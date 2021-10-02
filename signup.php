<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup to ProProgrammers</title>
    <link rel="stylesheet" href="css/signup.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <script src="js/jquery-3.6.0.min.js"></script>
    <a href="https://icons8.com/icon/KnQ23R20ge4i/dots-loading"></a>
</head>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

<body>
    <div id="signup-modal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <span id="signup-close" class="close">&times;</span>
            </div>
            <div class="modal-body">
                <h2>Signup to ProProgrammers</h2>
                <h4>Increase your pace towards the algorithm of success</h4>
                <div id="signup-msg"></div> <!-- div to dispaly  messsges-->
                <div id="verification_code"> <!-- form for entering otp code-->
                    <form id="code-form">
                        <input type="text" placeholder="code" name="code" id="otp-code" required>
                        <div class="error" id="code-error"></div>
                        <button type="submit" id="submit-code" class="Find"><i class="fas fa-check-square"></i> &nbsp;submit</button>
                        <button type="submit" id="resend-code" class="Find"><i class="fas fa-share-square"></i> &nbsp;resend</button>
                    </form>
                </div>
                <div>
                    <!-- Signup form -->
                    <form method="POST" id="signup-form">
                        <label for="fullname"><b>Full Name</b></label>
                        <input type="text" placeholder="Fullname" name="fullname" id="fullname" required>
                        <label for="email"><b>Email</b></label>
                        <input type="email" placeholder="Email" name="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
                        <div id="email-error" class="error"></div>
                        <label for="username"><b>Username</b></label>
                        <input type="text" placeholder="Username" name="username" id="username" required>
                        <div id="username-error" class="error"></div>
                        <label for="password"><b>Password</b></label>
                        <input type="password" placeholder="Password" name="password" id="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$" title="Must contain at least one number and one uppercase and lowercase letter, at least one special character and at least 8 or more characters" required>
                        <div class="password-error error"></div>
                        <label for="confirmpassword"><b>Confirm Password</b></label>
                        <input type="password" placeholder="Confirm Password" name="confirmpassword" id="confirmpassword" required>
                        <div class="password-error error"></div>
                        <input type="checkbox" id="show-password" onclick="showPassword()"> &nbsp;Show Password
                        <button type="submit" class="Find"><i class="fal fa-lock-alt"></i> &nbsp; Signup</button>
                    </form>
                    <p>Already registered? <a href="#" onclick="showModal('login-modal','signup-modal')">login</a></p>
                </div>
            </div>
        </div>
    </div>
    <div id="signupsuccess" class="modal" style="display: none; padding-top: 30px;background-color: transparent;
  background-color: rgba(0,0,0,0); ">

        <!-- Modal content -->
        <div class="modal-content" style="border-radius: 10px;background-color:lightgreen;color:forestgreen">
            <div>
                <span id="success-close" class="close" style="font-size:20px; color:forestgreen">&times;</span>
            </div>
            <div class="modal-body">
                <p style="text-align: center;"></p>
            </div>
        </div>

    </div>

    <!-- div to show success message -->
    <!-- <div id="signupsuccess" class="modal">
        <div class="modal-content">
            <div>
                <span id="success-close" class="close">&times;</span>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
        </div>

    </div> -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

</body>

</html>