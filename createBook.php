<?php
    session_start();

    $pageTitle = "Добавление книги";

    require_once "db.php";
    require_once "admin_header.php";

    function printSelectResultsForComboBox($column) {
        $host = "localhost";
        $hostLogin = "root";
        $hostPassword = "1234";
        $dbName = "publishing_house";
    
        $mysql = new mysqli($host, $hostLogin, $hostPassword, $dbName);
        if($column == "genre_id") {
            $result = $mysql->query("SELECT title FROM `genre`;");
            $column = 'title';
        }
        else {
            $result = $mysql->query("SELECT DISTINCT $column FROM `book`;");
        }
        if($result->num_rows > 0) {           
            while($row = $result->fetch_assoc()) {
                echo "<option>" . $row[$column] . "</option><br>";
            }
        }
        $mysql->close();
    }     
?>

<div class="description container mt-2">
    <div class="portfolio">
    <h1 class="text-center">Создание книги</h1>

        <div class="container bookElement">
<form action="checkCreateBook.php" id="editForm" style="display: block;" method="post">
    
    <label for="bookTitle" class="label">Название книги:</label>
    <input type="text" name="bookTitle" class="form-control">

    <label for="bookAuthor" class="label">Автор книги:</label>
    <input type="text" name="bookAuthor" class="form-control">
    
    <label for="bookPrice" class="label">Цена</label>
    <input type="number" name="bookPrice"  class="form-control">

    <label for="bookGenre" class="label">Жанр книги:</label>
    <select name="bookGenre" class="form-control">
        <?php printSelectResultsForComboBox('genre_id');?>
    </select><br>

    <!-- <label for="realEstateStatus" class="label">Статус:</label>
    <select name="realEstateStatus" value="<?=$_SESSION['realEstateStatus']?>" placeholder="Введите логин" class="form-control">
        <?php printSelectResultsForComboBox('status');?>
    </select><br> -->

    <div class="text-danger"><?=$_SESSION['errorNumber']?></div><br>


    <button type="submit" class="btn btn-success" style="width: 30%; position:absolute; left: 35%;">Сохранить</button>
    <!-- <button type="button" class="btn btn-danger" style="width: 30%; position:absolute; right: 13%;" onclick="closeEditForm();">Закрыть</button> -->
</form>

        </div>
    </div>
<?php
    include_once "footer.php";
?>
</div>