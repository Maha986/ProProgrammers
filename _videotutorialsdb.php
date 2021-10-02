<?php

    require '_dbconnect.php';
    $action = $_POST['action'];
    if ($action == 'fetchcoursedata') {
        $courseid = $_POST['courseid'];
        //course name fetch
        $courseselect = $conn->prepare('SELECT * FROM `courses` WHERE `CourseId`=?');
        $courseselect->bind_param('i', $courseid);
        $courseselect->execute();
        $courseresult = $courseselect->get_result();
        while ($row = mysqli_fetch_assoc($courseresult)) {
            $course = $row['CourseName'];
            echo "<script>$('#main-page').append(`<div id='navigation-menu'></div><div id='right-side'></div>`);$('#navigation-menu').prepend(`<h1 id='ulvcourse$courseid' style='text-align:center;'>$course</h1>`);$('#navigation-menu').append(`<ul class='moduleul'></ul>`);$('#right-side').append(`<section id='newpage'><div id='title-of-course'><label for='course'>
            <h3 style='display:inline;'>Course Title: </h3>
        </label>
        <input class='course-material' type='text' name='course' disabled id='course$courseid' value='$course' style='display:inline;'></div></section>`);</script>";

            //module fetch
            $moduleselect = $conn->prepare('SELECT * FROM `module` WHERE `CourseId`=?');
            $moduleselect->bind_param('i', $courseid);
            $moduleselect->execute();
            $moduleresult = $moduleselect->get_result();
            while ($mrow = mysqli_fetch_assoc($moduleresult)) {
                $moduleid = $mrow['ModuleId'];
                $module = $mrow['ModuleName'];
                echo "<script>$('.moduleul').append(`<li><i class='fas fa-caret-down'></i><a id='ulvmodule$moduleid'>$module</a><ul class='topicul'>          
    </ul></li>`);</script>";
                if ($moduleid == 1) {
                    echo "<script>$('#newpage').append(`<section id='content-section'>
        <input class='course-material' type='text' id='module$moduleid' value='$module' placeholder='Module Name: Overview' disabled></section>`)</script>";
                }

                //topic fetch
                $topicselect = $conn->prepare('SELECT * FROM `topics` WHERE `CourseId`=? AND `ModuleId`=?');
                $topicselect->bind_param('ii', $courseid, $moduleid);
                $topicselect->execute();
                $topicresult = $topicselect->get_result();
                while ($trow = mysqli_fetch_assoc($topicresult)) {
                    $topicid = $trow['TopicId'];
                    $topic = $trow['TopicName'];
                    echo "<script>$('#ulvmodule$moduleid').next().append(`<li><i class='fas fa-caret-down'></i><a id='mod".$moduleid."ulvtopic$topicid'>$topic</a> <ul class='subtopicul'></ul></li>`);</script>";
                    if ($topicid == 1 && $moduleid==1) {
                        echo "<script>$('#content-section').append(`<input class='course-material' type='text' id='topic$topicid' value='$topic' placeholder='Topic Name: What is HTML?' disabled>`);</script>";

                        
                    }
                    //subtopic fetch
                    $subselect = $conn->prepare('SELECT * FROM `subtopics` WHERE `CourseId`=? AND `ModuleId`=? AND `TopicId`=?');
                    $subselect->bind_param('iii', $courseid, $moduleid, $topicid);
                    $subselect->execute();
                    $subresult = $subselect->get_result();
                    while ($strow = mysqli_fetch_assoc($subresult)) {
                        $subtopicid = $strow['SubtopicId'];
                        $subtopic = $strow['SubtopicName'];
                        $subdesc = $strow['SubtopicDesc'];

                        echo "<script>$('#ulvmodule$moduleid').siblings().find('#mod".$moduleid."ulvtopic$topicid').siblings('.subtopicul').append(`<li><a id='smod".$moduleid."ulvtop".$topicid."subtopic$subtopicid' onclick='openSubTopic(this)'>$subtopic</a></li>`)</script>";

                        if ($topicid == 1 && $moduleid==1) {
                            echo "<script>$('#content-section').append(`<div class='main-description' id='main-desc$subtopicid'> <input class='course-material' type='text' id='sub-topic$subtopicid' value='$subtopic' style='margin:40px 7px;' disabled><div class='textarea-buttons'><button id='videoupload$subtopicid' class='videoupload' onclick='uploadvideo()'><a id='uploadvideo' href='videos.php' target='left_side'>Upload Video</a></button></div><div class='description-details'><textarea class='course-material description-box' id='description$subtopicid' cols='30' rows='6' placeholder='This video gives the information about why and how HTML has came to existence.'></textarea>`)</script>";

                            echo "<script>$('#content-section').append(`<div class='textarea-buttons right' id='btndiv$subtopicid'><button class='savebtn' id='vsave$subtopicid' onclick='vsave(this)' style='display:inline-block;'>Save</button>
                            <button class='saveedit' id='vsaveedit$subtopicid' onclick='vsaveEdit(this)' style='display:none;'>Save Changes</button>
                            <button class='editbtn' id='vediting$subtopicid' onclick='veditSubTopic(this)' style='display:none;'>Edit
                            Description</button></div>
                            <br><br>
                            </div>
                            </div>`)</script>";
                        }
                    }
                    
                }

                //quiz fetch
                // $quizselect=$conn->prepare("SELECT * FROM `mcqs` WHERE `ModuleId`=? AND `CourseId`=?");
                // echo "<script>$('#ulvmodule$moduleid').siblings('.topicul').append(`<li><img src='https://img.icons8.com/material-rounded/11/000000/questions.png'/><a id='vquiz$moduleid' onclick='openvQuiz(this)'>Quiz</a></li>`)</script>";
            }
            //assignment fetch
            // echo "<script>$('.moduleul').append(`<li><img src='https://img.icons8.com/ios-filled/11/000000/laptop-coding.png'/><a id='ulvassignment$courseid' onclick='openvAss()'>Assignment</a></li>`);</script>";

            //practice problem fetch
            // echo "<script>$('.moduleul').append(`<li><img src='https://img.icons8.com/ios-filled/11/000000/laptop-coding.png'/><a id='ulvpractice$courseid' onclick='openvPractice()'>Practice</a></li>`);</script>";

            //next button
            echo "<script>$('#newpage').append(`<section id='btn-section'>
            <div class='textarea-buttons right'>
                <div class='right'>
                    <button onclick='next()'>Next</button>
                </div>
            </div>
        </section>`)</script>";
        }
    }

    if ($action=="fetchnextpage")
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
        <input class='course-material' type='text' id='module$moduleid' value='$modulename' placeholder='Module Name: Overview' disabled></section>`)</script>";
                echo "<script>$('#content-section').append(`<input class='course-material' type='text' id='topic$tid' value='$topic' disabled>`);</script>";
                //subtopic fetch
                $subselect = $conn->prepare('SELECT * FROM `subtopics` WHERE `CourseId`=? AND `ModuleId`=? AND `TopicId`=?');
                $subselect->bind_param('iii', $courseid, $moduleid, $tid);
                $subselect->execute();
                $subresult = $subselect->get_result();
                while ($strow = mysqli_fetch_assoc($subresult)) 
                {
                    $subtopicid = $strow['SubtopicId'];
                    $subtopic = $strow['SubtopicName'];
                    $videodesc=$strow['VideoDesc'];
                    if($videodesc==NULL)
                    {
                        echo "<script>$('#content-section').append(`<div class='main-description' id='main-desc$subtopicid'> <input class='course-material' type='text' id='sub-topic$subtopicid' value='$subtopic' style='margin:40px 7px;' disabled><div class='textarea-buttons'><button id='videoupload$subtopicid' class='videoupload' onclick='uploadvideo()'><a id='uploadvideo' href='videos.php' target='left_side'>Upload Video</a></button></div><div class='description-details'><textarea class='course-material description-box' id='description$subtopicid' cols='30' rows='6' placeholder='This video gives the information about why and how HTML has came to existence.'></textarea>`)</script>";

                        echo "<script>$('#content-section').append(`<div class='textarea-buttons right' id='btndiv$subtopicid'><button class='savebtn' id='vsave$subtopicid' onclick='vsave(this)' style='display:inline-block;'>Save</button>
                        <button class='saveedit' id='vsaveedit$subtopicid' onclick='vsaveEdit(this)' style='display:none;'>Save Changes</button>
                        <button class='editbtn' id='vediting$subtopicid' onclick='veditSubTopic(this)' style='display:none;'>Edit
                        Description</button></div>
                        <br><br>
                        </div>
                        </div>`)</script>";
                    }
                    else
                    {
                        echo "<script>$('#content-section').append(`<div class='main-description' id='main-desc$subtopicid'> <input class='course-material' type='text' id='sub-topic$subtopicid' value='$subtopic' style='margin:40px 7px;' disabled><div class='description-details'><textarea class='course-material description-box' id='description$subtopicid' cols='30' rows='6'>$videodesc</textarea>`)</script>";

                        echo "<script>$('#content-section').append(`<div class='textarea-buttons right' id='btndiv$subtopicid'><button class='savebtn' id='vsave$subtopicid' onclick='vsave(this)' style='display:inline-block;' disabled>&#10004; Saved!</button>
                        <button class='vsaveedit' id='saveedit$subtopicid' onclick='vsaveEdit(this)' style='display:none;'>Save Changes</button>
                        <button class='veditbtn' id='editing$subtopicid' onclick='veditSubTopic(this)' style='display:inline-block;'>Edit
                        Description</button></div>
                        <br><br>
                        </div>
                        </div>`)</script>";
                    }

                    
                        
                    
                    
                }
            }
        }
        else
        {
            // echo "entered<br>";
            $tid=1;
            // echo $tid."    ".$moduleid."  ".$courseid;
            $nextmodule=$conn->prepare("SELECT topics.`TopicName`,module.`ModuleName` FROM `topics` INNER JOIN `module` ON module.`ModuleId`=topics.`ModuleId` AND module.`CourseId`=topics.`CourseId` WHERE topics.`TopicId`=? AND topics.`ModuleId`=? and topics.`CourseId`=?");
            $nextmodule->bind_param('iii',$tid,$nextmoduleid,$courseid);
            $nextmodule->execute();
            $nextmodulename=$nextmodule->get_result();
            if(mysqli_num_rows($nextmodulename)>0)
            {
                // echo "entered4";
                while($nrow=mysqli_fetch_assoc($nextmodulename))
                {
                    // echo "entered20";
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
                        $subtopicid = $strow['SubtopicId'];
                        $subtopic = $strow['SubtopicName'];
                        $videodesc=$strow['VideoDesc'];
                        if($videodesc==NULL)
                        {
                            echo "<script>$('#content-section').append(`<div class='main-description' id='main-desc$subtopicid'> <input class='course-material' type='text' id='sub-topic$subtopicid' value='$subtopic' style='margin:40px 7px;' disabled><div class='textarea-buttons'><button id='videoupload$subtopicid' class='videoupload' onclick='uploadvideo()'><a id='uploadvideo' href='videos.php' target='left_side'>Upload Video</a></button></div> 
                        <div class='description-details'><textarea class='course-material description-box' id='description$subtopicid' cols='30' rows='6' placeholder='This video gives the information about why and how HTML has came to existence.'></textarea>`)</script>";

                            echo "<script>$('#content-section').append(`<div class='textarea-buttons right' id='btndiv$subtopicid'><button class='savebtn' id='vsave$subtopicid' onclick='vsave(this)' style='display:inline-block;'>Save</button>
                            <button class='saveedit' id='vsaveedit$subtopicid' onclick='vsaveEdit(this)' style='display:none;'>Save Changes</button>
                            <button class='editbtn' id='vediting$subtopicid' onclick='veditSubTopic(this)' style='display:none;'>Edit
                            Description</button></div>
                            <br><br>
                            </div>
                            </div>`)</script>";
                        }
                        else
                        {
                            echo "<script>$('#content-section').append(`<div class='main-description' id='main-desc$subtopicid'> <input class='course-material' type='text' id='sub-topic$subtopicid' value='$subtopic' style='margin:40px 7px;' disabled><div class='description-details'><textarea class='course-material description-box' id='description$subtopicid' cols='30' rows='6'>$videodesc</textarea>`)</script>";

                            echo "<script>$('#content-section').append(`<div class='textarea-buttons right' id='btndiv$subtopicid'><button class='savebtn' id='vsave$subtopicid' onclick='vsave(this)' style='display:inline-block;' disabled>&#10004; Saved!</button>
                            <button class='saveedit' id='vsaveedit$subtopicid' onclick='vsaveEdit(this)' style='display:none;'>Save Changes</button>
                            <button class='editbtn' id='vediting$subtopicid' onclick='veditSubTopic(this)' style='display:inline-block;'>Edit
                            Description</button></div>
                            <br><br>
                            </div>
                            </div>`)</script>";
                        } 
                        
                    }
                }
            }
           
        }
        $tid=$nexttopicid+1;
        $nextselect=$conn->prepare("SELECT * FROM `topics` WHERE `CourseId`=? AND `ModuleId`=? AND `TopicId`=?");
        $nextselect->bind_param('iii',$courseid,$moduleid,$tid);
        $nextselect->execute();
        $nextselectresult=$nextselect->get_result();
        if(mysqli_num_rows($nextselectresult)>0)
        {
             //next button
            
             echo "<script>$('#newpage').append(`<section id='btn-section'>
             <div class='textarea-buttons right'>
                 <div class='right'>
                 <button onclick='previous()'>Previous</button>
                     <button onclick='next()'>Next</button>
                 </div>
             </div>
         </section>`)</script>";
        }
        else
        {
            $nextselect=$conn->prepare("SELECT * FROM `topics` WHERE `CourseId`=? AND `ModuleId`=? AND `TopicId`!=(SELECT MAX(`TopicId`) FROM `topics` WHERE `ModuleId`=? AND `CourseId`=?)");
        $nextselect->bind_param('iiii',$courseid,$nextmoduleid,$nextmoduleid,$courseid);
        $nextselect->execute();
        $nextselectresult=$nextselect->get_result();
        if(mysqli_num_rows($nextselectresult)>0)
        {
             //next button
             echo "<script>$('#newpage').append(`<section id='btn-section'>
             <div class='textarea-buttons right'>
                 <div class='right'>
                 <button onclick='previous()'>Previous</button>
                     <button onclick='next()'>Next</button>
                 </div>
             </div>
         </section>`)</script>";
        }
        else
        {
            echo "<script>$('#newpage').append(`<section id='btn-section'>
            <div class='textarea-buttons right'>
                <div class='right'>
                    <button onclick='previous()'>Previous</button>
                    <button onclick='coursecomplete()'>Save Course</button>
                    
                </div>
            </div>
        </section>`)</script>";
        }
        }
    
    }
    if ($action=="fetchpreviouspage")
    {
        $courseid=$_POST['courseid'];
        $moduleid=$_POST['moduleid'];
        $modulename=$_POST['modulename'];
        $topicid=$_POST['topicid'];
        $prevtopicid=(int)$topicid-1;
        $prevmoduleid=(int)$moduleid-1;
        $prevtopic=$conn->prepare("SELECT * FROM `topics` WHERE `CourseId`=? AND `ModuleId`=? AND `TopicId`=?");
        $prevtopic->bind_param('iii',$courseid,$moduleid,$prevtopicid);
        $prevtopic->execute();
        $prevtopicres=$prevtopic->get_result();
        if(mysqli_num_rows($prevtopicres)>0)
        {
            while ($trow=mysqli_fetch_assoc($prevtopicres))
            {
                $tid = $trow['TopicId'];
                $topic = $trow['TopicName'];
                echo "<script>$('#newpage').append(`<section id='content-section'>
        <input class='course-material' type='text' id='module$moduleid' value='$modulename' placeholder='Module Name: Overview' disabled></section>`)</script>";
                echo "<script>$('#content-section').append(`<input class='course-material' type='text' id='topic$tid' value='$topic' disabled>`);</script>";
                //subtopic fetch
                $subselect = $conn->prepare('SELECT * FROM `subtopics` WHERE `CourseId`=? AND `ModuleId`=? AND `TopicId`=?');
                $subselect->bind_param('iii', $courseid, $moduleid, $tid);
                $subselect->execute();
                $subresult = $subselect->get_result();
                while ($strow = mysqli_fetch_assoc($subresult)) 
                {
                    $subtopicid = $strow['SubtopicId'];
                    $subtopic = $strow['SubtopicName'];
                    $videodesc=$strow['VideoDesc'];
                    
                    if($videodesc==NULL)
                    {
                        echo "<script>$('#content-section').append(`<div class='main-description' id='main-desc$subtopicid'> <input class='course-material' type='text' id='sub-topic$subtopicid' value='$subtopic' style='margin:40px 7px;' disabled><div class='textarea-buttons'><button id='videoupload$subtopicid' class='videoupload' onclick='uploadvideo()'><a id='uploadvideo' href='videos.php' target='left_side'>Upload Video</a></button></div>
                    <div class='description-details'><textarea class='course-material description-box' id='description$subtopicid' cols='30' rows='6' placeholder='This video gives the information about why and how HTML has came to existence.'></textarea>`)</script>";

                        echo "<script>$('#content-section').append(`<div class='textarea-buttons right' id='btndiv$subtopicid'><button class='savebtn' id='vsave$subtopicid' onclick='vsave(this)' style='display:inline-block;'>Save</button>
                        <button class='saveedit' id='vsaveedit$subtopicid' onclick='vsaveEdit(this)' style='display:none;'>Save Changes</button>
                        <button class='editbtn' id='vediting$subtopicid' onclick='veditSubTopic(this)' style='display:none;'>Edit
                        Description</button></div>
                        <br><br>
                        </div>
                        </div>`)</script>";
                    }
                    else
                    {
                        echo "<script>$('#content-section').append(`<div class='main-description' id='main-desc$subtopicid'> <input class='course-material' type='text' id='sub-topic$subtopicid' value='$subtopic' style='margin:40px 7px;' disabled><div class='description-details'><textarea class='course-material description-box'  placeholder='This video gives the information about why and how HTML has came to existence.' id='description$subtopicid' cols='30' rows='6'>$videodesc</textarea>`)</script>";

                        echo "<script>$('#content-section').append(`<div class='textarea-buttons right' id='btndiv$subtopicid'><button class='savebtn' id='vsave$subtopicid' onclick='vsave(this)' style='display:inline-block;' disabled>&#10004; Saved!</button>
                        <button class='saveedit' id='vsaveedit$subtopicid' onclick='vsaveEdit(this)' style='display:none;'>Save Changes</button>
                        <button class='editbtn' id='vediting$subtopicid' onclick='veditSubTopic(this)' style='display:inline-block;'>Edit
                        Description</button></div>
                        <br><br>
                        </div>
                        </div>`)</script>";
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
                    $modulename=$nrow['ModuleName'];
                    $topic = $nrow['TopicName'];
                    $tid=$nrow['TopicId'];
                    echo "<script>$('#newpage').append(`<section id='content-section'>
        <input class='course-material' type='text' id='module$prevmoduleid' value='$modulename' placeholder='Module Name: Overview' disabled></section>`)</script>";
        echo "<script>$('#content-section').append(`<input class='course-material' type='text' id='topic$tid' value='$topic' disabled>`);</script>";
                    //subtopic fetch
                    $subselect = $conn->prepare('SELECT * FROM `subtopics` WHERE `CourseId`=? AND `ModuleId`=? AND `TopicId`=?');
                    $subselect->bind_param('iii', $courseid, $prevmoduleid, $tid);
                    $subselect->execute();
                    $subresult = $subselect->get_result();
                    while ($strow = mysqli_fetch_assoc($subresult)) 
                    {
                        $subtopicid = $strow['SubtopicId'];
                        $subtopic = $strow['SubtopicName'];
                        $videodesc=$strow['VideoDesc'];
                        if($videodesc==NULL)
                        {
                            echo "<script>$('#content-section').append(`<div class='main-description' id='main-desc$subtopicid'> <input class='course-material' type='text' id='sub-topic$subtopicid' value='$subtopic' style='margin:40px 7px;' disabled><div class='textarea-buttons'><button id='videoupload$subtopicid' class='videoupload' onclick='uploadvideo()'><a id='uploadvideo' href='videos.php' target='left_side'>Upload Video</a></button></div> 
                        <div class='description-details'><textarea class='course-material description-box' id='description$subtopicid' cols='30' rows='6' placeholder='This video gives the information about why and how HTML has came to existence.'></textarea>`)</script>";

                            echo "<script>$('#content-section').append(`<div class='textarea-buttons right' id='btndiv$subtopicid'><button class='savebtn' id='vsave$subtopicid' onclick='vsave(this)' style='display:inline-block;'>Save</button>
                            <button class='saveedit' id='vsaveedit$subtopicid' onclick='vsaveEdit(this)' style='display:none;'>Save Changes</button>
                            <button class='editbtn' id='vediting$subtopicid' onclick='veditSubTopic(this)' style='display:none;'>Edit
                            Description</button></div>
                            <br><br>
                            </div>
                            </div>`)</script>";
                        }
                        else
                        {
                        echo "<script>$('#content-section').append(`<div class='main-description' id='main-desc$subtopicid'> <input class='course-material' type='text' id='sub-topic$subtopicid' value='$subtopic' style='margin:40px 7px;' disabled><div class='description-details'><textarea class='course-material description-box' id='description$subtopicid' cols='30' rows='6' placeholder='This video gives the information about why and how HTML has came to existence.'>$videodesc</textarea>`)</script>";

                            echo "<script>$('#content-section').append(`<div class='textarea-buttons right' id='btndiv$subtopicid'><button class='savebtn' id='vsave$subtopicid' onclick='vsave(this)' style='display:inline-block;' disabled>&#10004; Saved!</button>
                            <button class='saveedit' id='vsaveedit$subtopicid' onclick='vsaveEdit(this)' style='display:none;'>Save Changes</button>
                            <button class='editbtn' id='vediting$subtopicid' onclick='veditSubTopic(this)' style='display:inline-block;'>Edit
                            Description</button></div>
                            <br><br>
                            </div>
                            </div>`)</script>";     
                        }                   
                    }
                }
            }
           
        }

        $prevselect=$conn->prepare("SELECT * FROM `topics` WHERE `CourseId`=? AND `ModuleId`=? AND `TopicId`=?");
        $prevselect->bind_param('iii',$courseid,$moduleid,$prevtopicid);
        $prevselect->execute();
        $prevselectresult=$prevselect->get_result();
        if(mysqli_num_rows($prevselectresult)>0 && ($moduleid!=1 && $topicid!=1))
        {
             //prev button
           
             echo "<script>$('#newpage').append(`<section id='btn-section'>
             <div class='textarea-buttons right'>
                 <div class='right'>
                 <button onclick='previous()'>Previous</button>
                     <button onclick='next()'>Next</button>
                 </div>
             </div>
         </section>`)</script>";
        }
        else
        {
            
            $prevselect=$conn->prepare("SELECT * FROM `topics` WHERE `CourseId`=? AND `ModuleId`=? AND `TopicId`=(SELECT MAX(TopicId) WHERE CourseId=? AND ModuleId=?)");
        $prevselect->bind_param('iiii',$courseid,$prevmoduleid,$courseid,$prevmoduleid);
        $prevselect->execute();
        $prevselectresult=$prevselect->get_result();
        if(mysqli_num_rows($prevselectresult)>0 && !($moduleid==1 && $topicid==1))
        {
            
             //prev button
             echo "<script>$('#newpage').append(`<section id='btn-section'>
             <div class='textarea-buttons right'>
                 <div class='right'>
                 <button onclick='previous()'>Previous</button>
                     <button onclick='next()'>Next</button>
                 </div>
             </div>
         </section>`)</script>";
        }
        else
        {
            if($moduleid!=1 && $topicid!==1)
            {
                
                echo "<script>$('#newpage').append(`<section id='btn-section'>
                <div class='textarea-buttons right'>
                    <div class='right'>
                        <button onclick='previous()'>Previous</button>
                        <button onclick='coursecomplete()'>Save Course</button>
                        
                    </div>
                </div>
            </section>`)</script>";
            }
            else
            {
                echo "<script>$('#newpage').append(`<section id='btn-section'>
             <div class='textarea-buttons right'>
                 <div class='right'>
                     <button onclick='next()'>Next</button>
                 </div>
             </div>
         </section>`)</script>";
            }
            
        }
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
            while ($row=mysqli_fetch_assoc($subtopicresult)) {
                $subtopic=$row['SubtopicName'];
                $subtopicid=$row['SubtopicId'];
                $videodesc=$row['VideoDesc'];
                        if($videodesc==NULL)
                        {
                            echo "<script>$('#content-section').append(`<div class='main-description' id='main-desc$subtopicid'> <input class='course-material' type='text' id='sub-topic$subtopicid' value='$subtopic' style='margin:40px 7px;' disabled><div class='textarea-buttons'><button id='videoupload$subtopicid' class='videoupload' onclick='uploadvideo()'><a id='uploadvideo' href='videos.php' target='left_side'>Upload Video</a></button></div> <div class='description-details'><textarea class='course-material description-box' id='description$subtopicid' cols='30' rows='6' placeholder='This video gives the information about why and how HTML has came to existence.'></textarea>`)</script>";

                            echo "<script>$('#content-section').append(`<div class='textarea-buttons right' id='btndiv$subtopicid'><button class='savebtn' id='vsave$subtopicid' onclick='vsave(this)' style='display:inline-block;'>Save</button>
                            <button class='saveedit' id='vsaveedit$subtopicid' onclick='vsaveEdit(this)' style='display:none;'>Save Changes</button>
                            <button class='editbtn' id='vediting$subtopicid' onclick='veditSubTopic(this)' style='display:none;'>Edit
                            Description</button></div>
                            <br><br>
                            </div>
                            </div>`)</script>";
                        }
                        else
                        {
                            echo "<script>$('#content-section').append(`<div class='main-description' id='main-desc$subtopicid'> <input class='course-material' type='text' id='sub-topic$subtopicid' value='$subtopic' style='margin:40px 7px;' disabled><div class='description-details'><textarea class='course-material description-box' id='description$subtopicid' cols='30' rows='6' disabled>$videodesc</textarea>`)</script>";

                            echo "<script>$('#content-section').append(`<div class='textarea-buttons right' id='btndiv$subtopicid'><button class='savebtn' id='vsave$subtopicid' onclick='vsave(this)' style='display:inline-block;' disabled>&#10004; Saved!</button>
                            <button class='saveedit' id='vsaveedit$subtopicid' onclick='vsaveEdit(this)' style='display:none;'>Save Changes</button>
                            <button class='editbtn' id='vediting$subtopicid' onclick='veditSubTopic(this)' style='display:inline-block;'>Edit
                            Description</button></div>
                            <br><br>
                            </div>
                            </div>`)</script>";
                        } 
                }
              
        } 

        if($moduleid==1 && $topicid==1)
        {
            echo "<script>$('#newpage').append(`<section id='btn-section'>
            <div class='textarea-buttons right'>
                <div class='right'>
                    <button onclick='next()'>Next</button>
                </div>
            </div></section>`)</script>";
        }
        else
        {
            $btnselect=$conn->prepare("SELECT MAX(module.`ModuleId`) as modid, Max(topics.`TopicId`) as topid FROM module,topics WHERE topics.`ModuleId`=(SELECT MAX(module.`ModuleId`) FROM module WHERE module.`CourseId`=?) and module.`CourseId`=?");
            $btnselect->bind_param('ii',$courseid,$courseid);
            $btnselect->execute();
            $btnselectresult=$btnselect->get_result();
            while($brow=mysqli_fetch_assoc($btnselectresult))
            {
                $mid=$brow['modid'];
                $tid=$brow['topid'];
                if($moduleid==$mid && $topicid==$tid)
                {
                    echo "<script>$('#newpage').append(`<section id='btn-section'>
                <div class='textarea-buttons right'>
                    <div class='right'>
                        <button onclick='previous()'>Previous</button>
                        <button onclick='coursecomplete()'>Save Course</button>
                        
                    </div>
                </div></section>`)</script>";
                }
                else
                {
                    echo "<script>$('#newpage').append(`<section id='btn-section'>
             <div class='textarea-buttons right'>
                 <div class='right'>
                 <button onclick='previous()'>Previous</button>
                     <button onclick='next()'>Next</button>
                 </div>
             </div>
         </section>`)</script>";
                }
            }
        }  
    }

    if($action=="savevideodesc")
    {

        $courseid=$_POST['courseid'];
        $moduleid=$_POST['moduleid'];
        $topicid=$_POST['topicid'];
        $subtopicid=$_POST['subtopicid'];
        $videodesc=$_POST['videodesc'];
        $checkmaxvideoid=$conn->prepare("SELECT `VideoLinkId` FROM `subtopics` WHERE `VideoLinkId`=(SELECT MAX(id) FROM `uploadingmaterial`)");
        $checkmaxvideoid->execute();
        $checkres=$checkmaxvideoid->get_result();
        if(mysqli_num_rows($checkres)>0)
        {
            echo "1";
        }
        else
        {
            $videodescsave=$conn->prepare("UPDATE `subtopics` SET `VideoDesc`=?, `VideoLinkId`=(SELECT MAX(id) FROM `uploadingmaterial`) WHERE `CourseId`=? AND `ModuleId`=? AND `TopicId`=? AND `SubtopicId`=?");
            $videodescsave->bind_param('siiii',$videodesc,$courseid,$moduleid,$topicid,$subtopicid);
            $videodescsave->execute();
            echo "2";
        }
    }

    if($action=="completecourse")
    {
        $courseid=$_POST['courseid'];
        $coursecompselect=$conn->prepare("SELECT * FROM `subtopics` WHERE `CourseId`=? AND `VideoDesc` IS NULL");
        $coursecompselect->bind_param('i',$courseid);
        $coursecompselect->execute();
        $coursecompresult=$coursecompselect->get_result();
        if(mysqli_num_rows($coursecompresult)>0)
        {
            echo "1";
        }
        else
        {
            echo "2";
        }
    }
    $conn->close();
?>