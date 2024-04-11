<?php
require_once 'config/database.php';
function get_image($productId){

    global $pdo;
    $p = new Products($pdo);
    $p->id_produit = $productId;
    $product = $p->read_single();
    if(isset($product->image)){
        $slash = strstr($product->image, '/');
        $image_path = substr($slash, 1); // This will get everything after the first slash
        return $image_path;
    }else{
        return 'uploads/default.jpg';
    }
}

