<?php
   session_start();
   require "_dbconnect.php";

    
    $action=$_POST['action'];

    if($action=="update")
    {
        $i=$_POST['id'];
        $h=$_POST['he'];
        $p=$_POST['pa'];
        $sqlinsert="UPDATE `notes` SET `Title` =  '$h' ,`Detail` = '$p' WHERE `SNo`=$i";
        $result=mysqli_query($conn,$sqlinsert);
        if($result)
        {
            echo "data inserted successfully";
        }
    }
    if($action=="color_change")
    {
        echo "entered";
        $color=$_POST['color'];
        $id=$_POST['id'];
        echo $id,$color;
        $colorupdate="UPDATE `notes` SET `color`='$color' WHERE `SNo`=$id";
        $res=mysqli_query($conn,$colorupdate);
        if($res)
        {
            echo "chanfed ";
        }
        else
        {
            echo "not chanfed";
        }
    }
    if($action=="delete")
    {
        $i=$_POST['id'];
        $h=$_POST['he'];
        $p=$_POST['pa'];
        $id=$_POST['did'];
        $sqldelete="DELETE FROM `notes` WHERE `SNo`=$id";
        mysqli_query($conn,$sqldelete); 
    }
    

   
?>