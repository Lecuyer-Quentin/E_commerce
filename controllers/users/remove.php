<?php
include_once '../../models/UtilisateurRepo.php';
include_once '../../config/database.php';
include_once '../../utils/error_message.php';


if($_SERVER["REQUEST_METHOD"] == "POST") {

    if(!isset($_POST["id"]) || !is_numeric($_POST["id"])) {
        $error_delete = translateErrorMessage("Error[ID]");
    }
    if(!empty($error_delete)) {
        $response = [
            "status" => "error",
            "message" => $error_delete
        ];
        echo json_encode($response);
        exit;
    }

    $userId = $_POST["id"];

    try {
        //$user = new UtilisateurRepo($pdo);
        //$user->delete($userId);
        $response = [
            "status" => "success",
            "message" => "L'utilisateur " . $userId . " a été supprimé avec succès."
        ];
        echo json_encode($response);
        exit;
        
    } catch (Exception $e) {
        $technical_error_message = $e->getMessage();
        $error_delete[] = translateErrorMessage($technical_error_message);
    }

    exit;
}