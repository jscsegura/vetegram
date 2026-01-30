const Appointments = window.Appointments = window.Appointments || {};
(function() {
    var cfg = window.APPOINT_MODAL_CONFIG && window.APPOINT_MODAL_CONFIG.sendAttach;
    if (!cfg) return;

    var helpers = window.vetegramHelpers || {};
    var ids = cfg.ids || {};
    var labels = cfg.labels || {};
    var routes = cfg.routes || {};

    function getEl(id, fallbackId) {
        return document.getElementById(id || fallbackId);
    }

    function setIdAppointmentToSendAttach(id, email) {
        var idField = getEl(ids.idField, 'setIdAppointmentToSendAttach');
        var emailField = getEl(ids.emailField, 'emailToSendAttach');
        if (idField) idField.value = id || 0;
        if (emailField && email) emailField.value = email;
    }
    Appointments.setIdAppointmentToSendAttach = setIdAppointmentToSendAttach;

    function sendAttachModal() {
        var idField = getEl(ids.idField, 'setIdAppointmentToSendAttach');
        var emailField = getEl(ids.emailField, 'emailToSendAttach');
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
            ? helpers.ajaxPost(routes.sendAttach, { id: id, email: email })
            : $.post(routes.sendAttach, { id: id, email: email });

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
    Appointments.sendAttachModal = sendAttachModal;

    document.addEventListener('click', function(e) {
        var button = e.target.closest('[data-appoint-action="send-attach"]');
        if (button) {
            sendAttachModal();
        }
    });
})();
