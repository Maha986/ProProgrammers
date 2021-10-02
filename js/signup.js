$(document).ready(function () {

   
    $("#username").on("input", function () {
        $("#username-error").css("display", "none");

    });
    $("#otp-code-forgot").on("input", function () {
        $("#forgotcode-error").css("display", "none");

    });

    $("#otp-code").on("input", function () {
        $("#code-error").css("display", "none");
    });
    $("#email").on("input", function () {
        $("#email-error").css("display", "none");

    });
    $("#password,#confirmpassword,#forgot_password,#confirmforgot_password ").on("input", function () {
        $(".password-error").css("display", "none");

    });
    $("#forgotcode-error").on("input", function () {
        $("#otp-code-forgot").css("display", "none");

    });

})
$("#verification_code").hide();
$("#signup-form").on("submit", function (e) {
    $("#signup-msg").css("display", "block");
    $('#signup-msg').html('<span>Please wait</span> <img src="HomeImages/s.gif"/ style="height:30px;">');
    var fullName = $.trim($("#fullname").val());
    var emailId = $.trim($("#email").val());
    var userName = $.trim($("#username").val());
    var password = $.trim($("#password").val());
    var confirmPassword = $.trim($("#confirmpassword").val());
    var action = "signup";
    $.ajax({
        url: "dbcon.php",
        type: "POST",
        data: {
            fullName: fullName,
            emailId: emailId,
            userName: userName,
            password: password,
            confirmPassword: confirmPassword,
            action: action,

        },
        success: function (data) {
            if (data == 0) {
                $("#signup-msg").css("display", "none");
                $("#username-error").css("display", "block");
             
                $('#username-error').html('<i class="fas fa-times"></i><span> &nbsp  Username already Exists. Choose a different username</span>');

            }
            else if (data == 1) {
                $("#signup-msg").css("display", "none");
                $("#email-error").css("display", "block");
                $('#email-error').html('<i class="fas fa-times"></i><span> &nbsp  Email already exixst. Choose a different Email.</span>');
            }
            else if (data == 3) {
                $("#signup-msg").css("display", "block");
                $('#signup-msg').html('<i class="fas fa-check-circle"></i><span> &nbsp  We have sent a verification code to ' + emailId + ' Please, verify your account...If you have not received the email. Click on resend code</span>');
                $("#verification_code").show();
            }
            else if (data == 4) {
                $("#signup-msg").css("display", "block");
                $('#signup-msg').html('<i class="fas fa-times"></i><span> &nbsp  Email sending failed... Check your Internet Connection</span>');
            }
            else if (data == 5) {
                console.log(data);
                // $("#signup-msg").css("display", "block");
                // $('#signup-msg').html('<i class="fas fa-times"></i><span> &nbsp Failed to Register. Try again</span>');

            }
            else if (data == 6) {
                $("#signup-msg").css("display", "none");
                $('.password-error').css("display", "block");
                $('.password-error').html('<i class="fas fa-times"></i><span> &nbsp  Password and confirm password are not matched</span>');
            }
            else {
                console.log(data);
             
                // $("#signup-msg").css("display", "block");
                // $('#signup-msg').html('<i class="fas fa-times"></i><span> &nbsp Failed to Register. Try again</span>');

            }
        }
    })
    e.preventDefault();
})

$("#code-form").on("submit", function (e) {
    e.preventDefault();
    var otpVerificationCode = $.trim($("#otp-code").val());
    var action = "submitcode";
    $.ajax({
        url: "dbcon.php",
        type: "POST",
        data: {
            otpVerificationCode: otpVerificationCode,
            action: action,
        },
        success: function (data) {

            if (data == 0) {

                $("#signup-form").trigger("reset");
                $('#signup-msg').text(" ");
                $('#signup-msg').hide();
                $('#signupsuccess p').text("Congratulations!!. You are successfully registered to Proprogrammers. Now you can login.");
                showModal("signupsuccess", "signup-modal")
               
                // $('#signup-msg').html('<i class="fas fa-check-circle"></i><span> &nbsp Congratutions! You are registered. Now you can login</span>');
                $("#verification_code").hide();
            } else if (data == 1) {
                $('#signup-msg').html('<i class="fas fa-times"></i><span> &nbsp Fail to verify your account</span>');
            }
            else {
                $('#code-error').css("display", "block");
                $('#code-error').html('<i class="fas fa-times"></i><span> &nbsp  Wrong code. Submit again</span>');
            }
        }
    })
})

