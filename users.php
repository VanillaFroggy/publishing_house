<?php
    session_start();

    require_once "db.php";

    $pageTitle = "Пользователи";

    require_once "admin_header.php";

    // print_r($_POST);

    if(isset($_POST["isEditForm"]) && isset($_POST["isDeleteUser"])) {
        $editFormStatus = "display: none;";
    }
    else if(isset($_POST["isEditForm"]) && $_POST["isEditForm"] == '1') {
        $editFormStatus = "display: block;";
    }
    else {
        $editFormStatus = "display: none;";
    }

    if(isset($_POST["isDeleteUser"]) && $_POST["isDeleteUser"] == '1') {
        if($mysql->connect_error) {
            echo "Error Number: ". $mysqsl->connect_errno."<br>";
            echo "Error: " . $mysql->connect_error;
        }
        else {
            $userId = htmlspecialchars(trim($_POST["userID"]));
            $mysql->query("DELETE FROM `user` WHERE `id` = '$userId';");
        }
    }

    if(isset($_POST["userID"])) {
        $userResult = $mysql->query("SELECT `username` FROM `user` WHERE id = '" . $_POST["userID"] . "';");
        $userId = $_POST["userID"];
        $userName = printSelectRow($userResult, 'username');
        $userResult = $mysql->query("SELECT `password` FROM `user` WHERE id = '" . $_POST["userID"] . "';");
        $userPassword = printSelectRow($userResult, 'password');
        $userResult = $mysql->query("SELECT `email` FROM `user` WHERE id = '" . $_POST["userID"] . "';");
        $userEmail = printSelectRow($userResult, 'email');
        $userResult = $mysql->query("SELECT `phonenumber` FROM `user` WHERE id = '" . $_POST["userID"] . "';");
        $userPhone = printSelectRow($userResult, 'phonenumber');
    }

    $gridResult = $mysql->query("SELECT `id`, `username`, `password`, `email`, `phonenumber` FROM `user` WHERE role_id = 2;");

    function printSelectResults($result) {
        if($result->num_rows > 0) {           
            while($row = $result->fetch_assoc()) {
                echo "<div class='col-lg-4 col-md-4 col-sm-12 element' style=''><form action='' method='post'>";
                echo "<input type='number' name='isEditForm' value='1' style='display: none;' value=" . "display: none" . ">";
                echo "<input type='number' name='userID' style='display: none;' value=" . $row['id'] . ">";
                echo "id: " . $row['id']."<br>";
                echo "Имя пользователя: " . $row['username']."<br>";
                echo "Пароль: " . $row['password']."<br>";
                echo "Email: " . $row['email']."<br>";
                echo "Номер телефона: " . $row['phonenumber']."<br>";
                echo "<button type='submit' class='btn btn-success' style='margin-top: 7px; margin-bottom: 7px;' >Редактировать</button>";
                echo "<button type='submit' name='isDeleteUser' value='1' class='btn btn-danger' style='margin-left: 31%'>Удалить</button>";
                echo "</form></div>";
            }
        }
    }
    function printSelectRow($result, $columnName) {
        $element = "";
        if($result->num_rows > 0) {           
            while($row = $result->fetch_assoc()) {   
                $element = $row[$columnName];
            }
        }
        return $element;
    }
?>

<div class="description container mt-2">
<h1 class='text-center gridH'>Список пользователей</h1>
<!-- <button type='button' class='btn btn-success btnOpenCreateForm' id='btnOpenCreateForm' onclick='openCreateForm();'>Зарегестрировать пользователя</button> -->

<form action="checkUsers.php" id="editForm" style="<?=$editFormStatus?>" method="post">
    <input type='number' name='isEditForm' value='1' style='display: none;' value="display: none">
    <input type='number' name='userID' value='<?=$userId?>' style='display: none;' value="display: none">
    <label for="userName" class="label">Имя пользователя:</label>
    <input type="text" name="userName" value="<?=$userName?>" class="form-control" required>
    <label for="userPass" class="label">Пароль:</label>
    <input type="password" name="userPass" value="<?=$userPassword?>" class="form-control" required>
    <label for="userMail" class="label">Email:</label>
    <input type="text" name="userMail" value="<?=$userEmail?>" class="form-control">
    <div class="text-danger"><?=$_SESSION['userTextError']?></div><br>
    <label for="userPhone" class="label">Номер телефона:</label>
    <input type="number" name="userPhone" value="<?=$userPhone?>" class="form-control" required>
    <div class="text-danger"><?=$_SESSION['userPhoneError']?></div><br> 
    <button type="submit" class="btn btn-success">Сохранить</button>
    <button type="button" class="btn btn-danger" style="position:absolute; right: 2.9%;" onclick="closeEditForm();">Закрыть</button>
</form>

<!-- id="grid" -->
<div class='container  mt-2' >
    <div class='container'>
        <div class='row'>
            <?=printSelectResults($gridResult);?>
        </div>
    </div>
</div>

<form action="checkClients.php" id="createForm" method="post">
    <input type='number' name='isCreateForm' value='1' style='display: none;'>
    <input type='number' name='isEditForm' value='0' style='display: none;' value="display: none">
    <label for="userName" class="label">Имя пользователя:</label>
    <input type="text" name="userName" class="form-control" required>
    <label for="userPassword" class="label">Пароль:</label>
    <input type="text" name="userPassword" class="form-control" required>
    <label for="userEmail" class="label">Email:</label>
    <input type="text" name="userEmail" class="form-control">
    <div class="text-danger"><?=$_SESSION['userTextError']?></div><br>
    <label for="userPhone" class="label">Номер телефона:</label>
    <input type="number" name="userPhone" class="form-control" required>
    <div class="text-danger"><?=$_SESSION['userPhoneError']?></div><br> 
    <button type="submit" class="btn btn-success">Создать</button>
    <button type="button" class="btn btn-danger" style="position:absolute; right: 2.9%;" onclick="closeCreateForm();">Закрыть</button>
</form>



<?php
    include_once "footer.php";
?>
</div>
