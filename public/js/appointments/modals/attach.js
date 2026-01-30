const Appointments = window.Appointments = window.Appointments || {};
(function() {
    var cfg = window.APPOINT_MODAL_CONFIG && window.APPOINT_MODAL_CONFIG.attach;
    if (!cfg) return;

    var helpers = window.vetegramHelpers || {};
    var ids = cfg.ids || {};
    var labels = cfg.labels || {};
    var routes = cfg.routes || {};
    var allowedExtensions = cfg.allowedExtensions || [];
    var ajaxPost = helpers.ajaxPost || function(url, data, options) {
        if (!window.$) {
            return null;
        }
        return $.ajax(Object.assign({
            type: 'POST',
            url: url,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': helpers.getCsrfToken ? helpers.getCsrfToken() : ''
            },
            data: data
        }, options));
    };

    function getEl(id, fallbackId) {
        return document.getElementById(id || fallbackId);
    }

    function setIdAppointmentToAttach(id, pet) {
        var idField = getEl(ids.idField, 'attachIdAppointment');
        var petField = getEl(ids.petField, 'attachIdPetAppointment');
        if (idField) idField.value = id || 0;
        if (petField) petField.value = pet || 0;
    }
    Appointments.setIdAppointmentToAttach = setIdAppointmentToAttach;

    var peticion;
    function shouldReload() {
        return (window.AppointmentsStart && window.AppointmentsStart.state && window.AppointmentsStart.state.reloadToComplete) ||
            (window.AppointmentsEdit && window.AppointmentsEdit.state && window.AppointmentsEdit.state.reloadToComplete);
    }

    function saveAttachModal() {
        var fileInput = getEl(ids.fileInput, 'fileModalMultiple');
        if (!fileInput || !fileInput.files || !fileInput.files.length) return;

        var isvalid = true;
        var counter = 0;

        for (var i = 0; i < fileInput.files.length; i++) {
            var name = fileInput.files[i].name || '';
            var extension = name.substring(name.lastIndexOf('.'));
            if (allowedExtensions.length && $.inArray(extension, allowedExtensions) === -1) {
                isvalid = false;
                window.vetegramHelpers.toast({
                    text: labels.extNotValid || '',
                    position: 'bottom-right',
                    textAlign: 'center',
                    loader: false,
                    hideAfter: 4000,
                    icon: 'warning'
                });
            }
            counter++;
        }

        if (!isvalid || counter === 0) return;

        setCharge2();

        peticion = ajaxPost(routes.saveAttach, new FormData(getEl(ids.form, 'frmUploaderAttachModal')), {
            xhr: function() {
                var progress = $('#progressAttachModal');
                var xhr = $.ajaxSettings.xhr();
                progress.show();
                xhr.upload.onprogress = function(ev) {
                    if (ev.lengthComputable) {
                        var percentComplete = parseInt((ev.loaded / ev.total) * 100, 10);
                        $('#progressAttachModal em').html(percentComplete + '%');
                        $('#progressAttachModal span').css('width', percentComplete + '%');
                    }
                };
                return xhr;
            },
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#progressAttachModal').hide();
                fileInput.value = '';
                if (data.save == 1) {
                    window.vetegramHelpers.toast({
                        text: labels.attachSuccess || '',
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
                    var errorText = data.error ? data.error : (labels.attachError || '');
                    window.vetegramHelpers.toast({
                        text: errorText,
                        position: 'bottom-right',
                        textAlign: 'center',
                        loader: false,
                        hideAfter: data.error ? 10000 : 4000,
                        icon: 'error'
                    });
                }
                hideCharge2();
            },
            error: function() {
                $('#progressAttachModal').hide();
                window.vetegramHelpers.toast({
                    text: labels.attachError || '',
                    position: 'bottom-right',
                    textAlign: 'center',
                    loader: false,
                    hideAfter: 4000,
                    icon: 'error'
                });
                hideCharge2();
            }
        });
    }
    Appointments.saveAttachModal = saveAttachModal;

    document.addEventListener('click', function(e) {
        var button = e.target.closest('[data-appoint-action="attach-save"]');
        if (button) {
            saveAttachModal();
        }
    });
})();
