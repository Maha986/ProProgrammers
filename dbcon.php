<?php
session_start();
require '_dbconnect.php';
include('smtp/PHPMailerAutoload.php');
$_SESSION["loggedinwithgoogle"] = false;
if (($_POST["action"] == "signup")) {
    $fullName = $_POST["fullName"];
    $emailId = $_POST["emailId"];
    $userName = $_POST["userName"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];
    $emailQuery = "SELECT * from `registration` where  `email` = '{$emailId}' ";
    $emailQueryResult = mysqli_query($conn, $emailQuery);
    $emailExistsCount = mysqli_num_rows($emailQueryResult);
    $fetchemail= mysqli_fetch_assoc($emailQueryResult);
    $userNameQuery = "SELECT * from `registration` where  `username` = '{$userName}' ";
    $userNameQueryResult = mysqli_query($conn, $userNameQuery);
    $userNameExistsCount = mysqli_num_rows($userNameQueryResult);
    if ($userNameExistsCount > 0  && $fetchemail["status"]=='inactive' ) {
        $deleteInactiveUser = "DELETE FROM `registration` WHERE `username` = '{$userName}' ";
                   
        if (mysqli_query($conn, $deleteInactiveUser)) {
            echo 7;
        } else {
            echo 8;
        }
       
    } elseif($userNameExistsCount > 0 ){
        echo 0;
    }
    elseif ($emailExistsCount > 0) {
        echo 1;
    } else {
        if ($password === $confirmPassword) {
            $encryptedPassword = password_hash($password, PASSWORD_BCRYPT);
            $encryptedConfirmPassword = password_hash($confirmPassword, PASSWORD_BCRYPT);
            $otpCode = bin2hex(random_bytes(2));
            $insertUserDetails = "INSERT INTO `registration` (`fullname`, `email`, `username`, `password`, `cpassword`, `code`, `status`) VALUES ('{$fullName}', '{$emailId}', '{$userName}', '{$encryptedPassword}', '{$encryptedConfirmPassword}' , '{$otpCode}', 'inactive');";
            $insertQueryResult = mysqli_query($conn, $insertUserDetails);
            if ($insertQueryResult) {

             
               smtp_mailer($emailId,'Email Verification',$otpCode);
                // SendMail($userName, $otpCode, $emailId);
            } else {

                echo 5;
            }
        } else {
            echo 6;
        }
    }
}

if ($_POST["action"] == "submitcode") {
    $otpVerificationCode = $_POST["otpVerificationCode"];
    $otpCodeQuery = "SELECT * from `registration` where  `code` = '{$otpVerificationCode}'";
    $otpCodeQueryResult = mysqli_query($conn, $otpCodeQuery);
    $otpCodeExists =   mysqli_num_rows($otpCodeQueryResult);
    if ($otpCodeExists == 1) {
        $updateOtpCode = "UPDATE `registration` SET `status` = 'active' WHERE `registration`.`code` = '{$otpVerificationCode}'";
        $resultUpdateOtpCode = mysqli_query($conn, $updateOtpCode);
        if ($resultUpdateOtpCode) {
            echo 0;
        } else {
            echo 1;
        }
    } else {
        echo 2;
    }
}

if ($_POST["action"] == "resendotpcode") {

    $resendOtpForEmail = $_POST["emailIdForResendingCode"];
    $resendOtpForEmailUsername = $_POST["usernameForResendingCode"];
    $resendCode = bin2hex(random_bytes(3));
    $sqlForResendCode = "UPDATE `registration` SET `code` = '{$resendCode}' WHERE `email` = '{$resendOtpForEmail}'";
    $resultResendcode = mysqli_query($conn,  $sqlForResendCode);
    if ($resultResendcode) {
        smtp_mailer($resendOtpForEmail,'Email Verification',$resendCode);
       
    } else {
        echo 0;
    }
}

if ($_POST["action"] == "resendforgototpcode") {

    $resendOtpForEmail = $_POST["emailIdForResendingCode"];
    $resendOtpForEmailUsername = $_POST["usernameForResendingCode"];
    $resendCode = bin2hex(random_bytes(3));
    $sqlForResendCode = "UPDATE `registration` SET `code` = '{$resendCode}' WHERE `email` = '{$resendOtpForEmail}'";
    $resultResendcode = mysqli_query($conn,  $sqlForResendCode);
    if ($resultResendcode) {

        // sendMail($resendOtpForEmailUsername, $resendCode, $resendOtpForEmail);
    } else {
        echo 0;
    }
}


