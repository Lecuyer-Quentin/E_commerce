<?php
    require_once 'utils/get_JSON.php';
    require_once 'api/get_category.php';
    $categories = get_category();
    $add_data = get_JSON('data.json','forms', 'add_product');
    //$data['fields'][4]['options'] = $categories;
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
?>

    <?php echo $modal_add_product->modal_trigger(); ?>
