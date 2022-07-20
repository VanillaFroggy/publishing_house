<?php
    session_start();

    require_once "db.php";

    $_SESSION["errorRegistration"] = "";

    function redirectUser() {
        header("Location: book.php");
        exit();
    }
    function redirectBack() {
        header("Location: registration.php");
        exit();
    }

    $login = htmlspecialchars(trim($_POST["username"]));
    $password = htmlspecialchars(trim($_POST["password"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $phone = htmlspecialchars(trim($_POST["phonenumber"]));
    
    $_SESSION["userLogin"] = $login;
    $_SESSION["userPassword"] = $password;
    $_SESSION["userEmail"] = $email;
    $_SESSION["userPhonenumber"] = $phone;


    if($mysql->connect_error) {
        echo "Error Number: ". $mysqsl->connect_errno."<br>";
        echo "Error: " . $mysql->connect_error;
    }
    else {
        $loginResult = $mysql->query("SELECT * FROM `user` WHERE `username` = '$login' AND `role_id` = 2;");
        $emailResult = $mysql->query("SELECT * FROM `user` WHERE `email` = '$email' AND `role_id` = 2;");
        $phoneResult = $mysql->query("SELECT * FROM `user` WHERE `phonenumber` = '$phone' AND `role_id` = 2;");
        if($loginResult->num_rows > 0) {  
            $_SESSION["errorRegistration"] = "Этот логин уже зарегистрирован";         
            redirectBack();
        }
        else if($emailResult->num_rows > 0) {
            $_SESSION["errorRegistration"] = "Этот Email уже зарегистрирован";
            redirectBack();
        }
        else if($phoneResult->num_rows > 0) {
            $_SESSION["errorRegistration"] = "Этот номер телефона уже зарегистрирован";
            redirectBack();
        }
        else {
            $_SESSION["errorRegistration"] = "";
            $mysql->query("INSERT INTO `user` (`role_id`, `username`, `password`, `email`, `phonenumber`) VALUES ('2', '$login', '$password', '$email', '$phone')");
            $loginResult = $mysql->query("SELECT id FROM `user` WHERE `username` = '$login' AND `role_id` = 2;");
            $loginRow = $loginResult->fetch_assoc();
            $_SESSION["userId"] = $loginRow["id"];
            $_SESSION["userRole"] = 2;
            redirectUser();
        }
    }