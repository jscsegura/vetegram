const Appointments = window.Appointments = window.Appointments || {};
(function() {
    var cfg = window.APPOINT_MODAL_CONFIG && window.APPOINT_MODAL_CONFIG.reminder;
    if (!cfg) return;

    var helpers = window.vetegramHelpers || {};
    var ids = cfg.ids || {};
    var labels = cfg.labels || {};
    var routes = cfg.routes || {};

    function getEl(id, fallbackId) {
        return document.getElementById(id || fallbackId);
    }

    function initDateDropper() {
        if (typeof dateDropper === 'undefined') return;
        new dateDropper({
            selector: '.dDropperFuture',
            format: 'd/m/y',
            expandable: true,
            showArrowsOnHover: true
        });
    }

    function setRepeat() {
        var repeat = getEl(ids.repeatSelect, 'repeatReminder');
        var period = getEl(ids.periodSelect, 'periodReminder');
        var quantity = getEl(ids.quantityInput, 'quantityReminder');
        if (!repeat || !period || !quantity) return;

        if (repeat.value === '1') {
            period.disabled = false;
            quantity.disabled = false;
        } else {
            period.value = '1';
            quantity.value = '';
            period.disabled = true;
            quantity.disabled = true;
        }
    }
    Appointments.setRepeat = setRepeat;

    function setIdAppointmentToReminder(id, onlyForMe, requiredReload, petid, sms) {
        var idField = getEl(ids.idField, 'reminderIdAppointment');
        var reloadField = getEl(ids.reloadField, 'reminderToReload');
        var petField = getEl(ids.petField, 'idIsForPet');
        var smsField = getEl(ids.smsField, 'sms');
        var whatsappField = getEl(ids.whatsappField, 'whatsapp');
        var reminderToSelect = getEl(ids.toSelect, 'reminderToModal');

        if (idField) idField.value = id || 0;
        if (petField) petField.value = petid || 0;

        if (onlyForMe === 1 && reminderToSelect) {
            var optionOwner = reminderToSelect.querySelector("option[value='2']");
            if (optionOwner) optionOwner.remove();
            reminderToSelect.value = '1';
        }

        if (requiredReload === 1 && reloadField) {
            reloadField.value = 1;
        }

        if (smsField) smsField.value = '0';
        if (whatsappField) whatsappField.value = '0';

        if (sms === 'sms') {
            if (smsField) smsField.value = '1';
        } else if (sms === 'whatsapp') {
            if (whatsappField) whatsappField.value = '1';
        } else if (sms === 'sms-whatsapp') {
            if (smsField) smsField.value = '1';
            if (whatsappField) whatsappField.value = '1';
        }
    }
    Appointments.setIdAppointmentToReminder = setIdAppointmentToReminder;

    function saveReminderModal() {
        var valid = true;
        var idField = getEl(ids.idField, 'reminderIdAppointment');
        var petField = getEl(ids.petField, 'idIsForPet');
        var toSelect = getEl(ids.toSelect, 'reminderToModal');
        var detailInput = getEl(ids.detailInput, 'reminderDetailModal');
        var dateInput = getEl(ids.dateInput, 'reminderDateModal');
        var timeInput = getEl(ids.timeInput, 'reminderTimeModal');
        var reloadField = getEl(ids.reloadField, 'reminderToReload');
        var smsField = getEl(ids.smsField, 'sms');
        var whatsappField = getEl(ids.whatsappField, 'whatsapp');

        var repeatSelect = getEl(ids.repeatSelect, 'repeatReminder');
        var periodSelect = getEl(ids.periodSelect, 'periodReminder');
        var quantityInput = getEl(ids.quantityInput, 'quantityReminder');

        var id = idField ? idField.value : '';
        var isPetId = petField ? petField.value : '';
        var to = toSelect ? toSelect.value : '';
        var detail = detailInput ? detailInput.value : '';
        var date = dateInput ? dateInput.value : '';
        var time = timeInput ? timeInput.value : '';
        var isReload = reloadField ? reloadField.value : '0';
        var sms = smsField ? smsField.value : '0';
        var whatsapp = whatsappField ? whatsappField.value : '0';

        var requiredFields = document.querySelectorAll('.requeridoModalSetReminder');
        requiredFields.forEach(function(elem) {
            var value = (elem.value || '').trim();
            if (value === '') {
                elem.classList.add('is-invalid');
                valid = false;
            } else {
                elem.classList.remove('is-invalid');
            }
        });

        var repeat = repeatSelect ? repeatSelect.value : '0';
        var quantity = 0;
        var period = 0;
        if (repeat === '1') {
            if (quantityInput && quantityInput.value === '') {
                quantityInput.classList.add('is-invalid');
                valid = false;
            } else if (quantityInput) {
                quantityInput.classList.remove('is-invalid');
            }
            quantity = quantityInput ? quantityInput.value : 0;
            period = periodSelect ? periodSelect.value : 0;
        }

        if (!valid) return;

        setCharge();

        var section = 0;
        if (window.Home && typeof window.Home.sectionReminder !== 'undefined') {
            section = window.Home.sectionReminder;
        } else if (typeof window.sectionReminder !== 'undefined') {
            section = window.sectionReminder;
        }

        var request = helpers.ajaxPost
            ? helpers.ajaxPost(routes.saveReminder, { id: id, to: to, detail: detail, date: date, time: time, section: section, isPetId: isPetId, sms: sms, whatsapp: whatsapp, repeat: repeat, period: period, quantity: quantity })
            : $.post(routes.saveReminder, { id: id, to: to, detail: detail, date: date, time: time, section: section, isPetId: isPetId, sms: sms, whatsapp: whatsapp, repeat: repeat, period: period, quantity: quantity });

        request.done(function(data) {
            if (data.save == 1) {
                if (toSelect) toSelect.value = '';
                if (detailInput) detailInput.value = '';
                if (dateInput) dateInput.value = '';
                if (timeInput) timeInput.value = '';

                if (isReload == 1) {
                    location.reload();
                } else {
                    window.vetegramHelpers.toast({
                        text: labels.reminderSuccess || '',
                        position: 'bottom-right',
                        textAlign: 'center',
                        loader: false,
                        hideAfter: 4000,
                        icon: 'success'
                    });
                }
            } else if (data.save == 2) {
                window.vetegramHelpers.toast({
                    text: labels.reminderDateError || '',
                    position: 'bottom-right',
                    textAlign: 'center',
                    loader: false,
                    hideAfter: 4000,
                    icon: 'error'
                });
            } else if (data.save == 3) {
                window.vetegramHelpers.toast({
                    text: labels.reminderDateBeforeError || '',
                    position: 'bottom-right',
                    textAlign: 'center',
                    loader: false,
                    hideAfter: 4000,
                    icon: 'error'
                });
            } else {
                window.vetegramHelpers.toast({
                    text: labels.reminderError || '',
                    position: 'bottom-right',
                    textAlign: 'center',
                    loader: false,
                    hideAfter: 4000,
                    icon: 'error'
                });
            }
            hideCharge();
        });
    }
    Appointments.saveReminderModal = saveReminderModal;

    document.addEventListener('change', function(e) {
        if (e.target && e.target.matches('[data-appoint-action="reminder-repeat"]')) {
            setRepeat();
        }
    });

    document.addEventListener('click', function(e) {
        var button = e.target.closest('[data-appoint-action="reminder-save"]');
        if (button) {
            saveReminderModal();
        }
    });

    initDateDropper();
})();
