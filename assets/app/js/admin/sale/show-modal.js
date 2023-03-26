$( document ).ready(function() {
    $(document).on('click', '.sale_show_button', function () {
        let url = $(this).data('url');

        show(url);
    });

    function show(url) {
        $.ajax({
            type: 'GET',
            url: url,
            success: function(data) {
                $("#show-modal-content").html(data);
            },
            error: function() {
                Toast.fire({
                    icon: 'error', title: 'Se ha producido un error'
                });
            }
        });
    }
});