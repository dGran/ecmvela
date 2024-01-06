document.addEventListener('DOMContentLoaded', () => {
    const $listElements = {
        buttonCreate: $('.create_button'),
        buttonEdit: $('.edit_button'),
        buttonDelete: $('.delete_button'),
        buttonReminder: $('.reminder_button')
    }

    $listElements.buttonCreate.on("click", create);
    $listElements.buttonEdit.on("click", edit);
    $listElements.buttonDelete.on('click', function(e) {
        e.preventDefault();

        let clickedElement = $(this);
        let form = $(this).parents('form');
        let name = clickedElement.data('name');
        let date = clickedElement.data('date');

        $('.dropdown').removeClass('block').addClass('hidden');

        deleteConfirmation(form, name, date);
    });

    function create() {
        let url = $(this).data('url');
        let container = $("#modal-static-content");
        let date = $(this).data('date');

        container.html('');

        $.ajax({
            type: 'POST',
            url: url,
            data: {date: date},
            success: function(data) {
                container.html(data);
                $('#booking_date').focus();
            },
            error: function() {
                Toast.fire({
                    icon: 'error', title: 'Se ha producido un error'
                });
            }
        });
    }

    function edit() {
        $('.dropdown').removeClass('block').addClass('hidden');

        let url = $(this).data('url');
        let container = $("#modal-static-content");

        container.html('');

        $.ajax({
            type: 'POST',
            url: url,
            success: function(data) {
                container.html(data);
                $('#booking_date').focus();
            },
            error: function() {
                Toast.fire({
                    icon: 'error', title: 'Se ha producido un error'
                });
            }
        });
    }

    function deleteConfirmation(form, name, date){
        Swal.fire({
            html: '<div class="py-1.5">¿Seguro que quieres eliminar la cita?<p><strong>'+name+' a las '+date+'</strong></p></div>',
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
                if (result.value) {
                    form.submit();
                }
            });
    }

    // const $formElements = {
    //     inputDate: $('#booking_date'),
    //     inputPet: $('#booking_pet'),
    //     inputCustomer: $('#booking_customer'),
    //     inputEstimatedDuration: $('#booking_estimatedDuration'),
    //     buttonSubmit: $('#submit-button'),
    // };
    //
    // // $(document).on('change', $formElements, validateForm);
    //
    // $(document).on('change', '#booking_date, #booking_pet, #booking_estimatedDuration', validateForm);
    //
    //
    // function validateForm() {
    //     if ($('#booking_date').val() !== '' && $('#booking_pet').val() !== '' && $('#booking_estimatedDuration').val() !== '') {
    //         $('#submit-button').prop('disabled', false).addClass('bg-blue-500 hover:bg-blue-600 focus:bg-blue-600').removeClass('bg-blue-300 hover:bg-blue-300 focus:bg-blue-300 pointer-events-none');
    //     } else {
    //         $('#submit-button').prop('disabled', true).removeClass('bg-blue-500 hover:bg-blue-600 focus:bg-blue-600').addClass('bg-blue-300 hover:bg-blue-300 focus:bg-blue-300 pointer-events-none');
    //     }
    // }

    // $('#submit-button').on("click", function (e) {
    //     e.preventDefault();
    //
    //     let form = $(this).parents('form');
    //     let formData = new FormData(form[0]);
    //
    //     $.ajax({
    //         type: 'POST',
    //         url: form.attr('action'),
    //         data: formData,
    //         contentType: false,
    //         processData: false,
    //         success: function(response) {
    //             if (response.status === 'success') {
    //                 window.location.reload();
    //             } else {
    //                 $('.ajax-form').replaceWith(response);
    //             }
    //         }
    //     });
    // });
});