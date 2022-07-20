<?php
    session_start();

    require_once "db.php";

    function addColumnToQuery($result, $column, $value) {
        $result += "`$column` = $value";
    }

    $_SESSION['errorNumber'] = "";

    if(isset($_POST['isDeleteBook'])) {
        $mysql->query("DELETE FROM `cart` WHERE book_id = '" . $_SESSION["bookID"] . "';");
        $mysql->query("DELETE FROM `book` WHERE book.id = '" . $_SESSION["bookID"] . "';");
        header("Location: book.php");
        exit;
    }
    else if(isset($_POST['isInsertToCart'])) {
        $mysql->query("INSERT INTO `cart` (`user_id`, `book_id`, `count`, `status`) VALUES ('" . $_SESSION["userId"] . "', '" . $_SESSION["bookID"] . "', '1', 'ожидает');");
        header("Location: bookElement.php");
        exit;
    }
    else {
        if($_POST['bookPrice'] < 0) {
            $_SESSION['errorNumber'] = "Вводите положительные числа";
            header("Location: bookElement.php");
            exit;
        }
        else {
            if(isset($_POST['bookTitle'])) {
                $mysql->query("UPDATE `book` SET `title` = '" . $_POST['bookTitle'] . "'WHERE book.id = '" . $_SESSION['bookID'] . "';");
            }
            if(isset($_POST['bookAuthor'])) {
                $mysql->query("UPDATE `book` SET `author` = '" . $_POST['bookAuthor'] . "'WHERE book.id = '" . $_SESSION['bookID'] . "';");
            }
            if(isset($_POST['bookPrice'])){
                $mysql->query("UPDATE `book` SET `price` = '" . $_POST['bookPrice'] . "'WHERE book.id = '" . $_SESSION['bookID'] . "';");
            }
            if(isset($_POST['bookGenre'])){
                $genreResult = $mysql->query("SELECT id FROM `genre` WHERE title = '" . $_POST['bookGenre'] . "'");
                $row = $genreResult->fetch_assoc();
                $mysql->query("UPDATE `book` SET `genre_id` = '" . $row['id'] . "'WHERE book.id = '" . $_SESSION['bookID'] . "';");
            }
            if(isset($_POST['bookStatus'])){
                $mysql->query("UPDATE `book` SET `status` = '" . $_POST['bookStatus'] . "'WHERE book.id = '" . $_SESSION['bookID'] . "';");
            }
            
            $_SESSION['errorNumber'] = "";

            header("Location: bookElement.php");
            print_r($_POST);
            exit;
        }
    }