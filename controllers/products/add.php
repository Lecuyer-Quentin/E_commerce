<?php
require_once '../../config/database.php';
include_once '../../utils/upload_image.php';
include_once '../../utils/error_message.php';
include_once '../../models/Products.php';

//? À corriger
//function check_image($image) {
//    $image_info = getimagesize($image['tmp_name']);
//    if($image_info === false) {
//        return false;
//    }else{
//        $image_mime = $image_info['mime'];
//        if (!in_array($image_mime, ['image/jpeg', 'image/png', 'image/gif'])) {
//            return false;
//        }
//    }
//    return true;
//}

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
    if(!isset($_FILES['image']) || empty($_FILES['image'])) {
        $error_products[] = translateErrorMessage('Error[IMAGE]');
    }    
    //if(!check_image($image)) {
    //    $error_products[] = translateErrorMessage('Error[INVALID_IMAGE_TYPE]');
    //}
    if(!empty($error_products)) {
        echo nl2br(htmlspecialchars(implode('\n', $error_products)));
        exit;
    }

    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $categorie = $_POST['categorie'];
    $image = $_FILES['image'];

    try {
        $product = new Products($pdo);
        $target_file = upload_image($image, '../../uploads/products/');
        $product->nom = $nom;
        $product->description = $description;
        $product->prix = $prix;
        $product->id_categorie = $categorie;
        $product->image = $target_file;
        $product->create();
        echo 'success';

    } catch (Exception $e) {
        $technical_error_message = $e->getMessage();
        $error_products[] = translateErrorMessage($technical_error_message);
        echo nl2br(htmlspecialchars(implode('/n', $error_products)));
    }
    exit;
}




    