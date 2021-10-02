<?php
session_start();
    require "_dbconnect.php";
    include('smtp/PHPMailerAutoload.php');
    $action=$_POST['action'];
    if($action=="viewcourse")
    {
        $courseid=$_POST['courseid'];
        //course name fetch
        $courseselect = $conn->prepare('SELECT * FROM `courses` WHERE `CourseId`=?');
        $courseselect->bind_param('i', $courseid);
        $courseselect->execute();
        $courseresult = $courseselect->get_result();
        while ($row = mysqli_fetch_assoc($courseresult)) {
            $course = $row['CourseName'];
            echo "<script>$(`</section><section id='center'></section><section id='notespage'></section>`).insertAfter('#navigation');$('#navigation').prepend(`<h1 id='ulcourse$courseid' style='text-align:center; font-size: 1.4rem;'>$course</h1>`);$('#navigation').prepend(`<button id='navclose' onclick='closenav()'><i class='fas fa-times'></i></button>`);$('#center').append(`<section id='newpage'><div  id='titlecourse' class='title-top textarea-buttons'><div><button id='hamburger' onclick='opensidebar()'><i class='far fa-bars'></i></button><button class='right' id='tuttogglebtn' onclick='viewVideoTutorial()'><i class='fal fa-play'></i>Video Tutorial</button></div><p class='course-material' id='course$courseid' style='display:block;'>$course</p></div><div id='title-of-course' class='title-top textarea-buttons'><button id='hamburger' onclick='opensidebar()'><i class='far fa-bars'></i></button><label for='course'>
            <h3 style='display:inline;'>Course Title: </h3>
        </label>
        <p class='course-material' id='course$courseid' style='display:inline-block;'>$course</p><button class='right' id='tuttogglebtn'  onclick='viewVideoTutorial()'><i class='fal fa-play'></i>Video Tutorial</button></div></section>`)</script>";

            //module fetch
            $moduleselect = $conn->prepare('SELECT * FROM `module` WHERE `CourseId`=?');
            $moduleselect->bind_param('i', $courseid);
            $moduleselect->execute();
            $moduleresult = $moduleselect->get_result();
            while ($mrow = mysqli_fetch_assoc($moduleresult)) {
                $moduleid = $mrow['ModuleId'];
                $module = $mrow['ModuleName'];
                echo "<script>$('.moduleul').append(`<li><i class='fas fa-caret-down'></i><a id='ulmodule$moduleid'>$module</a><ul class='topicul'>          
    </ul></li>`);</script>";
                if ($moduleid == 1) {
                    echo "<script>$('#newpage').append(`<section id='content-section'>
        <input class='course-material' type='text' id='module$moduleid' value='$module' disabled></section>`)</script>";
                }

                //topic fetch
                $topicselect = $conn->prepare('SELECT * FROM `topics` WHERE `CourseId`=? AND `ModuleId`=?');
                $topicselect->bind_param('ii', $courseid, $moduleid);
                $topicselect->execute();
                $topicresult = $topicselect->get_result();
                while ($trow = mysqli_fetch_assoc($topicresult)) {
                    $topicid = $trow['TopicId'];
                    $topic = $trow['TopicName'];
                    echo "<script>$('#ulmodule$moduleid').next().append(`<li><i class='fas fa-caret-down'></i><a id='mod".$moduleid."ultopic$topicid'>$topic</a> <ul class='subtopicul'></ul></li>`);</script>";
                    if ($topicid == 1 && $moduleid==1) {
                        echo "<script>$('#content-section').append(`<input class='course-material' type='text' id='topic$topicid' value='$topic'disabled><br><br>`);</script>";  
                    }


                        // subtopic fetch
                        $subtopicselect=$conn->prepare("SELECT `SubtopicId`,`SubtopicName`,`SubtopicDesc` FROM `subtopics` WHERE `TopicId`=? AND `ModuleId`=? AND `CourseId`=?");
                        $subtopicselect->bind_param('iii',$topicid,$moduleid,$courseid);
                        $subtopicselect->execute();
                        $subtopicresult=$subtopicselect->get_result();
                        $rnum=mysqli_num_rows($subtopicresult);
                        if ($rnum>0) {
                            while ($row=mysqli_fetch_assoc($subtopicresult)) {
                                $subtopic=$row['SubtopicName'];
                                $subtopicid=$row['SubtopicId'];
                                $description=$row['SubtopicDesc'];
                                echo "<script>$('#ulmodule$moduleid').siblings().find('#mod".$moduleid."ultopic$topicid').siblings('.subtopicul').append(`<li><a id='smod".$moduleid."ultop".$topicid."subtopic$subtopicid' onclick='openSubTopic(this)'>$subtopic</a></li>`)</script>";
                                if ($topicid == 1 && $moduleid==1) {
                                    echo "<script>$('#content-section').append(`<hr><div class='main-description' id='main-desc$subtopicid'> <input class='course-material' type='text' id='sub-topic$subtopicid' value='$subtopic' disabled><pre class='course-material description-box' id='description$subtopicid'>$description</pre>`)</script>";

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
                                            echo "<script>$('#content-section').append(`<div class='description-details code-detail' id='codemaindiv$snippetid' style='display:block;'>
                                            <div class='codesnippet code'>
                                                <button class='codecopy' id='copybtn$snippetid' onclick='copy(this)'>
                                                    <i class='fal fa-copy'></i>
                                                </button>
                                                <pre id='code$snippetid' placeholder='print('''Hello World''')'disabled>$code</pre>
                                            </div>
                                            <div class='codesnippet'>
                                                <pre id='output$snippetid' placeholder='Hello World' disabled>$output</pre>
                                            </div>

                                        </div>`)</script>";
                                        }
                                    }
                                }
                                
                            }
                        }
                    }
                // quiz fetch
                $quizselect=$conn->prepare("SELECT * FROM `mcqs` WHERE `ModuleId`=? AND `CourseId`=?");
                echo "<script>$('#ulmodule$moduleid').siblings('.topicul').append(`<li><input type='checkbox' class='myinput' disabled><img src='https://img.icons8.com/material-rounded/11/000000/questions.png'/><a id='quiz$moduleid' onclick='openQuiz(this)'>Quiz</a></li>`)</script>";
                    //check if user submitted quiz
                    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'])
                    {
                        $userquizcheck=$conn->prepare("SELECT * FROM `attemptquiz` WHERE `CourseId`=? AND `ModuleId`=? AND `Username`=?");
                        $userquizcheck->bind_param('iis',$courseid,$moduleid,$_SESSION["username"]);
                        $userquizcheck->execute();
                        $userquizcheckres=$userquizcheck->get_result();
                        if(mysqli_num_rows($userquizcheckres)>0)
                        {
                            echo "<script>$('#quiz$moduleid').siblings('input').prop('checked',true)</script>";

                        }
                    }
            }
            //assignment fetch
            echo "<script>$('.moduleul').append(`<li><img src='https://img.icons8.com/ios-filled/11/000000/laptop-coding.png'/><a id='ulassignment$courseid' onclick='openAss()'>Assignment</a></li>`);</script>";

            //practice problem fetch
            echo "<script>$('.moduleul').append(`<li><img src='https://img.icons8.com/ios-filled/11/000000/laptop-coding.png'/><a id='ulpractice$courseid' onclick='openPractice()'>Practice</a></li>`);</script>";

            //completion of certificate
            if(isset($_SESSION["username"]) && $_SESSION["username"])
            {
                $username=$_SESSION["username"];
                $checkenrollment=$conn->prepare("SELECT * FROM `enrollment` WHERE `username`=? AND `courseid`=?");
                $checkenrollment->bind_param('si',$username,$courseid);
                $checkenrollment->execute();
                $checkenrollmentresult=$checkenrollment->get_result();
                if(mysqli_num_rows($checkenrollmentresult)>0)
                {
                    echo "<script>$('.moduleul').append(`<li><i class='fas fa-file-certificate'></i><a id='ulcertificate$courseid' style='text-decoration:none;'  href='certificatepage.php?id=$courseid'> Certificate of Completion</a></li>`);</script>";
                }        
                
            }

            //next button
            echo "<script>$('#newpage').append(`<section id='btn-section'>
            <div class='textarea-buttons right'>
                <div class='right'>
                
                <button class='next' onclick='next()'>Next</button>
                </div>
            </div>
        </section>`)</script>";
        }
    }

  if($action=="fetchnextpage")
  {
    $courseid=$_POST['courseid'];
    $moduleid=$_POST['moduleid'];
    $modulename=$_POST['modulename'];
    $topicid=$_POST['topicid'];
    $nexttopicid=$topicid+1;
    $nextmoduleid=$moduleid+1;
    $nexttopic=$conn->prepare("SELECT * FROM `topics` WHERE `CourseId`=? AND `ModuleId`=? AND `TopicId`=?");
    $nexttopic->bind_param('iii',$courseid,$moduleid,$nexttopicid);
    $nexttopic->execute();
    $nexttopicres=$nexttopic->get_result();
    if(mysqli_num_rows($nexttopicres)>0)
    {
        while ($trow=mysqli_fetch_assoc($nexttopicres))
        {
            $tid = $trow['TopicId'];
            $topic = $trow['TopicName'];
            echo "<script>$('#newpage').append(`<section id='content-section'>
    <input class='course-material' type='text' id='module$moduleid' value='$modulename'disabled></section>`)</script>";
            echo "<script>$('#content-section').append(`<input class='course-material' type='text' id='topic$tid' value='$topic' disabled>`);</script>";
            //subtopic fetch
            $subselect = $conn->prepare('SELECT * FROM `subtopics` WHERE `CourseId`=? AND `ModuleId`=? AND `TopicId`=?');
            $subselect->bind_param('iii', $courseid, $moduleid, $tid);
            $subselect->execute();
            $subresult = $subselect->get_result();
            while ($strow = mysqli_fetch_assoc($subresult)) 
            {
                $subtopic=$strow['SubtopicName'];
                $subtopicid=$strow['SubtopicId'];
                $description=$strow['SubtopicDesc'];
                echo "<script>$('#content-section').append(`<hr><div class='main-description' id='main-desc$subtopicid'> <input class='course-material' type='text' id='sub-topic$subtopicid' value='$subtopic' disabled><pre class='course-material description-box' id='description$subtopicid'>$description</pre>`)</script>";

                //snippet fetch
                $snippetselect=$conn->prepare("SELECT `SnippetId`,`Code`,`Output` FROM `snippets` WHERE `TopicId`=$nexttopicid AND `ModuleId`=$moduleid AND `CourseId`=$courseid AND `SubtopicId`=$subtopicid");
                $snippetselect->execute();
                $snippetresult=$snippetselect->get_result();
                $srnum=mysqli_num_rows($snippetresult);
                if ($srnum>0) 
                {
                    while ($srow=mysqli_fetch_assoc($snippetresult)) 
                    {
                    $snippetid=$srow['SnippetId'];
                    $code=$srow['Code'];
                    $output=$srow['Output'];
                    echo "<script>$('#content-section').append(`<div class='description-details code-detail' id='codemaindiv$snippetid' style='display:block;'><div class='codesnippet code'><button class='codecopy' id='copybtn$snippetid' onclick='copy(this)'><i class='fal fa-copy'></i></button><pre id='code$snippetid' placeholder='print('''Hello World''')'disabled>$code</pre></div><div class='codesnippet'> <pre id='output$snippetid' placeholder='Hello World' disabled>$output</pre></div></div>`)</script>";
                    }
                }
            }
        }
    }
    else
    {
        
        $currentmodule=$conn->prepare("SELECT module.`ModuleName` FROM  `module` WHERE `ModuleId`=? and `CourseId`=?");
        $currentmodule->bind_param('ii',$moduleid,$courseid);
        $currentmodule->execute();
        $currentmodulename=$currentmodule->get_result();
        if(mysqli_num_rows($currentmodulename)>0)
        {
            // quiz fetch
            while($nrow=mysqli_fetch_assoc($currentmodulename))
            {
                $modulename=$nrow['ModuleName'];
                echo "<script>$('#center').append(`<div id='quiztop' style='display: flex;
                        justify-content: center;
                        flex-wrap: wrap;'>
                            <div style='margin-right: 10px;'>
                                <img src='img/quizclip-removebg-preview.png' style='height: 62px;
                            width: 62px;' alt=''>
                            </div>
                            <div>
                                <h2 id='headingquiz$moduleid'>$modulename</h2>
                                <h4>Quiz to test the knowledge of learners</h4>
                            </div>
                        </div><form method='POST' id='quiz-form' style='margin-top: 28px;font-size: 1rem;'></form>`)</script>";
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
            <h4 style='width:100%;'>MCQ-$mcqid</h4>
            <label for='mcq$mcqid' id='mcq$mcqid' style='margin-top:12px;'>$que</label><br><br>`)</script>";
            $optionselect=$conn->prepare("SELECT * FROM `options` WHERE `McqId`=? AND `ModuleId`=? AND `CourseId`=?");
            $optionselect->bind_param('iii', $mcqid, $moduleid, $courseid);
            $optionselect->execute();
            $optionresult=$optionselect->get_result();
            while ($orow=mysqli_fetch_assoc($optionresult)) {
                $optid=$orow['OptionId'];
                $options=$orow['OptionStatement'];
                echo "<script>$('#quiz-form').append(`<input name='mcq$mcqid' type='radio' value='$options' style='margin-left: 26px;'>  $options<br><br>`)</script>";
            }
            
        }
        echo "<script>$('#quiz-form').append(`<input type='button' value='Submit' id='quizsubmit'  onclick='submitquiz()' style='padding: 7px;
        width: 100%;cursor:pointer;
        font-size: 1.1rem;
        background-color: #1eb2a6;
        color: white;'>`)</script>";
        }
        
       
    }
  
     
        echo "<script>$('#center').append(`<section id='btn-section'>
         <div class='textarea-buttons right'>
             <div class='right'>
             <button class='prev' onclick='previous()'>Previous</button>
             <button class='next' onclick='next()'>Next</button>
             </div>
         </div>
     </section>`)</script>";

}

if($action=="fetchnextmodule")
{
    $courseid=$_POST['courseid'];
    $moduleid=$_POST['moduleid'];
    $nextmoduleid=$moduleid+1;
    $tid=1;
    $nextmodule=$conn->prepare("SELECT topics.`TopicName`,module.`ModuleName` FROM `topics` INNER JOIN `module` ON module.`ModuleId`=topics.`ModuleId` AND module.`CourseId`=topics.`CourseId` WHERE topics.`TopicId`=? AND topics.`ModuleId`=? and topics.`CourseId`=?");
    $nextmodule->bind_param('iii',$tid,$nextmoduleid,$courseid);
    $nextmodule->execute();
    $nextmodulename=$nextmodule->get_result();
    if(mysqli_num_rows($nextmodulename)>0)
    {
        while($nrow=mysqli_fetch_assoc($nextmodulename))
            {
                $topicid=1;
                $modulename=$nrow['ModuleName'];
                $topic = $nrow['TopicName'];
                echo "<script>$('#newpage').append(`<section id='content-section'>
    <input class='course-material' type='text' id='module$nextmoduleid' value='$modulename' placeholder='Module Name: Overview' disabled></section>`)</script>";
   
    echo "<script>$('#content-section').append(`<input class='course-material' type='text' id='topic$tid' value='$topic' disabled>`);</script>";
                //subtopic fetch
            $subselect = $conn->prepare('SELECT * FROM `subtopics` WHERE `CourseId`=? AND `ModuleId`=? AND `TopicId`=?');
            $subselect->bind_param('iii', $courseid, $nextmoduleid, $tid);
            $subselect->execute();
            $subresult = $subselect->get_result();
            while ($strow = mysqli_fetch_assoc($subresult)) 
            {
                $subtopic=$strow['SubtopicName'];
                $subtopicid=$strow['SubtopicId'];
                $description=$strow['SubtopicDesc'];
                echo "<script>$('#content-section').append(`<hr><div class='main-description' id='main-desc$subtopicid'> <input class='course-material' type='text' id='sub-topic$subtopicid' value='$subtopic' disabled><pre class='course-material description-box' id='description$subtopicid'>$description</pre>`)</script>";

                //snippet fetch
                $snippetselect=$conn->prepare("SELECT `SnippetId`,`Code`,`Output` FROM `snippets` WHERE `TopicId`=$tid AND `ModuleId`=$nextmoduleid AND `CourseId`=$courseid AND `SubtopicId`=$subtopicid");
                $snippetselect->execute();
                $snippetresult=$snippetselect->get_result();
                $srnum=mysqli_num_rows($snippetresult);
                if ($srnum>0) 
                {
                    while ($srow=mysqli_fetch_assoc($snippetresult)) 
                    {
                    $snippetid=$srow['SnippetId'];
                    $code=$srow['Code'];
                    $output=$srow['Output'];
                    echo "<script>$('#content-section').append(`<div class='description-details code-detail' id='codemaindiv$snippetid' style='display:block;'><div class='codesnippet code'><button class='codecopy' id='copybtn$snippetid' onclick='copy(this)'><i class='fal fa-copy'></i></button><pre id='code$snippetid' placeholder='print('''Hello World''')'disabled>$code</pre></div><div class='codesnippet'> <pre id='output$snippetid' placeholder='Hello World' disabled>$output</pre></div></div>`)</script>";
                    }
                }
            }    
            }
        }
        else{
    //fetch assignment
    $assselect=$conn->prepare("SELECT * FROM `courses` WHERE `CourseId`=?");
    $assselect->bind_param('i', $courseid);
    $assselect->execute();
    $assresult=$assselect->get_result();
    $rnum=mysqli_num_rows($assresult);
    if ($rnum>0) {
        while ($row=mysqli_fetch_assoc($assresult)) {
            $course=$row['CourseName'];
            $assign=$row['Assignment'];
            echo "<script> $('#center').append(`<section id='assignment'>
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
                <pre class='course-material description-box' style='color:black;'>$assign</pre>
            </div>
            <div id='pasteurl' class='description-details description-box course-material' style='margin-top:26px; padding:12px;'>
                <strong style='text-transform: capitalize;'>you are required to submit you project link below:</strong>
                <input type='url' pattern='https://.*' placeholder='https://jsfiddle.net' style='padding: 3px;
                display: block;
                width: 100%;
                margin: 18px 0px; outline:black; border: 2px solid;
                font-size: 1.2rem;margin-bottom: 20px;' required>
                <div class='textarea-buttons'>
    
                <button id='submitassbtn' onclick='submitass()'>Submit Assignment</button>
                </div> <br>
            </div>
        </section>`)</script>";
        }
    }
        }
            
    
    echo "<script>$('#center').append(`<section id='btn-section'>
         <div class='textarea-buttons right'>
             <div class='right'>
             <button class='prev' onclick='previous()'>Previous</button>
             <button class='next' onclick='next()'>Next</button>
             </div>
         </div>
     </section>`)</script>";
}

if($action=="fetchpractice")
{
    $courseid=$_POST['courseid'];
        $practiceselect=$conn->prepare("SELECT practiceproblems.*,courses.`CourseName` FROM `practiceproblems` INNER JOIN `courses` WHERE practiceproblems.`CourseId`=courses.`CourseId` AND courses.`CourseId`=?");
        $practiceselect->bind_param('i', $courseid);
        $practiceselect->execute();
        $practiceresult=$practiceselect->get_result();
        $rnum=mysqli_num_rows($practiceresult);
        if ($rnum>0) {
            echo "<script>$('#center').append(`<section id='practice'></section>`)</script>";
            while ($row=mysqli_fetch_assoc($practiceresult)) {
                $course=$row['CourseName'];
                $practiceid=$row['ProblemId'];
                $question=$row['ProbQue'];
                $solution=$row['ProbSolution'];
                echo "<script>$('#practice').append(`
                <div class='main-description' id='main-desc$practiceid'>
                    <div class='description-details'>
                        <pre class='course-material description-box' id='practice$practiceid' >$question</pre>
                
                        <div class='description-details code-detail' id='codemaindiv$practiceid'>
                            <div class='codesnippet code'>
                                <button class='codecopy' id='copybtn$practiceid' onclick='copy(this)'>
                                    <i class='fal fa-copy'></i>
                                </button>
                                <pre id='code$practiceid'>$solution</pre>
                            </div>
                
                        </div>
                        
                        <br>
                    </div>
                </div>`)</script>";
            }
        } 
        
        echo "<script>$('#center').append(`<section id='btn-section'>
         <div class='textarea-buttons right'>
             <div class='right'>
             <button class='prev' onclick='previous()'>Previous</button>
         
                 
             </div>
         </div>
     </section>`)</script>";
}
if($action=="fetchass")
{
    $courseid=$_POST['courseid'];
    //fetch assignment
    $assselect=$conn->prepare("SELECT * FROM `courses` WHERE `CourseId`=?");
    $assselect->bind_param('i', $courseid);
    $assselect->execute();
    $assresult=$assselect->get_result();
    $rnum=mysqli_num_rows($assresult);
    if ($rnum>0) {
        while ($row=mysqli_fetch_assoc($assresult)) {
            $course=$row['CourseName'];
            $assign=$row['Assignment'];
            echo "<script> $('#center').append(`<section id='assignment'>
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
                <pre class='course-material description-box' style='color:black;'>$assign</pre>
            </div>
            <div id='pasteurl' class='description-details description-box course-material' style='margin-top:26px; padding:12px;'>
                <strong style='text-transform: capitalize;'>you are required to submit you project link below:</strong>
                <input type='url' pattern='https://.*' placeholder='https://jsfiddle.net' style='padding: 3px;
                display: block;
                width: 100%;
                margin: 18px 0px; outline:black; border: 2px solid;
                font-size: 1.2rem;margin-bottom: 20px;'>
                <div class='textarea-buttons' required>
    
                <button id='submitassbtn' onclick='submitass()'>Submit Assignment</button>
                </div> <br>
            </div>
        </section>`)</script>";
        }
    }
    echo "<script>$('#center').append(`<section id='btn-section'>
    <div class='textarea-buttons right'>
        <div class='right'>
        <button class='prev' onclick='previous()'>Previous</button>
                 <button class='next' onclick='next()'>Next</button>
        </div>
    </div>
</section>`)</script>";
}
if($action=="fetchlastquiz")
{
    $courseid=$_POST['courseid'];
    $currentmodule=$conn->prepare("SELECT module.`ModuleName`,`ModuleId` FROM  `module` WHERE `ModuleId`=(SELECT MAX(ModuleId) FROM `module` WHERE `CourseId`=?) and `CourseId`=?");
        $currentmodule->bind_param('ii',$courseid,$courseid);
        $currentmodule->execute();
        $currentmodulename=$currentmodule->get_result();
        if(mysqli_num_rows($currentmodulename)>0)
        {
            // quiz fetch
            while($nrow=mysqli_fetch_assoc($currentmodulename))
            {
                $moduleid=$nrow['ModuleId'];
                $modulename=$nrow['ModuleName'];
                echo "<script>$('#center').append(`<div id='quiztop' style='display: flex;
                        justify-content: center;
                        flex-wrap: wrap;'>
                            <div style='margin-right: 10px;'>
                                <img src='img/quizclip-removebg-preview.png' style='height: 62px;
                            width: 62px;' alt=''>
                            </div>
                            <div>
                                <h2 id='headingquiz$moduleid'>$modulename</h2>
                                <h4>Quiz to test the knowledge of learners</h4>
                            </div>
                        </div><form method='POST' id='quiz-form' style='margin-top: 28px;font-size: 1rem;'></form>`)</script>";
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
            <h4 style='width:100%;'>MCQ-$mcqid</h4>
            <label for='mcq$mcqid' id='mcq$mcqid' style='margin-top:12px;'>$que</label><br><br>`)</script>";
            $optionselect=$conn->prepare("SELECT * FROM `options` WHERE `McqId`=? AND `ModuleId`=? AND `CourseId`=?");
            $optionselect->bind_param('iii', $mcqid, $moduleid, $courseid);
            $optionselect->execute();
            $optionresult=$optionselect->get_result();
            while ($orow=mysqli_fetch_assoc($optionresult)) {
                $optid=$orow['OptionId'];
                $options=$orow['OptionStatement'];
                echo "<script>$('#quiz-form').append(`<input name='mcq$mcqid' type='radio' value='$options' style='margin-left: 26px;'>  $options<br><br>`)</script>";
            }
            
        }
        echo "<script>$('#quiz-form').append(`<input type='button' value='Submit' id='quizsubmit'  onclick='submitquiz()' style='padding: 7px;
        width: 100%;cursor:pointer;
        font-size: 1.1rem;
        background-color: #1eb2a6;
        color: white;'>`)</script>";
        }
        
       
    
  
     
        echo "<script>$('#center').append(`<section id='btn-section'>
         <div class='textarea-buttons right'>
             <div class='right'>
             <button class='prev' onclick='previous()'>Previous</button>
                 <button class='next' onclick='next()'>Next</button>
             </div>
         </div>
     </section>`)</script>";

}
if($action=="fetchprevtopic")
{
    $courseid=$_POST['courseid'];
    $moduleid=$_POST['moduleid'];
    $prevtopic=$conn->prepare("SELECT topics.`TopicId`,topics.`TopicName`,module.`ModuleName` FROM `topics` INNER JOIN `module` ON module.`ModuleId`=topics.`ModuleId` AND module.`CourseId`=topics.`CourseId` WHERE topics.`TopicId`=(SELECT MAX(TopicId) FROM `topics` WHERE `CourseId`=? AND `ModuleId`=?) AND topics.`ModuleId`=? and topics.`CourseId`=?");
    $prevtopic->bind_param('iiii',$courseid,$moduleid,$moduleid,$courseid);
    $prevtopic->execute();
    $prevtopicres=$prevtopic->get_result();
    if(mysqli_num_rows($prevtopicres)>0)
    {
        while ($trow=mysqli_fetch_assoc($prevtopicres))
        {
            $tid = $trow['TopicId'];
            $topic = $trow['TopicName'];
            $modulename=$trow['ModuleName'];
            echo "<script>$('#newpage').append(`<section id='content-section'>
    <input class='course-material' type='text' id='module$moduleid' value='$modulename'disabled></section>`)</script>";
            echo "<script>$('#content-section').append(`<input class='course-material' type='text' id='topic$tid' value='$topic' disabled>`);</script>";
            //subtopic fetch
            $subselect = $conn->prepare('SELECT * FROM `subtopics` WHERE `CourseId`=? AND `ModuleId`=? AND `TopicId`=?');
            $subselect->bind_param('iii', $courseid, $moduleid, $tid);
            $subselect->execute();
            $subresult = $subselect->get_result();
            while ($strow = mysqli_fetch_assoc($subresult)) 
            {
                $subtopic=$strow['SubtopicName'];
                $subtopicid=$strow['SubtopicId'];
                $description=$strow['SubtopicDesc'];
                echo "<script>$('#content-section').append(`<hr><div class='main-description' id='main-desc$subtopicid'> <input class='course-material' type='text' id='sub-topic$subtopicid' value='$subtopic' disabled><pre class='course-material description-box' id='description$subtopicid'>$description</pre>`)</script>";

                //snippet fetch
                $snippetselect=$conn->prepare("SELECT `SnippetId`,`Code`,`Output` FROM `snippets` WHERE `TopicId`=$tid AND `ModuleId`=$moduleid AND `CourseId`=$courseid AND `SubtopicId`=$subtopicid");
                $snippetselect->execute();
                $snippetresult=$snippetselect->get_result();
                $srnum=mysqli_num_rows($snippetresult);
                if ($srnum>0) 
                {
                    while ($srow=mysqli_fetch_assoc($snippetresult)) 
                    {
                    $snippetid=$srow['SnippetId'];
                    $code=$srow['Code'];
                    $output=$srow['Output'];
                    echo "<script>$('#content-section').append(`<div class='description-details code-detail' id='codemaindiv$snippetid' style='display:block;'><div class='codesnippet code'><button class='codecopy' id='copybtn$snippetid' onclick='copy(this)'><i class='fal fa-copy'></i></button><pre id='code$snippetid' placeholder='print('''Hello World''')'disabled>$code</pre></div><div class='codesnippet'> <pre id='output$snippetid' placeholder='Hello World' disabled>$output</pre></div></div>`)</script>";
                    }
                }
            }
        }
    }
    echo "<script>$('#center').append(`<section id='btn-section'>
         <div class='textarea-buttons right'>
             <div class='right'>
             <button class='prev' onclick='previous()'>Previous</button>
             <button class='next' onclick='next()'>Next</button>
             </div>
         </div>
     </section>`)</script>";
}
if($action=="fetchmoduletopics")
{
    $courseid=$_POST['courseid'];
    $moduleid=$_POST['moduleid'];
    $topicid=$_POST['topicid'];
    $prevmoduleid=$moduleid-1;
    $prevtopicid=$topicid-1;
    if($topicid==1 && $moduleid!=1)
    {
        $prevmodule=$conn->prepare("SELECT module.`ModuleName`,`ModuleId` FROM  `module` WHERE `ModuleId`=? and `CourseId`=?");
        $prevmodule->bind_param('ii',$prevmoduleid,$courseid);
        $prevmodule->execute();
        $prevmodulename=$prevmodule->get_result();
        if(mysqli_num_rows($prevmodulename)>0)
        {
            // quiz fetch
            while($nrow=mysqli_fetch_assoc($prevmodulename))
            {
                $moduleid=$nrow['ModuleId'];
                $modulename=$nrow['ModuleName'];
                echo "<script>$('#center').append(`<div  id='quiztop' style='display: flex;
                        justify-content: center;
                        flex-wrap: wrap;'>
                            <div style='margin-right: 10px;'>
                                <img src='img/quizclip-removebg-preview.png' style='height: 62px;
                            width: 62px;' alt=''>
                            </div>
                            <div>
                                <h2 id='headingquiz$moduleid'>$modulename</h2>
                                <h4>Quiz to test the knowledge of learners</h4>
                            </div>
                        </div><form method='POST' id='quiz-form' style='margin-top: 28px;font-size: 1rem;'></form>`)</script>";
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
            <h4 style='width:100%;'>MCQ-$mcqid</h4>
            <label for='mcq$mcqid' id='mcq$mcqid' style='margin-top:12px;'>$que</label><br><br>`)</script>";
            $optionselect=$conn->prepare("SELECT * FROM `options` WHERE `McqId`=? AND `ModuleId`=? AND `CourseId`=?");
            $optionselect->bind_param('iii', $mcqid, $moduleid, $courseid);
            $optionselect->execute();
            $optionresult=$optionselect->get_result();
            while ($orow=mysqli_fetch_assoc($optionresult)) {
                $optid=$orow['OptionId'];
                $options=$orow['OptionStatement'];
                echo "<script>$('#quiz-form').append(`<input name='mcq$mcqid' type='radio' value='$options' style='margin-left: 26px;'>  $options<br><br>`)</script>";
            }
            
        }
        echo "<script>$('#quiz-form').append(`<input type='button' value='Submit'  onclick='submitquiz()'  id='quizsubmit' style='padding: 7px;
        width: 100%;cursor:pointer;
        font-size: 1.1rem;
        background-color: #1eb2a6;
        color: white;'>`)</script>";
        }
        
    }
    else
    {
        $prevtopic=$conn->prepare("SELECT topics.`TopicId`,topics.`TopicName`,module.`ModuleName` FROM `topics` INNER JOIN `module` ON module.`ModuleId`=topics.`ModuleId` AND module.`CourseId`=topics.`CourseId` WHERE topics.`TopicId`=? AND topics.`ModuleId`=? and topics.`CourseId`=?");
        $prevtopic->bind_param('iii',$prevtopicid,$moduleid,$courseid);
        $prevtopic->execute();
        $prevtopicres=$prevtopic->get_result();
        if(mysqli_num_rows($prevtopicres)>0)
        {
            while ($trow=mysqli_fetch_assoc($prevtopicres))
            {
                $tid = $trow['TopicId'];
            $topic = $trow['TopicName'];
            $modulename=$trow['ModuleName'];
            echo "<script>$('#newpage').append(`<section id='content-section'>
    <input class='course-material' type='text' id='module$moduleid' value='$modulename'disabled></section>`)</script>";
            echo "<script>$('#content-section').append(`<input class='course-material' type='text' id='topic$tid' value='$topic' disabled>`);</script>";
            //subtopic fetch
            $subselect = $conn->prepare('SELECT * FROM `subtopics` WHERE `CourseId`=? AND `ModuleId`=? AND `TopicId`=?');
            $subselect->bind_param('iii', $courseid, $moduleid, $tid);
            $subselect->execute();
            $subresult = $subselect->get_result();
            while ($strow = mysqli_fetch_assoc($subresult)) 
            {
                $subtopic=$strow['SubtopicName'];
                $subtopicid=$strow['SubtopicId'];
                $description=$strow['SubtopicDesc'];
                echo "<script>$('#content-section').append(`<hr><div class='main-description' id='main-desc$subtopicid'> <input class='course-material' type='text' id='sub-topic$subtopicid' value='$subtopic' disabled><pre class='course-material description-box' id='description$subtopicid'>$description</pre>`)</script>";

                //snippet fetch
                $snippetselect=$conn->prepare("SELECT `SnippetId`,`Code`,`Output` FROM `snippets` WHERE `TopicId`=$tid AND `ModuleId`=$moduleid AND `CourseId`=$courseid AND `SubtopicId`=$subtopicid");
                $snippetselect->execute();
                $snippetresult=$snippetselect->get_result();
                $srnum=mysqli_num_rows($snippetresult);
                if ($srnum>0) 
                {
                    while ($srow=mysqli_fetch_assoc($snippetresult)) 
                    {
                    $snippetid=$srow['SnippetId'];
                    $code=$srow['Code'];
                    $output=$srow['Output'];
                    echo "<script>$('#content-section').append(`<div class='description-details code-detail' id='codemaindiv$snippetid' style='display:block;'><div class='codesnippet code'><button class='codecopy' id='copybtn$snippetid' onclick='copy(this)'><i class='fal fa-copy'></i></button><pre id='code$snippetid' placeholder='print('''Hello World''')'disabled>$code</pre></div><div class='codesnippet'> <pre id='output$snippetid' placeholder='Hello World' disabled>$output</pre></div></div>`)</script>";
                    }
                }
            }
                
            }
        }
        else
        {
            $prevmodule=$conn->prepare("SELECT topics.`TopicId`, topics.`TopicName`,module.`ModuleName` FROM `topics` INNER JOIN `module` ON module.`ModuleId`=topics.`ModuleId` AND module.`CourseId`=topics.`CourseId` WHERE topics.`TopicId`=(SELECT MAX(`TopicId`) FROM `topics` WHERE topics.`ModuleId`=? and topics.`CourseId`=?) AND topics.`ModuleId`=? and topics.`CourseId`=?");
            $prevmodule->bind_param('iiii',$prevmoduleid,$courseid,$prevmoduleid,$courseid);
            $prevmodule->execute();
            $prevmodulename=$prevmodule->get_result();
            if(mysqli_num_rows($prevmodulename)>0)
            {
                while($nrow=mysqli_fetch_assoc($prevmodulename))
                {
                    $tid = $trow['TopicId'];
            $topic = $trow['TopicName'];
            $modulename=$trow['ModuleName'];
            echo "<script>$('#newpage').append(`<section id='content-section'>
    <input class='course-material' type='text' id='module$moduleid' value='$modulename'disabled></section>`)</script>";
            echo "<script>$('#content-section').append(`<input class='course-material' type='text' id='topic$tid' value='$topic' disabled>`);</script>";
            //subtopic fetch
            $subselect = $conn->prepare('SELECT * FROM `subtopics` WHERE `CourseId`=? AND `ModuleId`=? AND `TopicId`=?');
            $subselect->bind_param('iii', $courseid, $moduleid, $tid);
            $subselect->execute();
            $subresult = $subselect->get_result();
            while ($strow = mysqli_fetch_assoc($subresult)) 
            {
                $subtopic=$strow['SubtopicName'];
                $subtopicid=$strow['SubtopicId'];
                $description=$strow['SubtopicDesc'];
                echo "<script>$('#content-section').append(`<hr><div class='main-description' id='main-desc$subtopicid'> <input class='course-material' type='text' id='sub-topic$subtopicid' value='$subtopic' disabled><pre class='course-material description-box' id='description$subtopicid'>$description</pre>`)</script>";

                //snippet fetch
                $snippetselect=$conn->prepare("SELECT `SnippetId`,`Code`,`Output` FROM `snippets` WHERE `TopicId`=$tid AND `ModuleId`=$moduleid AND `CourseId`=$courseid AND `SubtopicId`=$subtopicid");
                $snippetselect->execute();
                $snippetresult=$snippetselect->get_result();
                $srnum=mysqli_num_rows($snippetresult);
                if ($srnum>0) 
                {
                    while ($srow=mysqli_fetch_assoc($snippetresult)) 
                    {
                    $snippetid=$srow['SnippetId'];
                    $code=$srow['Code'];
                    $output=$srow['Output'];
                    echo "<script>$('#content-section').append(`<div class='description-details code-detail' id='codemaindiv$snippetid' style='display:block;'><div class='codesnippet code'><button class='codecopy' id='copybtn$snippetid' onclick='copy(this)'><i class='fal fa-copy'></i></button><pre id='code$snippetid' placeholder='print('''Hello World''')'disabled>$code</pre></div><div class='codesnippet'> <pre id='output$snippetid' placeholder='Hello World' disabled>$output</pre></div></div>`)</script>";
                    }
                }
            }
                }
                                    
                   
            }
           
        }
    }




    if($topicid==2  && $moduleid==1)
    {
        echo "<script>$('#center').append(`<section id='btn-section'>
         <div class='textarea-buttons right'>
             <div class='right'>
             
             <button class='next' onclick='next()'>Next</button>
             </div>
         </div>
     </section>`)</script>";
    }
    else
    {
        echo "<script>$('#center').append(`<section id='btn-section'>
         <div class='textarea-buttons right'>
             <div class='right'>
             <button class='prev' onclick='previous()'>Previous</button>
             <button class='next' onclick='next()'>Next</button>
             </div>
         </div>
     </section>`)</script>";
    }
}

if ($action=="showsubtopic") {
    $courseid=$_POST['courseid'];
    $moduleid=$_POST['moduleid'];
    $topicid=$_POST['topicid'];
    $subtopicid=$_POST['subtopicid'];

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
            echo "<script>$('#content-section').append(`<input class='course-material' type='text' id='topic$topicid' value='$topic' placeholder='Topic Name: What is HTML?' disabled>`)</script>";
        }
    }


    // subtopic fetch
    $subtopicselect=$conn->prepare("SELECT `SubtopicId`,`SubtopicName`,`VideoDesc` FROM `subtopics` WHERE `TopicId`=$topicid AND `ModuleId`=$moduleid AND `CourseId`=$courseid");
    $subtopicselect->execute();
    $subtopicresult=$subtopicselect->get_result();
    $rnum=mysqli_num_rows($subtopicresult);
    if ($rnum>0) {
        $subselect = $conn->prepare('SELECT * FROM `subtopics` WHERE `CourseId`=? AND `ModuleId`=? AND `TopicId`=?');
            $subselect->bind_param('iii', $courseid, $moduleid, $topicid);
            $subselect->execute();
            $subresult = $subselect->get_result();
            while ($strow = mysqli_fetch_assoc($subresult)) 
            {
                $subtopic=$strow['SubtopicName'];
                $subtopicid=$strow['SubtopicId'];
                $description=$strow['SubtopicDesc'];
                echo "<script>$('#content-section').append(`<hr><div class='main-description' id='main-desc$subtopicid'> <input class='course-material' type='text' id='sub-topic$subtopicid' value='$subtopic' disabled><pre class='course-material description-box' id='description$subtopicid'>$description</pre>`)</script>";

                //snippet fetch
                $snippetselect=$conn->prepare("SELECT `SnippetId`,`Code`,`Output` FROM `snippets` WHERE `TopicId`=$topicid AND `ModuleId`=$moduleid AND `CourseId`=$courseid AND `SubtopicId`=$subtopicid");
                $snippetselect->execute();
                $snippetresult=$snippetselect->get_result();
                $srnum=mysqli_num_rows($snippetresult);
                if ($srnum>0) 
                {
                    while ($srow=mysqli_fetch_assoc($snippetresult)) 
                    {
                    $snippetid=$srow['SnippetId'];
                    $code=$srow['Code'];
                    $output=$srow['Output'];
                    echo "<script>$('#content-section').append(`<div class='description-details code-detail' id='codemaindiv$snippetid' style='display:block;'><div class='codesnippet code'><button class='codecopy' id='copybtn$snippetid' onclick='copy(this)'><i class='fal fa-copy'></i></button><pre id='code$snippetid' placeholder='print('''Hello World''')'disabled>$code</pre></div><div class='codesnippet'> <pre id='output$snippetid' placeholder='Hello World' disabled>$output</pre></div></div>`)</script>";
                    }
                }
            }
            
            
          
    } 
    if($topicid==1  && $moduleid==1)
    {
        echo "<script>$('#center').append(`<section id='btn-section'>
         <div class='textarea-buttons right'>
             <div class='right'>
             
             <button class='next' onclick='next()'>Next</button>
             </div>
         </div>
     </section>`)</script>";
    }
    else
    {
        echo "<script>$('#center').append(`<section id='btn-section'>
         <div class='textarea-buttons right'>
             <div class='right'>
             <button class='prev' onclick='previous()'>Previous</button>
                 <button class='next' onclick='next()'>Next</button>
             </div>
         </div>
     </section>`)</script>";
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
            echo "<script>$('#center').append(`<section id='newpage'><div id='titlecourse' class='title-top textarea-buttons'><div><button id='hamburger' onclick='opensidebar()'><i class='far fa-bars'></i></button><button class='right' id='tuttogglebtn' onclick='viewViewTutorial()'><i class='fal fa-play'></i>Video Tutorial</button></div><p class='course-material' id='course$courseid' style='display:block;'>$course</p></div><div id='title-of-course' class='title-top textarea-buttons'><button id='hamburger' onclick='opensidebar()'><i class='far fa-bars'></i></button><label for='course'>
            <h3 style='display:inline;'>Course Title: </h3>
        </label>
        <p class='course-material' id='course$courseid' style='display:inline-block;'>$course</p><button class='right' id='tuttogglebtn' onclick='viewVideoTutorial()'><i class='fal fa-play'></i>Video Tutorial</button></div></section>`)</script>";
            $assign=$row['Assignment'];
            echo "<script> $('#center').append(`<section id='assignment'>
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
                <pre class='course-material description-box' style='color:black;'>$assign</pre>
            </div>
            <div id='pasteurl' class='description-details description-box course-material' style='margin-top:26px; padding:12px;'>
                <strong style='text-transform: capitalize;'>you are required to submit you project link below:</strong>
                <input type='url'  pattern='https://.*' placeholder='https://jsfiddle.net' style='padding: 3px;
                display: block;
                width: 100%;
                margin: 18px 0px; outline:black; border: 2px solid;
                font-size: 1.2rem;margin-bottom: 20px;' required>
                <div class='textarea-buttons'>
    
                <button id='submitassbtn' onclick='submitass()'>Submit Assignment</button>
                </div> <br>
            </div>
        </section>`)</script>";
        }
    }
    echo "<script>$('#center').append(`<section id='btn-section'>
    <div class='textarea-buttons right'>
        <div class='right'>
        <button class='prev' onclick='previous()'>Previous</button>
        <button class='next' onclick='next()'>Next</button>
        </div>
    </div>
</section>`)</script>";
}

if($action=="openquiz")
{
    $courseid=$_POST['courseid'];
    $moduleid=$_POST['moduleid'];
    
    $currentmodule=$conn->prepare("SELECT module.`ModuleName` FROM  `module` WHERE `ModuleId`=? and `CourseId`=?");
        $currentmodule->bind_param('ii',$moduleid,$courseid);
        $currentmodule->execute();
        $currentmodulename=$currentmodule->get_result();
        if(mysqli_num_rows($currentmodulename)>0)
        {
            // quiz fetch
            while($nrow=mysqli_fetch_assoc($currentmodulename))
            {
                $modulename=$nrow['ModuleName'];
                echo "<script>$('#center').append(`<div id='quiztop' style='display: flex;
                        justify-content: center;
                        flex-wrap: wrap;'>
                            <div style='margin-right: 10px;'>
                                <img src='img/quizclip-removebg-preview.png' style='height: 62px;
                            width: 62px;' alt=''>
                            </div>
                            <div>
                                <h2 id='headingquiz$moduleid'>$modulename</h2>
                                <h4>Quiz to test the knowledge of learners</h4>
                            </div>
                        </div><form method='POST' id='quiz-form' style='margin-top: 28px;font-size: 1rem;'></form>`)</script>";
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
            <h4 style='width:100%;'>MCQ-$mcqid</h4>
            <label for='mcq$mcqid' id='mcq$mcqid' style='margin-top:12px;'>$que</label><br><br>`)</script>";
            $optionselect=$conn->prepare("SELECT * FROM `options` WHERE `McqId`=? AND `ModuleId`=? AND `CourseId`=?");
            $optionselect->bind_param('iii', $mcqid, $moduleid, $courseid);
            $optionselect->execute();
            $optionresult=$optionselect->get_result();
            while ($orow=mysqli_fetch_assoc($optionresult)) {
                $optid=$orow['OptionId'];
                $options=$orow['OptionStatement'];
                echo "<script>$('#quiz-form').append(`<input name='mcq$mcqid' type='radio' value='$options' style='margin-left: 26px;'>  $options<br><br>`)</script>";
            }
            
        }
        echo "<script>$('#quiz-form').append(`<input type='button' value='Submit' id='quizsubmit' onclick='submitquiz()' style='padding: 7px;
        width: 100%;cursor:pointer;
        font-size: 1.1rem;
        background-color: #1eb2a6;
        color: white;'>`)</script>";
        }

        echo "<script>$('#center').append(`<section id='btn-section'>
    <div class='textarea-buttons right'>
        <div class='right'>
        <button class='prev' onclick='previous()'>Previous</button>
        <button class='next' onclick='next()'>Next</button>
        </div>
    </div>
</section>`)</script>";
}

if($action=="quizsubmit")
{
    $courseid=$_POST['courseid'];
    $moduleid=$_POST['moduleid'];
    $username=$_SESSION['username'];
    $mcq1=$_POST['mcq1'];
    $mcq2=$_POST['mcq2'];
    $mcq3=$_POST['mcq3'];
    $mcq4=$_POST['mcq4'];
    $mcq5=$_POST['mcq5'];
    $correct=0;
    $checkenrollment=$conn->prepare("SELECT * FROM `enrollment` WHERE `username`=? AND `courseid`=?");
        $checkenrollment->bind_param('si',$username,$courseid);
        $checkenrollment->execute();
        $checkenrollmentresult=$checkenrollment->get_result();
        if(mysqli_num_rows($checkenrollmentresult)==0)
        {
            echo "2";
          
        }        
        else
        {
            $checkattempt=$conn->prepare("SELECT * FROM `attemptquiz` WHERE `CourseId`=? AND `ModuleId`=? AND `username`=?");
            $checkattempt->bind_param('iis',$courseid,$moduleid,$username);
            $checkattempt->execute();
            $checkattemptresult=$checkattempt->get_result();
            if(mysqli_num_rows($checkattemptresult)>0)
            {
                echo "1";
                
            }
            else
            {
                for($i=1;$i<=5;$i++)
                {
                    $selectans=$conn->prepare("SELECT `Answer` FROM `mcqs` WHERE `CourseId`=? AND `ModuleId`=? AND `McqId`=?");
                    $selectans->bind_param('iii',$courseid,$moduleid,$i);
                    $selectans->execute();
                    $selectedans=$selectans->get_result();
                    if(mysqli_num_rows($selectedans)>0)
                    {
                        while($row=mysqli_fetch_assoc($selectedans))
                        {
                            $option=$row['Answer'];
                            $mcqno="mcq".$i;
                            if($option==${$mcqno})
                            {
                                
                                echo "<script>$('#mcq$i').css('background-color','green')</script>";
                               
                                echo "<script>$('#mcq$i').css('color','white')</script>";
                                echo "<script>$('#mcq$i').css('width','100%')</script>";
                            }
                            else
                            {
                                echo "<script>$('#mcq$i').append(`<span style='color:white;display:block; padding:12px 0px;'>correct ans:$option</span>`)</script>";
                                echo "<script>$('#mcq$i').css('background-color','red')</script>";
                                echo "<script>$('#mcq$i').css('color','white')</script>";
                            }
                        }
                    }
                }
                echo "<script>$('#quiz$moduleid').siblings('input').prop('checked',true)</script>";
                $updateattempt=$conn->prepare("INSERT INTO `attemptquiz` VALUES(?,?,?)");
                $updateattempt->bind_param('iis',$courseid,$moduleid,$username);
                $updateattempt->execute();
            }
            
            
        }
}
if($action=="assignmentsubmit")
{
    $courseid=(int)$_POST['courseid'];
    $username=$_SESSION['username'];
    $assurl=$_POST['assurl'];
    
    $checkenrollment=$conn->prepare("SELECT * FROM `enrollment` WHERE `username`=? AND `courseid`=?");
        $checkenrollment->bind_param('si',$username,$courseid);
        $checkenrollment->execute();
        $checkenrollmentresult=$checkenrollment->get_result();
        if(mysqli_num_rows($checkenrollmentresult)==0)
        {
            echo 2;
        }        
        else
        {
            $checkattempt=$conn->prepare("SELECT * FROM `enrollment` WHERE `CourseId`=? AND `username`=?");
            $checkattempt->bind_param('is',$courseid,$username);
            $checkattempt->execute();
            $checkattemptresult=$checkattempt->get_result();
            if(mysqli_num_rows($checkattemptresult)>0)
            {
                while($row=mysqli_fetch_assoc($checkattemptresult))
                {
                    $url=$row['AssignmentUrl'];
                    if($url!=NULL)
                    {
                        echo 1;
                    }
                    else
                    {
                        $addass=$conn->prepare("UPDATE `enrollment` SET `AssignmentUrl`=? WHERE `Username`=? AND `CourseId`=?");
                        $addass->bind_param('ssi',$assurl,$username,$courseid);
                        $addass->execute();
                    }
                
                }
            
                   
                
               
            }
            
            
        }
}

if($action=="certificatebtn")
{
    $courseid=$_POST['courseid'];
    $username=$_SESSION["username"];
    $totalquiz=$conn->prepare("SELECT COUNT(ModuleId) as 'NO' FROM `module` WHERE `CourseId`=?");
    $totalquiz->bind_param('i',$courseid);
    $totalquiz->execute();
    $quizNumber=mysqli_fetch_assoc($totalquiz->get_result());
    $quizzes=$quizNumber['NO'];

    $attemptquiz=$conn->prepare("SELECT COUNT(ModuleId) as 'ATTEMPT' FROM `attemptquiz` WHERE `CourseId`=? AND `username`=?");
    $attemptquiz->bind_param('is',$courseid,$username);
    $attemptquiz->execute();
    $attemptquizNumber=mysqli_fetch_assoc($attemptquiz->get_result());
    $attempted=$attemptquizNumber['ATTEMPT'];

    if($quizzes==$attempted)
    {
        $checkassignment=$conn->prepare("SELECT `AssignmentUrl` FROM `enrollment` WHERE `CourseId`=? AND `username`=? AND `AssignmentUrl` IS NOT NULL");
        $checkassignment->bind_param('is',$courseid,$username);
        $checkassignment->execute();
        if(mysqli_num_rows($checkassignment->get_result())>0)
        {
            $checkcompletion=$conn->prepare("SELECT `Certification` FROM `enrollment` WHERE `CourseId`=? AND `username`=? AND `Certification` IS NOT NULL");
            $checkcompletion->bind_param('is',$courseid,$username);
            $checkcompletion->execute();
            if(mysqli_num_rows($checkcompletion->get_result())>0)
            {
                $couresname=$conn->prepare("SELECT `CourseName` FROM `courses` WHERE `CourseId`=?");
                $couresname->bind_param('i',$courseid);
                $couresname->execute();
                $coursenameres=$couresname->get_result();
                $coursedata=mysqli_fetch_assoc($coursenameres);
                $course=$coursedata["CourseName"];
                echo $course;
            }
            else
            {
                
                $rate=$conn->prepare("SELECT assignment_comment.`rating`,assignment_comment.`assignment_id`,assignment_comment.`assignment_topic` FROM `assignment_comment` LEFT JOIN `courses` ON courses.`CourseName`=assignment_comment.`assignment_topic` WHERE courses.`CourseId`=? AND assignment_comment.`sender_name`=?");
                $rate->bind_param('is',$courseid,$username);
                $rate->execute();
                $rating=$rate->get_result();
                if(mysqli_num_rows($rating)>0)
                {
                    $rates=mysqli_fetch_assoc($rating);
                    $sum=$rates['rating'];
                    $course=$rates['assignment_topic'];
                    $assignmentId=$rates['assignment_id'];
                    $stmt3 = $conn->prepare("SELECT COUNT(assignment_id) AS review  from `assignment_reviewers` WHERE assignment_id=?");
                    $stmt3->bind_param("i", $assignmentId);
                    $stmt3->execute();
                    $stmt3res = $stmt3->get_result();
            
                    while ($row1 = mysqli_fetch_assoc($stmt3res)) {
                        $times = $row1["review"];
                        if ($times != 0) {
                            $sumrate = $sum / $times;
                            $prcnt = (($sumrate) / 5) * 100;
                            $r = substr($sumrate, 0, 3);
                        } else {
                            $times = 0;
                            $sumrate = 0;
                            $r = 0;
                            $prcnt = 0;
                        }
                    }
                    if($times>=3 && $sumrate>=5)
                    {
                        $complete="completed";
                        $date=date('y-m-d');
                        $ensurecompletion=$conn->prepare("UPDATE `enrollment` SET `Certification`=?,`Date`=? WHERE `CourseId`=? AND `username`=?");
                        $ensurecompletion->bind_param('ssis',$complete,$date,$courseid,$username);
                        $ensurecompletion->execute();
                        $certificateemail=$conn->prepare("SELECT `email` FROM `registration` WHERE `username`=?");
                        $certificateemail->bind_param('s',$username);
                        $certificateemail->execute();
                        $certificateresult=$certificateemail->get_result();
                        $row4 = mysqli_fetch_assoc($certificateresult);
                        $emailforcertificate=$row4["email"];
                        smtp_mailer($emailforcertificate,'Email Verification');
                        echo $course;
                    }
                    else
                    {
                        echo 3;
                    }
                }
                else
                {
                    echo 4;
                }
                
                
            }   
        }
        else
        {
            echo 5;
        }
        
    }
    else
    {
        echo 2;
    }
}


function smtp_mailer($to,$subject){
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
	$mail->Body = '<p> Congratultaions!.Your course cerificate complatetion certificate is enabled. To view visit your account</p>';
    
	$mail->AddAddress($to);
	$mail->SMTPOptions=array('ssl'=>array(
		'verify_peer'=>false,
		'verify_peer_name'=>false,
		'allow_self_signed'=>false
	));
	
}


    $conn->close();
?>
