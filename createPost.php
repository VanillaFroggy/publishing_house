<?php
    session_start();

    $pageTitle = "Создание новости";

    require_once "db.php";
    require_once "admin_header.php";

    function printSelectResultsForComboBox($column) {
        $host = "localhost";
        $hostLogin = "root";
        $hostPassword = "1234";
        $dbName = "publishing_house";
    
        $mysql = new mysqli($host, $hostLogin, $hostPassword, $dbName);
        $result = $mysql->query("SELECT DISTINCT $column FROM `book`;");
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
    <h1 class="text-center">Создание новости</h1>

        <div class="container bookElement">
<form action="checkCreatePost.php" id="editForm" style="display: block;" method="post">
    
    <label for="postTitle" class="label">Название новости:</label>
    <input type="text" name="postTitle" class="form-control" required>

    <label for="postAnons" class="label">Анонс новости:</label>
    <input type="text" name="postAnons" class="form-control" required>

    <label for="postDate" class="label">Дата новости:</label>
    <input type="datetime-local" name="postDate" class="form-control" required>

    <label for="postFullText" class="label">Текст новости:</label>
    <textarea name="postFullText" placeholder="Введите текст статьи" class="form-control" required></textarea><br>
    
    <label for="bookTitle" class="label">Название книги:</label>
    <select name="bookTitle" class="form-control" required>
        <option selected>-</option>
        <?php printSelectResultsForComboBox('title');?>
    </select><br>

    <!-- <label for="realEstateStatus" class="label">Статус:</label>
    <select name="realEstateStatus" value="<?=$_SESSION['realEstateStatus']?>" placeholder="Введите логин" class="form-control">
        <?php printSelectResultsForComboBox('status');?>
    </select><br> -->

    <!-- <div class="text-danger"><?=$_SESSION['errorText']?></div><br> -->


    <button type="submit" class="btn btn-success" style="width: 30%; position:absolute; left: 35%;">Сохранить</button>
    <!-- <button type="button" class="btn btn-danger" style="width: 30%; position:absolute; right: 13%;" onclick="closeEditForm();">Закрыть</button> -->
</form>

        </div>
    </div>
<?php
    include_once "footer.php";
?>
</div>