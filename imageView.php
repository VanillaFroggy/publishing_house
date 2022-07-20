<?php
    require_once "db.php";
    if(isset($_GET['id']) && isset($_GET['column'])) {
        $id = $_GET['id'];
        $column = $_GET['column'];
        $sql = "SELECT $column FROM `book` WHERE `id` = " . $_GET['id'];
        $result = $mysql->query($sql) or die("<b>Error:</b> Problem on Retrieving Image BLOB<br/>" . $mysql->error);
        $row = $result->fetch_assoc();
        header("Content-type: image/jpeg");
        echo $row["$column"];
    }
	$mysql->close();
?>