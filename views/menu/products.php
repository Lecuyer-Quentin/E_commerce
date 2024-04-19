<?php
    $categories = new CategorieRepo($pdo);
    $categories = $categories->read();
    
?>

<nav class="navbar navbar-expand-xl navbar-light mt-3">
    
<div class="btn_1 d-xl-none w-100">
    <button class="navbar-toggler w-100 border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#products_menu" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span>Voir les catégories</span>
    </button>
</div>   

    <div class="collapse navbar-collapse d-flex justify-content-center" id="products_menu">

        <ul class="navbar-nav d-flex flex-row justify-content-center flex-wrap">
            <?php foreach($categories as $category) : ?>
                <li class="nav-item m-1">
                    <form method="post">
                        <button type="submit" name="category_nav" class="btn_1" value="<?= $category->get_nom() ?>">
                            <?= $category->get_nom() ?>
                        </button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</nav>