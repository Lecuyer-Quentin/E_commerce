<?php

class Categorie 
{
    private $idCategorie;
    private $nom;

    public function __construct(int $idCategorie, string $nom) {
        $this->set_nom($nom);
        $this->set_idCategorie($idCategorie);
    }

    public function set_nom($nom) {
        $this->nom = $nom;
    }
    public function set_idCategorie($idCategorie) {
        $this->idCategorie = $idCategorie;
    }
    public function get_idCategorie() {
        return $this->idCategorie;
    }
    public function get_nom() {
        return $this->nom;
    }
}