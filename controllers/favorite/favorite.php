<?php
session_start();

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    if(isset($_POST['favorite']) && !empty($_POST['favorite'])) {
        $fav_value = $_POST['favorite'];
    }

    if(isset($_POST['id']) && !empty($_POST['id']) && is_numeric($_POST['id'])) {
        $productId = $_POST['id'];
    }

    switch ($fav_value) {
        case 'add':
            if(isset($_SESSION['favorite'])) {
                if (!in_array($productId, $_SESSION['favorite'])) {
                    $_SESSION['favorite'][] = $productId;
                }
                setcookie('favorite', $productId, time() + 3600, '/');
            }
            break;
        case 'remove':
            if(isset($_SESSION['favorite'])) {
                if (($key = array_search($productId, $_SESSION['favorite'])) !== false) {
                    unset($_SESSION['favorite'][$key]);
                }
                setcookie('favorite', $productId, time() - 3600, '/');
            }
            break;
        default:
            break;
    }

    header(
        'Location: ' . $_SERVER['HTTP_REFERER']
    );
    exit;


} 
