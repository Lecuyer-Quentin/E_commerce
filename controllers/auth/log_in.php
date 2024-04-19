<?php
session_start();
require_once '../../config/database.php';
require_once '../../models/UtilisateurRepo.php';
require_once '../../utils/error_message.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $error_login = [];

    if (!isset($_POST['email']) || empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $error_login[] = translateErrorMessage('Error[EMAIL]');
    }
    if (!isset($_POST['password']) || empty($_POST['password'])) {
        $error_login[] = translateErrorMessage('Error[PASSWORD]');
    }
    
    $email = $_POST['email'];
    $password = $_POST['password'];

    try{
        $user = new UtilisateurRepo($pdo);
        $user->email = $email;
        $user->password = $password;
        $check_user = $user->log_in();

        if (!$check_user) {
            $error_login[] = translateErrorMessage('Error[CONNEXION]');
        } else {
            $_SESSION['user'] = $check_user;
            setcookie('user', $check_user->get_idUtilisateur(), time() + 3600, '/');
            echo 'success';
        }

    } catch (Exception $e) {
        $technical_error_message = $e->getMessage();
        $error_login[] = translateErrorMessage($technical_error_message);
    }

    if (!empty($error_login)) {
        echo nl2br(htmlspecialchars(implode ('\n', $error_login)));
        exit;
    }
    exit;
}