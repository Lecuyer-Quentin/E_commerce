<?php
    require_once 'utils/get_JSON.php';
    require_once 'utils/display_category.php';
    global $pdo;
    $products = new Products($pdo);
    $products = $products->read();
    $products = display_category($products);
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
        <?php require_once 'add.php';?>
    </span>
    <?php echo $table->generateTable(); ?>
</article>
