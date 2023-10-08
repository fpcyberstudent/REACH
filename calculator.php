<?php

require 'vendor/autoload.php';
$user = "admin";
$pwd = '779f990a';

$client = new MongoDB\Client("mongodb://${user}:${pwd}@127.0.0.1:27017");

if(isset($_POST['budget']) && $_POST['budget'] != 0)
{

$printMeals = true;

$budget = $_POST['budget'];

$allergies = array();

if(isset($_POST['dairy']))
{
    array_push($allergies, $_POST['dairy']);
}
if(isset($_POST['eggs']))
{
    array_push($allergies, $_POST['eggs']);
}
if(isset($_POST['nuts']))
{
    array_push($allergies, $_POST['nuts']);
}
if(isset($_POST['seafood']))
{
    array_push($allergies, $_POST['seafood']);
}
if(isset($_POST['soy']))
{
    array_push($allergies, $_POST['soy']);
}
if(isset($_POST['wheat']))
{
    array_push($allergies, $_POST['wheat']);
}

$minimize = $_POST['minimize'];

$approvedMeals = array();

$collection = $client->fia->meals;
$result = $collection->find([]);

foreach ($result as $entry){

    $storedAllergies = array();
    $cost = $entry['cost'];
    $allergiesLength = count($allergies);

    $calories = $entry['nutrition']['calories'];
    $carbsg = $entry['nutrition']['carbsg'];
    $proteing = $entry['nutrition']['proteing'];
    $sodiummg = $entry['nutrition']['sodiummg'];
    $fatg = $entry['nutrition']['fatg'];
    $sugarg = $entry['nutrition']['sugarg'];

    foreach($entry['allergies'] as $allerg)
    {
        array_push($storedAllergies, $allerg);
    }

    if($minimize == "calories" && $calories >= 750) { continue; }
    if($minimize == "sugar" && $sugar >= 8) { continue; }
    if($minimize == "fats" && $fats >= 26) { continue; }
    if($minimize == "carbs" && $carbs >= 92) { continue; }
    if($minimize == "protein" && $protein >= 25) { continue; }
    if($minimize == "sodium" && $sodium >= 650) { continue; }

    if($cost >= $budget) { continue; } 

    if($allergiesLength != 0)
    {
        if(count(array_intersect($allergies, $storedAllergies)) != 0) { continue; }
    }

    $foodArray = array();
    foreach($entry['foods'] as $nutrient)
    {
        array_push($foodArray, $nutrient);
    }

    $nutritionArray = array();
    foreach($entry['nutrition'] as $nutrition)
    {
        array_push($nutritionArray, $nutrition);
    }
    
    $meal = [
        'name' => $entry['name'],
        'cost' => $entry['cost'],
        'foods' => $foodArray,
        'nutrition' => $nutritionArray,
        'type' => $entry['type'],
    ];
    
    array_push($approvedMeals, $meal);

}

}


?> 
<!DOCTYPE html>
<head><script src="../assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Headers · Bootstrap v5.3</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/headers/">

    

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        width: 100%;
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }

      .btn-bd-primary {
        --bd-violet-bg: #712cf9;
        --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

        --bs-btn-font-weight: 600;
        --bs-btn-color: var(--bs-white);
        --bs-btn-bg: var(--bd-violet-bg);
        --bs-btn-border-color: var(--bd-violet-bg);
        --bs-btn-hover-color: var(--bs-white);
        --bs-btn-hover-bg: #6528e0;
        --bs-btn-hover-border-color: #6528e0;
        --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
        --bs-btn-active-color: var(--bs-btn-hover-color);
        --bs-btn-active-bg: #5a23c8;
        --bs-btn-active-border-color: #5a23c8;
      }

      .bd-mode-toggle {
        z-index: 1500;
      }

      .bd-mode-toggle .dropdown-menu .active .bi {
        display: block !important;
      }
    </style>
    
    <!-- HEADERS -->
    <link href="headers.css" rel="stylesheet"/>
  </head>
  <body>

<main>
  <h1 class="visually-hidden">REACH - Relief, Empowerment, & Assistance for Community Hunger</h1>

  

