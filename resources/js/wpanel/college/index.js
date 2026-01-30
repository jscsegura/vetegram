(function() {
    const cfg = window.WPANEL_COLLEGE_INDEX_CONFIG || {};
    if (!cfg.listUrl || !window.vetegramWpanel || !window.vetegramWpanel.initDataTable) {
        return;
    }

    window.vetegramWpanel.initDataTable({
        ajax: cfg.listUrl,
        columns: [
            { data: 'id' },
            { data: 'code' },
            { data: 'dni' },
            { data: 'name' },
            { data: 'category' }
        ]
    });
})();
