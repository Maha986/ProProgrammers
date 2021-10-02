<?php
session_start()
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    /* Style the buttons that are used to open and close the accordion panel */
    .accordion {
      background-color: white;
      color: #1eb2a6;
      cursor: pointer;
      padding: 22px;
      width: 100%;
      text-align: left;
      border: none;
      border-radius: 4px;
      border-top: 1px solid #1eb2a6;
      font-size: 1.2em;
      font-weight: bold;

      margin: auto;
      /* outline: #1eb2a6; */
      transition: 0.4s;
    }

    .panel p {
      color: black;
      padding: 20px;
      font-size: 1em;
    }

    .accordion:after {
      content: '\02795';
      /* Unicode character for "plus" sign (+) */
      font-size: 13px;
      color: #777;
      float: right;
      margin-left: 5px;
    }

    .active:after {
      content: "\2796";

      /* Unicode character for "minus" sign (-) */
    }

    /* Add a background color to the button if it is clicked on (add the .active class with JS), and when you move the mouse over it (hover) */
    .active,
    .accordion:hover {
      background-color: lightseagreen;
      color: white
    }

    /* Style the accordion panel. Note: hidden by default */

    .panel {
      padding: 0 18px;
      background-color: white;
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.2s ease-out;
    }

    #home1 {
      background: url("img/22.jpg") no-repeat center center/cover;
      padding: 29px;
      display: flex;
      justify-content: space-evenly;
      height: 400px;
    }

    #homew p {
      margin: auto;
      font-size: 1.3em;
      padding: 12px 0px;
      line-height: 28px;
      color: white;
    }

    #homew h3 {
      margin: auto;
      line-height: 41px;
      padding: 12px 0px;
      font-size: 2.3em;
      color: white;
    }

    #searchalert {
      display: none;
      padding-top: 30px;
      background-color: transparent;
      background-color: rgba(0, 0, 0, 0);
    }

    #searchalert .modal-content {
      border-radius: 10px;
      height: 40px;
      padding-top: 1px;
      ;
    }

    #searchalert #searchclose {
      font-size: 30px;
      float: right;
      margin-right: 10px;
      cursor: pointer;
    }

    #searchsection button {
      font-size: 1.2em;
    }

    @media screen and (max-width:500px) {
      #searchsection button {
        font-size: 0.8em;
      }
    }
  </style>




</head>

