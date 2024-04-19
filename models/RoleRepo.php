<?php

class RoleRepo
{
    private $pdo;
    private $table = 'role';

   //private $idRole;
   //private $nom;



    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function read()
    {
        $query = 'SELECT * FROM ' . $this->table;
        $stmt = $this->pdo->prepare($query);
        $roles = null;
        if($stmt->execute()) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($results as $result) {
                $r = new Role(
                    $result['idRole'],
                    $result['nom']
                );
                $roles[] = $r;
            }
        } else {
            printf("Error: %s.\n", $stmt->error);
        }
        return $roles;
    }


    //public function read_one($id)
    //{
    //    $query = 'SELECT * FROM ' . $this->table . ' WHERE idRole = ?';
    //    $stmt = $this->pdo->prepare($query);
    //    $stmt->execute([$id]);
    //    return $stmt->fetch();
    //}
//
    //public function create($data)
    //{
    //    $query = 'INSERT INTO ' . $this->table . ' (nom) VALUES (?)';
    //    $stmt = $this->pdo->prepare($query);
    //    $stmt->execute([$data['nom']]);
    //}
//
    //public function update($data)
    //{
    //    $query = 'UPDATE ' . $this->table . ' SET nom = ? WHERE idRole = ?';
    //    $stmt = $this->pdo->prepare($query);
    //    $stmt->execute([$data['nom'], $data['idRole']]);
    //}
//
    //public function delete($id)
    //{
    //    $query = 'DELETE FROM ' . $this->table . ' WHERE idRole = ?';
    //    $stmt = $this->pdo->prepare($query);
    //    $stmt->execute([$id]);
    //}

}

class Role {
    private $idRole;
    private $nom;

    public function __construct(int $idRole, string $nom)
    {
        $this->set_idRole($idRole);
        $this->set_nom($nom);
    }

    public function get_idRole()
    {
        return $this->idRole;
    }

    public function get_nom()
    {
        return $this->nom;
    }

    public function set_idRole($idRole)
    {
        $this->idRole = $idRole;
    }

    public function set_nom($nom)
    {
        $this->nom = $nom;
    }
}



