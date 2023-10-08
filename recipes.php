<?php

require 'vendor/autoload.php';
$user = "admin";
$pwd = '779f990a';

$notify = '';

$client = new MongoDB\Client("mongodb://${user}:${pwd}@127.0.0.1:27017");

?>

<!DOCTYPE html>
<head><script src="../assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title> Recipes · REACH</title>

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
          <li class="nav-item"><a href="/calculator.php" class="nav-link px-2 text-body-secondary">Calculator</a></li>
          <li class="nav-item"><a href="/recipes.php" class="nav-link px-2 text-body-secondary bg-warning">Recipes</a></li>
          <li class="nav-item"><a href="/Contact.html" class="nav-link px-2 text-body-secondary">Contact</a></li>
        </ul>
    </header>
    <h1 class="display-4">Our Recipes</h1>
    <br />
    <a class = "btn btn-warning" href="/addrecipe.php"> Add your own! </a>
    <div class="container mt-5">
    <?php
    $collection = $client->fia->recipes;
    $result = $collection->find();
    
        foreach ($result as $entry){
    ?>

    <!--Cards-->
    <?php?>
        <div class="card">
            <div class="card-body">
                <h3 class="card-title"><?php echo($entry['name']) ?></h3>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <h5>Ingredients</h5>
                        <ul>
                            <?php foreach ($entry['ingredients'] as $ingredient) {?> 
                              <li> <?php echo($ingredient); ?> </li>
                            <?php }?>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h5>Nutrition Facts</h5>
                        <ul>
                          <li> <?php echo("Calories: " . $entry['nutrition']['calories']); ?> </li>
                          <li> <?php echo("Carbs (g): " . $entry['nutrition']['carbsg']); ?> </li>
                          <li> <?php echo("Protein (g): " . $entry['nutrition']['proteing']); ?> </li>
                          <li> <?php echo("Sodium (mg): " . $entry['nutrition']['sodiummg']); ?> </li>
                          <li> <?php echo("Fat (g): " . $entry['nutrition']['fatg']); ?> </li>
                          <li> <?php echo("Sugar (g): " . $entry['nutrition']['sugarg']); ?> </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <br />
    <?php }?>
    </div>

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

