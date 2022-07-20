<?php
    session_start();

    require_once "db.php";

    $_SESSION['errorNumber'] = "";

    if($_POST['bookPrice'] < 0) {
        $_SESSION['errorNumber'] = "Вводите положительные числа";
        header("Location: createBook.php");
        exit;
    }
    else {
        $genreResult = $mysql->query("SELECT id FROM `genre` WHERE `title` = '" . $_POST['bookGenre'] . "';");
        $row = $genreResult->fetch_assoc();

        $mysql->query("INSERT INTO `book` (`title`, `author`, `price`, `genre_id`, `status`)
            VALUES ('" . $_POST['bookTitle'] . "', '" . $_POST['bookAuthor'] . "', '" . $_POST['bookPrice'] . "', '" . $row['id'] . "', 'продаётся');");
        
        $_SESSION['errorNumber'] = "";

        header("Location: book.php");
        exit;
    }