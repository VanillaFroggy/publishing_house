<?php
    session_start();

    require_once "db.php";

    $pageTitle = "Корзина";

    require_once "user_header.php";

    // print_r($_SESSION);

    function printSelectResultsForComboBox($column) {
        $host = "localhost";
        $hostLogin = "root";
        $hostPassword = "1234";
        $dbName = "publishing_house";
    
        $mysql = new mysqli($host, $hostLogin, $hostPassword, $dbName);
        $result = $mysql->query("SELECT DISTINCT $column FROM `cart`;");
        if($result->num_rows > 0) {           
            while($row = $result->fetch_assoc()) {
                echo "<option>" . $row[$column] . "</option><br>";
            }
        }
        $mysql->close();
    }  

    if(isset($_POST["isEditForm"]) && isset($_POST["isDeleteBook"])) {
        $editFormStatus = "display: none;";
    }
    else if(isset($_POST["isEditForm"]) && $_POST["isEditForm"] == '1') {
        $editFormStatus = "display: block;";
    }
    else {
        $editFormStatus = "display: none;";
    }

    if(isset($_POST["isDeleteBook"]) && $_POST["isDeleteBook"] == '1') {
        if($mysql->connect_error) {
            echo "Error Number: ". $mysqsl->connect_errno."<br>";
            echo "Error: " . $mysql->connect_error;
        }
        else {
            $bookId = htmlspecialchars(trim($_POST["bookID"]));
            $mysql->query("DELETE FROM `cart` WHERE `book_id` = '$bookId' AND `user_id` = '" .  $_SESSION['userId'] . "';");
        }
    }

    $fullPrice = 0;
    $fullPriceResult = $mysql->query("SELECT book.price, cart.count 
                                FROM `cart`
                                INNER JOIN `book` ON cart.book_id = book.id
                                WHERE cart.user_id = '" . $_SESSION['userId'] . "' AND cart.status = 'ожидает';");
    if($fullPriceResult->num_rows > 0) {           
        while($row = $fullPriceResult->fetch_assoc()) {
            $fullPrice += $row['price'] * $row['count'];
        }
    }

    if(isset($_POST["bookID"])) {
        $bookResult = $mysql->query("SELECT `count` FROM `cart` WHERE book_id = '" . $_POST["bookID"] . "' AND `user_id` = '" .  $_SESSION['userId'] . "';");
        $bookId = $_POST["bookID"];
        $bookCount = printSelectRow($bookResult, 'count');
        $bookResult = $mysql->query("SELECT `status` FROM `cart` WHERE book_id = '" . $_POST["bookID"] . "' AND `user_id` = '" .  $_SESSION['userId'] . "';");
        $bookStatus = printSelectRow($bookResult, 'status');
    }

    $gridResult = $mysql->query("SELECT cart.user_id, cart.book_id, cart.count, 
                                cart.status, book.title, book.cover, book.price 
                                FROM `cart`
                                INNER JOIN `book` ON cart.book_id = book.id
                                WHERE cart.user_id = '" . $_SESSION['userId'] . "' AND cart.status = 'ожидает';");
    
    $editFormSelectResult = $mysql->query("SELECT cart.user_id, cart.book_id, cart.count, 
    cart.status, book.title, book.cover, book.price 
    FROM `cart`
    INNER JOIN `book` ON cart.book_id = book.id
    WHERE cart.user_id = '" . $_SESSION['userId'] . "' AND cart.status = 'ожидает';");

    function printSelectResults($result) {
        if($result->num_rows > 0) {           
            while($row = $result->fetch_assoc()) {
                echo "<div class='col-lg-3 col-md-4 col-sm-12 element m-2' style=''><form action='' method='post'>";
                echo "<input type='number' name='isEditForm' value='1' style='display: none;' value=" . "display: none" . ">";
                echo "<input type='number' name='bookID' style='display: none;' value=" . $row['book_id'] . ">";
                // echo "id жанра: " . $row['id']."<br>";
                echo "<b><h5>" . $row['title']."</h5></b>";
                $id = $row['book_id'];
                echo "<img src='imageView.php?id=$id&column=cover' class='img-fluid' style='width: 200px; height: 300px'>" ."<br>";
                echo "<p>".$row['price']." р.</p>";
                echo "<p>".$row['count']." шт.</p>";
                echo "<button type='submit' class='btn btn-success' style='margin-top: 7px; margin-bottom: 7px; display: inline;' >Редактировать</button>";
                echo "<button type='submit' name='isDeleteBook' value='1' class='btn btn-danger' style='margin-bottom: 7px; display: inline;'>Удалить</button>";
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
<h1 class='text-center gridH'>Корзина</h1>
<!-- <button type='button' class='btn btn-success btnOpenCreateForm' id='btnOpenCreateForm' onclick='openCreateForm();'>Внести жанр</button> -->

<form action="checkCart.php" id="editForm" style="<?=$editFormStatus?>" method="post">
    <input type='number' name='isEditForm' value='1' style='display: none;' value="display: none">
    <input type='number' name='bookID' value='<?=$bookId?>' style='display: none;' value="display: none">
    <label for="bookCount" class="label">Количество экземпляров:</label>
    <input type="number" name="bookCount" value="<?=$bookCount?>" class="form-control" required>
    <label for="bookStatus" class="label">Статус:</label>
    <select name="bookStatus" value="<?=$bookStatus?>" class="form-control" required>
        <?php printSelectResultsForComboBox('status');?>
    </select><br>
    <button type="submit" class="btn btn-success">Сохранить</button>
    <button type="button" class="btn btn-danger" style="position:absolute; right: 2.9%;" onclick="closeEditForm();">Закрыть</button>
</form>

<div class='container  mt-2' id="grid">
    <div class='container'>
        <div class='row' style="margin-left: 8%;">
            <?=printSelectResults($gridResult);?>
        </div><br>
        <h4 class="h4">Итоговая цена: <?=$fullPrice?> р.</h4>
    </div>
</div><br>

<h2 class="text-center gridH">Информация об оплате и получении заказа</h2>

<div class="container about">
    <p>Уважаемые читатели, партнеры, друзья!<br>
      В настоящее время «Капибара» — это небольшой издательский дом в России, главный отдел которого расположен в Санкт-Петербурге.<br><br>

      Книги можно получить только самовывозом, оплата производится на месте, после чего нужно зайти в корзину и отметить книги, которые вы получили, выставив им соответствующий статус.</p><br>

    <div class="content-align-center" style="margin-left: 20%;">
        <h4 style="margin-left: 10%;">Место расположения главного офиса</h4><br>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2001.2252956835796!2d30.432344416068773!3d59.895209981860425!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46962e35293fa0c5%3A0xa3621928370af862!2sIzdatel&#39;skiy%20Dom%20%22Piter%22!5e0!3m2!1sen!2sru!4v1656757282171!5m2!1sen!2sru" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    <br><br>
</div>

<?php
    include_once "footer.php";
?>
</div>
