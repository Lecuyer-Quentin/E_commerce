<?php 
    $id = $_SESSION['user']->get_idUtilisateur();
    $users = new UtilisateurRepo($pdo);
    $user = $users->read_one($id);
?>

<main>
    <?php require_once 'views/menu/profile.php';?>
    <?php
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(isset($_POST['profile_nav'])){
            $page = $_POST['profile_nav'];
            switch($page){
                case 'Profil':
                    require_once 'views/profile/user/index.php';
                    break;
                case 'Commandes':
                    require_once 'views/profile/orders/index.php';
                    break;
                case 'Favoris':
                    require_once 'views/profile/favorites/index.php';
                    break;
                case 'Paramètres':
                    require_once 'views/profile/settings/index.php';
                    break;
                default:
                    require_once 'views/profile/user/index.php';
                    break;
            }
        }
    } else {
        require_once 'views/profile/user/index.php';
    }
    ?>
</main>