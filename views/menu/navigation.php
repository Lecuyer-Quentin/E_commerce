<?php
include_once 'utils/get_JSON.php';
$data = get_JSON('data.json', 'menu', 'nav');
$items = $data['items'];
?>

<button class="navbar-toggler border-0 shadow-none focus:outline-none focus:ring-0" style="margin-left:15px;" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav flex-row justify-content-end">
        <?php foreach($items as $item): ?>
            <li class="nav-item mx-2">
                <a class="nav-link" href="<?php echo $item['value']; ?>"><?php echo $item['label']; ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
    <div class="d-flex justify-content-end">
        <form method="post" action="controllers/search.php" id="search_form">
            <input type="text" name="search" placeholder="Search">
            <button type="submit">Search</button>
        </form>
    </div>

    <div id="search_result" class="container shadow d-flex flex-wrap justify-content-center overflow-auto scrollbar" style="max-height: 30vh;"></div>
    <div id="search_error"></div>
</div>