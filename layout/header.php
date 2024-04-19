<header class="navbar fixed-top bg-light shadow-sm d-flex justify-content-end align-items-center justify-content-md-between ">

    <div class="d-none d-md-block" style="width: 14rem;">
        <a href="index.php">
            <img src="assets/images/logo.png" alt="logo" class="logo">
        </a>
    </div>

    
    <div class="d-none d-xl-flex">
        
        <form id="search_form" action="controllers/search.php" method="POST">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="À l'assaut de la perle rare">
                            <button type="submit" class="btn btn-primary">
                                <img src="assets/svg/search_heart.svg" width="40" height="40" alt="Rechercher">
                            </button>
                        </div>
                    </form>
                    <div id="search_error" class="text-danger"></div>
                    <div id="search_result"></div>
    </div>
    <?php require_once 'views/menu/navigation.php'; ?>  
    <div id="search_result" class="container shadow d-flex flex-wrap justify-content-center overflow-auto scrollbar" style="max-height: 30vh;"></div>
    <div id="search_error" class="container shadow d-flex justify-content-center"></div>


</header>

