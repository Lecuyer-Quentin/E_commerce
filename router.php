<?php
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
$user_role = isset($_SESSION['user']) ? $_SESSION['user']->get_idRole() : null;


switch ($page) {
    case 'home':
        require_once 'views/home/index.php';
        break;
    case 'contact':
        require_once 'views/contact/index.php';
        break;
    case 'products':
        require_once 'views/products/router.php';
        break;
    case 'product':
        require_once 'views/product/index.php';
        break;
    case 'checkout':
        require_once 'views/checkout.php';
        break;
    case 'profile':
        if($user) {
            require_once 'views/profile/router.php';
        } else {
            require_once 'views/denied.php';
        }
        break;
    case 'admin':
        if( ($user_role == 2) || ($user_role == 3) ) {
            require_once 'views/admin/router.php';
        } else {
            require_once 'views/denied.php';
        }
        break;
    
    default:
        require_once 'views/404.php';
        break;
}