var registerForm = document.getElementById('register_form');
registerForm.addEventListener('submit', function(e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: $(this).attr('action'),
        data: $(this).serialize(),
        success: function(data) {
            if (data === 'success') {
               // console.log('Inscription réussie.');
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
            //setTimeout(function() {
            //    $('#error-message').html('');
            //}, 2000);
        }
    });
});