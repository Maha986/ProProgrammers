<?php
session_start();
include "_dbconnect.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProProgrammers| Notes</title>
    <style>
        #make-notes label {
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
            margin-left: 100px;

        }

        #note-title,
        #note-details {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
            background-color: white;
            font-size: 1.2rem;
            border: 2px solid #1eb2a6;
            ;
        }

        .col-75 {
            float: left;
            width: 55%;
            margin-top: 6px;
            /* border:1px s olid white; */
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        .btn {
            margin: 12px;

            background: transparent;
            height: 30px;
            border-radius: 6px;
            color: rgb(255, 255, 255);
            cursor: pointer;
            outline: none;

        }

        .searchbtn {
            position: absolute;
            right: 23px;
            width: 57px;
            margin-left: auto;
            margin-right: auto;
            display: block;
        }

        * {
            padding: 0px;
            margin: 0px;
        }

        .new {
            background-color: teal;
            color: white;
            width: 43%;
            height: 245px;
            overflow: auto;
            margin-bottom: 5px;
            padding: 23px;
            border-radius: 10px;
        }

        .new h3 {
            margin-bottom: 6px;
        }

        #notes {
            display: flex;
            width: 60%;
            margin: auto;
            flex-wrap: wrap;
            justify-content: space-evenly;
        }
        
        .notebtns,
        .savebtns,.colorbtns {
            cursor: pointer;
            border: none;
            font-size: 19px;
            margin-bottom: 6px;
            /* width: 50px; */
            margin-left: 6px;
            color: white;
            background: transparent;
            float: right;
        }
        .colorbtns
        {
            float: none;
        }
        .edit {
            display: inline-block;
        }

        .savebtns {
            display: none;
        }

        .deletebtns {
            float: right;
            color: white;
            background: transparent;
            font-size: 19px;
            border: none;
            color: white;
            cursor: pointer;
        }

        .deletebtns:active,
        .notebtns:active,
        .savebtns:active {
            transform: scale(1.03);
        }

        #msg {
            color: white !important;
            padding: 7px;
            text-align: center;
            font-size: 1.2rem;
            display: inline-block;
            width: 93%;
        }

        #errormsg span {
            float: right;
            padding: 7px;
            cursor: pointer;
        }

        #errormsg {
            background-color: green !important;
            display: none;
            position: sticky;
            top: 50px;
            z-index: 10;
        }
        .colors
        {
            display:none;
        }
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

        }

        @media screen and (max-width:400px) {
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
    include "login.php";
    include "signup.php";
?>
    <div id="errormsg">
        <p id="msg"></p>
        <span onclick="closeError()">&#10006</span>
    </div>
    <h1 style="text-align: center; margin:20px;">Notes Keeping</h1>
    <div class="container">
        <form id="make-notes" action="inotes.php" method="POST">
            <div class="row">
                <div class="col-25">
                    <label for="title">Title:</label>
                </div>
                <div class="col-75">
                    <input type="text" id="note-title" name="title" placeholder="A note for the rememberance." required>
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="details">Note Description:</label>
                </div>
                <div class="col-75">
                    <textarea name="details" id="note-details" placeholder="This is my note for my personal learning."
                        style="height:200px" required></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-25">

                </div>
                <div class="col-75 ">
                    <!-- <input type="hidden" name="assignment_comment_id" id="assignment_comment_id" value="0" /> -->
                    <Button type="submit" class="Find" style="width:136px; height:44px; margin-bottom:13px;"> <i
                            class="fas fa-sticky-note"></i>&nbsp;&nbsp;&nbsp;Add Note</Button>
                </div>

            </div>
        </form>
        <?php
            if($_SERVER['REQUEST_METHOD']=='POST')
            {
                $title=$_POST['title'];
                $description=$_POST['details'];
                $username=$_SESSION["username"];
                $notesinsert=$conn->prepare("INSERT INTO `notes` (`Title`,`Detail`,`username`) VALUES (?,?,?)");
                $notesinsert->bind_param('sss',$title,$description,$username);
                $notesinsert->execute();
            }
        ?>

        <div id="notes">
            <?php
            $notesselect=$conn->prepare("SELECT * FROM `notes` WHERE `username`=?");
            $notesselect->bind_param('s',$_SESSION["username"]);
            $notesselect->execute();
            $noteselectresult=$notesselect->get_result();
            $rnum=mysqli_num_rows($noteselectresult);
            if($rnum>0)
            {
                $i = 1;
                $j = 1;
                while ($row = mysqli_fetch_assoc($noteselectresult)) 
                {
                $id = $row["SNo"];
                $color=$row["color"];
                $tit = $row["Title"];
                $dec = $row["Detail"];
                echo "<div class='new' id='note$id' onclick='hidecolor(this.id)' style='background-color:$color;'>
                    <button class='savebtns' id=$id onclick=save(this.id)><i class='far fa-cloud-upload'></i></button>
                    <button type='button' class='notebtns' id=$id onclick=edit(this.id)><i class='fal fa-edit'></i></button>
                    <button class='deletebtns' id=$id onclick=ndelete(this.id)><i class='far fa-trash'></i></button>
                    <button id=$id class='colorbtns' onmouseover=colorbtn(this.id)><i class='far fa-palette'></i></button>
                    <div class='colors' id=color$id onmouseover=colorbtn(this.id)><button class='colorbtns' id='og$id' onclick=olivegreen(this.id) style='color:darkolivegreen;'><i class='fas fa-circle' style='border: 1px solid white; border-radius: 50%;background-color:darkolivegreen;'></i></button> <button class='colorbtns' id='sg$id' onclick=seagreen(this.id) style='color:seagreen;'><i class='fas fa-circle' style='border: 1px solid white; border-radius: 50%;background-color:seagreen;'></i></button> <button class='colorbtns' id='dr$id' onclick=darkred(this.id) style='color:darkred;'><i class='fas fa-circle' style='border: 1px solid white; border-radius: 50%;background-color:darkred;'></i></button> <button class='colorbtns' id='dc$id' onclick=darkcyan(this.id) style='color:darkcyan;'><i class='fas fa-circle' style='border: 1px solid white; border-radius: 50%;background-color:darkcyan;'></i></button> <button class='colorbtns' id='pe$id' onclick=peru(this.id) style='color:peru;'><i class='fas fa-circle' style='border: 1px solid white; border-radius: 50%;background-color:peru;'></i></button></div>
                    
                <div class='mydiv' id=$id><h3 id='myhead'>$tit</h3><p id='mydes'>$dec</p></div> </div>";
                $i = $i + 1;
                $j=$j+1;
                }
            }
        ?>
        </div>
        <?php
            include "footer.php";
        ?>


        <script src="js/jquery-3.6.0.min.js"></script>
        <!-- stop the resubmission of form on reloading document -->
        <script>
        <?php 
        if ($loggedin) { ?>
        if (window.history.replaceState) {
                    window.history.replaceState(null, null, window.location.href);
                }
                function colorchange(color,id)
                {
                    console.log("enteed");
                    id=parseInt(id.match(/\d+/g), 10);
                    let action="color_change";
                    $.ajax({
                        url:"_notesdb.php",
                        type:"POST",
                        data:{
                            action:action,
                            id:id,
                            color:color,
                        },
                        success:function(data)
                        {
                            console.log(data);
                            $('#note'+id).css("background-color",color);
                            $('#color'+id).css("display","inline");
                        }
                    })
                }
                function olivegreen(id)
                {
                    colorchange("darkolivegreen",id);
                }
                function seagreen(id)
                {
                    colorchange("seagreen",id);
                }
                function darkred(id)
                {
                    colorchange("darkred",id);
                }
                function darkcyan(id)
                {
                    colorchange("darkcyan",id);
                }
                function peru(id)
                {
                    colorchange("peru",id);
                }
                function edit(id) {
                    var b = document.getElementById(id).parentNode.lastElementChild;
                    b.setAttribute("contenteditable", "true");
                    var k = document.getElementsByClassName('notebtns');
                    Array.from(k).forEach((e) => {
                        if (e.id == id) {
                            e.style.display = "none";
                        }
                        else {
                            e.style.display = "inline-block";
                        }
                    });
                    var savelemo = document.getElementsByClassName('savebtns');
                    Array.from(savelemo).forEach((elem) => {
                        if (elem.id == id) {
                            elem.style.display = "inline-block";
                        }
                        else {
                            elem.style.display = "none";
                            elem.parentNode.lastElementChild.setAttribute("contenteditable", "false");
                        }
                    });
                }
                function colorbtn(id)
                {
                    id=parseInt(id.match(/\d+/g), 10);
                    var b=document.getElementById('color'+id);
                    b.style.display="inline";
                }
                function hidecolor(id)
                {
                    id=parseInt(id.match(/\d+/g), 10);
                    var b=document.getElementById('color'+id);
                    b.style.display="none";
                }
                function closeError() {
                    $('#errormsg').css("display", "none");
                }
                //to show edit button on clicking on to the window page        
                $('body').click(function (evt) {
                    if (evt.target.id == "notes")
                        return;
                    //For descendants of menu_content being clicked, remove this check if you do not want to put constraint on descendants.
                    if ($(evt.target).closest('#notes').length)
                        return;

                    //Do processing of click event here for every element except with id menu_content
                    $('.savebtns').hide();
                    $('.notebtns').show();
                    // $('.mydiv').setAttribute("contenteditable","false");
                    var s = $('.mydiv');
                    Array.from(s).forEach((e) => {
                        e.setAttribute("contenteditable", "false");
                    });
                });

                function save(id) {
                    var division = document.getElementById(id).parentNode.lastElementChild;
                    // var division = document.getElementById(id).nextElementSibling.nextElementSibling.nextElementSibling;
                    var heading = division.getElementsByTagName('h3')[0].innerText;
                    var para = division.getElementsByTagName('p')[0].innerText;
                    var divid = division.id;
                    let action="update";
                    $.ajax({
                        type: "POST",
                        url: "_notesdb.php",
                        dataType: "text",
                        data: {
                            id: divid,
                            he: heading,
                            pa: para,
                            action: action,
                        },
                        success: function () {
                            $('#errormsg').show();
                            $('#msg').text("The note has been successfully updated");
                        }
                    });
                    var sbtn = document.getElementsByClassName('savebtns');
                    var ebtn = document.getElementsByClassName('notebtns');
                    Array.from(ebtn).forEach((e) => {
                        if (e.id == id) {
                            e.style.display = "inline-block";
                        }
                    });
                    Array.from(sbtn).forEach((e) => {
                        if (e.id == id) {
                            e.style.display = "none";
                        }
                    })

                }

                function ndelete(id) {
                    // var division = document.getElementById(id).nextElementSibling.nextElementSibling.nextElementSibling;
                    var division = document.getElementById(id).parentNode.lastElementChild;
                    var did = division.id;
                    let action="delete";
                    $.ajax({
                        type: "POST",
                        url: "_notesdb.php",
                        dataType: "text",
                        data: {
                            did: did,
                            action:action,
                        },
                        success: function () {
                            // id.closest("div").fadeOut();
                            location.reload();
                            $('#errormsg').show();
                            $('#msg').text("The note has been successfully deleted");
                        }
                    });
                }
   
   <?php } else {?>
                location.href="index.php";
<?php   }

   ?>

        </script>
</body>

</html>