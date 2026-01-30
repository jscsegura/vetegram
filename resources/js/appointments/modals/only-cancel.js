const Appointments = window.Appointments = window.Appointments || {};
(function() {
    var cfg = window.APPOINT_MODAL_CONFIG && window.APPOINT_MODAL_CONFIG.onlyCancel;
    if (!cfg) return;

    var helpers = window.vetegramHelpers || {};
    var ids = cfg.ids || {};
    var labels = cfg.labels || {};
    var routes = cfg.routes || {};

    function getEl(id, fallbackId) {
        return document.getElementById(id || fallbackId);
    }

    function setIdAppointmentToOnlyCancel(id, userId) {
        var idField = getEl(ids.idField, 'cancelIdAppointment');
        var userField = getEl(ids.userField, 'IdUserAppointmentToCancel');
        if (idField) idField.value = id || 0;
        if (userField) userField.value = userId || 0;
        confirmSaveActionOnlyCancel();
    }
    Appointments.setIdAppointmentToOnlyCancel = setIdAppointmentToOnlyCancel;

    function confirmSaveActionOnlyCancel() {
        var idField = getEl(ids.idField, 'cancelIdAppointment');
        var userField = getEl(ids.userField, 'IdUserAppointmentToCancel');
        var id = idField ? idField.value : '';
        var userId = userField ? userField.value : '';

        var option = 'cancelar';
        var title = labels.titleCancel || '';
        var text = labels.textCancel || '';
        var btn = labels.btnCancel || '';

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
                ? helpers.ajaxPost(routes.cancelOrReschedule, { id: id, user_id: userId, date: '', time: '', option: option })
                : $.post(routes.cancelOrReschedule, { id: id, user_id: userId, date: '', time: '', option: option });

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
    Appointments.confirmSaveActionOnlyCancel = confirmSaveActionOnlyCancel;

    document.addEventListener('click', function(e) {
        var button = e.target.closest('[data-appoint-action="only-cancel-save"]');
        if (button) {
            confirmSaveActionOnlyCancel();
        }
    });
})();
