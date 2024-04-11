<?php 
    include_once 'config/database.php';
    include_once 'utils/get_image.php';
    $products = new Products($pdo);
    $products->limit = 6;
    $products = $products->read_limit();    
?>
<main>
    <section class="container mt-5">
        <h1>Bienvenue sur notre boutique en ligne</h1>
        <p>Notre boutique en ligne propose une large gamme de produits de qualité à des prix compétitifs.</p>
        <p>Parcourez notre collection et trouvez tout ce dont vous avez besoin pour votre maison, votre famille et vous-même.</p>
        <article>
            <h2>Nos Produits</h2>
            <div class="row mt-4 mb-4 text-center justify-content-center align-items-center gap-3">
                <?php foreach($products as $product):
                    $col = '<div class="col col-md-4 col-sm-6 mb-4">';
                            //$product->image = get_image($product->image);
                            echo $product->card_hero();
                    $col .= '</div>';
                endforeach; ?>
            </div>          
        </article>
    </section>

    <section>
        <h2>Notre Équipe</h2>
        <article>
            <p>Notre équipe est composée de professionnels dévoués qui travaillent dur pour vous offrir une expérience de magasinage en ligne exceptionnelle.</p>
            <p>Nous sommes là pour vous aider à trouver les meilleurs produits, à répondre à vos questions et à résoudre tout problème que vous pourriez rencontrer.</p>
        </article>
    </section>

    <section>
        <h2>Notre Engagement</h2>
        <article>
            <p>Nous nous engageons à offrir un excellent service client, des produits de qualité et des prix compétitifs à tous nos clients.</p>
            <p>Si vous avez des questions, des préoccupations ou des commentaires, n'hésitez pas à nous contacter. Nous sommes là pour vous aider.</p>
        </article>
    </section>
</main>