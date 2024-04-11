<?php
    require_once 'components/button/logout_btn.php';
    require_once 'utils/get_JSON.php';
    $user_session = isset($_SESSION['user']) ? $_SESSION['user'] : null;
    $user_role = isset($_SESSION['user']->id_role) ? $_SESSION['user']->id_role : null;
    $isAdmin = $user_role == 1 || $user_role == 3 ? true : false;
    $page = isset($_GET['page']) && $_GET['page'] == 'admin' ? true : false;
    $login_data = get_JSON('data.json','forms', 'login');
    $admin_data = get_JSON('data.json', 'menu', 'admin');
    $admin_data = $admin_data['items'];
    $user_data = get_JSON('data.json', 'menu', 'user');
    $user_data = $user_data['items'];
    $register_data = get_JSON('data.json','forms', 'register');
    $login_form = new Form();
    $login_form->setData($login_data);
    $login_form->generateForm();
    $modal_login_data = [
        'btn_name' => 'Connexion',
        'btn_target' => '#login_modal',
        'modal_id' => 'login_modal',
        'modal_label' => 'login_modal_label',
        'modal_body' => $login_form->generateForm()
    ];
    $modal_login = new Modal($modal_login_data);
    $register_form = new Form();
    $register_form->setData($register_data);
    $register_form->generateForm();
    $modal_register_data = [
        'btn_name' => 'Inscription',
        'btn_target' => '#register_modal',
        'modal_id' => 'register_modal',
        'modal_label' => 'register_modal_label',
        'modal_body' => $register_form->generateForm()
    ];
    $modal_register = new Modal($modal_register_data);
    $cart = new Cart();
?>

<nav class="nav d-flex flex-row align-items-center">
    <div class="nav-item mx-2">
        <?php if($user_session): ?>
            <span class="">Bonjour <?php echo $_SESSION['user']->nom; ?></span>
        <?php else: ?>
            <?php echo $modal_login->modal_trigger(); ?>
        <?php endif; ?>
    </div>
    <?php if($isAdmin): ?>
        <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
                <img src="assets/svg/admin.svg" alt="Admin" width="20" height="20">
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="index.php?page=admin">Admin</a></li>
            </ul>
        </div>
    <?php endif; ?>
    <?php if($user_session): ?>
        <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
                <img src="assets/svg/user.svg" alt="Mon Compte" width="20" height="20">
            </a>
            <ul class="dropdown-menu">
                <?php foreach($user_data as $item): ?>
                    <li><a class="dropdown-item" href="<?php echo $item['value']; ?>"><?php echo $item['label']; ?></a></li>
                    <li><hr class="dropdown-divider"></li>
                <?php endforeach; ?>
                <li><hr class="dropdown-divider"></li>
                <li class="nav-item">
                    <?php echo logout_btn(); ?>
                </li>
            </ul>
        </div>
        <div class="nav-item">
            <?php echo $cart->cart_trigger(); ?>
        </div>
    <?php else: ?>
        <div class="nav-item">
            <?php echo $cart->cart_trigger(); ?>
        </div>
    <?php endif; ?>
</nav>