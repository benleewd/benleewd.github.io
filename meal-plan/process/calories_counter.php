<?php

require_once 'recipe/vendor/autoload.php';

class Calories
    {
        public function __construct(){
            
        }

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

        function getCalories(String $foodname) {
            $calorieUrl = "https://trackapi.nutritionix.com/v2/search/instant?query=" . $foodname;
            $applicationID = "nutritionix-api.p.rapidapi.com";
            $applicationKey = "835404b870msh61d5d8dce4f179ap10daebjsn695607c283a0";



            $headers = array(
                'X-APP-ID' => $applicationID,
                'X-APP-KEY' => $applicationKey,
            );

            $context = stream_context_create(array(
                'http' => array(
                    'method' => 'GET',
                    'header' => $this->prepareHeaders($headers)
                )
            ));

            $content = file_get_contents($calorieUrl, false, $context);
            $dataObj = json_decode($content);
            $foodObjs = $dataObj->branded;
            $calories = $foodObjs[0]->nf_calories;
            $noOfServing =  $foodObjs[0]->serving_qty;
            $totalCalories = $noOfServing * $calories;

            return $totalCalories;
        }

    }




?>