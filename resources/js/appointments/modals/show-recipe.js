const Appointments = window.Appointments = window.Appointments || {};
(function() {
    var cfg = window.APPOINT_MODAL_CONFIG && window.APPOINT_MODAL_CONFIG.showRecipe;
    if (!cfg) return;

    var helpers = window.vetegramHelpers || {};
    var ids = cfg.ids || {};
    var labels = cfg.labels || {};
    var routes = cfg.routes || {};

    function getEl(id, fallbackId) {
        return document.getElementById(id || fallbackId);
    }

    function setIdAppointmentToShow(id) {
        setCharge();
        var container = getEl(ids.container, 'tbodyShowRecipe');
        if (container) container.innerHTML = '';

        var request = helpers.ajaxPost
            ? helpers.ajaxPost(routes.getRecipeData, { id: id, onlyDetail: true })
            : $.post(routes.getRecipeData, { id: id, onlyDetail: true });

        request.done(function(data) {
            $.each((data.recipe && data.recipe.detail) || [], function(i, item) {
                var txt = '<tr>' +
                    '<td data-label="' + (labels.name || '') + ':" class="fw-medium py-1 py-md-3">' + item.title + '</td>' +
                    '<td data-label="' + (labels.duration || '') + ':" class="py-1 py-md-3">' + item.duration + '</td>' +
                    '<td data-label="' + (labels.take || '') + ':" class="py-1 py-md-3 text-center">' + item.take + '</td>' +
                    '<td data-label="' + (labels.quantity || '') + ':" class="py-1 py-md-3 text-center">' + item.quantity + '</td>' +
                    '<td data-label="' + (labels.notes || '') + ':" class="py-1 py-md-3 d-flex"><span class="flex-1">' + item.instruction + '</span></td>' +
                    '</tr>';
                if (container) container.insertAdjacentHTML('beforeend', txt);
            });
            hideCharge();
        });
    }
    Appointments.setIdAppointmentToShow = setIdAppointmentToShow;
})();
