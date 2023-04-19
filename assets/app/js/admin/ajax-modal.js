$( document ).ready(function() {
    $(document).on('click', '.ajax_modal_button', function () {
        let url = $(this).data('url');

        show(url);
    });

    function show(url) {
        $("#modal-content").html('');

        $.ajax({
            type: 'GET',
            url: url,
            success: function(data) {
                $("#modal-content").html(data);
            },
            error: function() {
                Toast.fire({
                    icon: 'error', title: 'Se ha producido un error'
                });
            }
        });
    }

    $(document).on('click', '.ajax_static_modal_button', function () {
        let url = $(this).data('url');

        showStatic(url);
    });

    function showStatic(url) {
        $("#modal-static-content").html('');

        $.ajax({
            type: 'GET',
            url: url,
            success: function(data) {
                $("#modal-static-content").html(data);
            },
            error: function() {
                Toast.fire({
                    icon: 'error', title: 'Se ha producido un error'
                });
            }
        });
    }
});