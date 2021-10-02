<?php session_start() ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/profile.css">
    
    <title>ProProgrammers| <?php echo $_SESSION["username"] ?> Profile</title>
</head>

<body onload="maintainProfile()">
    <?php include "nav.php";

    include "signup.php";
    include "login.php";
    require "_dbconnect.php"; ?>
    <div id="user-profile">
        <h1><?php if($loggedin){echo ucwords($_SESSION["username"]);} ?></h1>
        <div id="profile-div"><input title="write your skils here" type="text" name="myprofile" placeholder="Html|CSS|JS" id="myprofile" required>&nbsp;<i class="fas fa-check-double" style="color:green;cursor:pointer;" onclick="saveProfile()"></i></div>
        <div id="show-profile">
            <p>Edit your profile</p> &nbsp<i class="fas fa-user-edit" onclick="editProfile()"></i>
        </div>
    </div>

    <hr>
    <h1 style="margin: 30px;text-align:center">Enrolled Courses</h1>

    <div id="enrolled-courses" style='justify-content:center'>
    </div>
</body>
<script>
   

    <?php if ($loggedin) { ?>

        function editProfile() {
            $("#show-profile").css("display", "none");
            $("#profile-div").css("display", "block");
            var action = "maintainProfile";
            $.ajax({
                url: "dbcon.php",
                type: "POST",
                data: {

                    action: action,
                },
                success: function(data) {
                    if (data == 0) {
                        $("#profile-div").css("display", "block");
                    } else {
                        $("#profile-div input").val(data);

                    }

                }

            })
        }

        function saveProfile() {
            var skills = $.trim($("#myprofile").val());
            if (skills.length == 0) {
                $("#profile-div").css("display", "none");
                $("#show-profile").css("display", "block");
            } else {
                var action = "submitProfile";
                $.ajax({
                    url: "dbcon.php",
                    type: "POST",
                    data: {
                        skills: skills,
                        // usernameForResendingCode: usernameForResendingCode,
                        action: action,
                    },
                    success: function(data) {

                        if (data == 0) {
                            $("#profile-div").css("display", "none");
                            $('#show-profile').children('p').text(skills);

                            $("#show-profile").css("display", "block");

                        } 

                    }

                })
            }


        }



        function maintainProfile() {

            var action = "maintainProfile";
            $.ajax({
                url: "dbcon.php",
                type: "POST",
                data: {
                    action: action,
                },
                success: function(data) {

                    if (data == 0) {

                        $("#show-profile").css("display", "block");

                    } else {
                        $('#show-profile').children('p').text(data);
                        $("#show-profile").css("display", "block");
                    }

                }

            })
            var action = "maintaincourse";
            $.ajax({
                url: "dbcon.php",
                type: "POST",
                data: {
                    action: action,
                },
                success: function(data) {
                    $("#enrolled-courses").html(data);
                }
            })

        }
    <?php } else {
    ?>
        location.href = "index.php";
    <?php } ?>

    $(document).ready(function(){
        $('.coursediv').each(function(){
            if($(this).css("background-color")=="rgba(0, 0, 0, 0)")
            {
                $(this).css("background-color","#eed1d4");
            }
        })
    })
</script>

</html>