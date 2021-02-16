<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <?php
    include "process/session.php";
    include "process/authenticate.php";
    include "process/recipe.php";
    include "process/google_api.php";

    $googleapi = new GoogleApi;
    $apikey = $googleapi->getApiKey();
    ?>


    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
    <title>WeightWatcher</title>

    <link rel="stylesheet" href="style/navbar.css">
    <link rel="stylesheet" href="style/index.css">

    <style>
        /* Set the size of the div element that contains the map */
        #map {
            height: 500px;
            /* The height is 400 pixels */
            width: 100%;
            /* The width is the width of the web page */
        }

        html,
        body {
            max-width: 100%;
            overflow-x: hidden;
        }

        .button {
            background-color: black;
            color: white;
            font-size: 16px;
            padding: 14px 40px;
            border: none;
        }

        #logout {
            position: fixed;
            z-index: 100;
            top: 10px;
            right: 10px;
        }
    </style>
</head>

<body class="container-fluid">
    <div id="logout">
        <a href="process/process_logout.php"><img src="img/logout.png" width=auto height=50px /></a>
    </div>
    <main class="row">
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel" data-wrap="false">
            <div class="carousel-inner">
                <div class="carousel-item active d-flex" style="background-image:url('img/food.jpg'); background-size: cover; height:100vh; width:100vw">
                    <div class="mx-auto" style="margin-top:7%;">
                        <img src="img/logo.png" class="d-block mx-auto" width=15% height=auto />
                        <div style='font-size:5rem;'>Welcome back,
                            <?php
                            $userEmail = $_SESSION['user'];
                            $user = new UserDAO;
                            $userDetails = $user->retrieve($userEmail);
                            echo "{$userDetails->name}";
                            ?>
                            !
                        </div>
                        <p class="lead text-center font-weight-normal">You have <?php echo $userDetails->dailycount; ?> calories left for today</p>
                    </div>
                </div>
                <div class="carousel-item " style="background-image:url('img/food.jpg'); background-size: cover; height:100vh; width:100vw">
                    <div class="form-group mb-2 text-center h3 mt-5 pt-5">
                        <label for="targetCalories">These are the food that you can consume with <?php echo $userDetails->dailycount; ?> calories!</label>
                    </div>

                    <div class="row p-5 ml-5" id="contentTargetCalories">
                        <?php
                        $recipe = new Recipe;
                        $decode = json_decode($recipe->getDailyMeal((int) $userDetails->dailycount));
                        echo "
                            <div class='col-sm-2' >
                            
                            </div>
                            <div class='col-sm-8'>
                                <div class='row'>
                                ";
                        for ($i = 0; $i < 3; $i++) {
                            echo " <div class='col-sm-4'>
                                    <div class='card' style='width: 18rem; height:25rem; background-color: #555555;'>
                                    <img class='card-img-top' src='";
                            if (empty($decode->meals[$i]->image)) {
                                echo "img/no-image.png";
                            } else {
                                echo "https://spoonacular.com/recipeImages/" . $decode->meals[$i]->image;
                            }
                            echo  "' width=18rem; height=200rem>
                                    <div class='card-body text-center pl-4>'
                                    <p class='card-text' style='color:white;'>
                                    {$decode->meals[$i]->title}
                                    </p>";
                            echo "
                                    <div class='btn-group'>
                                        <button class='btn btn-outline-success' value='{$decode->meals[$i]->title}' name='submit' onclick='getData(this)'>Location</button>
                                        <form method='post' action='recipe_display.php'>
                                            <input type='hidden' name='content2' id='' value='{$decode->meals[$i]->title}'>
                                            <button class='btn btn-outline-success' type='submit' name='submit'>Recipe</button>
                                        </form>
                                    </div>";
                            echo "
                                    </div>
                                    </div>
                                    </div>";
                        }
                        echo "</div>
                        </div>
                        <div class='col-sm-2'>
                        </div>";
                        ?>
                    </div>
                </div>
                <div class="carousel-item" style="background-image:url('img/food.jpg'); background-size: cover; height:100vh; width:100vw">
                    <div class="d-block ">
                        <div class="mx-auto" style="margin-top:15%; margin-bottom:auto;">
                            <h2 class="text-center font-weight-normal">Update your calories intake here!</h2><br>
                            <form action="process/process_food.php" class="my-auto mx-auto" method="POST" enctype="multipart/form-data">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div id="fileUpload" class="col-12" style="display: none;">
                                            <div class="form-group files">
                                                <!-- <label>Upload Picture of Your Meal</label> -->
                                                <input type="file" class="form-control" multiple="" name="image" id="image" accept="image/*">
                                            </div>
                                        </div>
                                        <div id="imagePreview" class="col-12 text-center" style="display:none;">
                                            <img id="imageShow" src="" alt="">
                                        </div>
                                        <div id="mainSearch" class="col-12" style="display: block;">
                                            <div class="container input-group mb-3 w-50">
                                                <input class="form-control" type="text" name="food" id="food" placeholder="What did you have?">
                                                <div class="input-group-append">
                                                    <img id="startRecord" src="img/mic_icon.png" alt="" style="display: block;" height="80%">
                                                    <img id="stopRecord" src="img/stop_icon.png" alt="" style="display: none;" height="80%">
                                                    <img id="fileAttachment" src="img/paper_clip_icon.png" alt="" height="80%">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row text-center pt-1">
                                        <div class="col-12">
                                            <input class="button" type="submit" name="submit" id="submit" style="display: none;"></input>
                                            <button id="resetBtn" class="button" type="reset">Reset</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

    </main>
    <main class="row">
        <div class="col-4 pt-5 pb-5 text-center" style="background-color:#d3d3d3; ">
            <img src='img/breakfast.png' width=20% height=auto />
            <h5 class="mt-5">Find recipe to food you like through our wonderful list of recipes!</h5><br />
            <button id="GenerateMealPlan" class='button'>Find recipe</button>
            <form id="GenerateMealPlanForm" action="recipe_display.php" style="display: none;" method="post">
                <input type="text" class="form-control" placeholder="Enter food name here" name="content2" required="required"><br />
                <input type="submit" class='button' value="Let's Go!" />
            </form>
        </div>
        <div class="col-4 pt-5 pb-5 text-center" style="background-color:#d3d3d3;">
            <img src='img/lamp.png' width=20% height=auto />
            <h5 class="mt-5">Get various food suggestions and plan meals based on calories entered!</h5><br>
            <button id="FoodSuggestion" class='button'>Get food suggestion</button>
            <form id="FoodSuggestionForm" action="mealPlan.php" style="display: none;" method="post">
                <!-- <label for="comment">Min Calories:</label> -->
                <!-- <input type="text" class="form-control" id="foodSuggested" placeholder="Min Calories"><br /> -->
                <!-- <label for="comment">Max Calories:</label> -->
                <input type="text" class="form-control" name="targetCalories" placeholder="Calories" required="required"><br />
                <input type="submit" class='button' value="Let's Go!" />
            </form>
        </div>
        <div class="col-4  pt-5 pb-5 text-center" style="background-color:#d3d3d3;">
            <img src='img/place.png' width=20% height=auto />
            <h5 class="mt-5">Enter the food that you want to find and we will suggest a place for you!</h5><br />
            <button id="LocationSuggestion" class='button'>Get location suggestion</button>
            <form id="LocationSuggestionForm" class="form-group" style="display: none;">
                <input type="text" class="form-control" id="foodRequestedLocation" placeholder="Enter food here" onkeypress='return check(event)'><br />
                <input type="button" class='button' value="Let's Go!" onclick='getLocation()' />
            </form>
        </div>

    </main>
    <section class="text-center">
        <p id="mapText"></p>
        <div id="map" style="display: none;"></div>
    </section>

    <script src="script/navbar.js"></script>
    <script src="script/speechRecognition.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script>
        document.getElementById("fileAttachment").addEventListener("click", function() {
            document.getElementById("content2").style.display = "block";

        });

        document.getElementById("resetBtn").addEventListener("click", function() {
            document.getElementById("mainSearch").style.display = "block";
            document.getElementById("fileUpload").style.display = "none";
        });

        document.getElementById("fileAttachment").addEventListener("click", function() {
            document.getElementById("mainSearch").style.display = "none";
            document.getElementById("fileUpload").style.display = "block";
        });

        var fileTag = document.getElementById("image"),
            preview = document.getElementById("imageShow");

        fileTag.addEventListener("change", function() {
            changeImage(this);
        });

        function changeImage(input) {
            var reader;

            if (input.files && input.files[0]) {
                reader = new FileReader();

                reader.onload = function(e) {
                    preview.setAttribute('src', e.target.result);
                    preview.setAttribute('height', "150px");
                }

                reader.readAsDataURL(input.files[0]);
            }
            document.getElementById("image").style.backgroundPosition = "center";
            document.getElementById("fileUpload").style.display = "none";
            document.getElementById("imagePreview").style.display = "block";
        }

        document.getElementById("food").addEventListener("change", showSubmit);
        document.getElementById("image").addEventListener("change", showSubmit);

        function showSubmit() {
            document.getElementById("submit").style.display = "inline";
        }

        $('.carousel').carousel({
            interval: 5000
        });

        document.getElementById("GenerateMealPlan").addEventListener("click", function() {
            document.getElementById("GenerateMealPlan").style.display = "none";
            document.getElementById("GenerateMealPlanForm").style.display = "inline";
        });

        document.getElementById("FoodSuggestion").addEventListener("click", function() {
            document.getElementById("FoodSuggestion").style.display = "none";
            document.getElementById("FoodSuggestionForm").style.display = "inline";
        });

        document.getElementById("LocationSuggestion").addEventListener("click", function() {
            document.getElementById("LocationSuggestion").style.display = "none";
            document.getElementById("LocationSuggestionForm").style.display = "inline";
        });

        //maps
        var loc = {
            lat: 1.290270,
            lng: 103.851959
        };

        function check(e) {
            if (e.keyCode == 13) {
                getLocation();
                return false;
            }
        }

        function getLocation() {
            var request = new XMLHttpRequest();

            var foodRequestedLocation = document.getElementById("foodRequestedLocation").value;

            request.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    let jsObj = JSON.parse(this.responseText);
                    console.log(jsObj);
                    if (jsObj.status == "ZERO_RESULTS") {
                        document.getElementById("mapText").innerText = "Sorry we are unable to find anything in the vicinity :(";
                    } else if (jsObj == "Sorry no location found") {
                        document.getElementById("mapText").innerText = "Sorry we are unable to find anything in the vicinity :(";
                    } else {
                        var address = jsObj.results[0].formatted_address;
                        var longtitude = jsObj.results[0].geometry.location.lng;
                        var latitude = jsObj.results[0].geometry.location.lat;
                        var name = jsObj.results[0].name;
                        var openingHours = jsObj.results[0].opening_hours.open_now;
                        loc = {
                            lat: latitude,
                            lng: longtitude
                        };
                        initMap();
                        if (openingHours) {
                            document.getElementById("mapText").innerHTML = name + "<br>" + address + "<br>" + "<p style='color:green'>Open now!</p>";
                        } else {
                            document.getElementById("mapText").innerHTML = name + "<br>" + address + "<br>" + "<p style='color:red'>Oh no it is closed!</p>";
                        }
                    }

                    document.getElementById("map").style.display = "block";
                    window.scrollTo(0, document.body.scrollHeight);
                }
            }

            request.open("GET", "process/process_location.php?query=" + foodRequestedLocation, true);
            request.send();
        }

        function getData(obj) {
            var request = new XMLHttpRequest();

            request.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    let jsObj = JSON.parse(this.responseText);
                    console.log(jsObj);
                    if (jsObj.status == "ZERO_RESULTS") {
                        document.getElementById("mapText").innerText = "Sorry we are unable to find anything in the vicinity :(";
                    } else if (jsObj == "Sorry no location found") {
                        document.getElementById("mapText").innerText = "Sorry we are unable to find anything in the vicinity :(";
                    } else {
                        var address = jsObj.results[0].formatted_address;
                        var longtitude = jsObj.results[0].geometry.location.lng;
                        var latitude = jsObj.results[0].geometry.location.lat;
                        var name = jsObj.results[0].name;
                        var openingHours = jsObj.results[0].opening_hours.open_now;
                        loc = {
                            lat: latitude,
                            lng: longtitude
                        };
                        initMap();
                        if (openingHours) {
                            document.getElementById("mapText").innerHTML = name + "<br>" + address + "<br>" + "<p style='color:green'>Open now!</p>";
                        } else {
                            document.getElementById("mapText").innerHTML = name + "<br>" + address + "<br>" + "<p style='color:green'>Oh no it is closed!</p>";
                        }
                    }

                    document.getElementById("map").style.display = "block";
                    window.scrollTo(0, document.body.scrollHeight);
                }
            }

            request.open("GET", "process/process_location.php?query=" + obj.value, true);
            request.send();
        }

        function initMap() {
            var map = new google.maps.Map(
                document.getElementById('map'), {
                    zoom: 15,
                    center: loc
                });
            var marker = new google.maps.Marker({
                position: loc,
                map: map
            });
        }

        //card hover shadow
        $(document).ready(function() {
            console.log("document is ready");


            $(".card").hover(
                function() {
                    $(this).addClass('shadow-lg').css('cursor', 'pointer');
                },
                function() {
                    $(this).removeClass('shadow-lg');
                }
            );

        });
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo $apikey ?>&callback=initMap">
    </script>

</body>

</html>