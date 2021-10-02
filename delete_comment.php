<?php
session_start();
require "_dbconnect.php";
$del_comment_id= $_POST["del_id"];
$stmt = $conn->prepare("DELETE  FROM `tbl_comment` WHERE `comment_id`= '{$del_comment_id}'");
$stmt->execute();


  echo 1;
$conn->close();
    
?>