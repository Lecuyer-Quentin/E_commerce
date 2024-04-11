<?php
session_start();
require_once '../../models/Cart.php';
$cart = new Cart();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $cart->emptyCart();

    if(isset($_SERVER['HTTP_REFERER'])){
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }else{
        header('Location: ../index.php');
    }
    exit;
}else{
    die("Invalid request");
}
