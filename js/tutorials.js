function escapeHtml(text) {
    return text
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
  }

function quizsaved(quizresult) {
    if (quizresult == true) {
        $('#right-side').html($('#newpage'));
        let inputId = parseInt($('[id^=module]').prop("id").match(/\d+/g), 10) + 1;
        $('[id^=module]').prop('id', 'module' + inputId);
        $('[id^=headsave]').prop('id', 'headsave1');
        $('[id^=headedit]').prop('id', 'headedit1');
        $('[id^=topic]').prop('id', 'topic1');
        $('#headsave1').prop("disabled", false);
        $('#module' + inputId).prop("disabled", false);
        $('#topic1').prop("disabled", false);
        $('#sub-topic1').prop("disabled", false);
        $('#description1').prop("disabled", false);
        $('#headsave1').html("Save");
        if($('#newpage').find('#codemaindiv1').length==0)
        {
            $(`<div class="description-details code-detail" id="codemaindiv1"><div class="codesnippet code"><button class="codecopy" id="copybtn1" onclick="copy(this)"><i class="fal fa-copy"></i></button><textarea cols="30" rows="6" id="code1"placeholder="print('Hello World')"></textarea></div><div class="codesnippet"><textarea cols="30" rows="6" id="output1" placeholder="Hello World"></textarea></div></div>`).insertBefore('#btndiv1');
            $('#codemaindiv1').css("display", "none");

        }
        $('#newpage').find('[id^=codemaindiv]').each(function () {
            // console.log("ioutside"+$(this));            
            if ($(this).attr("id") != "codemaindiv1") {
                // console.log("inside"+$(this));
                $(this).remove();
            }
            else {
                // console.log($(this));
                // $(this).insertBefore("#btndiv1");
                $(this).css("display", "none");
                
            }
        });
        $('#newpage').find('[id^=main-desc').each(function () {
            if ($(this).attr("id") != "main-desc1") {
                $(this).remove();
            }
        });
        
        $('input').not('[id^=course]').val("");
        $('textarea').val("");
        $(window).scrollTop(0);
        $('#save1').css("display", "inline-block");
        $('#save1').html("Add other sub-topic");
        $('#save1').prop("disabled", false);
        $('#save1', '#headsave' + inputId).hover(function () {
            $(this).css("box-shadow", "gray 2px 2px 5px");
        }, function () {
            $(this).css("box-shadow", "none");
        });
        $('#headedit1').css("display","none");
        $('#saveedit1').css("display", "none");
        $('#snippetbtn1').css("display", "inline-block");
        $('#editing1').css("display", "none");
    }
}

function savetodb(t) {
    let idNo = parseInt(t.id.match(/\d+/g), 10);
    if ($('[id^=headsave]').prop("disabled") == false || ($('#save' + (idNo - 1)).length && $('#save' + (idNo - 1)).prop("disabled") == false)) {
        $('#errormsg').css("display", "block");
        $('#msg').text("You have some unsaved changes. Please save them first :(");
        return false;
    }
    if (!$('#save' + idNo).prop("disabled")) {

        //send data to ajax
        var subhead = $('#sub-topic' + idNo).val();
        var desc = $('#description' + idNo).val();
        let moduleid = parseInt($('[id^=module]').prop("id").match(/\d+/g), 10);
        let courseid = parseInt($('[id^=course]').prop("id").match(/\d+/g), 10);
        let topicid = parseInt($('[id^=topic]').prop("id").match(/\d+/g), 10);
        if (subhead == "" || desc == "") {
            $('#errormsg').css("display", "block");
            if (subhead == "" && desc == "") {
                $('#msg').text("Opps!! there was no sub-topic name and description :(");
            }
            else if (subhead == "" && desc != "") {
                $('#msg').text("Opps!! there was no sub-topic name :(");
            }
            else {
                $('#msg').text("Opps!! there was no description :(");
            }
            return false;
        }
        let snippet = $('#main-desc' + idNo).find('[id^=codemaindiv]');
        var reserr = true;
        snippet.each(function () {
            $(this).find('[id^=code]').each(function () {
                if ($(this).val() != "") {
                    let snipidNo = parseInt($(this)[0].id.match(/\d+/g), 10);
                    let code = $(this).val();
                    code=escapeHtml(code);
                    $(this).css("color", "#d3d1d1");
                    let output = $('#output' + snipidNo).val();
                    if (output == "") {
                        $('#errormsg').css("display", "block");

                        $('#msg').text("Opps!! there was no output for the given code :(");

                        reserr = false;
                    }
                    $('#output' + snipidNo).css("color", "#d3d1d1");
                    let act = "snippetsave";
                    if (reserr) {
                        $.ajax({
                            url: "_tutorialsdb.php",
                            type: 'POST',
                            data: {
                                action: act,
                                courseid: courseid,
                                mid: moduleid,
                                tid: topicid,
                                sid: idNo,
                                snipid: snipidNo,
                                code: code,
                                output: output,
                            },
                            success: function () {
                                $('#errormsg').css("display", "none");

                                reserr = true;
                            }
                        })
                    }

                }
            })

        })
        if (!reserr) {
            return false;
        }

        var action = "subtopicsave";
        desc=escapeHtml(desc);
        $.ajax({
            url: "_tutorialsdb.php",
            type: 'POST',
            data: {
                action: action,
                courseid: courseid,
                mid: moduleid,
                tid: topicid,
                sid: idNo,
                st: subhead,
                desc: desc,
            },
            dataType: "html",
            success: function (data) {
                $('#errormsg').css("display", "none");
                $('#main-page').append(data);
            }
        });

        $('#save' + idNo).html("&#10004; Saved!");
        $('#save' + idNo).prop("disabled", true);
        $('#save' + idNo).css("box-shadow", "none");
    }
    return true;
}

