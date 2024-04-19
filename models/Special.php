<?php

class Special
{
    private $idSpecial;
    private $nom;

    public function __construct($idSpecial, $nom)
    {
        $this->set_idSpecial($idSpecial);
        $this->set_nom($nom);
    }

    public function get_idSpecial()
    {
        return $this->idSpecial;
    }
    public function set_idSpecial($idSpecial)
    {
        $this->idSpecial = $idSpecial;
    }
    public function get_nom()
    {
        return $this->nom;
    }
    public function set_nom($nom)
    {
        $this->nom = $nom;
    }

}