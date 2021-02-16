<?php

require 'vendor/autoload.php';
include "session.php";

# imports the Google Cloud client library
use Google\Cloud\Vision\V1\ImageAnnotatorClient;

use function GuzzleHttp\json_decode;

if (isset($_POST['submit'])) {
    $file = $_FILES['image'];
    $userTextInput = $_POST['food'];
    $toProcess = "";

    $userEmail = $_SESSION['user'];
    $user = new UserDAO;
    $userDetails = $user->retrieve($userEmail);

    if ($userTextInput != "") {
        $toProcess = $userTextInput;
    } else if ($file['error'] == 0) {
        // Storing file in uploads folder
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];

        $fileExt = explode(".", $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $fileNameNew = uniqid('', true) . "." . $fileActualExt;
        $fileDestination = 'uploads/' . $fileNameNew;
        move_uploaded_file($fileTmpName, $fileDestination);

        // process the file

        # instantiates a client
        $imageAnnotator = new ImageAnnotatorClient([
            'credentials' => json_decode(file_get_contents('key.json'), true)
        ]);

        # prepare the image to be annotated
        $image = file_get_contents($fileDestination);

        # performs label detection on the image file
        $response = $imageAnnotator->labelDetection($image);
        $labels = $response->getLabelAnnotations();

        $commonNames = ["dish", "food", "cuisine", "ingredient"];

        if ($labels) {
            foreach ($labels as $label) {
                $foodItem = $label->getDescription();
                //filter descriptions by food. So take the first Food Item
                if (!in_array(strtolower($foodItem), $commonNames)) {
                    $toProcess = $foodItem;
                    break;
                }
            }
        } else {
            //Add error msg. Unable to identify the food. Please key in the food name manually. 
        }
    } else {
        //Add error msg. You need to insert a picture, voice command or type in your meal.
    }

    // Process the food item entered to give calories(to add part 2 here)
    $foodName = $toProcess;
    $calorieUrl = "https://trackapi.nutritionix.com/v2/search/instant?query=" . $foodName;
    $applicationID = "placeholder";
    $applicationKey = "placeholder";

    function prepareHeaders($headers)
    {
        $flattened = array();

        foreach ($headers as $key => $header) {
            if (is_int($key)) {
                $flattened[] = $header;
            } else {
                $flattened[] = $key . ': ' . $header;
            }
        }

        return implode("\r\n", $flattened);
    }

    $headers = array(
        'X-APP-ID' => $applicationID,
        'X-APP-KEY' => $applicationKey,
    );

    $context = stream_context_create(array(
        'http' => array(
            'method' => 'GET',
            'header' => prepareHeaders($headers)
        )
    ));


    $content = file_get_contents($calorieUrl, false, $context);
    $dataObj = json_decode($content);
    $foodObjs = $dataObj->branded;
    $calories = $foodObjs[0]->nf_calories;
    $noOfServing =  $foodObjs[0]->serving_qty;
    $totalCalories = $noOfServing * $calories;

    $userDailyCount = $userDetails->dailycount;
    $userDailyCount -= $calories;
    $userDetails = $user->updateDailyCount($userEmail, $userDailyCount);

    // $_SESSION["foodAte"] = $toProcess . "<br>" . "Calories per serving: " . $calories . "<br>Number of servings: " . $noOfServing . "<br>Total Number of calories: " . $totalCalories;
    // $recipe = new Recipe;
    // $recipeDetails = $recipe->getRecipesByCalories(0, (int) $userDailyCount);
    // $decodedRecipeDetails = json_decode($recipeDetails);
    // $_SESSION['suggestedFoodItems'] = $decodedRecipeDetails;

    header("Location: ../index.php");
} else {
    //Add error msg. Something went wrong try again later.
}