function practicesavetodb(t) {
    let idNo = parseInt(t.id.match(/\d+/g), 10);
    if (($('#practicesave' + (idNo - 1)).length && $('#practicesave' + (idNo - 1)).prop("disabled") == false)) {
        $('#errormsg').css("display", "block");
        $('#msg').text("You have some unsaved changes. Please save them first :(");
        return false;
    }
    var practice = $('#practice' + idNo).val();
    var code = $('#code' + idNo).val();
    let courseid = parseInt($('[id^=course]').prop("id").match(/\d+/g), 10);
    if (practice == "" || code == "") {
        $('#errormsg').css("display", "block");
        if (practice == "" && code == "") {
            $('#msg').text("Opps!! there was no practice question and solution :(");
        }
        else if (practice == "" && code != "") {
            $('#msg').text("Opps!! there was no practice question :(");
        }
        else {
            $('#msg').text("Opps!! there was no solution :(");
        }
        return false;
    }

    var action = "practicesave";
    code=escapeHtml(code);
    $.ajax({
        url: "_tutorialsdb.php",
        type: 'POST',
        data: {
            action: action,
            courseid: courseid,
            pid: idNo,
            practice: practice,
            code: code,
        },
        dataType: "html",
        success: function (data) {
            $('#errormsg').css("display", "none");
            $('#main-page').append(data);
        }
    });
    $('#practicesave' + idNo).html("&#10004; Saved!");
    $('#practicesave' + idNo).prop("disabled", true);
    $('#practicesave' + idNo).css("box-shadow", "none");
    return true;
}
function save(t) {

    let res = savetodb(t);
    if (!res) {
        return false;
    }

    //new node creation
    let idNo = parseInt(t.id.match(/\d+/g), 10);
    let newNode = $('.main-description').last().not().clone(true);
    var inputId = parseInt($('.main-description').last().find('[id^=sub-topic]').prop("id").match(/\d+/g), 10) + 1;
    newNode.prop('id', "main-desc" + inputId);
    // $(event.target).html("&#10004; Saved!");
    $('#main-desc' + idNo).find('textarea').each(function () {
        $(this).prop("disabled", true);
        $(this).not('[id^=code],[id^=output]').css("color", "black");
    })
    // $(event.target).prop("disabled", true);
    // $(event.target).css("box-shadow", "none");
    $('.snippetbtn').last().css("display", "none");
    $('.editbtn').last().css("display", "inline-block");
    // $('#sub-topic1','#description1').css("color", "black");
    $('.main-description').last().children('input').prop("disabled", true);
    $('.main-description').last().children('input').css("color", "black");
    newNode.find('.code-detail').remove();
    $('#content-section').append(newNode);
    $('.main-description').last().find('[id^=sub-topic]').prop('id', "sub-topic" + inputId);
    $('.main-description').last().find('[id^=description]').prop('id', "description" + inputId);
    $('.main-description').last().find('[id^=editing]').prop('id', "editing" + inputId);
    $('.main-description').last().find('[id^=saveedit][id$=t' + idNo + ']').prop('id', "saveedit" + inputId);
    $('.main-description').last().find('[id^=save][id$=e' + idNo + ']').prop('id', "save" + inputId);
    $('.main-description').last().find('[id^=save][id$=e' + inputId + ']').prop('disabled', false);
    $('.main-description').last().find('[id^=save][id$=e' + inputId + ']').html('Add other sub-topic');
    $('.main-description').last().find('[id^=snippetbtn]').prop('id', "snippetbtn" + inputId);
    $('.main-description').last().find('[id^=btndiv]').prop('id', "btndiv" + inputId);
    $('#sub-topic' + inputId).val("");
    $('#description' + inputId).val("");
}
function practicesave(t) {
    let res = practicesavetodb(t);
    if (!res) {
        return false;
    }
    //new node creation
    let idNo = parseInt(t.id.match(/\d+/g), 10);
    let newNode = $('.main-description').last().clone(true);
    var inputId = parseInt($('.main-description').last().find('[id^=practice]').prop("id").match(/\d+/g), 10) + 1;
    newNode.prop('id', "main-desc" + inputId);
    // $(event.target).html("&#10004; Saved!");
    $('#main-desc' + idNo).find('textarea').each(function () {
        $(this).prop("disabled", true);
        $(this).not('[id^=code]').css("color", "black");
    })
    $('.editbtn').last().css("display", "inline-block");
    $('#practice').append(newNode);
    $('.main-description').last().find('[id^=practice][id$=ce' + idNo + ']').prop('id', "practice" + inputId);
    $('.main-description').last().find('[id^=code][id$=de' + idNo + ']').prop('id', "code" + inputId);
    $('.main-description').last().find('[id^=copybtn]').prop('id', "copybtn" + inputId);
    $('.main-description').last().find('[id^=codemaindiv][id$=maindiv' + idNo + ']').prop('id', "codemaindiv" + inputId);
    $('.main-description').last().find('[id^=practiceediting][id$=g' + idNo + ']').prop('id', "practiceediting" + inputId);
    $('.main-description').last().find('[id^=practicesaveedit][id$=t' + idNo + ']').prop('id', "practicesaveedit" + inputId);
    $('.main-description').last().find('[id^=practicesave][id$=ve' + idNo + ']').prop('id', "practicesave" + inputId);
    $('.main-description').last().find('[id^=practicesave][id$=ve' + inputId + ']').prop('disabled', false);
    $('.main-description').last().find('#code' + inputId).prop('disabled', false);
    $('.main-description').last().find('[id^=practicesave][id$=ve' + inputId + ']').html('Add other problem');
    $('.main-description').last().find('[id^=btndiv]').prop('id', "btndiv" + inputId);
    $('#code' + inputId).val("");
    $('#practice' + inputId).val("");
}
function addsnippet(t) {
    let idNo = parseInt(t.id.match(/\d+/g), 10);
    if ($('#codemaindiv1').css("display") == 'block') {
        let newNode = $('.code-detail').last().clone(true).prop('id', "codemaindiv" + idNo);
        let inputId = parseInt($('.code-detail').last().find('[id^=code]').prop("id").match(/\d+/g), 10) + 1;
        newNode.find('[id^=output]').prop('id', "output" + inputId);
        newNode.find('[id^=code]').prop('id', "code" + inputId);
        newNode.find('[id^=copybtn').prop('id', "copybtn" + inputId);
        newNode.insertBefore($('#btndiv' + idNo));
        $('#codemaindiv' + idNo).find('textarea').each(function () {
            $(this).prop("disabled", false);
        })
        $('#code' + inputId).val("");
        $('#output' + inputId).val("");
    }
    else if (!($('#codemaindiv1').length)) {
        $('#content-section').append(`<div class="description-details code-detail" id="codemaindiv1">
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

    </div>`);

    }
    else if ($('#codemaindiv1').css("display") == "none" && idNo != 1) {
        $('#codemaindiv1').css("display", "block");

        let newNode = $('.code-detail').last().clone(true).prop('id', "codemaindiv" + idNo);
        $('#codemaindiv1').remove();
        newNode.insertBefore($('#btndiv' + idNo));
        $('#codemaindiv' + idNo).find('textarea').each(function () {
            $(this).prop("disabled", false);
        })
    }
    else {
        $('#codemaindiv1').css("display", "block");
        $('#codemaindiv' + idNo).find('textarea').each(function () {
            $(this).prop("disabled", false);
        })
    }
}

