<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProProgrammers| Certificate</title>
    <style>
        #certificate-avail
        {
            width:55%;
            margin:50px auto;
        }
        #mainheading
        {
            font-size: 1.8rem;
            text-align: center;
        }
        #innerdiv
        {
            margin: 40px 0px;
            font-size: 1.3rem;
            line-height: 35px;
            word-spacing: 2px;
        }
        #innerdiv h3
        {
            text-decoration: underline;
            margin: 20px 0px;
        }
        #demonstration,#availing-certificate
        {
            width: 45%;
            margin:auto;
            padding: 7px 0px 1px 0px;
            
            box-shadow: grey -3px 7px 11px -1px;
        }
        #demonstration p,#availing-certificate p
        {
            margin: 8px;
        }
        #demonstration button,#availing-certificate button {
            font-size: 16px;
            background: #1eb2a6;
            color: whitesmoke;
            border-radius: 11px;
            border: none;
            padding: 8px 6px;
            margin: 38px auto 9px;
            display: block;
            width: 85%;
            text-transform: uppercase;
            word-spacing: 5px;
            letter-spacing: -1px;
        }
        #availing-certificate
        {
            margin: 50px auto;
            display: none;
        }
        #availing-certificate button
        {
            cursor: pointer;
            
        }
        #availing-certificate button:active
        {
            transform: scale(1.01);
            background-color: teal;
        }
        #demonstration i,#availing-certificate i
        {
            margin: 0px 9px;

        }
        @media screen and (max-width:750px) {
            #demonstration,#availing-certificate
            {
                width:100%;
            }
        }
    </style>
</head>
<body>
    <?php
        include "nav.php"; 
        include "signup.php"; 
        include "login.php"; 
        require "_dbconnect.php";

    ?>
    <section id="certificate-avail">
        <p id="mainheading">Congratulations on Completing the Course!</p>
        <div id="innerdiv">
            <h3>How to Get Your Certificate</h3>
            <p>Once <u>all Quizzes and the assignment</u> are completed, <strong><u>assignment has received 5 rating</u></strong>, you will automatically see the button at the <u style="color: red;">bottom corner</u> of this page. <span style="color: teal;">It will look like this:</span></p>
        </div>

        <div id="demonstration">
            <div style="height: 6px; background-color: #1eb2a6;"></div>
            <p><b>100%</b> complete</p>
            <button disabled><i class="fas fa-file-certificate"></i>Get Your Certificate</button>
        </div>

        <div id="availing-certificate">
            <h2 style="text-align: center; margin-bottom: 8px;"></h2>
            <div style="height: 6px; background-color: #1eb2a6;"></div>
            <p><b>100%</b> complete</p>

            <button onclick="getcertificate()"><i class="fas fa-file-certificate"></i>Get Your Certificate</button>
            
        </div>

        <p id="msg" style="color:red; margin:12px;"></p>
    </section>


    <?php
    include "footer.php";
    ?>

    <script>
        $(document).ready(function()
        {
            const urlSearchParams = new URLSearchParams(window.location.search);
            const params = Object.fromEntries(urlSearchParams.entries());
            let courseid = params['id'];
            action="certificatebtn";
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
                    
                    if(data==4)
                    {
                        $('#msg').text("please add the comment in assignment review section with your assignment link");
                    }
                    else if(data!=2 && data!=3 && data!=5)
                    {
                        $('#availing-certificate').show();
                        $('#availing-certificate h2').append(data);
                    }
                }
            })
        })

        function getcertificate()
        {
            const urlSearchParams = new URLSearchParams(window.location.search);
            const params = Object.fromEntries(urlSearchParams.entries());
            let courseid = params['id'];
           location.href="certificate.php?id="+courseid;
        }
        
    </script>
</body>
</html>