<?php
session_start();
require_once '../../models/Cart.php';
$cart = new Cart();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['id']) || !is_numeric($_POST['id']) || !isset($_POST['quantity']) || !is_numeric($_POST['quantity'])) {
        die("Invalid request");
    }
    $productId = $_POST['id'];
    $quantity = $_POST['quantity'];

    $cart->removeFromCart($productId, $quantity);

    if (isset($_SERVER['HTTP_REFERER'])) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else {
        header('Location: ../index.php');
    }
    exit;
} else {
    die("Invalid request");
}
