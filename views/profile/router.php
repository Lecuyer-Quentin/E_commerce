<?php

if(isset($_POST['button'])){
    $button = $_POST['button'];
    switch($button){
        case 'Profil':
            require_once 'views/profile/index.php';
            break;
        case 'Commandes':
            require_once 'views/profile/orders/orders.php';
            break;
        case 'Paramètres':
            require_once 'views/profile/settings/settings.php';
            break;
        case 'Admin':
            require_once 'views/admin/index.php';

        default:
            require_once 'views/profile/index.php';
            break;
    }
}else{
    require_once 'views/profile/index.php';
}