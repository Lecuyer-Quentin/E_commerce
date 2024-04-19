<?php
session_start();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['id'])) {
        $productId = $_POST['id'];

        if(isset($_SESSION['favorite'])) {
            if (!in_array($productId, $_SESSION['favorite'])) {
                $_SESSION['favorite'][] = $productId;
            }
        } else {
            $_SESSION['favorite'] = [$productId];
        }

        //if(isset($_COOKIE['favorite'])) {
        //    setcookie('favorite', json_encode([$productId]), time() + 3600, '/');
        //}
    } 

    header(
        'Location: ' . $_SERVER['HTTP_REFERER']
    );
    exit;


} 
