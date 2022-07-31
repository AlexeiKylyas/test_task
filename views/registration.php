<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Авторизация пользователя. Тестовое задание</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Регистрация</h1>
        <p>Введите данные:</p>
        <form method="post" action="/?action=registration">
            <label class="form-label">
                E-mail:
                <input type="text" class="form-control" name="email" value="<?=$email?>"/>
            </label><br/>
            <label class="form-label">
                Password:
                <input type="password" class="form-control" name="password" value="<?=$password?>"/>
            </label><br/>
            <label class="form-label">
                job title :
                <select class="form-select" name="job_title" required>
                    <option value="director">Директор</option>
                    <option value="manager">Менеджер</option>
                    <option value="executor">Исполнитель</option>
                </select>
            </label><br/>
            <input class="btn btn-success" type="submit" name="submit"/><br/>
        </form>
        <?php
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo $error . '<br/>';
                }
            }
        ?>
    </div>
</body>
</html>
