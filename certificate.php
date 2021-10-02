
<?php
session_start();
require "_dbconnect.php";
$img = imagecreatefromjpeg('certificate.jpg');
$name_color = imagecolorallocate($img, 19, 21, 22);
// $name_font = 'C:\Windows\Fonts\BRUSHSCI.ttf';
$name_font = 'C:\Windows\Fonts\arial.ttf';

$name=$_SESSION["username"];
// $font='G:\xampp\htdocs\Web-project-proprogrammers\Web_Engineering\webproj\Courgette-Regular.ttf';
$name_count=strlen($name);
$url = $_SERVER['REQUEST_URI'];
$parts = parse_url($url);
parse_str($parts['query'], $query);
$courseid=$query['id'];
$couresname=$conn->prepare("SELECT `CourseName` FROM `courses` WHERE `CourseId`=?");
$couresname->bind_param('i',$courseid);
$couresname->execute();
$coursenameres=$couresname->get_result();
while($coursedata=mysqli_fetch_assoc($coursenameres))
{
    $course=$coursedata["CourseName"];
}
$course_font='C:\Windows\Fonts\arial.ttf';
$course_color = imagecolorallocate($img, 17, 79, 82);

$coursedate=$conn->prepare("SELECT `Date` FROM `enrollment` WHERE `CourseId`=? AND `username`=?");
$coursedate->bind_param('is',$courseid,$name);
$coursedate->execute();
$coursedateres=$coursedate->get_result();
while($courseDate=mysqli_fetch_assoc($coursedateres)){

    $datestring=$courseDate["Date"];
    $date=date('d-M-Y',strtotime($datestring));
}
// Get image dimensions
$width = imagesx($img);
$height = imagesy($img);
// Get center coordinates of image
$centerX = $width / 2;
$centerY = $height / 2;
// Get size of text
list($left_name, $bottom_name, $right_name, , , $top_name) = imageftbbox(40, 0, $name_font, $name);
list($left_course, $bottom_course, $right_course, , , $top_course) = imageftbbox(25, 0, $course_font, $course);
// Determine offset of text
$left_offset_name = ($right_name - $left_name) / 2;
$top_offset_name = ($bottom_name - $top_name) / 2;
$left_offset_course = ($right_course - $left_course) / 2;
$top_offset_course = ($bottom_course - $top_course) / 2;
// Generate coordinates
$x_name = $centerX - $left_offset_name;
$x_course = $centerX - $left_offset_course;
imagettftext($img,40, 0, $x_name, 330, $name_color, $name_font, $name);
imagettftext($img,25, 0, $x_course, 500, $course_color, $course_font, $course);
imagettftext($img,15, 0, 480, 630, $name_color, $course_font, $date);
header('Content-Type: image/jpg');
ob_clean();
imagejpeg($img);
imagedestroy($img);
?>