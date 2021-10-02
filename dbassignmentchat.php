<?php
session_start();
require "_dbconnect.php";
if ($_POST["action"] == "add") {
    $comment_content = $_POST["comment"];
    $topic = $_POST["topic"];
    $username = $_SESSION["username"];
    //  $comment_content = $_POST["comment_content"];
    echo $comment_content,$topic,$username;
    $stmt = $conn->prepare("INSERT INTO `assignment_comment` (`assignment_commet`,`assignment_topic`, `sender_name`,`rating`) VALUES(?, ?, ?, ?)");
    // $stmt=$conn->prepare("SELECT MAX(assignment_comment_id)+1 AS 'NUM' FROM `assignment_comment`");
    // $stmt=$conn->prepare("INSERT INTO `books`(`Title`,`Catogory`,`Language`) VALUES (?,?,?)");
     $rating = 0;
     
    
    $stmt->bind_param("sssi", $comment_content, $topic, $username,$rating);
    $stmt->execute();
    // $stmtresult = $stmt->get_result();
//  if($stmt) {
    //  echo "inserted";
 
//  else{
     
//  echo "no row gone";
// while ($row = mysqli_fetch_assoc($stmtresult)){
//     echo $row['NUM'];
// }

    
 echo 1;
    // $stmt->close();
}
if ($_POST["action"] == "load") {

    $username = $_SESSION["username"];

    $fetchcomment = $conn->prepare("SELECT * from `assignment_comment` ORDER BY assignment_id DESC ; ");
    $fetchcomment->execute();
    $commentresult = $fetchcomment->get_result();
    $output = '';
    $rnum = mysqli_num_rows($commentresult);
    while ($row = mysqli_fetch_assoc($commentresult)) {
        abc($conn, $username, $row["assignment_id"]);
        $sum = $row["rating"];
        $output .= '
        <div  class="comment-panel"  >
         <div class="comment-header"><b>' . $row["sender_name"] . '</b><span style="float:right;margin-right:10px;"><i>' . $row["assignment_topic"] . ' Assignment</i></span></div>
         <div  class="comment-body">' . $row["assignment_commet"] . '</div>
         <div class="comment-footer"  id="footer' . $row["assignment_id"] . '">

      
         <div class="result-container" >
         <div class="rate-bg "  id="rate-bg' . $row["assignment_id"] . '"></div>
         <div class="rate-stars" id="rate-stars' . $row["assignment_id"] . '"></div>
         
     </div>   
     <button type="button"  title="Rate the project" class="reply"  id="btn' . $row["assignment_id"] . '"><i class="fad fa-stars" style="font-size:15px;"></i>&nbsp;Rate</button>
     <button type="button" title="Delete comment" class="delete" style="display:block;" id="delete' . $row["assignment_id"] . '"><i class="fas fa-trash"></i>&nbsp;Delete</button></div>                 
     <span class="reviewScore" id="reviewScore' . $row["assignment_id"] . '" ></span><span class="reviewCount"  id="reviewCount' . $row["assignment_id"] . '"></span>
    
        
         
     
    </div>
    ';
        $stmt3 = $conn->prepare("SELECT COUNT(assignment_id) AS review  from `assignment_reviewers` WHERE assignment_id=?");
        $stmt3->bind_param("i", $row["assignment_id"]);
        $stmt3->execute();
        $stmt3res = $stmt3->get_result();

        while ($row1 = mysqli_fetch_assoc($stmt3res)) {
            $times = $row1["review"];
            if ($times != 0) {
                $sumrate = $sum / $times;
                $prcnt = (($sumrate) / 5) * 100;
                $r = substr($sumrate, 0, 3);
            } else {
                $times = 0;
                $sumrate = 0;
                $r = 0;
                $prcnt = 0;
            }

?>
            <script>
                var w = document.getElementById("rate-bg" + <?php echo $row["assignment_id"] ?>)
                w.style.width = <?php echo $prcnt ?> + "%"

                var d = document.getElementById("reviewScore" + <?php echo $row["assignment_id"] ?>)
                d.innerHTML = "Rating:<b><?php echo $r ?></b> ";

                var p = document.getElementById("reviewCount" + <?php echo $row["assignment_id"] ?>)
                p.innerHTML = "(<b><?php echo $times ?></b> people reviewed this assignment)";
            </script>
        <?php




        }
    }





    echo $output;
}

