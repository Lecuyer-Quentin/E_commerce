<?php 
    require_once 'utils/get_JSON.php';
    $contact_data = get_JSON('data.json', 'forms', 'contact');
    $contact_form = new Form();
    $contact_form->setData($contact_data);
    $adresse_info = [
        "name"=> "La Boutique",
        "street" => "123 Fake Street",
        "zip" => "12345",
        "city" => "Fake City",
        "country" => "Fake Country",
        "telephone" => "0123456789",
        "email" => "fake.email@fake.com",
        "opening_hours" => "Monday to Friday, 9am to 6pm"
    ];
    $iframe_src = 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2903.0000000000005!2d5.377853870391846!3d43.48868942260742!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12c9c7f1b1b1b1b1%3A0x12c9c7f1b1b1b1b1!2sMarseille%20Provence%20Airport!5e0!3m2!1sen!2sfr!4v1623686820001!5m2!1sen!2sfr';
?>

<main>
    <section class="container mt-5">
        <h2>La Boutique</h2>
        <article>
            <p>Pour toute question ou renseignement, veuillez nous contacter à l\'aide du formulaire ci-dessous.</p>
            <p>Nous vous recontacterons dans les plus brefs délais.</p>
        </article>
        <article class='d-flex justify-content-center'>
            <?php echo $contact_form->generateForm(); ?>
        </article>
    </section>

    <section class="container mt-5">
        <h2>Our location</h2>
        <article>
            <div id='map'>
                <iframe src='<?php echo $iframe_src; ?>' width='100%' height='100%' style='border-radius: 3px;' frameborder='0' style='border:0' allowfullscreen='' loading='lazy'></iframe>
            </div>
        </article>
        <article>
            <aside>
                <p>
                    <strong><?php echo $adresse_info['name']; ?></strong><br>
                    <?php echo $adresse_info['street']; ?><br>
                    <?php echo $adresse_info['zip']; ?> <?php echo $adresse_info['city']; ?><br>
                    <?php echo $adresse_info['country']; ?><br>
                    <br>
                    Telephone: <a href='tel:<?php echo $adresse_info['telephone']; ?>'><?php echo $adresse_info['telephone']; ?></a><br>
                    Email: <a href='mailto:<?php echo $adresse_info['email']; ?>'><?php echo $adresse_info['email']; ?></a><br>
                    Opening hours: <?php echo $adresse_info['opening_hours']; ?><br>
                </p>
            </aside>
        </article>
    </section>

</main>