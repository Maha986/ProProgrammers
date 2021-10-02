function openTopic(elem) {
    let topicidNo = parseInt(elem.id.slice(-5).match(/\d+/g), 10);
    let moduleidNo = parseInt(elem.id.slice(0, 7).match(/\d+/g), 10);
    
    
    let courseid = $('#navigation-menu').children('[id^=ulcourse]').attr("id");
    
    let courseidNo = parseInt(courseid.match(/\d+/g), 10);
    

    let action = "showtopic";
    $.ajax({
        url: '_tutorialsdb.php',
        type: 'POST',
        data:
        {
            action: action,
            courseid: courseidNo,
            moduleid: moduleidNo,
            topicid: topicidNo,
        },
        success: function (data) {
            console.log(data);
            $('#right-side').html('');
            $('#right-side').append(data);
            $('input').css("color","black");
            $('textarea').css("color","black");
            $('.codesnippet textarea').css("color","white");

            if (!$('#mod'+moduleidNo+'ultopic' + (topicidNo + 1)).length && !$('#ulmodule' + (moduleidNo + 1)).length && !$('[id^=ulassignment]').length) {
                
                $('#newpage').append(`<section id="btn-section">
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
    </div>`);
            }
        }
    })

}

function openAss()
{
    let courseid = $('#navigation-menu').children('[id^=ulcourse]').attr("id");
    let courseidNo = parseInt(courseid.match(/\d+/g), 10);
    var msgresult=false;
    if($('#ulpractice'+courseidNo).length && $('#practice').length && ((($('#practice [id^=practice]').not($('[id^=btndiv]').children())).last()).attr("id")!="practice1") && (!(($('#practice [id^=practice]').not($('[id^=btndiv]').children())).last()).prop("disabled")))
    {
        $('#errormsg').css("display", "block");
        $('#errormsg span').hide();
        $('#errormsg button').css("display","block");
        // return false;
        $('#msg').text("If you go to previous page, you will not be able to add new practice problems. Do you really want to view assignment?");
        $('#yes').on("click",function()
        {
            $('#errormsg').css("display", "none");
            $('#errormsg span').show();
            $('#errormsg button').css("display","none");
            msgresult=true;
            view(msgresult);
        })
        $('#no').on("click",function()
        {
            $('#errormsg').css("display", "none");
            $('#errormsg span').show();
            $('#errormsg button').css("display","none");
            msgresult=false;
            view(msgresult);
        })
        
        
    }
    else
    {
        msgresult=true;
        view(msgresult);
    }
    function view(msgresult)
    {
        if(msgresult)
    {

        let action="showass";
        $.ajax({
            url:"_tutorialsdb.php",
            type:"POST",
            data:
            {
                action:action,
                courseid:courseidNo,
            },
            success:function(data)
            {
                $('#right-side').html('');
                $('#main-page').append(data);
                $('[id^=course]').css("color","black");
                if(!$('#ulpractice'+courseidNo).length)
                {
                    $('#assignment').append(`<div class='textarea-buttons right'>
            
                    <button id='donebtn' onclick='savePractice()' style='display:none;'>Done</button>
                    <button id='proceedbtn' onclick='saveAssignment()'>Proceed</button>
                </div>`);
                }
            }
        })
    }
    }
    
}

function openPractice()
{
    let coursediv=$('#title-of-course');
    let courseid = $('#navigation-menu').children('[id^=ulcourse]').attr("id");
    let courseidNo = parseInt(courseid.match(/\d+/g), 10);
    let action="showpractice";
    $.ajax({
        url:"_tutorialsdb.php",
        type:"POST",
        data:
        {
            action:action,
            courseid:courseidNo,
        },
        success:function(data)
        {
            $('textarea').not('[id^=code]').css("color","black");
            $('#right-side').html("");
            $('#right-side').append(coursediv);
            $('#main-page').append(data);
        }
    })
}

function openQuiz(elem)
{
    let moduleidNo = parseInt(elem.id.match(/\d+/g), 10);
    let courseid = $('#navigation-menu').children('[id^=ulcourse]').attr("id");
    let courseidNo = parseInt(courseid.match(/\d+/g), 10);
    

    let action = "showquiz";
    $.ajax({
        url: '_tutorialsdb.php',
        type: 'POST',
        data:
        {
            action: action,
            courseid: courseidNo,
            moduleid: moduleidNo,
        },
        success:function(data)
        {
            $('#right-side').append(data);
            $('#right-side #quiz-form input').css("color","black");
        }
    })
}