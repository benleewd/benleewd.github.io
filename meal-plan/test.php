<?php
    if (isset($_POST['submit'])) {
        $file = $_FILES['food'];
        var_dump($file);
        $fileName = $_FILES['food']['name'];
        $fileTmpName = $_FILES['food']['tmp_name'];
        $fileSize = $_FILES['food']['size'];
        $fileError = $_FILES['food']['error'];

        var_dump($_POST['text']);
    }

?>