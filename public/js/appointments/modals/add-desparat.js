const Appointments = window.Appointments = window.Appointments || {};
(function() {
    var cfg = window.APPOINT_MODAL_CONFIG && window.APPOINT_MODAL_CONFIG.addDesparat;
    if (!cfg) return;

    var helpers = window.vetegramHelpers || {};
    var ids = cfg.ids || {};
    var labels = cfg.labels || {};
    var routes = cfg.routes || {};
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

    function setIdAppointmentToDesparat(idPet, idOwner) {
        var petField = getEl(ids.petField, 'vaccineIdPetDesp');
        var ownerField = getEl(ids.ownerField, 'vaccineIdOwnerDesp');
        if (petField) petField.value = idPet || 0;
        if (ownerField) ownerField.value = idOwner || 0;
    }
    Appointments.setIdAppointmentToDesparat = setIdAppointmentToDesparat;

    function setIntervalDesp() {
        var select = getEl(ids.nameSelect, 'vaccineNameDesp');
        if (!select) return;
        var selected = select.options[select.selectedIndex];
        var interval = selected ? selected.getAttribute('data-interval') : '';
        var intervalInput = getEl(ids.intervalInput, 'intervalDesp');
        if (intervalInput) intervalInput.value = interval || '';
    }
    Appointments.setIntervalDesp = setIntervalDesp;

    function saveToCreateVaccineDesp() {
        var valid = true;
        var required = document.querySelectorAll('.requeridoAddVaccineDesp');
        required.forEach(function(elem) {
            var value = (elem.value || '').trim();
            if (value === '') {
                elem.classList.add('is-invalid');
                valid = false;
            } else {
                elem.classList.remove('is-invalid');
            }
        });

        if (!valid) return;

        setCharge();
        ajaxPost(routes.createVaccine, new FormData(getEl(ids.form, 'frmVaccineModaladdDesp')), {
            contentType: false,
            cache: false,
            processData: false,
            success: function() {
                location.reload();
            },
            error: function() {
                window.vetegramHelpers.toast({
                    text: labels.errorCreate || '',
                    position: 'bottom-right',
                    textAlign: 'center',
                    loader: false,
                    hideAfter: 4000,
                    icon: 'error'
                });
                hideCharge();
            }
        });
    }
    Appointments.saveToCreateVaccineDesp = saveToCreateVaccineDesp;

    document.addEventListener('change', function(e) {
        if (e.target && e.target.matches('[data-appoint-action="desparat-interval"]')) {
            setIntervalDesp();
        }
    });

    document.addEventListener('click', function(e) {
        var button = e.target.closest('[data-appoint-action="desparat-save"]');
        if (button) {
            saveToCreateVaccineDesp();
        }
    });
})();