$("#resend-code").on("click", function (e) {
    e.preventDefault();
    $("#verification_code").hide();
    $('#code-error').text(" ")
    $('#code-error').hide();
    $("#code-form").trigger("reset");
    $('#signup-msg').html('<span>Please wait, We are resending you another otp code.</span> <img src="HomeImages/s.gif"/ style="height:30px;">');
    var emailIdForResendingCode = $.trim($("#email").val());
    var usernameForResendingCode = $.trim($("#username").val());
    var action = "resendotpcode";
    $.ajax({
        url: "dbcon.php",
        type: "POST",
        data: {
            emailIdForResendingCode: emailIdForResendingCode,
            usernameForResendingCode: usernameForResendingCode,
            action: action
        },
        success: function (data) {
            if (data == 3) {
                $('#signup-msg').html('<i class="far fa-user-unlock"></i><span> &nbsp  We have sent a verification code to ' + emailIdForResendingCode + ' Please, verify your account...If you have not received the email. Click on resesnd code</span>');
                $("#verification_code").show();
            } else if (data == 4) {
                $('#signup-msg').html('<i class="fas fa-times"></i><span> &nbsp  Email sending failed... Check your Internet Connection..</span>');
            }
            else {
                $('#signup-msg').html('<i class="fas fa-times"></i><span> &nbsp Try again</span>');
            }
        }
    })
})





function onSignIn(user) {
  
    var userdata = user.getBasicProfile();
    console.log(userdata)
    action = "signingoogle";
    $.ajax({
        url: "dbcon.php",
        type: "POST",
        data: {
            getUserGoogleEmail: userdata.getEmail(),
            getUserGoogleName: userdata.getName(),
            getUserGooglePicture: userdata.getImageUrl(),
            action: action,
        },
        success: function (data) {
            if (data == 0) {
                $("#login-form").trigger("reset");

                location.reload("index.php");





            } else if (data == 1) {
                $("#login-msg").css("display", "block");
                $('#login-msg').html('<i class="fas fa-times"></i><span>  &nbsp  Your account was not verified.Signup again</span>');

            }
            else if (data == 2) {
                $("#login-msg").css("display", "block");
                $('#login-msg').html('<i class="fas fa-times"></i><span>  &nbsp Try again</span>');

            }
            else {
                $("#login-msg").css("display", "block");
                $('#login-msg').html('<i class="fas fa-times"></i><span>  &nbsp Signup first</span>');

            }

        }
    })
}


$("#login-form").on("submit", function (e) {
    e.preventDefault();
    var usernameOrEmail = $.trim($("#username-or-email").val());
    var loginPassword = $.trim($("#login-password").val());
    var check;
    if (document.getElementById('rememberme').checked) {
        check = 1;
    } else {
        check = 0;

    }
    var action = "login";
    $.ajax({
        url: "dbcon.php",
        type: "POST",

        data: {
            usernameOrEmail: usernameOrEmail,
            loginPassword: loginPassword,
            action: action,
            check: check,


        },
        success: function (data) {

            if (data == 0) {
                // $("#login-form").trigger("reset");
                $("#login-msg").css("display", "block");
                $('#login-msg').html('<i class="fas fa-check-circle""></i><span>  &nbsp You are successfully loggedin</span>');
                location.reload("index.php");

            } else if (data == 1) {
                $("#login-form").trigger("reset");
                $("#login-msg").css("display", "block");
                $('#login-msg').html('<i class="fas fa-times"></i><span>  &nbsp Your account was not verified.Signup again</span>');

            }
            else if (data == 2) {
                $("#login-msg").css("display", "block");
                $('#login-msg').html('<i class="fas fa-times"></i><span>  &nbsp Try again</span>');

            }
            else if (data == 3) {

                $('#loginpassword-error').css("display", "block");
                $('#loginpassword-error').html('<i class="fas fa-times"></i><span> &nbsp  Invalid Password</span>');


            }
            else if (data == 4) {

                $('#login-msg').css("display", "block");
                $('#login-msg').html('<i class="fas fa-times"></i><span> &nbsp Email not registered. Signup first</span>');

            }
            else if (data == 5) {
                $('#username-email-error').css("display", "block");
                $('#username-email-error').html('<i class="fas fa-times"></i><span> &nbsp  Invalid Username</span>');

            }
            // else if (data == 7) {

            //     location.reload("courses.php");
            // }
            else if (data == 8) {
                location.reload("index.php");
            }

            else {
                console.log(data);
                // $("#login-msg").css("display", "block");
                // $('#login-msg').html('<i class="fas fa-times"></i><span> &nbsp  Try again</span>');
               

            }
        }
    })
})


