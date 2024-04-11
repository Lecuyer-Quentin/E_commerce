$(document).ready(function() {
    $('#login_form').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data) {
                if (data === 'success') {
                    $('#success-message').html('Connexion réussie. Vous allez être redirigé vers la page d\'accueil.');
                    setTimeout(function() {
                        $('#success-message').html('');
                        $('#login_form').trigger('reset');
                        window.location.href = 'index.php';
                    }, 2000);
                } else {
                    $('#error-message').html(data);
                    //setTimeout(function() {
                    //    $('#error-message').html('');
                    //}, 2000);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#error-message').html('Une erreur est survenue lors de la connexion. Veuillez réessayer.');
                setTimeout(function() {
                    $('#error-message').html('');
                }, 2000);
            }
        });
    });
    $('#register_form').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data) {
                if (data === 'success') {
                    $('#success-message').html('Inscription réussie.');
                    setTimeout(function() {
                        $('#success-message').html('');
                        window.location.href = 'index.php';
                    }, 2000);
                } else {
                    $('#error-message').html(data);
                    setTimeout(function() {
                        $('#error-message').html('');
                    }, 2000);
                }
            },
            error: function( jqXhr, textStatus, errorThrown ){
                $('#error-message').html('Une erreur est survenue, veuillez réessayer.');
                setTimeout(function() {
                    $('#error-message').html('');
                }, 2000);
            }
        });
    });
    $('#add_product_form').submit(function(e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function(data) {
                if (data === 'success') {
                    $('#success-message').html('Produit ajouté avec succès.');
                    setTimeout(async function() {
                        $('#add_product_form').trigger('reset');
                        $('#success-message').html('');
                    }, 2000);
                } else {
                    $('#error-message').html(data);
                    setTimeout(async function() {
                        $('#error-message').html('');
                    }, 2000);
                }
            },
            error: function(jqXhr, textStatus, errorThrown) {
                $('#error-message').html('Une erreur est survenue, veuillez réessayer.');
                setTimeout(async function() {
                    $('#error-message').html('');
                }, 2000);
            }
        });
    });
    $('#add_user_form').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data) {
                if (data === 'success') {
                    $('#success-message').html('Utilisateur ajouté avec succès.');
                    setTimeout(function() {
                        $('#add_user_form').trigger('reset');
                        $('#success-message').html('');
                    }, 2000);
                } else {
                    $('#error-message').html(data);
                    setTimeout(function() {
                        $('#error-message').html('');
                    }, 2000);
                }
            },
            error: function(jqXhr, textStatus, errorThrown) {
                $('#error-message').html('Une erreur est survenue, veuillez réessayer.');
                setTimeout(function() {
                    $('#error-message').html('');
                }, 2000);
            }
        });
    });
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