if ($_POST["action"] == "rate") {
    $commentrate = $_POST["i"] + 1;
    $modal_id  = $_POST["modal_id"];
    $username = $_SESSION["username"];



$stmt1=$conn->prepare("SELECT rating FROM `assignment_comment` WHERE assignment_id=?");
$stmt1->bind_param("i", $modal_id);
$stmt1->execute();
 $stmt1result = $stmt1->get_result();
while($row = mysqli_fetch_assoc($stmt1result)){
$newrating=$row["rating"]+$commentrate;
}
    //  $comment_content = $_POST["comment_content"];
    // $stmt = $conn->prepare("INSERT INTO `assignment_comment` (`rating`) SELECT MAX(rating)+1  FROM `assignment_comment` where `assignment_id`= ?");

    //    $stmt = $conn->prepare("UPDATE assignment_comment SET rating=SELECT MAX(rating)+$commentrate FROM `assignment_comment` WHERE assignment_id=?");
    //    UPDATE assignment_comment SET rating=(SELECT MAX(rating) +1 FROM `assignment_comment`) WHERE assignment_id=1
    $stmt = $conn->prepare("UPDATE assignment_comment SET rating=? WHERE assignment_id=?");

    $stmt->bind_param("ii", $newrating, $modal_id);
    $stmt->execute();
    $stmt1 = $conn->prepare("INSERT INTO `assignment_reviewers` (`reviewer_name`,`assignment_id`) VALUES (?,?)");

    $stmt1->bind_param("si", $username, $modal_id);
    $stmt1->execute();
    echo 1;
}

if ($_POST["action"] == "delete") {
    $del_comment_id = $_POST["del_id"];
    // $stmt = $conn->prepare("DELETE  FROM `assignment_comment` WHERE `comment_id`=?");
    $stmt = $conn->prepare("DELETE t1, t2 FROM assignment_comment t1 LEFT JOIN assignment_reviewers t2 ON t1.assignment_id = t2.assignment_id WHERE t1.assignment_id = ?");
    $stmt->bind_param("i", $del_comment_id);
    $stmt->execute();
    echo 1;
}
$m=false;
$n=false;
if ($_POST["action"] == "open") {
    $modal_id  = $_POST["modal_id"];
    $username = $_SESSION["username"];

    $stmt2 = $conn->prepare("SELECT * from `assignment_comment` WHERE assignment_id=?");
    $stmt2->bind_param("i", $modal_id);
    $stmt2->execute();
    $stmt2result = $stmt2->get_result();


    $row = mysqli_fetch_assoc($stmt2result);
    $assignment_sender = $row["sender_name"];
    
    if ($assignment_sender == $username) {
        echo 0;
    }
        else{

    $stmt4 = $conn->prepare("SELECT * from `assignment_reviewers` WHERE assignment_id=?");
    $stmt4->bind_param("i", $modal_id);
    $stmt4->execute();
    $stmt4result = $stmt4->get_result();

$review=false;
    while ($row1 = mysqli_fetch_assoc($stmt4result)) {


            
          if ($username == $row1["reviewer_name"]) {
              $review=true;
              
              break;
           
            
        } 
            
           
    }
    if($review==true){
        echo 1;
    }
    else{
        echo 2;

    }
        
    
  
}
}

function abc($conn, $username, $ass)
{
    // $username = $_SESSION["username"];

    $stmt5 = $conn->prepare("SELECT * from `assignment_comment` WHERE `assignment_id`=?");

    $stmt5->bind_param("i", $ass);
    $stmt5->execute();
    $stmt5result = $stmt5->get_result();
    while ($row1 = mysqli_fetch_assoc($stmt5result)) {
        $assignment_sender = $row1["sender_name"];



        if ($assignment_sender == $username) {
        ?>
            <script>
                // document.getElementsByClassName("delete").style.display="none";
                var u = document.getElementById("delete" + <?php echo $ass ?>)
                u.style.display = "block"
            </script>
        <?php
        } else { ?>
            <script>
                var u = document.getElementById("delete" + <?php echo  $ass ?>)
                u.style.display = "none";
                //  document.getElementsByClassName("delete").style.display="block";
                // $(".delete").css("display", "inline-block");
            </script>
<?php
        }
    }

    
}
$conn->close();