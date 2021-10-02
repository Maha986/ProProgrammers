function viewcourse(elem)
{
    let courseid=parseInt(elem.id.match(/\d+/g),10);
    window.location="viewcourse.php?id="+courseid;
}



function copy(t) {
    let idNo = parseInt(t.id.match(/\d+/g), 10);
    const copyText=$('#code' + idNo).text();
    const textArea = document.createElement('textarea');
  textArea.textContent = copyText;
  $(textArea).css("position","absolute");
  $(textArea).css("left","-100");
  document.body.append(textArea);
  textArea.select();
  document.execCommand("copy");
  textArea.remove();
    // $('#code'+idNo).setSelection
}

function next()
{
    
    let courseid=parseInt($('[id^=course]').attr("id").match(/\d+/g),10);
    if($('#assignment').length)
    {
        //send request to get the practice problems
        let action="fetchpractice";
        $.ajax({
            url: "_viewcoursedb.php",
            type: "POST",
            data:
            {
                action: action,
                courseid: courseid,
               
            },
            success: function (data) {
               
                // $('#center').html("");
                $('#center').children().not('#newpage').remove();
                $('#center').append(data);
                $(window).scrollTop(0);
                $('input').not(`input[type=submit]`).css("color", "black");
                $('textarea').each(function () {
                    if ($(this).prop("disabled")) {
                        $(this).css("color", "black");
                    }
                })
                $('[id^=module],[id^=topic],[id^=sub-topic]').css("font-weight","bold");
                $('[id^=course]').css("font-size","2rem");
            }
        });
    }
    else if($('[id^=headingquiz]').length)
    {
        //send request to get next module
        let moduleid = parseInt($('[id^=headingquiz]').attr("id").match(/\d+/g), 10);
        let action="fetchnextmodule";
        $.ajax({
            url: "_viewcoursedb.php",
            type: "POST",
            data:
            {
                action: action,
                courseid: courseid,
                moduleid: moduleid,
               
            },
            success: function (data) {
               
                $('#center').children().children().not(('.title-top')).remove();
                $('#quiz-form').remove();

                $('#newpage').append(data);
                $(window).scrollTop(0);
                $('input').not(`input[type=submit]`).css("color", "black");
                $('textarea').each(function () {
                    if ($(this).prop("disabled")) {
                        $(this).css("color", "black");
                    }
                })
                $('[id^=module],[id^=topic],[id^=sub-topic]').css("font-weight","bold");
                $('[id^=course]').css("font-size","2rem");
            
            }
        });

    }
    else
    {
        let courseid = parseInt($('[id^=ulcourse]').attr("id").match(/\d+/g), 10);
    let moduleid = parseInt($('[id^=module]').attr("id").match(/\d+/g), 10);
    let modulename = $('[id^=module]').val();
   let topicid = parseInt($('[id^=topic]').attr("id").match(/\d+/g), 10);
    let action = "fetchnextpage";
    $.ajax({
        url: "_viewcoursedb.php",
        type: "POST",
        data:
        {
            action: action,
            courseid: courseid,
            moduleid: moduleid,
            topicid: topicid,
            modulename: modulename,
        },
        success: function (data) {
            
            $('#quiz-form').remove();
            $('#center').children().children().not(('.title-top')).remove();
            $('#newpage').append(data);
            $(window).scrollTop(0);
            $('input').not(`input[type=submit]`).css("color", "black");
            $('textarea').each(function () {
                if ($(this).prop("disabled")) {
                    $(this).css("color", "black");
                }
            })
            $('[id^=module],[id^=topic],[id^=sub-topic]').css("font-weight","bold");
            $('[id^=course]').css("font-size","2rem");
        }
    });
    }
    
}

