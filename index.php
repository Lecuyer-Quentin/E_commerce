<?php
require 'utils/autoload.php';
session_start();
require 'config/database.php';
require 'utils/get_JSON.php';
require 'utils/error_message.php';
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
    <?php 
    foreach($meta as $image) {
        if($image['target'] == $page) {
            echo '<link rel="website icon" type="png" href="'.$image['href'].'">';
    }}
    echo '<title>'.ucfirst($page).'</title>';
    ?>
    <link rel="stylesheet" type="text/css" href="assets/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    
    
</head>          


    <body class="container container-fluid">
        <?php 
            include_once 'layout/header.php';
            
            echo $modal_login->render();
            echo $modal_register->render();
            echo $cart->off_canvas();
        
            require_once 'router.php';
            include_once 'layout/footer.php';
        ?>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <script src="assets/js/ajax/favorite.js"></script>
            <script src="assets/js/ajax/log_in.js"></script>
            <script src="assets/js/ajax/register.js"></script>
            <script src="assets/js/ajax/contact.js"></script>
            <script src='assets/js/ajax/search.js'></script>
            <script src='assets/js/ajax/products/add.js'></script>
            <script src='assets/js/ajax/products/remove.js'></script>
            <script src='assets/js/ajax/users/remove.js'></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>