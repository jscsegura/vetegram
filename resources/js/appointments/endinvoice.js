const helpers = window.vetegramHelpers || {};

function initAppointmentsEndInvoiceSelects() {
    if (!helpers.initSelect2 || typeof $ === 'undefined') {
        return;
    }
    helpers.initSelect2('.select2');
}

function initAppointmentsEndInvoiceDatepicker() {
    if (typeof dateDropper === 'undefined') {
        return;
    }
    new dateDropper({
        selector: '.dDropper',
        format: 'd/m/y',
        expandable: true,
        showArrowsOnHover: true
    });
}

document.addEventListener('DOMContentLoaded', function() {
    initAppointmentsEndInvoiceSelects();
    initAppointmentsEndInvoiceDatepicker();
});
