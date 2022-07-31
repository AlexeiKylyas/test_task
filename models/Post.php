<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/core/Database.php');
if(isset($_POST['posts'])){
    Post::save();
}
class Post
{
    public $button;
    public $title;
    public $body;
    public $author;

    public function save(){
        foreach ($_POST['posts'] as $post){
            $onePost = new Post();
            $onePost->title = $post['title'];
            $onePost->body = $post['body'];
            switch ($post['buttonNumber']){
                case 1:
                    $onePost -> button = 'directorButton';
                    break;
                case 2:
                    $onePost -> button = 'managerButton';
                    break;
                case 3:
                    $onePost -> button = 'executorButton';
                    break;
            }
            $onePost -> author = $_COOKIE['user'];
            $db = Database::getInstance();
            $sth = $db->pdo->prepare("INSERT INTO `posts` SET `title` = :title, `body` = :body, `author` = :username, `button` = :button");
            $sth->execute([
                'title' => $onePost->title,
                'body' => $onePost->body,
                'username' => $onePost->author,
                'button' => $onePost->button
            ]);
        }
        return true;
    }
}