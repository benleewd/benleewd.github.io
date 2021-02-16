<?php
include "session.php";

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $KeepLogIn = False;
    if (isset($_POST['remember-me'])) {
        $KeepLogIn = True;
    } 

    $dao = new UserDAO;
    $match = $dao->retrieve($email);

    if (is_string($match)) {
        $_SESSION['errors'] = array("Connection failed!");
        header('Location: ../login.php');
    } else if ($match != null && password_verify($password, $match->password)) {
        //Setting cookie for keep log in
        if ($KeepLogIn) {
            setcookie("user", $email, 60*60*24);
        } else {
            $_SESSION['user'] = $email;
            // $_SESSION['KeepLogIn'] = $KeepLogIn;
        }
        
        header('Location: ../index.php');
    } else {
        $_SESSION['errors'] = array("Incorrect username/password!");
        header('Location: ../login.php');
    }
    
} else {
    header('Location: ../login.php');
}
?>

