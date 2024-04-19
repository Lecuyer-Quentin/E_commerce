// Fonctionnalité: Login
var loginForm = document.getElementById('login_form');
loginForm.addEventListener('submit', function(e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: $(this).attr('action'),
        data: $(this).serialize(),
        success: function(data) {
            if (data === 'success') {
                $('#success-message').html('Connexion réussie.');
                setTimeout(function() {
                    $('#success-message').html('');
                    $('#login_form').trigger('reset');
                    window.location.href = 'index.php';
                }, 2000);
            } else {
                $('#error-message').html(data);
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