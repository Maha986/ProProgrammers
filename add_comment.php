<?php
session_start();
require "_dbconnect.php";
// if ($_POST["action"] == "add") {
$comment_content = '';
$username = $_SESSION["username"];
 $comment_content = $_POST["comment_content"];
    $stmt = $conn->prepare("INSERT INTO `tbl_comment` (`comment`, `comment_sender_name`,`parent_comment_id`) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $comment_content, $username, $_POST['comment_id']);
    $stmt->execute();

echo 1;

