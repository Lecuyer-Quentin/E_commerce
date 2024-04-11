<?php 

require_once 'api/get_category.php';
function display_category($products){
    $category = get_category();
    foreach ($products as $key => $product) {
        foreach ($category as $cat) {
            if ($product->id_categorie == $cat['id_categorie']) {
                $products[$key]->id_categorie = ucfirst($cat['nom']);
            }
        }
    }
    return $products;
}