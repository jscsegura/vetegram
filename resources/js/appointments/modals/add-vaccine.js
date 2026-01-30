const Appointments = window.Appointments = window.Appointments || {};
(function() {
    var cfg = window.APPOINT_MODAL_CONFIG && window.APPOINT_MODAL_CONFIG.addVaccine;
    if (!cfg) return;

    var helpers = window.vetegramHelpers || {};
    var ids = cfg.ids || {};
    var labels = cfg.labels || {};
    var routes = cfg.routes || {};
    var assetsBase = cfg.assetsBase || '';
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

    function setIdAppointmentToVaccine(idPet, idOwner) {
        var petField = getEl(ids.petField, 'vaccineIdPet');
        var ownerField = getEl(ids.ownerField, 'vaccineIdOwner');
        if (petField) petField.value = idPet || 0;
        if (ownerField) ownerField.value = idOwner || 0;
    }
    Appointments.setIdAppointmentToVaccine = setIdAppointmentToVaccine;

    function setIntervalFromSelection() {
        var select = getEl(ids.nameSelect, 'vaccineName');
        if (!select) return;
        var selected = select.options[select.selectedIndex];
        var interval = selected ? selected.getAttribute('data-interval') : '';
        var intervalInput = getEl(ids.intervalInput, 'interval');
        if (intervalInput) intervalInput.value = interval || '';
    }
    Appointments.setIntervalFromSelection = setIntervalFromSelection;

    function saveToCreateVaccine() {
        var valid = true;
        var required = document.querySelectorAll('.requeridoAddVaccine');
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
        ajaxPost(routes.createVaccine, new FormData(getEl(ids.form, 'frmVaccineModaladd')), {
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
    Appointments.saveToCreateVaccine = saveToCreateVaccine;

    function showAppointmentVaccine(id) {
        setCharge();
        var container = getEl(ids.detailContainer, 'containerVaccine');
        if (container) container.innerHTML = '';

        var request = helpers.ajaxPost
            ? helpers.ajaxPost(routes.getVaccineData, { id: id })
            : $.post(routes.getVaccineData, { id: id });

        request.done(function(data) {
            var result = data.result || {};
            var photo = '';
            if (result.photo) {
                photo = '<img src="' + assetsBase + result.photo + '" alt="Vacuna" class="vaccineImg">';
            }
            var signature = '';
            if (result.signature) {
                signature = '<img src="' + result.signature + '" alt="Firma" class="vaccineImg">';
            }

            var html = '<tr>' +
                '<td data-label="' + (labels.applyLabel || '') + ':" class="fw-medium py-1 py-md-3">' + (result.date || '') + '</td>' +
                '<td data-label="' + (labels.drugLabel || '') + ':" class="py-1 py-md-3">' + (result.name || '') + '</td>' +
                '<td data-label="' + (labels.brandLabel || '') + ':" class="py-1 py-md-3 text-center">' + (result.brand || '') + '</td>' +
                '<td data-label="' + (labels.batchLabel || '') + ':" class="py-1 py-md-3 text-center">' + (result.batch || '') + '</td>' +
                '<td data-label="' + (labels.expireLabel || '') + ':" class="py-1 py-md-3 text-center">' + (result.expire || '') + '</td>' +
                '<td data-label="' + (labels.photoLabel || '') + ':" class="py-1 py-md-3 text-center">' + photo + '</td>' +
                '<td data-label="' + (labels.professionalLabel || '') + ':" class="py-1 py-md-3 text-center">' +
                '<p class="d-inline-block">' + (result.nameDoctor || '') + '</p><br>' +
                signature +
                '</td>' +
                '</tr>';

            if (container) container.innerHTML = html;
            hideCharge();
        });
    }
    Appointments.showAppointmentVaccine = showAppointmentVaccine;

    document.addEventListener('change', function(e) {
        if (e.target && e.target.matches('[data-appoint-action="vaccine-interval"]')) {
            setIntervalFromSelection();
        }
    });

    document.addEventListener('click', function(e) {
        var button = e.target.closest('[data-appoint-action="vaccine-save"]');
        if (button) {
            saveToCreateVaccine();
        }
    });
})();
