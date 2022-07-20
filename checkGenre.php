<?php
    session_start();

    require_once "db.php";

    function redirect() {
        header("Location: genre.php");
        exit;
    }

    $wallMaterialName = htmlspecialchars(trim($_POST["genreName"]));

    if($_POST["isEditForm"] == '1') {
        if($mysql->connect_error) {
            echo "Error Number: ". $mysqsl->connect_errno."<br>";
            echo "Error: " . $mysql->connect_error;
        }
        else {
            $genreId = htmlspecialchars(trim($_POST["genreID"]));
            $mysql->query("UPDATE `genre` SET `title` = '$genreName' WHERE `id` = '$genreId';");
            redirect();
        }
    }
    else if($_POST["isCreateForm"] == '1') {
        if($mysql->connect_error) {
            echo "Error Number: ". $mysqsl->connect_errno."<br>";
            echo "Error: " . $mysql->connect_error;
        }
        else {
            $mysql->query("INSERT INTO `genre` (`title`) VALUES ('" . $_POST["genreName"] . "');");
            redirect();
        }
    }

