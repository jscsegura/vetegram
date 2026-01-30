const Appointments = window.Appointments = window.Appointments || {};
(function() {
    var cfg = window.APPOINT_MODAL_CONFIG && window.APPOINT_MODAL_CONFIG.searchUser;
    if (!cfg) return;

    var helpers = window.vetegramHelpers || {};
    var ids = cfg.ids || {};
    var labels = cfg.labels || {};
    var routes = cfg.routes || {};

    function getEl(id, fallbackId) {
        return document.getElementById(id || fallbackId);
    }

    function searchClient() {
        var email = getEl(ids.emailInput, 'searchClientInput');
        var codePhone = getEl(ids.codeSelect, 'searchClientInputCode');
        var phone = getEl(ids.phoneInput, 'searchClientInputPhone');
        var printer = getEl(ids.resultsContainer, 'printerCreateUser');

        var emailVal = email ? email.value : '';
        var codeVal = codePhone ? codePhone.value : '';
        var phoneVal = phone ? phone.value : '';

        if (emailVal === '' && phoneVal === '') return;

        setLoad(ids.searchButton || 'btn-SearchClient', labels.search || '');

        var request = helpers.ajaxPost
            ? helpers.ajaxPost(routes.getClient, { email: emailVal, codePhone: codeVal, phone: phoneVal })
            : $.post(routes.getClient, { email: emailVal, codePhone: codeVal, phone: phoneVal });

        request.done(function(data) {
            var html = '';
            $.each(data.rows || [], function(i, item) {
                html += '<option value="' + item.id + ':' + item.id_user + '" data-iduser="' + item.get_user.id + '" data-name="' + item.get_user.name + '" data-email="' + item.get_user.email + '">' + item.name + ' (' + item.get_user.name + ')</option>';
            });

            var createPet = '<div class="col col-md-6"><button type="button" data-appoint-action="create-pet" class="btn btn-secondary btn-sm w-100"><i class="fa-solid fa-paw me-2"></i>' + (labels.createPet || '') + '</button></div>';
            if (html === '') {
                createPet = '';
                html = '<option value="" data-iduser="" data-name="" data-email="">' + (labels.notResult || '') + '</option>';
            }

            var txt = '<div class="d-flex flex-column flex-sm-row gap-3">' +
                '<div class="flex-grow-1">' +
                '<label class="form-label small">' + (labels.userSelected || '') + '</label>' +
                '<select id="userSearchInput" name="userSearchInput" class="form-select fc">' + html + '</select>' +
                '</div>' +
                '<button type="button" data-appoint-action="search-client-selected" id="btn-SearchClientSelected" class="btn btn-primary btn-sm align-self-sm-end"><i class="fa-solid fa-arrow-right me-2"></i>' + (labels.selected || '') + '</button>' +
                '</div>' +
                '<div class="row mt-4">' +
                createPet +
                '<div class="col col-md-6"><button type="button" class="btn btn-secondary btn-sm w-100" data-bs-toggle="modal" data-bs-target="#createNewUser"><i class="fa-solid fa-user me-2"></i>' + (labels.createUser || '') + '</button></div>' +
                '</div>';

            if (printer) {
                printer.innerHTML = txt;
            }
            stopLoad(ids.searchButton || 'btn-SearchClient', labels.search || '');
        });
    }
    Appointments.searchClient = searchClient;

    function searchClientSelected() {
        var select = getEl(ids.userSelect, 'userSearchInput');
        var user = getEl(ids.mainUserSelect, 'user');
        var data = select ? select.value : '';
        var userId = user ? user.value : '';

        if (!data) return;

        setLoad(ids.searchSelectedButton || 'btn-SearchClientSelected', labels.selected || '');

        var request = helpers.ajaxPost
            ? helpers.ajaxPost(routes.setClient, { data: data, user: userId })
            : $.post(routes.setClient, { data: data, user: userId });

        request.done(function(response) {
            var html = '';
            $.each(response.rows || [], function(i, item) {
                html += '<option value="' + item.id + ':' + item.id_user + '">' + item.name + ' (' + item.get_user.name + ')</option>';
            });

            $('#pet').html(html);
            $("#pet option[value='" + data + "']").attr('selected', true);

            $('#createUserModal').modal('hide');
            stopLoad(ids.searchSelectedButton || 'btn-SearchClientSelected', labels.selected || '');
        });
    }
    Appointments.searchClientSelected = searchClientSelected;

    document.addEventListener('click', function(e) {
        var searchBtn = e.target.closest('[data-appoint-action="search-client"]');
        if (searchBtn) {
            searchClient();
        }

        var selectBtn = e.target.closest('[data-appoint-action="search-client-selected"]');
        if (selectBtn) {
            searchClientSelected();
        }

        var createPetBtn = e.target.closest('[data-appoint-action="create-pet"]');
        if (createPetBtn && typeof chargeCreatePet === 'function') {
            chargeCreatePet();
        }
    });
})();
