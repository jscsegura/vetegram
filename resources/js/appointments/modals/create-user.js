const Appointments = window.Appointments = window.Appointments || {};
(function() {
    var cfg = window.APPOINT_MODAL_CONFIG && window.APPOINT_MODAL_CONFIG.createUser;
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

    function getBreed() {
        var typeSelect = getEl(ids.typeSelect, 'petTypeCreateuser');
        var breedSelect = getEl(ids.breedSelect, 'petBreedCreateuser');
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
    Appointments.getBreed = getBreed;

    function saveToCreateUser() {
        var valid = true;
        document.querySelectorAll('.requeridoAddUser').forEach(function(elem) {
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
        ajaxPost(routes.createOwner, new FormData(getEl(ids.form, 'frmCreateUser')), {
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data.result === 'userexist') {
                    window.vetegramHelpers.toast({
                        text: labels.emailExists || '',
                        position: 'bottom-right',
                        textAlign: 'center',
                        loader: false,
                        hideAfter: 4000,
                        icon: 'warning'
                    });
                    hideCharge();
                    return;
                }

                if (data.result === 'create') {
                    var user = $('#user').val();
                    var request = helpers.ajaxPost
                        ? helpers.ajaxPost(routes.setClient, { data: data.data, user: user })
                        : $.post(routes.setClient, { data: data.data, user: user });

                    request.done(function(response) {
                        var associateUserDoctor = getEl(ids.associateField, 'associateUserDoctor');
                        if (associateUserDoctor && associateUserDoctor.value === '1') {
                            location.reload();
                        }

                        var html = '';
                        $.each(response.rows || [], function(i, item) {
                            html += '<option value="' + item.id + ':' + item.id_user + '">' + item.name + ' (' + item.get_user.name + ')</option>';
                        });

                        $('#pet').html(html);
                        $("#pet option[value='" + data.data + "']").attr('selected', true);

                        var fields = ['nameCreateuser', 'emailCreateuser', 'petNameCreateuser', 'petTypeCreateuser', 'petBreedCreateuser'];
                        fields.forEach(function(fieldId) {
                            var field = getEl(null, fieldId);
                            if (field) field.value = '';
                        });

                        $('#createNewUser').modal('hide');
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
    Appointments.saveToCreateUser = saveToCreateUser;

    document.addEventListener('change', function(e) {
        if (e.target && e.target.matches('[data-appoint-action="create-user-breed"]')) {
            getBreed();
        }
    });

    document.addEventListener('click', function(e) {
        var button = e.target.closest('[data-appoint-action="create-user-save"]');
        if (button) {
            saveToCreateUser();
        }
    });
})();
