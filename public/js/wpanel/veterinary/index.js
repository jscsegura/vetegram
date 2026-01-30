(function() {
    const cfg = window.WPANEL_VETERINARY_INDEX_CONFIG || {};
    if (!cfg.listUrl || !window.vetegramWpanel || !window.vetegramWpanel.initDataTable) {
        return;
    }

    window.vetegramWpanel.initDataTable({
        ajax: cfg.listUrl,
        columns: [
            { data: 'id' },
            { data: 'social_name' },
            { data: 'company' },
            { data: 'phone' },
            {
                data: 'id',
                render: function(data, type, row) {
                    if (row.pro == 1) {
                        return '<a href="' + cfg.proBaseUrl + '/' + row.id + '"><img src="' + cfg.assets.menu + '"></a>';
                    }
                    return '<a><img src="' + cfg.assets.locked + '"></a>';
                },
                orderable: false,
                searchable: false,
                className: 'text-center'
            },
            {
                data: 'id',
                render: function(data, type, row) {
                    if (row.expire_status == 1) {
                        return '<span style="color: red;">' + row.expire + '</span>';
                    }
                    return '<span>' + row.expire + '</span>';
                },
                orderable: false,
                searchable: false,
                className: 'text-center'
            },
            {
                data: 'id',
                render: function(data, type, row) {
                    return '<a href="' + cfg.usersBaseUrl + '/' + row.id + '"><img src="' + cfg.assets.menu + '"></a>';
                },
                orderable: false,
                searchable: false,
                className: 'text-center'
            }
        ]
    });
})();
