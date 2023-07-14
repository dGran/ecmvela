$( document ).ready(function() {
    $('.delete-action-button').click(function(e) {
        e.preventDefault();

        let clickedElement = $(this);
        let form = $(this).parents('form');
        let name = clickedElement.data('name');
        let img = clickedElement.data('img');

        deleteConfirmation(form, name, img)
    });

    function deleteConfirmation(form, name, img)
    {
        Swal.fire({
            title: 'Eliminar mascota',
            html: '<div class="border-b">' +
                '<p>¿Seguro que quieres eliminar la mascota?</p>' +
                '<div class="py-3 flex flex-col items-center">' +
                '<img src="'+img+'" alt="name" class="h-28 w-28 rounded-full object-cover shadow-lg border p-1">' +
                '<p class="pt-1.5 font-medium text-lg">'+name+'</p>' +
                '</div>' +
                '</div>',
            showCloseButton: true,
            showCancelButton: true,
            cancelButtonText: "Cancelar",
            confirmButtonText: "Sí, eliminar",
            customClass: {
                title: 'text-2xl font-medium',
                htmlContainer: 'text-base',
                closeButton: 'text-slate-300 text-[28px] hover:text-slate-500 focus:text-slate-500 focus:outline-none',
                cancelButton: 'px-6 py-2.5 bg-transparent font-medium text-xs leading-tight uppercase text-slate-400 hover:text-slate-700 focus:text-slate-700 focus:outline-none focus:ring-0 transition duration-150 ease-in-out',
                confirmButton: 'px-6 py-2.5 bg-red-500 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-red-600 hover:shadow-lg focus:bg-red-600 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-700 active:shadow-lg transition duration-150 ease-in-out',
            },
            buttonsStyling: false,
            reverseButtons: true,
            showLoaderOnConfirm: true,
        })
            .then(result => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
    }

    $(document).on('click', '.create_button', function () {
        let url = $(this).data('url');
        let container = $("#modal-static-content");

        container.html('');

        $.ajax({
            type: 'POST',
            url: url,
            success: function(data) {
                container.html(data);
                $('#pet_name').focus();
            },
            error: function() {
                Toast.fire({
                    icon: 'error', title: 'Se ha producido un error'
                });
            }
        });
    });

    $(document).on('click', '.edit_button', function () {
        let url = $(this).data('url');
        let container = $("#modal-static-content");

        container.html('');

        $.ajax({
            type: 'POST',
            url: url,
            success: function(data) {
                container.html(data);
                $('#pet_name').focus();
            },
            error: function() {
                Toast.fire({
                    icon: 'error', title: 'Se ha producido un error'
                });
            }
        });
    });

    $(document).on('input', '#pet_name', function (){
        if (!$(this).val()) {
            markErrorElement($(this))
        } else {
            unmarkErrorElement($(this));
        }
    });

    $(document).on('change', '#pet_category', function (){
        let TYPE_CAT_ID = 2;
        let TYPE_RABBIT_ID = 3;
        let TYPE_DOG_NO_IMAGE_PATH = '/build/app/img/pets/dog-no-image.png';
        let TYPE_CAT_NO_IMAGE_PATH = '/build/app/img/pets/cat-no-image.png';
        let TYPE_RABBIT_NO_IMAGE_PATH = '/build/app/img/pets/rabbit-no-image.png';
        let preview = $('#preview');

        if ($(this).val() == TYPE_CAT_ID) {
            if ($('#delete-image-button').is(':hidden')) {
                $('#preview').attr('src', TYPE_CAT_NO_IMAGE_PATH);
            }

            preview.data('defaultImage', TYPE_CAT_NO_IMAGE_PATH);
        } else if ($(this).val() == TYPE_RABBIT_ID) {
            if ($('#delete-image-button').is(':hidden')) {
                preview.attr('src', TYPE_RABBIT_NO_IMAGE_PATH);
            }

            preview.data('defaultImage', TYPE_RABBIT_NO_IMAGE_PATH);
        } else {
            if ($('#delete-image-button').is(':hidden')) {
                preview.attr('src', TYPE_DOG_NO_IMAGE_PATH);
            }

            preview.data('defaultImage', TYPE_DOG_NO_IMAGE_PATH);
        }

        if (!$(this).val()) {
            markErrorElement($(this))
        } else {
            unmarkErrorElement($(this));
        }
    });

    function markErrorElement(element) {
        let label = $("label[for='" + element.attr('id') + "']");

        label.removeClass('text-slate-600').addClass('text-red-600');
        element.removeClass('border-slate-300').addClass('border-red-500 focus:border-red-500 focus:ring-1 focus:ring-red-500').focus();

        $('#send-form-button').prop('disabled', true).removeClass('bg-blue-500 hover:bg-blue-600 focus:bg-blue-600').addClass('bg-blue-300 hover:bg-blue-300 focus:bg-blue-300 pointer-events-none');
    }

    function unmarkErrorElement(element) {
        let label = $("label[for='" + element.attr('id') + "']");

        label.removeClass('text-red-600').addClass('text-slate-600');
        element.removeClass('border-red-500 focus:border-red-500 focus:ring-1 focus:ring-red-500').addClass('border-slate-300');

        if (formIsValid()) {
            $('#send-form-button').prop('disabled', false).addClass('bg-blue-500 hover:bg-blue-600 focus:bg-blue-600').removeClass('bg-blue-300 hover:bg-blue-300 focus:bg-blue-300 pointer-events-none');
        }
    }

    function formIsValid() {
        return !(!$('#pet_name').val() || !$('#pet_category').val());
    }

    $(document).on('change', '#pet_imageFile', function(){
        let inputFile = this;
        let preview = $('#preview');

        if (inputFile.files && inputFile.files[0]) {
            let reader = new FileReader();

            reader.onload = function(e) {
                preview.attr('src', e.target.result);
            }
            reader.readAsDataURL(inputFile.files[0]);

            $('#delete-image-button').removeClass('hidden');
            $('#delete-current-image').val(0);
        }
    });

    $(document).on('click', '#load-image-button', function(){
        $('#pet_imageFile').trigger('click');
    });

    $(document).on('click', '#delete-image-button', function(){
        let preview = $('#preview');
        let defaultImage = preview.data('default-image');

        $('#pet_imageFile').val('');
        preview.attr('src', defaultImage);
        $('#delete-image-button').addClass('hidden');
        $('#delete-current-image').val(1);
    });

    $(document).on('click', '#send-form-button', function (e){
        e.preventDefault();

        if (formIsValid()) {
            let form = $(this).parents('form');
            let formData = new FormData(form[0]);

            $.ajax({
                type: 'POST',
                url: form.attr('action'),
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status === 'success') {
                        window.location.reload();
                    } else {
                        $('.ajax-form').replaceWith(response);
                    }
                }
            });
        } else {
            Toast.fire({
                icon: 'error', title: 'Comprueba los errores del formulario'
            });
        }
    });
});