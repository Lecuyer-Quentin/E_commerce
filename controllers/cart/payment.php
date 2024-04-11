<?php
session_start();
require_once '../api/orders/create_order.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $products = [];

    if((!isset($_POST['total'])  || !is_numeric($_POST['total']))) {
        die('Invalid total');
    }
    
    if(!isset($_SESSION['cart'])) {
        die('Cart is empty');
    }
    if(!isset($_SESSION['user'])) {
        die('You must be logged in to place an order');
    }
    
    $user_id = $_SESSION['user']['id_utilisateur'];

    foreach($_SESSION['cart'] as $product_id => $quantity) {
        $products[] = ['id_produit' => $product_id, 'quantity' => $quantity];
    }

    $order = [
        'id_utilisateur' => $user_id,
        'total' => $_POST['total'],
        'products' => $products,
    ];

    try{
        //create_order($order);
        unset($_SESSION['cart']);
        header('Location: ../index.php?page=profile');
        exit;

    } catch (Exception $e) {
        die('Error: ' . $e->getMessage());
    }
} else {
    die('Invalid request');
}

