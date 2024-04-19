

<section>
    <article>
        <h2>Modifier mes informations</h2>
        <form action="controllers/users/update.php" method="post">
            <input type="hidden" name="id" value="<?php echo $user->get_idUtilisateur(); ?>">
            <input type="hidden" name="role" value="<?php echo $user->get_idRole(); ?>">
            <label for="nom">Nom</label>
            <input type="text" name="nom" id="nom" value="<?php echo $user->get_nom(); ?>">
            <label for="prenom">Prénom</label>
            <input type="text" name="prenom" id="prenom" value="<?php echo $user->get_prenom(); ?>">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?php echo $user->get_email(); ?>">
            <button type="submit">Modifier</button>
        </form>
    </article>
    <article>
        <h2>Supprimer mon compte</h2>
        <form action="index.php?controller=profile&action=delete" method="post">
            <input type="submit" value="Supprimer">
        </form>
    </article>
</section>