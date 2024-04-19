<?php

class CommandeRepo
{
    private $pdo;
    private $table = 'commande';
    public $total;
    public $statut;
    public $fkIdUtilisateur;
    public $fkIdProduit;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }
    public function join_table(){
        $query = 'SELECT c.*, u.nom as utilisateur, p.nom as produit FROM ' . $this->table . ' c';
        $query .= ' LEFT JOIN utilisateur_commande uc ON c.idCommande = uc.fkIdCommande';
        $query .= ' LEFT JOIN utilisateur u ON uc.fkIdUtilisateur = u.idUtilisateur';
        $query .= ' LEFT JOIN commande_produit cp ON c.idCommande = cp.fkIdCommande';
        $query .= ' LEFT JOIN produit p ON cp.fkIdProduit = p.idProduit';
        return $query;
    }

    public function read(){
        $query = $this->join_table();
        $query .= ' ORDER BY c.date DESC';
        $stmt = $this->pdo->prepare($query);
        if($stmt->execute()){
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        }else{
            printf("Error: %s.\n", $stmt->error);
        }
    }

    public function read_one(int $idCommande){
        $query = $this->join_table();
        $query .= ' WHERE c.idCommande = :idCommande';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':idCommande', $idCommande);
        if($stmt->execute()){
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        }else{
            printf("Error: %s.\n", $stmt->error);
        }
    }

    public function read_by_user(int $idUtilisateur){
        $query = $this->join_table();
        $query .= ' WHERE u.idUtilisateur = :idUtilisateur';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':idUtilisateur', $idUtilisateur);
        if($stmt->execute()){
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        }else{
            printf("Error: %s.\n", $stmt->error);
        }
    }

    public function read_by_product(int $idProduit){
        $query = $this->join_table();
        $query .= ' WHERE p.idProduit = :idProduit';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':idProduit', $idProduit);
        if($stmt->execute()){
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        }else{
            printf("Error: %s.\n", $stmt->error);
        }
    }

    public function read_limit(int $limit){
        $query = $this->join_table();
        $query .= ' ORDER BY c.date DESC LIMIT :limit';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        if($stmt->execute()){
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        }else{
            printf("Error: %s.\n", $stmt->error);
        }
    }

    public function search(string $keyWords){
        $query = $this->join_table();
        $query .= ' WHERE u.nom LIKE :keyWords OR p.nom LIKE :keyWords';
        $query .= ' ORDER BY c.date DESC';
        $stmt = $this->pdo->prepare($query);
        $keyWords = htmlspecialchars(strip_tags($keyWords));
        $keyWords = "%{$keyWords}%";
        $stmt->bindParam(':keyWords', $keyWords);
        if($stmt->execute()){
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        }else{
            printf("Error: %s.\n", $stmt->error);
        }
    }

    //! AJOUTER STATUS DANS LA BD
    public function create(){
        try{
            $this->pdo->beginTransaction();
            $query = 'INSERT INTO ' . $this->table . ' (total, statut) VALUES (:total, :statut)';
            //$date = htmlspecialchars(strip_tags($this->date));
            $total = htmlspecialchars(strip_tags($this->total));
            $statut = htmlspecialchars(strip_tags($this->statut));
            $stmt = $this->pdo->prepare($query);
            //$stmt->bindParam(':date', $date);
            $stmt->bindParam(':total', $total);
            $stmt->bindParam(':statut', $statut);

            $stmt->execute();

            $idCommande = $this->pdo->lastInsertId();

            $query = 'INSERT INTO utilisateur_commande (fkIdUtilisateur, fkIdCommande) VALUES (:fkIdUtilisateur, :fkIdCommande)';
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':fkIdUtilisateur', $this->fkIdUtilisateur);
            $stmt->bindParam(':fkIdCommande', $idCommande);
            $stmt->execute();

            $query = 'INSERT INTO produit_commande (fkIdProduit, fkIdCommande) VALUES (:fkIdProduit, :fkIdCommande)';
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':fkIdProduit', $this->fkIdProduit);
            $stmt->bindParam(':fkIdCommande', $idCommande);
            $stmt->execute();

            $this->pdo->commit();
            return true;
        }catch(PDOException $e){
            $this->pdo->rollback();
            printf("Error: %s.\n", $e->getMessage());
            return false;

        }

    }


}