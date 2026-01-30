const Appointments = window.Appointments = window.Appointments || {};
const appointmentsHistoryConfig = window.APPOINTMENTS_HISTORY_CONFIG || {};
const appointmentsHistoryRoutes = appointmentsHistoryConfig.routes || {};
const appointmentsHistorySelectors = appointmentsHistoryConfig.selectors || {};

const appointmentsHistory = {
    monthSelect: appointmentsHistorySelectors.monthSelect || '#monthselect',
    yearSelect: appointmentsHistorySelectors.yearSelect || '#yearselect',
    userSelect: appointmentsHistorySelectors.userSelect || '#useridselect'
};

function initAppointmentsHistoryTooltips() {
    if (typeof bootstrap === 'undefined') {
        return;
    }
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    [...tooltipTriggerList].map((tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl));
}

function initAppointmentsHistoryDatepicker() {
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
    initAppointmentsHistoryTooltips();
    initAppointmentsHistoryDatepicker();
});

function buildAppointmentsHistoryUrl(month, year, userId) {
    if (!appointmentsHistoryRoutes.history) {
        return '';
    }
    return `${appointmentsHistoryRoutes.history}/${btoa(month)}/${btoa(year)}/${btoa(userId)}`;
}

function prevMonth() {
    var month = $(appointmentsHistory.monthSelect).val();
    var year = $(appointmentsHistory.yearSelect).val();
    var userid = $(appointmentsHistory.userSelect).val();

    if (month == 1) {
        month = 12;
        year = parseInt(year) - 1;
    } else {
        month = parseInt(month) - 1;
    }

    setCharge();

    const url = buildAppointmentsHistoryUrl(month, year, userid);
    if (url) {
        location.href = url;
    }
}
Appointments.prevMonth = prevMonth;

function nextMonth() {
    var month = $(appointmentsHistory.monthSelect).val();
    var year = $(appointmentsHistory.yearSelect).val();
    var userid = $(appointmentsHistory.userSelect).val();

    if (month == 12) {
        month = 1;
        year = parseInt(year) + 1;
    } else {
        month = parseInt(month) + 1;
    }

    setCharge();

    const url = buildAppointmentsHistoryUrl(month, year, userid);
    if (url) {
        location.href = url;
    }
}
Appointments.nextMonth = nextMonth;

function getAppoinments() {
    var month = $(appointmentsHistory.monthSelect).val();
    var year = $(appointmentsHistory.yearSelect).val();
    var userid = $(appointmentsHistory.userSelect).val();

    setCharge();

    const url = buildAppointmentsHistoryUrl(month, year, userid);
    if (url) {
        location.href = url;
    }
}
Appointments.getAppoinments = getAppoinments;
