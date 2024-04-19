<?php
    global $pdo;
    $add_data = get_JSON('data.json','forms', 'add_product');
    $categories = new CategorieRepo($pdo);
    $categories = $categories->read();
    $special = new SpecialRepo($pdo);
    $special = $special->read();
    $add_data['fields'][4]['options'] = $categories;
    $add_data['fields'][5]['options'] = $special;
    $add_form = new Form();
    $add_form->setData($add_data);
    $add_form->generateForm();
    $modal_add_data = [
        'btn_name' => 'Ajouter un produit',
        'btn_target' => '#add_product_modal',
        'modal_id' => 'add_product_modal',
        'modal_label' => 'add_product_modal_label',
        'modal_body' => $add_form->generateForm()
    ];
    $modal_add_product = new Modal($modal_add_data);
    $modal_add_product->modal_trigger();
    echo $modal_add_product->render();
