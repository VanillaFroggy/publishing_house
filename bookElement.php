<?php
    session_start();

    $pageTitle = "Страница книги";

    require_once "db.php";
    if(isset($_POST["bookID"])) {
        $_SESSION["bookID"] = $_POST["bookID"];
    }

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
    <h1 class="text-center">Страница книги</h1>

        <div class="container bookElement">

<?php
    $sql = "SELECT book.id, book.title AS title,
    book.author, book.cover, book.price, book.status, genre.title AS genre
    FROM `book` INNER JOIN `genre`
    ON book.genre_id = genre.id
    WHERE book.status = 'продаётся' AND book.id = " . $_SESSION["bookID"] . ";";
    $result = $mysql->query($sql);
    $row = $result->fetch_array();
    $_SESSION['bookTitle'] = $row['title'];
    echo "<input type='number' name='bookID' style='display: none;' value=" . $row['id'] . ">";
    echo "<span><b>Название книги:</b> " . $row['title']."<br>";
    $_SESSION['bookAuthor'] = $row['author'];
    echo "<span><b>Автор:</b> " . $row['author']."<br>";
    $_SESSION['bookPrice'] = $row['price'];
    echo "<span><b>Цена:</b> " . $row['price']." р.<br>";
    $_SESSION['bookGenre'] = $row['genre'];
    echo "<span><b>Жанр:</b> " . $row['genre']."<br>";
    $id = $row['id'];
    echo "<span><b>Обложка:</b> ". "<img src='imageView.php?id=$id&column=cover' class='img-fluid' style='width: 200px; height: 300px'>" ."<br>";

    // echo "<form action='checkRealEstate.php'>";


    if ($_SESSION["userRole"] == 1) {
        $_SESSION['bookStatus'] = $row['status'];
        echo "<span><b>Статус:</b> " . $row['status']."<br>";
        echo "<button type='button' class='btn btn-success' style='width: 30%; margin-top: 7px; margin-bottom: 7px;' onclick='openEditForm();'>Редактировать</button>";
        echo "<form action='checkBook.php' method='post' style='display: inline;'><button type='submit' name='isDeleteBook' value='1' class='btn btn-danger' style='width: 30%; margin-left: 31%'>Удалить</button></form>";
    }
    else {
        $userCartSelectResult = $mysql->query("SELECT * FROM `cart` WHERE user_id = '" . $_SESSION["userId"] . "' AND book_id = '" . $_SESSION["bookID"] . "' AND status = 'ожидает';");
        if ($userCartSelectResult->num_rows == 0)
            echo "<form action='checkBook.php' method='post'><button type='submit' name='isInsertToCart' value='1' class='btn btn-success' style='width: 30%; margin-top: 7px; margin-bottom: 7px;' >Добавить в корзину</button></form>";
    }
    // echo "</form>"

?>
    <form action="checkBook.php" id="editForm" style="display: none;" method="post">
    
    <label for="bookTitle" class="label">Название книги:</label>
    <input type="text" name="bookTitle" value="<?=$_SESSION['bookTitle']?>" class="form-control">

    <label for="bookAuthor" class="label">Автор:</label>
    <input type="text" name="bookAuthor" value="<?=$_SESSION['bookAuthor']?>" class="form-control">

    <label for="bookPrice" class="label">Автор:</label>
    <input type="number" name="bookPrice" value="<?=$_SESSION['bookPrice']?>" class="form-control">
    
    <label for="bookGenre" class="label">Жанр:</label>
    <select name="bookGenre" value="<?=$_SESSION['bookGenre']?>" class="form-control" required>
        <option selected>-</option>
        <?php printSelectResultsForComboBox('genre_id');?>
    </select>

    <label for="bookStatus" class="label">Статус:</label>
    <select name="bookStatus" value="<?=$_SESSION['bookStatus']?>" class="form-control" required>
        <?php printSelectResultsForComboBox('status');?>
    </select>

    <div class="text-danger"><?=$_SESSION['errorNumber']?></div><br>


    <button type="submit" class="btn btn-success" style="width: 30%; position:absolute; left: 15%;">Сохранить</button>
    <button type="button" class="btn btn-danger" style="width: 30%; position:absolute; right: 13%;" onclick="closeEditForm();">Закрыть</button>
</form>

<?php
    if (count($_FILES) > 0) {
        if (is_uploaded_file($_FILES['bookCover']['tmp_name'])) {
            
            $imgData = addslashes(file_get_contents($_FILES['bookCover']['tmp_name']));
            
            $sql = "UPDATE `book` SET `cover` = '$imgData' WHERE `id` = " . $_SESSION["bookID"] . ";";
            $result = $mysql->query($sql) or die("<b>Error:</b> Problem on Image Insert<br/>" . $mysql->error);
        }
    }
?>

<form action="" enctype="multipart/form-data" id="uploadImageForm" style="display: none; margin-top: 5em;" method="post">
    
    <label for="bookCover" class="label">Обложка:</label> <!-- фото --> 
    <input type="file" name="bookCover" class="form-control">

    <button type="submit" class="btn btn-success" style="width: 30%; position:absolute; margin-top: 20px; left: 35%;">Загрузить фотографию</button>
</form>
            </div>
        </div>
<?php
    include_once "footer.php";
?>
    </div>

</div>