<?php 

class Commande
{
    private $idCommande;
    private $date;
    private $total;
    private $statut;
    private $fkIdUtilisateur;
    private $fkIdProduit;
    private $idUtilisateur;

    public function __construct($idCommande, $date, $total, $statut, $fkIdUtilisateur, $fkIdProduit)
    {
        $this->setDate($date);
        $this->setTotal($total);
        $this->setStatut($statut);
        $this->setFkIdUtilisateur($fkIdUtilisateur);
        $this->setFkIdProduit($fkIdProduit);
        $this->setIdCommande($idCommande);
    }

    public function getIdCommande()
    {
        return $this->idCommande;
    }
    public function getDate()
    {
        return $this->date;
    }
    public function getTotal()
    {
        return $this->total;
    }
    public function getStatut()
    {
        return $this->statut;
    }
    public function getFkIdUtilisateur()
    {
        return $this->fkIdUtilisateur;
    }
    public function getFkIdProduit()
    {
        return $this->fkIdProduit;
    }
    public function setIdCommande($idCommande)
    {
        $this->idCommande = $idCommande;
    }
    public function setDate($date)
    {
        $this->date = $date;
    }
    public function setTotal($total)
    {
        $this->total = $total;
    }
    public function setStatut($statut)
    {
        $this->statut = $statut;
    }
    public function setFkIdUtilisateur($fkIdUtilisateur)
    {
        $this->fkIdUtilisateur = $fkIdUtilisateur;
    }
    public function setFkIdProduit($fkIdProduit)
    {
        $this->fkIdProduit = $fkIdProduit;
    }
}
    