$("#resend-code-forgot").on("click", function (e) {
    e.preventDefault();
    $("#forgot-msg").css("display", "block");
    $('#forgot-msg').html('<span>Please wait</span> <img src="HomeImages/s.gif"/ style="height:30px;">');

    $("#formforcode").hide();
    $('#forgotcode-error').text(" ")
    $('#forgotcode-error').hide();
    $("#otp-code-forgot").trigger("reset");
    $('#forgot-msg').html('<span>Please wait, We are resending you  otp code.</span> <img src="HomeImages/s.gif"/ style="height:30px;">');


    var forgotEmail = $.trim($("#forgotemail").val());
    var action = "forgotemailsubmit";


    $.ajax({
        url: "dbcon.php",
        type: "POST",
        data: {
            forgotEmail: forgotEmail,
            // usernameForResendingCode: usernameForResendingCode,
            action: action,
        },
        success: function (data) {

            if (data == 0) {
                $('#forgot-msg').html('<i class="fas fa-times"></i><span> &nbsp  You are not registered. Signup first</span>');




            } else if (data == 3) {
                $('#forgot-msg').css("display", "block");
                $('#forgot-msg').html('<i class="fas fa-check-circle"></i><span> &nbsp  We have sent a verification code to ' + forgotEmail + ' Please, verify your account...If you have not received the email. Click on resesnd Code</span>');

                $('#formforcode').css("display", "block");
            } else if (data == 4) {
                $('#forgot-msg').html('<i class="fas fa-times"></i><span> &nbsp Email sending failed. Check your internet connection.</span>');

            }

        }

    })
})

$("#formforpassword").on("submit", function (e) {
    e.preventDefault();
    var forgotpassword = $("#forgot_password").val();
    var forgotConfirmPassword = $("#confirmforgot_password").val();
    var forgotEmail = $("#forgotemail").val();
    action = "updatepassword";
    $.ajax({
        url: "dbcon.php",
        type: "POST",

        data: {
            forgotpassword: forgotpassword,
            forgotConfirmPassword: forgotConfirmPassword,
            forgotEmail: forgotEmail,
            action: action,
        },
        success: function (data) {
            if (data == 0) {
                $('#signupsuccess p').text("Password updated successfully");
                openModal("signupsuccess")
                $('#forgot-msg').text(" ");
                $('#forgot-modal').hide();

                

            } else if (data == 1) {
                $('#forgot-msg').text("failed to upadte password");
            } else if (data == 2) {
                $('#forgot-msg').text("passwords not match");
            } else {
                $('#forgot-msg').text("data");
            }
        }


    })
})

$("#formforemail").on("submit", function (e) {
    $("#forgot-msg").css("display", "block");
    $('#forgot-msg').html('<span>Please wait</span> <img src="HomeImages/s.gif"/ style="height:30px;">');
    e.preventDefault();

    var forgotEmail = $.trim($("#forgotemail").val());
    var action = "forgotemailsubmit";
    $.ajax({
        url: "dbcon.php",
        type: "POST",

        data: {
            forgotEmail: forgotEmail,

            action: action,
        },
        success: function (data) {

            if (data == 0) {

                $('#forgot-msg').html('<i class="fas fa-times"></i><span> &nbsp  You are not registered. Signup first</span>');




            } else if (data == 3) {
                // $('#forgot-msg').css("display", "block");
                $('#forgot-msg').html('<i class="fas fa-check-circle"></i><span> &nbsp  We have sent a verification code to ' + forgotEmail + ' Please, verify your account...If you have not received the email. Click on resesnd Code</span>');
                $('#submit-email-forgot').css("display", "none");
                $('#forgot-code').css("display", "block");
            } else if (data == 4) {
                $('#forgot-msg').html('<i class="fas fa-times"></i><span> &nbsp Email sending failed. Check your internet connection.</span>');

            }

        }

    })
})
$("#formforcode").on("submit", function (e) {
    e.preventDefault();
    var forgotcode = $("#otp-code-forgot").val();
    var forgotEmail = $("#forgotemail").val();
    var action = "forgotcodesubmit";
    $.ajax({
        url: "dbcon.php",
        type: "POST",

        data: {
            forgotcode: forgotcode,
            forgotEmail: forgotEmail,
            action: action,
        },
        success: function (data) {
            if (data == 0) {
                $('#forgot-email').css("display", "none");
                $('#forgot-code').css("display", "none");

                $('#forgot-msg').text("set password and confirm password");
                $('#set-password').css("display", "block");

            } else if (data == 1) {
                $('#forgotcode-error').css("display", "block");
                $('#forgotcode-error').html('<i class="fas fa-times"></i><span> wrong code</span>');

            } else {
                $('#forgot-msg').text("Try again");
            }


        }
    })
})






