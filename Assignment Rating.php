<?php session_start();
require "_dbconnect.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="stylesheet" href="css/home.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
  <a href="https://icons8.com/icon/54615/course-assign"></a>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <!-- <link rel="stylesheet" href="chat.css"> -->
 
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script> -->
  <title>ProProgrammers| Assignment Review Section</title>



  <style>
    * {
      box-sizing: border-box;
    }

  #course,#assignment-comment {
      width: 100%;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 4px;
      resize: vertical;
      background-color: white;
      font-size: 1.2rem;
      border: 2px solid #1eb2a6; ;
    }

   #assignment-review label {
      padding: 12px 12px 12px 0;
      font-size: 1.2rem;
      display: inline-block;
    }
    .container {


      padding: 0px 10px;
    }

    .col-25 {
      float: left;
      width: 15%;
      margin-top: 6px;
      /* border: 1px solid black; */
      margin-left: 100px;

    }

    .col-75 {
      float: left;
      width: 55%;
      margin-top: 6px;
      /* border:1px s olid black; */
    }

    /* Clear floats after the columns */
    .row:after {
      content: "";
      display: table;
      clear: both;
    }
    .result-container{
        width: 100px; 
        height: 22px;
        background-color: #ccc;
        vertical-align:middle;
        display:inline-block;
        position: relative;
        top: -4px;
    }
    .rate-stars{
        width: 100px;
         height: 22px;
        background: url("img/unnamed.png") no-repeat;
        background-size: cover;
        position: absolute;
    }
    .rate-bg{
        height: 22px;

        background-color: #ffbe10;
        position: absolute;
    }


 .comment-panel{
  border:2px solid #1eb2a6;
  background-color:white;
  margin-top: 10px;
  border-radius: 7px;
  
}
.comment-header{
  border-bottom:2px solid #1eb2a6;
  /* background-color: blanchedalmond; */
  height:40px;
  padding-top:8px;
  padding-left:5px;

  border-radius: 7px;
}
.comment-body{
  /* border:1px solid black; */
  /* background-color:yellow; */
  min-height: 80px;
  overflow-wrap: break-word;
  max-height:auto;
  padding: 10px;
  
}

.comment-footer{
  /* border:1px solid black; */
  background-color: white;
  height:40px;
  padding-top: 10px;
  border-top:2px solid #1eb2a6;
  border-radius: 7px;
  
}
.reply,.delete{
  float: right;
  background: #1eb2a6;
    height: 35px;
    width: 70px;
    font-size: 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    color:white;
    margin-right: 10px;
    padding-top: 0px;
}
.modal-body p
{
  line-height:unset !important;
}
#alerts{
  display: none; padding-top:30px;background-color: transparent;
  background-color: rgba(0,0,0,0);
}
#alerts .modal-content{
  border-radius: 10px;padding-top: 1px;;
}
#alerts #closealert{
  font-size:24px; float: right;margin-right: 10px;cursor: pointer;
}



  /* Responsive layout - when the screen is less than 600px wide, make the two columns stack on top of each other instead of next to each other */ 
  @media screen and (max-width: 670px) {
    .col-25 {
        width: 28%;
        margin-left: 10px
      }
  }
    @media screen and (max-width: 600px) {

      .col-75,
      input[type=submit] {
        width: 62%;
        margin-top: 0;

      }

      .col-25 {
        width: 28%;
        margin-left: 10px
      }
      .reply,.delete{
        width:50px;
        font-size: 11px;
      
      }
    }
    @media screen and (max-width:400px)
    {
      .col-25 {
        width: 100%;
      }
      .col-75,
      input[type=submit] {
        width: 100%;

      }
    }
  </style>
</head>

<body>
  <?php
  include "nav.php";
  include "signup.php";
  include "login.php";
  ?>
  <h1 style="text-align: center; margin:20px;">Assignment Review Section</h1>

  <div class="container">
    <form id="assignment-review">


      <div class="row">
      


          <div class="col-25">
            <label for="country">Course:</label>
          </div>
          <div class="col-75">
            <select id="course" name="course">

              <?php
              if($loggedin)
              {
                $selectcourse=$conn->prepare("SELECT courses.`CourseName` FROM `courses` LEFT JOIN `enrollment` ON courses.`CourseId`=enrollment.`CourseId` WHERE enrollment.`username`=?");
                $selectcourse->bind_param('s',$_SESSION["username"]);
                $selectcourse->execute();
                $selectedcourse=$selectcourse->get_result();
                if(mysqli_num_rows($selectedcourse)>0)
                {
                  while($row=mysqli_fetch_assoc($selectedcourse))
                  {
                    $course=$row['CourseName'];
                    echo "<option value='$course'>$course</option>";
                  }
                }
              }
              ?>
            </select>
          </div>
      </div>
      <div class="row">
        <div class="col-25">
          <label for="comment">Comment:</label>
        </div>
        <div class="col-75">
          <textarea name="assignmnet-comment" id="assignment-comment" placeholder="Enter Comment. You can incude your assignment URL here." style="height:200px" required></textarea>
        </div>
      </div>
      <div class="row">
        <div class="col-25">

        </div>
        <div class="col-75 ">
          <!-- <input type="hidden" name="assignment_comment_id" id="assignment_comment_id" value="0" /> -->
        <Button type="submit"  class="Find" style="width:160px;">  <i class="fas fa-comment-dots"></i>&nbsp;&nbsp;&nbsp;Add Comment</Button>
        </div>

      </div>
    </form>
    <div id="display_assignment_comment" class="row" style="width:90%;margin:auto;"></div>
    </form>
  </div>


  <div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content" style="height: 200px;border:1px solid black;background-color:white">
      <span id="closeit" style="color:grey" class="close">&times;</span>
      <h1 style="text-align: center;font-size:2em;margin-top:20px;">RATE THE ASSIGNMENT</h1>
  
      <div style="display:flex;justify-content:center;margin-top:20px;">

      <span class="fa fa-star fa-2x" data-index="0"></span>
      <span class="fa fa-star fa-2x" data-index="1"></span>
      <span class="fa fa-star fa-2x" data-index="2"></span>
      <span class="fa fa-star fa-2x" data-index="3"></span>
      <span class="fa fa-star fa-2x" data-index="4"></span>
     </div>
     <div style="display:flex;justify-content:center;margin-top:20px;">

    
      <input type="hidden" id="submitrate" value="">
      <input type="submit" class="Find" style="width: 90px;" id="submitrating" value="Rate it">
      </div>
      </div>

   

  </div>

  <div id="alerts" class="modal">
        <div class="modal-content">
           <div><span id="closealert">&times;</span></div>
                
           
            <div class="modal-body" style="padding:2px; line-height:unset;">
                <p></p>
            </div>
        </div>

    </div>

