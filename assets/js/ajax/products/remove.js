const removeProduct = document.getElementById('action_btn_products_table');
removeProduct.addEventListener('submit', function (e) {
    e.preventDefault();
    
    $.ajax({
        type: 'POST',
        url: $(this).attr('action'),
        data: $(this).serialize(),
        dataType: 'json',
        success: function(data) {
            if (data.status == 'success') {
                $('#table_alert_products_table').removeClass('d-none');
                $('#table_alert_products_table').addClass('form_message success');
                $('#table_alert_products_table').html(data.message);
                setTimeout(function() {
                    $('#table_alert_products_table').html('');
                }, 3000);
            }
            if (data.status == 'error') {
                $('#table_alert_products_table').removeClass('d-none');
                $('#table_alert_products_table').addClass('form_message error');
                $('#table_alert_products_table').html(data.message);
                setTimeout(function() {
                    $('#table_alert_products_table').html('');
                }, 3000);
            }
        }
    });
});
