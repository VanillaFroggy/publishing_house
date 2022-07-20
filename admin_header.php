<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
    <script src="js/main.js"></script>
    <title><?=$pageTitle?></title>
</head>
<body>
<div class="container mt-5">
    <header class="navbar">
        <a href="book.php" class="navLink nav-link">Главная<a>|
        <a href="post.php" class="navLink nav-link">Новости<a>|
        <a href="about.php" class="navLink nav-link">Про нас<a>|
        <a href="author.php" class="navLink nav-link">Авторам<a>|
        <div class="dropdown">
        <a href="#" class="dropbtn navLink nav-link" onclick="dropContent()">Администрирование</a>
            <div class="dropdown-content" id="myDropdown">
                <a href="users.php" class="droplink nav-link">Пользователи<a>
                <!-- <a href="cart.php" class="navLink nav-link">Корзина<a> -->
                <a href="genre.php" class="droplink nav-link">Жанры<a>
            </div>
        </div>
    </header>

    