<div class="container">
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
            <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
            <div>
              <img src="Logo.png" alt="Your Image Description" style="float: left; margin-right: 0.01px; width: 50px;">
              <span class="fs-4">REACH</span>
            </div>
        </a>

        <ul class="nav nav-pills">
          <li class="nav-item"><a href="/index.html" class="nav-link px-2 text-body-secondary">Home</a></li>
          <li class="nav-item"><a href="/About.html" class="nav-link px-2 text-body-secondary">About</a></li>
          <li class="nav-item"><a href="/calculator.php" class="nav-link px-2 text-body-secondary bg-warning ">Calculator</a></li>
          <li class="nav-item"><a href="/recipes.php" class="nav-link px-2 text-body-secondary">Recipes</a></li>
          <li class="nav-item"><a href="/Contact.html" class="nav-link px-2 text-body-secondary">Contact</a></li>
        </ul>
    </header>
    <body>
        <div class="center-container">
            <h1 class="display-4">Meal Calculator</h1>
            <form action="/calculator.php" method="post">

                <div class = "form-group">
                    <!-- Text input box -->
                    <label for="budget">Enter Budget per meal (min. $8.20):</label>
                    <input class = "form-control" type="budget" id="budget" name="budget">
                    <br />
                </div>
        
                <!-- Select for allergies -->
                <label>Select Allergies (if applicable):</label>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="dairy" name="dairy" value="dairy" >
                    <label class="form-check-label" for="dairy">Dairy</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="nuts" name="nuts" value="nuts">
                    <label class="form-check-label" for="nuts">Nuts</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="wheat" name="wheat" value="wheat" >
                    <label class="form-check-label" for="wheat">Wheat</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="seafood" name="seafood" value="seafood" >
                    <label class="form-check-label" for="seafood">Seafood</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="eggs" name="eggs" value="eggs" >
                    <label class="form-check-label" for="eggs">Eggs</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="soy" name="soy" value="soy" >
                    <label class="form-check-label" for="soy">Soy</label>
                </div>

                <div class = "form-group">
                    <label for="minimize">What would you like to minimize most in your diet?:</label>
                    <select class = "form-control" id="minimize" name="minimize">
                        <option>None</option>
                        <option value="protein">Protein</option>
                        <option value="carbs">Carbohydrates</option>
                        <option value="sodium">Sodium</option>
                        <option value="fats">Fats</option>
                        <option value="sugar">Sugar</option>
                        <option value="calories">Calories</option>
                    </select>
                </div>
                <br />
                <input class = "btn btn-warning" type="submit" value="Submit">
            </form>

            <?php 
            if($approvedMeals == array()) { ?>
            
                <h1 class="display-4">No meals found :(</h1>
            <?php

            if($printMeals && $approvedMeals != array())
            {?>
                <h1 class="display-4">No meals found :(</h1>
            <?php}

            foreach ($approvedMeals as $meal) { ?>

                <!--Cards-->
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title"><?php echo($meal['name'] . " ($" . $meal['cost'] . ")") ?></h3>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Dishes</h5>
                                    <ul>
                                        <?php foreach ($meal['foods'] as $foodAtom) {?> 
                                        <li> <?php echo($foodAtom); ?> </li>
                                        <?php }?>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h5>Nutrition Facts:</h5>
                                    <ul>
                                        <li> <?php echo("Calories: " . $meal['nutrition'][0]); ?> </li>
                                        <li> <?php echo("Carbs (g): " . $meal['nutrition'][1]); ?> </li>
                                        <li> <?php echo("Protein (g): " . $meal['nutrition'][2]); ?> </li>
                                        <li> <?php echo("Sodium (mg): " . $meal['nutrition'][3]); ?> </li>
                                        <li> <?php echo("Fat (g): " . $meal['nutrition'][4]); ?> </li>
                                        <li> <?php echo("Sugar (g): " . $meal['nutrition'][5]); ?> </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />
                <?php }?>
            
            <?php }?>

            

        </div


    <!-- FOOTER -->
    
    <div class="container">
        <footer class="py-3 my-4">
          <ul class="nav justify-content-center border-bottom pb-3 mb-3">
          <li class="nav-item"><a href="/index.html" class="nav-link px-2 text-body-secondary">Home</a></li>
            <li class="nav-item"><a href="/About.html" class="nav-link px-2 text-body-secondary">About</a></li>
            <li class="nav-item"><a href="/calculator.php" class="nav-link px-2 text-body-secondary">Calculator</a></li>
            <li class="nav-item"><a href="/recipes.php" class="nav-link px-2 text-body-secondary">Recipes</a></li>
            <li class="nav-item"><a href="/Contact.html" class="nav-link px-2 text-body-secondary">Contact</a></li>
          </ul>
          <p class="text-center text-body-secondary">&copy; 2023 Food Insecurity Aid</p>
        </footer>
      </div>
      
      <div class="b-example-divider"></div>
     
      
    
    
  
  



</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    

</body>
</html>

