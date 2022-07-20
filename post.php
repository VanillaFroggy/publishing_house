<?php
    session_start();

    $pageTitle = "Новости";

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
        if($column == "book_id") {
            $result = $mysql->query("SELECT title FROM `book`;");
            $column = 'title';
        }
        else {
            $result = $mysql->query("SELECT DISTINCT $column FROM `post`;");
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

    <h1 class="text-center">Новости издательства</h1>
        <div class="container">
        <?php
            if($_SESSION["userRole"] == 1)
                echo "<a href='createPost.php' class='btn btn-success' style='width: 30%; margin-bottom: 20px; margin-left: 35%'>Добавить новость</a>";
        ?>
            <!-- <a href="#editForm" class='btn btn-success' id='btnOpenCreateForm' onclick='openEditForm();' style='width: 30%; margin-bottom: 20px;' href>Отфильтровать</a> -->
            <div class="row">
        
<?php
function printSelectResults($result, $nullPointer) {
    if($result->num_rows > 0) {           
        while($row = $result->fetch_array()) {
            echo "<div class='col-lg-10 col-md-4 col-sm-12 element mb-3' style='margin-left: 8.5%;'><form action='postElement.php' method='post'>";
            echo "<b><h4>".$row['title']."</h4></b>";
            echo "<input type='number' name='postID' style='display: none;' value=" . $row['id'] . ">";
            echo "<p>".$row['anons']."</p>";
            echo "<p>".$row['date']."</p>";
            if($nullPointer != null) {
                $id = $row['book_id'];
                echo "<img src='imageView.php?id=$id&column=cover' class='img-fluid' style='width: 200px; height: 300px'>" ."<br>";
            }
            echo "<button type='submit' class='btn btn-success' style='margin-top: 7px; margin-bottom: 7px;'>Детали</button>";
            echo "</form></div>";
        }
    }
}
    if($mysql->connect_error) {
        echo "Error Number: ". $mysqsl->connect_errno."<br>";
        echo "Error: " . $mysql->connect_error;
    }
    else {
        $seekBookResult = $mysql->query("SELECT book_id FROM `post` WHERE id ='" . $_SESSION['postID'] . "';");
        $row = $seekBookResult->fetch_assoc();
        $bookIdResult = $row['book_id'];
        if($bookIdResult != null) {
            $result = $mysql->query("SELECT post.id, post.title AS title,
            post.anons, post.date, book.cover, post.book_id
            FROM `post` INNER JOIN `book`
            ON post.book_id = book.id
            ORDER BY post.date DESC;");
            printSelectResults($result, $bookIdResult);
        }
        else {
            $result = $mysql->query("SELECT post.id, post.title AS title,
            post.anons, post.date
            FROM `post`
            ORDER BY post.date DESC;");
            printSelectResults($result, $bookIdResult);
        }
    }
?>
            </div>
        </div>
    </div>
<?php
    include_once "footer.php";
?>
</div>
