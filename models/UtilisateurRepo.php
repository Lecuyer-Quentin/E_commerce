<?php 
include_once 'Utilisateur.php';

class UtilisateurRepo
{
    private $pdo;
    private $table = 'utilisateur';
    public $nom;
    public $prenom;
    public $email;
    public $password;
    public $idRole;
    public $image;


    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    private function prepare_data() {
        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->prenom = htmlspecialchars(strip_tags($this->prenom));
        $this->email = htmlspecialchars(strip_tags($this->email));
        //! a verifier ?? utilisation pour update
        $this->password = htmlspecialchars(strip_tags($this->password ?? ''));
        $this->idRole = htmlspecialchars(strip_tags($this->idRole));
        $this->image = htmlspecialchars(strip_tags($this->image ?? ''));
        return $this;
    }
    private function join_table() {
        $query = ' SELECT u.*, r.nom as role, r.idRole FROM ' . $this->table . ' u';
        $query .= ' LEFT JOIN utilisateur_role ur ON u.idUtilisateur = ur.fkIdUtilisateur';
        $query .= ' LEFT JOIN role r ON ur.fkIdRole = r.idRole';
        return $query;
    }

    public function read() {
        $query = $this->join_table();
        $query .= ' ORDER BY u.date DESC';
        $stmt = $this->pdo->prepare($query);
        $users = null;
        if($stmt->execute()) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($results as $result){
                $user = new Utilisateur(
                    $result['idUtilisateur'],
                    $result['nom'],
                    $result['prenom'],
                    $result['email'],
                    '', // password is not needed
                    $result['role'],
                    $result['idRole'],
                    $result['date'],
                    $result['numRue'],
                    $result['nomRue'],
                    $result['cPostal'],
                    $result['ville'],
                    $result['pays'],
                    $result['image']
                );
                $users[] = $user;
            }

        } else {
            printf("Error: %s.\n", $stmt->error);
        }
        return $users;
    }

    public function read_one(int $idUtilisateur) {
        $query = $this->join_table();
        $query .= ' WHERE u.idUtilisateur = :idUtilisateur';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':idUtilisateur', $idUtilisateur);
        if($stmt->execute()) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $user = new Utilisateur(
                $result['idUtilisateur'],
                $result['nom'],
                $result['prenom'],
                $result['email'],
                '', // password is not needed
                $result['role'],
                $result['idRole'],
                $result['date'],
                $result['numRue'],
                $result['nomRue'],
                $result['cPostal'],
                $result['ville'],
                $result['pays'],
                $result['image']
            );
            return $user;
        } else {
            printf("Error: %s.\n", $stmt->error);
        }
        return false;
    }

    public function read_limit(int $limit){
        $query = $this->join_table();
        $query .= ' ORDER BY u.date DESC LIMIT :limit';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $users = null;
        if($stmt->execute()) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($results as $result){
                $user = new Utilisateur(
                    $result['idUtilisateur'],
                    $result['nom'],
                    $result['prenom'],
                    $result['email'],
                    '', // password is not needed
                    $result['role'],
                    $result['idRole'],
                    $result['date'],
                    $result['numRue'],
                    $result['nomRue'],
                    $result['cPostal'],
                    $result['ville'],
                    $result['pays'],
                    $result['image']
                );
                $users[] = $user;
            }
        } else {
            printf("Error: %s.\n", $stmt->error);
        }
        return $users;
    }

    public function search(string $keyWords){
        $query = $this->join_table();
        $query .= ' WHERE u.nom LIKE :keywords OR u.prenom LIKE :keywords OR u.email LIKE :keywords OR r.nom LIKE :keywords';
        $stmt = $this->pdo->prepare($query);
        $keyWords = htmlspecialchars(strip_tags($keyWords));
        $keyWords = "%{$keyWords}%";
        $stmt->bindParam(':keywords', $keyWords);
        $users = null;
        if($stmt->execute()) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($results as $result){
                $user = new Utilisateur(
                    $result['idUtilisateur'],
                    $result['nom'],
                    $result['prenom'],
                    $result['email'],
                    '', // password is not needed
                    $result['role'],
                    $result['idRole'],
                    $result['date'],
                    $result['numRue'],
                    $result['nomRue'],
                    $result['cPostal'],
                    $result['ville'],
                    $result['pays'],
                    $result['image']
                );
                $users[] = $user;

            }
        } else {
            printf("Error: %s.\n", $stmt->error);
        }
        return $users;
    }

    public function create() {
        try{
            $this->pdo->beginTransaction();
            $query = 'INSERT INTO ' . $this->table . ' (nom, prenom, email, password, image) VALUES (:nom, :prenom, :email, :password, :image)';
            $stmt = $this->pdo->prepare($query);
            $data = $this->prepare_data();
            $data->password = password_hash($data->password, PASSWORD_BCRYPT);
            $stmt->bindParam(':nom', $data->nom);
            $stmt->bindParam(':prenom', $data->prenom);
            $stmt->bindParam(':email', $data->email);
            $stmt->bindParam(':password', $data->password);
            $stmt->bindParam(':image', $data->image);

            $stmt->execute();

            $idUtilisateur = $this->pdo->lastInsertId();

            $query = 'INSERT INTO utilisateur_role (fkIdUtilisateur, fkIdRole) VALUES (:idUtilisateur, :idRole)';
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':idUtilisateur', $idUtilisateur);
            $stmt->bindParam(':idRole', $data->idRole);
            $stmt->execute();

            $this->pdo->commit();
            return true;

        } catch(PDOException $e) {
            $this->pdo->rollBack();
            printf("Error: %s.\n", $e->getMessage());
            return false;
        }
    }

    public function log_in(){
        $query = $this->join_table();
        $query .= ' WHERE email = :email';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result){
            if(password_verify($this->password, $result['password'])){
                $user = new Utilisateur(
                    $result['idUtilisateur'],
                    $result['nom'],
                    $result['prenom'],
                    $result['email'],
                    '', // password is not needed
                    $result['role'],
                    $result['idRole'],
                    $result['date'],
                    $result['numRue'],
                    $result['nomRue'],
                    $result['cPostal'],
                    $result['ville'],
                    $result['pays'],
                    $result['image']
                );
                return $user;
                //return $result;
            }

        }
        return false;
    }

    public function update(int $idUtilisateur) {
        try{
            $this->pdo->beginTransaction();

            $query = 'UPDATE ' . $this->table . ' SET nom = :nom, prenom = :prenom, email = :email, image = :image WHERE idUtilisateur = :idUtilisateur';
            $stmt = $this->pdo->prepare($query);
            $data = $this->prepare_data();
            //$data->password = password_hash($data->password, PASSWORD_BCRYPT);
            $stmt->bindParam(':idUtilisateur', $idUtilisateur);
            $stmt->bindParam(':nom', $data->nom);
            $stmt->bindParam(':prenom', $data->prenom);
            $stmt->bindParam(':email', $data->email);
            $stmt->bindParam(':image', $data->image);

            $stmt->execute();

            $query = 'UPDATE utilisateur_role SET fkIdRole = :idRole WHERE fkIdUtilisateur = :idUtilisateur';
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':idUtilisateur', $idUtilisateur);
            $stmt->bindParam(':idRole', $data->idRole);
            $stmt->execute();

            $this->pdo->commit();
            return true;
        } catch(PDOException $e) {
            $this->pdo->rollBack();
            printf("Error: %s.\n", $e->getMessage());
            return false;
        }
    }

    public function delete (int $idUtilisateur){
        try{
            $this->pdo->beginTransaction();

            $query = 'DELETE FROM utilisateur_role WHERE fkIdUtilisateur = :idUtilisateur';
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':idUtilisateur', $idUtilisateur);
            $stmt->execute();
            
            $query = 'DELETE FROM ' . $this->table . ' WHERE idUtilisateur = :idUtilisateur';
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':idUtilisateur', $idUtilisateur);
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