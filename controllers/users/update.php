<?php 
include_once '../../utils/error_message.php';
include_once '../../models/UtilisateurRepo.php';
include_once '../../config/database.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $error_update = [];

    if(!isset($_POST['id']) || !is_numeric($_POST['id'])) {
        $error_update[] = translateErrorMessage('Error[ID]'); 
    }
    if(!isset($_POST['nom']) || empty($_POST['nom'])) {
        $error_update[] = translateErrorMessage('Error[NOM]'); 
    }
    if(!isset($_POST['prenom']) || empty($_POST['prenom'])) {
        $error_update[] = translateErrorMessage('Error[PRENOM]'); 
    }
    if(!isset($_POST['email']) || empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $error_update[] = translateErrorMessage('Error[EMAIL]'); 
    }
    if(!isset($_POST['role']) || !is_numeric($_POST['role'])) {
        $error_update[] = translateErrorMessage('Error[ROLE]'); 
    }
    if(!empty($error_update)) {
        echo nl2br(htmlspecialchars(implode('\n', $error_update)));
        exit;
    }

    $id = intval($_POST['id']);
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];    
    $role = intval($_POST['role']);

    try{
        $user_to_update = new UtilisateurRepo($pdo);
        $user_to_update->nom = $nom;
        $user_to_update->prenom = $prenom;
        $user_to_update->email = $email;
        $user_to_update->idRole = $role;
        $user_to_update->update($id);



        //? Utiliser par Ajax pour savoir si la requête a fonctionné
        echo 'success';
        //? À modifier

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