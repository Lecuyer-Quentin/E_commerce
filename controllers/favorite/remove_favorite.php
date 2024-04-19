<?php
session_start();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['id'])) {
        $productId = $_POST['id'];

        if(isset($_SESSION['favorite'])) {
            if (($key = array_search($productId, $_SESSION['favorite'])) !== false) {
                unset($_SESSION['favorite'][$key]);
            }
        }
        // Destroy all cookies
        //if (isset($_SERVER['HTTP_COOKIE'])) {
        //    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
        //    foreach($cookies as $cookie) {
        //        $parts = explode('=', $cookie);
        //        $name = trim($parts[0]);
        //        setcookie($name, '', time()-1000);
        //        setcookie($name, '', time()-1000, '/');
        //    }
        //}

        //if(isset($_COOKIE['favorite'][$productId])) {
        //    setcookie('favorite', json_encode([$productId]), time() - 3600, '/');
        //}
    } 

    header(
        'Location: ' . $_SERVER['HTTP_REFERER']
    );
    exit;
}