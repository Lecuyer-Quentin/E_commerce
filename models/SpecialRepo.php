<?php

class SpecialRepo
{
    private $pdo;
    private $table = 'special';
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    public function read_one($id)
    {
        $query = "SELECT * FROM $this->table WHERE idSpecial = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        if($stmt->execute()) {
            $result = $stmt->fetch( PDO::FETCH_ASSOC );
            $special = new Special($result['idSpecial'], $result['nom']);
            return $special;
        } else {
            throw new Exception('Error reading special');
        }
    }
    public function read()
    {
        $query = 'SELECT * FROM ' . $this->table;
        $stmt = $this->pdo->prepare($query);
        $specials = null;
        if($stmt->execute()) {
            $results = $stmt->fetchAll( PDO::FETCH_ASSOC );
            foreach($results as $result) {
                $special = new Special($result['idSpecial'], $result['nom']);
                $specials[] = $special;
            }
        } else {
            throw new Exception('Error reading special');
        }
        return $specials;
    }
}