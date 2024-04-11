<?php
include_once '../../utils/error_message.php';
include_once '../../models/Products.php';
include_once '../../config/database.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $error_update = [];

    if(!isset($_POST['id']) || !is_numeric($_POST['id'])) {
        $error_update[] = translateErrorMessage('Error[ID]'); 
    }
    if(!isset($_POST['nom']) || empty($_POST['nom'])) {
        $error_update[] = translateErrorMessage('Error[NAME]'); 
    }
    if(!isset($_POST['prix']) || !is_numeric($_POST['prix'])) {
        $error_update[] = translateErrorMessage('Error[PRIX]'); 
    }
    if(!isset($_POST['description']) || empty($_POST['description'])) {
        $error_update[] = translateErrorMessage('Error[DESCRIPTION]'); 
    }
    if(!empty($error_update)) {
        echo nl2br(htmlspecialchars(implode('/n', $error_update)));
        exit;
    }

    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $prix = $_POST['prix'];
    $description = $_POST['description'];
    $image = $_POST['image'];
    $id_categorie = $_POST['id_categorie'];
    
    try {
        $product = new Products($pdo);
        $product->id_produit = $id;
        $product->nom = $nom;
        $product->prix = $prix;
        $product->description = $description;
        $product->image = $image;
        $product->id_categorie = $id_categorie;
        $product->update();
        echo 'success';

    } catch (Exception $e) {
        $technical_error_message = $e->getMessage();
        $error_update[] = translateErrorMessage($technical_error_message);
        echo nl2br(htmlspecialchars(implode('\n', $error_update)));
        error_log($e->getMessage());
    }

    if($_SERVER['HTTP_REFERER']) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else {
        //header('Location: /admin');
    }
    exit;
}