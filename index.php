<?php
session_start();
require "_dbconnect.php";
?>



<!DOCTYPE html>
<html>

<head>
    <title>ProProgrammers</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/home.css">
    <a href="https://icons8.com/icon/54615/course-assign"></a>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

   

</head>

<body onload="goToMission()">
    <!--For about section.Mission and next button appears when page isloaded-->
    <?php

    include 'nav.php';

    ?>
    <?php
    include 'signup.php';
    include 'login.php';
    ?>
     <div id="errormsg">
        <p id="msg"></p>
        <span onclick="closeError()">&#10006</span>
    </div>
    <section id="home">
      

        <div class="innerdivs" id="homebar">
            <p>Welcome to ProProgrammers</p>
            <h3>Free Online Learning Platform For All Those Who Strive</h3>
            <p>
                Ease your learning by joining us. Solve your queries at any stage. Learn by practice and hard work and
                continue to grow.
            </p>
            <button class="homebtn" class="hoveranimation" id="coursebtn" onclick="location.href='courses.php'">View Courses &nbsp;<span>&#8594;</span> </button>
            <button class="homebtn" class="hoveranimation" id="librarybtn" onclick="location.href='library.php'">View Library &nbsp;<span>&#8594;</span></button>
        </div>

        <div class="innerdivs" id="imgdiv">
            <img src="img/homeimg.png" alt="" style="width:100%; height:100%;">
        </div>
    </section>


    <!-- Our Courses Section -->
    <h1 id="ourcourseheading" class="courses_heading">Our Courses</h1>
    <h3 class="taglines">Learn to program a computer, because it teaches you how to think</h3>
    <section id="courses_Section">
        <div class="slidecontainer" id="coursescontainer">
            <div class="slidebox">
                <div class="innerslidebox">
                    <div class="box">
                        <img src="HomeImages/htmlCourse.jpg">
                        <h2>HTML</h2>
                        <p>HTML is the fundamental building block of web pages. When used in conjunction with other technologies
                            like CSS and JavaScript,
                            it creates the vast majority of content seen on websites.
                            HTML is used for a huge variety of things on the web, from building complex websites that offer email
                            and calendar functions
                            to constructing a simple course website or resume.
                        </p>
                    </div>
                    <div class="box">
                        <img src="HomeImages/css.jpg">
                        <h2>CSS</h2>
                        <p>Cascading Style Sheets (CSS) is a simple mechanism for adding style (e.g., fonts, colors, spacing) to Web
                            documents.
                            CSS helps Web developers create a uniform look across several pages of a Web site. Plus, CSS makes it
                            easy to change styles across several pages at once.
                            CSS is great for creating text styles and formatting other aspects of Web page layout as well.</p>
                    </div>
                    <div class="box">
                        <img src="HomeImages/JsCourse.jpg">
                        <h2>JAVASCRIPT</h2>
                        <p>JavaScript is the scripting language of the web which means the source code is processed by the client's
                            web browser rather than on the web server.
                            If you have ever wanted to add simple interactivity to web pages beyond links and without complicated
                            server languages you will want to learn JavaScript.
                            It is supported by all modern browsers.
                        </p>
                    </div>
                </div>
            </div>
            <div class="slidebox">
                <div class="innerslidebox">
                    <div class=" box">
                        <img src="HomeImages/PyhtonCourse.jpg">
                        <h2>PYTHON</h2>
                        <p>Python is a popular programming language,used for a wide variety of applications.
                            Python is a general-purpose coding language—which means that, unlike HTML, CSS, and JavaScript,
                            it can be used for other types of programming and software development besides web development.
                            It includes high-level data structures, dynamic typing, dynamic binding, and many more features
                        </p>
                    </div>
                    <div class="box">
                        <img src="HomeImages/C++.jpg">
                        <h2>C++</h2>
                        <p>C++ is an object-oriented computer language.C++ is pronounced "see-plus-plus." It was developed as a
                            cross-platform improvement of C to provide developers with a higher degree of control over memory and
                            system resources.
                            C++ can be used to develop a broad range of software, applications, browsers,
                            Graphical User Interfaces (GUIs), operating systems, and games.
                        </p>
                    </div>
                    <div class="box">
                        <img src="HomeImages/Java.jpg">
                        <h2>JAVA</h2>
                        <p>Java is a programming language, designed to be concurrent, class-based and object-oriented, as well as a
                            computing platform first released by Sun Microsystems in 1995.
                            An enormous amount of applications and websites will not work unless you have Java installed, and more
                            are created every day. Denying yourself Java is akin to denying yourself access to a technological
                            infrastructure.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="slideshowbtn">
            <button><i id="coursesfirstbtn" class="firstbtn fal fa-horizontal-rule" onclick="first(this.id)"></i></button>
            <button><i id="coursessecondbtn" class="secondbtn fal fa-horizontal-rule" onclick="second(this.id)"></i></button>
        </div>
    </section>
    <div class="divfind">
        <button class="Find" onclick="location.href='courses.php'"><i class="fas fa-search"></i> &nbsp; Find More Courses</button>
    </div>

    <!-- Popular Courses Section -->
    <h1 class="courses_heading">Our Popular Courses</h1>
    <section id="PopularCourses">
        <?php
            $popularcourses=$conn->prepare("SELECT count(enrollment.`CourseId`) as c,enrollment.`CourseId`,courses.`CourseName` FROM `enrollment` INNER JOIN `courses` ON enrollment.`CourseId`=courses.`CourseId` GROUP BY `CourseId` ORDER BY c DESC LIMIT 3");
            $popularcourses->execute();
            $pop=$popularcourses->get_result();
            while($row=mysqli_fetch_assoc($pop))
            {
                $coursename=$row['CourseName'];
                $courseid=$row["CourseId"];
                $quizzes=$conn->prepare("SELECT COUNT(`ModuleId`) as 'no' FROM `module` WHERE `CourseId`=?");
                $quizzes->bind_param('i',$courseid);
                $quizzes->execute();
                $noOfQuiz=$quizzes->get_result();
                while($nrow=mysqli_fetch_assoc($noOfQuiz))
                {
                    $no=$nrow["no"];
                }
                $subtopics=$conn->prepare("SELECT COUNT(`SubtopicId`) as 'SubNO' FROM `subtopics` WHERE `CourseId`=?");
                $subtopics->bind_param('i',$courseid);
                $subtopics->execute();
                $gettopic=$subtopics->get_result();
                while($trow=mysqli_fetch_assoc($gettopic))
                {
                    $subtopicno=$trow["SubNO"];
                }

                
                echo "<div class='box1'>
                <img src='img/courseicon.png'>
              
                
                <h2>$coursename</h2>
                <div>
                    <ul>
                        <li>$subtopicno topics</li>
                        <li>$no quizzez</li>
                        <li>1 assignment</li>
                    </ul>
                </div>
                <button id='homeenroll$courseid' onclick='enroll(this)'><i class='fas fa-user-check'></i> &nbsp;Enroll now!</button>
              
            </div>";
            }

        ?>
        <!-- <div class="box1">
            <img src="HomeImages/python.png">
          
            
            <h2>PYTHON</h2>
            <div>
                <ul>
                    <li>20 videos</li>
                    <li>5 quizzez</li>
                    <li>1 assignment</li>
                    <span>&#9733;&#9733;&#9733;&#9733;&#9733;</span>(5.0)
                </ul>
            </div>
            <button><i class='fas fa-user-check'></i> &nbsp;Enroll now!</button>
          
        </div>
        <div class="box1">
            <img src="HomeImages/javascript.png">
            <h2>JAVASCRIPT</h2>
            <div>
                <ul>
                    <li>20 videos</li>
                    <li>5 quizzez</li>
                    <li>1 assignment</li>
                    <span>&#9733;&#9733;&#9733;&#9733;&#9733;</span>(5.0)
                </ul>
            </div>
            <button><i class="fas fa-user-check"></i> &nbsp; Enroll now!</button>
        </div>
        <div class="box1">
            <img src="HomeImages/html.png">
            <h2>HTML</h2>
            <div>
                <ul>
                    <li>20 videos</li>
                    <li>5 quizzez</li>
                    <li>1 assignment</li>
                    <span>&#9733;&#9733;&#9733;&#9733;&#9733;</span>(5.0)
                </ul>
            </div>
            <button><i class="fas fa-user-check"></i> &nbsp;Enroll now!</button>
        </div> -->
    </section>

    <!-- Our Services Section -->
    <h1 class="courses_heading">Our Services</h1>
    <section id="ourservices">
        <div class="grid-container">
            <!--Make a grid of two columns-->
            <div id="myimage" class="grid-item"><img src="HomeImages/services.jpg"></div>
            <!--First grid item-->
            <div class="grid-item" id="servicesdescription">
                <!--Second grid item-->
                <h4>Become Expert programmer</h4>
                <h1>Ways we provide you in your path of success</h1>
                <div class="serviceslist" id="firstservice">
                    <div class="servicesicon" id="onlinecourses"><i class="fas fa-laptop-code"></i></div>
                    <div class="servicenames">
                        <h3>Online courses</h3>
                        <p>We provide best courses for you to take at home with ease. Written courses and video courses are available so you can take a course as per your learning style.</p>
                    </div>
                </div>
                <div class="serviceslist" id="secondservice">
                    <div class="servicesicon" id="certificate"><i class="fas fa-award"></i></div>
                    <div class="servicenames">
                        <h3>Earn Certificate</h3>
                        <p>Learning and having a record of it is best. We provide you a completion certificate indicating your score and skills so you can progress in your career</p>
                    </div>
                </div>
                <div class="serviceslist" id="thirdservice">
                    <div class="servicesicon" id="practice"><i class="fas fa-user-graduate"></i></div>
                    <div class="servicenames">
                        <h3>Hands-on Practice</h3>

                        <p>Programming is easy but it needs practice. Practice makes man perfect so we provide you a great opportunity to practice more and more.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Library section -->
    <h1 id="ourlibraryheading" class="courses_heading">Library Catalog</h1>
    <h3 class="taglines">When in doubt go to the library</h3>
    <section id="ourlibrary">
        <div class="slidecontainer" id="librarycontainer">
            <div class="slidebox">
                <div class="innerslidebox">
                    <div class="books">
                        <div class="imgdiv">
                            <img src="img/book1.jpg">
                        </div>
                        <p class="insidepadding">
                            <i class="fal fa-book"></i>
                            Data Science from Scratch with Python
                        </p>
                    </div>
                    <div class="books">
                        <div class="imgdiv">
                            <img src="img/book2.jpg">
                        </div>
                        <p class="insidepadding">
                            <i class="fal fa-book"></i>
                            The C++ Programming Language
                        </p>
                    </div>
                    <div class="books">
                        <div class="imgdiv">
                            <img src="img/book3.jpg">
                        </div>
                        <p class="insidepadding">
                            <i class="fal fa-book"></i>
                            Beginning CSS Web Development
                        </p>
                    </div>
                </div>
            </div>
            <div class="slidebox">
                <div class="innerslidebox">
                    <div class="books">
                        <div class="imgdiv">
                            <img src="img/book4.jpg">
                        </div>
                        <p class="insidepadding">
                            <i class="fal fa-book"></i>
                            PHP for Absolute Beginners
                        </p>
                    </div>
                    <div class="books">
                        <div class="imgdiv">
                            <img src="img/book5.jpg">
                        </div>
                        <p class="insidepadding">
                            <i class="fal fa-book"></i>
                            Effective Java
                        </p>
                    </div>
                    <div class="books">
                        <div class="imgdiv">
                            <img src="img/book6.jpg">
                        </div>
                        <p class="insidepadding">
                            <i class="fal fa-book"></i>
                            Foundations of Machine Learning
                        </p>
                    </div>
                </div>
            </div>
        </div>


        <div class="slideshowbtn">
            <button><i id="libraryfirstbtn" class="firstbtn fal fa-horizontal-rule" onclick="first(this.id)"></i></button>
            <button><i id="librarysecondbtn" class="secondbtn fal fa-horizontal-rule" onclick="second(this.id)"></i></button>
        </div>
    </section>
    <div class="divfind">
        <button class="Find" onclick="location.href='library.php'"><i class="fas fa-search"></i> &nbsp; Explore Library</button>
    </div>


    <!-- Success Section -->
    <h1 class="courses_heading">Our Success</h1>
    <section class="success-section " id="success">
        <div class="success-items-left">
            <div>
                <img src="HomeImages/success-courses.png" id="courses-icon">
            </div>
            <div>
                Courses
            </div>
            <div id="courses-counter">
                <!--Div for total number-->
            </div>

        </div>

        <div class="success-items-right">

            <div>
                <img src="HomeImages/success-students.png" id="students-icon">
            </div>
            <div>
                Students Enrolled
            </div>
            <div id="students-counter">
                <!--Div for total number-->
            </div>

        </div>

        <div class="success-items-left">

            <div>
                <img src="HomeImages/success-books.png" id="books-icon">
            </div>
            <div>
                Books
            </div>
            <div id="books-counter">
                <!--Div for total number-->
            </div>

        </div>
        <div class="success-items-right">
            <div>
                <img src="HomeImages/success-cerificate.png" id="certificate-icon"></i>
            </div>
            <div>
                Certificates issued
            </div>
            <div id="certificate-counter">
                <!--Div for total number-->
            </div>
        </div>
    </section>

    <!-- About Us Section -->
    <h1 class="courses_heading">About Us</h1>
    <section id="aboutus">
        <button id="next" class="prev_next_btn" onclick="goToVision()">&raquo;</button>
        <div id="missiondiv" class="mission_vision">
            <h3>Our Mission</h3><br>Our mission is to provide beginners a written example and a perfect explanation.
            All the practice that a developers needs will be provided and a feature to establish a developer community will be created.
        </div>
        <button id="prev" class="prev_next_btn" onclick="goToMission()">&laquo;</button>
        <div id="visiondiv" class="mission_vision">
            <h3>Our Vision</h3><br>
            To be the platform where new software developers can become a profficient programmer by using all the tools they need for their skills.
        </div>
    </section>

    <!-- COntact section -->
    <section id="contact">
        <div>
            <h1 style="font-size: 1.7em;">Have any queries or Want to give feedback</h1>
            <p style="font-size: 1.3em;">mail us or visit our pages</p>
        </div>

        <div>

            <div style="display: inline-block;">
                <i class="btnicon far fa-envelope-open-text"></i>
                <a href="mailto:proprogrammers.world@gmail.com">Mail Us: proprogrammers.world@gmail.com</a>
            </div>
            <div style="display: inline-block;">
                <button class="pagebtn" title="facebook/proprogrammers"><i class="btnicon fab fa-facebook-f"></i></button>
                <button class="pagebtn" title="instagram/proprogrammers"><i class="btnicon fab fa-instagram"></i></button>
                <button class="pagebtn" title="linkedin/proprogrammers"><i class="btnicon fab fa-linkedin-in"></i></button>
            </div>
        </div>
    </section>

    <?php
        include 'footer.php';
    ?>




    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/home.js"></script>

    <script>

    
        //jquery part To start Counter of Success when success div is viewed on scroll
        $(document).ready(function() {

            var scroll = false; // set the variable to false on page load
            var successDivPosition = $('#success').offset().top; //calculate the position of success section from start to its margin top 
            var totalScreenHeight = $(window).height(); //calculate the total screen height of laptop/window
            var activation_offset = 0.5; //determines how far up the the page the element needs to be before triggering the function
            var activation_point = successDivPosition - (totalScreenHeight * activation_offset); //calculate the activtion point so that the counter starts when half of the  success section is viewed on the screen
            var max_scroll_height = $('body').height() - totalScreenHeight - 5; //calculate the maxixmum height left to scroll
            //-5 for a little bit of buffer of images or other things that takes time to load
            //body.height returns the heught of whole web page.

            $(window).on('scroll', function() { //function runs when user scrolls to success section or when user directly go to the botton of page

                var y_scroll_pos = window.pageYOffset; //calculate how mush user scrolled vertically
                var element_in_view = y_scroll_pos > activation_point; //return true when user scroll more than the halfo of success section(activation point) 

                // var has_reached_bottom_of_page = max_scroll_height <= y_scroll_pos && !element_in_view;

                if (scroll == false) { //to not run the function once it loads
                    if (element_in_view) { //if user reached the success section
                    <?php
                        $courses=$conn->prepare("SELECT count(`CourseId`) as 'c1' FROM `courses`");
                        $courses->execute(); 
                        $cresult=$courses->get_result(); 
                        if(mysqli_num_rows($cresult)>0)
                        {
                            $row=mysqli_fetch_assoc($cresult);
                            $courseNo=$row["c1"];
                        }
                        else
                        {
                            $courseNo=0;
                        }
                        echo "startCounterOnScroll(0, $courseNo, document.getElementById('courses-counter'));";

                        $students=$conn->prepare("SELECT COUNT(`username`) as 'c2' FROM `enrollment`");
                        $students->execute();
                        $sresult=$students->get_result();
                        if(mysqli_num_rows($sresult)>0)
                        {

                            $row1=mysqli_fetch_assoc($sresult);
                            $studentsNo=$row1["c2"];
                        }
                        else
                        {
                            $studentsNo=0;
                        }         
                        echo "startCounterOnScroll(0, $studentsNo, document.getElementById('students-counter'));";
                        
                        
                        $certificate=$conn->prepare("SELECT COUNT(`Certification`) as 'c3' FROM `enrollment`");
                        $certificate->execute();
                        $ceresult=$certificate->get_result();
                        if(mysqli_num_rows($ceresult)>0)
                        {
                            $row2=mysqli_fetch_assoc($ceresult);

                            $certificateNo=$row2["c3"];
                        }
                        else
                        {
                            $certificateNo=0;
                        }                 
                        echo "startCounterOnScroll(0, $certificateNo, document.getElementById('certificate-counter'));";
                        
                        
                        $books=$conn->prepare("SELECT COUNT(`Sno`) as 'c4' FROM `books`");
                        $books->execute();
                        $bresult=$books->get_result();
                        if(mysqli_num_rows($bresult)>0)
                        {
                            $row3=mysqli_fetch_assoc($bresult);

                            $booksNo=$row3["c4"];
                        }
                        else
                        {
                            $booksNo=0;
                        }
                        echo "startCounterOnScroll(0, $booksNo, document.getElementById('books-counter'));";
                    ?>
                    }
                }
            });

            function startCounterOnScroll($startCount, $endCount, $targetDiv) { //Animate Counter function for success
                $({
                    countNum: $startCount //starting value
                }).animate({
                    countNum: $endCount //ending value
                }, {
                    duration: 1000, //time to increase the count
                    easing: 'linear', //to move at constant speed
                    step: function() {
                        // What todo on every count
                        $($targetDiv).text(Math.ceil(this.countNum)) //target div represents the counter div
                        // step function runs on each animated leement after each animation
                    },
                    complete: function() {
                        scroll = true; //done after animation is done because we dont want to again triggger the function before loading th epage.
                    }
                });
            }


            // Jquery for changing colours  on hovering Our Services icons

            $("#firstservice").hover(function() {
                $(".fa-laptop-code").css("color", "white");
            }, function() {
                $(".fa-laptop-code").css("color", "#1eb2a6");
            })

            $("#secondservice").hover(function() {
                $(".fa-award").css("color", "white");
            }, function() {
                $(".fa-award").css("color", "#1eb2a6");
            })

            $("#thirdservice").hover(function() {
                $(".fa-user-graduate").css("color", "white");
            }, function() {
                $(".fa-user-graduate").css("color", "#1eb2a6");
            })
        });
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

        //Javascript for About us section
        //To move from mission to vision and vicecers
        function goToMission() { //Function runs on page load and when previous button clicks
            document.getElementById("missiondiv").style.display = "block";
            document.getElementById("visiondiv").style.display = "none";
            document.getElementById("next").style.display = "inline";
            document.getElementById("prev").style.display = "none";
        }

        function goToVision() { //Function runs when next button clicks
            document.getElementById("visiondiv").style.display = "block";
            document.getElementById("missiondiv").style.display = "none";
            document.getElementById("next").style.display = "none";
            document.getElementById("prev").style.display = "block";
        }

    </script>



</body>

</html>