function previous()
{
    if($('[id^=practice]').length)
    {
        let courseid = parseInt($('[id^=course]').attr("id").match(/\d+/g), 10);
        let action = "fetchass";
        $.ajax({
            url: "_viewcoursedb.php",
            type: "POST",
            data:
            {
                action: action,
                courseid: courseid,
            },
            success: function (data) {
            $('#practice').remove();

                $('#quiz-form').remove();
                $('#center').children().children().not(('.title-top')).remove();
                $('#newpage').append(data);
                $(window).scrollTop(0);
                $('input').not(`input[type=submit]`).css("color", "black");
                $('textarea').each(function () {
                    if ($(this).prop("disabled")) {
                        $(this).css("color", "black");
                    }
                })
                $('[id^=module],[id^=topic],[id^=sub-topic]').css("font-weight","bold");
                $('[id^=course]').css("font-size","2rem");
            }
        });
    }
    else if($('#assignment').length)
    {
        let courseid = parseInt($('[id^=ulcourse]').attr("id").match(/\d+/g), 10);
        console.log(courseid);
        let action = "fetchlastquiz";
        $.ajax({
            url: "_viewcoursedb.php",
            type: "POST",
            data:
            {
                action: action,
                courseid: courseid,
            },
            success: function (data) {
                $('#center').children().children().not(('.title-top')).remove();
                $('#assignment').remove();
                $('#center').append(data);
                $(window).scrollTop(0);
                $('input').not(`input[type=submit]`).css("color", "black");
                $('textarea').each(function () {
                    if ($(this).prop("disabled")) {
                        $(this).css("color", "black");
                    }
                })
                $('[id^=module],[id^=topic],[id^=sub-topic]').css("font-weight","bold");
                $('[id^=course]').css("font-size","2rem");
            }
        });
    }
    else if($('#quiz-form').length)
    {
        let courseid = parseInt($('[id^=ulcourse]').attr("id").match(/\d+/g), 10);
        let moduleid=parseInt($('[id^=headingquiz]').attr("id").match(/\d+/g),10);
        let action="fetchprevtopic";
        $.ajax({
            url: "_viewcoursedb.php",
            type: "POST",
            data:
            {
                action: action,
                courseid: courseid,
                moduleid: moduleid,
               
            },
            success: function (data) {
                $('#center').children().children().not(('.title-top')).remove();
            $('#quiztop').remove();
            $('#quiz-form').remove();
                $('#newpage').append(data);
                $(window).scrollTop(0);
                $('input').not(`input[type=submit]`).css("color", "black");
                $('textarea').each(function () {
                    if ($(this).prop("disabled")) {
                        $(this).css("color", "black");
                    }
                })
                $('[id^=module],[id^=topic],[id^=sub-topic]').css("font-weight","bold");
                $('[id^=course]').css("font-size","2rem");
            
            }
        });
    }
    else
    {
        let action="fetchmoduletopics";
        let courseid = parseInt($('[id^=ulcourse]').attr("id").match(/\d+/g), 10);
        let moduleid= parseInt($('[id^=module]').attr("id").match(/\d+/g),10);
        let topicid= parseInt($('[id^=topic]').attr("id").match(/\d+/g),10);
        $.ajax({
            url: "_viewcoursedb.php",
            type: "POST",
            data:
            {
                action: action,
                courseid: courseid,
                moduleid: moduleid,
               topicid:topicid,
            },
            success: function (data) {
                $('#center').children().children().not(('.title-top')).remove();
            $('#quiztop').remove();
            $('#quiz-form').remove();
                $('#newpage').append(data);
                $(window).scrollTop(0);
                $('input').not(`input[type=submit]`).css("color", "black");
                $('textarea').each(function () {
                    if ($(this).prop("disabled")) {
                        $(this).css("color", "black");
                    }
                })
                $('[id^=module],[id^=topic],[id^=sub-topic]').css("font-weight","bold");
                $('[id^=course]').css("font-size","2rem");
            
            }
        });
    }
}