function editSubTopic(t) {
    let idNo = parseInt(t.id.match(/\d+/g), 10);
    $('.main-description').find('#sub-topic' + idNo).prop("disabled", false);
    $('.main-description').find('#description' + idNo).prop("disabled", false);
    // if ($('#codemaindiv' + idNo).find('textarea').length) {
    //     $('#codemaindiv' + idNo).find('textarea').each(function () {
    //         $(this).prop("disabled", false);
    //     })
    // }
    $('#save' + idNo).css("display", "none");
    $('#saveedit' + idNo).css("display", "inline-block");


    //last line of function
    $('#editing' + idNo).css("display", "none");

}

function saveEdit(t) 
{
    let courseid= parseInt($('[id^=course]').prop("id").match(/\d+/g), 10);
    let moduleid= parseInt($('[id^=module]').prop("id").match(/\d+/g), 10);
    let topicid= parseInt($('[id^=topic]').prop("id").match(/\d+/g), 10);
    let subtopicid = parseInt(t.id.match(/\d+/g), 10);
    let subtopicname=$('#sub-topic'+subtopicid).val();
    console.log(subtopicid);
    console.log(subtopicname);
    let action="subtopicedit";
    let desc=$('#description'+subtopicid).val();
    if (subtopicname == "" || desc == "") {
        $('#errormsg').css("display", "block");
        if (subtopicname == "" && desc == "") {
            $('#msg').text("Opps!! there was no sub-topic name and description :(");
        }
        else if (subtopicname == "" && desc != "") {
            $('#msg').text("Opps!! there was no sub-topic name :(");
        }
        else {
            $('#msg').text("Opps!! there was no description :(");
        }
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
            subtopicname:subtopicname,
            desc:desc,
        },
        success:function()
        {
            $('#errormsg').css("display", "none");
            $('#save'+subtopicid).css("display","inline-block");
            $('#main-desc' + subtopicid).find('textarea').each(function () {
                $(this).prop("disabled", true);
            })
            $('#saveedit'+subtopicid).css("display", "none");
            $('#editing' + subtopicid).css("display", "inline-block");
            $('#main-desc' + subtopicid).children('input').prop("disabled", true);
            $('#smod'+moduleid+'ulsubtopic'+subtopicid).text(subtopicname);
        }
    })
}
    
