<?php 
require_once 'utils/autoload.php';
session_start();
require_once 'utils/get_JSON.php';
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$meta = get_JSON('data.json', 'images', 'meta');

// Display errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Log errors
ini_set('log_errors', 1);
ini_set('error_log', 'error/error.log');
//
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="assets/js/main.js" defer></script>

    <?php 
    foreach($meta as $image) {
        if($image['target'] == $page) {
            echo '<link rel="website icon" type="png" href="'.$image['href'].'">';
    }}
    echo '<title>'.ucfirst($page).'</title>';
    ?>
    
</head>          


    <body class="container">
        <?php include_once 'layout/header.php';?>
        <?php     
            echo $modal_login->render();
            echo $modal_register->render();
            echo $cart->off_canvas();
        ?>


        <?php require_once 'router.php';?>
            
        <?php include_once 'layout/footer.php';?>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>