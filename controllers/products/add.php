<?php
include_once '../../utils/error_message.php';
include_once '../../models/ProduitRepo.php';
require_once '../../config/database.php';


if($_SERVER["REQUEST_METHOD"] == "POST") {
    $error_products = [];

    if(!isset($_POST['nom']) || empty($_POST['nom'])) {
        $error_products[] = translateErrorMessage('Error[NOM]');
    }
    if(!isset($_POST['description']) || empty($_POST['description'])) {
        $error_products[] = translateErrorMessage('Error[DESCRIPTION]');
    }
    if(!isset($_POST['prix']) || !is_numeric($_POST['prix']) || empty($_POST['prix'])) {
        $error_products[] = translateErrorMessage('Error[PRIX]');
    }
    if(!isset($_POST['categorie']) || !is_numeric($_POST['categorie']) || empty($_POST['categorie'])) {
        $error_products[] = translateErrorMessage('Error[CATEGORIE]');
    }
    if(!isset($_POST['special']) || !is_numeric($_POST['special']) || empty($_POST['special'])) {
        $error_products[] = translateErrorMessage('Error[SPECIAL]');
    }

    if(isset($_FILES['image']['tmp_name'])) {
        $rep = '../../uploads/products/';
        if(!is_dir($rep)) {
            mkdir($rep, 0777, true);
        }
        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $target_file = uniqid() . '.' . $extension;
        $upload = move_uploaded_file($_FILES['image']['tmp_name'], $rep.$target_file);
        if(!$upload) {
            $error_products[] = translateErrorMessage('Error[UPLOAD_IMAGE]');
        }else{
            $image = $target_file;
        }
    }else{
        $error_products[] = 'Error[IMAGE]';
    }

    if(!empty($error_products)) {
        echo nl2br(htmlspecialchars(implode('\n', $error_products)));
        exit;
    }

    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $categorie = $_POST['categorie'];
    $special = $_POST['special'];

    try {
        $product = new ProduitRepo($pdo);
        $product->nom = $nom;
        $product->description = $description;
        $product->prix = $prix;
        $product->idCategorie = $categorie;
        $product->image = $image;
        $product->idSpecial = $special;
        $product->create();
        echo 'success';

    } catch (Exception $e) {
        $technical_error_message = $e->getMessage();
        $error_products[] = translateErrorMessage($technical_error_message);
        echo nl2br(htmlspecialchars(implode('/n', $error_products)));
    }
    exit;

}