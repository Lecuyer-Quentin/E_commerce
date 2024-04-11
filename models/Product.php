<?php

class Product{

    public $id_produit;
    public $nom;
    public $description;
    public $prix;
    public $image;
    public $id_categorie;
    public $date_creation;
    public $quantity;

     
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
            'date_creation' => $this->date_creation,
        ];
    }

    public function get_image(){
        ////global $pdo;
        ////$p = new Products($pdo);
        ////$p->id_produit = $this->id_produit;
        ////$product = $p->read_single();
        //if(isset($this->image)){
        //    $slash = strstr($this->image, '/');
        //    $image_path = substr($slash, 1); // This will get everything after the first slash
        //    return $image_path;
        //}else{
            return 'uploads/default.jpg';
        //}
    }

    public function getId(){
        return $this->id_produit;
    }
    //! Mettre les bons return
    public function translate($id_categorie){
        switch($id_categorie){
            case 1:
                return 'Vêtements';
            case 2:
                return 'Chaussures';
            case 3:
                return 'Accessoires';
            case 4:
                return 'Appareils électroniques';
            case 5:
                return 'Articles ménagers';
            default:
                return 'Autres';
        }
    }

    public function card_md()
    {
        $temp_special = [
            'Vêtements' => 'text-bg-primary',
            'Chaussures' => 'text-bg-success',
            'Nouveau' => 'text-bg-danger'
        ];
        
        $card = '<div class="card text-white bg-dark text-center p-2 position-relative" style="width: 22rem; height: 30rem;">';

        $card .= '<div class="position-absolute d-flex flex-column justify-content-start align-items-start">';
            foreach($temp_special as $key => $value){
                $card .= '<span class="badge badge-pill '. $value .' my-1 mx-1">' . $key . '</span>';
            }
        $card .= '</div>';

            $card .= '<img src="' . $this->get_image() . '" class="card-img-top w-100 h-100" alt="' . $this->nom . '">';

            $card .= '<div class="card-img-overlay w-100 h-100 d-flex flex-column justify-content-end">';
                
                $card .= '<div class="card-footer d-flex justify-content-between align-item-center border border-3 border-dark border-start-0 border-end-0 shadow">';
                    $card .= '<p class="card-text text-white my-2 font-weight-bold text-left font-size-5">' . $this->prix . ' €</p>';

                    $card .= '<div class="d-flex justify-content-around">';
                        $card .= '<form action="controllers/cart/add.php" method="post">';
                            $card .= '<input type="hidden" name="id" value="' . $this->id_produit . '">';
                            $card .= '<input type="hidden" name="quantity" value="1">';
                            $card .= '<button type="submit" class="btn btn-primary">';
                                $card .= '<img src="assets/svg/add_cart.svg" alt="add to cart" width="20" height="20">';
                            $card .= '</button>';
                        $card .= '</form>';
                        $card .= '<form action="controllers/cart/remove.php" method="post">';
                            $card .= '<input type="hidden" name="id" value="' . $this->id_produit . '">';
                            $card .= '<input type="hidden" name="quantity" value="1">';
                            $card .= '<button type="submit" class="btn btn-danger mx-2">';
                                $card .= '<img src="assets/svg/remove_cart.svg" alt="remove from cart" width="20" height="20">';
                            $card .= '</button>';
                        $card .= '</form>';
                    $card .=  '</div>';
                $card .= '</div>';
            $card .= '</div>';

            
        $card .= '</div>';
        return $card;
    }
    public function card_sm()
    {
        $card = '<div class="card text-white bg-dark text-center p-2 position-relative" style="width: 8rem; height: 10rem;">';
            $card .= '<img src="' . $this->get_image() . '" class="card-img w-100 h-100" alt="' . $this->nom . '">';
            $card .= '<div class="card-img-overlay w-100 h-100 d-flex flex-column justify-content-end">';
                $card .= '<button type="button" class="btn btn-info">';
                    $card .= '<a href="index.php?page=product&id=' . $this->id_produit . '" class="text-white text-decoration-none d-flex justify-content-around align-items-center">';
                        $card .=  $this->prix . ' €</>';
                        $card .= '<img src="assets/svg/arrow_right.svg" alt="voir" width="20" height="20">';
                    $card .= '</a>';
                $card .= '</button>';     
            $card .= '</div>';
        $card .= '</div>';
        return $card;
    }
    public function card_hero()
    {
        $card = '<div class="card text-white bg-dark text-center p-2 position-relative" style="width: 8rem; height: 10rem;">';
            $card .= '<img src="' . $this->get_image() . '" class="card-img w-100 h-100" alt="' . $this->nom . '">';

            $card .= '<div class="card-img-overlay w-100 h-100 d-flex flex-column justify-content-end opacity-50">'; 
                $card .= '<button type="button" class="btn btn-info">';
                    $card .= '<a href="index.php?page=product&id=' . $this->id_produit . '" class="text-white text-decoration-none d-flex justify-content-around align-items-center">';
                        $card .=  $this->prix . ' €</>';
                        $card .= '<img src="assets/svg/arrow_right.svg" alt="voir" width="20" height="20">';
                    $card .= '</a>';
                $card .= '</button>';
            $card .= '</div>';

        $card .= '</div>';
        return $card;
    }
    public function card_in_cart()
    {
        $card = '<div class="card text-white bg-dark position-relative w-100 d-flex justify-content-between align-items-center m-2">';

            $card .= '<div class="card-header w-100 d-flex justify-content-between align-items-center">';
                $card .= '<p class="card-title">' . $this->nom . '</p>';
                $card .= '<div class ="d-flex justify-content-around">';
                    $card .= '<form action="controllers/cart/remove.php" method="post">';
                        $card .= '<input type="hidden" name="id" value="' . $this->id_produit . '">';
                        $card .= '<input type="hidden" name="quantity" value="1">';
                        $card .= '<button type="submit" class="btn btn-dark">';
                            $card .= '<img src="assets/svg/remove_cart.svg" alt="remove from cart" width="20" height="20">';
                        $card .= '</button>';
                    $card .= '</form>';
                    $card .= '<form action="controllers/cart/add.php" method="post">';
                        $card .= '<input type="hidden" name="id" value="' . $this->id_produit . '">';
                        $card .= '<input type="hidden" name="quantity" value="1">';
                        $card .= '<button type="submit" class="btn btn-dark">';
                            $card .= '<img src="assets/svg/add_cart.svg" alt="add to cart" width="20" height="20">';
                        $card .= '</button>';
                    $card .= '</form>';
                $card .= '</div>';
            $card .= '</div>';

            $card .= '<div class="card-body w-100 d-flex justify-content-between align-items-center">';

                $card .= '<div style="width: 8rem; height: 6rem;">';
                    $card .= '<img style="width: 8rem; height: 6rem;" src="' . $this->get_image() . '" class="card-img" alt="' . $this->nom . '">';
                $card .= '</div>';

                $card .= '<table class="table table-dark table-striped table-bordered table-hover table-sm w-50 text-center">';
                $card .= '<thead>';
                    $card .= '<tr>';
                        $card .= '<th scope="col">Prix</th>';
                        $card .= '<th scope="col">Quantité</th>';
                    $card .= '</tr>';
                $card .= '</thead>';
                $card .= '<tbody>';
                    $card .= '<tr>';
                        $card .= '<td>' . $this->prix . ' €</td>';
                        $card .= '<td>' . $this->quantity . '</td>';
                    $card .= '</tr>';
                $card .= '</tbody>';
                $card .= '</table>';

            $card .= '</div>';

            $card .= '<div class="card-footer w-100 d-flex justify-content-between align-items-center">';
                $card.= '<a href="index.php?page=product&id=' . $this->id_produit . '" class="btn btn-primary">Voir le produit</a>';
                $card .= '<p>Total: ' . $this->prix * $this->quantity . ' €</p>';
            $card .=  '</div>';

        $card .= '</div>';
        return $card;
    }
    public function card_search()
    {
        $card = '<div class="card bg-light m-2" style="height: 6rem; width: 15rem;">';
            $card .= '<div class="card-body w-100 d-flex justify-content-between align-items-center">';
                $card .= '<div class="d-flex flex-column">';
                    $card .= "<span>$this->nom</span><br />";
                    $card .= "<span><strong>$this->prix $</strong></span>";
                $card .= "</div>";
                $card .= '<a href="index.php?page=product&id=' . $this->id_produit . '" class="btn btn-primary">Voir</a>';
            $card .= '</div>';
        $card .= '</div>';
        return $card;
    }
    public function accordion()
    {
        $temp_data = [
            'Nom' => $this->nom,
            'Description' => $this->description,
            'Prix' => $this->prix,
            'Catégorie' => $this->translate($this->id_categorie),
            'Date de création' => $this->date_creation
        ];
        $accordion = '<div class="accordion accordion-flush" style="width: 22rem; id="accordion_product">';
            foreach($temp_data as $key => $value){
                $accordion .= '<div class="accordion-item">';
                    $accordion .= '<h2 class="accordion-header" id="heading_' . $key . '">';
                        $accordion .= '<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_' . $key . '" aria-expanded="true" aria-controls="collapse_' . $key . '">';
                            $accordion .= $key;
                        $accordion .= '</button>';
                    $accordion .= '</h2>';
                    $accordion .= '<div id="collapse_' . $key . '" class="accordion-collapse collapse show" aria-labelledby="heading_' . $key . '" data-bs-parent="#accordion_product">';
                        $accordion .= '<div class="accordion-body">';
                            $accordion .= $value;
                        $accordion .= '</div>';
                    $accordion .= '</div>';
                $accordion .= '</div>';
            }
        $accordion .= '</div>';
        return $accordion;
    }
}