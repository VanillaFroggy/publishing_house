<?php
    session_start();

    require_once "db.php";

    function redirect() {
        header("Location: cart.php");
        exit;
    }

    if($_POST["isEditForm"] == '1') {
        if($mysql->connect_error) {
            echo "Error Number: ". $mysqsl->connect_errno."<br>";
            echo "Error: " . $mysql->connect_error;
        }
        else {
            $bookId = htmlspecialchars(trim($_POST["bookID"]));
            $mysql->query("UPDATE `cart` SET `count` = '" . $_POST["bookCount"] . "', `status` = '" . $_POST["bookStatus"] . "' WHERE `book_id` = '$bookId' AND `user_id` = '" . $_SESSION['userId'] . "';");
            redirect();
        }
    }
    else {
        redirect();
    }