<?php
$address = $user->get_numRue() . ' ' . $user->get_nomRue() . ', ' . $user->get_cPostal() . ', ' . $user->get_ville() . ', ' . $user->get_pays();
($user->get_idRole() == 2 || $user->get_idRole() == 3) ? $role = 'Administrateur' : $role = 'Utilisateur';
$user_name = $user->get_nom() . ' ' . $user->get_prenom();
?>



<section class="container container d-flex flex-column min-vh-100 align-items-start justify-content-start">

    <article class="card d-flex w-100 flex-column justify-content-between align-items-center p-3">

        <div class="d-flex w-100 flex-row justify-content-between align-items-center">

            <div class="d-flex flex-row align-items-center position-relative">
                <img src="<?php echo $user->get_image(); ?>" alt="User" width="100" height="100" class="rounded-circle p-1 border border-1 border-dark bg-info">
                <span class="position-absolute bottom-0 start-0 cursor-pointer" style="padding: 0.3rem; background-color: #f8f9fa; border-radius: 50%;">
                    <a type='button' data-bs-toggle='collapse' data-bs-target='#profile_collapse' aria-expanded='false' aria-controls='profile_collapse'>
                        <img src='assets/svg/chevron_down.svg' alt='arrow' width='20' height='20'>
                    </a>
                </span>
            </div>

            <div class="d-flex flex-column align-items-end">
                <h2><?php echo $user_name; ?></h2>
                <p><?php echo $user->get_email(); ?></p>
                <p><?php echo $role; ?></p>
            </div>
 
        </div>
            
        <div class="collapse pt-3" id="profile_collapse">
            <div class="card card-header">
                <h5>Informations Personnelles</h5>
            </div>
            <div class="card card-body">
                <p><?php echo $address; ?></p>
                <p><?php echo $user->get_date(); ?></p>
            </div>
        </div>
    </article>

    <article>
        <h2>Mes Commandes</h2>
        <?php require_once 'views/profile/orders/index.php';?>
    </article>
    <article>
        <div class="d-flex flex-row justify-content-between align-items-center mb-3">
            <h2>Mes Favoris</h2>
            <a href="index.php?page=products" class="btn btn-primary">Voir les produits</a>
        </div>
        <div class="d-flex flex-row flex-wrap justify-content-center align-items-center">
            <?php 
            if(isset($_SESSION['favorite'])) {
                foreach($_SESSION['favorite'] as $id) {
                    $product = new ProduitRepo($pdo);
                    $product = $product->read_one($id);
                    $data = $product->get_data();
                    $card = new Card($data);
                    echo $card->card_sm();
                    echo '<form action="controllers/favorite/remove_favorite.php" method="post">
                        <input type="hidden" name="id" value="'.$id.'">
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>';
                }
            } else {
                echo '<p>Vous n\'avez pas de favoris</p>';
            }
            ?>
        </div>
    </article>
    <article>
        <h2>Paramètres</h2>
        <?php require_once 'views/profile/settings/index.php';?>
    </article>
</section>
