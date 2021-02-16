<?php

require "session.php";
require "calories_counter.php";

$userCalories = 0;

foreach ($_SESSION['userFoodList'] as $title => $img) {
    $userFoodWanted = $title;

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

    $foodName = $toProcess;

    $cl = new Calories;
    $totalCalories = $cl->getCalories($foodName);
    

    $userCalories += $totalCalories;

    
}

if ($userCalories == 0) {
    $_SESSION['caloriesCount'] = "<p>Please try again later:(</p>";
} else {
    $_SESSION['caloriesCount'] = "<p>Current estimated calories count: $userCalories calories (1 serving per food item)</p>";
}


$temp = $_POST["targetCalories"];


header("Location: ../mealPlan.php?targetCalories=$temp");
?>