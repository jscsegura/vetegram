const Appointments = window.Appointments = window.Appointments || {};
const appointmentsRescheduleConfig = window.APPOINTMENTS_RESCHEDULE_CONFIG || {};
const appointmentsRescheduleTexts = appointmentsRescheduleConfig.texts || {};
const appointmentsRescheduleRoutes = appointmentsRescheduleConfig.routes || {};
const appointmentsRescheduleSelectors = appointmentsRescheduleConfig.selectors || {};
const helpers = window.vetegramHelpers || {};

const appointmentsReschedule = {
    userInput: appointmentsRescheduleSelectors.userInput || '#IdUserAppointmentToCancel',
    dateInput: appointmentsRescheduleSelectors.dateInput || '#dateModalCancelRe',
    hourInput: appointmentsRescheduleSelectors.hourInput || '#hourModalCancelRe',
    appointmentIdInput: appointmentsRescheduleSelectors.appointmentIdInput || '#cancelIdAppointment',
    successContainer: appointmentsRescheduleSelectors.successContainer || '#containerSuccess'
};

function rescheduleAjaxPost(url, data, options = {}) {
    if (helpers.ajaxPost) {
        return helpers.ajaxPost(url, data, options);
    }
    if (typeof $ === 'undefined') {
        return null;
    }
    const token = helpers.getCsrfToken ? helpers.getCsrfToken() : '';
    return $.ajax(Object.assign({
        type: 'POST',
        url: url,
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': token
        },
        data: data
    }, options));
}

function initRescheduleDatepicker() {
    if (typeof dateDropper === 'undefined') {
        return;
    }
    new dateDropper({
        selector: '.dDropper',
        format: 'd/m/y',
        expandable: true,
        showArrowsOnHover: true,
        onDropdownExit: getHours
    });
}

document.addEventListener('DOMContentLoaded', initRescheduleDatepicker);

function getHours() {
    var userid = $(appointmentsReschedule.userInput).val();
    var date = $(appointmentsReschedule.dateInput).val();

    if ((userid != '') && (date != '')) {
        if (!appointmentsRescheduleRoutes.getHours) {
            return;
        }
        rescheduleAjaxPost(appointmentsRescheduleRoutes.getHours, { userid: userid, date: date }, {
            success: function(data) {
                var existHours = 0;
                var html = `<option value="">${appointmentsRescheduleTexts.selected || ''}</option>`;
                if (data && data.rows) {
                    $.each(data.rows, function(i, item) {
                        html = html + '<option value="' + item.id + '">' + item.hour + '</option>';
                        existHours = 1;
                    });
                }

                if (existHours == 0) {
                    html = `<option value="">${appointmentsRescheduleTexts.notAvailable || ''}</option>`;
                }

                $(appointmentsReschedule.hourInput).html(html);
            }
        });
    } else {
        var html = `<option value="">${appointmentsRescheduleTexts.selected || ''}</option>`;
        $(appointmentsReschedule.hourInput).html(html);
    }
}
Appointments.getHours = getHours;

function confirmSaveActionReschedule() {
    var valid = true;

    var id = $(appointmentsReschedule.appointmentIdInput).val();
    var user_id = $(appointmentsReschedule.userInput).val();
    var option = 'reagendar';

    var date = $(appointmentsReschedule.dateInput).val();
    var time = $(appointmentsReschedule.hourInput).val();

    if (date == '') {
        $(appointmentsReschedule.dateInput).addClass('is-invalid');
        valid = false;
    } else {
        $(appointmentsReschedule.dateInput).removeClass('is-invalid');
    }

    if (time == '') {
        $(appointmentsReschedule.hourInput).addClass('is-invalid');
        valid = false;
    } else {
        $(appointmentsReschedule.hourInput).removeClass('is-invalid');
    }

    if (!valid) {
        return;
    }

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-primary btn-sm text-uppercase px-4 marginleft20',
            cancelButton: 'btn btn-danger btn-sm text-uppercase px-4'
        },
        buttonsStyling: false
    });

    swalWithBootstrapButtons.fire({
        title: appointmentsRescheduleTexts.confirmTitle || '',
        text: appointmentsRescheduleTexts.confirmText || '',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: appointmentsRescheduleTexts.confirmYes || '',
        cancelButtonText: appointmentsRescheduleTexts.confirmNo || '',
        reverseButtons: true
    }).then((result) => {
        if (!result.isConfirmed) {
            return;
        }
        if (!appointmentsRescheduleRoutes.cancelOrReschedule) {
            return;
        }

        setCharge();

        rescheduleAjaxPost(appointmentsRescheduleRoutes.cancelOrReschedule, {
            id: id,
            user_id: user_id,
            date: date,
            time: time,
            option: option,
            encrypt: true
        }, {
            success: function(data) {
                if (data && data.process == '1') {
                    $(appointmentsReschedule.successContainer).show();
                } else if (data && data.process == '500') {
                    window.vetegramHelpers.toast({
                        text: appointmentsRescheduleTexts.errorPermit || '',
                        position: 'bottom-right',
                        textAlign: 'center',
                        loader: false,
                        hideAfter: 4000,
                        icon: 'error'
                    });
                } else if (data && data.process == '401') {
                    window.vetegramHelpers.toast({
                        text: appointmentsRescheduleTexts.errorHour || '',
                        position: 'bottom-right',
                        textAlign: 'center',
                        loader: false,
                        hideAfter: 4000,
                        icon: 'warning'
                    });
                } else {
                    window.vetegramHelpers.toast({
                        text: appointmentsRescheduleTexts.errorReschedule || '',
                        position: 'bottom-right',
                        textAlign: 'center',
                        loader: false,
                        hideAfter: 4000,
                        icon: 'error'
                    });
                }

                hideCharge();
            },
            error: function() {
                window.vetegramHelpers.toast({
                    text: appointmentsRescheduleTexts.errorReschedule || '',
                    position: 'bottom-right',
                    textAlign: 'center',
                    loader: false,
                    hideAfter: 4000,
                    icon: 'error'
                });
                hideCharge();
            }
        });
    });
}
Appointments.confirmSaveActionReschedule = confirmSaveActionReschedule;
