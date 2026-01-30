(function() {
    const cfg = window.WPANEL_COUNTRIES_INDEX_CONFIG || {};
    if (!cfg.listUrl || !window.vetegramWpanel || !window.vetegramWpanel.initDataTable) {
        return;
    }

    function enabledRow(obj) {
        const id = $(obj).attr('data');
        if (typeof enabledRegister === 'function') {
            enabledRegister(cfg.enabledUrl, 'id=' + id, 'enabledRow' + id);
        }
    }

    const actions = window.WpanelActions = window.WpanelActions || {};
    actions.toggleEnabled = enabledRow;

    window.vetegramWpanel.initDataTable({
        ajax: cfg.listUrl,
        order: [[0, 'asc']],
        columns: [
            { data: 'id' },
            { data: 'title' },
            { data: 'iso2' },
            { data: 'iso3' },
            { data: 'phonecode' },
            {
                data: 'id',
                render: function(data, type, row) {
                    let btn = '<span id="enabledRow' + row.id + '"><a data="' + row.id + '" data-action="wpanel.toggleEnabled">';
                    if (row.enabled == 1) {
                        btn += '<img src="' + cfg.assets.enabled + '">';
                    } else {
                        btn += '<img src="' + cfg.assets.disabled + '">';
                    }
                    btn += '</a></span>';
                    return btn;
                },
                orderable: false,
                searchable: false,
                className: 'text-center'
            }
        ]
    });
})();
