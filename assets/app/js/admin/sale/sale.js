$( document ).ready(function() {
    $(document).on('change', '.sale_field', function() {
        let saleId = $('#sale-header').data('sale-id');
        let url = '/admin/sale/'+saleId+'/update';

        updateSale(url);
    });

    $(document).on('change', '.sale_field', function() {
        let saleId = $('#sale-header').data('sale-id');
        let url = '/admin/sale/'+saleId+'/update';

        updateSaleCustomerPet(url);
    });

    $(document).on('change', '.sale_line_field', function() {
        let form = $(this).closest('form');

        updateSaleLine(form);
    });

    $(document).on('click', '#add-line', function(event) {
        event.preventDefault();

        addSaleLine($(this).attr('href'));
    });

    $(document).on('click', '.delete_line_button', function(event) {
        event.preventDefault();

        deleteSaleLine($(this).attr('href'));
    });

    $(document).on('click', '#edit-date', function() {
        toggleEditDate();
    });

    // $("#mydiv").load(location.href + " #mydiv");

    function updateSale(url) {
        $('#spinner-sale').removeClass('hidden').addClass('block');

        $.ajax({
            type: 'POST',
            url: url,
            data: {
                date: $('#date').val(),
                customer: $('#customer').val(),
                pet: $('#pet').val(),
                notes: $('#notes').val(),
                maintenancePlan: $('#maintenance-plan').prop('checked'),
            },
            success: function(data) {
                //aqui solamente tendremos que actualizar en el caso que el plan de mantenimineto aplique un descuento
                //tambien si almacenamos el redonde en base de datos, se actualizarían los totales de línea o simplemente el total de la venta

                setTimeout(function() {
                    $('#spinner-sale').removeClass('block').addClass('hidden');
                }, 200);

            },
            error: function() {
                Toast.fire({
                    icon: 'error', title: 'Se ha producido un error'
                });

                setTimeout(function() {
                    $('#spinner-sale').removeClass('block').addClass('hidden');
                }, 200);
            }
        });
    }

    function updateSaleCustomerPet() {
        sale-customer-pet-data
    }

    function updateSaleLine(form) {
        $('#spinner-sale-lines').removeClass('hidden').addClass('block');
        $('#spinner-sale-summary').removeClass('hidden').addClass('block');

        let title = $(form.find('.title')).val();
        let quantity = $(form.find('.quantity')).val();
        let price = $(form.find('.price')).val();
        let discount = $(form.find('.discount')).val();
        let taxType = $(form.find('.taxType')).val();
        let total = $(form.find('.total')).val();

        $.ajax({
            type: 'POST',
            url: form.attr('action'),
            data: {
                title: title,
                quantity: quantity,
                price: price,
                discount: discount,
                taxType: taxType,
                total: total,
            },
            success: function(data) {
                $(form.find('.total')).val(data.sale_line_total.toFixed(2));
                $("#sale_total_discounts").html(data.sale_total_discounts.toLocaleString('es-ES', { style: 'currency', currency: 'EUR' }));
                $("#sale_total_without_taxes").html(data.sale_total_without_taxes.toLocaleString('es-ES', { style: 'currency', currency: 'EUR' }));
                $("#sale_total_taxes").html(data.sale_total_taxes.toLocaleString('es-ES', { style: 'currency', currency: 'EUR' }));
                $("#sale_total").html(data.sale_total.toLocaleString('es-ES', { style: 'currency', currency: 'EUR' }));

                setTimeout(function() {
                    $('#spinner-sale-lines').removeClass('block').addClass('hidden');
                    $('#spinner-sale-summary').removeClass('block').addClass('hidden');
                }, 200);

            },
            error: function() {
                Toast.fire({
                    icon: 'error', title: 'Se ha producido un error'
                });

                setTimeout(function() {
                    $('#spinner-sale-lines').removeClass('block').addClass('hidden');
                    $('#spinner-sale-summary').removeClass('block').addClass('hidden');
                }, 200);
            }
        });
    }

    function addSaleLine(url) {
        $.ajax({
            type: 'GET',
            url: url,
            success: function(data) {
                $("#sale-detail").html(data);

                //set focus on new line title
                $('form').last().find('.title').focus();
            },
            error: function() {
                Toast.fire({
                    icon: 'error', title: 'Se ha producido un error'
                });
            }
        });
    }

    function deleteSaleLine(url) {
        Swal.fire({
            html: '<p>¿Seguro que quieres eliminar la línea?</p>',
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
        })
        .then(result => {
            if (result.value) {
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function(data) {
                        if (data === 406) {
                            Toast.fire({
                                icon: 'error', title: 'Al menos debe existir una línea'
                            });
                        } else {
                            Toast.fire({
                                icon: 'success', title: 'Se ha eliminado la línea correctamente'
                            });

                            $("#sale-detail").html(data);
                            //set focus on last line title
                            $('form').last().find('.title').focus();
                        }
                    },
                    error: function() {
                        Toast.fire({
                            icon: 'error', title: 'Se ha producido un error'
                        });
                    }
                });
            }
        });
    }

    function toggleEditDate() {
        let date = $('#date');
        let editDateButton = $('#edit-date i');

        if (date.prop('disabled')) {
            editDateButton.removeClass('fa-pencil').addClass('fa-xmark')
            date.prop('disabled', false).removeClass('bg-slate-50').focus();
        } else {
            editDateButton.removeClass('fa-xmark').addClass('fa-pencil')
            date.prop('disabled', true).addClass('bg-slate-50');
        }
    }
});