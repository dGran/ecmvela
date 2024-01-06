$(document).ready(function() {
    $('select').select2();

    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });

    const $formElements = {
        inputDate: $('#booking_date'),
        inputPet: $('#booking_pet'),
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

    $(document).on('change', '#booking_date, booking_pet, #booking_estimatedDuration', validateForm);
});