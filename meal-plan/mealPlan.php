<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <?php
    error_reporting(0);
    include "process/session.php";
    include "process/authenticate.php";
    include "process/recipe.php";

    if (!isset($_SESSION['userFoodList'])) {
        $_SESSION['userFoodList'] = array();
    }

    if (isset($_POST['foodItem'])) {
        $input = $_POST['foodItem'];
        $name = explode("|", $input)[1];
        $img = explode("|", $input)[2];
        $_SESSION['userFoodList'][$name] = $img;
    }

    if (isset($_POST['removeItem'])) {
        $input = $_POST['removeItem'];
        $name = explode("|", $input)[1];
        $img = explode("|", $input)[2];
        unset($_SESSION['userFoodList'][$name]);
    }

    if (isset($_GET['targetCalories'])) {
        $_POST['targetCalories'] = $_GET['targetCalories'];
    }
    ?>


    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
    <title>WeightWatcher</title>

    <link rel="stylesheet" href="style/index.css">


    <style>
        html,
        body {
            max-width: 100%;
            overflow-x: hidden;
        }

        #logout {
            position: fixed;
            z-index: 100;
            top: 10px;
            right: 10px;
        }

        #SuggestedFood {
            background-color: whitesmoke;
            padding: 3%;
            margin-top: 2%;
        }

        #userCart {
            background-color: lightgoldenrodyellow;
            padding: 3%;
        }

        #cf {
            background-image: url('img/food.jpg');
            background-size: 120%;
        }
    </style>
</head>

<body id="cf" class="container-fluid">
    <div id="logout">
        <a href="index.php"><img src="img/home.png" width=auto height=50px /></a>
        <a href="process/process_logout.php"><img src="img/logout.png" width=auto height=50px /></a>
    </div>
    <main class="row">
        <div class="col-1 p-0"></div>
        <main id="main" class="col-10 p-0">
            <form class="form-inline justify-content-center pt-5" action="mealPlan.php" method="POST">
                <div class="form-group mb-2">
                    <input type="text" readonly class="form-control-plaintext" id="staticEmail2" value="Enter your target calories">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <input type="text" class="form-control" name="targetCalories" id="targetCalories" placeholder="Target Calories" <?php
                                                                                                                                    if (isset($_POST['targetCalories'])) {
                                                                                                                                        echo "value=\"{$_POST['targetCalories']}\"";
                                                                                                                                    }
                                                                                                                                    ?>>
                </div>
                <button type="button" class="btn btn-primary mb-2" name="submit">Enter</button>
            </form>
            <section id="SuggestedFood">

                <?php
                if (count($_SESSION['userFoodList']) != 3) {
                    echo "
                    <div class='text-center'>
                        <h2>Suggested Food</h2>
                    </div>
                    ";

                    if (isset($_POST['targetCalories'])) { ?>
                        <div class="row p-3 ml-5" id="contentTargetCalories">
                            <?php
                                    $recipe = new Recipe;
                                    $decode = json_decode($recipe->getDailyMeal((int) $_POST['targetCalories']));

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
                                        <form action='mealPlan.php' method='post'>
                                            <input type='hidden' name='targetCalories' value=\"{$_POST['targetCalories']}\">
                                            <button id='add$i' class='btn btn-outline-success' value='$i|{$decode->meals[$i]->title}|{$decode->meals[$i]->image}' name='foodItem' >Add to food list</button>
                                        </form>
                                    </div>";
                                        echo "
                                    </div>
                                    </div>
                                    </div>";
                                    }

                                    ?>
                        </div>
                <?php
                        echo "
                        <form class='text-center' action='mealPlan.php' method='post'>
                            <input type='hidden' name='targetCalories' value=\"{$_POST['targetCalories']}\">
                            <button class='btn btn-outline-success' name='foodItem'>More suggestion</button>
                        </form>
                        ";
                    }
                }
                ?>

            </section>
        </main>
        <div class="col-1 p-0"></div>
    </main>

    <main class="row">
        <p> </p>
    </main>

    <main class="row">
        <div class="col-1 p-0"></div>
        <main class="col-10 p-0">
            <section id='userCart'>
                <div class="text-center">
                    <?php
                    if (count($_SESSION['userFoodList']) != 0) {
                        echo "<h2>Your Food List</h2>";
                    }
                    if (count($_SESSION['userFoodList']) != 3) {
                        if (isset($_SESSION['caloriesCount'])) {
                            unset($_SESSION['caloriesCount']);
                        }
                    } else {
                        if (isset($_SESSION['caloriesCount'])) {
                            echo $_SESSION['caloriesCount'];
                        } else {
                            echo "<form action='process/process_calories.php' method='post'>
                                <input type='hidden' name='targetCalories' value=\"{$_POST['targetCalories']}\">
                                <button class='btn btn-outline-success' name='estimateCalories' >Estimate Calories</button>
                             </form>";
                        }
                    }
                    ?>
                </div>
                <?php if (count($_SESSION['userFoodList']) != 0) { ?>
                    <div class="row p-3 ml-5" id="contentTargetCalories">
                        <?php


                            foreach ($_SESSION['userFoodList'] as $title => $img) {
                                echo " <div class='col-sm-4'>
                                    <div class='card' style='width: 18rem; height:25rem; background-color: #555555;'>
                                    <img class='card-img-top' src='";
                                if (empty($img)) {
                                    echo "img/no-image.png";
                                } else {
                                    echo "https://spoonacular.com/recipeImages/" . $img;
                                }
                                echo  "' width=18rem; height=200rem>
                                    <div class='card-body text-center pl-4>'
                                    <p class='card-text' style='color:white;'>
                                    {$title}
                                    </p>";
                                echo "
                                    <div class='btn-group'>
                                        <form action='mealPlan.php' method='post'>
                                            <input type='hidden' name='targetCalories' value=\"{$_POST['targetCalories']}\">
                                            <button class='btn btn-outline-success' value='1|$title|$img' name='removeItem' >Remove from list</button>
                                        </form>
                                    </div>";
                                echo "
                                    </div>
                                    </div>
                                    </div>";
                            }
                            $limit = 3 - count($_SESSION['userFoodList']);
                            for ($i = 0; $i < $limit; $i++) {
                                echo " <div class='col-sm-4'>
                                    <div class='card' style='width: 18rem; height:25rem; background-color: #555555;'>
                                    <img class='card-img-top' src='";

                                echo "img/no-image.png";

                                echo  "' width=18rem; height=200rem>
                                    <div class='card-body text-center pl-4>'
                                    <p class='card-text' style='color:white;'>
                                    Add something
                                    </p>";
                                echo "
                                    <div class='btn-group'>
                                        <form action='mealPlan.php' method='post'>
                                        <input type='hidden' name='targetCalories' value=\"{$_POST['targetCalories']}\">
                                    </div>";
                                echo "
                                    </div>
                                    </div>
                                    </div>";
                            }

                            ?>
                    </div>
                <?php } ?>

            </section>
        </main>
        <div class="col-1 p-0"></div>
    </main>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script>
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



</body>

</html>