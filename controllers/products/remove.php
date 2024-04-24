<?php
include_once '../../utils/error_message.php';
include_once '../../models/ProduitRepo.php';
require_once '../../config/database.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {

   if(!isset($_POST['id']) || !is_numeric($_POST['id'])) {
        $error_delete = translateErrorMessage('Error[ID]');
    }
    if(!empty($error_delete)) {
        $response = [
            'status' => 'error',
            'message' => $error_delete
        ];
        echo json_encode($response);
        exit;
   }

    $productId = $_POST['id'];

    try {
        //$product = new Products($pdo);
        //$product->id_produit = $productId;
        //$product->delete();
        $response = [
            'status' => 'success',
            'message' => 'Le produit ' . $productId . ' a été supprimé avec succès.'
        ];
        echo json_encode($response);
        exit;
        
    } catch (Exception $e) {
        $technical_error_message = $e->getMessage();
        $error_delete[] = translateErrorMessage($technical_error_message);
    }

    if(isset($_SERVER['HTTP_REFERER'])) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else {
        //header('Location: ../index.php?page=admin');
    }
    exit;

}