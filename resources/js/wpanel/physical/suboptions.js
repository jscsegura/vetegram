(function() {
    const cfg = window.WPANEL_PHYSICAL_SUBOPTIONS_CONFIG || {};
    if (!cfg.listUrl || !window.vetegramWpanel || !window.vetegramWpanel.initDataTable) {
        return;
    }

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

    window.vetegramWpanel.initDataTable({
        ajax: cfg.listUrl,
        columns: [
            { data: 'id' },
            { data: 'title_es' },
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
            },
            {
                data: 'id',
                render: function(data, type, row) {
                    return '<a href="' + cfg.editBaseUrl + '/' + row.id + '/edit-suboptions"><img src="' + cfg.assets.edit + '"></a>';
                },
                orderable: false,
                searchable: false,
                className: 'text-center'
            },
            {
                data: 'id',
                render: function(data, type, row) {
                    return '<a data="' + row.id + '" data-action="wpanel.deleteRow"><img src="' + cfg.assets.delete + '"></a>';
                },
                orderable: false,
                searchable: false,
                className: 'text-center'
            }
        ]
    });
})();
