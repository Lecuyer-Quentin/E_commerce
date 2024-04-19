<?php
    $products = new ProduitRepo($pdo);
    $products = $products->read();
    $nbr = count($products);
    $data = get_JSON('data.json','tables', 'products');
    $footer[] = ['type' => 'p', 'content' => 'Nombre de produits: ' . $nbr];
    $data['items'] = $products;
    $data['footer'] = $footer;
    $table = new Table();
    $table->setData($data);
    $table->generateTable();
?>

<article class="position-relative">
    <span class="position-absolute top-0 end-0 mt-5">
        <?php require_once 'add.php';
        echo $modal_add_product->modal_trigger();
        ?>
    </span>
    <?php echo $table->generateTable(); ?>
</article>
