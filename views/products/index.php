<main>
    <h1>Tous les produits</h1>
    <section style="display: flex; flex-direction: row; flex-wrap: wrap; justify-content: center; align-items: center; gap: 1rem; background-color: #f5f5f5; border-radius: .5rem; box-shadow: 0 0 1rem #000; width: 90% ">
        <?php 
        require_once 'config/database.php';
        $products = new Products($pdo);
        $products = $products->read();
        foreach ($products as $product) {
            $card = '<div class="card card-small">';
            $card .= '<img src="' . $product->image . '" class="card-img-top" alt="' . $product->nom . '">';
            $card .= '<div class="card-body">';
            $card .= '<h5 class="card-title">' . $product->nom . '</h5>';
            $card .= '<p class="card-text">' . $product->description . '</p>';
            $card .= '<p class="card-text"><small class="text-muted">' . $product->prix . ' €</small></p>';
            $card .= '</div>';
            $card .= '<a href="index.php?page=product&id=' . $product->id_produit . '" class="btn btn-primary">Voir plus</a>';
            $card .= '</div>';
            echo $card;
        }
        ?>
    </section>
</main>