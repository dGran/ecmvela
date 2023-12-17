$( document ).ready(function() {
    // $('.delete-action-button').click(function(e) {
    //     e.preventDefault();
    //
    //     let clickedElement = $(this);
    //     let form = $(this).parents('form');
    //     let name = clickedElement.data('name');
    //     let date = clickedElement.data('date');
    //
    //     $('.dropdown').removeClass('block').addClass('hidden');
    //
    //     deleteConfirmation(form, name, date);
    // });
    //
    // function deleteConfirmation(form, name, date)
    // {
    //     Swal.fire({
    //         html: '<div class="py-1.5">¿Seguro que quieres eliminar el festivo?<p><strong>'+date+' ('+name+')</strong></p></div>',
    //         showCloseButton: true,
    //         showCancelButton: true,
    //         cancelButtonText: "Cancelar",
    //         confirmButtonText: "Sí, eliminar",
    //         customClass: {
    //             title: 'text-2xl font-medium',
    //             htmlContainer: 'text-base',
    //             closeButton: 'text-slate-300 text-[28px] hover:text-slate-500 focus:text-slate-500 focus:outline-none',
    //             cancelButton: 'px-6 py-2.5 bg-transparent font-medium text-xs leading-tight uppercase text-slate-400 hover:text-slate-700 focus:text-slate-700 focus:outline-none focus:ring-0 transition duration-150 ease-in-out',
    //             confirmButton: 'px-6 py-2.5 bg-red-500 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-red-600 hover:shadow-lg focus:bg-red-600 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-700 active:shadow-lg transition duration-150 ease-in-out',
    //         },
    //         buttonsStyling: false,
    //         reverseButtons: true,
    //         showLoaderOnConfirm: true,
    //     })
    //         .then(result => {
    //             if (result.value) {
    //                 form.submit();
    //             }
    //         });
    // }
    //
    $(document).on('click', '.create_button', function () {
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
                $('#pet_name').focus();
            },
            error: function() {
                Toast.fire({
                    icon: 'error', title: 'Se ha producido un error'
                });
            }
        });
    });
    //
    // $(document).on('click', '.edit_button', function () {
    //     $('.dropdown').removeClass('block').addClass('hidden');
    //
    //     let url = $(this).data('url');
    //     let container = $("#modal-static-content");
    //
    //     container.html('');
    //
    //     $.ajax({
    //         type: 'POST',
    //         url: url,
    //         success: function(data) {
    //             container.html(data);
    //             $('#pet_name').focus();
    //         },
    //         error: function() {
    //             Toast.fire({
    //                 icon: 'error', title: 'Se ha producido un error'
    //             });
    //         }
    //     });
    // });
    //
    // $(document).on('change', '#public_holiday_date', function (){
    //     if (!$(this).val()) {
    //         markErrorElement($(this))
    //     } else {
    //         unmarkErrorElement($(this));
    //     }
    // });
    //
    // function markErrorElement(element) {
    //     let label = $("label[for='" + element.attr('id') + "']");
    //
    //     label.removeClass('text-slate-600').addClass('text-red-600');
    //     element.removeClass('border-slate-300').addClass('border-red-500 focus:border-red-500 focus:ring-1 focus:ring-red-500').focus();
    //
    //     $('#send-form-button').prop('disabled', true).removeClass('bg-blue-500 hover:bg-blue-600 focus:bg-blue-600').addClass('bg-blue-300 hover:bg-blue-300 focus:bg-blue-300 pointer-events-none');
    // }
    //
    // function unmarkErrorElement(element) {
    //     let label = $("label[for='" + element.attr('id') + "']");
    //
    //     label.removeClass('text-red-600').addClass('text-slate-600');
    //     element.removeClass('border-red-500 focus:border-red-500 focus:ring-1 focus:ring-red-500').addClass('border-slate-300');
    //
    //     if (formIsValid()) {
    //         $('#send-form-button').prop('disabled', false).addClass('bg-blue-500 hover:bg-blue-600 focus:bg-blue-600').removeClass('bg-blue-300 hover:bg-blue-300 focus:bg-blue-300 pointer-events-none');
    //     }
    // }
    //
    // function formIsValid() {
    //     return !(!$('#public_holiday_date').val());
    // }
    //
    // $(document).on('click', '#send-form-button', function (e){
    //     e.preventDefault();
    //
    //     if (formIsValid()) {
    //         let form = $(this).parents('form');
    //         let formData = new FormData(form[0]);
    //
    //         $.ajax({
    //             type: 'POST',
    //             url: form.attr('action'),
    //             data: formData,
    //             contentType: false,
    //             processData: false,
    //             success: function(response) {
    //                 if (response.status === 'success') {
    //                     window.location.reload();
    //                 } else {
    //                     $('.ajax-form').replaceWith(response);
    //                 }
    //             }
    //         });
    //     } else {
    //         Toast.fire({
    //             icon: 'error', title: 'Comprueba los errores del formulario'
    //         });
    //     }
    // });
});