function headEdit(t)
{
    
        let topicid = parseInt(t.id.match(/\d+/g), 10);
        let moduleid= parseInt($('#topic'+topicid).prev().attr("id").match(/\d+/g), 10);
        let courseid= parseInt($('[id^=course]').prop("id").match(/\d+/g), 10);
        $('#topic' + topicid).prop("disabled", false);
        $('#module' + moduleid).prop("disabled", false);
        $('#course' + courseid).prop("disabled", false);
        $('#headsave' + topicid).css("display", "none");
        $('#headchanges' + topicid).css("display", "inline-block");
    
        //last line of function
        
        $('#headedit' + topicid).css("display", "none");
   
}

function headChanges(t)
{
    let topicid = parseInt(t.id.match(/\d+/g), 10);
    let moduleid= parseInt($('#topic'+topicid).prev().attr("id").match(/\d+/g), 10);
    let courseid= parseInt($('[id^=course]').prop("id").match(/\d+/g), 10);
    let module = $('#module' + moduleid).val();
    let topic = $('#topic' + topicid).val();
    let course = $('#course'+courseid).val();
    if (topic == "" || module == "" || course== "") {
        $('#errormsg').css("display", "block");
        if (module == "" && topic == "" && course=="") {
            $('#msg').text("Opps!! there was no module and topic and course name :(");
        }
        else if (module == "" && topic != ""&& course!="") {
            $('#msg').text("Opps!! there was no module name :(");
        }
        else if(topic==""  && module != ""&& course!=""){
            $('#msg').text("Opps!! there was no topic name :(");
        }
        else
        {
            $('#msg').text("Opps!! there was no course name :(");
        }
        return false;
    }
    let action="headchange";
    $.ajax({
        url:"_edittutorialsdb.php",
        type:"POST",
        data:
        {
            action:action,
            courseid:courseid,
            moduleid:moduleid,
            topicid:topicid,
            course:course,
            module:module,
            topic:topic,
        },
        success:function(data)
        {
            console.log(data);
            $('#headsave' + topicid).css("display", "inline-block");
            $('#headchanges' + topicid).css("display", "none");
            $('#mod'+moduleid+'ultopic'+topicid).text(topic);
            $('#ulmodule'+moduleid).text(module);
            $('#ulcourse'+courseid).text(course);
            //last line of function
            
            $('#headedit' + topicid).css("display", "inline-block");
        }
    })
    
}
function addtopic() {
    let subid = $('[id^=save]').last()[0];
    let res = savetodb(subid);
    if (!res) {
        return false;
    }
    $('#right-side').html($('#newpage'));
    let inputId = parseInt($('[id^=topic]').prop("id").match(/\d+/g), 10) + 1;
    $('[id^=topic]').prop('id', 'topic' + inputId);
    $('[id^=headsave]').prop('id', 'headsave' + inputId);
    $('[id^=headedit]').prop('id', 'headedit' + inputId);
    $('[id^=headchanges]').prop('id', 'headchanges' + inputId);
    $('#headsave' + inputId).prop("disabled", false);
    $('#topic' + inputId).prop("disabled", false);
    $('#headsave' + inputId).html("Save");
    $('#headsave' + inputId).css("display","inline-block");
    $('#headedit' + inputId).css("display","none");
    $('#headchanges' + inputId).css("display","none");

    $('input').not('[id^=module],[id^=course]').val("");
    $('#newpage').find('[id^=main-desc').each(function () {
        if ($(this).attr("id") != "main-desc1") {
            $(this).remove();
        }
    });
    $('#newpage').find('[id^=codemaindiv').each(function () {
        if ($(this).attr("id") != "codemaindiv1") {
            $(this).remove();
        }
        else {
            $(this).css("display", "none");
        }
    });
    $('textarea').val("");
    $(window).scrollTop(0);
    $('#save1').css("display", "inline-block");
    $('#save1').html("Add other sub-topic");
    $('#save1').prop("disabled", false);
    $('#sub-topic1').prop("disabled", false);
    $('#description1').prop("disabled", false);

    $('#save1', '#headsave' + inputId).hover(function () {
        $(this).css("box-shadow", "gray 2px 2px 5px");
    }, function () {
        $(this).css("box-shadow", "none");
    });
    $('#saveedit1').css("display", "none");
    $('#snippetbtn1').css("display", "inline-block");
    $('#editing1').css("display", "none");
}
function addmodule() {
    let subid = $('[id^=save]').last()[0];
    let res = savetodb(subid);
    if (!res) {
        return false;
    }

    let moduleid = parseInt($('[id^=module]').prop("id").match(/\d+/g), 10);
    let courseid = parseInt($('[id^=course]').prop("id").match(/\d+/g), 10);
    if (!$('#quiz' + moduleid).length) {

        $('#quiz-modal').css('display', 'block');
        var quizresult = false;
        $('#quizmoduleid').html($('#module' + moduleid).val());
        $('#quiz-form').on('submit', function (e) {

            action = "quizsave";
            $.ajax({

                url: '_tutorialsdb.php',
                type: 'POST',
                data: $('#quiz-form').serialize() + "&action=" + action + "&courseid=" + courseid + "&moduleid=" + moduleid,
                success: function (data) {
                    $('#quiz-modal').css('display', 'none');
                    quizresult = true;
                    $('#main-page').append(data);
                    quizsaved(quizresult);
                }
            })
            e.preventDefault();
        });
    }
    else {
        quizresult = true;
        quizsaved(quizresult);
    }



}
function saveAssignment() {
    var practice = `<section id="newpage"><section id="practice">
    <div class="main-description" id="main-desc1">
        <div class="description-details">
            <textarea class="course-material description-box" id="practice1" cols="30" rows="6"
                placeholder="Your problem question goes here:"></textarea>
    
            <div class="description-details code-detail" id="codemaindiv1">
                <div class="codesnippet code">
                    <button class="codecopy" id="copybtn1" onclick="copy(this)">
                        <i class="fal fa-copy"></i>
                    </button>
                    <textarea cols="30" rows="16" id="code1"
                        placeholder="print('Hello World')"></textarea>
                </div>
    
            </div>
            <div class="textarea-buttons right" id="btndiv1">
                <button class="savebtn" id="practicesave1" onclick="practicesave(this)">Add other question</button>
                <button class="saveedit" id="practicesaveedit1" onclick="practicesaveEdit(this)">Save Changes</button>
                <button class="editbtn" id="practiceediting1" onclick="practiceeditques(this)">Edit
                    question</button>
            </div>
            <br>
        </div>
    </div>
    
</section>
<div class="textarea-buttons right">
<button id="donebtn" onclick="savePractice()" style="display:none;">Complete Written Course</button>
<button id="proceedbtn" onclick="saveAssignment()">Proceed</button>
</div></section>`;
    let guidelines = $('#guidelines textarea').val();
    let courseid = parseInt($('[id^=course]').prop("id").match(/\d+/g), 10);
    let action = "saveass";
    if (guidelines === "") {
        $('#errormsg').css("display", "block");
        $('#msg').text("Please add the guidlines for assignment :(");
        return false;
    }
    if ($('#guidelines textarea').prop("disabled") == false) {
        $.ajax({
            url: "_tutorialsdb.php",
            type: "POST",
            data:
            {
                action: action,
                courseid: courseid,
                ass: guidelines,
            },
            dataType: "html",
            success: function (data) {
                $('#guidelines textarea').prop("disabled", true);
                $('#main-page').append(data);

            }
        });
    }

    $('#right-side').html($('#title-of-course'));
    $('#right-side').append(practice);
    $('#practice').css("display", "block");
    $('#proceedbtn').hide();
    $('#donebtn').css("display", "block");
    $(window).scrollTop(0);

}
function savePractice() {

    let courseid = $('#navigation-menu').children('[id^=ulcourse]').attr("id");
    let courseidNo = parseInt(courseid.match(/\d+/g), 10);
    if ($('[id^=practicesave]').last().prev().prop("disabled")) {
        $('#right-side').html($('#title-of-course'));
    }
    else {

        let subid = $('[id^=practicesave]').last()[0];
        let res = practicesavetodb(subid);
        if (!res) {
            return false;
        }
        $('[id^=practicesave]').last().next().css("display", "inline-block")
        $('#donebtn').css("display", "none");
        $('#right-side').html($('#title-of-course'));

    }
    $('#right-side').append(`<div class="textarea-buttons align-center"><p><strong>You have successfully added a descriptive course for the learners. Now, please add the video features.</strong></p><button id="videotutorial" onclick="addVideotutorial(this)">Proceed Towards Video Tutorial</button></div>`);
    $('#videotutorial').attr("id", 'videotutorial' + courseidNo);
    $(window).scrollTop(0);
}
function addassignment() {
    
    let subid = $('[id^=save]').last()[0];
    let idNo = parseInt(subid.id.match(/\d+/g), 10);
    if ($('[id^=headsave]').prop("disabled") == false || ($('#save' + (idNo - 1)).length && $('#save' + (idNo - 1)).prop("disabled") == false)) {
        $('#errormsg').css("display", "block");
        $('#msg').text("You have some unsaved changes. Please save them first :(");
        return false;
    }
    let moduleid = parseInt($('[id^=ulmodule]').last().attr("id").match(/\d+/g), 10);
    let courseid = parseInt($('[id^=course]').prop("id").match(/\d+/g), 10);
    if (!$('#save' + idNo).prop("disabled")) {

        
        var subhead = $('#sub-topic' + idNo).val();
        var desc = $('#description' + idNo).val();
        
        if (subhead == "" || desc == "") {
            $('#errormsg').css("display", "block");
            if (subhead == "" && desc == "") {
                $('#msg').text("Opps!! there was no sub-topic name and description :(");
            }
            else if (subhead == "" && desc != "") {
                $('#msg').text("Opps!! there was no sub-topic name :(");
            }
            else {
                $('#msg').text("Opps!! there was no description :(");
            }
            return false;
        }
    }
    
    if (!$('#quiz' + moduleid).length) {

        $('#quiz-modal').css('display', 'block');
        var quizresult = false;
        $('#quizmoduleid').html($('#module' + moduleid).val());
        $('#quiz-form').on('submit', function (e) {

            action = "quizsave";
            $.ajax({

                url: '_tutorialsdb.php',
                type: 'POST',
                data: $('#quiz-form').serialize() + "&action=" + action + "&courseid=" + courseid + "&moduleid=" + moduleid,
                success: function (data) {
                    $('#quiz-modal').css('display', 'none');
                    quizresult = true;
                    $('#main-page').append(data);
                    completecourseSave()
                }
            })
            e.preventDefault();
        });
    }
    else {
        quizresult = true;
        completecourseSave();
    }
    function completecourseSave() {
        var ass = `<section id="assignment">
        <h3 style="margin-top:26px;">Instructions For Assignment Submission</h3>
        <div id="instructions" class="course-material description-box">
            You are required to build your assignment on <a href="https://jsfiddle.net/">jsfiddle.net</a>.
            <br><br>
            If you are not familiar with it,follow the instructions given below:
            <br>
            To create assignment.
            <br>
            1) go to <a href="https://jsfiddle.net/">jsfiddle.net</a>.
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
        <h3 style="margin-top:26px;">Guidelines For Assignment</h3>
        <div id="guidelines">
            <textarea class="course-material description-box" cols="30" rows="30"
                placeholder="The first version of HTML was written by Tim Berners-Lee in 1993. Since then, there have been many different versions of HTML. The most widely used version throughout the 2000's was HTML 4.01, which became an official standard in December 1999. Another version, XHTML, was a rewrite of HTML as an XML language!"></textarea>
        </div>
        <div id="pasteurl" class="description-details description-box course-material" style="margin-top:26px; padding:12px;">
            <strong style="text-transform: capitalize;">you are required to submit you project link below:</strong>
            <input type="text" style="padding: 3px;
            display: block;
            width: 100%;
            margin: 18px 0px;
            font-size: 1.2rem;margin-bottom: 20px;" readonly>
            <div class="textarea-buttons">

            <button id="submitassbtn">Submit Assignment</button>
            </div> <br>
        </div>
        <div class="textarea-buttons right">

            <button id="donebtn" onclick="savePractice()" style="display:none;">Complete Written Course</button>
            <button id="proceedbtn" onclick="saveAssignment()">Proceed</button>
        </div>
    </section>`;
        if (quizresult == true) {
            if ($('[id^=save]').last().prev().prop("disabled")) {
                $('#right-side').html($('#title-of-course'));
                $('#right-side').append($(ass));
                $('#assignment').css("display", "block");
            }
            else {
                let subid = $('[id^=save]').last()[0];
                let res = savetodb(subid);
                if (!res) {
                    return false;
                }
                $('#right-side').html($('#title-of-course'));
                $('#right-side').append($(ass));
                $('#assignment').css("display", "block");
                $('[id^=save]').last().prev().prop("disabled", true);
            }
            $(window).scrollTop(0);
        }
    }
}
function headSave(that) {
    let btnid = that.id;
    let moduleid = parseInt($('[id^=module]').prop("id").match(/\d+/g), 10);
    let module = $('#module' + moduleid).val();
    let topicid = parseInt($('[id^=topic]').prop("id").match(/\d+/g), 10);
    let topic = $('#topic' + topicid).val();
    if (topic == "" || module == "") {
        $('#errormsg').css("display", "block");
        if (module == "" && topic == "") {
            $('#msg').text("Opps!! there was no module and topic name :(");
        }
        else if (module == "" && topic != "") {
            $('#msg').text("Opps!! there was no module name :(");
        }
        else {
            $('#msg').text("Opps!! there was no topic name :(");
        }
        return false;
    }
    if ($('#course').length) {
        let action = "headsave";
        var course = $('#course').val();
        if (course == "") {
            $('#errormsg').css("display", "block");
            $('#msg').text("Opps!! there was no course name :(");
            return false;
        }
        $.ajax({
            url: "_tutorialsdb.php",
            type: 'POST',
            data: {
                action: action,
                course: course,
                mid: moduleid,
                m: module,
                tid: topicid,
                t: topic,
            },
            dataType: "html",
            success: function (data) {
                if(data==1)
                {
                    $('#errormsg').css("display", "block");
                    $('#msg').text("Opps!! Seems like you have already added this course. :(");
                    $('input[id^=course],[id^=topic],[id^=module]').prop("disabled", false);
                    return false; 
                }
                else
                {
                    $('#' + btnid).html("&#10004; Saved!");
                    $('#' + btnid).prop("disabled", true);
                    $('#' + btnid).css("box-shadow", "none");
    
                    $('#errormsg').css("display", "none");
                    $('#main-page').append(data);
                    $('#headedit'+topicid).css("display","inline-block");
                }
                
            }
        });
    }
    else {
        let action = "headsave1";
        let courseid = parseInt($('[id^=course]').prop("id").match(/\d+/g), 10);
        $.ajax({
            url: "_tutorialsdb.php",
            type: 'POST',
            data: {
                action: action,
                courseid: courseid,
                mid: moduleid,
                m: module,
                tid: topicid,
                t: topic,
            },
            dataType: "html",
            success: function (data) {
                $('#' + btnid).html("&#10004; Saved!");
                $('#' + btnid).css("box-shadow", "none");
                $('#' + btnid).prop("disabled", true);
                $('#errormsg').css("display", "none");
                $('#main-page').append(data);
                $('#headedit'+topicid).css("display","inline-block");
            }
        });
    }
    $('input[id^=course],[id^=topic],[id^=module]').prop("disabled", true);
    $('input[id^=course],[id^=topic],[id^=module]').css("color", "black");
}

