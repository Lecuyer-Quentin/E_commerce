<?php 
    require_once 'config/database.php';
    require_once 'utils/get_JSON.php';
    require_once 'utils/get_image.php';

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $products = new Products($pdo);
        $products->id_produit = $id;
        $product = $products->read_single();
        $product->image = get_image($product->id_produit);
        $products->id_categorie = $product->id_categorie;
        $others_products = $products->read_by_category();  
    }else{
        $product = null;
    } 
?>

<main>
<?php if ($product !== null): ?>

    <section class="container d-flex flex-column min-vh-100 align-items-center flex-xl-row justify-content-xl-around align-items-xl-center">
        <article>
            <h1><?php echo $product->nom; ?></h1>
            <?php echo $product->card_md(); ?>
        </article>
        <aside>
            <?php echo $product->accordion(); ?>
        </aside>
    </section>
    <section class="container d-flex flex-column min-vh-100 align-items-center">
        <h2>Produits similaires</h2>
        <p>Vous aimerez peut-être aussi</p>
        <article class="row row-cols-2 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-2">
            <?php foreach($others_products as $product): 
                $product->image = get_image($product->id_produit);
            ?>
            <div class="col d-flex justify-content-center align-items-center">
                <?php echo $product->card_sm(); ?>
            </div>
            <?php endforeach; ?>
        </article>
    </section>

    <?php else: ?>
            <h1>Produit non trouvé</h1>
    <?php endif; ?>
</main>