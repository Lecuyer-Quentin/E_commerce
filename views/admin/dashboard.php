

<?php
require_once 'utils/get_JSON.php';
$data = get_JSON('data.json', 'views', 'dashboard');
$header = $data['header'];
$items = $data['items'];

?>



<section class="container container-fluid mt-2">
    <?php
        foreach($header as $line){
            $type = $line['type'];
            $content = $line['content'];
            echo "<$type>$content</$type>";
        }
    ?>

    <div class="mt-5 my-5 d-flex justify-content-center flex-wrap">
        <?php
            foreach($items as $item){
                $title = $item['title'];
                $content = $item['description'];
                $value = $item['value'];
                $modal = $item['modal'] ?? null;
                echo "<div class='card m-3 shadow p-10' style='min-width: 18rem;'>
                        <div class='card-header bg-dark bg-gradient text-light d-flex flex-column justify-content-end'>
                            <h5>$title</h5>
                            <p>$content</p>
                        </div>
                        <div class='card-body d-flex flex-column justify-content-center'>";

                        echo " <form method='post'>
                        <button type='submit' class='btn btn-primary w-100 mb-2' name='button' value=$value>
                            <span>Détails des $title</span>
                        </button>
                    </form>";
                            if($title == 'Utilisateurs'){
                                require_once 'views/admin/users/add.php';
                            } else if($title == 'Produits'){
                                require_once 'views/admin/products/add.php';
                            }


                    echo "</div></div>";
            }
        ?>
</section>

<?php echo $modal_add_user->render(); ?>
<?php echo $modal_add_product->render(); ?>

