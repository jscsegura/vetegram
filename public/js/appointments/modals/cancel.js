const Appointments = window.Appointments = window.Appointments || {};
(function() {
    var cfg = window.APPOINT_MODAL_CONFIG && window.APPOINT_MODAL_CONFIG.cancel;
    if (!cfg) return;

    var helpers = window.vetegramHelpers || {};
    var ids = cfg.ids || {};
    var labels = cfg.labels || {};
    var routes = cfg.routes || {};

    function getEl(id, fallbackId) {
        return document.getElementById(id || fallbackId);
    }

    var dateModalCancel = getEl(ids.dateWrap, 'dateModalCancel');
    var optionsWrap = getEl(ids.optionsWrap, 'divoptions');

    function toggleDate(show) {
        if (!dateModalCancel) return;
        dateModalCancel.style.display = show ? 'block' : 'none';
    }

    function initDateDropper() {
        if (typeof dateDropper === 'undefined') return;
        new dateDropper({
            selector: '.dDropperCancelModal',
            format: 'd/m/y',
            expandable: true,
            showArrowsOnHover: true,
            onDropdownExit: getHoursAppointmentToCancel
        });
    }

    function setIdAppointmentToCancel(id, userId, onlyReagend) {
        var idField = getEl(ids.idField, 'cancelIdAppointment');
        var userField = getEl(ids.userField, 'IdUserAppointmentToCancel');
        if (idField) idField.value = id || 0;
        if (userField) userField.value = userId || 0;

        initDateDropper();

        if (onlyReagend === 1) {
            var radio = document.querySelector("input[name='opcionesModalCancel'][value='reagendar']");
            if (radio) radio.checked = true;
            if (optionsWrap) optionsWrap.style.display = 'none';
            toggleDate(true);
        } else {
            var radioCancel = document.querySelector("input[name='opcionesModalCancel'][value='cancelar']");
            if (radioCancel) radioCancel.checked = true;
            if (optionsWrap) optionsWrap.style.display = '';
            toggleDate(false);
        }
    }
    Appointments.setIdAppointmentToCancel = setIdAppointmentToCancel;

    function getHoursAppointmentToCancel() {
        var userField = getEl(ids.userField, 'IdUserAppointmentToCancel');
        var dateField = getEl(ids.dateInput, 'dateModalCancelRe');
        var hourSelect = getEl(ids.hourSelect, 'hourModalCancelRe');
        var userId = userField ? userField.value : '';
        var date = dateField ? dateField.value : '';

        if (!hourSelect) return;

        if (userId && date) {
            var request = helpers.ajaxPost
                ? helpers.ajaxPost(routes.getHours, { userid: userId, date: date })
                : $.post(routes.getHours, { userid: userId, date: date });

            request.done(function(data) {
                var existHours = 0;
                var html = '<option value="">' + (labels.selected || '') + '</option>';
                $.each(data.rows || [], function(i, item) {
                    html += '<option value="' + item.id + '">' + item.hour + '</option>';
                    existHours = 1;
                });
                if (existHours === 0) {
                    html = '<option value="">' + (labels.selectedNotAvailable || '') + '</option>';
                }
                hourSelect.innerHTML = html;
            });
        } else {
            hourSelect.innerHTML = '<option value="">' + (labels.selected || '') + '</option>';
        }
    }
    Appointments.getHoursAppointmentToCancel = getHoursAppointmentToCancel;

    function reserverHourAppointmentToCancel(select) {
        var id = select ? select.value : '';
        if (!id) return;
        var request = helpers.ajaxPost
            ? helpers.ajaxPost(routes.reserveHour, { id: id })
            : $.post(routes.reserveHour, { id: id });

        request.done(function(data) {
            if (data.reserve !== '1') {
                window.vetegramHelpers.toast({
                    text: labels.hourNotAvailable || '',
                    position: 'bottom-right',
                    textAlign: 'center',
                    loader: false,
                    hideAfter: 4000,
                    icon: 'warning'
                });
                if (typeof getHours === 'function') {
                    getHours();
                } else {
                    getHoursAppointmentToCancel();
                }
            }
        });
    }
    Appointments.reserverHourAppointmentToCancel = reserverHourAppointmentToCancel;

    function confirmSaveActionCancel() {
        var valid = true;
        var idField = getEl(ids.idField, 'cancelIdAppointment');
        var userField = getEl(ids.userField, 'IdUserAppointmentToCancel');
        var dateField = getEl(ids.dateInput, 'dateModalCancelRe');
        var hourSelect = getEl(ids.hourSelect, 'hourModalCancelRe');

        var id = idField ? idField.value : '';
        var userId = userField ? userField.value : '';
        var date = '';
        var time = '';

        var option = document.querySelector("input[name='opcionesModalCancel']:checked");
        option = option ? option.value : 'cancelar';

        var title = '';
        var text = '';
        var btn = '';

        if (option === 'cancelar') {
            title = labels.titleCancel || '';
            text = labels.textCancel || '';
            btn = labels.btnCancel || '';
        } else if (option === 'reagendar') {
            date = dateField ? dateField.value : '';
            time = hourSelect ? hourSelect.value : '';

            if (!date) {
                if (dateField) dateField.classList.add('is-invalid');
                valid = false;
            } else if (dateField) {
                dateField.classList.remove('is-invalid');
            }

            if (!time) {
                if (hourSelect) hourSelect.classList.add('is-invalid');
                valid = false;
            } else if (hourSelect) {
                hourSelect.classList.remove('is-invalid');
            }

            title = labels.titleReschedule || '';
            text = labels.textReschedule || '';
            btn = labels.btnReschedule || '';
        }

        if (!valid) return;

        var swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary btn-sm text-uppercase px-4 marginleft20',
                cancelButton: 'btn btn-danger btn-sm text-uppercase px-4'
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: title,
            text: text,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: btn,
            cancelButtonText: labels.btnCancelReturn || '',
            reverseButtons: true
        }).then(function(result) {
            if (!result.isConfirmed) return;
            setCharge();
            var request = helpers.ajaxPost
                ? helpers.ajaxPost(routes.cancelOrReschedule, { id: id, user_id: userId, date: date, time: time, option: option })
                : $.post(routes.cancelOrReschedule, { id: id, user_id: userId, date: date, time: time, option: option });

            request.done(function(data) {
                if (data.process === '1') {
                    location.reload();
                } else if (data.process === '500') {
                    window.vetegramHelpers.toast({
                        text: labels.errorPermit || '',
                        position: 'bottom-right',
                        textAlign: 'center',
                        loader: false,
                        hideAfter: 4000,
                        icon: 'error'
                    });
                } else if (data.process === '401') {
                    window.vetegramHelpers.toast({
                        text: labels.errorHour || '',
                        position: 'bottom-right',
                        textAlign: 'center',
                        loader: false,
                        hideAfter: 4000,
                        icon: 'warning'
                    });
                } else {
                    window.vetegramHelpers.toast({
                        text: labels.errorReschedule || '',
                        position: 'bottom-right',
                        textAlign: 'center',
                        loader: false,
                        hideAfter: 4000,
                        icon: 'error'
                    });
                }
                hideCharge();
            });
        });
    }
    Appointments.confirmSaveActionCancel = confirmSaveActionCancel;

    document.addEventListener('change', function(e) {
        if (e.target && e.target.matches('[data-appoint-action="cancel-option"]')) {
            if (e.target.value === 'reagendar') {
                toggleDate(true);
            } else {
                toggleDate(false);
            }
        }

        if (e.target && e.target.matches('[data-appoint-action="cancel-hour"]')) {
            reserverHourAppointmentToCancel(e.target);
        }
    });

    document.addEventListener('click', function(e) {
        var button = e.target.closest('[data-appoint-action="cancel-save"]');
        if (button) {
            confirmSaveActionCancel();
        }
    });
})();
