<?php
    session_start();

    $pageTitle = "Детали новости";

    require_once "db.php";
    if(isset($_POST["postID"])) {
        $_SESSION["postID"] = $_POST["postID"];
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
    <h1 class="text-center">Детали новости</h1>

        <div class="container bookElement">

<?php
    $seekBookResult = $mysql->query("SELECT book_id FROM `post` WHERE id ='" . $_SESSION['postID'] . "';");
    $row = $seekBookResult->fetch_assoc();
    $bookIdResult = $row['book_id'];
    if($bookIdResult != null) {
        $sql = "SELECT post.id, post.title AS title,
        post.anons, post.date, book.cover, 
        post.book_id, post.full_text
        FROM `post` INNER JOIN `book`
        ON post.book_id = book.id
        WHERE post.id = " . $_SESSION["postID"] . ";";

        $result = $mysql->query($sql);
        $row = $result->fetch_array();
        $_SESSION['postTitle'] = $row['title'];
        echo "<input type='number' name='postID' style='display: none;' value=" . $row['id'] . ">";
        echo "<span><b>Название новости:</b> " . $row['title']."<br>";
        $_SESSION['postAnons'] = $row['anons'];
        echo "<span><b>Анонс:</b> " . $row['anons']."<br>";
        $_SESSION['postDate'] = $row['date'];
        echo "<span><b>Дата:</b> " . $row['date']."<br>";
        // $_SESSION['bookGenre'] = $row['genre'];
        // echo "<span><b>Жанр:</b> " . $row['genre']."<br>";
        $id = $row['book_id'];
        $_SESSION['bookID'] = $id;
        echo "<span><b>Обложка книги:</b> ". "<img src='imageView.php?id=$id&column=cover' class='img-fluid' style='width: 200px; height: 300px'>" ."<br>";
        $_SESSION['postFullText'] = $row['full_text'];
        echo "<span><b>Текст новости:</b> <span>" . $row['full_text']."</span><br><br>";
    }
    else {
        $sql = "SELECT post.id, post.title AS title,
        post.anons, post.date, post.full_text
        FROM `post`
        WHERE post.id = " . $_SESSION["postID"] . ";";

        $result = $mysql->query($sql);
        $row = $result->fetch_array();
        $_SESSION['postTitle'] = $row['title'];
        echo "<input type='number' name='postID' style='display: none;' value=" . $row['id'] . ">";
        echo "<span><b>Название новости:</b> " . $row['title']."<br>";
        $_SESSION['postAnons'] = $row['anons'];
        echo "<span><b>Анонс:</b> " . $row['anons']."<br>";
        $_SESSION['postDate'] = $row['date'];
        echo "<span><b>Дата:</b> " . $row['date']."<br>";
        $_SESSION['postFullText'] = $row['full_text'];
        echo "<span><b>Текст новости:</b> <span>" . $row['full_text']."</span><br><br>";
    }
    

    // echo "<form action='checkRealEstate.php'>";


    if ($_SESSION["userRole"] == 1) {
        echo "<button type='button' class='btn btn-success' style='width: 30%; margin-top: 7px; margin-bottom: 7px;' onclick='openEditForm();addText();'>Редактировать</button>";
        echo "<form action='checkPost.php' method='post' style='display: inline;'><button type='submit' name='isDeletePost' value='1' class='btn btn-danger' style='width: 30%; margin-left: 31%'>Удалить</button></form>";
    }
    // echo "</form>"

?>
    <form action="checkPost.php" id="editForm" style="display: none;" method="post">
    
    <label for="postTitle" class="label">Название новости:</label>
    <input type="text" name="postTitle"  value="<?=$_SESSION['postTitle']?>" class="form-control" required>

    <label for="postAnons" class="label">Анонс новости:</label>
    <input type="text" name="postAnons"  value="<?=$_SESSION['postAnons']?>" class="form-control" required>

    <label for="postDate" class="label">Дата новости:</label>
    <input type="datetime-local" name="postDate"  value="<?=$_SESSION['postDate']?>" class="form-control" required>

    <script>
        var text = <?=json_encode($_SESSION['postFullText']);?>;
        function addText() {
            document.getElementById("txtpost").value = text;
        }
    </script>

    <label for="postFullText" class="label">Текст новости:</label>
    <textarea name="postFullText" id="txtpost" placeholder="Введите текст статьи" class="form-control" required></textarea><br>
    
    <label for="bookTitle" class="label">Название книги:</label>
    <select name="bookTitle"  value="<?=$_SESSION['bookTitle']?>" class="form-control" required>
        <option selected>-</option>
        <?php printSelectResultsForComboBox('title');?>
    </select><br>

    <button type="submit" class="btn btn-success" style="width: 30%; position:absolute; left: 15%;">Сохранить</button>
    <button type="button" class="btn btn-danger" style="width: 30%; position:absolute; right: 13%;" onclick="closeEditForm();">Закрыть</button>
</form>
            </div>
        </div>
<?php
    include_once "footer.php";
?>
    </div>

</div>