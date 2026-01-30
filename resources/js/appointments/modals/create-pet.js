const Appointments = window.Appointments = window.Appointments || {};
(function() {
    var cfg = window.APPOINT_MODAL_CONFIG && window.APPOINT_MODAL_CONFIG.createPet;
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
            headers: { 'X-CSRF-TOKEN': helpers.getCsrfToken ? helpers.getCsrfToken() : '' },
            data: data
        }, options));
    };

    function getEl(id, fallbackId) {
        return document.getElementById(id || fallbackId);
    }

    function chargeCreatePet() {
        var select = document.getElementById('userSearchInput');
        if (!select) return;
        var option = select.options[select.selectedIndex];
        var iduser = option ? option.getAttribute('data-iduser') : '';
        var name = option ? option.getAttribute('data-name') : '';
        var email = option ? option.getAttribute('data-email') : '';

        if (iduser) {
            var idField = getEl(ids.userIdField, 'useridCreatePetModal');
            var nameField = getEl(ids.nameField, 'nameClientPetAdd');
            var emailField = getEl(ids.emailField, 'emailClientPetAdd');
            if (idField) idField.value = iduser;
            if (nameField) nameField.value = name || '';
            if (emailField) emailField.value = email || '';

            $('#createUserModal').modal('hide');
            $('#createNewPet').modal('show');
        }
    }
    Appointments.chargeCreatePet = chargeCreatePet;

    function getBreedPet() {
        var typeSelect = getEl(ids.typeSelect, 'typeCreatePet');
        var breedSelect = getEl(ids.breedSelect, 'breedCreatePet');
        var type = typeSelect ? typeSelect.value : '';

        var request = ajaxPost(routes.getBreed, { type: type });

        request.done(function(data) {
            var html = '<option value="">' + (labels.selected || '') + '</option>';
            $.each(data.rows || [], function(i, item) {
                html += '<option value="' + item.id + '">' + item.title + '</option>';
            });
            if (breedSelect) breedSelect.innerHTML = html;
        });
    }
    Appointments.getBreedPet = getBreedPet;

    function saveToCreatePet() {
        var valid = true;
        document.querySelectorAll('.requeridoAddPet').forEach(function(elem) {
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
        ajaxPost(routes.createPet, new FormData(getEl(ids.form, 'frmCreatePetModal')), {
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data.result === 'create') {
                    var user = $('#user').val();
                    var request = helpers.ajaxPost
                        ? helpers.ajaxPost(routes.setClient, { data: data.data, user: user })
                        : $.post(routes.setClient, { data: data.data, user: user });

                    request.done(function(response) {
                        var html = '';
                        $.each(response.rows || [], function(i, item) {
                            html += '<option value="' + item.id + ':' + item.id_user + '">' + item.name + ' (' + item.get_user.name + ')</option>';
                        });

                        $('#pet').html(html);
                        $("#pet option[value='" + data.data + "']").attr('selected', true);

                        var fields = ['useridCreatePetModal', 'nameClientPetAdd', 'emailClientPetAdd', 'nameModalCreatePet', 'typeCreatePet', 'breedCreatePet'];
                        fields.forEach(function(fieldId) {
                            var field = getEl(null, fieldId);
                            if (field) field.value = '';
                        });

                        $('#createNewPet').modal('hide');
                        hideCharge();
                    });
                    return;
                }

                window.vetegramHelpers.toast({
                    text: labels.errorCreate || '',
                    position: 'bottom-right',
                    textAlign: 'center',
                    loader: false,
                    hideAfter: 4000,
                    icon: 'error'
                });
                hideCharge();
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
    Appointments.saveToCreatePet = saveToCreatePet;

    document.addEventListener('change', function(e) {
        if (e.target && e.target.matches('[data-appoint-action="create-pet-breed"]')) {
            getBreedPet();
        }
    });

    document.addEventListener('click', function(e) {
        var button = e.target.closest('[data-appoint-action="create-pet-save"]');
        if (button) {
            saveToCreatePet();
        }
    });
})();
