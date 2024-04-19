<?php

class Card{
    private $data;
    public function __construct($data){
        $this->set_data($data);        
    }
    private function set_data($data){
        foreach($data as $key => $value){
            $this->data[$key] = $value;
        }
    }
    
    private function get_data(){
        return $this->data;
    }
    private function get_data_of($key){
        return $this->data[$key];
    }

    public function card_dash(){
            $card = "<div class='card m-3 shadow p-10' style='width: 18rem;'>";
                $card .= "<div class='card-header bg-dark bg-gradient text-light d-flex flex-column justify-content-end position-relative'>";
                    $card .= "<h5>".$this->get_data_of('title')."</h5>";
                    $card .= "<p>".$this->get_data_of('description')."</p>";
                    $card .= "<button type='button' data-bs-toggle='collapse' data-bs-target='#test.".$this->get_data_of('title')."' aria-expanded='false' aria-controls='collapseExample ' class='position-absolute top-0 end-0 btn'>";
                        $card .= "<img src='assets/svg/arrow_square_down.svg' alt='arrow' width='20' height='20'>";
                    $card .= "</button>";
                $card .= "</div>";

                $card .= "<div class='card-body d-flex flex-column justify-content-center'>";
                    $card .= "<form method='post'>";
                        $card .= "<button type='submit' class='btn btn-primary w-100 mb-2' name='admin_nav' value=".$this->get_data_of('value').">";
                            $card .= "<span>Détails des ".$this->get_data_of('title')."</span>";
                        $card .= "</button>";
                    $card .= "</form>";
                        if($this->get_data_of('value') == 'users') {
                            $modal = new Modal([
                                'btn_name' => 'Ajouter un utilisateur',
                                'btn_target' => '#add_user_modal',
                                'modal_id' => 'add_user_modal',
                                'modal_label' => 'add_user_modal_label',
                                'modal_body' => require_once 'views/admin/users/add.php']);
                            $card .= $modal->modal_trigger();
                        } else if($this->get_data_of('value') == 'products') {
                            $modal = new Modal([
                                'btn_name' => 'Ajouter un produit',
                                'btn_target' => '#add_product_modal',
                                'modal_id' => 'add_product_modal',
                                'modal_label' => 'add_product_modal_label',
                                'modal_body' => require_once 'views/admin/products/add.php']);
                            $card .= $modal->modal_trigger();
                        }
                $card .= "</div>";

                $card .= "<div class='collapse' id='test.".$this->get_data_of('title')."'>";
                    $card .= "<div class='card card-footer'>";
                        if($this->get_data_of('footer') != null) {
                            $card .= "<form method='post'>";
                                $card .= "<button type='submit' class='btn btn-primary w-100 mb-2' name='admin_nav' value=".$this->get_data_of('footer').">";
                                    $card .= "<span>Gestions des ".ucfirst($this->get_data_of('footer'))."</span>";
                                $card .= "</button>";
                            $card .= "</form>";
                        } else {
                            $card .= "<p class='text-center'>Pas de gestion disponible</p>";
                        }
                    $card .= "</div>";
                $card .= "</div>";
            $card .= "</div>";
        return $card;
    }

    public function card_sm()
    {
        $card = '<div class="card testHover text-white bg-dark text-center p-2 position-relative" style="width: 8rem; height: 10rem;">';
            $card .= '<img src="' . $this->get_data_of('image') .'" class="card-img w-100 h-100" alt="' . $this->get_data_of('nom') . '">';
            $card .= '<div class="card-img-overlay w-100 h-100 d-flex flex-column justify-content-end opacity-50">'; 
                    $card .= '<a href="index.php?page=product&id=' . $this->get_data_of('idProduit') . '" class="btn btn-info text-white d-flex justify-content-around align-items-center">';
                        $card .=  $this->get_data_of('prix') . ' €';
                        $card .= '<img src="assets/svg/arrow_right.svg" alt="voir" width="20" height="20">';
                    $card .= '</a>';
            $card .= '</div>';
        $card .= '</div>';
        return $card;
    }

