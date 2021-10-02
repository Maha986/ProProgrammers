<?php
session_start();
session_unset();
session_destroy();
//  header('location:home.php');
$before = $_SERVER['HTTP_REFERER'];
if(isset($before)) {
     header('Location: '.$before);  
} else {
     header('Location: index.php');  
}
    exit;

?>