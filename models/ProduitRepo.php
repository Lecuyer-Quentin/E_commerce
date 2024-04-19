<?php
require_once 'Produit.php';

class ProduitRepo
{
    private $pdo;
    private $table = 'produit';
    public $nom;
    public $description;
    public $prix;
    public $image;
    public $idCategorie;
    public $idSpecial;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    private function prepare_data() {
        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->prix = htmlspecialchars(strip_tags($this->prix));
        $this->image = htmlspecialchars(strip_tags($this->image));
        $this->idCategorie = htmlspecialchars(strip_tags($this->idCategorie));
        $this->idSpecial = htmlspecialchars(strip_tags($this->idSpecial));
        return $this;
    }
    private function join_table(){
        $query = 'SELECT p.*, c.nom as categorie, c.idCategorie, s.nom as special, s.idSpecial FROM ' . $this->table . ' p';
        $query .= ' LEFT JOIN produit_categorie pc ON p.idProduit = pc.fkIdProduit';
        $query .= ' LEFT JOIN categorie c ON pc.fkIdCategorie = c.idCategorie';
        $query .= ' LEFT JOIN produit_special ps ON p.idProduit = ps.fkIdProduit';
        $query .= ' LEFT JOIN special s ON ps.fkIdSpecial = s.idSpecial';
        return $query;
    }

