<?php
require_once '../utils/error_message.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    if(!isset($_POST['nom']) || empty($_POST['nom'])) {
        $error = translateErrorMessage('Error[NOM]');
    } elseif(!isset($_POST['prenom']) || empty($_POST['prenom'])) {
        $error = translateErrorMessage('Error[PRENOM]');
    } elseif(!isset($_POST['email']) || empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $error = translateErrorMessage('Error[EMAIL]');
    } elseif(!isset($_POST['message']) || empty($_POST['message'])) {
        $error = translateErrorMessage('Error[MESSAGE]');
    } else {
        $nom = strip_tags(htmlspecialchars($_POST['nom']));
        $prenom = strip_tags(htmlspecialchars($_POST['prenom']));
        $email = strip_tags(htmlspecialchars($_POST['email']));
        $message = strip_tags(htmlspecialchars($_POST['message']));
    }

    if(!isset($error)) {
        $response = array(
            'status' => 'success',
            'message' => 'Votre message a bien été envoyé'
        );
        echo json_encode($response);
        exit;
    } else {
        $response = array(
            'status' => 'error',
            'message' => $error
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