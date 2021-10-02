<?php
    $server="localhost";
    $username="root";
    $password="";
    $database="proprogrammers";
    $conn=mysqli_connect($server,$username,$password,$database);
    if(!$conn)
    {
        echo "<div>Sorry, We could not connect to database right now due to some unexpected error. We appologize for the inconveience.</div>";
    }
?>