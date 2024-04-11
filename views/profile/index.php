<?php 
    require_once 'views/menu/user.php';
    require_once 'config/database.php';
    $id = $_SESSION['user']->id_utilisateur;
    $users = new Users($pdo);
    $users->id_utilisateur = $id;
    $user = $users->read_single();
?>

<main>
    <section class="container container d-flex flex-column min-vh-100 align-items-start justify-content-start">
    <?php echo user_menu(); ?>

        <h1>Mon Profil</h1>
        <article>
            <h2>Mes Informations</h2>
            <p>Nom: <?php echo $user->nom; ?></p>
            <p>Prénom: <?php echo $user->prenom; ?></p>
            <p>Email: <?php echo $user->email; ?></p>
        </article>
        <article>
            <h2>Mes Commandes</h2>
            <p>Vous n'avez pas encore passé de commande.</p>
        </article>
    </section>
</main>