<?php
    require_once 'utils/display_role.php';
    require_once 'utils/get_JSON.php';
    global $pdo;
    $users = new Users($pdo);
    $users = $users->read();
    $users = display_role($users);
    foreach ($users as $key => $user) {
        $users[$key]->member_since = date('d/m/Y', strtotime($user->date_creation));
        unset($users[$key]->date_creation);
    }
    $nbr = count($users);
    $data = get_JSON('data.json', 'tables', 'users');
    $footer[] = ['type' => 'p', 'content' => 'Nombre d\'utilisateurs: ' . $nbr];
    $data['items'] = $users;
    $data['footer'] = $footer;
    $table = new Table();
    $table->setData($data);
    $table->generateTable();
?>
<article class="position-relative">
    <span class="position-absolute top-0 end-0 mt-5">
        <?php require_once 'add.php';?>
    </span>
    <?php echo $table->generateTable(); ?>
</article>
