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


    //! Ne fonctionne pas correctement
    if(isset($_POST['image']) && !empty($_POST['image'])){
        if(isset($_FILES['image']['tmp_name'])) {
            //! a changer par DOCUMENT_ROOT
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
        } else {
            $error_products[] = translateErrorMessage('Error[IMAGE]');
        }
    } else {
        $image = '';
    }
    //!

    if(!empty($error_products)) {
        $response = [
            'status' => 'error',
            'message' => $error_products
        ];
        echo json_encode($response);
        exit;
    }

    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $categorie = $_POST['categorie'];
    $special = $_POST['special'];
    $image = $target_file;

    try {
        $product = new ProduitRepo($pdo);
        $product->nom = $nom;
        $product->description = $description;
        $product->prix = $prix;
        $product->idCategorie = $categorie;
        $product->image = $image;
        $product->idSpecial = $special;
        $product = $product->create();

        if(!$product) {
            $error_products[] = 'Error[CREATE_PRODUCT]';
        } else {
            $response = [
                'status' => 'success',
                'message' => 'Le produit a bien été ajouté',
                'redirect' => $_SERVER['HTTP_REFERER']
            ];
            echo json_encode($response);
            exit;
        }

    } catch (Exception $e) {
        $technical_error_message = $e->getMessage();
        $error_products[] = translateErrorMessage($technical_error_message);
    }

    if(isset($_SERVER['HTTP_REFERER'])) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    } else {
        header("Location: /");
    }
    exit;
}