function openSubTopic(elem)
{
    
    let subtopicidNo = parseInt(elem.id.slice(-5).match(/\d+/g), 10);
    let moduleidNo = parseInt(elem.id.slice(0, 7).match(/\d+/g), 10);
    let courseid = $('#navigation').children('[id^=ulcourse]').attr("id");
    let courseidNo = parseInt(courseid.match(/\d+/g), 10);
    let topicidNo=parseInt(elem.id.slice(8,13).match(/\d+/g), 10);
    
    let action = "showsubtopic";
    $.ajax({
        url: '_viewcoursedb.php',
        type: 'POST',
        data:
        {
            action: action,
            courseid: courseidNo,
            moduleid: moduleidNo,
            topicid: topicidNo,
            subtopicid: subtopicidNo,
        },
        success: function (data) {
            $('#newpage').children().not(('.title-top')).remove();
            $('#assignment').remove();
            $('#quiztop').remove();
            $('#quiz-form').remove();
            $('#practice').remove();
            $('.prev').remove();
            $('.next').remove();
            $('#newpage').append(data);
            $(window).scrollTop(($('#sub-topic'+subtopicidNo).position().top)-60);
            $('input').css("color", "black");
            $('textarea').each(function () {
                if ($(this).prop("disabled")) {
                    $(this).css("color", "black");
                }
            })
            $('[id^=module],[id^=topic],[id^=sub-topic]').css("font-weight","bold");
            $('[id^=course]').css("font-size","2rem");
        }
    })
}

function openAss()
{
    let courseid = $('[id^=course]').attr("id");
    let courseidNo = parseInt(courseid.match(/\d+/g), 10);
    let action="showass";
        $.ajax({
            url:"_viewcoursedb.php",
            type:"POST",
            data:
            {
                action:action,
                courseid:courseidNo,
            },
            success:function(data)
            {
                
                $('#center').html('');
                $('#center').append(data);
                $('input').css("color", "black");
                $(window).scrollTop(0);
                $('textarea').each(function () {
                    if ($(this).prop("disabled")) {
                        $(this).css("color", "black");
                    }
                })
                $('[id^=module],[id^=topic],[id^=sub-topic]').css("font-weight","bold");
                $('[id^=course]').css("font-size","2rem");
                if($('[id^=ulvcourse]').length)
                {
                    $('#tuttogglebtn,#title-of-course #tuttogglebtn').html("<i class='fal fa-edit'></i>Written Tutorial");
                    $('#tuttogglebtn,#title-of-course #tuttogglebtn').attr("onclick","viewWrittenTutorial()");
                    $('#center').find('button').last().prev().attr("onclick","vprevious()");
                    $('#center').find('button').last().attr("onclick","vnext()");
                }
            }
        })
}

function openPractice()
{
    
    let courseid=parseInt($('[id^=course]').attr("id").match(/\d+/g),10);
     //send request to get the practice problems
        let action="fetchpractice";
        $.ajax({
            url: "_viewcoursedb.php",
            type: "POST",
            data:
            {
                action: action,
                courseid: courseid,
               
            },
            success: function (data) {
               
                // $('#center').html("");
                // $('#center').children().not('#newpage').remove();
            $('#center').children().children().not(('.title-top')).remove();
            $('#quiz-form').remove();

                $('#center').append(data);
                $(window).scrollTop(0);
                $('input').not(`input[type=submit]`).css("color", "black");
                $('textarea').each(function () {
                    if ($(this).prop("disabled")) {
                        $(this).css("color", "black");
                    }
                })
                $('[id^=module],[id^=topic],[id^=sub-topic]').css("font-weight","bold");
                $('[id^=course]').css("font-size","2rem");
                if($('[id^=ulvcourse]').length)
                {
                    $('#tuttogglebtn,#title-of-course #tuttogglebtn').html("<i class='fal fa-edit'></i>Written Tutorial");
                    $('#tuttogglebtn,#title-of-course #tuttogglebtn').attr("onclick","viewWrittenTutorial()");
                    $('#center').find('button').last().prev().attr("onclick","vprevious()");
                    
                }
            }
        });
}

