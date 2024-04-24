const removeUser = document.getElementById('action_btn_users_table');
removeUser.addEventListener('submit', function (e) {
    e.preventDefault();
    
    $.ajax({
        type: 'POST',
        url: $(this).attr('action'),
        data: $(this).serialize(),
        dataType: 'json',
        success: function(data) {
            if (data.status == 'success') {
                $('#table_alert_users_table').removeClass('d-none');
                $('#table_alert_users_table').addClass('form_message success');
                $('#table_alert_users_table').html(data.message);
                setTimeout(function() {
                    $('#table_alert_users_table').html('');
                }, 3000);
            }
            if (data.status == 'error') {
                $('#table_alert_users_table').removeClass('d-none');
                $('#table_alert_users_table').addClass('form_message error');
                $('#table_alert_users_table').html(data.message);
                setTimeout(function() {
                    $('#table_alert_users_table').html('');
                }, 3000);
            }
        }
    });
});
