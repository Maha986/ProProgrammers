<?php
session_start();
require "_dbconnect.php";
include "nav.php";
include "login.php";
include "signup.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProProgrammers| search result</title>
    <style>
        #searchsec
        {
            width:70%;
            font-size:1.3rem;
            margin:auto;
        }
        #searchsec h3
        {
            margin: 12px 0px;
            /* border-bottom: 2px solid #1eb2a6; */
        }
        #searchsec h4
        {
            margin: 6px 0px;
        }
        #searchsec p
        {
            margin: 13px 0px;
        }
        #searchsec hr
        {
            margin: 0px !important;

        }
        
    </style>
</head>
<body>

<section id="searchsec">
<?php
if(isset($_POST['searchmenu']))
{
    $val=$_POST['searchmenu'];
    if($val=="")
    {
        echo "<div style='text-align:center;'>You need to provide some information for us to search.</div>";
    }
    else
    {
        echo "<p style='font-size:1.7rem; color:#1eb2a6; margin:31px;text-align:center;'><b>$val</b></p>";
        $pieces=explode(" ",$val);
        $courseselected=false;
        $cid=0;
        foreach($pieces as $i)
        {
            $topicselected=false;

            if($courseselected==false && $i!="")
            {
                $sqlselect = $conn->prepare( "SELECT *
                FROM courses WHERE `CourseName` LIKE '%$i%'");
                $sqlselect->execute();
                $sqlsresult = $sqlselect->get_result();
                $rsnum = mysqli_num_rows( $sqlsresult );
                if ( $rsnum>0 )
                {
                    $courseselected=true;
                    while( $srow = mysqli_fetch_assoc( $sqlsresult ) )
                    {
                        $cid=$srow["CourseId"];
                    }
                    
                }
            }
            if($courseselected==true && $i!="")
            {
                    $topicselect=$conn->prepare("SELECT * FROM `topics` WHERE `CourseId`=? AND `TopicName` LIKE '%$i%'");
                    $topicselect->bind_param('i',$cid);
                    $topicselect->execute();
                    $result=$topicselect->get_result();
                    if(mysqli_num_rows($result)>0)
                    {
                        $topicselected=true;
                        while($row=mysqli_fetch_assoc($result))
                        {
                            $moduleid=$row['ModuleId'];
                            $topicid=$row['TopicId'];
                            $topicname=$row['TopicName'];
                            echo "<div id='topicdiv".$topicid."mod".$moduleid."'><h3>$topicname</h3></div>";
                            $subtopicselect=$conn->prepare("SELECT * FROM `subtopics` WHERE `CourseId`=? AND `TopicId`=? AND `ModuleId`=?");
                            $subtopicselect->bind_param('iii',$cid,$topicid,$moduleid);
                            $subtopicselect->execute();
                            $subtopicres=$subtopicselect->get_result();
                            while($r=mysqli_fetch_assoc($subtopicres))
                            {
                                $subtopicid=$r['SubtopicId'];
                                $subtopicname=$r['SubtopicName'];
                                $subtopicdesc=$r['SubtopicDesc'];
                                echo "<script>$('#topicdiv".$topicid."mod".$moduleid."').append(`<hr><h4>$subtopicname</h4><p>$subtopicdesc</p>`)</script>";
                            }
                        }
                    }
                
                if($topicselected==false)
                {
                    $subselect=$conn->prepare("SELECT * FROM `subtopics` WHERE `CourseId`=? AND `SubtopicName` LIKE '%$i%'");
                    $subselect->bind_param('i',$cid);
                    $subselect->execute();
                    $subresult=$subselect->get_result();
                    if(mysqli_num_rows($subresult)>0)
                    {
                        while($srow=mysqli_fetch_assoc($subresult))
                        {
                            $subtopicdesc=$srow['SubtopicDesc'];
                            $subtopicname=$srow['SubtopicName'];
                            echo "<div><hr><h4>$subtopicname</h4><p>$subtopicdesc</p></div>";
                        
                        }
                    }
                }
            }
            
        }

        if($courseselected==false)
        {
            echo "<div style='text-align:center;'>Sorry we could not process your request please do more clarification</div>";
        }
    }
}
?>
</section>




    <?php
include "footer.php";
?>

<script>
    // et xhr= new XMLHttpRequest();
    //         xhr.open("GET","nav.php",true);
    //         xhr.responseType='json';
    //         xhr.onload=()=>{
    //             console.log(xhr.response);
    //         }
    //         xhr.send();
            
</script>
</body>
</html>



