<?php

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $loggedin = true;
} else {
    $loggedin = false;
} ?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet">
    <title>ProProgrammers</title>

    <style>

    </style>
</head>

<body>


    <div id="topbox">

        <div id="innertopbox">

            <div id="title">
                <h3>ProProgrammers</h3>
                <p>ALGORITHM OF SUCCESS</p>
            </div>
            <?php

if ($loggedin) {
?>

    <?php if ((isset($_SESSION["loggedinwithgoogle"]) && $_SESSION["loggedinwithgoogle"] == true)) { ?>

        <!-- <img src="" style="border-radius:50%;width:100px;height:10px;"> -->
        <!--  ?>echo $_SESSION['userimage'];  -->
    <?php
    } else {

        $first = $_SESSION["username"];
        $char = strtoupper($first[0]);
    ?>
        <div id="profilebar" style="float: right;"><?php echo $char ?></div>
        <br>
     
<?php
    }
}

?>

            <button id="menubtn" onclick="menuvisible()"><i class="fas fa-bars"></i></button>
            <?php
            if (!$loggedin) {
                echo "<div class='innerdiv' id='users'>
               
                <button class='btn userbtn' id='login-btn' onclick='openModal(`login-modal`)'><i class='fal fa-user-lock'></i> Login</button>
                <button class='btn userbtn' id='signup-btn' onclick='openModal(`signup-modal`)'><i class='fal fa-lock-alt'></i> Register</button>
            </div>";
            } ?>

            <div class="innerdiv" id="pages">
            <?php
                if($loggedin)
                {

                   echo "<button class='pagebtn' id='chatbtn' title='Chat Section' onclick='location.href=`chat.php`'><i class='btnicon far fa-comments'></i></button>
                    <button class='pagebtn' id='assbtn' title='Assignment Section' onclick='location.href=`Assignment Rating.php`'><i class='btnicon far fa-link'></i></button>
                    <button class='pagebtn' id='notebtn' title='Notes Keeping' onclick='location.href=`inotes.php`'><i class='btnicon far fa-sticky-note'></i></button>";
                }
                ?>
                <button class="pagebtn"><i class="btnicon fab fa-facebook-f"></i></button>
                <button class="pagebtn"><i class="btnicon fab fa-instagram"></i></button>
                <button class="pagebtn"><i class="btnicon fab fa-linkedin-in"></i></button>
                <button class="pagebtn"><i class="btnicon far fa-envelope-open-text"></i></button>

                 <!-- <button class="pagebtn"><b><i class="btnicon bi bi-clipboard-check"></i></b></button> -->
                
                <?php
                
                if ($loggedin) {
                    ?>
                    <!-- <button class="btn userbtn"><a href="logout.php">Logout</a></button>

                    <img src="<?php echo $_SESSION['userimage']; ?>" style="border-radius:50%;width:30px;height:30px;" onclick="showProfile()"> -->
                <?php
                }

                ?>

               


            </div>

            <!-- <div class="innerdiv" id="users"> -->



        </div>
        <div id="mobilemenu">
            <div class="innerdiv links" id="mobilelinks">
                <a href="index.php#home">Home</a>
                <a href="index.php#explore">About</a>
                <a href="courses.php">Courses</a>
                <a href="library.php">Library</a>
                <a href="index.php#ourservices">Services</a>
                <a href="index.php#contact">Contact</a>

            </div>
            <div class="innerdiv searchdiv">
                <form action="searchresult.php" method="post">
                <input type="text" name="searchmenu" class="search" style="width: 190px;font-size: 1.2rem;padding: 12px;">
                <button type="submit" class="pagebtn searchit" id="searchit"><i class="far fa-search"></i></button>
            </form>
            </div>
            
        </div>
    </div>
    <div class="profilediv">
            <ol>
                <li><?php echo $first ?></li>
                <li><a href="profile.php">My Learning</a></li>
                <li><a href="logout.php">Logout</a>
                </li>
            </ol>

        </div>


    <header>
        <nav id="homenav">
            <div class="innerdiv links">
                <a href="index.php#home">Home</a>
                <a href="index.php#explore">About</a>
                <a href="courses.php">Courses</a>
                <a href="library.php">Library</a>
                <a href="index.php#ourservices">Services</a>
                <a href="index.php#contact">Contact</a>
            </div>
            <div class="innerdiv searchdiv" style="float: right;">
            <form action="searchresult.php" method="post">
                <input type="text" name="searchmenu" class="search" style="width: 190px; float: left;font-size: 1.2rem;padding: 12px;">
                <button type="submit" class="pagebtn searchit" id="bsearchit"><i class="far fa-search"></i></button>
            </form>
            </div>
        </nav>
    </header>




    <script src="js/jquery-3.6.0.min.js "></script>
    <!-- <script src="signup.js"></script> -->
    <script>
        $(document).ready(function() {
            $("#profilebar").click(function() {

                $(".profilediv").toggleClass("main");
            });

            <?php
    
    if(!$loggedin)
    {?>
        $('#pages').css("margin","15px 0px");
        $('#menubtn').css("bottom","0px");
        $('#menubtn').css("top","5px");
<?php 
    }
    ?>
        });

        function searchbar() {
            $('#bsearchit').css("display", "inline");
            $('.search').css("width", "190px");
            $('.search').css("visibility", "visible");
            $('.search').css("transition", "all 0.7s");
            $('#bsearchbtn').css("display", "none");
        }

        function searched() {
            $('#bsearchbtn').css("display", "inline");
            $('#bsearchit').css("display", "none");
            $('.search').css("visibility", "hidden");
            $('.search').css("width", "0px");
            // location.href="_searchdata.php";
            var searchvalue=$('#searchmenu').val();
            
        }

        function menuvisible() {
            $('#mobilemenu').slideToggle('slow');
        }

        function fun(switchlocation) {
            var userdiv = $('#users');
            var div = $('#mobilelinks');
            var btns = $('.userbtn');
            var chatbtn=$('#chatbtn');
            var assbtn=$('#assbtn');
            var notebtn=$('#notebtn');
            if (switchlocation.matches) {
                div.append(btns);
                btns.css("display", "block");
                btns.css("width","100%");
                btns.css("margin", "auto");
                btns.css("color","teal");
                btns.hover(function() {
                    $(this).css("color","whitesmoke");
                    $(this).css("background-color","teal");
                },function (){
                    $(this).css("color","teal");
                    $(this).css("background-color","#f6f6f6");
                });
                div.append(chatbtn);
                div.append(assbtn);
                div.append(notebtn);
            } else {
                userdiv.append(btns);
                btns.css("display", "inline");
                btns.css("width", "unset");
                btns.css("background-color", "inherit");
                btns.hover(function(){
                    $(this).css("background-color","teal");
                },function(){
                    $(this).css("background-color", "inherit");
                });
                $('#pages').append(chatbtn);
                $('#pages').append(assbtn);
                $('#pages').append(notebtn);
                // btns.unbind(hover);
            }
        }
        var switchlocation = window.matchMedia("(max-width:570px");
        fun(switchlocation);
        switchlocation.addListener(fun);

        var sl = window.matchMedia("(min-width:901px");
        displayfun(sl);
        sl.addListener(displayfun);

        function displayfun(sl) {
            if (sl.matches) {

                $('#mobilemenu').css("display", "none");
            }
        }

        
    </script>
</body>

</html>