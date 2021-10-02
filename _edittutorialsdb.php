<?php
    require "_dbconnect.php";

    $action=$_POST['action'];
    if($action=="headchange")
    {
        $courseid=$_POST['courseid'];
        $moduleid=$_POST['moduleid'];
        $topicid=$_POST['topicid'];
        $course=$_POST['course'];
        $module=$_POST['module'];
        $topic=$_POST['topic'];
        $courseupdate=$conn->prepare("UPDATE `courses` SET `CourseName`=? WHERE `CourseId`=?");
        $moduleupdate=$conn->prepare("UPDATE `module` SET `ModuleName`=? WHERE `CourseId`=? AND `ModuleId`=?");
        $topicupdate=$conn->prepare("UPDATE `topics` SET `TopicName`=? WHERE `CourseId`=? AND `ModuleId`=? AND `TopicId`=?");
        $courseupdate->bind_param('si',$course,$courseid);
        $moduleupdate->bind_param('sii',$module,$courseid,$moduleid);
        $topicupdate->bind_param('siii',$topic,$courseid,$moduleid,$topicid);
        $courseupdate->execute();
        $moduleupdate->execute();
        $topicupdate->execute();
    }

    if($action=="subtopicedit")
    {
        $courseid=$_POST['courseid'];
        $moduleid=$_POST['moduleid'];
        $topicid=$_POST['topicid'];
        $subtopicid=$_POST['subtopicid'];
        $subtopicname=$_POST['subtopicname'];
        $desc=$_POST['desc'];
        $subnameupdate=$conn->prepare("UPDATE `subtopics` SET `SubtopicName`=?,`SubtopicDesc`=? WHERE `CourseId`=? AND `ModuleId`=? AND `TopicId`=? AND `SubtopicId`=?");
        $subnameupdate->bind_param('ssiiii',$subtopicname,$desc,$courseid,$moduleid,$topicid,$subtopicid);
        $subnameupdate->execute();
    }

    if($action=="assEdit")
    {
        $guidelines=$_POST['guidelines'];
        $courseid=$_POST['courseid'];
        $assupdate=$conn->prepare("UPDATE `courses` SET `Assignment`=? WHERE `CourseId`=?");
        $assupdate->bind_param('si',$guidelines,$courseid);
        $assupdate->execute();
    }
    if($action=="editpractice")
    {
        $practiceid=$_POST['practiceid'];
        $courseid=$_POST['courseid'];
        $que=$_POST['que'];
        $ans=$_POST['ans'];
        $practiceupdate=$conn->prepare("UPDATE `practiceproblems` SET `ProbQue`=?,`ProbSolution`=? WHERE `CourseId`=? AND `ProblemId`=?");
        $practiceupdate->bind_param('ssii',$que,$ans,$courseid,$practiceid);
        $practiceupdate->execute();
    }
    if($action=="vsubtopicedit")
    {
        $courseid=$_POST['courseid'];
        $moduleid=$_POST['moduleid'];
        $topicid=$_POST['topicid'];
        $subtopicid=$_POST['subtopicid'];
        $videodesc=$_POST['videodesc'];
        $subnameupdate=$conn->prepare("UPDATE `subtopics` SET `VideoDesc`=? WHERE `CourseId`=? AND `ModuleId`=? AND `TopicId`=? AND `SubtopicId`=?");
        $subnameupdate->bind_param('siiii',$videodesc,$courseid,$moduleid,$topicid,$subtopicid);
        $subnameupdate->execute();
    }

    $conn->close();
?>