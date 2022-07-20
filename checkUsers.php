<?php
    session_start();

    require_once "db.php";

    function redirect() {
        header("Location: users.php");
        exit;
    }

    $_SESSION["userTextError"] = "";
    $_SESSION["userPhoneError"] = "";
    if(strlen(trim($_POST["userName"])) <= 1 || strlen(trim($_POST["userPass"])) <= 1 || strlen(trim($_POST["userMail"])) <= 1) {
        $_SESSION["userTextError"] = "Текстовые поля должны содержать больше одного символа";
        redirect();
    }
    else if(strval(strlen(trim($_POST["userPhone"]))) < 11) {
        $_SESSION["userPhoneError"] = "Телефон должен содержать 11 цифр";
        redirect();
    }
    else {
        $_SESSION["userTextError"] = "";
        $_SESSION["userPhoneError"] = "";    

        $userName = htmlspecialchars(trim($_POST["userName"]));
        $userPassword = htmlspecialchars(trim($_POST["userPass"]));
        $userEmail = htmlspecialchars(trim($_POST["userMail"]));
        $userPhone = htmlspecialchars(trim($_POST["userPhone"]));

        if($_POST["isEditForm"] == '1') {
            if($mysql->connect_error) {
                echo "Error Number: ". $mysqsl->connect_errno."<br>";
                echo "Error: " . $mysql->connect_error;
            }
            else {
                $userId = htmlspecialchars(trim($_POST["userID"]));
                $mysql->query("UPDATE `user` SET `username` = '$userName', `password` = '$userPassword', `email` = '$userEmail', `phonenumber` = '$userPhone' WHERE `id` = '$userId';");
                redirect();
            }
        }
        else if($_POST["isCreateForm"] == '1') {
            if($mysql->connect_error) {
                echo "Error Number: ". $mysqsl->connect_errno."<br>";
                echo "Error: " . $mysql->connect_error;
            }
            else {
                $mysql->query("INSERT INTO `user` (`role_id`, `username`, `password`, `email`, `phonenumber`) VALUES ('2', '$userName', '$userPassword', '$userEmail', '$userPhone');");
                redirect();
            }
        }
    }
