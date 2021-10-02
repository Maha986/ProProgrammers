function addVideotutorial(t) {
    let courseid = parseInt(t.id.match(/\d+/g), 10);
    let action = "fetchcoursedata"
    $.ajax({
        url: "_videotutorialsdb.php",
        type: "POST",
        data:
        {
            action: action,
            courseid: courseid,

        },
        success: function (data) {
            $('#main-page').html('');
            $('#main-page').append(data);
            $('input').css("color", "black");
            $('.moduleul').on('click', function (e) {
                var $t = $(e.target).closest('a'),
                    $ul = $t.nextAll('ul').eq(0);
                if ($t.length && $ul.length) {
                    // $ul.toggleClass('open').slideToggle(350);
                    if ($ul.is(':visible')) {
                        $ul.slideUp();
                        $(e.target).prev().removeClass('fas fa-caret-up').addClass('fas fa-caret-down');
                    }
                    else {
                        $ul.slideDown();
                        $(e.target).prev().removeClass('fas fa-caret-down').addClass('fas fa-caret-up');

                    }
                }
            });
        }
    })
}

function next() {
    var courseid = parseInt($('[id^=ulvcourse]').attr("id").match(/\d+/g), 10);
    var moduleid = parseInt($('[id^=module]').attr("id").match(/\d+/g), 10);
    var modulename = $('[id^=module]').val();
    var topicid = parseInt($('[id^=topic]').attr("id").match(/\d+/g), 10)
    let action = "fetchnextpage";
    $.ajax({
        url: "_videotutorialsdb.php",
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
            $('#newpage').children().not(('#title-of-course')).remove();
            $('#newpage').append(data);
            $(window).scrollTop(0);
            $('input').css("color", "black");
            $('textarea').each(function () {
                if ($(this).prop("disabled")) {
                    $(this).css("color", "black");
                }
            })

        }
    });

}

function previous()
{
    var courseid = parseInt($('[id^=ulvcourse]').attr("id").match(/\d+/g), 10);
    var moduleid = parseInt($('[id^=module]').attr("id").match(/\d+/g), 10);
    var modulename = $('[id^=module]').val();
    var topicid = parseInt($('[id^=topic]').attr("id").match(/\d+/g), 10)
    let action = "fetchpreviouspage";
    $.ajax({
        url: "_videotutorialsdb.php",
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
            $('#newpage').children().not(('#title-of-course')).remove();
            $('#newpage').append(data);
            $(window).scrollTop(0);
            $('input').css("color", "black");
            $('textarea').each(function () {
                if ($(this).prop("disabled")) {
                    $(this).css("color", "black");
                }
            })

        }
    });
}

function openSubTopic(elem)
{
    
    let subtopicidNo = parseInt(elem.id.slice(-5).match(/\d+/g), 10);
    let moduleidNo = parseInt(elem.id.slice(0, 7).match(/\d+/g), 10);
    let courseid = $('#navigation-menu').children('[id^=ulvcourse]').attr("id");
    let courseidNo = parseInt(courseid.match(/\d+/g), 10);
    let topicidNo=parseInt(elem.id.slice(8,13).match(/\d+/g), 10);
    
    let action = "showsubtopic";
    $.ajax({
        url: '_videotutorialsdb.php',
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
            $('#newpage').children().not(('#title-of-course')).remove();
            $('#newpage').append(data);
            $(window).scrollTop($('#sub-topic'+subtopicidNo).position().top);
            $('input').css("color", "black");
            $('textarea').each(function () {
                if ($(this).prop("disabled")) {
                    $(this).css("color", "black");
                }
            })
        }
    })
}

function vsave(elem)
{
    let courseid=parseInt($('[id^=course]').prop("id").match(/\d+/g),10);
    let moduleid=parseInt($('[id^=module]').prop("id").match(/\d+/g),10);
    let topicid=parseInt($('[id^=topic]').prop("id").match(/\d+/g),10);
    let subtopicid= parseInt(elem.id.match(/\d+/g), 10);
   
    let videodesc=$('#description'+subtopicid).val();
    
    if(videodesc=="")
    {
        $('#errormsg').css("display", "block");
        $('#msg').text("Opps!! there was no Video Description :(");
        return false;     
    }
    let action="savevideodesc";
    $.ajax({
        url:"_videotutorialsdb.php",
        type:"POST",
        data:
        {
            action:action,
            courseid:courseid,
            moduleid:moduleid,
            topicid:topicid,
            subtopicid:subtopicid,
            videodesc:videodesc,
        },
        success: function(data)
        {
            
            console.log(data);
            if(data==1)
            {
                $('#errormsg').css("display", "block");
                $('#msg').text("Opps!! there was no video uploaded :(");
                return false;     
            }
            else
            {
                $('#errormsg').css("display", "none");
                $('#description'+subtopicid).prop("disabled",true);
                $('#description'+subtopicid).css("color","black");
                $('#vsave'+subtopicid).css("disabled",true);
                $('#vsave'+subtopicid).html("&#10004; Saved!");
                $('#vediting'+subtopicid).css("display","inline-block");
            }
            
        }
    })

}

function uploadvideo(){
    $('#myvideoModal').css("display","block");
    $('body').css("position","fixed");
    $('body').css("width","100vw");
}

function closeuploadvideo()
{
    $('#myvideoModal').css("display","none");
    $('body').css("position","unset");
    $('body').css("width","unset");
}

function coursecomplete()
{
    let courseid=parseInt($('[id^=course]').prop("id").match(/\d+/g),10);
    let action="completecourse";
    $.ajax({
        url:"_videotutorialsdb.php",
        type:"POST",
        data:
        {
            action:action,
            courseid:courseid,
        },
        success:function(data)
        {
            if(data==1)
            {
                $('#errormsg').css("display", "block");
                $('#msg').text("You have some unsaved changes or some missing video description :(");
                return false;  
            }
            else
            {
                $('#errormsg').css("display", "none");
                location.href='courses.php';
            }
        }
    })
}

function veditSubTopic(t) {
    let idNo = parseInt(t.id.match(/\d+/g), 10);
    $('.main-description').find('#description' + idNo).prop("disabled", false);
    $('#vsave' + idNo).css("display", "none");
    $('#vsaveedit' + idNo).css("display", "inline-block");
    $('#vediting' + idNo).css("display", "none");

}

function vsaveEdit(t) 
{
    let courseid= parseInt($('[id^=course]').prop("id").match(/\d+/g), 10);
    let moduleid= parseInt($('[id^=module]').prop("id").match(/\d+/g), 10);
    let topicid= parseInt($('[id^=topic]').prop("id").match(/\d+/g), 10);
    let subtopicid = parseInt(t.id.match(/\d+/g), 10);
    let action="vsubtopicedit";
    let videodesc=$('#description'+subtopicid).val();
    if(videodesc=="")
    {
        $('#errormsg').css("display", "block");
        $('#msg').text("Opps!! there was no Video Description :(");
        return false;     
    }
    $.ajax({
        url:"_edittutorialsdb.php",
        type:"POST",
        data:
        {
            action:action,
            courseid:courseid,
            moduleid:moduleid,
            topicid:topicid,
            subtopicid:subtopicid,
            videodesc:videodesc,
        },
        success:function()
        {
            $('#vsave'+subtopicid).css("display","inline-block");
            $('#main-desc' + subtopicid).find('textarea').each(function () {
                $(this).prop("disabled", true);
                $(this).css("color","black");
            })
            $('#vsaveedit'+subtopicid).css("display", "none");
            $('#vediting' + subtopicid).css("display", "inline-block");

        }
    })
}
    