if ($_POST["action"] == "signingoogle") {

    $UserGoogleEmail = $_POST["getUserGoogleEmail"];
    $getUserGoogleName = $_POST["getUserGoogleName"];
    $getUserGooglePicture = $_POST["getUserGooglePicture"];
    $googleEmailIdVerification = "SELECT * from `registration` where  `email` = '{$UserGoogleEmail}'";
    $googleEmailIdVerificationResult = mysqli_query($conn, $googleEmailIdVerification);
    $googleEmailExists =   mysqli_num_rows($googleEmailIdVerificationResult);
    if ($googleEmailExists > 0) {
        $fetchGoogleEmail = mysqli_fetch_assoc($googleEmailIdVerificationResult);
        $getUserGoogleEmailStatus =  $fetchGoogleEmail['status'];
        if ($getUserGoogleEmailStatus == "active") {
          
            $_SESSION["loggedin"] = true;
            $_SESSION["loggedinwithgoogle"] = true;
            $_SESSION["username"] =  $fetchGoogleEmail['username'];
            $_SESSION["userimage"] =  $getUserGooglePicture;
            // $_SESSION["username"] =  $email_pass['username'];
            echo 0;
        } else {
            $deleteacc = "DELETE FROM `registration` WHERE `email` = '{$UserGoogleEmail}' ";

            if (mysqli_query($conn, $deleteacc)) {
                echo 1;
            } else {
                echo 2;
            }
        }
    } else {
        echo 3;
    }
}


if (($_POST["action"] == "login")) {
    $usernameOrEmail = $_POST["usernameOrEmail"];
    $loginPassword = $_POST["loginPassword"];

    if (filter_var($usernameOrEmail, FILTER_VALIDATE_EMAIL)) {
        $emailVerifiactionQuery = "SELECT * from `registration` where  `email` = '{$usernameOrEmail}'";
        $resultOfEmailVerification = mysqli_query($conn, $emailVerifiactionQuery);
        $emailAlreadyExists =   mysqli_num_rows($resultOfEmailVerification);

        if ($emailAlreadyExists == 1) {
            $fetchExistsEmail = mysqli_fetch_assoc($resultOfEmailVerification);
            $fetchExistsEmailPassword = $fetchExistsEmail['password'];
            $decodePassword = password_verify($loginPassword, $fetchExistsEmailPassword);
            if ($decodePassword) {
                $fetchExistsEmailStatus = $fetchExistsEmail['status'];
                if ($fetchExistsEmailStatus == "active") {
                 
                    $_SESSION["loggedin"] = true;
                    $_SESSION["username"] =   $fetchExistsEmail['username'];

                    if ($_POST["check"] == "1") {


                        setcookie("user",  $_POST["usernameOrEmail"]);
                        setcookie("pass", $_POST["loginPassword"]);
                        echo 0;
                    } else {
                        if (isset($_COOKIE["user"])) {
                            setcookie("user", "");
                        }
                        if (isset($_COOKIE["pass"])) {
                            setcookie("pass", "");
                        }

                        echo 8;
                    }
                } else {
                    $deleteInactiveEmail = "DELETE FROM `registration` WHERE `email` = '{$usernameOrEmail}' ";
                   
                    if (mysqli_query($conn, $deleteInactiveEmail)) {
                        echo 1;
                    } else {
                        echo 2;
                    }
                }
            } else {
                echo 3;
            }
        } else {
            echo 4;
        }
    } else {
        $usernameVerifiactionQuery = "SELECT * from `registration` where  `username` = '{$usernameOrEmail}'";
        $resultOfUsernameVerification  = mysqli_query($conn, $usernameVerifiactionQuery);
        $usernameAlreadyExists =   mysqli_num_rows($resultOfUsernameVerification);
        if ($usernameAlreadyExists == 1) {
            $fetchExistsUsername = mysqli_fetch_assoc($resultOfUsernameVerification);
            $fetchExistsUsernamePassword = $fetchExistsUsername['password'];
            $decodePassword = password_verify($loginPassword,  $fetchExistsUsernamePassword);
            if ($decodePassword) {
                $fetchExistsUsernameStatus =   $fetchExistsUsername['status'];
                if ($fetchExistsUsernameStatus == "active") {
                
                    $_SESSION["loggedin"] = true;
                    $_SESSION["username"] = $fetchExistsUsername['username'];
                    if ($_POST["check"] == "1") {


                        setcookie("user",  $_POST["usernameOrEmail"]);
                        setcookie("pass", $_POST["loginPassword"]);
                        echo 0;
                    } else {
                        if (isset($_COOKIE["user"])) {
                            setcookie("user", "");
                        }
                        if (isset($_COOKIE["pass"])) {
                            setcookie("pass", "");
                        }

                        echo 8;
                    }
                } else {
                    $deleteInactiveUsername = "DELETE FROM `registration` WHERE `username` = '{$usernameOrEmail}' ";
                    // mysqli_query($con, $deleteInactiveUsername);
                    if (mysqli_query($conn, $deleteInactiveUsername)) {
                        echo 1;
                    } else {
                        echo 2;
                    }
                }
            } else {
                echo 3;
            }
        } else {
            echo 5;
        }
    }
}



