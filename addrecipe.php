<?php

require 'vendor/autoload.php';
$user = "admin";
$pwd = '779f990a';

$notify = '';

$client = new MongoDB\Client("mongodb://${user}:${pwd}@127.0.0.1:27017");

if(isset($_POST['name']) && $_POST['name'] != '')
{

$ingredients = array();
$ingredientsCount = array();

$name = $_POST['name'];


$igr1 = str_replace("_", " ", $_POST['igr1']);
$igrq1 = $_POST['igrq1'];

$igr2 = str_replace("_", " ", $_POST['igr2']);
$igrq2 = $_POST['igrq2'];

$igr3 = str_replace("_", " ", $_POST['igr3']);
$igrq3 = $_POST['igrq3'];

$igr4 = str_replace("_", " ", $_POST['igr4']);
$igrq4 = $_POST['igrq4'];

$igr5 = str_replace("_", " ", $_POST['igr5']);
$igrq5 = $_POST['igrq5'];

if(isset($igr1) && $igr1 != 'none') {array_push($ingredients, $igr1); array_push($ingredientsCount, $igrq1);}
if(isset($igr2) && $igr2 != 'none') {array_push($ingredients, $igr2); array_push($ingredientsCount, $igrq2);}
if(isset($igr3) && $igr3 != 'none') {array_push($ingredients, $igr3); array_push($ingredientsCount, $igrq3);}
if(isset($igr4) && $igr4 != 'none') {array_push($ingredients, $igr4); array_push($ingredientsCount, $igrq4);}
if(isset($igr5) && $igr5 != 'none') {array_push($ingredients, $igr5); array_push($ingredientsCount, $igrq5);}

$cost = 0;
$allergies = array();
$nutrition = [
        'calories' => 0,
        'carbsg' => 0,
        'proteing' => 0,
        'sodiummg' => 0,
        'fatg' => 0,
        'sugarg' => 0
];

$collection = $client->fia->ingredients;

foreach ($ingredients as $igr){
    $result = $collection->find([
        'name' => $igr
    ]);

    foreach ($result as $entry){

        $multFactor = $ingredientsCount[array_search($entry['name'], $ingredients)];
        $cost += $entry['cost'] * (double)$multFactor;

        $nutrition['calories'] += $entry['nutrition']['calories'] * (int)$multFactor;
        $nutrition['carbsg'] += $entry['nutrition']['carbsg'] * (int)$multFactor;
        $nutrition['proteing'] += $entry['nutrition']['proteing'] * (int)$multFactor;
        $nutrition['sodiummg'] += $entry['nutrition']['sodiummg'] * (int)$multFactor;
        $nutrition['fatg'] += $entry['nutrition']['fatg'] * (int)$multFactor;
        $nutrition['sugarg'] += $entry['nutrition']['sugarg'] * (int)$multFactor;

        foreach($entry['allergies'] as $allerg)
        {
            array_push($allergies, $allerg);
        }
    }

}   

$ingredients = array_filter($ingredients);
$allergies = array_unique($allergies);
$cost = round($cost, 2);
$collection = $client->fia->recipes;

$result = $collection->insertOne( [ 
    'name' => $name, 
    'cost' => $cost, 
    'ingredients' => $ingredients,
    'ingredientsCount' => $ingredientsCount,
    'nutrition' => $nutrition,
    'allergies' => $allergies
] );

$notify = "${name} has been added!";

}

?>

<!DOCTYPE html>
<head><script src="../assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Add a Recipe · REACH</title>

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
            <span class="fs-4">REACH</span>
        </a>

        <ul class="nav nav-pills">
        <li class="nav-item"><a href="/index.html" class="nav-link px-2 text-body-secondary">Home</a></li>
          <li class="nav-item"><a href="/About.html" class="nav-link px-2 text-body-secondary">About</a></li>
          <li class="nav-item"><a href="/calculator.php" class="nav-link px-2 text-body-secondary">Calculator</a></li>
          <li class="nav-item"><a href="/recipes.php" class="nav-link px-2 text-body-secondary bg-warning">Recipes</a></li>
          <li class="nav-item"><a href="/Contact.html" class="nav-link px-2 text-body-secondary">Contact</a></li>
        </ul>
    </header>
    <h1 class="display-4">Add a Recipe</h1>
    <!--Body with input-->
    <form class="form-inline" action="/addrecipe.php" method="post">

        <div class="container">
        
        <div class = "form-group">
        <label for="name">Enter Name of Recipe:</label>
        <br />

        <input type="text" class="form-control" id="name" name="name">
        <br />
        </div>

        <?php
        for ($x = 1; $x < 6; $x++) {
        ?>
          <div class="row">
            <div class= "col">
              <div class = "form-group">
                <label for=<?php echo("igr" . (String)$x);?>>Select ingredient:</label>
                <select class="form-control" id=<?php echo("igr" . (String)$x)?> name=<?php echo("igr" . (String)$x);?>>
                  <option value="none">none selected</option>
                  <?php 
                  $collection = $client->fia->ingredients;
                  $result = $collection->find([]);
                  foreach ($result as $entry)
                  {
                  ?>
                  <option value=<?php echo(str_replace(" ", "_", $entry['name']));?>><?php echo($entry['name']);?></option>
                  
                <?php }?>
                </select>
              </div>
            </div>
            <div class = "col form-group">
              <!-- Number input -->
              <label for=<?php echo("igrq" . (String)$x);?>>Ingredient Quantity:</label>
              <input class="form-control" type="number" id=<?php echo("igrq" . (String)$x);?> name=<?php echo("igrq" . (String)$x);?> min="1" max="10">
            </div>

          </div>
        <?php
        }
        ?>
        <br />
        <br />
        <input class="btn btn-warning flex" type="submit" value="Submit">
        <br />
        <?php echo($notify); ?>
        </div>
    </form>
    
    <!--FOOTER-->
    
    <div class="container">
        <footer class="py-3 my-4">
          <ul class="nav justify-content-center border-bottom pb-3 mb-3">
            <li class="nav-item"><a href="/index.html" class="nav-link px-2 text-body-secondary">Home</a></li>
            <li class="nav-item"><a href="/About.html" class="nav-link px-2 text-body-secondary">About</a></li>
            <li class="nav-item"><a href="/calculator.php" class="nav-link px-2 text-body-secondary">Calculator</a></li>
            <li class="nav-item"><a href="/recipes.php" class="nav-link px-2 text-body-secondary">Recipes</a></li>
            <li class="nav-item"><a href="/Contact.html" class="nav-link px-2 text-body-secondary">Contact</a></li>
          </ul>
          <p class="text-center text-body-secondary">&copy; 2023 REACH</p>
        </footer>
      </div>
      
      <div class="b-example-divider"></div>
     
      
    
    
  
  



</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    

</body>
</html>

