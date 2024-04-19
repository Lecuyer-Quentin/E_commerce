<?php

$commandes = new CommandeRepo($pdo);
$commandes = $commandes->read_by_user($_SESSION['user']->get_idUtilisateur());
if (empty($commandes)) {
    echo "<p>Vous n'avez pas encore passé de commande.</p>";
} else {
    foreach ($commandes as $commande) {
        $idCommande = $commande['idCommande'];
        $total = $commande['total'];
        //$statut = $commande['statut'];
        $date = $commande['date'];
        $produit = $commande['produit'];
        $utilisateur = $commande['utilisateur'];
        echo "<p>Commande n°$idCommande</p>";
        echo "<p>Total: $total</p>";
        //echo "<p>Statut: $statut</p>";
        echo "<p>Date: $date</p>";
        echo "<p>Produit: $produit</p>";
        echo "<p>Utilisateur: $utilisateur</p>";
    }
}


