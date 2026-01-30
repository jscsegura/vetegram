(function() {
    const cfg = window.WPANEL_CONTACT_INDEX_CONFIG || {};
    if (!cfg.listUrl || !window.vetegramWpanel || !window.vetegramWpanel.initDataTable) {
        return;
    }

    window.vetegramWpanel.initDataTable({
        ajax: cfg.listUrl,
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'email' },
            { data: 'message' },
            { data: 'ip' },
            { data: 'browser' }
        ]
    });
})();
