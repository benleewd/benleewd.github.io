<?php

include "session.php";

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordConfirm = $_POST['cpassword'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $caloriesintake = $_POST['caloriesintake'];

    //Check if password and passwordConfirm matches, height is numeric, weight is numeric and age is numeric
    if (empty($name) || empty($email) || empty($password) || empty($passwordConfirm) || empty($height) || empty($weight) || empty($age) || empty($gender) || empty($caloriesintake)) {
        $_SESSION['signupName'] = $name;
        $_SESSION['signupEmail'] = $email;
        $_SESSION['signupHeight'] = $height;
        $_SESSION['signupWeight'] = $weight;
        $_SESSION['signupAge'] = $age;
        $_SESSION['signupGender'] = $gender;
        $_SESSION['signupCaloriesintake'] = $caloriesintake;
        $_SESSION['errors'] = array("All fields must be filled up!");
        header("Location: ../registration.php");
    } else if (!is_numeric($height) || !is_numeric($weight) || !is_numeric($age) || !is_numeric($caloriesintake)) {
        $_SESSION['signupName'] = $name;
        $_SESSION['signupEmail'] = $email;
        $_SESSION['signupHeight'] = $height;
        $_SESSION['signupWeight'] = $weight;
        $_SESSION['signupAge'] = $age;
        $_SESSION['signupGender'] = $gender;
        $_SESSION['signupCaloriesintake'] = $caloriesintake;
        $_SESSION['errors'] = array("Height, weight, age and calories intake must be a number!");
        header("Location: ../registration.php");
    } else if ($password != $passwordConfirm) {
        $_SESSION['signupName'] = $name;
        $_SESSION['signupEmail'] = $email;
        $_SESSION['signupHeight'] = $height;
        $_SESSION['signupWeight'] = $weight;
        $_SESSION['signupAge'] = $age;
        $_SESSION['signupGender'] = $gender;
        $_SESSION['signupCaloriesintake'] = $caloriesintake;
        $_SESSION['errors'] = array("Password do not match!");
        header("Location: ../registration.php");
    } else {
        $user = new User($name, $email, password_hash($password, PASSWORD_DEFAULT), (int) $height, (int) $weight, (int) $age, $gender, (int) $caloriesintake, (int) $caloriesintake);
        //Check if email exists in DB
        $dao = new UserDAO;
        $status = $dao->add($user);

        $_SESSION['status'] = $status;
        if ($status != "Success") {
            if (strpos(strtolower($status), "duplicate")) {
                $_SESSION['errors'] = array("Email is used. Please try another email.");
            } else {
                $_SESSION['errors'] = array("An error occured. Please try again later.");
            }
            header("Location: ../registration.php");
        } else {
            $_SESSION['user'] = $email;
            header("Location: ../index.php");
        }
    }
} else {
    header('Location: ../registration.php');
}

?>