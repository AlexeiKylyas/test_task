<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/core/Database.php');

class User
{
    public $id;
    public $password;
    public $password_hash;
    public $email;
    public $jobTitle;
    public $errors = [];

    public function auth()
    {
        if (isset($_COOKIE['user']) && isset($_COOKIE['password_hash'])) {
            $login = $_COOKIE['user'];
            $user = self::getByLogin($login);
            if ($user && $user->password_hash == $_COOKIE['password_hash']) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    public static function getByLogin($login)
    {
        $db = Database::getInstance();
        $stmt = $db->pdo->prepare('SELECT * FROM `users` WHERE `email` = :login');
        $stmt->execute(['login' => $login]);
        $user_array = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user_array) {
            $user = new self();
            $user->id = $user_array['id'];
            $user->password_hash = $user_array['password'];
            $user->email = $user_array['email'];
            $user->jobTitle = $user_array['job'];

            return $user;
        } else {
            return false;
        }
    }

    public function login()
    {
        $user = self::getByLogin($this->email);
        if ($user && $user->password_hash == md5($this->password)) {
            setcookie('user', $user->email);
            setcookie('password_hash', $user->password_hash);
            return true;
        } else {
            $this->errors['login'] = 'Неправильный логин или пароль!';
            return false;
        }
    }

    public function logout()
    {
        setcookie("user", "", time() - 3600, "/");
        setcookie("password_hash", "", time() - 3600, "/");
        return true;
    }

    public function validate()
    {
        $no_errors = true;
        if (!isset($this->email) || $this->email == '') {
            $no_errors = false;
            $this->errors['login'] = 'Логин не может быть пустым!';
        }else{
            $pos = strripos($this->email, '@');
            if($pos == false){
                $no_errors = false;
                $this->errors['login'] = 'Email должен содержать @';
            }
            elseif ($pos <= 2){
                $no_errors = false;
                $this->errors['login'] = 'Минимум 3 символа до @';
            }else{
                $emailEnding = substr($this->email, $pos);
                if(strlen($emailEnding) != 4){
                    $no_errors = false;
                    $this->errors['login'] = 'Строго 3 символа после @';
                }
            }
        }
        if (!isset($this->password) || $this->password == '') {
            $no_errors = false;
            $this->errors['password'] = 'Пароль не может быть пустым!';
        }else{
            if (strlen($this->password) < 6 || strripos($this->password, '!') == false){
                $no_errors = false;
                $this->errors['password'] = 'Неверный формат пароля!';
            }
        }

        return $no_errors;
    }

    public function save()
    {
        if (isset($this->id)) {
            $db = Database::getInstance();
            $sth = $db->pdo->prepare("UPDATE `users` SET `password` = :password, `email` = :email, `job` = :jobTitle WHERE `id` = :id");
            $sth->execute([
                'id' => $this->id,
                'password' => md5($this->password),
                'email' => $this->email,
                'jobTitle' => $this->jobTitle,
            ]);
        } else {
            $db = Database::getInstance();
            $sth = $db->pdo->prepare("INSERT INTO `users` SET `password` = :password, `email` = :email, `job` = :jobTitle");
            $sth->execute([
                'password' => md5($this->password),
                'email' => $this->email,
                'jobTitle' => $this->jobTitle,
            ]);
        }

    }
}