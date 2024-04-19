<?php

if(isset($_POST['id'])){
    $id = $_POST['id'];
}else{
    $id = $_GET['id'];
}

function add_user_info($user){
    $role = get_roles();
    $role = display_role($role);
    $data = get_JSON('data.json','forms', 'edit_user');
    $data['fields'][0]['value'] = $user['id_utilisateur'];
    $data['fields'][1]['value'] = $user['nom'];
    $data['fields'][2]['value'] = $user['prenom'];
    $data['fields'][3]['value'] = $user['email'];
    $data['fields'][6]['value'] = $user['id_role'];
    $data['fields'][6]['options'] = $role;
    return $data;
}

function edit_user(){
    global $id;
    $user = get_user($id);
    $data = add_user_info($user);
    $form = new Form();
    $form->setData($data);
    echo $form->generateForm();
}

edit_user();