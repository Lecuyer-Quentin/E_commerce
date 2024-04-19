<?php
session_start();
require_once '../../models/Cart.php';
require_once '../../models/ProduitRepo.php';
require_once '../../config/database.php';

$cart = new Cart();
global $pdo;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['id']) || !is_numeric($_POST['id']) || !isset($_POST['quantity']) || !is_numeric($_POST['quantity'])) {
        die("Invalid request");
    }
    $productId = $_POST['id'];
    $quantity = $_POST['quantity'];

    $ps = new ProduitRepo($pdo);
    $product = $ps->read_one($productId);
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
