<?php

class User
{
    public $id_utilisateur;
    public $nom;
    public $prenom;
    public $email;
    public $password;
    public $date_creation;
    public $member_since;
    public $id_role;

    public function __construct()
    {
    }
    public function insert($data)
    {
        $this->id_utilisateur = $data['id_utilisateur'] ?? null;
        $this->nom = $data['nom'] ?? null;
        $this->prenom = $data['prenom'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->password = $data['password'] ?? null;
        $this->date_creation = $data['date_creation'] ?? null;
        $this->member_since = $data['member_since'] ?? null;
        $this->id_role = $data['id_role'] ?? null;

        return [
            'id_utilisateur' => $this->id_utilisateur,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'email' => $this->email,
            'password' => $this->password,
            'date_creation' => $this->date_creation,
            'member_since' => $this->member_since,
            'id_role' => $this->id_role,
            ];
    }

    public function getId()
    {
        return $this->id_utilisateur;
    }

}