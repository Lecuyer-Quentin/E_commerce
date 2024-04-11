<?php
require_once 'class/Form.php';
require_once 'api/products/get_product.php';
require_once 'api/get_category.php';
require_once 'utils/get_JSON.php';

if(isset($_POST['id'])){
    $id = $_POST['id'];
}else{
    $id = $_GET['id'];
}

//! Probable doublon de code a verifier
function display_category($category){
    foreach ($category as $key => $cat) {
        $category[$key]['nom'] = ucfirst($cat['nom']);
    }
    return $category;
}//!

function add_product_info($product){
    $category = get_category();
    $category = display_category($category);
    $data = get_JSON('data.json','forms', 'edit_product');
    $data['fields'][0]['value'] = $product['id_produit'];
    $data['fields'][1]['value'] = $product['nom'];
    $data['fields'][3]['value'] = $product['description'];
    $data['fields'][2]['value'] = $product['prix'];
    $data['fields'][4]['value'] = $product['description'];
    $data['fields'][5]['value'] = $product['id_categorie'];
    $data['fields'][5]['options'] = $category;
    return $data;
}

function edit_product(){
    global $id;
    $product = get_product($id);
    $data = add_product_info($product);
    $form = new Form();
    $form->setData($data);
    echo $form->generateForm();
}

edit_product();


