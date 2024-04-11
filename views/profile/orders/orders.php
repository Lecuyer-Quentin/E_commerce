<?php
require_once 'api/orders/get_order.php';
require_once 'api/products/get_product.php';

$orders = get_orders_by_user($_SESSION['user']['id_utilisateur']);

if (count($orders) > 0) {
    display_orders($orders);
} else {
    echo "<h1>No orders found</h1>";
}


function display_orders($orders){
    foreach ($orders as $order) {
        //! Modifier le total pour que le calcul se fasse dans la base de données
        $total = 0;
        echo "<h1>Order n°" . $order['id_commande'] . "</h1>";

        echo "<h2>Products</h2>";
        echo "<ul>";
        foreach ($order['products'] as $product) {
            $p = get_product($product['id_produit']);
            $product_name = $p['nom'];
            $product_price = $p['prix'];
            $product_quantite = $product['quantite'];
            $total += $product_price * $product_quantite;
            echo "<li>" . $product_name . " - " . $product_price . "€ x"  . $product_quantite . "  Total: " . $product_price * $product_quantite . "€</li>";
        }
        echo "</ul>";
        echo "<h2>Total: " . $total . "€</h2>";
    }
}
