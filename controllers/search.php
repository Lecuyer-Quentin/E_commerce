<?php
include_once '../models/ProduitRepo.php';
include_once '../models/Card.php';
include_once '../config/database.php';
include_once '../utils/error_message.php';


if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(!isset($_POST['search']) || empty($_POST['search'])) {
        $response = array(
            "status" => "error",
            "message" => "Veuillez saisir un terme de recherche"
        );
        echo json_encode($response);
        exit;
    }else {
        $search = $_POST['search'];
        $search = stripslashes($search);
        $search = htmlspecialchars($search);
        $search = strip_tags($search);
        $search = trim($search);
    }

    try{
        $product = new ProduitRepo($pdo);
        $products = $product->search($search);
        if(!$products) {
            $error_search = 'Aucun résultat trouvé';
        } else {
            $results = array();
            foreach($products as $product) {
                $data = $product->get_data();
                $card = new Card($data);
                $results[] = $card->card_search();
            }
            $response = array(
                "status" => "success",
                "results" => $results
            );
            echo json_encode($response);
            exit;
        }

    } catch (Exception $e) {
        $technical_error_message = $e->getMessage();
        $error_search = translateErrorMessage($technical_error_message);
    }

    if(!empty($error_search)) {
        $response = array(
            "status" => "error",
            "message" => $error_search
        );
        echo json_encode($response);
        exit;
    }

    if(isset($_SERVER['HTTP_REFERER'])) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    } else {
        header("Location: /");
    }
    exit;
}