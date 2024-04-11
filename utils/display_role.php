<?php
require_once 'api/get_roles.php';

function display_role($users) {
    $roles = get_roles();
    foreach ($users as $key => $user) {
        foreach ($roles as $role) {
            if ($user->id_role == $role['id_role']) {
                $users[$key]->id_role = ucfirst($role['nom']);
            }
        }
    }
    return $users;
}