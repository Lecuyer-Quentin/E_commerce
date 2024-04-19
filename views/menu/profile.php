<?php
$items = [
    ['label' => 'Profil', 'value' => 'Profil'],
    ['label' => 'Commandes', 'value' => 'Commandes'],
    ['label' => 'Favoris', 'value' => 'Favoris'],
    ['label' => 'Paramètres', 'value' => 'Paramètres']
];
?>
<nav class="navbar navbar-expand-md navbar-light bg-light">

    <button class="navbar-toggler mt-1 border-0 shadow-none focus:outline-none focus:ring-0" type="button" data-bs-toggle="collapse" data-bs-target="#profile_nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="profile_nav">
        <ul class="navbar-nav flex-row justify-content-center flex-wrap">
            <?php foreach($items as $item): ?>
                <li class="nav-item mx-1">
                    <form method="post" class="nav-link">
                        <button type="submit" name="profile_nav" class="btn btn-link text-decoration-none" value="<?php echo $item['value']; ?>">
                            <strong><?php echo $item['label']; ?></strong>
                        </button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</nav>