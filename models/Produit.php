<?php

class Produit{

    private $idProduit;
    private $nom;
    private $description;
    private $prix;
    private $image;
    private $categorie;
    private $idCategorie;
    private $special;
    private $idSpecial;
    private $date;
    private $quantity;

    public function __construct(int $idProduit, string $nom, string $description, float $prix, string $image, array $categorie, array $idCategorie, array $special = null, array $idSpecial = null, $date)
    {
        $this->set_idProduit($idProduit);
        $this->set_nom($nom);
        $this->set_description($description);
        $this->set_prix($prix);
        $this->set_image($image);
        $this->set_categorie($categorie);
        $this->set_idCategorie($idCategorie);
        $this->set_special($special);
        $this->set_idSpecial($idSpecial);
        $this->set_date($date);
    }

    public function get_data()
    {
        return get_object_vars($this);
    }

    public function get_value_of($key)
    {
        return $this->$key;
    }
    public function get_idProduit()
    {
        return $this->idProduit;
    }
    public function get_nom()
    {
        return $this->nom;
    }
    public function get_description()
    {
        return $this->description;
    }
    public function get_prix()
    {
        return $this->prix;
    }
    public function get_image()
    {
        return $this->image;
    }
    public function get_categorie()
    {
        return $this->categorie;
    }
    public function get_idCategorie()
    {
        return $this->idCategorie;
    }
    public function get_special()
    {
        return $this->special;
    }
    public function get_idSpecial()
    {
        return $this->idSpecial;
    }
    public function get_date()
    {
        return $this->date;
    }
    public function get_quantity()
    {
        return $this->quantity;
    }
    public function set_idProduit($idProduit)
    {
        $this->idProduit = $idProduit;
    }
    public function set_nom($nom)
    {
        $this->nom = $nom;
    }
    public function set_description($description)
    {
        $this->description = $description;
    }
    public function set_prix($prix)
    {
        $this->prix = $prix;
    }
    public function set_image($image)
    {
        if(!$image){
            $this->image = 'uploads/default.jpg';
        }else{
            $path = 'uploads/products/';
            $img = $path . $image;
            $this->image = $img;
        }
    }
    public function set_categorie($categorie)
    {
        foreach($categorie as $value){
            $this->categorie[] = $value;
        }
    }
    public function set_idCategorie($idCategorie)
    {
        foreach($idCategorie as $value){
            $this->idCategorie[] = $value;
        }
    }
    public function set_special($special)
    {
        if(!$special){
            $this->special = null;
        }else{
        foreach($special as $value){
            $this->special[] = $value;
            }
        }
    }
    public function set_idSpecial($idSpecial)
    {
        if(!$idSpecial){
            $this->idSpecial = null;
        }else{
        foreach($idSpecial as $value){
            $this->idSpecial[] = $value;
            }
        }
    }
    public function set_date($date)
    {
        $this->date = $date;
    }
    public function set_quantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function accordion()
    {
        $data = [
            'Nom' => $this->nom,
            'Description' => $this->description,
            'Prix' => $this->prix,
            'Catégorie' => $this->categorie,
            'Date de création' => $this->date
        ];
        $accordion = '<div class="accordion accordion-flush" style="width: 22rem; id="accordion_product">';
            foreach($data as $key => $value){
                $accordion .= '<div class="accordion-item">';
                    $accordion .= '<h2 class="accordion-header" id="heading_' . $key . '">';
                        $accordion .= '<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_' . $key . '" aria-expanded="true" aria-controls="collapse_' . $key . '">';
                            $accordion .= $key;
                        $accordion .= '</button>';
                    $accordion .= '</h2>';
                    $accordion .= '<div id="collapse_' . $key . '" class="accordion-collapse collapse show" aria-labelledby="heading_' . $key . '" data-bs-parent="#accordion_product">';
                        $accordion .= '<div class="accordion-body">';
                        if(is_array($value)){
                            foreach($value as $item){
                                $accordion .= '<p>' . $item . '  </p>';
                            }
                        } else {
                            $accordion .= $value;
                        }
                        $accordion .= '</div>';
                    $accordion .= '</div>';
                $accordion .= '</div>';
            }
        $accordion .= '</div>';
        return $accordion;
    }

}