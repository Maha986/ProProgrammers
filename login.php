<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/signup.css">
    <link rel="stylesheet" href="css/courses.css">
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="http://apis.google.com/js/platform.js" async defer></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <meta name="google-signin-client_id" content="967503607910-in2lq88i4pql4tjo7iovaqk2cu5vcfdq.apps.googleusercontent.com">
</head>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

<body>
    <!-- login modal -->
    <div id="login-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span id="login-close" class="close">&times;</span>
            </div>
            <div class="modal-body">
                <h2>Login to ProProgrammers</h2>
                <h4>Welcome to the world of programming</h4>
                <div id="login-msg"></div>
                <!-- <div id="googlebtn">
                    <div class="g-signin2" data-onsuccess="onSignIn" data-theme="dark" data-width="180" data-prompt="select-account"></div>
                </div>
                <div id="line">
                    <hr>
                    <div class="ordiv">
                        <p>OR</p>
                    </div>
                </div> -->
                <!-- login form -->
                <form id="login-form">
                    <label for="username_email"><b>Username or Email</b></label>
                    <input type="text" placeholder="Username or Email" name="username_email" id="username-or-email" value="<?php if (isset($_COOKIE['user'])) {
    echo $_COOKIE['user'];
} ?>" required>
                    <div id="username-email-error" class="error"></div>
                    <label for="login_password"><b>Password</b></label>
                    <div><input type="password" placeholder="Password" name="login_password" id="login-password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$" title="Must contain at least one number and one uppercase and lowercase letter, at least one special character and at least 8 or more characters" value="<?php if (isset($_COOKIE['pass'])) {
    echo $_COOKIE['pass'];
} ?>" required> <i class="far fa-eye" id="togglePassword" style="cursor: pointer;"></i></div>
                    <div id="loginpassword-error" class="error"></div>
                    <input type="checkbox" name="remember" id="rememberme" <?php if (isset($_COOKIE['user'])) { ?> checked <?php } ?> />

                    <label>Remember me</label>
                    <button type="submit" class="Find" id="btnlogin"><i class="fal fa-user-lock"></i> &nbsp;login</button>
                </form>
                <p><a href="#" onclick="showModal('forgot-modal', 'login-modal')">Forgot Password?</a></p>
                <p>Not registered yet ?<a href="#" onclick="showModal('signup-modal','login-modal')">signup</a></p>
            </div>
        </div>
    </div>



    <div id="forgot-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span id="forgot-modal-close" class="close">&times;</span>
            </div>
            <div class="modal-body">
                <h2>Change Password</h2>
                <h4>It's easy to forget things when you can recover them</h4>
                <div id="forgot-msg"></div>
                <div>

                    <div id="forgot-email">
                        <form id="formforemail" >

                            <label for="email"><b> Email</b></label>
                            <input type="email" placeholder="email" name="email" id="forgotemail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
                            <button type="submit" class="Find" id="submit-email-forgot"><i class="fas fa-user"></i> &nbsp;submit email</button>
                    </div>
                    </form>
                </div>
                <div id="forgot-code">
                    <form id="formforcode">


                        Enter otp code:
                        <input type="text" placeholder="code" id="otp-code-forgot" name="code">
                        <div class="error" id="forgotcode-error"></div>

                        <button type="submit" id="submit-code-forgot" class="Find"><i class="fas fa-user"></i> &nbsp;submit</button>
                        <button type="submit" id="resend-code-forgot" class="Find"><i class="fas fa-user"></i> &nbsp;resend</button>

                </div>
                </form>
                <div id="set-password" >
                <form id="formforpassword">

                  

                        <label for="forgot_password"><b>Password</b></label>

                        <div><input type="password" placeholder="Password" name="forgot_password" id="forgot_password" required> <i class="far fa-eye" id="toggleforgotPassword" style="cursor: pointer;"></i></div>
                        <div class="password-error error"></div>
                        <label for="confirm_password"><b>Confirm Password</b></label>
                        <div><input type="password" placeholder="Confirm Password" name="confirmforgot_password" id="confirmforgot_password" required></div>
                        <div class="password-error error"></div>



                        <button type="submit" class="Find" id="btnupdatePassword"><i class="fas fa-user"></i> &nbsp;Update Password</button>
                   

                </form>
                </div>

                <div id="backtologin">
                    <p><a href="#" onclick="showModal('login-modal','forgot-modal')"> Back to login</a></p>
                </div>

            </div>
        </div>
    </div>
    <div id="loginsuccess" class="modal" style="display: none; padding-top: 30px;background-color: transparent;
  background-color: rgba(0,0,0,0); ">

        <!-- Modal content -->
        <div class="modal-content" style="border-radius: 10px;background-color:lightgreen;color:forestgreen">
            <div>
                <span class="close" id="login-success-close" style="font-size:20px; color:forestgreen">&times;</span>
            </div>
            <div class="modal-body">
                <p style="text-align: center;"></p>
            </div>
        </div>

    </div>
    <script>
        <?php
        if ((!$loggedin)) {
            echo '$(window).scroll(function() {
               
        if($move==false &&  $closeButtonPressed == 0 && $loginopen==0){
            if (document.cookie.indexOf("modal_shown=") >= 0) {
                //do nothing if modal_shown cookie is present
            }
            else{
            setTimeout(function() {
                $move=true;
                document.cookie = "modal_shown=seen";
                openModal("signup-modal");
            }, 2000);
        }
        }
        })';
        }

        ?>
      
    setTimeout(function () {
        $('#googlebtn div div span span:last').text("Connect with google");
        $('#googlebtn div div span span:first').text("Connect with google");
        // $('#googlebtn div div span span:last').css("font-family", "Arial");//for font formatting
        // $('#googlebtn div div span span:first').css("font-family", "Arial");//for font formatting
    }, 1000);
   </script>
    <script src="js/signup.js"></script>
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>


</body>

</html>