var loginForm = document.getElementById('login_form');
loginForm.addEventListener('submit', function(e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: $(this).attr('action'),
        data: $(this).serialize(),
        dataType: 'json',
        success: function(data) {
            if (data.status == 'success') {
                $('#alert_message_login_form').removeClass('d-none');
                $('#alert_message_login_form').addClass('form_message success');
                $('#alert_message_login_form').html(data.message);
                setTimeout(function() {
                    window.location.href = data.redirect;
                }, 3000);
            }
            if (data.status == 'error') {
                $('#alert_message_login_form').removeClass('d-none');
                $('#alert_message_login_form').addClass('form_message error');
                $('#alert_message_login_form').html(data.message);
                setTimeout(function() {
                    $('#alert_message_login_form').html('');
                }, 3000);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
                $('#alert_message_login_form').removeClass('d-none');
                $('#alert_message_login_form').addClass('form_message error');
                $('#alert_message_login_form').html(response.message);
                setTimeout(function() {
                    $('#alert_message_login_form').html('');
                }, 3000);
        }
    });
});