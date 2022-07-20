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
    <title>Регистрация</title>
</head>
<body>
<div class="container mt-5">
<div class="description container mt-2">
    <h1 class='text-center'>Регистрация</h1>
    <form action="check_registration.php" method="post">
        <label for="username" class="label">Логин:</label>
        <input type="text" name="username" placeholder="Введите свой логин" class="form-control" required>
        <label for="password" class="label">Пароль:</label>
        <input type="password" name="password" placeholder="Введите свой пароль" class="form-control" required>
        <label for="email" class="label">Email:</label>
        <input type="email" name="email" placeholder="Введите свою электронную почту" class="form-control" required>
        <label for="phonenumber" class="label">Номер телефона:</label>
        <input type="number" name="phonenumber" placeholder="Введите свой номер телефона" class="form-control" required>
        <div class="text-danger"><?=$_SESSION['errorRegistration']?></div><br>
        <button type="submit" class="btn btn-success btn-autorise">Зарегистрироваться</button>
    </form>
</div>
</body>
</html>