<body>
  <?php
  include "nav.php";
  //   include "signup.php";
  include "login.php";
  ?>

  <section id="home1">


    <div class="in" id="homew">
      <div style="display:flex;justify-content:center;width:100%">
        <img src="img/xx.png" style="width:100%">
      </div>
      <h2 style="text-align: center;color:white">Welcome to Proprogrammers </h2>
      <h3 style="text-align: center;">How Can We Help You? </h3>
      <form id="searchsection">


        <input type="text" name="searchqs" id="searchqs" style="margin:auto;height:60px;border-radius:7px;width:73%;margin-top:15px;">

        <button style="width: 20%;margin-left:0;height:65px;background-color:darkslategrey;border-radius:7px;color:white;;"><a href="FAQ.php#qssection" style="color:white;text-decoration:none"  onclick="xyz()">Search</a></button>
        <!-- <input type="search" id="query" name="q"
   placeholder="Search..."
   aria-label="Search through site content">
  <button>Search</button> -->


      </form>
      <!-- <p>
              Ease your learning by joining us. Solve your queries at any stage. Learn by practice and hard work and
              continue to grow.
          </p>
          <button class="homebtn" id="coursebtn">View Courses &nbsp;<span>&#8594;</span> </button>
          <button class="homebtn" id="librarybtn">View Library &nbsp;<span>&#8594;</span></button> -->
    </div>


  </section>
  <section style="width: 80%;margin:auto;color:darkcyan" id="qssection">

    <h1 style="text-align: center;margin:20px 0px 20px 0px;padding-top:20px;">Frequently Asked Questions(FAQ)</h1>
    <div style=" border-radius: 4px; ">


      <button class="accordion">What if my assignment does not get more than 3 rating?</button>
      <div class="panel">
        <p>In case, if lot of people reviewed your assignment but your rating did not increase to 3 or more,
          it means that either you did not not follow the assignment submission instructions properly or your did not do the assignment correctly. Now, to know your mistake,you can comment in the Chat Section <a href="Chat.php">Click Here</a> with your assignment link and ask the mistake. After correcting the mistake,
          you can again post your assignment in the Assignment Review Section. <a href="Assignment Rating.php">Click Here</a> </p>
      </div>

      <button class="accordion">Why I get message of signup first at time of login even though I already registerd myself last time?</button>
      <div class="panel">
        <p>You get this message because did not enter the verification code that sent to you through your email at registration time. Without entering verification code you cannot be the member of ProProgrammers. So now, you should again register yourself. </p>
      </div>

      <button class="accordion">How do I know that my course certificate is enable for me?</button>
      <div class="panel">
        <p>When ever your course project get 3 or more rating from reviewers,your certificate will be enabled for you. an email will send to You about your certificate.</p>
      </div>
      <button class="accordion">How do I get the solutions of practice questions?</button>
      <div class="panel">
        <p>To get the solutions of practice questions, you should have to get token. For this you have to upload some document pr book relevent to website purpose. You can upload document<a href="library.php">here</a> </p>
      </div>
      <button class="accordion">What are the usage of token recieved in library</button>
      <div class="panel">
        <p>You received a token when uou upload a relevant document in library .<a href="library.php"> Library</a> The token is used to view solutions of some practices questions.</p>
      </div>
      <button class="accordion">How much tokens are required for viewing practice solution</button>
      <div class="panel">
        <p>You can view excatly 2 solutions per token.</p>
      </div>
      <button class="accordion">Where I can give suggestions?</button>
      <div class="panel">
        <p>You can give suggestions to our <strong>ProProgrammers Team </strong>by sending email at <b>>proprogrammers.world@gmail.com</b></p>
      </div>
      <button class="accordion">Do the course enrollment if for limited time?</button>
      <div class="panel">
        <p>No, once you enrolled in the course , you got the lifetime access to the course. You can view the course,progrress or uploaded assignment anytime.</p>
      </div>
      <button class="accordion">Are all the courses free?</button>
      <div class="panel">
        <p>ProProgrammesr is learner friendly website. It offers all the courses free.</p>
      </div>
    </div>
  </section>

  <div id="searchalert" class="modal">
    <div class="modal-content">
      <div><span id="searchclose">&times;</span></div>


      <div class="modal-body" style="padding:2px;">
        <p></p>
      </div>
    </div>

  </div>
  <?php
  include "footer.php";
  ?>
</body>

<script>
  var acc = document.getElementsByClassName("accordion");
  var i;

  for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
      this.classList.toggle("active");
      var panel = this.nextElementSibling;
      if (panel.style.maxHeight) {
        panel.style.maxHeight = null;
      } else {
        panel.style.maxHeight = panel.scrollHeight + "px";
      }
    });
  }

  var flag = false;
  const xyz = () => {
    let filter = document.getElementById("searchqs").value.toUpperCase();
    let sec = document.getElementById("qssection");
    let btn = sec.getElementsByTagName("button");
    for (var i = 0; i < btn.length; i++) {
      let a = btn[i].innerText.toUpperCase();

      var words = filter.split(" ");
      for (var j = 0; j < words.length; j++) {
        if (a.indexOf(words[j]) > -1) {
          flag=true;
          // let m =i;
          // btn[i].style.display="block";
          btn[i].style.backgroundColor = "teal";
          btn[i].style.color = "white";
          btn[i].classList.toggle("active");
          var panel = btn[i].nextElementSibling;
          panel.style.maxHeight = panel.scrollHeight + "px";


        // } else {
        //   if (i == btn.length - 1 && j == words.length - 1) {
        //     flag = true;

        //     break;
        //     console.log("bad");
        //   }

        // }


      }
      // if (flag == true) {
      //   break;
      // }
    }
   

  }
  if (flag ==  false) {
      $("#searchalert").css("display", "block");
      $("#searchalert").css("color", "");
      $("#searchalert .modal-content").css("background-color", "pink");
      $("#searchalert .modal-content").css("border", "2px solid red");
      // $("#myModal").css("display", "none");
      $('#searchalert p').text("No such results found");
    }
  }
</script>

</html>