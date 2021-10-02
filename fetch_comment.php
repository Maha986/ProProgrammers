<?php

session_start();
require "_dbconnect.php";
$username = $_SESSION["username"];
$fetchcomment = $conn->prepare("SELECT * from `tbl_comment` where  `parent_comment_id` = '0' ORDER BY comment_id DESC");
$fetchcomment->execute();

$commentresult = $fetchcomment->get_result();
$output = '';
$rnum = mysqli_num_rows($commentresult);
while ($row = mysqli_fetch_assoc($commentresult)) {

    abc($conn, $username, $row["comment_id"]);
    $output .= '
        <div  class="comment-panel" style="border:2px solid #1eb2a6 ;border-radius:4px;background-color:white;">
         <div class="comment-header" style="background-color:white;border:none;border-bottom:2px solid #1eb2a6;border-radius:4px;color:black"><b>' . $row["comment_sender_name"] . '</b><div>&nbsp  <i> &nbsp ' . $row["date"] . '</i></div></div>
         <div  class="comment-body"   style="background-color:white;border:none;border-bottom:2px solid #1eb2a6;border-radius:4px;color:black">' . $row["comment"] . '</div>
         <div class="comment-footer" style="background-color:white;border:none;border-bottom:2px solid #1eb2a6;border-radius:4px;color:black"><button type="button" style="color:white" title="Reply to the comment" class="reply"  id="' . $row["comment_id"] . '"><i class="fas fa-reply-all"></i></button>
         <button type="button" title="Delete comment" class="delete" id="delete' . $row["comment_id"] . '" style="color:white"><i class="fas fa-trash" ></i></button></div>
         
        </div>
        ';
    $output .= get_reply_comment($conn, $row["comment_id"]);
}
echo $output;
$counter = 0;
function get_reply_comment($conn, $parent_id = 0, $marginleft = 0)
{
    $username = $_SESSION["username"];
    $output = '';
    $getreply = $conn->prepare("SELECT * from `tbl_comment` where  `parent_comment_id` = '" . $parent_id . "'");
    $getreply->execute();
    $replyresult = $getreply->get_result();
    $count = mysqli_num_rows($replyresult);
    $saql = "SELECT * FROM `tbl_comment` WHERE  `comment_id`=?";
    $stamt = $conn->prepare($saql);
    $stamt->bind_param("i", $parent_id);
    $stamt->execute();
    $resulta = $stamt->get_result();
    if ($parent_id == 0) {
        $marginleft = 0;
        $width = 100;
    } else {
        $marginleft = $marginleft + 48;
    }

    if ($count > 0) {
        while ($row = mysqli_fetch_assoc($replyresult)) {

            while ($rowa = $resulta->fetch_assoc()) {

                abc($conn, $username, $row["comment_id"]);
                $output .= '
        <div class="comment-panel" id="reply-comment"  style="margin-left:' . $marginleft . 'px;">
         <div class="comment-header" style="background-color:white;border:none;border-bottom:2px solid #1eb2a6;border-radius:4px;color:black" ><b>' . $row["comment_sender_name"] . '</b> reply to ' . $rowa["comment_sender_name"] . '<div>&nbsp  <i> &nbsp ' . $row["date"] . '</i></div></div>
         <div class="comment-body" style="background-color:white;border:none;border-bottom:2px solid #1eb2a6;border-radius:4px;color:black">' . $row["comment"] . '</div>
         <div class="comment-footer" style="background-color:white;border:none;border-bottom:2px solid #1eb2a6;border-radius:4px;color:black"><button type="button" title="Reply to the comment" class="reply"  id="' . $row["comment_id"] . '" style="color:white"><i class="fas fa-reply-all"></i></button>
         <button type="button" class="delete" title="Delete comment" id="delete' . $row["comment_id"] . '"><i class="fas fa-trash" style="color:white"></i></button></div>
         </div>';
                $output .= get_reply_comment($conn, $row["comment_id"], $marginleft);
            }
        }
    }
    return $output;
}
function abc($conn, $username, $assi)
{
    // $username = $_SESSION["username"];

    $stmt5 = $conn->prepare("SELECT * from `tbl_comment` WHERE `comment_id`=?");

    $stmt5->bind_param("i", $assi);
    $stmt5->execute();
    $stmt5result = $stmt5->get_result();
    while ($row1 = mysqli_fetch_assoc($stmt5result)) {
        $comment_sender = $row1["comment_sender_name"];



        if ($comment_sender == $username) {
?>
            <script>
                // document.getElementsByClassName("delete").style.display="none";
                var u = document.getElementById("delete" + <?php echo $assi ?>)
                u.style.display = "block"
            </script>
        <?php
        } else { ?>
            <script>
                var u = document.getElementById("delete" + <?php echo  $assi ?>)
                u.style.display = "none";
                //  document.getElementsByClassName("delete").style.display="block";
                // $(".delete").css("display", "inline-block");
            </script>
<?php
        }
    }
}
$conn->close();
