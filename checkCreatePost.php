<?php
    session_start();

    require_once "db.php";

    if($_POST['bookTitle'] == '-') {
        $mysql->query("INSERT INTO `post` (`title`, `anons`, `date`, `full_text`)
            VALUES ('" . $_POST['postTitle'] . "', '" . $_POST['postAnons'] . "', '" . $_POST['postDate'] . "', '" . $_POST['postFullText'] . "');");

        header("Location: post.php");
        exit;
    }
    else {
        $bookResult = $mysql->query("SELECT id FROM `book` WHERE `title` = '" . $_POST['bookTitle'] . "';");
        $row = $bookResult->fetch_assoc();

        $mysql->query("INSERT INTO `post` (`title`, `anons`, `date`, `full_text`, `book_id`)
            VALUES ('" . $_POST['postTitle'] . "', '" . $_POST['postAnons'] . "', '" . $_POST['postDate'] . "', '" . $_POST['postFullText'] . "', '" . $row['id'] . "');");
        

        header("Location: post.php");
        exit;
    }