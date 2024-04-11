<?php
include_once '../../utils/error_message.php';
include_once '../../models/Products.php';
require_once '../../config/database.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $error_delete = [];

   if(!isset($_POST['id']) || !is_numeric($_POST['id'])) {
        $error_delete[] = translateErrorMessage('Error[ID]');
    }
    if(!empty($error_delete)) {
        echo nl2br(htmlspecialchars(implode('\n', $error_delete)));
        exit;
   }

    $productId = $_POST['id'];

    try {
        $product = new Products($pdo);
        $product->id_produit = $productId;
        $product->delete();
        echo 'success';
        
    } catch (Exception $e) {
        $technical_error_message = $e->getMessage();
        $error_delete[] = translateErrorMessage($technical_error_message);
        echo nl2br(htmlspecialchars(implode('\n', $error_delete)));
        error_log($e->getMessage());
    }
    if(isset($_SERVER['HTTP_REFERER'])) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else {
        //header('Location: ../index.php?page=admin');
    }
    exit;

}