
<main>
    <?php require_once 'views/menu/products.php'; ?>
    <?php
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(isset($_POST['category_nav'])){
                $idCategorie = $_POST['category_nav'];
                $products = new ProduitRepo($pdo);
                $products = $products->read_by_category($idCategorie);
            } else {
                $products = new ProduitRepo($pdo);
                $products = $products->read_limit(6);
            }

        } else {
            $products = new ProduitRepo($pdo);
            $products = $products->read_limit(6);
        } 
    ?>
    
    <section class="row mt-4 mb-4 text-center justify-content-center align-items-center gap-3">
        <?php 
            if(!empty($products)) {
                foreach($products as $product):
                    $data = $product->get_data();
                    $col = '<div class="col col-md-4 col-sm-6 mb-4">';
                        $card = new Card($data);
                        echo $card->card_sm();
                    $col .= '</div>';
                endforeach;
            } else {
                echo '<div class="col-12 text-center">Aucun produit trouvé</div>';
            }
        ?>
    </section>
</main>