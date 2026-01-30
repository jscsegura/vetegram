const Appointments = window.Appointments = window.Appointments || {};
const appointmentsIndexConfig = window.APPOINTMENTS_INDEX_CONFIG || {};
const appointmentsIndexTexts = appointmentsIndexConfig.texts || {};
const appointmentsIndexRoutes = appointmentsIndexConfig.routes || {};
const appointmentsIndexSelectors = appointmentsIndexConfig.selectors || {};
const helpers = window.vetegramHelpers || {};

const appointmentsIndex = {
    monthInput: appointmentsIndexSelectors.monthInput || '#monthCalendar',
    yearInput: appointmentsIndexSelectors.yearInput || '#yearCalendar',
    userSelect: appointmentsIndexSelectors.userSelect || '#useridselect',
    recipeModal: appointmentsIndexSelectors.recipeModal || '#recipeModal'
};

function initAppointmentsIndexTooltips() {
    if (typeof bootstrap === 'undefined') {
        return;
    }
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    [...tooltipTriggerList].map((tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl));
}

function initAppointmentsIndexDatepicker() {
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

function initAppointmentsIndexSelects() {
    if (!helpers.initSelect2 || typeof $ === 'undefined') {
        return;
    }
    helpers.initSelect2('.select2');
    helpers.initSelect2('.select3', {
        dropdownParent: $(appointmentsIndex.recipeModal)
    });
}

document.addEventListener('DOMContentLoaded', function() {
    initAppointmentsIndexTooltips();
    initAppointmentsIndexDatepicker();
    initAppointmentsIndexSelects();
});

function buildAppointmentsIndexUrl(month, year, userId) {
    if (!appointmentsIndexRoutes.index) {
        return '';
    }
    return `${appointmentsIndexRoutes.index}/${btoa(month)}/${btoa(year)}/${btoa(userId)}`;
}

function prevMonth() {
    var month = $(appointmentsIndex.monthInput).val();
    var year = $(appointmentsIndex.yearInput).val();
    var userid = $(appointmentsIndex.userSelect).val();

    if (month == 1) {
        month = 12;
        year = parseInt(year) - 1;
    } else {
        month = parseInt(month) - 1;
    }

    setCharge();

    const url = buildAppointmentsIndexUrl(month, year, userid);
    if (url) {
        location.href = url;
    }
}
Appointments.prevMonth = prevMonth;

function nextMonth() {
    var month = $(appointmentsIndex.monthInput).val();
    var year = $(appointmentsIndex.yearInput).val();
    var userid = $(appointmentsIndex.userSelect).val();

    if (month == 12) {
        month = 1;
        year = parseInt(year) + 1;
    } else {
        month = parseInt(month) + 1;
    }

    setCharge();

    const url = buildAppointmentsIndexUrl(month, year, userid);
    if (url) {
        location.href = url;
    }
}
Appointments.nextMonth = nextMonth;

function getUser() {
    var month = $(appointmentsIndex.monthInput).val();
    var year = $(appointmentsIndex.yearInput).val();
    var userid = $(appointmentsIndex.userSelect).val();

    setCharge();

    const url = buildAppointmentsIndexUrl(month, year, userid);
    if (url) {
        location.href = url;
    }
}
Appointments.getUser = getUser;

function startAppointment(url) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-primary btn-sm text-uppercase px-4 marginleft20',
            cancelButton: 'btn btn-danger btn-sm text-uppercase px-4'
        },
        buttonsStyling: false
    });

    swalWithBootstrapButtons.fire({
        title: appointmentsIndexTexts.startTitle || '',
        text: appointmentsIndexTexts.startConfirm || '',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: appointmentsIndexTexts.startYes || '',
        cancelButtonText: appointmentsIndexTexts.startNo || '',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            location.href = url;
        }
    });
}
Appointments.startAppointment = startAppointment;
