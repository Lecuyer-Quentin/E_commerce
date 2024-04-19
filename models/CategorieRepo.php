<?php

class CategorieRepo {
    private $pdo;
    private $table = 'categorie';
    //private $idCategorie;
    public $nom;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function read() {
        $query = 'SELECT * FROM ' . $this->table;
        $stmt = $this->pdo->prepare($query);
        $categories = null;
        if($stmt->execute()) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($results as $result) {
                $category = new Categorie(
                    $result['idCategorie'],
                    $result['nom']
                );
                $categories[] = $category;  
            }
        } else {
            printf("Error: %s.\n", $stmt->error);
        }
        return $categories;
    }

    public function read_one($idCategorie) {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE idCategorie = :idCategorie';
        $stmt = $this->pdo->prepare($query);
        if($stmt->execute(['idCategorie' => $idCategorie])) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $category = new Categorie(
                $result['idCategorie'],
                $result['nom']
            );
            return $category;
        } else {
            printf("Error: %s.\n", $stmt->error);
        }
        return null;
    }

    public function create()
    {   $query = 'INSERT INTO ' . $this->table . ' (nom) VALUES (:nom)';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':nom', $this->nom);
        $stmt->execute();
    }

    public function update($idCategorie) {
        $query = 'UPDATE ' . $this->table . ' SET nom = :nom WHERE idCategorie = :idCategorie';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':idCategorie', $idCategorie);
        $stmt->execute();
    }

    public function delete($idCategorie) {
        $query = 'DELETE FROM ' . $this->table . ' WHERE idCategorie = :idCategorie';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':idCategorie', $idCategorie);
        $stmt->execute();
    }
}