// function sendMail($usernameForResendingCode, $otpCodeForResending, $emailIdForResending)
// {
//     $subject = "Email activation";
//     $body = "Hi, $usernameForResendingCode. Please confirm verify your account.Your verification code is $otpCodeForResending";
//     $headers = "From: proprogrammers.world@gmail.com";
//     if (mail($emailIdForResending, $subject, $body, $headers)) {
//         echo 3;
//     } else {
//         echo 4;
//     }
// }








function smtp_mailer($to,$subject, $msg){
	$mail = new PHPMailer(); 
	// $mail->SMTPDebug  = 3;
	$mail->IsSMTP(); 
	$mail->SMTPAuth = true; 
	$mail->SMTPSecure = 'tls'; 
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 587; 
	$mail->IsHTML(true);
	$mail->CharSet = 'UTF-8';
	$mail->Username = "proprogrammers.world@gmail.com";
	$mail->Password = "Program8$$";
	$mail->SetFrom("proprogrammers.world@gmail.com");
	$mail->Subject = $subject;
	$mail->Body = '<p> Please confirm verify your account.Your verification code is '.$msg.'</p>';
    
	$mail->AddAddress($to);
	$mail->SMTPOptions=array('ssl'=>array(
		'verify_peer'=>false,
		'verify_peer_name'=>false,
		'allow_self_signed'=>false
	));
	if(!$mail->Send()){
		echo 4;
	}else{
		echo 3;
	}
}



if ($_POST["action"] == "forgotemailsubmit") {

    $forgotemail = $_POST["forgotEmail"];

    $forgotemailexists = "SELECT * from `registration` where  `email` = '{$forgotemail}'";
    $forgotemailresult = mysqli_query($conn,  $forgotemailexists);
    $forgotalreadyexits =   mysqli_num_rows($forgotemailresult);
    if ($forgotalreadyexits > 0) {

        $forgotemailcode = mysqli_fetch_assoc($forgotemailresult);
        $fetchforgotusername  =   $forgotemailcode['username'];
        $fetchforgotemailcode  =   $forgotemailcode['code'];
      
        smtp_mailer($forgotemail,'Email Verification', $fetchforgotemailcode);
    } else {
        echo 0;
    }
}


if ($_POST["action"] == "forgotcodesubmit") {
    $forgotemail = $_POST["forgotEmail"];

    $forgotcode = $_POST["forgotcode"];
    $forgotemailexists = "SELECT * from `registration` where  `email` = '{$forgotemail}'";
    $forgotemailresult = mysqli_query($conn,  $forgotemailexists);
    $forgotemailcode = mysqli_fetch_assoc($forgotemailresult);
    $fetchforgotemailcode  =   $forgotemailcode['code'];
    if ($forgotcode  == $fetchforgotemailcode) {
        echo 0;
    } else {
        echo 1;
    }
}



