<?php
    session_start();

    $pageTitle = "Каталог";

    require_once "db.php";

    if($_SESSION["userRole"] == '1')
        require_once "admin_header.php";
    else
        require_once "user_header.php";

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

    <h1 class="text-center">Список книг</h1>
        <div class="container" style="margin-left: 10%;">
        <?php
            if($_SESSION["userRole"] == 1)
                echo "<a href='createBook.php' class='btn btn-success' style='width: 30%; margin-bottom: 20px; margin-left: 25%'>Добавить книгу</a>";
        ?>
            <a href="#editForm" class='btn btn-success' id='btnOpenCreateForm' onclick='openEditForm();' style='width: 30%; margin-bottom: 20px;' href>Отфильтровать</a>
            <div class="row">
        
<?php
function printSelectResults($result) {
    if($result->num_rows > 0) {           
        while($row = $result->fetch_array()) {
            echo "<div class='col-lg-3 col-md-4 col-sm-12 element m-2'><form action='bookElement.php' method='post'>";
            echo "<b><h4>".$row['title']."</h4></b>";
            echo "<input type='number' name='bookID' style='display: none;' value=" . $row['id'] . ">";
            $id = $row['id'];
            echo "<img src='imageView.php?id=$id&column=cover' class='img-fluid' style='width: 200px; height: 300px'>" ."<br>";
            echo "<p>".$row['price']." р.</p>";
            echo "<button type='submit' class='btn btn-success' style='margin-top: 7px; margin-bottom: 7px;' >Перейти</button>";
            echo "</form></div>";
        }
    }
}
            if($mysql->connect_error) {
                echo "Error Number: ". $mysqsl->connect_errno."<br>";
                echo "Error: " . $mysql->connect_error;
            }
            else {
                if (!isset($_POST["isFiltred"])) {
                    $result = $mysql->query("SELECT book.id, book.title AS title,
                    book.author, book.cover, genre.title AS genre, book.price
                    FROM `book` INNER JOIN `genre`
                    ON book.genre_id = genre.id
                    WHERE book.status = 'продаётся'
                    ORDER BY book.id;");
                }
                else {
                    $filtrResult = "SELECT book.id, book.title AS title,
                        book.author, book.cover, genre.title AS genre, book.price
                        FROM `book` INNER JOIN `genre`
                        ON book.genre_id = genre.id
                        WHERE ";
    
                    if(isset($_POST['bookGenre']) && $_POST['bookGenre'] != '-') {
                        $filtrResult = $filtrResult . "genre.title = '" . $_POST['bookGenre'] . "' And ";
                    }
                    if(isset($_POST['bookAuthor']) && $_POST['bookAuthor'] != '-') {
                        $filtrResult = $filtrResult . "book.author = '" . $_POST['bookAuthor'] . "' And ";
                    }

                    $filtrResult = $filtrResult . "book.status = 'продаётся' ORDER BY book.id;"; // " .  $_POST['sortValue'] . "
                    $result = $mysql->query($filtrResult);
                }
            printSelectResults($result);
            $sortResult = $mysql->query("SHOW COLUMNS FROM `book`;");
            }
?>
            </div>
    <form action="" id="editForm" style="display: none; margin-right: 20%;" method="post">
    
    <label for="bookAuthor" class="label">Автор книги:</label>
    <select name="bookAuthor" class="form-control">
        <option selected>-</option>
        <?php printSelectResultsForComboBox('author');?>
    </select>
    
    <label for="bookGenre" class="label">Жанр книги:</label>
    <select name="bookGenre" class="form-control">
        <option selected>-</option>
        <?php printSelectResultsForComboBox('genre_id');?>
    </select><br>

    <!-- <label for="sortValue" class="label">Сортировка по:</label>
    <select name="sortValue" value="<?=$_SESSION['sortValue']?>" class="form-control">
        <?php 
            if($sortResult->num_rows > 0) {           
                while($row = $sortResult->fetch_assoc()) {
                    echo "<option>" . $row['Field'] . "</option><br>";
                }
            }
        ?>
    </select><br> -->

    <div class="text-danger"><?=$_SESSION['errorNumber']?></div><br>


    <button type="submit" name="isFiltred" value="1" class="btn btn-success" style="width: 30%; position:absolute; left: 20%;">Применить</button>
    <button type="button" class="btn btn-danger" style="width: 30%; position:absolute; right: 13%;" onclick="closeEditForm();">Закрыть</button>
</form>
        </div>
    </div>
<?php
    include_once "footer.php";
?>
</div>
