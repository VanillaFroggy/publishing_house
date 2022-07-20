<?php
    session_start();

    require_once "db.php";

    $_SESSION["errorAutorisation"] = "";

    function redirectUser() {
        header("Location: book.php");
        exit();
    }
    function redirectAdmin() {
        header("Location: book.php");
        exit();
    }
    function redirectBack() {
        header("Location: autorisation.php");
        exit();
    }
    function checkSelectResults($result) {  
        while($row = $result->fetch_assoc()) {   
            $_SESSION['userId'] = $row['id'];
            $_SESSION['userRole'] = $row['role_id'];
            $_SESSION['userEmail'] = $row['email'];
            $_SESSION['userPhone'] = $row['phonenumber'];
        }
    }

    $login = htmlspecialchars(trim($_POST["username"]));
    $password = htmlspecialchars(trim($_POST["password"]));
    
    $_SESSION["userLogin"] = $login;
    $_SESSION["userPassword"] = $password;

    if($mysql->connect_error) {
        echo "Error Number: ". $mysqsl->connect_errno."<br>";
        echo "Error: " . $mysql->connect_error;
    }
    else {
        $userResult = $mysql->query("SELECT * FROM `user` WHERE `username` = '$login' AND `password` = '$password' AND `role_id` = 2;");
        $adminResult = $mysql->query("SELECT * FROM `user` WHERE `username` = '$login' AND `password` = '$password' AND `role_id` = 1;");
        if($userResult->num_rows > 0) {           
            checkSelectResults($userResult);
            redirectUser();
        }
        else if($adminResult->num_rows > 0) {
            checkSelectResults($adminResult);
            redirectAdmin();
        }
        else {
            $_SESSION["errorAutorisation"] = "Неверный логин или пароль";
            redirectBack();
        }
    }