<?php
 session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProProgrammers| Courses</title>
    <style>
        #sec
        {
            display:flex;
            flex-wrap:wrap;
            width:80%;
            justify-content:space-evenly;
        }
        .secdiv
        {
            width: 318px;
            height: 209px;
            display: flex;
            flex-direction:column;
            justify-content: center;
            margin: 58px 15px;
            /* background-color: #acdfdb; */
            align-items: center;
            font-size: 1.5rem;
        }
        .secdiv:hover
        {
            background-color: #dfdfdf;
        }
       
        #courses-section
        {
            display: flex;
        }
        #introdiv
        {
            height: 275px;
            background: linear-gradient(rgba(105, 105, 105, 0.8), rgba(122, 122, 122, 0.8)), url('https://preview.colorlib.com/theme/tutor/images/xhero_bg.jpg.pagespeed.ic.Q-loDQSB2M.webp') no-repeat;
            background-attachment: fixed;
    background-size: 100% 100%;
    width: 100%;
    color: whitesmoke;
    /* padding: 34px; */
    vertical-align: middle;
        }
        #taglines
        {
            position: relative;
            display: inline;
            top: 30%;
            text-align: center;
            transform: translateY(-50%,-50%);
        }
        #taglines h1
        {
            padding-bottom: 9px;
        }
        #leftmenu
        {
            width: 15%;
            margin: 45px;
        }
        .coursepage-btns
        {
            margin-bottom: 23px;
        }
        .coursebtndiv
        {
            margin:28px;
        }
        
        .coursepage-btns button:hover {box-shadow: grey 2px 2px 5px 1px;}

.coursepage-btns button:active {
    transform: scale(1.05);
}

#langlinks a {
    display: block;
    padding: 4px;
    margin: 14px 4px;
    text-decoration: none;
    color: #055c54;
    cursor: pointer;
}
        .coursepage-btns button {
    cursor: pointer;
    margin: 8px;
    padding: 11px;
    background-color: #1eb2a6;
    color: whitesmoke;
    border: none;
    border-radius: 7px;
    /* box-shadow: grey 2px 1px 4px 1px; */
}
.coursebtndiv button
        {
            margin:0px;
            background-color:whitesmoke;
            color:#064e48;
        }
    #langlinks
    {
        margin: 4px;
    }
    #langlinks p
    {
        font-size: 1.4rem;
    /* margin: 4px; */
    margin-bottom: 11px;
    }

    @media screen and (max-width:750px) 
    {
        #courses-section
        {
            flex-direction: column;
        }
        #leftmenu
        {
            width: unset;
            margin: 12px auto 3px auto;
        }
        .coursepage-btns
        {
            margin-bottom: 0px;
        }
        .coursepage-btns button
        {
            margin: 3px;
        }
        #langlinks
        {
            display: none;
        }
        #sec
        {
            width: unset;
        }
    }
    #msg
    {
        color: #eed8d8;
        padding: 7px;
        text-align: center;
        font-size: 1.2rem;
        display: inline-block;
        width: 93%;
    }
    #errormsg span
    {
        float: right; padding: 7px;
        cursor: pointer;
    }
    #errormsg
    {
        background-color: #db2929; 
        display: none; 
        position: sticky;
        top: 50px; 
        z-index: 10;
    }
    </style>
</head>
<body>
    <?php
   

        include "nav.php";
        include "signup.php";
        include "login.php";
        require "_dbconnect.php";
    ?>   
    <div id="errormsg">
        <p id="msg"></p>
        <span onclick="closeError()">&#10006</span>
    </div>
    <div id="introdiv">
        <div id="taglines">
            <h1>Find your area of interest</h1>
            <h3>Multiple options you have for your growth and success</h3>
        </div>
    </div>


    <section id="courses-section">
        <div id="leftmenu">
            <?php
            if($loggedin)
            {
                if($_SESSION["username"]=="admin")
                {
                   
                    echo "<div class='coursepage-btns'>
                    <button onclick='location.href=`writtentutorial.php`'><i class='fal fa-feather-alt'></i> Add New Course</button>
                    
                </div>";
                }
            }
            ?>
            <div id="langlinks">
                <p>Languages</p>
            <?php
                $courseselect=$conn->prepare("SELECT * FROM `courses`");
                $courseselect->execute();
                $courses=$courseselect->get_result();
                if(mysqli_num_rows($courses)>0)
                {
                    while($row=mysqli_fetch_assoc($courses))
                    {
                        $courseid=$row['CourseId'];
                        $coursename=$row['CourseName'];
                        echo "<a class='hoveranimation' id='courselink$courseid' onclick='viewcourse(this)'> $coursename <span>&#8594;</span></a>";
                    }
                }
                
            ?>
        </div>

        </div>

        
        <section id="sec">        
            <?php
                $courseselect=$conn->prepare("SELECT * FROM `courses`");
                $courseselect->execute();
                $courses=$courseselect->get_result();
                if(mysqli_num_rows($courses)>0)
                {
                    while($row=mysqli_fetch_assoc($courses))
                    {
                        $courseid=$row['CourseId'];
                        $coursename=$row['CourseName'];
                        echo "<div class='coursepage-btns secdiv' id='course$courseid'>
                        <strong>$coursename</strong>
                        <div class='coursebtndiv'>
                        <button id='viewcourse$courseid' onclick='viewcourse(this)'>Go To Course</button>
                        <button id='enrollcourse$courseid' onclick='enroll(this)'>Enroll Course</button>
                        </div>
                        </div>";
                    }
                }
                
            ?>
        </section>
    
    </section>
    




    <?php
        include "footer.php";
    ?>
    
    <script src="js/viewcourse.js"></script>
    <script>
        $(document).ready(function ()
        {
            $('.secdiv').each(function(){
                
            let i=parseInt($(this).prop("id").match(/\d+/g),10);
            if(i%2==0)
            {
                $(this).css("background-color","#dbc3bb");
            }
            else if(i%3==0)
            {
                $(this).css("background-color","#a8c5c2");
            }
            else if(i%5==0)
            {
                $(this).css("background-color","#eee891");
            }
            else if(i%6==0)
            {
                $(this).css("background-color","red");
            }
            else if(i%7==0)
            {
                $(this).css("background-color","#eed1d4");
            }
            else
            {
                $(this).css("background-color","#c6f4d7");
            }
        })
        })
        function closeError() {
            $('#errormsg').css("display", "none");
        }
        function enroll(elem)
        {
            let coursesid=parseInt(elem.id.match(/\d+/g),10);
            let action="enroll";
            <?php
            if( $loggedin )
            {
            ?>
                $.ajax({
                    url:"_tutorialsdb.php",
                    type:"POST",
                    data:
                    {
                        action:action,
                        courseid:coursesid,
                        
                    },
                    success:function(data)
                    {
                        if(data==2)
                        {
                            $('#errormsg').css("display", "block");
                            $('#errormsg').css("background-color", "green");
                            $('#msg').text("Congratulations, You have successfully enrolled and can learn a lot :)");
                        }
                        else
                        {
                            $('#errormsg').css("display", "block");
                            $('#errormsg').css("background-color", "red");
                            $('#msg').text("Opps!! Seems like you have already been enrolled :(");
                        }
                    }
                })
               
            <?php  
            }
            else
            {
                ?>
                $('#errormsg').css("display", "block");
                $('#errormsg').css("background-color", "red");
                $('#msg').text("Opps!! You must signin for course enrollment :(");
                <?php
            }
            ?>
        }

    </script>
</body>
</html>