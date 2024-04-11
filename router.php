<?php
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
$user_role = isset($_SESSION['user']->id_role) ? $_SESSION['user']->id_role : null;


switch ($page) {
    case 'home':
        require_once 'views/home/index.php';
        break;
    case 'contact':
        require_once 'views/contact/index.php';
        break;
    case 'products':
        require_once 'views/products/index.php';
        break;
    case 'product':
        require_once 'views/product/index.php';
        break;
    case 'cart':
        require_once 'views/cart/index.php';
        break;
    case 'checkout':
        require_once 'views/checkout.php';
        break;
    case 'login':
        require_once 'views/auth/login.php';
        break;
    case 'register':
        require_once 'views/auth/register.php';
        break;
    case 'profile':
        if($user) {
            require_once 'views/profile/index.php';
        } else {
            require_once 'views/denied.php';
        }
        break;
    case 'admin':
        if( ($user_role == 1) || ($user_role == 3) ) {
            require_once 'views/admin/index.php';
        } else {
            require_once 'views/denied.php';
        }
        break;
    
    default:
        require_once 'views/404.php';
        break;
}