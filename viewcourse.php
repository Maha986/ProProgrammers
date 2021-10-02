<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/tutorials.css">
    <link rel="stylesheet" href="css/singup.css">
    <link rel="stylesheet" href="css/viewcourse.css">
    <title>ProProgrammers|</title>


</head>

<body>
    
    <?php
    include "nav.php";
    include "signup.php";
    include "login.php";
    ?>
    <div id="errormsg">
        <div style="display:flex">
        <p id="msg"></p>
        <span onclick="closeError()">&#10006</span>
        </div>
    </div>
    <section id="mainpage">
        <section id="navigation">
            <ul class="moduleul">

            </ul>
        </section>

    </section>


    <?php

    include "footer.php";
    ?>
    <script src="js/viewcourse.js"></script>
    <script>
        $(document).ready(function() {


            const urlSearchParams = new URLSearchParams(window.location.search);
            const params = Object.fromEntries(urlSearchParams.entries());
            let courseid = params['id'];
            let action = "viewcourse";
            $.ajax({
                url: "_viewcoursedb.php",
                type: "POST",
                data: {
                    action: action,
                    courseid: courseid,
                },
                success: function(data) {
                    $('#mainpage').append(data);
                    $('[id^=module],[id^=topic],[id^=sub-topic]').css("font-weight", "bold");
                    $('[id^=course]').css("font-size", "2rem");
                    $(document).prop("title", "ProProgrammers| " + $('[id^=course]').first().text());
                    <?php if($loggedin) {?>
                    $('#notespage').append(`<div style='padding:2px;background-color:#1eb2a6;color:white;text-align:center;display:flex;flex-direction:column;align-items:center;justify-content:center;height:120px;font-size: 1.1rem;
                    margin: 28px;'><div style='height:34px;'><i class='far fa-external-link-alt' style='cursor:pointer;' onclick='location.href="inotes.php"'></i></div><p>NOTES KEEPING SECTION</p></div><div style='padding:px;background-color:#1eb2a6;color:white;text-align:center;display:flex;flex-direction:column;align-items:center;justify-content:center;height:120px;font-size: 1.1rem;
                    margin: 28px;'><div style='height:34px;'><i class='far fa-external-link-alt' style='cursor:pointer;' onclick='location.href="Assignment Rating.php"'></i></div><p style="padding:0px 5px;">ASSIGNMENT REVIEW SECTION</p></div><div style='padding:px;background-color:#1eb2a6;color:white;text-align:center;display:flex;flex-direction:column;align-items:center;justify-content:center;height:120px;font-size: 1.1rem;
                    margin: 28px;'><div style='height:34px;'><i class='far fa-external-link-alt' style='cursor:pointer;' onclick='location.href="chat.php"'></i></div><p>CHAT SECTION</p></div><div style='padding:px;background-color:#1eb2a6;color:white;text-align:center;display:flex;flex-direction:column;align-items:center;justify-content:center;height:120px;font-size: 1.1rem;
                    margin: 28px;'><div style='height:34px;'><i class='far fa-external-link-alt' style='cursor:pointer;' onclick='location.href="FAQ.php"'></i></div><p>FAQ SECTION</p></div>`);
                    <?php }
                    else
                    { ?>
                    $('#notespage').append(`<div style='position:fixed;
    align-items: center;justify-content: center;
    display: flex; height:30vh;padding:2px;background-color:#1eb2a6;color:white;text-align:center;font-size: 1.1rem;margin-top: 28px;'><p><b>Learning</b> is more effective when it is <b>Active</b> rather than passive process.</p></div>`);

                    <?php }?>
                }
            })

      
        });

        function enroll()
        {
            let courseid=parseInt($('[id^=course]').attr("id").match(/\d+/g),10);
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
                        courseid:courseid,
                        
                    },
                    success:function(data)
                    {
                        if(data==2)
                        {
                            $('#errormsg').css("display", "block");
                            $('#errormsg').css("background-color", "green");
                            $('#msg').text("Congratulations, You have successfully enrolled and can learn a lot :)");
                            if($('#errormsg button').length)
                            {
                                $('#errormsg button').remove();
                            }
                        }
                        else
                        {
                            $('#errormsg').css("display", "block");
                            $('#errormsg').css("background-color", "#db2929");
                            $('#msg').text("Opps!! Seems like you have already been enrolled :(");
                            if($('#errormsg button').length)
                            {
                                $('#errormsg button').remove();
                            }
                        }
                    }
                })
               
            <?php  
            }
            else
            {
                ?>
                $('#errormsg').css("display", "block");
                $('#errormsg').css("background-color", "#db2929");
                $('#msg').text("Opps!! You must signin for course enrollment :(");
                <?php
            }
            ?>
        }



        function submitquiz() {
            <?php if ($loggedin) { ?>
                let courseid = parseInt($('[id^=course]').attr("id").match(/\d+/g), 10);
                let moduleid = parseInt($('[id^=headingquiz]').attr("id").match(/\d+/g), 10);

                if (($('#quiz-form').serialize().split('&').length) < 5) {
                    $('#errormsg').css("display", "block");
                    $('#errormsg').css("background-color", "#db2929");
                    $('#msg').text("Opps!! Seems like you missed some mcqs :(");
                    if($('#errormsg a').length)
                    {
                        $('#errormsg a').remove();
                    }
                } else {
                    action = "quizsubmit";

                    $.ajax({

                        url: '_viewcoursedb.php',
                        type: 'POST',
                        data: $('#quiz-form').serialize() + "&action=" + action + "&courseid=" + courseid + "&moduleid=" + moduleid,
                        success: function(data) {
                            console.log(data);
                            if (data == 2) {
                                $('#errormsg').css("display", "block");
                                $('#errormsg').css("background-color", "#db2929");
                                $('#msg').text("Opps!! You must be enrolled to submit the quiz :(");
                                $('#errormsg').append(`<button style="display:block;" onclick="enroll()">Enroll Now</button>`);

                            } else if (data == 1) {
                                $('#errormsg').css("display", "block");
                                $('#errormsg').css("background-color", "#db2929");
                                $('#msg').text("Opps!! You have already submitted this quiz :(");
                                if($('#errormsg a').length)
                                {
                                    $('#errormsg a').remove();
                                }
                            } else {
                                console.log(data);
                                $('#center').append(data);
                                $('#errormsg').css("display", "none");
                                if($('#errormsg a').length)
                                {
                                    $('#errormsg a').remove();
                                }
                            }
                        }
                    });
                }

            <?php
            } else { ?>
                $('#errormsg').css("display", "block");
                $('#errormsg').css("background-color", "#db2929");
                $('#msg').text("Opps!! You must be loggedin to submit the quiz :(");
            <?php } ?>
        };


        function submitass() {
            <?php if ($loggedin) { ?>
                let courseid = parseInt($('[id^=course]').attr("id").match(/\d+/g), 10);


                action = "assignmentsubmit";
                assurl = $('#pasteurl input').val();
                if (assurl == "") 
                {
                    $('#errormsg').css("display", "block");
                    $('#errormsg').css("background-color", "#db2929");
                    $('#msg').text("Opps!! You must add your assignment url :(");
                    if($('#errormsg button').length)
                    {
                        $('#errormsg button').remove();
                    }

                } 
                else if(!(assurl.endsWith("/") && assurl.startsWith("https://jsfiddle.net")))
                {
                    $('#errormsg').css("display", "block");
                    $('#errormsg').css("background-color", "#db2929");
                    $('#msg').text("Opps!! Your assignment url must be of fiddle.net and a complete url :(");
                    if($('#errormsg button').length)
                    {
                        $('#errormsg button').remove();
                    }
                }
                else {
                    $.ajax({

                        url: '_viewcoursedb.php',
                        type: 'POST',
                        data: {
                            action: action,
                            courseid: courseid,
                            assurl:assurl,
                        },
                        dataType:"html",
                        success: function(data) {
                            console.log(data);
                            if (data == 2) {
                                if($('#errormsg button').length)
                                {
                                    $('#errormsg button').remove();
                                }
                                $('#errormsg').css("display", "block");
                                $('#errormsg').css("background-color", "#db2929");
                                $('#msg').text("Opps!! You must be enrolled to submit the assignment :(");
                                $('#errormsg').append(`<button style="display:block;" onclick="enroll()">Enroll Now</button>`);

                            } else if (data == 1) {
                                $('#errormsg').css("display", "block");
                                $('#errormsg').css("background-color", "#db2929");
                                $('#msg').text("Opps!! You have already submitted this assignment :(");
                                if($('#errormsg button').length)
                                {
                                    $('#errormsg button').remove();
                                }
                            } else {
                                
                                $('#errormsg').css("display", "block");
                                $('#pasteurl input').css("disabled",true);
                                if($('#errormsg button').length)
                                {
                                    $('#errormsg button').remove();
                                }
                                $('#errormsg').css("background-color","green");
                                $('#msg').text("Hurrah!! Your assignment have been submitted and will be reviewed shortly :)");
                            }
                        }
                    });

                }
            <?php
            } else { ?>
                $('#errormsg').css("display", "block");
                $('#errormsg').css("background-color", "#db2929");
                $('#msg').text("Opps!! You must be loggedin to submit the assignment :(");
            <?php } ?>
        };


        $('.moduleul').on('click', function(e) {
            var $t = $(e.target).closest('a'),
                $ul = $t.nextAll('ul').eq(0);
            if ($t.length && $ul.length) {
                // $ul.toggleClass('open').slideToggle(350);
                if ($ul.is(':visible')) {
                    $ul.slideUp();
                    $(e.target).prev().removeClass('fas fa-caret-up').addClass('fas fa-caret-down');
                } else {
                    $ul.slideDown();
                    $(e.target).prev().removeClass('fas fa-caret-down').addClass('fas fa-caret-up');

                }
            }
        });
        var sl = window.matchMedia("(min-width:971px");
        displayfun(sl);
        sl.addListener(displayfun);

        function displayfun(sl) {
            if (sl.matches) {

                $('#navigation').css("width", "300px");
                $('#navigation').css("width", "unset");
                $('#navigation').css("display", "block");
            }
        }
        var sl2 = window.matchMedia("(max-width:970px");
        displayfun(sl2);
        sl2.addListener(displayfun2);

        function displayfun2(sl2) {
            if (sl2.matches) {

                $('#navigation').css("width", "0px");
                $('#navigation').css("display", "none");
            }
        }

        function closeError() {
            $('#errormsg').css("display", "none");
        }
    </script>

</body>


</html>