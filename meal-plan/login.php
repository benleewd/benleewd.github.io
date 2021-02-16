<?php
include "process/session.php";
// include "process/authenticate.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" type="text/css" href="style/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
    <link rel="stylesheet" type="text/css" href="style/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="style/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" type="text/css" href="style/animsition/css/animsition.min.css">
    <link rel="stylesheet" type="text/css" href="style/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="style/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" type="text/css" href="style/login/util.css">
    <link rel="stylesheet" type="text/css" href="style/login/main.css">

    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
    <title>Login</title>

</head>

<body>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-form-title" style="background-image: url(img/healthyfood.jpg);">
                    <span class="login100-form-title-1">
                        Sign In
                    </span>
                </div>

                <form class="login100-form validate-form" action="process/process_login.php" method="POST">
                    <div class="wrap-input100 validate-input m-b-26" data-validate="Email is required">
                        <span class="label-input100">Email</span>
                        <input class="input100" type="email" name="email" placeholder="Enter email">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="wrap-input100 validate-input m-b-18" data-validate="Password is required">
                        <span class="label-input100">Password</span>
                        <input class="input100" type="password" name="password" placeholder="Enter password">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="flex-sb-m w-full p-b-30">
                        <div class="contact100-form-checkbox">
                            <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
                            <label class="label-checkbox100" for="ckb1">
                                Remember me
                            </label>
                        </div>

                        <div>
                            <a href="#" class="txt1">
                                Forgot Password?
                            </a>
                        </div>
                    </div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn" name="submit">
                            Login
                        </button>
                    </div>

                    <div class="flex-sb-m w-full p-b-30">
                        <div>
                            <a href="registration.php" class="txt1">
                                New User?
                            </a>
                        </div>
                    </div>
                    <div class="text-center" style="color:red;">
                    <?php
                    if (isset($_SESSION['errors'])) {
                        printErrors();
                    }
                    ?>
                </div>
                </form>

                


            </div>
        </div>
    </div>

    <script src="style/jquery/jquery-3.2.1.min.js"></script>
    <script src="style/animsition/js/animsition.min.js"></script>
    <script src="style/bootstrap/js/popper.js"></script>
    <script src="style/bootstrap/js/bootstrap.min.js"></script>
    <script src="style/select2/select2.min.js"></script>
    <script src="style/daterangepicker/moment.min.js"></script>
    <script src="style/daterangepicker/daterangepicker.js"></script>
    <script src="style/countdowntime/countdowntime.js"></script>
    <script src="script/login.js"></script>
</body>

</html>