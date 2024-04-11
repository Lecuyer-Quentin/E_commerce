<?php
session_start();
require_once '../../models/Cart.php';
require_once '../../models/Products.php';
require_once '../../config/database.php';

$cart = new Cart();
global $pdo;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['id']) || !is_numeric($_POST['id']) || !isset($_POST['quantity']) || !is_numeric($_POST['quantity'])) {
        die("Invalid request");
    }
    $productId = $_POST['id'];
    $quantity = $_POST['quantity'];

    $ps = new Products($pdo);
    $ps->id_produit = $productId;
    $product = $ps->read_single();
    if (!$product) {
        die("Product not found");
    }

    $cart->addToCart($product, $quantity);

    if (isset($_SERVER['HTTP_REFERER'])) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else {
        header('Location: ../index.php');
    }
    exit;
} else {
    die("Invalid request");
}
