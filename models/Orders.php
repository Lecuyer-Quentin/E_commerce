<?php

class Orders 
{
    private $pdo;
    private $table = 'Commandes';
    public $id_commande;
    public $id_utilisateur;
    public $date_commande;
    public $prix_total;
    public $id_produit;
    public $id_detail;
    public $quantite;
    public $statut;
    public $keywords;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    public function read()
    {
        $query = 'SELECT * FROM ' . $this->table;
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        extract($result);
        return $result;
    }
    public function read_single()
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id_commande = :id_commande';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id_commande', $this->id_commande);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        extract($result);
        return $result;
    }
    public function create()
    {
        $query = 'INSERT INTO ' . $this->table . ' SET id_utilisateur = :id_utilisateur, date_commande = :date_commande, prix_total = :prix_total, statut = :statut';
        $id_utilisateur = htmlspecialchars(strip_tags($this->id_utilisateur));
        $date_commande = htmlspecialchars(strip_tags($this->date_commande));
        $prix_total = htmlspecialchars(strip_tags($this->prix_total));
        $statut = htmlspecialchars(strip_tags($this->statut));
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id_utilisateur', $id_utilisateur);
        $stmt->bindParam(':date_commande', $date_commande);
        $stmt->bindParam(':prix_total', $prix_total);
        $stmt->bindParam(':statut', $statut);
        if ($stmt->execute()) {
            return true;
        }
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    public function update()
    {
        $query = 'UPDATE ' . $this->table . ' SET id_utilisateur = :id_utilisateur, date_commande = :date_commande, prix_total = :prix_total, statut = :statut WHERE id_commande = :id_commande';
        $id_utilisateur = htmlspecialchars(strip_tags($this->id_utilisateur));
        $date_commande = htmlspecialchars(strip_tags($this->date_commande));
        $prix_total = htmlspecialchars(strip_tags($this->prix_total));
        $statut = htmlspecialchars(strip_tags($this->statut));
        $id_commande = htmlspecialchars(strip_tags($this->id_commande));
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id_utilisateur', $id_utilisateur);
        $stmt->bindParam(':date_commande', $date_commande);
        $stmt->bindParam(':prix_total', $prix_total);
        $stmt->bindParam(':statut', $statut);
        $stmt->bindParam(':id_commande', $id_commande);
        if ($stmt->execute()) {
            return true;
        }
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    public function delete()
    {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id_commande = :id_commande';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id_commande', $this->id_commande);
        if ($stmt->execute()) {
            return true;
        }
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    public function search()
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE CONCAT(id_commande, id_utilisateur, date_commande, prix_total, statut) LIKE ?';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(1, $this->keywords);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        extract($result);
        return $result;
    }

    public function count()
    {
        $query = 'SELECT COUNT(*) as total_ligne FROM ' . $this->table;
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        extract($result);
        return $result;
    }

    public function read_user_orders()
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id_utilisateur = :id_utilisateur';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id_utilisateur', $this->id_utilisateur);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        extract($result);
        return $result;
    }

    public function read_order_details()
    {
        $query = 'SELECT * FROM Details_commandes WHERE id_commande = :id_commande';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id_commande', $this->id_commande);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        extract($result);
        return $result;
    }

    public function create_order_details()
    {
        $query = 'INSERT INTO Details_commandes SET id_commande = :id_commande, id_produit = :id_produit, quantite = :quantite';
        $id_commande = htmlspecialchars(strip_tags($this->id_commande));
        $id_produit = htmlspecialchars(strip_tags($this->id_produit));
        $quantite = htmlspecialchars(strip_tags($this->quantite));
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id_commande', $id_commande);
        $stmt->bindParam(':id_produit', $id_produit);
        $stmt->bindParam(':quantite', $quantite);
        if ($stmt->execute()) {
            return true;
        }
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    public function update_order_details()
    {
        $query = 'UPDATE Details_commandes SET id_commande = :id_commande, id_produit = :id_produit, quantite = :quantite WHERE id_detail = :id_detail';
        $id_commande = htmlspecialchars(strip_tags($this->id_commande));
        $id_produit = htmlspecialchars(strip_tags($this->id_produit));
        $quantite = htmlspecialchars(strip_tags($this->quantite));
        $id_detail = htmlspecialchars(strip_tags($this->id_detail));
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id_commande', $id_commande);
        $stmt->bindParam(':id_produit', $id_produit);
        $stmt->bindParam(':quantite', $quantite);
        $stmt->bindParam(':id_detail', $id_detail);
        if ($stmt->execute()) {
            return true;
        }
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    public function delete_order_details()
    {
        $query = 'DELETE FROM Details_commandes WHERE id_detail = :id_detail';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id_detail', $this->id_detail);
        if ($stmt->execute()) {
            return true;
        }
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    public function count_order_details()
    {
        $query = 'SELECT COUNT(*) as total_ligne FROM Details_commandes WHERE id_commande = :id_commande';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id_commande', $this->id_commande);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        extract($result);
        return $result;
    }

    public function count_user_orders()
    {
        $query = 'SELECT COUNT(*) as total_ligne FROM ' . $this->table . ' WHERE id_utilisateur = :id_utilisateur';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id_utilisateur', $this->id_utilisateur);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        extract($result);
        return $result;
    }

    public function count_order_details_by_product()
    {
        $query = 'SELECT COUNT(*) as total_ligne FROM Details_commandes WHERE id_produit = :id_produit';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id_produit', $this->id_produit);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        extract($result);
        return $result;
    }
}