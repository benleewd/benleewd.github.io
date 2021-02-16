<?php
require "session.php";
require "google_api.php";

if (isset($_GET['query'])) {
    $userFoodWanted = $_GET['query'];

    $recipe = new Recipe;
    $foodDetected = json_decode($recipe->detectFoodInText($userFoodWanted));

    $toProcess = "";
    $wordsToIgnore = ["brunch", "dish", "food"];
    for ($x = 0; $x < sizeof($foodDetected->annotations); $x++) {
        if (!in_array($foodDetected->annotations[$x]->annotation, $wordsToIgnore)) {
            $toProcess = $foodDetected->annotations[$x]->annotation;
            break;
        }
    }

    $googleapi = new GoogleApi;

    if ($toProcess != "") {
        $location = $googleapi->getPlacesFromText($toProcess);
        if ($location != "Invalid query or no data found") {
            $toReturn = json_encode($location);
            echo $toReturn;
        } else {
            //error handling
            echo "Sorry no location found";
        }
    } else {
        echo "Sorry no location found";
    }
} else {
    //to add error handling
    echo "Sorry no location found";
}