</body>
<script>
  <?php if($loggedin) { ?>
  var span = document.getElementById("closeit");
  span.onclick = function() {
    $("#myModal").css("display", "none")
  }
  var span1 = document.getElementById("closealert");
  span1.onclick = function() {
    $("#alerts").css("display", "none")
  }
  $(document).ready(function() {
    var ratedindex = -1;
    load_comment();
    $('#assignment-review').on('submit', function(event) {
      event.preventDefault();
      var comment = $("#assignment-comment").val();
      var topic = $("#course").val();
// console.log(comment);console.log(topic);
      var action = "add";
      <?php if ($loggedin) { ?>
        $.ajax({
          url: "dbassignmentchat.php",
          type: "POST",
          data: {
            comment: comment,
            topic: topic,
            action: action,
          },
          success: function(data) {
            //   console.log(data);
            if (data == 1)
            {
              $('#assignment-review')[0].reset();
              load_comment();
            } else {}
          }
        })
      <?php } ?>
      load_comment();

    });

    function load_comment() {
      var action = "load";
      $.ajax({
        url: "dbassignmentchat.php",
        method: "POST",
        
        data: {
          action: action,
        },
        success: function(data) {
          $('#display_assignment_comment').html(data);
        }
      })
    }
    $(document).on('click', '.reply', function() {
      var action = "open";
      var s = $(this).attr("id").replace(/[A-Za-z$-]/g, "");
      modal_open_id = parseInt(s);
      $('#submitrate').val(modal_open_id);
      var modal_id = $('#submitrate').val();
      $.ajax({
        url: "dbassignmentchat.php",
        method: "POST",
        data: {
          action: action,
          modal_id: modal_id,
        },
        success: function(data) {
          
          if (data == 2) {
            console.log(data);
            $("#myModal").css("display", "block");
            starreset();

          } 
          if (data == 0) {
            console.log(data);
            $("#alerts").css("display","block");
            $("#alerts").css("color","red");
            $("#alerts .modal-content").css("background-color","pink");
            $("#alerts .modal-content").css("border","2px solid red");
            // $("#myModal").css("display", "none");
            $('#alerts p').text("you cannot rate your own project");
           
          }  if(data == 1 ) {
         console.log(data);

            $("#alerts").css("display","block");
            $("#alerts").css("color","forestgreen");
            $("#alerts .modal-content").css("background-color","lightgreen");
            $("#alerts .modal-content").css("border","2px solid forestgreen");
   
            $('#alerts p').text("you already rated this project");
           
         
        //   }
        
        }
      }
      })
    });
    $(".fa-star").on("click", function() {
      ratedindex = parseInt($(this).data("index"));
    })
    $(".fa-star").mouseover(function() {
      starreset();
      var currentindex = parseInt($(this).data("index"));
      for (var i = 0; i <= currentindex; i++) {
        $(".fa-star:eq(" + i + ")").css("color", "yellow");
      }
    })
    $(".fa-star").mouseleave(function() {
      starreset();
      if (ratedindex != -1) {
        for (var i = 0; i <= ratedindex; i++) {
          $(".fa-star:eq(" + i + ")").css("color", "yellow");
        }
      }
    })

    function starreset() {
      $(".fa-star").css("color", "grey");

    }
    $("#submitrating").on("click", function() {
      var action = "rate";
      var i = ratedindex;
      var modal_id = $('#submitrate').val();
      $.ajax({
        url: "dbassignmentchat.php",
        method: "POST",
        data: {
          action: action,
          i: i,
          modal_id: modal_id,
        },
        success: function(data) {
          if (data == 1) {
            $("#myModal").css("display", "none");
            load_comment();
            $("#alerts").css("display","block");
            $("#alerts").css("color","forestgreen");
            $("#alerts .modal-content").css("background-color","lightgreen");
            $("#alerts .modal-content").css("border","2px solid forestgreen");
   var newrating=i+1;
            $('#alerts p').text("You give "+newrating+" rating to this assignment");
           
          } else {
           
          }
        }
      })
    })

    $(document).on('click', '.delete', function() {
    
    var del_comment_id = $(this).attr("id").replace(/[A-Za-z$-]/g, "");
     del_id = parseInt(del_comment_id);
     var action="delete";
    // console.log(del_comment_id);
    $.ajax({
      url: "dbassignmentchat.php",
      type: "POST",
      data: {
        del_id: del_id,
        action:action,
      },

   
      success: function(data) {
        if (data == 1) {
         
          load_comment();
        }else{
         
        }
      }
    })
  });
})
<?php } else
   {?>
    location.href="index.php";
<?php   }

   ?>
</script>

</html>