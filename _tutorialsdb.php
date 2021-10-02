<?php

use Google\Service\Fitness\DataType;

require "_dbconnect.php";
    session_start();
    $action=$_POST['action'];
    if ($action=="headsave") {
        $course=$_POST['course'];
        $courseverify=$conn->prepare("SELECT * FROM `courses` WHERE `CourseName`=?");
        $courseverify->bind_param('s',$course);
        $courseverify->execute();
        $verification=$courseverify->get_result();
        if(mysqli_num_rows($verification)>0)
        {
            echo "1";
        }
        else
        {
            $courseinsert=$conn->prepare("INSERT INTO `courses` (`CourseName`) VALUES (?)");
            $courseinsert->bind_param('s', $course);
            $courseinsert->execute();
            $courseid=mysqli_insert_id($conn);
            $moduleid=$_POST['mid'];
            $module=$_POST['m'];
            $moduleinsert=$conn->prepare("INSERT IGNORE INTO `module` VALUES (?,?,?)");
            $moduleinsert->bind_param('iis', $moduleid, $courseid, $module);
            $moduleinsert->execute();
            
            $topicid=$_POST['tid'];
            $topic=$_POST['t'];
            $topicinsert=$conn->prepare("INSERT INTO `topics` VALUES (?,?,?,?)");
            $topicinsert->bind_param('iiis', $topicid, $courseid, $moduleid, $topic);
            $topicinsert->execute();
            if ($topicid==1) {
                echo "<script>$('.moduleul').append(`<li><i class='fas fa-caret-down'></i><a id='ulmodule$moduleid'>$module</a> <ul class='topicul'>          
                </ul></li>`);</script>";
            }
            echo "<script>$('#course').prop('id', 'course' + $courseid);$('#navigation-menu').prepend(`<h1 id='ulcourse$courseid' style='text-align:center;'>$course</h1>`);
            $('#ulmodule$moduleid').next().append(`<li><i class='fas fa-caret-down'></i><a id='mod".$moduleid."ultopic$topicid' onclick='openTopic(this)'>$topic</a> <ul class='subtopicul'></ul></li>`);</script>";
        }
        
    }
    if ($action=="headsave1") {
        $courseid=$_POST['courseid'];
        $modid=$_POST['mid'];
        $module=$_POST['m'];

        $moduleselect=$conn->prepare("SELECT * FROM `module` WHERE `CourseId`=$courseid AND `ModuleId`=$modid");
        $moduleselect->execute();
        $moduleresult=$moduleselect->get_result();
        $rnum=mysqli_num_rows($moduleresult);
        if ($rnum==0) {
            echo "<script>$('.moduleul').append(`<li><i class='fas fa-caret-down'></i><a id='ulmodule$modid'>$module</a> <ul class='topicul'>          
            </ul></li>`);</script>";
        }



        $moduleinsert=$conn->prepare("INSERT IGNORE INTO `module` VALUES (?,?,?)");
        $moduleinsert->bind_param('iis', $modid, $courseid, $module);
        $res=$moduleinsert->execute();
        
        $topicid=$_POST['tid'];
        $topic=$_POST['t'];
        $courseinsert=$conn->prepare("INSERT INTO `topics` VALUES (?,?,?,?)");
        $courseinsert->bind_param('iiis', $topicid, $courseid, $modid, $topic);
        $courseinsert->execute();

        
        
        echo "<script>
        $('#ulmodule$modid').next().append(`<li><i class='fas fa-caret-down'></i><a id='mod".$modid."ultopic$topicid' onclick='openTopic(this)'>$topic</a> <ul class='subtopicul'></ul></li>`);</script>";
    }
    if ($action=="subtopicsave") {
        $courseid=$_POST['courseid'];
        $moduleid=$_POST['mid'];
        $topicid=$_POST['tid'];
        $subtopicid=$_POST['sid'];
        $subtopic=$_POST['st'];
        $description=$_POST['desc'];
        $courseinsert=$conn->prepare("INSERT INTO `subtopics` (`SubtopicId`,`CourseId`,`ModuleId`,`TopicId`,`SubtopicName`,`SubtopicDesc`) VALUES (?,?,?,?,?,?)");
        $courseinsert->bind_param('iiiiss', $subtopicid, $courseid, $moduleid, $topicid, $subtopic, $description);
        $courseinsert->execute();
        echo "<script>
        $('#ulmodule$moduleid').siblings().find('#mod".$moduleid."ultopic$topicid').siblings('.subtopicul').append(`<li><a id='smod".$moduleid."ulsubtopic$subtopicid' onclick='openSubTopic(this)'>$subtopic</a></li>`);</script>";
    }
    if ($action=="snippetsave") {
        $courseid=$_POST['courseid'];
        $moduleid=$_POST['mid'];
        $topicid=$_POST['tid'];
        $subtopicid=$_POST['sid'];
        $snippetid=$_POST['snipid'];
        $code=$_POST['code'];
        $output=$_POST['output'];
        $courseinsert=$conn->prepare("INSERT INTO `snippets` VALUES (?,?,?,?,?,?,?)");
        $courseinsert->bind_param('iiiiiss', $snippetid, $courseid, $moduleid, $topicid, $subtopicid, $code, $output);
        $courseinsert->execute();
    }
    if ($action=="quizsave") {
        $courseid=$_POST['courseid'];
        $moduleid=$_POST['moduleid'];
        $mcq1=$_POST['mcq1'];
        $mcq2=$_POST['mcq2'];
        $mcq3=$_POST['mcq3'];
        $mcq4=$_POST['mcq4'];
        $mcq5=$_POST['mcq5'];
        $opt1m1=$_POST['opt1mcq1'];
        $opt2m1=$_POST['opt2mcq1'];
        $opt3m1=$_POST['opt3mcq1'];
        $opt4m1=$_POST['opt4mcq1'];
        $correctopt1=$_POST['correctoptmcq1'];
        $opt1m2=$_POST['opt1mcq2'];
        $opt2m2=$_POST['opt2mcq2'];
        $opt3m2=$_POST['opt3mcq2'];
        $opt4m2=$_POST['opt4mcq2'];
        $correctopt2=$_POST['correctoptmcq2'];
        $opt1m3=$_POST['opt1mcq3'];
        $opt2m3=$_POST['opt2mcq3'];
        $opt3m3=$_POST['opt3mcq3'];
        $opt4m3=$_POST['opt4mcq3'];
        $correctopt3=$_POST['correctoptmcq3'];
        $opt1m4=$_POST['opt1mcq4'];
        $opt2m4=$_POST['opt2mcq4'];
        $opt3m4=$_POST['opt3mcq4'];
        $opt4m4=$_POST['opt4mcq4'];
        $correctopt4=$_POST['correctoptmcq4'];
        $opt1m5=$_POST['opt1mcq5'];
        $opt2m5=$_POST['opt2mcq5'];
        $opt3m5=$_POST['opt3mcq5'];
        $opt4m5=$_POST['opt4mcq5'];
        $correctopt5=$_POST['correctoptmcq5'];
        $id=1;
        $quizinsert=$conn->prepare('INSERT INTO `mcqs` VALUES (?,?,?,?,?)');
        $quizinsert->bind_param('iiiss', $id, $courseid, $moduleid, $mcq1, $correctopt1);
        $quizinsert->execute();
        $id++;
        $quizinsert->bind_param('iiiss', $id, $courseid, $moduleid, $mcq2, $correctopt2);
        $quizinsert->execute();
        $id++;
        $quizinsert->bind_param('iiiss', $id, $courseid, $moduleid, $mcq3, $correctopt3);
        $quizinsert->execute();
        $id++;
        $quizinsert->bind_param('iiiss', $id, $courseid, $moduleid, $mcq4, $correctopt4);
        $quizinsert->execute();
        $id++;
        $quizinsert->bind_param('iiiss', $id, $courseid, $moduleid, $mcq5, $correctopt5);
        $quizinsert->execute();

        $optioninsert=$conn->prepare('INSERT INTO `options` VALUES(?,?,?,?,?)');
        $mcqid=1;
        $optid=1;
        $optioninsert->bind_param('iiiis', $optid, $courseid, $moduleid, $mcqid, $opt1m1);
        $optioninsert->execute();
        $optid++;
        $optioninsert->bind_param('iiiis', $optid, $courseid, $moduleid, $mcqid, $opt2m1);
        $optioninsert->execute();
        $optid++;
        $optioninsert->bind_param('iiiis', $optid, $courseid, $moduleid, $mcqid, $opt3m1);
        $optioninsert->execute();
        $optid++;
        $optioninsert->bind_param('iiiis', $optid, $courseid, $moduleid, $mcqid, $opt4m1);
        $optioninsert->execute();
        $optid=1;
        $mcqid++;
        $optioninsert->bind_param('iiiis', $optid, $courseid, $moduleid, $mcqid, $opt1m2);
        $optioninsert->execute();
        $optid++;
        $optioninsert->bind_param('iiiis', $optid, $courseid, $moduleid, $mcqid, $opt2m2);
        $optioninsert->execute();
        $optid++;
        $optioninsert->bind_param('iiiis', $optid, $courseid, $moduleid, $mcqid, $opt3m2);
        $optioninsert->execute();
        $optid++;
        $optioninsert->bind_param('iiiis', $optid, $courseid, $moduleid, $mcqid, $opt4m2);
        $optioninsert->execute();
        $optid=1;
        $mcqid++;
        $optioninsert->bind_param('iiiis', $optid, $courseid, $moduleid, $mcqid, $opt1m3);
        $optioninsert->execute();
        $optid++;
        $optioninsert->bind_param('iiiis', $optid, $courseid, $moduleid, $mcqid, $opt2m3);
        $optioninsert->execute();
        $optid++;
        $optioninsert->bind_param('iiiis', $optid, $courseid, $moduleid, $mcqid, $opt3m3);
        $optioninsert->execute();
        $optid++;
        $optioninsert->bind_param('iiiis', $optid, $courseid, $moduleid, $mcqid, $opt4m3);
        $optioninsert->execute();
        $optid=1;
        $mcqid++;
        $optioninsert->bind_param('iiiis', $optid, $courseid, $moduleid, $mcqid, $opt1m4);
        $optioninsert->execute();
        $optid++;
        $optioninsert->bind_param('iiiis', $optid, $courseid, $moduleid, $mcqid, $opt2m4);
        $optioninsert->execute();
        $optid++;
        $optioninsert->bind_param('iiiis', $optid, $courseid, $moduleid, $mcqid, $opt3m4);
        $optioninsert->execute();
        $optid++;
        $optioninsert->bind_param('iiiis', $optid, $courseid, $moduleid, $mcqid, $opt4m4);
        $optioninsert->execute();
        $optid=1;
        $mcqid++;
        $optioninsert->bind_param('iiiis', $optid, $courseid, $moduleid, $mcqid, $opt1m5);
        $optioninsert->execute();
        $optid++;
        $optioninsert->bind_param('iiiis', $optid, $courseid, $moduleid, $mcqid, $opt2m5);
        $optioninsert->execute();
        $optid++;
        $optioninsert->bind_param('iiiis', $optid, $courseid, $moduleid, $mcqid, $opt3m5);
        $optioninsert->execute();
        $optid++;
        $optioninsert->bind_param('iiiis', $optid, $courseid, $moduleid, $mcqid, $opt4m5);
        $optioninsert->execute();
        echo "<script>$('#ulmodule$moduleid').siblings('.topicul').append(`<li><img src='https://img.icons8.com/material-rounded/11/000000/questions.png'/><a id='quiz$moduleid' onclick='openQuiz(this)'>Quiz</a></li>`)</script>";
    }
    if ($action=="showtopic") {
        $courseid=$_POST['courseid'];
        $moduleid=$_POST['moduleid'];
        $topicid=$_POST['topicid'];

        // course fetch
        $courseselect=$conn->prepare("SELECT `CourseName` FROM `courses` WHERE `CourseId`=$courseid");
        $courseselect->execute();
        $courseresult=$courseselect->get_result();
        $rnum=mysqli_num_rows($courseresult);
        if ($rnum>0) {
            while ($row=mysqli_fetch_assoc($courseresult)) {
                $course=$row['CourseName'];
                echo "<script>$('#right-side').append(`<section id='newpage'><div id='title-of-course'><label for='course'>
                <h3 style='display:inline;'>Course Title: </h3>
            </label>
            <input class='course-material' type='text' name='course' id='course$courseid' value='$course' style='display:inline;' disabled></div></section>`);</script>";
            }
        }

        // module fetch
        $moduleselect=$conn->prepare("SELECT `ModuleName` FROM `module` WHERE `CourseId`=$courseid AND `ModuleId`=$moduleid");
        $moduleselect->execute();
        $moduleresult=$moduleselect->get_result();
        $rnum=mysqli_num_rows($moduleresult);
        if ($rnum>0) {
            while ($row=mysqli_fetch_assoc($moduleresult)) {
                $module=$row['ModuleName'];
                echo "<script>$('#newpage').append(`<section id='content-section'>
                <input class='course-material' type='text' id='module$moduleid' value='$module' placeholder='Module Name: Overview' disabled></section>`)</script>";
            }
        }

        // topic fetch
        $topicselect=$conn->prepare("SELECT `TopicName` FROM `topics` WHERE `TopicId`=$topicid AND `ModuleId`=$moduleid AND `CourseId`=$courseid");
        $topicselect->execute();
        $topicresult=$topicselect->get_result();
        $rnum=mysqli_num_rows($topicresult);
        if ($rnum>0) {
            while ($row=mysqli_fetch_assoc($topicresult)) {
                $topic=$row['TopicName'];
                echo "<script>$('#content-section').append(`<input class='course-material' type='text' id='topic$topicid' value='$topic' placeholder='Topic Name: What is HTML?' disabled>
                <div class='btnsdiv'>
                    <div class='textarea-buttons right' id='main-topic-btn'>
                        <button id='headsave$topicid' onclick='headSave(this)'disabled>&#10004; Saved!</button>
                        <button id='headedit$topicid' onclick='headEdit(this)' style='display:inline-block;'>Edit</button>
                        <button id='headchanges$topicid' onclick='headChanges(this)' style='display:none;'>Save Changes</button>
                    </div>
                    <br><br>
                </div>`)</script>";
            }
        }


        // subtopic fetch
        $subtopicselect=$conn->prepare("SELECT `SubtopicId`,`SubtopicName`,`SubtopicDesc` FROM `subtopics` WHERE `TopicId`=$topicid AND `ModuleId`=$moduleid AND `CourseId`=$courseid");
        $subtopicselect->execute();
        $subtopicresult=$subtopicselect->get_result();
        $rnum=mysqli_num_rows($subtopicresult);
        if ($rnum>0) {
            while ($row=mysqli_fetch_assoc($subtopicresult)) {
                $subtopic=$row['SubtopicName'];
                $subtopicid=$row['SubtopicId'];
                $description=$row['SubtopicDesc'];
                echo "<script>$('#content-section').append(`<div class='main-description' id='main-desc$subtopicid'> <input class='course-material' type='text' id='sub-topic$subtopicid' value='$subtopic' placeholder='Sub-heading: History of HTML' disabled><div class='description-details'><textarea class='course-material description-box' id='description$subtopicid' cols='30' rows='6' placeholder='The first version of HTML was written by Tim Berners-Lee in 1993. Since then, there have been many different versions of HTML. The most widely used version throughout the 2000's was HTML 4.01, which became an official standard in December 1999. Another version, XHTML, was a rewrite of HTML as an XML language!' disabled>$description</textarea>`)</script>";

                //snippet fetch
                $snippetselect=$conn->prepare("SELECT `SnippetId`,`Code`,`Output` FROM `snippets` WHERE `TopicId`=$topicid AND `ModuleId`=$moduleid AND `CourseId`=$courseid AND `SubtopicId`=$subtopicid");
                $snippetselect->execute();
                $snippetresult=$snippetselect->get_result();
                $srnum=mysqli_num_rows($snippetresult);
                if ($srnum>0) {
                    while ($srow=mysqli_fetch_assoc($snippetresult)) {
                        $snippetid=$srow['SnippetId'];
                        $code=$srow['Code'];
                        $output=$srow['Output'];
                        echo "<script>$('#main-desc$subtopicid').find('.description-details').first().append(`<div class='description-details code-detail' id='codemaindiv$snippetid' style='display:block;'>
                        <div class='codesnippet code'>
                            <button class='codecopy' id='copybtn$snippetid' onclick='copy(this)'>
                                <i class='fal fa-copy'></i>
                            </button>
                            <textarea cols='30' rows='6' id='code$snippetid' placeholder='print('''Hello World''')'disabled>$code</textarea>
                        </div>
                        <div class='codesnippet'>
                            <textarea cols='30' rows='6' id='output$snippetid' placeholder='Hello World' disabled>$output</textarea>
                        </div>

                    </div>`)</script>";
                    }
                }
                //snippet fetch end: ending button fetch start
                echo "<script>$('#main-desc$subtopicid').find('.description-details').first().append(`<div class='textarea-buttons right' id='btndiv$subtopicid'><button class='savebtn' id='save$subtopicid' onclick='save(this)' style='display:inline-block;' disabled>&#10004; Saved!</button>
                <button class='saveedit' id='saveedit$subtopicid' onclick='saveEdit(this)' style='display:none;'>Save Changes</button>
                <button class='snippetbtn' id='snippetbtn$subtopicid' onclick='addsnippet(this)' style='display:none;'>Add code
                    snippet</button>
                <button class='editbtn' id='editing$subtopicid' onclick='editSubTopic(this)' style='display:inline-block;'>Edit
                    Sub-topic</button></div>
                    <br><br>
                </div>
            </div>`)</script>";
            }
        } else {
            echo "<script>$('#content-section').append(`<div class='main-description' id='main-desc1'>
            <input class='course-material' type='text' id='sub-topic1'
                placeholder='Sub-heading: History of HTML'>
            <!-- <br> -->
            <div class='description-details'>
                <textarea class='course-material description-box' id='description1' cols='30' rows='6'
                    placeholder='The first version of HTML was written by Tim Berners-Lee in 1993. Since then, there have been many different versions of HTML. The most widely used version throughout the 2000's was HTML 4.01, which became an official standard in December 1999. Another version, XHTML, was a rewrite of HTML as an XML language!'></textarea>

                <div class='description-details code-detail' id='codemaindiv1'>
                    <div class='codesnippet code'>
                        <button class='codecopy' id='copybtn1' onclick='copy(this)'>
                            <i class='fal fa-copy'></i>
                        </button>
                        <textarea cols='30' rows='6' id='code1'
                            placeholder='print('Hello World')'></textarea>
                    </div>
                    <div class='codesnippet'>
                        <textarea cols='30' rows='6' id='output1' placeholder='Hello World'></textarea>
                    </div>

                </div>
                <div class='textarea-buttons right' id='btndiv1'>
                    <button class='savebtn' id='save1' onclick='save(this)'>Add other sub-topic</button>
                    <button class='saveedit' id='saveedit1' onclick='saveEdit(this)'>Save Changes</button>
                    <button class='snippetbtn' id='snippetbtn1' onclick='addsnippet(this)'>Add code
                        snippet</button>
                    <button class='editbtn' id='editing1' onclick='editSubTopic(this)'>Edit
                        Sub-topic</button>
                </div>
                <br><br>
            </div>
        </div>`)</script>";
        }
    }

    if ($action=="saveass") {
        $ass=$_POST['ass'];
        $courseid=$_POST['courseid'];
        $assinsert=$conn->prepare("UPDATE `courses` SET `Assignment`=? WHERE `CourseId`=?");
        $assinsert->bind_param('si', $ass, $courseid);
        $assinsert->execute();
        echo "<script>$('.moduleul').append(`<li><img src='https://img.icons8.com/ios-filled/11/000000/laptop-coding.png'/><a id='ulassignment$courseid' onclick='openAss()'>Assignment</a></li>`);</script>";
    }

    if ($action=="practicesave") {
        $courseid=$_POST['courseid'];
        $practiceid=$_POST['pid'];
        $solution=$_POST['code'];
        $problem=$_POST['practice'];
        $practiceinsert=$conn->prepare("INSERT INTO `practiceproblems` VALUES (?,?,?,?)");
        $practiceinsert->bind_param('iiss', $courseid, $practiceid, $problem, $solution);
        $practiceinsert->execute();
        $courseselect=$conn->prepare("SELECT * FROM `practiceproblems` WHERE `CourseId`=?");
        $courseselect->bind_param('i', $courseid);
        $courseselect->execute();
        $res=$courseselect->get_result();
        $rnum=mysqli_num_rows($res);
        if ($rnum==1) {
            echo "<script>$('.moduleul').append(`<li><img src='https://img.icons8.com/ios-filled/11/000000/laptop-coding.png'/><a id='ulpractice$courseid' onclick='openPractice()'>Practice</a></li>`);</script>";
        } else {
            echo "";
        }
    }

    if ($action=="showass") {
        $courseid=$_POST['courseid'];
        $assselect=$conn->prepare("SELECT * FROM `courses` WHERE `CourseId`=?");
        $assselect->bind_param('i', $courseid);
        $assselect->execute();
        $assresult=$assselect->get_result();
        $rnum=mysqli_num_rows($assresult);
        if ($rnum>0) {
            while ($row=mysqli_fetch_assoc($assresult)) {
                $course=$row['CourseName'];
                echo "<script>$('#right-side').append(`<section id='newpage'><div id='title-of-course'><label for='course'>
                <h3 style='display:inline;'>Course Title: </h3>
            </label>
            <input class='course-material' type='text' name='course' id='course$courseid' disabled value='$course' style='display:inline;'></div></section>`);</script>";
                $assign=$row['Assignment'];
                echo "<script> $('#right-side').append(`<section id='assignment'>
                <h3 style='margin-top:26px;'>Instructions For Assignment Submission</h3>
                <div id='instructions' class='course-material description-box'>
                    You are required to build your assignment on <a href='https://jsfiddle.net/'>jsfiddle.net</a>.
                    <br><br>
                    If you are not familiar with it,follow the instructions given below:
                    <br>
                    To create assignment.
                    <br>
                    1) go to <a href='https://jsfiddle.net/'>jsfiddle.net</a>.
                    <br>
                    2) Create your account.
                    <br>3) Login to jsfiddle.
                    <br>4) Write your code.
                    <br>5) Save code by pressing the button in the top navigation bar.
                    <br>6) Copy the url from url bar.
                    <br>7) Submit the url in the submission link box given below the assignment .
        
                    <strong>
                        <br><br>NOTE:
                        <br>1) YOU ARE ALSO REQUIRED TO SUBMIT YOUR ASSIGNMENT LINK ON THE ASSIGNMENT COMMENT
                        SECTION(Click here)
                    </strong>
        
                    <br><br>2) Course completion certificate will only be assigned to you when your project get 3 or
                    above rating
        
                    <br>3) You are also allowed to review others assignment there.<br>
        
                </div>
                <h3 style='margin-top:26px;'>Guidelines For Assignment</h3>
                <div id='guidelines'>
                    <textarea class='course-material description-box' cols='30' rows='30' disabled style='color:black;'>$assign</textarea>
                </div>
                <div id='pasteurl' class='description-details description-box course-material' style='margin-top:26px; padding:12px;'>
                    <strong style='text-transform: capitalize;'>you are required to submit you project link below:</strong>
                    <input type='text' style='padding: 3px;
                    display: block;
                    width: 100%;
                    margin: 18px 0px;
                    font-size: 1.2rem;margin-bottom: 20px;' readonly>
                    <div class='textarea-buttons'>
        
                    <button id='submitassbtn'>Submit Assignment</button>
                    </div> <br>
                </div>
                <div class='textarea-buttons right'>

            <button id='assEditsave' onclick='assEditsave()' style='display:none;'>Save Changes</button>
            <button id='assEdit' onclick='assEdit()'>Edit</button>
        </div>
            </section>`)</script>";
            }
        }
    }
    if ($action=="showpractice") {
        $courseid=$_POST['courseid'];
        $practiceselect=$conn->prepare("SELECT * FROM `practiceproblems` WHERE `CourseId`=?");
        $practiceselect->bind_param('i', $courseid);
        $practiceselect->execute();
        $practiceresult=$practiceselect->get_result();
        $rnum=mysqli_num_rows($practiceresult);
        if ($rnum>0) {
            while ($row=mysqli_fetch_assoc($practiceresult)) {
                $practiceid=$row['ProblemId'];
                $question=$row['ProbQue'];
                $solution=$row['ProbSolution'];
                echo "<script>$('#right-side').append(`<section id='newpage'><section id='practice'>
                <div class='main-description' id='main-desc$practiceid'>
                    <div class='description-details'>
                        <textarea class='course-material description-box' id='practice$practiceid' cols='30' rows='6' disabled>$question</textarea>
                
                        <div class='description-details code-detail' id='codemaindiv$practiceid'>
                            <div class='codesnippet code'>
                                <button class='codecopy' id='copybtn$practiceid' onclick='copy(this)'>
                                    <i class='fal fa-copy'></i>
                                </button>
                                <textarea cols='30' rows='16' id='code$practiceid' disabled>$solution</textarea>
                            </div>
                
                        </div>
                        <div class='textarea-buttons right' id='btndiv$practiceid'>
                            <button class='savebtn' id='practicesave$practiceid' onclick='practicesave(this)' disabled>&#10004; Saved!</button>
                            <button class='saveedit' id='practicesaveedit$practiceid' onclick='practicesaveEdit(this)'>Save Changes</button>
                            <button class='editbtn' id='practiceediting$practiceid' onclick='practiceeditques(this)' style='display:inline-block;'>Edit
                                question</button>
                        </div>
                        <br>
                    </div>
                </div>
                
            </section>
            <div class='textarea-buttons right'>
            <button id='donebtn' onclick='savePractice()' style='display:inline-block;'>Complete Written Course</button>
            <button id='proceedbtn' onclick='saveAssignment()' style='display:none;'>Proceed</button>
            </div></section>`)</script>";
            }
        } else {
            echo "<section id='newpage'><section id='practice'>
            <div class='main-description' id='main-desc1'>
                <div class='description-details'>
                    <textarea class='course-material description-box' id='practice1' cols='30' rows='6'
                        placeholder='Your problem question goes here:'></textarea>
            
                    <div class='description-details code-detail' id='codemaindiv1'>
                        <div class='codesnippet code'>
                            <button class='codecopy' id='copybtn1' onclick='copy(this)'>
                                <i class='fal fa-copy'></i>
                            </button>
                            <textarea cols='30' rows='16' id='code1'
                                placeholder='print('Hello World')'></textarea>
                        </div>
            
                    </div>
                    <div class='textarea-buttons right' id='btndiv1'>
                        <button class='savebtn' id='practicesave1' onclick='practicesave(this)'>Add other question</button>
                        <button class='saveedit' id='practicesaveedit1' onclick='practicesaveEdit(this)'>Save Changes</button>
                        <button class='editbtn' id='practiceediting1' onclick='practiceeditques(this)'>Edit
                            question</button>
                    </div>
                    <br>
                </div>
            </div>
            
        </section>
        <div class='textarea-buttons right'>
        <button id='donebtn' onclick='savePractice()' style='display:inline-block;'>Complete Written Course</button>
        <button id='proceedbtn' onclick='saveAssignment()' style='display:none;'>Proceed</button>
        </div></section>";
        }
    }
    if ($action=="showquiz") {
        $moduleid=$_POST['moduleid'];
        $courseid=$_POST['courseid'];
        $modselect=$conn->prepare("SELECT `ModuleName` FROM `module` WHERE `ModuleId`=? AND `CourseId`=?");
        $modselect->bind_param('ii', $moduleid, $courseid);
        $modselect->execute();
        $modresult=$modselect->get_result();
        $rnum=mysqli_num_rows($modresult);

        if ($rnum>0) {
            while ($row=mysqli_fetch_assoc($modresult)) {
                $module=$row['ModuleName'];
                echo "<script>$('#right-side').append(`<section id='newpage'><div id='quiz-modal' class='modal' style='display:block;'>
                <div class='modal-content'>
                    <div class='modal-header'>
                    <span class='close' id='quizclose' onclick='closequiz()'>&times;</span>
                    </div>
                    <div class='modal-body'>
                        <div style='display: flex;
                        justify-content: center;
                        flex-wrap: wrap;'>
                            <div style='margin-right: 10px;'>
                                <img src='img/quizclip-removebg-preview.png' style='height: 62px;
                            width: 62px;' alt=''>
                            </div>
                            <div>
                                <h2 id='quizmoduleid'>$module</h2>
                                <h4>Quiz to test the knowledge of learners</h4>
                            </div>
                        </div>
                        <div>
                        <form method='POST' id='quiz-form' style='margin-top: 28px;'></form>
                        </div>
                    </div>
                </div>
            </div></section>`)</script>";
            }
        } 
        $quizselect=$conn->prepare("SELECT * FROM  `mcqs` WHERE `CourseId`=? AND `ModuleId`=?");
        $quizselect->bind_param('ii', $courseid, $moduleid);
        $quizselect->execute();
        $quizresult=$quizselect->get_result();
        while ($qrow=mysqli_fetch_assoc($quizresult)) {
            $mcqid=$qrow['McqId'];
            $que=$qrow['Question'];
            $ans=$qrow['Answer'];
            echo "<script>$('#quiz-form').append(`
            <h4>MCQ-$mcqid</h4>
            <input type='text' name='mcq$mcqid' id='mcq$mcqid' value='$que' disabled required>`)</script>";
            $optionselect=$conn->prepare("SELECT * FROM `options` WHERE `McqId`=? AND `ModuleId`=? AND `CourseId`=?");
            $optionselect->bind_param('iii', $mcqid, $moduleid, $courseid);
            $optionselect->execute();
            $optionresult=$optionselect->get_result();
            while ($orow=mysqli_fetch_assoc($optionresult)) {
                $optid=$orow['OptionId'];
                $options=$orow['OptionStatement'];
                echo "<script>$('#quiz-form').append(`<label for='opt'.$optid.'mcq$mcqid'>Option $optid</label>
                <input name='opt'.$optid.'mcq$mcqid' type='text' value='$options' disabled required>`)</script>";
            }
            echo "<script>$('#quiz-form').append(`<input type='text' name='correctoptmcq$mcqid' value='$ans' disabled required>`)</script>";
        }

        echo "<script>$('#quiz-form').append(`<input type='submit' value='Save' id='quizsave' disabled>`)</script>";
    }

    if($action=="enroll")
    {
        // echo "run ".$_SESSION["username"];
        $courseid=$_POST['courseid'];
        $username=$_SESSION["username"];
        $cid=(int)$courseid;
        $checkenroll=$conn->prepare("SELECT * FROM `enrollment` WHERE `username`=? AND `CourseId`=?");
        $checkenroll->bind_param('si',$username,$cid);
        $checkenroll->execute();
        $checkenrollmentresults=$checkenroll->get_result();
        if(mysqli_num_rows($checkenrollmentresults)>0)
        {
            echo 1;
        }
        else
        {
            $enroll=$conn->prepare("INSERT INTO `enrollment` (`CourseId`,`username`) VALUES (?,?)");
            $enroll->bind_param('is',$cid,$username);
            $enroll->execute();
            echo 2;
        }
    }

   $conn->close();
?>