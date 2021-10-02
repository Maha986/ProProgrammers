<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/tutorials.css">
    <link rel="stylesheet" href="css/singup.css">
    <title>ProProgrammers| Add Written Course</title>
</head>

<body>
    <?php
       
        include "nav.php";
        include "login.php";
        include "signup.php";
    ?>
<div id='myvideoModal' class='modal'> 

<!-- Modal content -->
<div class='modal-content'>
    <span onclick='closeuploadvideo()' class='closevideo'>&times;</span>
    <div>
        <iframe id='left_side' name='left_side' src="" width='100%' height='350px' frameBorder='0'></iframe>
    </div>
</div>
</div>

    <div id="errormsg">
        <p id="msg"></p>
        <span onclick="closeError()">&#10006</span>
        <button id="yes" style="display: none; float: right;">Yes</button>
        <button id="no"  style="display: none; float: right;">Cancel</button>
    </div>
    <button id='hamburger' onclick='opensidebar()'><i class='far fa-bars'></i></button>
        <h1 style="text-align:center; margin:20px;">When you learn, teach, when you get, give</h1>
   
    <div id="main-page">
        <div id="navigation-menu">
        <button id='navclose' onclick='closenav()'><i class='fas fa-times'></i></button>
            <ul class="moduleul">

            </ul>
        </div>
        <div id="right-side">
            <section id="newpage">
            
                <div id="title-of-course">
                    <label for="course">
                        <h3 style="display:inline;">Course Title: </h3>
                    </label>
                    <input class="course-material" type="text" id="course" style="display:inline;"
                        placeholder="HTML, CSS, etc" required>
                </div>
               
                <section id="content-section">
                    <input class="course-material" type="text" id="module1" placeholder="Module Name: Overview">
                    <input class="course-material" type="text" id="topic1" placeholder="Topic Name: What is HTML?">
                    <div class="btnsdiv">
                        <div class="textarea-buttons right" id="main-topic-btn">
                            <button id="headsave1" onclick="headSave(this)">Save</button>
                            <button id="headedit1" onclick="headEdit(this)" style="display:none;">Edit</button>
                            <button id="headchanges1" onclick="headChanges(this)" style="display:none;">Save Changes</button>
                        </div>
                        <br><br>
                    </div>

                    <div class="main-description" id="main-desc1">
                        <input class="course-material" type="text" id="sub-topic1"
                            placeholder="Sub-heading: History of HTML">
                        <!-- <br> -->
                        <div class="description-details">
                            <textarea class="course-material description-box" id="description1" cols="30" rows="6"
                                placeholder="The first version of HTML was written by Tim Berners-Lee in 1993. Since then, there have been many different versions of HTML. The most widely used version throughout the 2000's was HTML 4.01, which became an official standard in December 1999. Another version, XHTML, was a rewrite of HTML as an XML language!"></textarea>

                            <div class="description-details code-detail" id="codemaindiv1">
                                <div class="codesnippet code">
                                    <button class="codecopy" id="copybtn1" onclick="copy(this)">
                                        <i class="fal fa-copy"></i>
                                    </button>
                                    <textarea cols="30" rows="6" id="code1"
                                        placeholder="print('Hello World')"></textarea>
                                </div>
                                <div class="codesnippet">
                                    <textarea cols="30" rows="6" id="output1" placeholder="Hello World"></textarea>
                                </div>

                            </div>
                            <div class="textarea-buttons right" id="btndiv1">
                                <button class="savebtn" id="save1" onclick="save(this)">Add other sub-topic</button>
                                <button class="saveedit" id="saveedit1" onclick="saveEdit(this)">Save Changes</button>
                                <button class="snippetbtn" id="snippetbtn1" onclick="addsnippet(this)">Add code
                                    snippet</button>
                                <button class="editbtn" id="editing1" onclick="editSubTopic(this)">Edit
                                    Sub-topic</button>
                            </div>
                            <br><br>
                        </div>
                    </div>
                </section>
                <section id="btn-section">
                    <div class="textarea-buttons right">
                        <div class="additiondiv">
                            <button onclick="addtopic()">Add Another topic</button>
                            <button onclick="addmodule()">Add Another Module</button>
                        </div>
                        <div class="right">
                            <button onclick="addassignment()">Add Assignment</button>
                        </div>
                    </div>
                </section>

                <div id="quiz-modal" class="modal">
                    <!-- Modal content -->
                    <div class="modal-content">
                        <div class="modal-header">

                        </div>
                        <div class="modal-body">
                            <div style="display: flex;
                            justify-content: center;
                            flex-wrap: wrap;">
                                <div style="margin-right: 10px;">
                                    <img src="img/quizclip-removebg-preview.png" style="height: 62px;
                                width: 62px;" alt="">
                                </div>
                                <div>
                                    <h2 id="quizmoduleid">Module name</h2>
                                    <h4>Quiz to test the knowledge of learners</h4>
                                </div>
                            </div>
                            <div>
                                <form method="POST" id="quiz-form" style="margin-top: 28px;">
                                    <h4>MCQ-1</h4>
                                    <input type="text" name="mcq1" id="mcq1" placeholder="Your question goes here:"
                                        required>
                                    <label for="opt1mcq1">Option 1</label>
                                    <input name="opt1mcq1" type="text" required>
                                    <label for="opt2mcq1">Option 2</label>
                                    <input type="text" name="opt2mcq1" required>
                                    <label for="opt3mcq1">Option 3</label>
                                    <input type="text" name="opt3mcq1" required>
                                    <label for="opt4mcq1">Option 4</label>
                                    <input type="text" name="opt4mcq1" required>
                                    <label for="correctoptmcq1">Correct Option</label>
                                    <input type="text" name="correctoptmcq1" required>
                                    <h4>MCQ-2</h4>
                                    <input type="text" name="mcq2" placeholder="Your question goes here:" required>
                                    <label for="opt1mcq2">Option 1</label>
                                    <input type="text" name="opt1mcq2" required>
                                    <label for="opt2mcq2">Option 2</label>
                                    <input type="text" name="opt2mcq2" required>
                                    <label for="opt3mcq2">Option 3</label>
                                    <input type="text" name="opt3mcq2" required>
                                    <label for="opt4mcq2">Option 4</label>
                                    <input type="text" name="opt4mcq2" required>
                                    <label for="correctoptmcq2">Correct Option</label>
                                    <input type="text" name="correctoptmcq2" required>
                                    <h4>MCQ-3</h4>
                                    <input type="text" name="mcq3" placeholder="Your question goes here:" required>
                                    <label for="opt1mcq3">Option 1</label>
                                    <input type="text" name="opt1mcq3" required>
                                    <label for="opt2mcq3">Option 2</label>
                                    <input type="text" name="opt2mcq3" required>
                                    <label for="opt3mcq3">Option 3</label>
                                    <input type="text" name="opt3mcq3" required>
                                    <label for="opt4mcq3">Option 4</label>
                                    <input type="text" name="opt4mcq3" required>
                                    <label for="correctoptmcq3">Correct Option</label>
                                    <input type="text" name="correctoptmcq3" required>
                                    <h4>MCQ-4</h4>
                                    <input type="text" name="mcq4" placeholder="Your question goes here:" required>
                                    <label for="opt1mcq4">Option 1</label>
                                    <input type="text" name="opt1mcq4" required>
                                    <label for="opt2mcq4">Option 2</label>
                                    <input type="text" name="opt2mcq4" required>
                                    <label for="opt3mcq4">Option 3</label>
                                    <input type="text" name="opt3mcq4" required>
                                    <label for="opt4mcq4">Option 4</label>
                                    <input type="text" name="opt4mcq4" required>
                                    <label for="correctoptmcq4">Correct Option</label>
                                    <input type="text" name="correctoptmcq4" required>
                                    <h4>MCQ-5</h4>
                                    <input type="text" name="mcq5" placeholder="Your question goes here:" required>
                                    <label for="opt1mcq5">Option 1</label>
                                    <input type="text" name="opt1mcq5" required>
                                    <label for="opt2mcq5">Option 2</label>
                                    <input type="text" name="opt2mcq5" required>
                                    <label for="opt3mcq5">Option 3</label>
                                    <input type="text" name="opt3mcq5" required>
                                    <label for="opt4mcq5">Option 4</label>
                                    <input type="text" name="opt4mcq5" required>
                                    <label for="correctoptmcq5">Correct Option</label>
                                    <input type="text" name="correctoptmcq5" required>

                                    <input type="submit" value="Save" id="quizsave">
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </section>

            
        </div>
    </div>


    <?php
    include "footer.php";
    ?>

    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/tutorials.js"></script>
    <script src="js/viewtutorials.js"></script>
    <script src="js/videotutorial.js"></script>
</body>

</html>