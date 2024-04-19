<?php
    $users = new UtilisateurRepo($pdo);
    $users = $users->read();
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
        <?php require_once 'add.php';
        echo $modal_add_user->modal_trigger();
        ?>
    </span>
    <?php echo $table->generateTable(); ?>
</article>
