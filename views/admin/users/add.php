<?php
    require_once 'utils/get_JSON.php';
    require_once 'api/get_roles.php';
    $roles = get_roles();
    $data = get_JSON('data.json','forms', 'add_user');
    $data['fields'][5]['options'] = $roles;
    $form = new Form();
    $form->setData($data);
    $form->generateForm();
    $modal_data = [
        'btn_name' => 'Ajouter un utilisateur',
        'btn_target' => '#add_user_modal',
        'modal_id' => 'add_user_modal',
        'modal_label' => 'add_user_modal_label',
        'modal_body' => $form->generateForm()
    ];
    $modal_add_user = new Modal($modal_data);
?>

    <?php echo $modal_add_user->modal_trigger(); ?>
