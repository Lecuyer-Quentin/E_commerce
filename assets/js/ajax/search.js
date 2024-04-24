const form_search = document.getElementById('search_form');
form_search.addEventListener('submit', function(e){
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: $(this).attr('action'),
        data: $(this).serialize(),
        dataType: 'json',
        success: function(data){
            if(data.status == 'success'){
                $('#search_result').html('');
                $('#search_result').append(data.results);
            }
            if(data.status == 'error') {
                $('#search_result').html(data.message);
                setTimeout(function(){
                    $('#search_result').html('');
                }, 3000);
            }
        },
        error: function ( jqXhr, textStatus, errorThrown ){
            $('#search_result').html('Error: ' + errorThrown);
        }
    });
});

