$(function () {
    // JS for the footer bar links.
    $('.enterreg__form')
        .on('submit', function (e) {
            e.preventDefault();
            window.tcCloseOverlays();

            // TODO: Change this to the car registration field.
            $('#vehicleSearchForm #px_vrm').val($('.reg-input').val());

            $('.tab-cc').click();
        });
});
