const Appointments = window.Appointments = window.Appointments || {};
const appointmentsScheduleConfig = window.APPOINTMENTS_SCHEDULE_CONFIG || {};
const appointmentsScheduleTexts = appointmentsScheduleConfig.texts || {};
const appointmentsScheduleSelectors = appointmentsScheduleConfig.selectors || {};
const helpers = window.vetegramHelpers || {};

const appointmentsSchedule = {
    monthlyContainer: appointmentsScheduleSelectors.monthlyContainer || '#mensual',
    weeklyContainer: appointmentsScheduleSelectors.weeklyContainer || '#semanal',
    dailyContainer: appointmentsScheduleSelectors.dailyContainer || '#diario',
    monthlySelectorContainer: appointmentsScheduleSelectors.monthlySelectorContainer || '#selTimeCalendarMensual',
    weeklySelectorContainer: appointmentsScheduleSelectors.weeklySelectorContainer || '#selTimeCalendarSemanal',
    dailySelectorContainer: appointmentsScheduleSelectors.dailySelectorContainer || '#selTimeCalendarDiario'
};

function initAppointmentsScheduleSelects() {
    if (!helpers.initSelect2 || typeof $ === 'undefined') {
        return;
    }
    helpers.initSelect2('.select2');
    helpers.initSelect2('.select3', {
        dropdownParent: $(appointmentsScheduleSelectors.recipeModal || '#recipeModal')
    });
}

document.addEventListener('DOMContentLoaded', function() {
    initAppointmentsScheduleSelects();
    setCalendar(appointmentsScheduleConfig.initialType || 1);
});

function buildCalendarSelect(selected) {
    const labelMonthly = appointmentsScheduleTexts.monthly || '';
    const labelWeekly = appointmentsScheduleTexts.weekly || '';
    const labelDaily = appointmentsScheduleTexts.daily || '';
    return '<select id="selTime" name="selTime" class="form-select form-select-sm" aria-label="Seleccionar rango">' +
        `<option value="1" ${selected == 1 ? 'selected' : ''}>${labelMonthly}</option>` +
        `<option value="2" ${selected == 2 ? 'selected' : ''}>${labelWeekly}</option>` +
        `<option value="3" ${selected == 3 ? 'selected' : ''}>${labelDaily}</option>` +
        '</select>';
}

function setCalendar(value) {
    $('.selTimeCalendar').html('');

    if (value == 1) {
        $(appointmentsSchedule.monthlySelectorContainer).html(buildCalendarSelect(1));
        $(appointmentsSchedule.monthlyContainer).show();
        $(appointmentsSchedule.weeklyContainer).hide();
        $(appointmentsSchedule.dailyContainer).hide();
    } else if (value == 2) {
        $(appointmentsSchedule.weeklySelectorContainer).html(buildCalendarSelect(2));
        $(appointmentsSchedule.monthlyContainer).hide();
        $(appointmentsSchedule.weeklyContainer).show();
        $(appointmentsSchedule.dailyContainer).hide();
    } else if (value == 3) {
        $(appointmentsSchedule.dailySelectorContainer).html(buildCalendarSelect(3));
        $(appointmentsSchedule.monthlyContainer).hide();
        $(appointmentsSchedule.weeklyContainer).hide();
        $(appointmentsSchedule.dailyContainer).show();
    }
}
Appointments.setCalendar = setCalendar;

document.addEventListener('change', function(event) {
    const target = event.target;
    if (target && target.id === 'selTime') {
        setCalendar(target.value);
    }
});