$closeButtonPressed = 0;
$loginopen = 0;
$move = false;

function openModal(getModal) {
    var modalToOpen = document.getElementById(getModal);
    // Get the button that opens the modal
    // var btn = document.getElementById(y);
    // Get the <span> element that closes the modal
    if (modalToOpen.id == "signup-modal") {

        modalToOpen.style.display = "block";
        var closeButton = document.getElementById("signup-close");
        $closeButtonPressed = 1;
        $("#verification_code").hide();
    }


    else if (modalToOpen.id == "login-modal") {
        $("#login-msg").text(" ");
        $("#login-msg").hide();
        modalToOpen.style.display = "block";
        $loginopen = 1
        var closeButton = document.getElementById("login-close");
        $closeButtonPressed = 2;
    }
    else if (modalToOpen.id == "signupsuccess") {

        modalToOpen.style.display = "block";
        var closeButton = document.getElementById('success-close');
    }else if (modalToOpen.id == "loginsuccess") {

        modalToOpen.style.display = "block";
        var closeButton = document.getElementById('login-success-close')



    }else if (modalToOpen.id == "loginsuccess") {

        modalToOpen.style.display = "block";
        var closeButton = document.getElementById('login-success-close')



    }
    else if (modalToOpen.id == "forgot-modal") {

        modalToOpen.style.display = "block";
        var closeButton = document.getElementById('forgot-modal-close')



    }
    else {

        var closeButton = document.getElementsByClassName("close")[3];
        modalToOpen.style.display = "block";
    }

    // When the user clicks the button, open the modal 

    // When the user clicks on <span> (x), close the modal
    closeButton.onclick = function () {
        //    document.getElementById(getModal).getElementsByTagName("input").val("")
        //    modalToOpen.querySelector("form input").val("")

     if(modalToOpen.id == "signup-modal" || modalToOpen.id == "forgot-modal"){
         clearfield(modalToOpen);
     }


        modalToOpen.style.display = "none";
    }
    // When the user clicks anywhere outside of the modal, close it
    // window.onclick = function (event) {
    //     if (event.target == modalToOpen) {
    //         modalToOpen.style.display = "none";
    //     }
    // }
}

function clearfield(x){

    var elements = x.getElementsByTagName("input")
    for (var i = 0; i < elements.length; i++) {
        elements[i].value = "";

        //Do something here
    }

}


function showModal(modalTOShow, modalToClose) {
    // document.getElementById(modalToClose).trigger("reset");
    // $("#signup-msg").text(" ");
    // $("#signup-msg").css("display","none");
    document.getElementById(modalToClose).style.display = "none"; //login
    openModal(modalTOShow);
}

function showPassword() {

    var x = document.getElementById("password");
    var y = document.getElementById("confirmpassword");
    if (x.type === "password" || y.type === "password") {
        x.type = "text";
        y.type = "text";
    } else {
        x.type = "password";
        y.type = "password";
    }
}



const togglePassword = document.querySelector('#togglePassword',);
const password = document.querySelector('#login-password');
togglePassword.addEventListener('click', function (e) {
    // toggle the type attribute
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    // toggle the eye / eye slash icon
    this.classList.toggle('bi-eye');
});
const toggleforgotPassword = document.querySelector('#toggleforgotPassword');
const forgotpassword = document.querySelector('#forgot_password');
const confirmpassword = document.querySelector('#confirmforgot_password');
toggleforgotPassword.addEventListener('click', function (e) {
    // toggle the type attribute
    const type = forgotpassword.getAttribute('type') === 'password' ? 'text' : 'password';
    forgotpassword.setAttribute('type', type);
    const type1 = confirmpassword.getAttribute('type') === 'password' ? 'text' : 'password';
    confirmpassword.setAttribute('type', type);
    // toggle the eye / eye slash icon
    this.classList.toggle('bi-eye');
});

