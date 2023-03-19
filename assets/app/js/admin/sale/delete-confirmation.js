$('.delete-action-button').click(function(e) {
    e.preventDefault();

    let clickedElement = $(this);
    let form = $(this).parents('form');
    let name = clickedElement.data('name');
    let img = clickedElement.data('img');

    deleteConfirmation(form, name, img)
});

function deleteConfirmation(form)
{
    Swal.fire({
        html: '<div class="py-1.5">¿Seguro que quieres eliminar el TPV?</div>',
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