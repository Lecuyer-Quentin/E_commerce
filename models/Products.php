<?php
require_once 'Product.php';
class Products
{
    private $pdo;
    private $table = 'Produits';
    public $id_produit;
    public $nom;
    public $description;
    public $prix;
    public $image;
    public $id_categorie;
    public $date_creation;
    public $keywords;
    public $limit;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    private function prepare_data()
    {
        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->prix = htmlspecialchars(strip_tags($this->prix));
        $this->image = htmlspecialchars(strip_tags($this->image));
        $this->id_categorie = htmlspecialchars(strip_tags($this->id_categorie));
        return $this;
        //[
        //    'nom' => $nom,
        //    'description' => $description,
        //    'prix' => $prix,
        //    'image' => $image,
        //    'id_categorie' => $id_categorie
        //];
    }
        
    public function read()
    {
        $query = 'SELECT * FROM ' . $this->table;
        $stmt = $this->pdo->prepare($query);
        if($stmt->execute()){
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($results as $result){
                $product = new Product();
                $product->insert($result);
                $products[] = $product;
            }
        }else{
            printf("Error: %s.\n", $stmt->error);
        }
        return $products;
    }

    public function read_single()
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id_produit = :id_produit';
        $stmt = $this->pdo->prepare($query);
        $stmt -> bindParam(':id_produit', $this->id_produit);
        if($stmt->execute()){
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $product = new Product();
            $product->insert($result);
        }else{
            printf("Error: %s.\n", $stmt->error);
        }
        return $product;
    }

    public function read_by_category()
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id_categorie = :id_categorie';
        $stmt = $this->pdo->prepare($query);
        $stmt -> bindParam(':id_categorie', $this->id_categorie);
        //$products = [];
        if($stmt->execute()){
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($results as $result){
                $product = new Product();
                $product->insert($result);
                $products[] = $product;
            }
        }else{
            printf("Error: %s.\n", $stmt->error);
        }
        return $products;
    }
    public function read_limit()
    {
        $query = 'SELECT * FROM ' . $this->table . ' ORDER BY date_creation DESC LIMIT :limit';
        $stmt = $this->pdo->prepare($query);
        $stmt -> bindValue(':limit', (int) $this->limit, PDO::PARAM_INT);
        if($stmt->execute()){
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($results as $result){
                $product = new Product();
                $product->insert($result);
                $products[] = $product;
            }
        }else{
            printf("Error: %s.\n", $stmt->error);
        }
        return $products;
    }
    public function create()
    {
        $query = 'INSERT INTO ' . $this->table . ' SET nom = :nom, description = :description, prix = :prix, image = :image, id_categorie = :id_categorie';
        $stmt = $this->pdo->prepare($query);
        $data = $this->prepare_data();
        foreach($data as $key => $value){
            $stmt->bindParam(':'. $key, $value);
        }
        if ($stmt->execute()) {
            return true;
        }
        printf("Error: %s.\n", $stmt->error);
        return false;
    }
    public function update()
    {
        $query = 'UPDATE ' . $this->table . ' SET nom = :nom, description = :description, prix = :prix, image = :image, id_categorie = :id_categorie WHERE id_produit = :id_produit';
        $stmt = $this->pdo->prepare($query);
        $data = $this->prepare_data();
        foreach($data as $key => $value){
            $stmt->bindParam(':'. $key, $value);
        }
        if ($stmt->execute()) {
            return true;
        }
        printf("Error: %s.\n", $stmt->error);
        return false;
    }
    public function delete()
    {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id_produit = :id_produit';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id_produit', $this->id_produit);
        if ($stmt->execute()) {
            return true;
        }
        printf("Error: %s.\n", $stmt->error);
        return false;
    }
    public function search()
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE nom LIKE :keywords OR description LIKE :keywords';
        $stmt = $this->pdo->prepare($query);
        $keywords = htmlspecialchars(strip_tags($this->keywords));
        $keywords = "%{$keywords}%";
        $stmt->bindParam(':keywords', $keywords);
        if($stmt->execute()){
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($results as $result){
                $product = new Product();
                $product->insert($result);
                $products[] = $product;
            }
        }else{
            printf("Error: %s.\n", $stmt->error);
        }
        return $products ?? [];
    }

    public function count()
    {
        $query = 'SELECT COUNT(*) as total_ligne FROM ' . $this->table;
        $stmt = $this->pdo->prepare($query);
        if($stmt->execute()){
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        }
        printf("Error: %s.\n", $stmt->error);
        return false;
    }
}