if ($_POST["action"] == "updatepassword") {


    $forgotpassword = $_POST["forgotpassword"];
    $forgotConfirmPassword = $_POST["forgotConfirmPassword"];
    $forgotemail = $_POST["forgotEmail"];
    if ($forgotpassword ===  $forgotConfirmPassword) {

        $encryptedforgotPassword = password_hash($forgotpassword, PASSWORD_BCRYPT);
        $encryptedforgotConfirmPassword = password_hash($forgotConfirmPassword, PASSWORD_BCRYPT);
        $sqlForgetpassword = "UPDATE `registration` SET `password` = '{$encryptedforgotPassword}' , `cpassword` = '{$encryptedforgotConfirmPassword}'  WHERE `email` = '{$forgotemail}'";


        if (mysqli_query($conn, $sqlForgetpassword)) {
            echo 0;
        } else {
            echo 1;
        }
    } else {
        echo 2;
    }
}



if ($_POST["action"] == "submitProfile") {

    // session_start();
    $skills = $_POST["skills"];
    $username = $_SESSION["username"];
    $sqlprofile = "UPDATE `registration` SET `profile` = '{$skills}'  WHERE `username` = '{$username}'";


    if (mysqli_query($conn, $sqlprofile)) {
        echo 0;
    } else {
        echo 1;
    }
}
if ($_POST["action"] == "maintainProfile") {
    $username = $_SESSION["username"];
    $sqlprofilefetch = "SELECT *  from  `registration`  WHERE `username` = '{$username}'";
    $profileresult = mysqli_query($conn, $sqlprofilefetch);
    $row = mysqli_fetch_assoc($profileresult);
    $skills =   $row['profile'];
    if ($skills == "") {
        echo 0;
    } else {
        echo $skills;
    }
}
if ($_POST["action"] == "maintaincourse") {
    $username = $_SESSION["username"];
    $sqlcourseenroll = $conn->prepare("SELECT courses.CourseId As id,courses.CourseName AS Course FROM enrollment INNER JOIN courses WHERE enrollment.CourseId=courses.CourseId AND enrollment.username =?");

    $sqlcourseenroll->bind_param("s", $username);
    $sqlcourseenroll->execute();
    $courseenrollexits  = $sqlcourseenroll->get_result();
    $output = '';
    $rnum = mysqli_num_rows($courseenrollexits);


    if ($rnum > 0) {


        while ($row1 = mysqli_fetch_assoc($courseenrollexits)) {




            $sqltotalmodule = $conn->prepare("SELECT COUNT(ModuleId) AS Total from module WHERE CourseId =?");

            $sqltotalmodule->bind_param("i", $row1["id"]);
            $sqltotalmodule->execute();
            $sqltotalmoduleresult = $sqltotalmodule->get_result();
            $row2 = mysqli_fetch_assoc($sqltotalmoduleresult);
            $totalModule = $row2["Total"]+1;

            $sqltotalprogress = $conn->prepare("SELECT COUNT(attemptquiz.ModuleId)+COUNT(DISTINCT enrollment.AssignmentUrl) AS Progress FROM attemptquiz INNER JOIN enrollment ON attemptquiz.CourseId=enrollment.CourseId AND attemptquiz.username=enrollment.username WHERE attemptquiz.username=? AND attemptquiz.CourseId=?");

            $sqltotalprogress->bind_param("si", $username, $row1["id"]);
            $sqltotalprogress->execute();
            $sqlprogressresult = $sqltotalprogress->get_result();
            $row3 = mysqli_fetch_assoc($sqlprogressresult);
            $totalProgressModule = $row3["Progress"];
            $progressprcnt = ($totalProgressModule * 100) / $totalModule;


            $output .= '<div class="coursediv"  id="coursediv' . $row1["id"] . '">
            <div id="coursenamediv' . $row1["id"] . '" class="coursenamediv">' . $row1["Course"] . '</div>
            <div id="myProgress" class="myProgress">
            <div id="myBar"' . $row1["id"] . '" class="myBar" style="width:' . round($progressprcnt) . '%">' . round($progressprcnt) . '%</div>
          </div>
          <input type="submit" class="profilebtn" id="profilebtn' . $row1["id"] . '" value="Go To Course" onclick="window.location=\'viewcourse.php?id='.$row1["id"].'\'">
            
            </div>';
        }
        
        echo $output;
    } else {
        echo "<h2>No courses enrolled</h2>";
    } 
    
}
$conn->close();
?>