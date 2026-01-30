const Appointments = window.Appointments = window.Appointments || {};
(function() {
    var cfg = window.APPOINT_MODAL_CONFIG && window.APPOINT_MODAL_CONFIG.addExternalVaccine;
    if (!cfg) return;

    var helpers = window.vetegramHelpers || {};
    var ids = cfg.ids || {};
    var labels = cfg.labels || {};
    var routes = cfg.routes || {};

    function getEl(id, fallbackId) {
        return document.getElementById(id || fallbackId);
    }

    function setIdExternalToEntryVaccine(id) {
        var idField = getEl(ids.idField, 'setIdPetToVaccine');
        if (idField) idField.value = id || 0;
    }
    Appointments.setIdExternalToEntryVaccine = setIdExternalToEntryVaccine;

    function sendEntryVaccineModal() {
        var idField = getEl(ids.idField, 'setIdPetToVaccine');
        var emailField = getEl(ids.emailField, 'emailToSendVaccine');
        var id = idField ? idField.value : '';
        var email = emailField ? emailField.value.trim() : '';

        var isValid = helpers.validateEmail ? helpers.validateEmail(email) : /^[a-zA-Z0-9._+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/.test(email);
        if (!email || !isValid) {
            window.vetegramHelpers.toast({
                text: labels.emailInvalid || '',
                position: 'bottom-right',
                textAlign: 'center',
                loader: false,
                hideAfter: 4000,
                icon: 'error'
            });
            return;
        }

        setCharge();
        var request = helpers.ajaxPost
            ? helpers.ajaxPost(routes.sendEntryVaccine, { id: id, email: email })
            : $.post(routes.sendEntryVaccine, { id: id, email: email });

        request.done(function(data) {
            if (data.send == '1') {
                if (emailField) emailField.value = '';
                window.vetegramHelpers.toast({
                    text: labels.sendSuccess || '',
                    position: 'bottom-right',
                    textAlign: 'center',
                    loader: false,
                    hideAfter: 4000,
                    icon: 'success'
                });
            } else {
                window.vetegramHelpers.toast({
                    text: labels.sendError || '',
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
    Appointments.sendEntryVaccineModal = sendEntryVaccineModal;

    document.addEventListener('click', function(e) {
        var button = e.target.closest('[data-appoint-action="external-vaccine-send"]');
        if (button) {
            sendEntryVaccineModal();
        }
    });
})();
