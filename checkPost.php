<?php
    session_start();

    require_once "db.php";

    function addColumnToQuery($result, $column, $value) {
        $result += "`$column` = $value";
    }

    if(isset($_POST['isDeletePost'])) {
        $mysql->query("DELETE FROM `post` WHERE post.id = '" . $_SESSION["postID"] . "';");
        header("Location: post.php");
        exit;
    }
    else {
        if(isset($_POST['postTitle'])) {
            $mysql->query("UPDATE `post` SET `title` = '" . $_POST['postTitle'] . "'WHERE post.id = '" . $_SESSION['postID'] . "';");
        }
        if(isset($_POST['postAnons'])) {
            $mysql->query("UPDATE `post` SET `anons` = '" . $_POST['postAnons'] . "'WHERE post.id = '" . $_SESSION['postID'] . "';");
        }
        if(isset($_POST['postDate'])){
            $mysql->query("UPDATE `post` SET `date` = '" . $_POST['postDate'] . "'WHERE post.id = '" . $_SESSION['postID'] . "';");
        }
        if(isset($_POST['postFullText'])){
            $mysql->query("UPDATE `post` SET `full_text` = '" . $_POST['postFullText'] . "'WHERE post.id = '" . $_SESSION['postID'] . "';");
        }
        if(isset($_POST['bookTitle']) && $_POST['bookTitle'] != '-'){
            $bookResult = $mysql->query("SELECT id FROM `book` WHERE title = '" . $_POST['bookTitle'] . "'");
            $row = $bookResult->fetch_assoc();
            $mysql->query("UPDATE `post` SET `book_id` = '" . $row['id'] . "'WHERE post.id = '" . $_SESSION['postID'] . "';");
        }
        else if(isset($_POST['bookTitle']) && $_POST['bookTitle'] == '-') {
            $mysql->query("UPDATE `post` SET `book_id` = NULL WHERE post.id = '" . $_SESSION['postID'] . "';");
        }
        
        header("Location: postElement.php");
        print_r($_POST);
        exit;
    }