function openQuiz(elem)
{
    let courseid=parseInt($('[id^=course]').attr("id").match(/\d+/g),10);
    let moduleid=parseInt(elem.id.match(/\d+/g),10);
    let action="openquiz";
    $.ajax({
        url:"_viewcoursedb.php",
        type:"POST",
        data:
        {
            action:action,
            courseid:courseid,
            moduleid:moduleid,
        },
        success:function(data)
        {
            
            $('#quiztop').remove();
            $('#quiz-form').remove();
            $('#center').children().children().not(('.title-top')).remove();
            $('#newpage').append(data);
            $(window).scrollTop(0);
            $('input').not(`input[type=submit]`).css("color", "black");
            $('textarea').each(function () {
                if ($(this).prop("disabled")) {
                    $(this).css("color", "black");
                }
            })
            $('[id^=module],[id^=topic],[id^=sub-topic]').css("font-weight","bold");
            $('[id^=course]').css("font-size","2rem");
            if($('[id^=ulvcourse]').length)
                {
                    $('#tuttogglebtn,#title-of-course #tuttogglebtn').html("<i class='fal fa-edit'></i>Written Tutorial");
                    $('#tuttogglebtn,#title-of-course #tuttogglebtn').attr("onclick","viewWrittenTutorial()");
                    $('#center').find('button').last().prev().attr("onclick","vprevious()");
                    $('#center').find('button').last().attr("onclick","vnext()");
                }
        }
    })
}


function opensidebar()
{
    $('#navigation').css("display","block");
    $('#navigation').animate({width: "240px"});
}
function closenav()
{
    
    $('#navigation').animate({width: "0px"});
    $('#navigation').hide();
}

function viewVideoTutorial()
{
    let courseid=parseInt($('[id^=course]').attr("id").match(/\d+/g),10);
    let action="fetchfirstvideopage";
    $.ajax({
        url:"_viewvideocoursedb.php",
        type:"POST",
        data:
        {
            action:action,
            courseid:courseid,
        },
        success:function(data)
        {
            // $('#mainpage').children().not('#navigation').remove();
            // console.log(data);
            $('#mainpage').children().not('#navigation').not('#notespage').remove();
            $('.moduleul').children().remove();
            $('[id^=ulcourse]').remove();
            $('#mainpage').append(data);
            $('[id^=module],[id^=topic],[id^=sub-topic]').css("font-weight","bold");
    $('[id^=course]').css("font-size","2rem");
            $(document).prop("title","ProProgrammers| "+$('[id^=course]').val())
        
        }
    })
}

function vnext()
{
    
    let courseid=parseInt($('[id^=course]').attr("id").match(/\d+/g),10);
    if($('#assignment').length)
    {
        //send request to get the practice problems
        let action="fetchpractice";
        $.ajax({
            url: "_viewvideocoursedb.php",
            type: "POST",
            data:
            {
                action: action,
                courseid: courseid,
               
            },
            success: function (data) {
                console.log(action);
                // $('#center').html("");
                $('#center').children().not('#newpage').remove();
                $('#center').append(data);
                $(window).scrollTop(0);
                $('input').not(`input[type=submit]`).css("color", "black");
                $('textarea').each(function () {
                    if ($(this).prop("disabled")) {
                        $(this).css("color", "black");
                    }
                })
                $('[id^=module],[id^=topic],[id^=sub-topic]').css("font-weight","bold");
                $('[id^=course]').css("font-size","2rem");
            }
        });
    }
    else if($('[id^=headingquiz]').length)
    {
        //send request to get next module
        let moduleid = parseInt($('[id^=headingquiz]').attr("id").match(/\d+/g), 10);
        let action="fetchnextmodule";
        $.ajax({
            url: "_viewvideocoursedb.php",
            type: "POST",
            data:
            {
                action: action,
                courseid: courseid,
                moduleid: moduleid,
               
            },
            success: function (data) {
                console.log(action);
                $('#center').children().children().not(('.title-top')).remove();
            $('#quiztop').remove();
            $('#quiz-form').remove();
                $('#newpage').append(data);
                $(window).scrollTop(0);
                $('input').not(`input[type=submit]`).css("color", "black");
                $('textarea').each(function () {
                    if ($(this).prop("disabled")) {
                        $(this).css("color", "black");
                    }
                })
                $('[id^=module],[id^=topic],[id^=sub-topic]').css("font-weight","bold");
                $('[id^=course]').css("font-size","2rem");
            
            }
        });

    }
    else
    {
        let courseid = parseInt($('[id^=ulvcourse]').attr("id").match(/\d+/g), 10);
    let moduleid = parseInt($('[id^=module]').attr("id").match(/\d+/g), 10);
    let modulename = $('[id^=module]').val();
   let topicid = parseInt($('[id^=topic]').attr("id").match(/\d+/g), 10)
    let action = "fetchnextpage";
    $.ajax({
        url: "_viewvideocoursedb.php",
        type: "POST",
        data:
        {
            action: action,
            courseid: courseid,
            moduleid: moduleid,
            topicid: topicid,
            modulename: modulename,
        },
        success: function (data) {
            console.log(action);
            $('#quiztop').remove();
            $('#quiz-form').remove();
            $('#center').children().children().not(('.title-top')).remove();
            $('#newpage').append(data);
            $(window).scrollTop(0);
            $('input').not(`input[type=submit]`).css("color", "black");
            $('textarea').each(function () {
                if ($(this).prop("disabled")) {
                    $(this).css("color", "black");
                }
            })
            $('[id^=module],[id^=topic],[id^=sub-topic]').css("font-weight","bold");
            $('[id^=course]').css("font-size","2rem");
        }
    });
    }
    
}



