<?php
session_start();
require_once '../../models/UtilisateurRepo.php';
require_once '../../config/database.php';
require_once '../../utils/error_message.php';


if($_SERVER['REQUEST_METHOD'] == "POST") {
    $error_register = [];
    $hashed_password = null;

    if(!isset($_POST['nom']) || empty($_POST['nom'])) {
        $error_register[] = translateErrorMessage('Error_001[NOM]');
    }
    if(!isset($_POST['prenom']) || empty($_POST['prenom'])) {
        $error_register[] = translateErrorMessage('Error[PRENOM]');
    }
    if(!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $error_register[] = translateErrorMessage('Error[EMAIL]');
    }
    if(!isset($_POST['password']) || empty($_POST['password'])) {
        $error_register[] = translateErrorMessage('Error[PASSWORD]');
    }
    if(!isset($_POST['password_confirm']) || empty($_POST['password_confirm'])) {
        $error_register[] = translateErrorMessage('Error[PASSWORD_CONFIRM]');
    }
    if(!isset($_POST['role']) || !is_numeric($_POST['role'])) {
        $error_register[] = translateErrorMessage('Error[ROLE]');
    }
    //? Améliorer la gestion du mot de passe en ajoutant des contraintes de complexité
    //if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/', $password)) {
    //     $error_register[] = translateErrorMessage('Error[PASSWORD_COMPLEXITY]');
    //}
    if(isset($_FILES['image']['tmp_name'])) {
        $rep = '../../uploads/users/';
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

    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];
    $role = $_POST['role'];

    if($password !== $password_confirm) {
        $error_register[] = translateErrorMessage('Error[PASSWORD_CONFIRM]');   
    }
    if(!empty($error_register)) {
        echo nl2br(htmlspecialchars(implode('\n', $error_register)));
        exit;
    }

    //! Password comfirm Problrme !//
    try{
        $user = new UtilisateurRepo($pdo);
        $user->nom = $nom;
        $user->prenom = $prenom;
        $user->email = $email;
        $user->password = $password_confirm;
        $user->idRole = $role;
        $user->image = $image;
        $user->create();
        echo 'success';

    } catch (Exception $e) {
        $technical_error_message = $e->getMessage();
        $error_register[] = translateErrorMessage($technical_error_message);
    }
    
    exit;
}
