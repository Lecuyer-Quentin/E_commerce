<?php

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $products = new ProduitRepo($pdo);
        $product = $products->read_one($id);
    }else{
        $product = null;
    }

    $cat = $product->get_categorie();
    var_dump($cat);
    $others_products = new ProduitRepo($pdo);
    //! A améliorer
    $others_products = $others_products->read_by_category($cat[0]);
?>

<main>    
<?php if (!empty($product)): ?>
    <section class="container d-flex flex-column min-vh-100 align-items-center flex-xl-row justify-content-xl-around align-items-xl-center">
        <article>
            <h1><?php echo $product->get_nom(); ?></h1>
            <?php 
                $data = $product->get_data();
                $card = new Card($data);
                echo $card->card_md();
            ?>
        </article>
        <aside>
            <?php echo $product->accordion(); ?>
        </aside>
    </section>
    <section class="container d-flex flex-column mt-5 align-items-center">
        <h2>Produits similaires</h2>
        <p>Vous aimerez peut-être aussi</p>
        <article class="d-flex flex-row flex-wrap justify-content-center">
            <?php foreach($others_products as $product): ?>
            <div class="col d-flex justify-content-center align-items-center m-2">
                <?php 
                    $data = $product->get_data();
                    $card = new Card($data);
                    echo $card->card_sm();
                ?>
            </div>
            <?php endforeach; ?>
        </article>
    </section>

    <?php else: ?>
            <h1>Produit non trouvé</h1>
    <?php endif; ?>
</main>