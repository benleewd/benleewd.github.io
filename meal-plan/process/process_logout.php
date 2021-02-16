<?php
require_once 'session.php';

session_unset();

// redirect
header("Location: ../logout.html");
    