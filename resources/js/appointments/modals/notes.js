const Appointments = window.Appointments = window.Appointments || {};
(function() {
    var cfg = window.APPOINT_MODAL_CONFIG && window.APPOINT_MODAL_CONFIG.notes;
    if (!cfg) return;

    var helpers = window.vetegramHelpers || {};
    var ids = cfg.ids || {};
    var labels = cfg.labels || {};
    var routes = cfg.routes || {};

    function getEl(id, fallbackId) {
        return document.getElementById(id || fallbackId);
    }

    function shouldReload() {
        return (window.AppointmentsStart && window.AppointmentsStart.state && window.AppointmentsStart.state.reloadToComplete) ||
            (window.AppointmentsEdit && window.AppointmentsEdit.state && window.AppointmentsEdit.state.reloadToComplete);
    }

    function setIdAppointmentToNote(id, to) {
        var toField = getEl(ids.toField, 'noteToAppointment');
        var idField = getEl(ids.idField, 'noteIdAppointment');
        if (toField) toField.value = to || 0;
        if (idField) idField.value = id || 0;
    }
    Appointments.setIdAppointmentToNote = setIdAppointmentToNote;

    function saveNoteModal() {
        var idField = getEl(ids.idField, 'noteIdAppointment');
        var toField = getEl(ids.toField, 'noteToAppointment');
        var noteField = getEl(ids.noteField, 'noteMtitle');

        var id = idField ? idField.value : '';
        var to = toField ? toField.value : '';
        var note = noteField ? noteField.value.trim() : '';

        if (!note) {
            window.vetegramHelpers.toast({
                text: labels.noteRequired || '',
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
            ? helpers.ajaxPost(routes.saveNote, { id: id, note: note, to: to })
            : $.post(routes.saveNote, { id: id, note: note, to: to });

        request.done(function(data) {
            if (noteField) noteField.value = '';
            if (data.save == 1) {
                window.vetegramHelpers.toast({
                    text: labels.noteSuccess || '',
                    position: 'bottom-right',
                    textAlign: 'center',
                    loader: false,
                    hideAfter: 4000,
                    icon: 'success'
                });
                if (shouldReload()) {
                    location.reload();
                }
            } else {
                window.vetegramHelpers.toast({
                    text: labels.noteError || '',
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
    Appointments.saveNoteModal = saveNoteModal;

    document.addEventListener('click', function(e) {
        var button = e.target.closest('[data-appoint-action="note-save"]');
        if (button) {
            saveNoteModal();
        }
    });
})();
