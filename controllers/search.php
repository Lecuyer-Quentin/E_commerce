<?php
include_once '../models/ProduitRepo.php';
include_once '../models/Card.php';
include_once '../config/database.php';
include_once '../utils/error_message.php';


if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $error_search = [];
    if(!isset($_POST['search']) || empty($_POST['search'])) {
        $error_search[] = translateErrorMessage('Error[SEARCH]');
        exit;
    }
    $search = $_POST['search'];
    $search = stripslashes($search);
    $search = htmlspecialchars($search);
    $search = strip_tags($search);
    $search = trim($search);
    

    try{
        $product = new ProduitRepo($pdo);
        $products = $product->search($search);
        if($products) {
            foreach($products as $product) {
                $data = $product->get_data();
                $card = new Card($data);
                echo $card->card_search();
            }
        }else{
            echo 'success';
        }
    } catch (Exception $e) {
        $technical_error_message = $e->getMessage();
        $error_search[] = translateErrorMessage($technical_error_message);
        echo nl2br(htmlspecialchars(implode('\n', $error_search)));
        error_log($e->getMessage());
    }
}


?>

<script>
    $document.ready(function() {
        $('#search_form').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data) {
                if(data !== 'success') {
                    $('#search_result').html(data);
                }else{
                    $('#search_error').html('Resultat non trouver');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#search_error').html('Une erreur est survenue lors de la recherche.');
            }
        });
    }
    );
});

</script>
