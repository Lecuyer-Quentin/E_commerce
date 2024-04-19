<?php 
    $products = new ProduitRepo($pdo);
    $products = $products->read_limit(6);  

    function display_products($products) {
        foreach($products as $product) {
            $data = $product->get_data();
            $card = new Card($data);
            echo $card->card_sm();
        }
    }
?>
<main class="container container-fluid">
    <section>
        <div class="card mb-3 text-white position-relative">
            <img src="assets/images/champs-de-lavande.jpg" class="card-img img-fluid" alt="Champs de lavande">
            <div class="card-img-overlay">
                <h1 class="card-title position-absolute top-0 start-0 p-3">
                    Bienvenue chez nous
                </h1>

                <div class="d-none d-lg-flex row w-50 position-absolute top-50 end-0 translate-middle-y gap-3">
                    <?php display_products($products); ?>
                </div> 
                <p class="card-text position-absolute bottom-0 end-0 px-3 py-2 bg-dark bg-opacity-75">
                    Votre boutique en ligne pour tous vos besoins en matière de maison, de famille et de vous-même.
                </p>
            </div>
        </div>
    </section>

    <section>
        <article class="d-lg-none">
            <h2>Nos Produits</h2>
            <p>Parcourez notre collection et trouvez tout ce dont vous avez besoin pour votre maison, votre famille et vous-même.</p>
            <div class="row mt-4 mb-4 text-center justify-content-center align-items-center gap-3">
                <?php display_products($products); ?>
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