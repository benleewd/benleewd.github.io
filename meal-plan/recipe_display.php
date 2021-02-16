<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <?php
    include "process/session.php";
    include "process/authenticate.php";
    include "process/recipe.php";
    ?>

    
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
    <title>WeightWatcher</title>

    <link rel="stylesheet" href="style/navbar.css">
    <link rel="stylesheet" href="style/index.css">


    <style>
        html, body {
            max-width: 100%;
            overflow-x: hidden;
        }

        #logout {
            position:fixed;
            z-index: 100;
            top: 10px;
            right: 10px;
        }

        #cf {
            background-image: url('img/food.jpg');
            background-size: 120%;
        }

        #recipe {
            background-image: url('img/scroll.jpg');
            background-size: 150%;
            background-position: center;
            padding: 20px;
            margin-top: 5%;
            margin-bottom: 5%;
            border: 1px solid grey;
            box-shadow: 10px 10px 5px grey;
        }
    </style>
</head>

<body id="cf" class="container-fluid">
    <div id="logout">
        <a href="index.php"><img src="img/home.png" width=auto height=50px /></a>
        <a href="process/process_logout.php"><img src="img/logout.png" width=auto height=50px /></a>
    </div>
    <main class="row">
        <main id="main" class="col-12 p-0">
        <?php 
        $foodSelected = $_POST['content2'];
        $recipe = new Recipe;
        $decoder = $recipe->getRecipeDetails($foodSelected);
        ?>
        <section id="content2">
            <div class="container" id="ingredients">   
                <div class="row">
                    <div id="recipe" class="col-12">
                        <img src=<?php echo $decoder['image'];?> width=450rem height=250rem class="pt-4 rounded mx-auto d-block">
                        <h3>Ingredients</h3>
                        <hr/>
                        <div class="row">
                        <?php
                            $countOfRows = count($decoder['extendedIngredients']);
                            for($i=0; $i<$countOfRows;$i++){
                                echo "<div class='col-6'>{$decoder['extendedIngredients'][$i]['original']}</div>";
                            }
                        ?>                         
                        </div>
                        <h3 class="mt-4">Steps</h3>
                        <hr/>
                        <div class="row mb-4">
                        <?php
                            $numberOfSteps = count($decoder['analyzedInstructions'][0]['steps']);
                            for($i=1; $i<=$numberOfSteps;$i++){
                                echo "<div class='col-12 mb-3'>Step $i: {$decoder['analyzedInstructions'][0]['steps'][$i-1]['step']}</div>";
                            }
                        ?>        
                        </div>
                    </div>
                </div>
            </div>

                <?php
                    
                    
                ?>
            </section>

        </main>
    </main>

    <script src="script/navbar.js"></script>
    <script src="script/speechRecognition.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
        
    <script>
        document.getElementById("recipe").addEventListener("click", function(){
            if (document.getElementById("recipeForm").style.display == "inline") {
                document.getElementById("recipeForm").style.display = "none";
            } else {
                document.getElementById("recipeForm").style.display = "inline";
            }
            
        });

        document.getElementById("fileAttachment").addEventListener("click", function () {
            document.getElementById("content2").style.display = "block";
            
        });

        document.getElementById("resetBtn").addEventListener("click", function () {
            document.getElementById("mainSearch").style.display = "block";
            document.getElementById("fileUpload").style.display = "none";
        });

        var fileTag = document.getElementById("image"),
            preview = document.getElementById("imageShow");

        fileTag.addEventListener("change", function () {
            changeImage(this);
        });

        function changeImage(input) {
            var reader;

            if (input.files && input.files[0]) {
                reader = new FileReader();

                reader.onload = function (e) {
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

    
    </script>


</body>

</html>