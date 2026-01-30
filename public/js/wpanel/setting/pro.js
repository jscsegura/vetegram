(function() {
    const cfg = window.WPANEL_SETTING_PRO_CONFIG || {};

    function enabledRow(obj) {
        const id = $(obj).attr('data');
        if (typeof enabledRegister === 'function') {
            enabledRegister(cfg.enabledUrl, 'id=' + id, 'enabledRow' + id);
        }
    }

    function deleteRow(obj) {
        const id = $(obj).attr('data');
        const row = $(obj).parent().parent('tr');
        if (typeof eliminateRegister === 'function') {
            eliminateRegister(cfg.deleteUrl, 'id=' + id, row);
        }
    }

    const actions = window.WpanelActions = window.WpanelActions || {};
    actions.toggleEnabled = enabledRow;
    actions.deleteRow = deleteRow;
})();