function vprevious()
{
    if($('[id^=practice]').length)
    {
        let courseid = parseInt($('[id^=course]').attr("id").match(/\d+/g), 10);
        let action = "fetchass";
        $.ajax({
            url: "_viewcoursedb.php",
            type: "POST",
            data:
            {
                action: action,
                courseid: courseid,
            },
            success: function (data) {
            $('#quiztop').remove();
            $('#quiz-form').remove();
            $('#practice').remove();
                $('#center').children().children().not(('.title-top')).remove();
                $('#newpage').append(data);
                $(window).scrollTop(0);
                $('input').not(`input[type=submit]`).css("color", "black");
                $('textarea').each(function () {
                    if ($(this).prop("disabled")) {
                        $(this).css("color", "black");
                    }
                })
                $('[id^=module],[id^=topic],[id^=sub-topic]').css("font-weight","bold");
                $('[id^=course]').css("font-size","2rem");
                if($('[id^=ulvcourse]').length)
                {
                    $('#tuttogglebtn,#title-of-course #tuttogglebtn').html("<i class='fal fa-edit'></i>Written Tutorial");
                    $('#tuttogglebtn,#title-of-course #tuttogglebtn').attr("onclick","viewWrittenTutorial()");
                    $('#center').find('button').last().prev().attr("onclick","vprevious()");
                    $('#center').find('button').last().attr("onclick","vnext()");
                }
            }
        });
    }
    else if($('#assignment').length)
    {
        let courseid = parseInt($('[id^=course]').attr("id").match(/\d+/g), 10);
        let action = "fetchlastquiz";
        $.ajax({
            url: "_viewcoursedb.php",
            type: "POST",
            data:
            {
                action: action,
                courseid: courseid,
            },
            success: function (data) {
                $('#center').children().children().not(('.title-top')).remove();
                $('#assignment').remove();
                $('#center').append(data);
                $(window).scrollTop(0);
                $('input').not(`input[type=submit]`).css("color", "black");
                $('textarea').each(function () {
                    if ($(this).prop("disabled")) {
                        $(this).css("color", "black");
                    }
                })
                $('[id^=module],[id^=topic],[id^=sub-topic]').css("font-weight","bold");
                $('[id^=course]').css("font-size","2rem");
                if($('[id^=ulvcourse]').length)
                {
                    $('#tuttogglebtn,#title-of-course #tuttogglebtn').html("<i class='fal fa-edit'></i>Written Tutorial");
                    $('#tuttogglebtn,#title-of-course #tuttogglebtn').attr("onclick","viewWrittenTutorial()");
                    $('#center').find('button').last().prev().attr("onclick","vprevious()");
                    $('#center').find('button').last().attr("onclick","vnext()");
                }
            }
        });
    }
    else if($('#quiz-form').length)
    {
        let courseid = parseInt($('[id^=course]').attr("id").match(/\d+/g), 10);
        let moduleid=parseInt($('[id^=headingquiz]').attr("id").match(/\d+/g),10);
        let action="fetchprevtopic";
        $.ajax({
            url: "_viewvideocoursedb.php",
            type: "POST",
            data:
            {
                action: action,
                courseid: courseid,
                moduleid: moduleid,
               
            },
            success: function (data) {
                $('#center').children().children().not(('.title-top')).remove();
            $('#quiztop').remove();
            $('#quiz-form').remove();
                $('#newpage').append(data);
                $(window).scrollTop(0);
                $('input').not(`input[type=submit]`).css("color", "black");
                $('textarea').each(function () {
                    if ($(this).prop("disabled")) {
                        $(this).css("color", "black");
                    }
                })
                $('[id^=module],[id^=topic],[id^=sub-topic]').css("font-weight","bold");
                $('[id^=course]').css("font-size","2rem");
            
            }
        });
    }
    else
    {
        let action="fetchmoduletopics";
        let courseid = parseInt($('[id^=course]').attr("id").match(/\d+/g), 10);
        let moduleid= parseInt($('[id^=module]').attr("id").match(/\d+/g),10);
        let topicid= parseInt($('[id^=topic]').attr("id").match(/\d+/g),10);
        $.ajax({
            url: "_viewvideocoursedb.php",
            type: "POST",
            data:
            {
                action: action,
                courseid: courseid,
                moduleid: moduleid,
               topicid:topicid,
            },
            success: function (data) {
                $('#center').children().children().not(('.title-top')).remove();
                $('#quiz-form').remove();
                $('#quiztop').remove();
                $('#newpage').append(data);
                $(window).scrollTop(0);
                $('input').not(`input[type=submit]`).css("color", "black");
                $('textarea').each(function () {
                    if ($(this).prop("disabled")) {
                        $(this).css("color", "black");
                    }
                })
                $('[id^=module],[id^=topic],[id^=sub-topic]').css("font-weight","bold");
                $('[id^=course]').css("font-size","2rem");
            
            }
        });
    }
}

