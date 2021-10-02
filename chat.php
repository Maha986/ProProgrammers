<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" /> -->
  <link rel="stylesheet" href="css/home.css">
  <link rel="stylesheet" href="css/chat.css">
  <title>ProProgrammers| Chat</title>
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
  <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> -->
</head>

<body>
  <?php
  include "nav.php";
  include "signup.php";
  include "login.php";


  ?>
<!-- <div style="margin: auto;border:1px solid black;"> -->

<br>
<br>
  <h2>ASK YOUR QUERIES HERE</h2>
  <br>
  <div id="chat-div">
    <form method="POST" id="comment_form" >

      <div id="comment-area">
        <textarea name="comment_content" id="comment_content" placeholder="Enter Comment" rows="10" cols="180" required style="border:2px solid #1eb2a6 ;border-radius:4px;    font-size: 1.2rem;padding: 7px;"></textarea>
      </div>
      <div>
        <input type="hidden" name="comment_id" id="comment_id" value="0" />
        <button type="submit" name="submit" id="submit" class="Find" style="height: 50px;width:130px;"><i class="fas fa-comments"></i>&nbsp;Add Comment</button>
      </div>
    </form>
    <!-- <span id="comment_message"></span> -->
    <br />
    <div id="display_comment" >
    
    </div>
  </div>
 <?php
 include "footer.php";
 ?>
</body>

</html>
<script>
  $(document).ready(function() {
    load_comment()
    
    
    $(document).on('click', '.delete', function() {
      var del_comment_id = $(this).attr("id").replace(/[A-Za-z$-]/g, "");
     del_id = parseInt(del_comment_id);
      var del_comment_id = $(this).attr("id");
      // console.log(del_comment_id);
      $.ajax({
        url: "delete_comment.php",
        type: "POST",
        data: {
          del_id: del_id,
        },

        dataType: "JSON",
        success: function(data) {
          if (data == 1) {
           
            load_comment();
          }else{
            console.log(data);
          }
        }
      })
    })






    $('#comment_form').on('submit', function(event) {

      event.preventDefault();
      var form_data = $(this).serialize();
      // var action="add";
      <?php if ($loggedin) { ?>
        $.ajax({
          url: "add_comment.php",
          type: "POST",
          data: form_data,

          dataType: "JSON",
          success: function(data) {
            if (data == 1) {

              $('#comment_form')[0].reset();

              $('#comment_id').val('0');
              load_comment();
            }

          }
        })
      <?php } ?>
    });
    load_comment();

    function load_comment() {
      $.ajax({
        url: "fetch_comment.php",
        method: "POST",
        success: function(data) {
          $('#display_comment').html(data);
        }
      })
    }
    $(document).on('click', '.reply', function() {
      var comment_id = $(this).attr("id");
      $('#comment_id').val(comment_id);
      $('#comment_content').focus();
    });

  });
</script>