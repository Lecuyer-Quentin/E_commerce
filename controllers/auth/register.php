<?php
session_start();
require_once '../../models/UtilisateurRepo.php';
require_once '../../config/database.php';
require_once '../../utils/error_message.php';


if($_SERVER['REQUEST_METHOD'] == "POST") {

    if (!isset($_POST['nom']) || empty($_POST['nom'])) {
        $error_register = translateErrorMessage('Error[NOM]');
    } elseif (!isset($_POST['prenom']) || empty($_POST['prenom'])) {
        $error_register = translateErrorMessage('Error[PRENOM]');
    } elseif (!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $error_register = translateErrorMessage('Error[EMAIL]');
    } elseif (!isset($_POST['password']) || empty($_POST['password'])) {
        $error_register = translateErrorMessage('Error[PASSWORD]');
    } elseif (!isset($_POST['password_confirm']) || empty($_POST['password_confirm'])) {
        $error_register = translateErrorMessage('Error[PASSWORD_CONFIRM]');
    } elseif (!isset($_POST['role']) || !is_numeric($_POST['role'])) {
        $error_register = translateErrorMessage('Error[ROLE]');
    } elseif($_POST['password'] !== $_POST['password_confirm']) {
        $error_register = translateErrorMessage('Error[PASSWORD_CONFIRM]');
        
    //? Améliorer la gestion du mot de passe en ajoutant des contraintes de complexité
    //} elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/', $_POST['password'])) {
    //    $error_register = translateErrorMessage('Error[PASSWORD_COMPLEXITY]');

    } else {
        $nom = strip_tags(htmlspecialchars($_POST['nom']));
        $prenom = strip_tags(htmlspecialchars($_POST['prenom']));
        $email = strip_tags(htmlspecialchars($_POST['email']));
        $password = strip_tags(htmlspecialchars($_POST['password']));
        $password_confirm = strip_tags(htmlspecialchars($_POST['password_confirm']));
        $role = strip_tags(htmlspecialchars($_POST['role']));
    }

    //! A deplacer dans le controller add_user
    if(isset($_POST['image']) && !empty($_POST['image'])) {
        
        if(isset($_FILES['image']['tmp_name'])) {
            //! a changer par DOCUMENT_ROOT
            $rep = '../../uploads/users/';
            if(!is_dir($rep)) {
                mkdir($rep, 0777, true);
            }
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $target_file = uniqid() . '.' . $extension;
            $upload = move_uploaded_file($_FILES['image']['tmp_name'], $rep.$target_file);
            if(!$upload) {
                //$error_register = translateErrorMessage('Error[UPLOAD_IMAGE]');
                $error_register = 'Erreur lors de l\'upload de l\'image';
            }else{
                $image = $target_file;
            }
        }else{
            //$error_register = translateErrorMessage('Error[UPLOAD_IMAGE]');
            $error_register = 'Erreur lors de l\'upload de l\'image';
        }
    } else {
        $image = '';
    }
    //!

    if(!empty($error_register)) {
        $response = array(
            'status' => 'error',
            'message' => $error_register,
        );
        echo json_encode($response);
        exit;
    }

    try{
        $user = new UtilisateurRepo($pdo);
        $user->nom = $nom;
        $user->prenom = $prenom;
        $user->email = $email;
        $user->password = $password_confirm;
        $user->idRole = $role;
        $user->image = $image;
        $new_user = $user->create();

        if(!$new_user) {
            $error_register = translateErrorMessage('Error[REGISTER]');
        } else {
            try{
                $user_to_log = new UtilisateurRepo($pdo);
                $user_to_log->email = $email;
                $user_to_log->password = $password;
                $user = $user_to_log->log_in();

                if(!$user) {
                    $error_register = translateErrorMessage('Error[LOGIN]');
                } else {
                    $_SESSION['user'] = $user;
                    setcookie('user', $user->get_idUtilisateur(), time() + 3600, '/');
                    $response = array(
                        'status' => 'success',
                        'message' => 'Votre compte a été créé avec succès',
                        'redirect' => $_SERVER['HTTP_REFERER'],
                    );
                    echo json_encode($response);
                    exit;
                }
            } catch (Exception $e) {
                $technical_error_message = $e->getMessage();
                $error_register = translateErrorMessage($technical_error_message);
            }
        }

    } catch (Exception $e) {
        $technical_error_message = $e->getMessage();
        $error_register = translateErrorMessage($technical_error_message);
    }

    if(isset($_SERVER['HTTP_REFERER'])) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    } else {
        header("Location: /");
    }
    exit;
}