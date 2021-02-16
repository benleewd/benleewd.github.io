<?php
require_once 'recipe/vendor/autoload.php';

    class Recipe
    {
        private $intData = [];

        public function __construct(){
            $this->intData = ["extendedIngredients", "readyInMinutes", "servings", "image", "analyzedInstructions"];
        }

        public function getRecipeDetails(String $recipeName)
        {   
            $headers = array('Accept' => 'application/json');
            Unirest\Request::verifyPeer(false); 

            $inputArr = explode(" ", $recipeName);
            $arrLength = count($inputArr);
            $lastWord = $inputArr[$arrLength - 1];
            $inputArr[$arrLength - 1] = substr($lastWord, 0, strlen($lastWord) - 1);
            $input = join("+", $inputArr);
            
            // var_dump($input);

            $response = Unirest\Request::get("https://spoonacular-recipe-food-nutrition-v1.p.rapidapi.com/recipes/search?number=10&offset=0&query=" . $input,
            array(
                "X-RapidAPI-Host" => "spoonacular-recipe-food-nutrition-v1.p.rapidapi.com",
                "X-RapidAPI-Key" => "nutritionix-api.p.rapidapi.com"
            )
            );

            $data = json_decode($response->raw_body, true);

            // var_dump($data);

            // echo "<br>";

            $id = $data['results'][0]['id'];

            return $this->getIngredients($id);

        }

        public function getIngredients(int $id)
        {
            $headers = array('Accept' => 'application/json');
            Unirest\Request::verifyPeer(false); 
            $response = Unirest\Request::get("https://spoonacular-recipe-food-nutrition-v1.p.rapidapi.com/recipes/" . $id . "/information",
            array(
                "X-RapidAPI-Host" => "spoonacular-recipe-food-nutrition-v1.p.rapidapi.com",
                "X-RapidAPI-Key" => "placeholder"
            )
            );

            $data = json_decode($response->raw_body, true);

            // var_dump($data);

            $recipeData = [];

            foreach ($this->intData as $item) {
                $recipeData[$item] = $data[$item];
            }
            
            return $recipeData;
        }

        public function getDailyMeal(int $targetCalories)
        {
            $headers = array('Accept' => 'application/json');
            Unirest\Request::verifyPeer(false); 
            $response = Unirest\Request::get("https://spoonacular-recipe-food-nutrition-v1.p.rapidapi.com/recipes/mealplans/generate?targetCalories=" . $targetCalories . "&timeFrame=day",
            array(
              "X-RapidAPI-Host" => "spoonacular-recipe-food-nutrition-v1.p.rapidapi.com",
              "X-RapidAPI-Key" => "placeholder"
            )
          );
          return $response->raw_body;
        }

        public function getRecipesByCalories(int $minCalories, int $maxCalories) 
        {
            $response = Unirest\Request::get("https://spoonacular-recipe-food-nutrition-v1.p.rapidapi.com/recipes/findByNutrients?minCalories=". $minCalories ."&maxCalories=" . $maxCalories,
            array(
              "X-RapidAPI-Host" => "spoonacular-recipe-food-nutrition-v1.p.rapidapi.com",
              "X-RapidAPI-Key" => "placeholder"
            )
          );
          return $response->raw_body;
        }

        public function detectFoodInText(String $textInput) 
        {
            $curl = curl_init();
            
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://spoonacular-recipe-food-nutrition-v1.p.rapidapi.com/food/detect",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "text=" . $textInput,
                CURLOPT_HTTPHEADER => array(
                    "content-type: application/x-www-form-urlencoded",
                    "x-rapidapi-host: spoonacular-recipe-food-nutrition-v1.p.rapidapi.com",
                    "x-rapidapi-key: placeholder"
                ),
            ));
            
            $response = curl_exec($curl);
            $err = curl_error($curl);
            
            curl_close($curl);
            
            if ($err) {
                return "cURL Error #:" . $err;
            } else {
                return $response;
            }
        }
    }
    
//sample codes for testing purposes

//     $headers = array('Accept' => 'application/json');
//     Unirest\Request::verifyPeer(false); 
//     $response = Unirest\Request::get("https://spoonacular-recipe-food-nutrition-v1.p.rapidapi.com/recipes/mealplans/generate?targetCalories=2000&timeFrame=day",
//     array(
//       "X-RapidAPI-Host" => "spoonacular-recipe-food-nutrition-v1.p.rapidapi.com",
//       "X-RapidAPI-Key" => "placeholder"
//     )
//   );
//   //print_r($response->raw_body);
//  // $val = json_encode();
//   $decode = json_decode($response->raw_body);
//   var_dump($decode->meals[0]);

    // $recipe = new Recipe;

    //var_dump($recipe->getRecipeDetails("Pork chops with cider and spinach"));
    //var_dump($recipe->detectFoodInText("Spicy Tuna Tartare Mushrooms Soup Cheese"));

    //get image from api
    // $recipe = new Recipe;
    // $decode = json_decode($recipe->getDailyMeal(2000));
    // $val = $decode->meals[0]->imageUrls[0];
    // var_dump($val);
    // echo "<img src='https://spoonacular.com/recipeImages/" . $val . "'/>";
?>