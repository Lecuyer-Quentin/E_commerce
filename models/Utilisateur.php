<?php

class Utilisateur 
{
    private $idUtilisateur;
    private $nom;
    private $prenom;
    private $email;
    private $password;
    private $role;
    private $idRole;
    private $date;
    private $numRue;
    private $nomRue;
    private $cPostal;
    private $ville;
    private $pays;
    private $image;

    public function __construct(int $idUtilisateur, string $nom, string $prenom, string $email, string $password, string $role, int $idRole, $date, string $numRue = null, string $nomRue = null, string $cPostal = null, string $ville = null, string $pays = null, string $image = null)
    {
        $this->set_idUtilisateur($idUtilisateur);
        $this->set_nom($nom);
        $this->set_prenom($prenom);
        $this->set_email($email);
        $this->set_password($password);
        $this->set_role($role);
        $this->set_idRole($idRole);
        $this->set_date($date);
        $this->set_adresse($numRue, $nomRue, $cPostal, $ville, $pays);
        $this->set_image($image);
    }

    public function get_value_of($key)
    {
        return $this->$key;
    }

    public function get_idUtilisateur()
    {
        return $this->idUtilisateur;
    }

    public function get_nom()
    {
        return $this->nom;
    }

    public function get_prenom()
    {
        return $this->prenom;
    }

    public function get_email()
    {
        return $this->email;
    }

    public function get_password()
    {
        return $this->password;
    }

    public function get_role()
    {
        return $this->role;
    }
    public function get_idRole()
    {
        return $this->idRole;
    }

    public function get_date()
    {
        return $this->date;
    }

    public function get_adresse()
    {
        return $this->numRue . $this->nomRue . $this->cPostal . $this->ville . $this->pays;
    }
    public function get_numRue()
    {
        return $this->numRue;
    }
    public function get_nomRue()
    {
        return $this->nomRue;
    }
    public function get_cPostal()
    {
        return $this->cPostal;
    }
    public function get_ville()
    {
        return $this->ville;
    }
    public function get_pays()
    {
        return $this->pays;
    }
    

    public function get_image()
    {
        return $this->image;
    }

    public function set_idUtilisateur($idUtilisateur)
    {
        $this->idUtilisateur = $idUtilisateur;
    }
   
    public function set_nom($nom)
    {
        $this->nom = $nom;
    }
    public function set_prenom($prenom)
    {
        $this->prenom = $prenom;
    }
    public function set_email($email)
    {
        $this->email = $email;
    }
    public function set_password($password)
    {
        $this->password = $password;
    }
    public function set_role($role)
    {
        $this->role = $role;
    }
    public function set_idRole($idRole)
    {
        $this->idRole = $idRole;
    }

    public function set_date($date)
    {
        $this->date = $date;
    }

    public function set_adresse($numRue, $nomRue, $cPostal, $ville, $pays)
    {
        $this->numRue = $numRue;
        $this->nomRue = $nomRue;
        $this->cPostal = $cPostal;
        $this->ville = $ville;
        $this->pays = $pays;
    }
    public function set_image($image)
    {
        if(!$image){
            $this->image = 'uploads/default.jpg';
        }else{
            $path = 'uploads/users/';
            $img = $path . $image;
            $this->image = $img;
        }
    }

}