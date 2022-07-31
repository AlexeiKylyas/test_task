<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Авторизация пользователя. Тестовое задание</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <style type="text/css">
        .line{
            min-width: 500px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Личный кабинет</h1>
    <p>Спасибо что вошли, <?= $email ?></p>
</div>
<div class="container"  style="display:flex">
    <div class="container director-button" style="text-align: center">
        <button class="btn btn-primary" style="margin-bottom: 10px" <?php if($job == 'manager' || $job == 'executor'){ echo 'disabled';} ?> name="name" onclick="addPost(this)" value="1">director button</button>
        <div class="container" id="director-container"></div>
        <div class="container save-button"><button type="button" class="btn btn-success" onclick="savePosts()">Save posts</button></div>
    </div>
    <div class="container manager-button" style="text-align: center">
        <button class="btn btn-primary" style="margin-bottom: 10px" <?php if($job == 'executor'){ echo 'disabled';} ?> onclick="addPost(this)" name="name" value="2">manager button</button>
        <div class="container" id="manager-container"></div>
    </div>
    <div class="container executor-button" style="text-align: center">
        <button class="btn btn-primary" style="margin-bottom: 10px"  name="name" onclick="addPost(this)" value="3">executor button</button>
        <div class="container" id="executor-container"></div>
    </div>
</div>
<?php
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo $error . '<br/>';
    }
}
?>
<a href="/?action=logout">Выход</a>
</body>
</html>
<script>
    $(document).ready(function() {
        window.amountOfPosts = 0;
        window.posts = [];
    });
    function addPost(btn) {
        amountOfPosts +=1;
        $.ajax({
            method: "GET",
            url: "https://jsonplaceholder.typicode.com/posts/"+amountOfPosts,
            success: function(data) {
                data.buttonNumber = btn.value;
                var newPost = document.createElement("div");
                newPost.className = "alert alert-success";
                newPost.innerHTML = "<h3>" + data.title + "</h3><p>" + data.body + "</p>";
                if(btn.value == 1){
                    var directorContainer = document.getElementById("director-container");
                    directorContainer.append(newPost);
                }
                if(btn.value == 2){
                    var managerContainer = document.getElementById("manager-container");
                    managerContainer.append(newPost);
                }
                if(btn.value == 3){
                    var executorContainer = document.getElementById("executor-container");
                    executorContainer.append(newPost);
                }
                posts.push(data);
            },
            error: function(er) {
                console.log(er);
            }
        });
    }
    function savePosts(){
        console.log(posts);
        $.ajax({
            method: "POST",
            url: "/models/Post.php",
            data: ({posts : posts}),
            dataType: 'json',
            success: function(data) {
                console.log('done!')
            },
            error: function(er) {
                console.log(er);
            }
        });
    }
</script>