    public function read() {
        $query = $this->join_table();
        $query .= ' ORDER BY p.date DESC';
        $stmt = $this->pdo->prepare($query);
        $products = null;
        if($stmt->execute()) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($results as $result){
                $product = new Produit(
                    $result['idProduit'],
                    $result['nom'],
                    $result['description'],
                    $result['prix'],
                    $result['image'],
                    explode(',', $result['categorie']),
                    explode(',', $result['idCategorie']),
                    $result['special'] ? explode(',', $result['special']) : null,
                    $result['idSpecial'] ? explode (',', $result['idSpecial']) : null,
                    $result['date']
                );
                $products[] = $product;
            }
        } else {
            printf("Error: %s.\n", $stmt->error);
        }
        return $products;
    }

    public function read_one(int $idProduit) {
        $query = $this->join_table();
        $query .= ' WHERE p.idProduit = :idProduit';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':idProduit', $idProduit);
        if($stmt->execute()) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $product = new Produit(
                $result['idProduit'],
                $result['nom'],
                $result['description'],
                $result['prix'],
                $result['image'],
                explode (',', $result['categorie']),
                explode (',', $result['idCategorie']),
                $result['special'] ? explode(',', $result['special']) : null,
                $result['idSpecial'] ? explode (',', $result['idSpecial']) : null,
                $result['date']
            );
            return $product;
        } else {
            printf("Error: %s.\n", $stmt->error);
        }
        return null;
    }

    //! CHANGER par $idCategorie
    public function read_by_category(string $categorie) {
        $query = $this->join_table();
        $query .= ' WHERE c.nom = :categorie';
        $query .= ' ORDER BY p.date DESC';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':categorie', $categorie);
        $products = null;
        if($stmt->execute()) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($results as $result){
                $product = new Produit(
                    $result['idProduit'],
                    $result['nom'],
                    $result['description'],
                    $result['prix'],
                    $result['image'],
                    explode(',', $result['categorie']),
                    explode (',', $result['idCategorie']),
                    $result['special'] ? explode(',', $result['special']) : null,
                    $result['idSpecial'] ? explode (',', $result['idSpecial']) : null,
                    $result['date']
                );
                $products[] = $product;
            }
        } else {
            printf("Error: %s.\n", $stmt->error);
        }
        return $products;
    }

    public function read_limit(int $limit){
        $query = $this->join_table();
        $query .= ' ORDER BY p.date DESC LIMIT :limit';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $products = null;
        if($stmt->execute()) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($results as $result){
                $product = new Produit(
                    $result['idProduit'],
                    $result['nom'],
                    $result['description'],
                    $result['prix'],
                    $result['image'],
                    explode(',', $result['categorie']),
                    explode(',', $result['idCategorie']),
                    $result['special'] ? explode(',', $result['special']) : null,
                    $result['idSpecial'] ? explode (',', $result['idSpecial']) : null,
                    $result['date']
                );
                $products[] = $product;
            }
        } else {
            printf("Error: %s.\n", $stmt->error);
        }
        return $products;
    }

    public function search(string $keyWords) {
        $query = $this->join_table();
        $query .= ' WHERE p.nom LIKE :keyWords OR p.description LIKE :keyWords';
        $query .= ' ORDER BY p.date DESC';

        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':keyWords', '%'.$keyWords.'%', PDO::PARAM_STR);
        $products = null;
        if($stmt->execute()) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($results as $result){
                $product = new Produit(
                    $result['idProduit'],
                    $result['nom'],
                    $result['description'],
                    $result['prix'],
                    $result['image'],
                    explode (',', $result['categorie']),
                    explode (',', $result['idCategorie']),
                    $result['special'] ? explode(',', $result['special']) : null,
                    $result['idSpecial'] ? explode (',', $result['idSpecial']) : null,
                    $result['date']
                );
                $products[] = $product;
            }
        } else {
            printf("Error: %s.\n", $stmt->error);
        }
        return $products;
    }

    public function create() {
        try{
            $this->pdo->beginTransaction();

            $query = 'INSERT INTO ' . $this->table . ' (nom, description, prix, image) VALUES (:nom, :description, :prix, :image)';
            $stmt = $this->pdo->prepare($query);
            $data = $this->prepare_data();
            $stmt->bindParam(':nom', $data->nom);
            $stmt->bindParam(':description', $data->description);
            $stmt->bindParam(':prix', $data->prix);
            $stmt->bindParam(':image', $data->image);
            $stmt->execute();   

            $lastInsertId = $this->pdo->lastInsertId();

            $query = 'INSERT INTO produit_categorie (fkIdProduit, fkIdCategorie) VALUES (:fkIdProduit, :fkIdCategorie)';
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':fkIdProduit', $lastInsertId);
            $stmt->bindParam(':fkIdCategorie', $data->idCategorie);
            $stmt->execute();

            if($data->idSpecial) {
            $query = 'INSERT INTO produit_special (fkIdProduit, fkIdSpecial) VALUES (:fkIdProduit, :fkIdSpecial)';
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':fkIdProduit', $lastInsertId);
            $stmt->bindParam(':fkIdSpecial', $data->idSpecial);
            $stmt->execute();
            }

            $this->pdo->commit();
            return true;

        } catch(PDOException $e) {
            $this->pdo->rollBack();
            printf("Error: %s.\n", $e->getMessage());
            return false;
        }
    }

    public function update(int $idProduit) {
        try{
            $this->pdo->beginTransaction();

            $query = 'UPDATE ' . $this->table . ' SET nom = :nom, description = :description, prix = :prix, image = :image WHERE idProduit = :idProduit';
            $stmt = $this->pdo->prepare($query);
            $data = $this->prepare_data();
            $stmt->bindParam(':nom', $data->nom);
            $stmt->bindParam(':description', $data->description);
            $stmt->bindParam(':prix', $data->prix);
            $stmt->bindParam(':image', $data->image);
            $stmt->bindParam(':idProduit', $idProduit);
            $stmt->execute();
            
            $lastInsertId = $this->pdo->lastInsertId();

            $query = 'UPDATE produit_categorie SET fkIdCategorie = :fkIdCategorie WHERE fkIdProduit = :fkIdProduit';
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':fkIdProduit', $lastInsertId);
            $stmt->bindParam(':fkIdCategorie', $data->idCategorie);
            $stmt->execute();
            
            $query = 'UPDATE produit_special SET fkIdSpecial = :fkIdSpecial WHERE fkIdProduit = :fkIdProduit';
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':fkIdProduit', $lastInsertId);
            $stmt->bindParam(':fkIdSpecial', $data->idSpecial);
            $stmt->execute();

            $this->pdo->commit();
            return true;

        } catch(PDOException $e) {
            $this->pdo->rollBack();
            printf("Error: %s.\n", $e->getMessage());
            return false;
        }
    }

    public function delete(int $idProduit){
        try{
            $this->pdo->beginTransaction();

            $query = 'DELETE FROM produit_categorie WHERE fkIdProduit = :fkIdProduit';
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':fkIdProduit', $idProduit);
            $stmt->execute();

            $query = 'DELETE FROM produit_special WHERE fkIdProduit = :fkIdProduit';
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':fkIdProduit', $idProduit);
            $stmt->execute();

            $query = 'DELETE FROM ' . $this->table . ' WHERE idProduit = :idProduit';
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':idProduit', $idProduit);
            $stmt->execute();

            $this->pdo->commit();
            return true;

        } catch(PDOException $e) {
            $this->pdo->rollBack();
            printf("Error: %s.\n", $e->getMessage());
            return false;
        }
    }
}