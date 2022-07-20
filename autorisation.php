<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
    <script src="js/main.js"></script>
    <title>Авторизация</title>
</head>
<body>
<div class="container mt-5">
<div class="description container mt-2">
    <h1 class='text-center'>Авторизация</h1>
    <form action="check_autorisation.php" method="post">
        <label for="username" class="label">Логин:</label>
        <input type="text" name="username" placeholder="Введите свой логин" class="form-control">
        <label for="password" class="label">Пароль:</label>
        <input type="password" name="password" placeholder="Введите свой пароль" class="form-control">
        <div class="text-danger"><?=$_SESSION['errorAutorisation']?></div><br>
        <button type="submit" class="btn btn-success btn-autorise">Отправить</button>
    </form>
    <div class="container mt-4" style="text-align: center;">
        <a href="registration.php" class="link-primary h5">Зарегистрироваться</a>
    </div>
</div>
</body>
</html>