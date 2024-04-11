<?php
include_once '../models/Products.php';
include_once '../models/Table.php';
include_once '../config/database.php';
include_once '../utils/error_message.php';


if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $error_search = [];
    if(!isset($_POST['search']) || empty($_POST['search'])) {
        $error_search[] = translateErrorMessage('Error[SEARCH]');
        exit;
    }
    $search = $_POST['search'];
    $search = stripslashes($search);
    $search = htmlspecialchars($search);
    $search = strip_tags($search);
    $search = trim($search);
    

    try{
        $product = new Products($pdo);
        $product->keywords = $search;
        $products = $product->search();
        if(!$products) {
            $error_search[] = translateErrorMessage('Error[SEARCH]');
            echo nl2br(htmlspecialchars(implode('\n', $error_search)));
            exit;
        }
        foreach($products as $product) {
            echo $product->card_search();            
        }
        
    } catch (Exception $e) {
        $technical_error_message = $e->getMessage();
        $error_search[] = translateErrorMessage($technical_error_message);
        echo nl2br(htmlspecialchars(implode('\n', $error_search)));
        error_log($e->getMessage());
    }
}
