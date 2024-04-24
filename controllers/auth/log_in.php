<?php
session_start();
require_once '../../config/database.php';
require_once '../../models/UtilisateurRepo.php';
require_once '../../utils/error_message.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!isset($_POST['email']) || empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) 
    || (!isset($_POST['password']) || empty($_POST['password']))) {
        $response = array(
            'status' => 'error',
            'message' => translateErrorMessage('Error[CONNEXION]'),
        );
        echo json_encode($response);
        exit;
    } else {
        $email = strip_tags(htmlspecialchars($_POST['email']));
        $password = strip_tags(htmlspecialchars($_POST['password']));
    }
    
    try{
        $user = new UtilisateurRepo($pdo);
        $user->email = $email;
        $user->password = $password;
        $check_user = $user->log_in();

        if (!$check_user) {
            $error_login = translateErrorMessage('Error[CONNEXION]');
        } else {
            $_SESSION['user'] = $check_user;
            setcookie('user', $check_user->get_idUtilisateur(), time() + 3600, '/');
            $response = array(
                'status' => 'success',
                'message' => 'Connexion réussie. Vous allez être redirigé dans quelques secondes...',
                'redirect' => $_SERVER['HTTP_REFERER'],
            );
            echo json_encode($response);
            exit;
        }

    } catch (Exception $e) {
        $technical_error_message = $e->getMessage();
        $error_login = translateErrorMessage($technical_error_message);
    }

    if (!empty($error_login)) {
        $response = array(
            'status' => 'error',
            'message' => $error_login,
        );
        echo json_encode($response);
        exit;
    }


    if (isset($_SERVER['HTTP_REFERER'])) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    } else {
        header("Location: /");
    }
    exit;
}