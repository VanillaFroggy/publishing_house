<?php
    session_start();

    require_once "db.php";

    $pageTitle = "Жанры книг";

    require_once "admin_header.php";

    // print_r($_POST);

    if(isset($_POST["isEditForm"]) && isset($_POST["isDeleteGenre"])) {
        $editFormStatus = "display: none;";
    }
    else if(isset($_POST["isEditForm"]) && $_POST["isEditForm"] == '1') {
        $editFormStatus = "display: block;";
    }
    else {
        $editFormStatus = "display: none;";
    }

    if(isset($_POST["isDeleteGenre"]) && $_POST["isDeleteGenre"] == '1') {
        if($mysql->connect_error) {
            echo "Error Number: ". $mysqsl->connect_errno."<br>";
            echo "Error: " . $mysql->connect_error;
        }
        else {
            $genreId = htmlspecialchars(trim($_POST["genreID"]));
            $mysql->query("DELETE FROM `genre` WHERE `id` = '$genreId';");
        }
    }

    if(isset($_POST["genreID"])) {
        $genreResult = $mysql->query("SELECT `title` FROM `genre` WHERE id = '" . $_POST["genreID"] . "';");
        $genreId = $_POST["genreID"];
        $genreName = printSelectRow($genreResult, 'title');
    }

    $gridResult = $mysql->query("SELECT * FROM `genre`;");

    function printSelectResults($result) {
        if($result->num_rows > 0) {           
            while($row = $result->fetch_assoc()) {
                echo "<div class='col-lg-5 col-md-4 col-sm-12 element m-1' style=''><form action='' method='post'>";
                echo "<input type='number' name='isEditForm' value='1' style='display: none;' value=" . "display: none" . ">";
                echo "<input type='number' name='genreID' style='display: none;' value=" . $row['id'] . ">";
                echo "id жанра: " . $row['id']."<br>";
                echo "Название жанра: " . $row['title']."<br>";
                echo "<button type='submit' class='btn btn-success' style='margin-top: 7px; margin-bottom: 7px;' >Редактировать</button>";
                echo "<button type='submit' name='isDeleteGenre' value='1' class='btn btn-danger' style='margin-left: 31%'>Удалить</button>";
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
<h1 class='text-center gridH'>Список жанров</h1>
<button type='button' class='btn btn-success btnOpenCreateForm' id='btnOpenCreateForm' onclick='openCreateForm();' style="margin-left: 35%;">Внести жанр</button>

<form action="checkGenre.php" id="editForm" style="<?=$editFormStatus?>" method="post">
    <label for="genreName" class="label">Название жанра:</label>
    <input type='number' name='isEditForm' value='1' style='display: none;' value="display: none">
    <input type='number' name='genreID' value='<?=$genreId?>' style='display: none;' value="display: none">
    <input type="text" name="genreName" value="<?=$genreName?>" class="form-control"><br>   
    <button type="submit" class="btn btn-success">Сохранить</button>
    <button type="button" class="btn btn-danger" style="position:absolute; right: 2.9%;" onclick="closeEditForm();">Закрыть</button>
</form>

<div class='container  mt-2' id="grid">
    <div class='container'>
        <div class='row ml-5'>
            <?=printSelectResults($gridResult);?>
        </div>
    </div>
</div>

<form action="checkGenre.php" id="createForm" method="post">
    <input type='number' name='isCreateForm' value='1' style='display: none;'>
    <input type='number' name='isEditForm' value='0' style='display: none;' value="display: none">
    <label for="genreName" class="label">Название жанра:</label>
    <input type="text" name="genreName" class="form-control"><br>     
    <button type="submit" class="btn btn-success">Создать</button>
    <button type="button" class="btn btn-danger" style="position:absolute; right: 2.9%;" onclick="closeCreateForm();">Закрыть</button>
</form>



<?php
    include_once "footer.php";
?>
</div>
