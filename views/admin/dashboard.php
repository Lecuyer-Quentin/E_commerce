

<?php
$data = get_JSON('data.json', 'views', 'dashboard');
$header = $data['header'];
$cards = $data['cards'];
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
            foreach($cards as $c){  
                $c = new Card($c);
                echo $c->card_dash();                    
            }
        ?>
    </div>
</section>

