<?php

session_start();
require_once '../config/db.php';

if(isset($_SESSION['admin_id']) || isset($_SESSION['user_id'])){
    header("location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Login-Register</title>
    <link rel="icon" href="../public/img/logo.png " type="image/gif">
    <link rel="stylesheet" href="../public/css/login.css">
</head>

<body>

    <div class="img-back">
        <a href="../index.php"><img src="../public/img/angle-left.png " alt=""></a>
    </div>

    <section class="user">
        <div class="user_options-container">
            <div class="user_options-text">
                <div class="user_options-unregistered">
                    <h2 class="user_unregistered-title">Don't have an account?</h2>
                    <p class="user_unregistered-text">You can apply to be our m ember by just pressing the Sign up
                        button and
                        filling out the information.</p>
                    <button class="user_unregistered-signup" id="signup-button">Sign up</button>
                </div>

                <div class="user_options-registered">
                    <h2 class="user_registered-title">Have an account?</h2>
                    <p class="user_registered-text">Already registered? You can log in by pressing the Login button and
                        filling in
                        your information.</p>
                    <button class="user_registered-login" id="login-button">Login</button>
                </div>
            </div>

            <form action="signin_db.php" id="signinform" method="post">
                <div class="user_options-forms" id="user_options-forms">
                    <div class="user_forms-login">
                        <h2 class="forms_title">Login</h2>
                        <form class="forms_form">
                            <fieldset class="forms_fieldset">
                                <div class="forms_field">
                                    <input type="text" name="username" placeholder="Username" class="forms_field-input" />
                                </div>
                                <div class="forms_field">
                                    <input type="password" name="password" placeholder="Password" class="forms_field-input" />
                                </div>
                            </fieldset>
                            <div class="forms_buttons">
                                <input type="submit" value="Log In" name="login" class="forms_buttons-action">
                            </div>
                        </form>
                    </div>
            </form>

            <form action="signup_db.php" id="signupform" method="post">
                <div class="user_forms-signup">
                    <h2 class="forms_title">Sign Up</h2>
                    <form class="forms_form">
                        <fieldset class="forms_fieldset">

                            <div class="forms_field">
                                <input type="text" name="firstname" aria-describedby="firstname" placeholder="FirstName" class="forms_field-input" />
                            </div>
                            <div class="forms_field">
                                <input type="text" name="lastname" aria-describedby="lastname" placeholder="LastName" class="forms_field-input" />
                            </div>
                            <div class="forms_field">
                                <input type="email" name="email" aria-describedby="email" placeholder="E-mail" class="forms_field-input" />
                            </div>
                            <div class="forms_field">
                                <input type="text" name="username" aria-describedby="username" placeholder="Username" class="forms_field-input" />
                            </div>
                            <div class="forms_field">
                                <input type="password" name="password" placeholder="Password" class="forms_field-input" />
                            </div>
                            <div class="forms_field">
                                <input type="password" name="c_password" placeholder="Confirm Password" class="forms_field-input" />
                            </div>
                        </fieldset>
                        <div class="forms_buttons">
                            <input type="submit" name="signup" value="Sign up" class="forms_buttons-action">
                        </div>
                    </form>
                </div>
            </form>
        </div>
        </div>
    </section>

    <script src="../public/js/login.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $("#signupform").submit(function(e) {
                e.preventDefault();

                let formUrl = $(this).attr("action");
                let reqMethod = $(this).attr("method");
                let formData = $(this).serialize();

                $.ajax({
                    url: formUrl,
                    type: reqMethod,
                    data: formData,
                    success: function(data) {
                        let result = JSON.parse(data);
                        if (result.status == "success") {
                            Swal.fire("Success!", result.msg, result.status).then(function() {
                                window.location.reload();
                            });
                        } else {
                            console.log(result);
                            Swal.fire("Error!", result.msg, result.status);
                        }
                    }
                })
            })
        })

        $(document).ready(function() {
            $("#signinform").submit(function(e) {
                e.preventDefault();

                let formUrl = $(this).attr("action");
                let reqMethod = $(this).attr("method");
                let formData = $(this).serialize();

                $.ajax({
                    url: formUrl,
                    type: reqMethod,
                    data: formData,
                    success: function(data) {
                        let result = JSON.parse(data);

                        if (result.status == "success") {
                            console.log(result);
                            Swal.fire("Success!", result.msg, result.status).then(function() {
                                window.location.href = "../index.php";
                            });
                        } else {
                            Swal.fire("Error!", result.msg, result.status);
                        }
                    }
                })
            })
        })
    </script>
</body>

</html>