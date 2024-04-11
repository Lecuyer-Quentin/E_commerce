<?php
require_once 'Products.php';
//require_once 'utils/get_image.php';

class Cart {
    public $cart;
    public $total;
    public $count;

    public $id_produit;

    public function __construct() {
        $this->cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        $this->total = 0;
        $this->count = 0;
    }
    public function getCart() {
        return $this->cart;
    }
    public function getTotal() {
        return $this->total;
    }
    public function addToCart($product, $quantity) {
        if (isset($this->cart[$product->id_produit])) {
            $this->cart[$product->id_produit]['quantity'] += $quantity;
        } else {
            $this->cart[$product->id_produit]['product'] = $product;
            $this->cart[$product->id_produit]['quantity'] = $quantity;
        }
        $_SESSION['cart'] = $this->cart;
    }

    public function removeFromCart($id, $quantity) {
        if (isset($this->cart[$id])) {
            $this->cart[$id]['quantity'] -= $quantity;
            if ($this->cart[$id]['quantity'] <= 0) {
                unset($this->cart[$id]);
            }
        }
        $this->total -= $quantity;
        $_SESSION['cart'] = $this->cart;
    }
    public function emptyCart() {
        $this->cart = [];
        $this->total = 0;
        $this->count = 0;
        $_SESSION['cart'] = $this->cart;
    }
    //! À revoir
    //? fonctionne dans cart_trigger mais compte double dans displayCart
   public function count(){
       foreach($this->cart as $product){
           $this->count += $product['quantity'];
       }
       return $this->count;
   }//!
    //! À revoir

    public function cart_trigger() {
        $trigger = "<button class='nav-link position-relative' type='button' data-bs-toggle='offcanvas' data-bs-target='#offcanvasCart' aria-controls='offcanvasExample'>";
        $trigger .= "<img src='assets/svg/cart.svg' alt='Mon Panier' width='20' height='20'>";
        $trigger .= '<span class="position-absolute top-50 start-70 font-size-6">';
        $trigger .= '('.$this->count().')';
        $trigger .= '<span class="visually-hidden">items in cart</span>';
        $trigger .= '</span>';
        $trigger .= '</button>';
        return $trigger;
    }
    public function off_canvas() {
        $content = $this->displayCart();
        $off_canvas = "<section class='offcanvas offcanvas-end' data-bs-scroll='true' tabindex='-1' id='offcanvasCart' aria-labelledby='offcanvasExampleLabel' aria-controls='offcanvasWithBothOptions'>";
            $off_canvas .= "<div class='offcanvas-header'>";
                $off_canvas .= "<h5 class='offcanvas-title' id='offcanvasExampleLabel'>Mon Panier</h5>";
                $off_canvas .= "<button type='button' class='btn-close' data-bs-dismiss='offcanvas' aria-label='Close'></button>";
            $off_canvas .= "</div>";
            $off_canvas .= "<div class='offcanvas-body'>";
                $off_canvas .= $content;
            $off_canvas .= "</div>";
        $off_canvas .= "</section>";
        return $off_canvas;
    }
    public function displayCart() {
        $output = '';
        if(empty($this->cart)) {
            return "<p>Votre panier est vide</p>";
        }
        $output .= "<article class='d-flex flex-column justify-content-between align-items-center min-vh-100'>";
            $output .= "<ul class='list-group list-group-flush'>";
                foreach($this->cart as $id => $product) {
                    //$img = get_image($product['product']->id_produit);
                    //var_dump($img);
                    $p = $product['product'];
                    $p->quantity = $product['quantity'];
                    //? Bouger autrepart
                    $this->total += $p->prix * $p->quantity;
                    $output .= $p->card_in_cart();
                }        
            $output .= "</ul>";
            $output .= "<aside class='d-flex flex-column justify-content-between align-items-center'>";
                $output .= "<p><strong>Total: ".$this->total." €</strong></p>";
                $output .= "<p>Nombre d'articles: ".$this->count."</p>";

                $output .= "<div class='d-flex justify-content-center mb-3'>";
                    $output .= "<a href='cart.php' class='btn btn-primary m-1'>Voir le panier</a>";
                    $output .= "<form action='controllers/cart/destroy.php' method='post'>";
                        $output .= "<button type='submit' class='btn btn-danger m-1'>Vider le panier</button>";
                    $output .= "</form>";
                $output .= "</div>";

                $output .="<div>";
                    $output .= "<a href='checkout.php' type='button' class='btn btn-success'>Commander</a>";
                $output .= "</div>";

            $output .= "</aside>";
        $output .= "</article>";
        return $output;
        
    }
}
