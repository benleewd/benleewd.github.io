<?php

spl_autoload_register(function($class){
    $path = $class . ".php";
    require $path;
});

session_start();

function printErrors() {
    if (isset($_SESSION['errors'])) {
        print "<ul>";
        foreach ($_SESSION['errors'] as $value) {
            print "<li>$value</li>";
        }
        print "</ul>";
        unset($_SESSION['errors']);
    }
}

?>