function openvSubTopic(elem)
{
    
    let subtopicidNo = parseInt(elem.id.slice(-5).match(/\d+/g), 10);
    let moduleidNo = parseInt(elem.id.slice(0, 7).match(/\d+/g), 10);
    let courseid = $('#navigation').children('[id^=ulvcourse]').attr("id");
    let courseidNo = parseInt(courseid.match(/\d+/g), 10);
    let topicidNo=parseInt(elem.id.slice(8,13).match(/\d+/g), 10);
    
    let action = "showsubtopic";
    $.ajax({
        url: '_viewvideocoursedb.php',
        type: 'POST',
        data:
        {
            action: action,
            courseid: courseidNo,
            moduleid: moduleidNo,
            topicid: topicidNo,
            subtopicid: subtopicidNo,
        },
        success: function (data) {
            $('#newpage').children().not(('.title-top')).remove();
            $('#assignment').remove();
            $('#practice').remove();
            $('#quiz-form').remove();
            $('#quiztop').remove();
            $('.prev').remove();
            $('.next').remove();
            $('#newpage').append(data);
            $(window).scrollTop(($('#sub-topic'+subtopicidNo).position().top)-60);
            $('input').css("color", "black");
            $('textarea').each(function () {
                if ($(this).prop("disabled")) {
                    $(this).css("color", "black");
                }
            })
            $('[id^=module],[id^=topic],[id^=sub-topic]').css("font-weight","bold");
            $('[id^=course]').css("font-size","2rem");
        }
    })
}

function viewWrittenTutorial()
{
    let courseid = parseInt($('[id^=course]').attr("id").match(/\d+/g), 10);
    let action="viewcourse";
    $.ajax({
        url:"_viewcoursedb.php",
        type:"POST",
        data:
        {
            action:action,
            courseid:courseid,
        },
        success:function(data)
        {
            // console.log(data);
            // $('#mainpage').children().not('#navigation').remove();
            $('#mainpage').children().not('#navigation').not('#notespage').remove();

            $('.moduleul').children().remove();
            $('[id^=ulvcourse]').remove();
            $('#mainpage').append(data);
            $('[id^=module],[id^=topic],[id^=sub-topic]').css("font-weight","bold");
    $('[id^=course]').css("font-size","2rem");
            $(document).prop("title","ProProgrammers| "+$('[id^=course]').val());
            $('#notespage').first().remove();
        }
    });
}

