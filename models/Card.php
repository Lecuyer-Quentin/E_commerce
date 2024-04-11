<?php

class Card{
    public $data;
    public $id_produit;
    public $nom;
    public $description;
    public $prix;
    public $image;
    public $id_categorie;
    public $date_creation;

    public function __construct(){
    }
    
    public function insert($data){
        $this->id_produit = $data['id_produit'];
        $this->nom = $data['nom'];
        $this->description = $data['description'];
        $this->prix = $data['prix'];
        $this->image = $data['image'];
        $this->id_categorie = $data['id_categorie'];
        $this->date_creation = $data['date_creation'];

        return [
            'id_produit' => $this->id_produit,
            'nom' => $this->nom,
            'description' => $this->description,
            'prix' => $this->prix,
            'image' => $this->image,
            'id_categorie' => $this->id_categorie,
            'date_creation' => $this->date_creation
        ];
    }


    public function display(){
        $card = '<div class="card" style="width: 18rem;"';
            $card .= '<img src="' . $this->image . '" class="card-img-top" alt="' . $this->nom . '">';
            $card .= '<div class="card-body">';
                $card .= '<h5 class="card-title">' . $this->nom . '</h5>';
                $card .= '<p class="card-text">' . $this->description . '</p>';
                $card .= '<p class="card-text"><small class="text-muted">' . $this->prix . ' €</small></p>';
                $card .= '<a href="index.php?page=product&id=' . $this->id_produit . '" class="btn btn-primary">Voir le produit</a>';
            $card .= '</div>';
        $card .= '</div>';
        return $card;
    }

}