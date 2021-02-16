<?php
include "process/session.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Colorlib Templates">
    <meta name="author" content="Colorlib">
    <meta name="keywords" content="Colorlib Templates">

    <!-- Title Page-->
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
    <title>Registration</title>

    <!-- Icons font CSS-->
    <link href="style/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="style/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
    <!-- Vendor CSS-->
    <link href="style/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="style/datepicker/daterangepicker.css" rel="stylesheet" media="all">
    <!-- Main CSS-->
    <link href="style/registration/main.css" rel="stylesheet" media="all">

    <style>
        body {
            background-color: whitesmoke;
        }

        #dropdown {
            border: 0px solid black;
            color: grey;
            font-size: 18px;
            padding-top:6%;
        }
    </style>
</head>

<body>
    <div class="page-wrapper p-b-90 font-robo" style="padding-top: 3%;">
        <div class="wrapper wrapper--w960">
            <div class="card card-2">
                <div class="card-heading" style="background-image: url(img/healthyfood.jpg)"></div>
                <div class="card-body">
                    <h2 class="title">Registration</h2>
                    <form method="POST" action="process/process_signup.php">

                        <div class="input-group">
                            <input class="input--style-2" type="text" placeholder="Email (For future login purpose)" name="email"
                            <?php
                            if (isset($_SESSION['signupEmail'])) {
                                $signupEmail = $_SESSION['signupEmail'];
                                echo "value=$signupEmail";
                            };
                            ?>
                            >
                            
                        </div>
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <input class="input--style-2" type="text" placeholder="Name" name="name"
                                        <?php
                                        if (isset($_SESSION['signupName'])) {
                                            $signupName = $_SESSION['signupName'];
                                            echo "value=$signupName";
                                        };
                                        ?>
                                    >
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <input class="input--style-2" type="text" placeholder="Daily Calories Intake" name="caloriesintake"
                                        <?php
                                        if (isset($_SESSION['signupCaloriesintake'])) {
                                            $signupHeight = $_SESSION['signupCaloriesintake'];
                                            echo "value=$signupCaloriesintake";
                                        };
                                        ?>
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <input class="input--style-2" type="password" placeholder="Password" name="password">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <input class="input--style-2" type="password" placeholder="Confirm Password" name="cpassword">
                                </div>
                            </div>
                        </div>
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <input class="input--style-2" type="text" placeholder="Height (in cm)" name="height"
                                    <?php
                                    if (isset($_SESSION['signupHeight'])) {
                                        $signupHeight = $_SESSION['signupHeight'];
                                        echo "value=$signupHeight";
                                    };
                                    ?>
                                    >
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <input class="input--style-2" type="text" placeholder="Weight (in kg)" name="weight"
                                    <?php
                                    if (isset($_SESSION['signupWeight'])) {
                                        $signupWeight = $_SESSION['signupWeight'];
                                        echo "value=$signupWeight";
                                    };
                                    ?>
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <input class="input--style-2" type="text" placeholder="Age" name="age"
                                    <?php
                                    if (isset($_SESSION['signupAge'])) {
                                        $signupAge = $_SESSION['signupAge'];
                                        echo "value=$signupAge";
                                    };
                                    ?>
                                    >
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <!-- <input class="input--style-2" type="text" placeholder="Gender" name="gender"> -->
                                    <select name='gender' id='dropdown'>
                                        <option disabled selected value> -- Enter your gender -- </option>
                                        <option value='male'>Male</option>
                                        <option value='female'>Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="p-t-30">
                            <button class="btn btn--radius btn--green" type="submit" name="submit">Register</button>
                        </div>
                    </form>
                    <div class="text-center" style="color:red;">
                    <?php
                    if (isset($_SESSION['errors'])) {
                        printErrors();
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery JS-->
    <script src="style/jquery/jquery.min.js"></script>
    <!-- Vendor JS-->
    <script src="style/select2/select2.min.js"></script>
    <script src="style/datepicker/moment.min.js"></script>
    <script src="style/datepicker/daterangepicker.js"></script>

    <!-- Main JS-->
    <script src="script/registration"></script>

</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>