function closeError() {
    $('#errormsg').css("display", "none");
}

function copy(t) {
    let idNo = parseInt(t.id.match(/\d+/g), 10);
    $('#code' + idNo).select();
    // $('#code'+idNo).setSelectionRange(0,99999);
    document.execCommand("copy");
}

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

function closequiz() {
    $('#quiz-modal').css("display", "none");
}

function assEditsave()
{
    let courseid=parseInt($('[id^=course]').attr("id").match(/\d+/g),10);
    let guidelines=$('textarea').val();
    if (guidelines === "") {
        $('#errormsg').css("display", "block");
        $('#msg').text("Please add the guidlines for assignment :(");
        return false;
    }
    let action="editass";
    $.ajax({
        url:"_edittutorialsdb.php",
        type:"POST",
        data:
        {
            action:action,
            guidelines:guidelines,
            courseid:courseid,
        },
        success:function()
        {
            $('#errormsg').css("display", "none");
            $('#assEditsave').css("display","none");
            $('#assEdit').css("display","block");
        }
    })
}

function assEdit()
{
    $('textarea').prop("disabled",false);
    $('#assEditsave').css("display","block");
    $('#assEdit').css("display","none");
}

function practiceeditques(elem)
{
    
    let practiceid=parseInt(elem.id.match(/\d+/g),10);
    $('#practice'+practiceid).prop("disabled",false);
    $('#code'+practiceid).prop("disabled",false);
    $('#practicesaveedit'+practiceid).css("display","inline-block");
    $('#practicesave'+practiceid).css("display","none");
    $('#practiceediting'+practiceid).css("display","none");
}
function practicesaveEdit(elem)
{
    let courseid=parseInt($('[id^=course]').attr("id").match(/\d+/g),10);
    let practiceid=parseInt(elem.id.match(/\d+/g),10);
    let que=$('#practice'+practiceid).val();
    let ans=$('#code'+practiceid).val();
    if (que == "" || ans == "") {
        $('#errormsg').css("display", "block");
        if (que == "" && ans == "") {
            $('#msg').text("Opps!! there was no practice question and solution :(");
        }
        else if (que == "" && ans != "") {
            $('#msg').text("Opps!! there was no practice question :(");
        }
        else {
            $('#msg').text("Opps!! there was no solution :(");
        }
        return false;
    }
    let action="editpractice";
    $.ajax({
        url:"_edittutorialsdb.php",
        type:"POST",
        data:
        {
            action:action,
            practiceid:practiceid,
            courseid:courseid,
            que:que,
            ans:ans,
        },
        success:function()
        {
            $('#errormsg').css("display", "none");
            $('#practice'+practiceid).prop("disabled",true);
            $('#code'+practiceid).prop("disabled",true);
            $('#practicesaveedit'+practiceid).css("display","none");
            $('#practicesave'+practiceid).css("display","inline-block");
            $('#practiceediting'+practiceid).css("display","inline-block");
        }
    })
}

function opensidebar()
{
    $('#navigation-menu').css("display","block");
    $('#navigation-menu').animate({width: "240px"});
}
function closenav()
{
    
    $('#navigation-menu').animate({width: "0px"});
    $('#navigation-menu').hide();
}

var sl = window.matchMedia("(min-width:972px");
        displayfun(sl);
        sl.addListener(displayfun);

        function displayfun(sl) {
            if (sl.matches) {

                // $('#navigation-menu').css("width", "300px");
                $('#navigation-menu').css("width", "20%");
                $('#navigation-menu').css("css", "block");
            }
        }
        var sl2 = window.matchMedia("(max-width:970px");
        displayfun(sl2);
        sl.addListener(displayfun2);
        function displayfun2(sl2)
        {
            if (sl.matches) {

            $('#navigation-menu').css("width", "240px");
            $('#navigation-menu').css("css", "none");
            }
        }