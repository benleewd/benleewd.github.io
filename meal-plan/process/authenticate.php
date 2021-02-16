<?php

#always use after session.php

if (!isset($_SESSION['user']) && !isset($_COOKIE['user'])) {
    // header("Location: login.php");
    $_SESSION['user'] = "test";
} else if (isset($_COOKIE['user']) && !isset($_SESSION['user'])) {
    $_SESSION['user'] = $_COOKIE['user'];
}

?>