    public function card_md(){
        
        $card = '<div class="card text-white bg-dark text-center p-2 position-relative" style="width: 22rem; height: 30rem;">';
            if(!empty($this->get_data_of('special'))){
                $card .= '<div class="position-absolute top-0 start-0">';
                    foreach($this->get_data_of('special') as $key => $value){
                        $card .= '<span class="badge bg-primary my-1 mx-1">' . $value . '</span>';
                    }
                $card .= '</div>';
            }

            $card .= '<img src="' . $this->get_data_of('image') . '" class="card-img-top w-100 h-100" alt="' . $this->get_data_of('nom') . '">';
            $card .= '<div class="card-img-overlay w-100 h-100 d-flex flex-column justify-content-end">';

                $card .= '<div class="position-absolute top-0 end-0">';
                    $card .= '<form action="controllers/favorite/add_favorite.php" method="post" class="">';
                        $card .= '<input type="hidden" name="id" value="' . $this->get_data_of('idProduit') . '">';
                        $card .= '<button type="submit" class="btn btn-link" id="color-change">';
                            $card .= (isset($_SESSION['favorite'])) ? '<img src="assets/svg/heart_bm_red.svg" alt="add to favorite" width="20" height="20">' : '<img src="assets/svg/heart_bm_grey.svg" alt="add to favorite" width="20" height="20">';
                        $card .= '</button>';
                    $card .= '</form>';
                    //$card .= '<form action="controllers/favorite/remove_favorite.php" method="post" class="">';
                    //    $card .= '<input type="hidden" name="id" value="' . $this->get_data_of('idProduit') . '">';
                    //    $card .= '<button type="submit" class="btn btn-link" id="color-change">';
                    //        $card .= (!isset($_COOKIE['favorite']) || !isset($_SESSION['favorite'])) ? '<img src="assets/svg/heart_bm_red.svg" alt="add to favorite" width="20" height="20">' : '<img src="assets/svg/heart_bm_grey.svg" alt="add to favorite" width="20" height="20">';
                    //    $card .= '</button>';
                    //$card .= '</form>';
                $card .= '</div>';

                $card .= '<div class="card-footer d-flex justify-content-between align-item-center border border-3 border-dark border-start-0 border-end-0 shadow">';
                    $card .= '<p class="card-text text-white my-2 font-weight-bold text-left font-size-5">' . $this->get_data_of('prix') . ' €</p>';

                    $card .= '<div class="d-flex justify-content-around">';

                        $card .= '<form action="controllers/cart/add.php" method="post">';
                            $card .= '<input type="hidden" name="id" value="' . $this->get_data_of('idProduit') . '">';
                            $card .= '<input type="hidden" name="quantity" value="1">';
                            $card .= '<button type="submit" class="btn btn-primary">';
                                $card .= '<img src="assets/svg/add_cart.svg" alt="add to cart" width="20" height="20">';
                            $card .= '</button>';
                        $card .= '</form>';

                        $card .= '<form action="controllers/cart/remove.php" method="post">';
                            $card .= '<input type="hidden" name="id" value="' . $this->get_data_of('idProduit') . '">';
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

    public function card_in_cart()
    {
        $card = '<div class="card text-white bg-dark position-relative w-100 d-flex justify-content-between align-items-center m-2">';

            $card .= '<div class="card-header w-100 d-flex justify-content-between align-items-center">';
                $card .= '<p class="card-title">' . $this->get_data_of('nom') . '</p>';
                $card .= '<div class ="d-flex justify-content-around">';
                    $card .= '<form action="controllers/cart/remove.php" method="post">';
                        $card .= '<input type="hidden" name="id" value="' . $this->get_data_of('idProduit') . '">';
                        $card .= '<input type="hidden" name="quantity" value="1">';
                        $card .= '<button type="submit" class="btn btn-dark">';
                            $card .= '<img src="assets/svg/remove_cart.svg" alt="remove from cart" width="20" height="20">';
                        $card .= '</button>';
                    $card .= '</form>';
                    $card .= '<form action="controllers/cart/add.php" method="post">';
                        $card .= '<input type="hidden" name="id" value="' . $this->get_data_of('idProduit') . '">';
                        $card .= '<input type="hidden" name="quantity" value="1">';
                        $card .= '<button type="submit" class="btn btn-dark">';
                            $card .= '<img src="assets/svg/add_cart.svg" alt="add to cart" width="20" height="20">';
                        $card .= '</button>';
                    $card .= '</form>';
                $card .= '</div>';
            $card .= '</div>';

            $card .= '<div class="card-body w-100 d-flex justify-content-between align-items-center">';

                $card .= '<div style="width: 8rem; height: 6rem;">';
                    $card .= '<img style="width: 8rem; height: 6rem;" src="' . $this->get_data_of('image') . '" class="card-img" alt="' . $this->get_data_of('nom') . '">';
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
                        $card .= '<td>' . $this->get_data_of('prix') . ' €</td>';
                        $card .= '<td>' . $this->get_data_of('quantity') . '</td>';
                    $card .= '</tr>';
                $card .= '</tbody>';
                $card .= '</table>';

            $card .= '</div>';

            $card .= '<div class="card-footer w-100 d-flex justify-content-between align-items-center">';
                $card.= '<a href="index.php?page=product&id=' . $this->get_data_of('idProduit') . '" class="btn btn-primary">Voir le produit</a>';
                $card .= '<p>Total: ' . $this->get_data_of('prix') * $this->get_data_of('quantity') . ' €</p>';
            $card .=  '</div>';

        $card .= '</div>';
        return $card;
    }

    public function card_search()
    {
        $card = '<div class="card bg-light m-2" style="height: 6rem; width: 15rem;">';
            $card .= '<div class="card-body w-100 d-flex justify-content-between align-items-center">';
                $card .= '<div class="d-flex flex-column">';
                    $card .= "<span>".$this->get_data_of('nom')."</span><br>";
                    $card .= "<span><strong>".$this->get_data_of('prix')." €</strong></span>";
                $card .= "</div>";
                $card .= '<a href="index.php?page=product&id=' . $this->get_data_of('idProduit') . '" class="btn btn-primary">Voir</a>';
            $card .= '</div>';
        $card .= '</div>';
        return $card;
    }

}