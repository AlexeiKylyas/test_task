<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Авторизация пользователя. Тестовое задание</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Авторизация</h1>
        <p>Введите логин и пароль:</p>
        <form method="post" action="/?action=login">
            <label>
                Login:
                <input type="text" class="form-control" name="login" value="<?=$login?>"/>
            </label><br/>
            <label>
                Password:
                <input type="password" class="form-control" name="password" value="<?=$password?>"/>
            </label><br/>
            <input type="submit" class="btn btn-success" style="margin-top:10px" name="submit"/><br/>
        </form>
        <?php
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo $error . '<br/>';
                }
            }
        ?>
        <a href="/?action=registration">Регистрация</a>
    </div>
</body>
</html>
