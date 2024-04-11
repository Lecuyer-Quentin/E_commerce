<?php
require_once 'User.php';

class Users
{
    private $pdo;
    private $table = 'Utilisateurs';
    public $id_utilisateur;
    public $nom;
    public $prenom;
    public $email;
    public $password;
    public $date_creation;
    public $id_role;
    public $keywords;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    private function prepare_data()
    {
        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->prenom = htmlspecialchars(strip_tags($this->prenom));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->id_role = htmlspecialchars(strip_tags($this->id_role));
        $this->date_creation = htmlspecialchars(strip_tags($this->date_creation));
        $this->id_utilisateur = htmlspecialchars(strip_tags($this->id_utilisateur));
        $this->id_role = htmlspecialchars(strip_tags($this->id_role));
        return [
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'email' => $this->email,
            'password' => $this->password,
            'id_role' => $this->id_role,
            'date_creation' => $this->date_creation,
            'id_utilisateur' => $this->id_utilisateur,
        ];
    }
    
    public function read()
    {
        $query = 'SELECT * FROM ' . $this->table;
        $stmt = $this->pdo->prepare($query);
        if($stmt->execute()){
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($results as $result){
                $user = new User();
                $user->insert($result);
                $users[] = $user;
            }
        }else{
            printf('Error: %s.\n', $stmt->error);
        }
        return $users;
    }

    public function read_single()
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id_utilisateur = :id_utilisateur';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id_utilisateur', $this->id_utilisateur);
        if($stmt->execute()){
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $user = new User();
            $user->insert($result);
        }else{
            printf('Error: %s.\n', $stmt->error);
        }
        return $user;
    }

    public function connect()
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE email = :email';
        $email = htmlspecialchars(strip_tags($this->email));
        $password = htmlspecialchars(strip_tags($this->password));
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        if($stmt->execute()){
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if(password_verify($password, $result['mot_de_passe'])){
                $user = new User();
                $user->insert($result);
            }else{
                return false;
            }
        }else{
            printf('Error: %s.\n', $stmt->error);
        }
        return $user;

    }

    public function register()
    {
        $query = 'INSERT INTO ' . $this->table . ' (nom, prenom, email, mot_de_passe, id_role) VALUES (:nom, :prenom, :email, :password, :id_role)';
        $stmt = $this->pdo->prepare($query);
        $data = $this->prepare_data();
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        foreach($data as $key => $value){
            $stmt->bindParam(':'.$key, $value);
        }
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    public function update()
    {
        $query = 'UPDATE ' . $this->table . ' SET nom = :nom, prenom = :prenom, email = :email, id_role = :id_role WHERE id_utilisateur = :id_utilisateur';
        $stmt = $this->pdo->prepare($query);
        $data = $this->prepare_data();
        foreach($data as $key => $value){
            $stmt->bindParam(':'.$key, $value);
        }
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    public function delete()
    {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id_utilisateur = :id_utilisateur';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id_utilisateur', $this->id_utilisateur);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    public function count()
    {
        $query = 'SELECT COUNT(*) as total_ligne FROM ' . $this->table;
        $stmt = $this->pdo->prepare($query);
        if($stmt->execute()){
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $total_ligne = $result['total_ligne'];
        }else{
            printf('Error: %s.\n', $stmt->error);
        }
        return $total_ligne;
    }
    public function search()
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE nom LIKE ? OR prenom LIKE ? OR email LIKE ?';
        $stmt = $this->pdo->prepare($query);
        $keywords = htmlspecialchars(strip_tags($this->keywords));
        $keywords = "%{$keywords}%";
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords);
        $stmt->bindParam(3, $keywords);
        if($stmt->execute()){
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($results as $result){
                $user = new User();
                $user->insert($result);
                $users[] = $user;
            }
        }else{
            printf('Error: %s.\n', $stmt->error);
        }
        return $users;
    }
}

//class User
//{
//    public $id_utilisateur;
//    public $nom;
//    public $prenom;
//    public $email;
//    public $password;
//    public $date_creation;
//    public $id_role;
//
//    public function insert($data)
//    {
//        $this->id_utilisateur = $data['id_utilisateur'];
//        $this->nom = $data['nom'];
//        $this->prenom = $data['prenom'];
//        $this->email = $data['email'];
//        $this->password = $data['mot_de_passe'];
//        $this->date_creation = $data['date_creation'];
//        $this->id_role = $data['id_role'];
//    }
//
//
//}