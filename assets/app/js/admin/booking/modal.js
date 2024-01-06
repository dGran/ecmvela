$(document).ready(function() {
    $('select').select2();

    const $formElements = {
        inputDate: $('#booking_date'),
        inputPet: $('#booking_pet'),
        inputCustomer: $('#booking_customer'),
        inputEstimatedDuration: $('#booking_estimatedDuration'),
        buttonSubmit: $('#submit-button'),
    };

    function validateForm() {
        if ($formElements.inputDate.val() !== '' && $formElements.inputPet.val() !== '' && $formElements.inputEstimatedDuration.val() !== '') {
            $formElements.buttonSubmit.prop('disabled', false).addClass('bg-blue-500 hover:bg-blue-600 focus:bg-blue-600').removeClass('bg-blue-300 hover:bg-blue-300 focus:bg-blue-300 pointer-events-none');
        } else {
            $formElements.buttonSubmit.prop('disabled', true).removeClass('bg-blue-500 hover:bg-blue-600 focus:bg-blue-600').addClass('bg-blue-300 hover:bg-blue-300 focus:bg-blue-300 pointer-events-none');
        }
    }

    $(document).on('change', '#booking_date, #booking_estimatedDuration', validateForm);
    $(document).on('change', '#booking_pet', function() {
        const checkNicknameAvailabilityUrl = $('#check-nickname-availability-url').data('url');

        $.ajax({
            type: 'POST',
            url: checkNicknameAvailabilityUrl,
            data: {
                nickname: nickname
            },
            success: function(response) {
                if (!response.isAvailable) {
                    $formElements.nicknameInfo.text(response.message);
                    setClassesToElements($formElements.inputNickname, inputNicknameClassMap, 'error');
                    setClassesToElements($formElements.nicknameInfo, nicknameInfoClassMap, 'error');

                    resolve(false);
                } else {
                    $formElements.nicknameInfo.text(default_message);
                    setClassesToElements($formElements.inputNickname, inputNicknameClassMap, 'valid');
                    setClassesToElements($formElements.nicknameInfo, nicknameInfoClassMap, 'valid');

                    resolve(true);
                }
            },
            error: function() {
                const message = 'Nickname verification failed';
                $formElements.nicknameInfo.text(message);

                resolve(false);
            }
        });

        validateForm();
    });

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