var registerForm = document.getElementById('register_form');
registerForm.addEventListener('submit', function(e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: $(this).attr('action'),
        data: $(this).serialize(),
        dataType: 'json',
        success: function(data) {
            if (data.status == 'success') {
                $('#alert_message_register_form').removeClass('d-none');
                $('#alert_message_register_form').addClass('form_message success');
                $('#alert_message_register_form').html(data.message);
                setTimeout(function() {
                    window.location.href = data.redirect;
                    $('#alert_message_register_form').removeClass('form_message success');
                }, 3000);
            }
            if (data.status == 'error') {
                $('#alert_message_register_form').removeClass('d-none');
                $('#alert_message_register_form').addClass('form_message error');
                $('#alert_message_register_form').html(data.message);
                setTimeout(function() {
                    $('#alert_message_register_form').html('');
                    $('#alert_message_register_form').removeClass('form_message error');
                }, 3000);
            }
        },
        error: function( jqXhr, textStatus, errorThrown ){
            $('#alert_message_register_form').removeClass('d-none');
            $('#alert_message_register_form').addClass('form_message error');
            $('#alert_message_register_form').html('Error: ' + errorThrown);
            setTimeout(function() {
                $('#alert_message_register_form').html('');
                $('#alert_message_register_form').removeClass('form_message error');
            }, 3000);
        }
    });
});