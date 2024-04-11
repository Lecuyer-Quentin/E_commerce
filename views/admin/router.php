<?php

if(isset($_POST['button'])){
    $value = $_POST['button'];
    switch($value){
        case 'dashboard':
            require_once 'views/admin/dashboard.php';
            break;
        case 'users':
            require_once 'views/admin/users/index.php';
            break;
        case 'products':
            require_once 'views/admin/products/index.php';
            break;
        case 'orders':
            require_once 'views/admin/orders/index.php';
            break;
        case 'settings':
            require_once 'views/admin/settings/settings.php';
            break;
        case 'back':
            $_SERVER['HTTP_REFERER'];
            break;
            
        default:
            require_once 'views/admin/dashboard.php';
            break;
    }
} else {
    require_once 'views/admin/dashboard.php';
}