(function() {
    const cfg = window.WPANEL_CLIENT_INDEX_CONFIG || {};
    if (!cfg.listUrl || !window.vetegramWpanel || !window.vetegramWpanel.initDataTable) {
        return;
    }

    function enabledRow(obj) {
        const id = $(obj).attr('data');
        if (typeof enabledRegister === 'function') {
            enabledRegister(cfg.lockUrl, 'id=' + id, 'lockRow' + id);
        }
    }

    function activeRow(obj) {
        const id = $(obj).attr('data');
        if (typeof bootbox === 'undefined') {
            if (typeof enabledRegister === 'function') {
                enabledRegister(cfg.enabledUrl, 'id=' + id, 'enabledRow' + id);
            }
            return;
        }
        bootbox.confirm({
            title: cfg.confirmTitle || 'Validar correo',
            message: cfg.confirmMessage || '\u00bfDesea confirmar la direcci\u00f3n de correo electronica del usuario como v\u00e1lida?',
            className: 'confirm_bootbox',
            buttons: {
                confirm: {
                    label: '<i class="fa fa-times"></i> Si, Validar ',
                    className: 'btn-success'
                },
                cancel: {
                    label: ' No, Cancelar ',
                    className: 'btn-danger'
                }
            },
            callback: function(result) {
                if (result && typeof enabledRegister === 'function') {
                    enabledRegister(cfg.enabledUrl, 'id=' + id, 'enabledRow' + id);
                }
            }
        });
    }

    const actions = window.WpanelActions = window.WpanelActions || {};
    actions.toggleEnabled = enabledRow;
    actions.toggleActive = activeRow;

    window.vetegramWpanel.initDataTable({
        ajax: cfg.listUrl,
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'email' },
            { data: 'phone' },
            {
                data: 'id',
                render: function(data, type, row) {
                    return '<a href="' + cfg.detailBaseUrl + '/' + row.id + '"><img src="' + cfg.assets.menu + '"></a>';
                },
                orderable: false,
                searchable: false,
                className: 'text-center'
            },
            {
                data: 'id',
                render: function(data, type, row) {
                    if (row.enabled == 1) {
                        return '<span id="enabledRow' + row.id + '"><a data="' + row.id + '"><img width="25px" src="' + cfg.assets.active + '"></a></span>';
                    }
                    return '<span id="enabledRow' + row.id + '"><a data="' + row.id + '" data-action="wpanel.toggleActive"><img width="25px" src="' + cfg.assets.deactivated + '"></a></span>';
                },
                orderable: false,
                searchable: false,
                className: 'text-center'
            },
            {
                data: 'id',
                render: function(data, type, row) {
                    let btn = '<span id="lockRow' + row.id + '"><a data="' + row.id + '" data-action="wpanel.toggleEnabled">';
                    if (row.lock == 1) {
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
