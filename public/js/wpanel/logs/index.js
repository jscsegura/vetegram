(function() {
    const cfg = window.WPANEL_LOGS_INDEX_CONFIG || {};
    if (!cfg.listBaseUrl || !window.vetegramWpanel || !window.vetegramWpanel.initDataTable) {
        return;
    }

    let vartype = '';
    let varevent = '';
    let auditid = '';

    const dataTable = window.vetegramWpanel.initDataTable({
        ajax: cfg.listBaseUrl + '/?type=' + vartype + '&event=' + varevent + '&auditid=' + auditid,
        columns: [
            { data: 'id' },
            { data: 'event' },
            { data: 'auditable_type' },
            { data: 'auditable_id' },
            { data: 'author' },
            { data: 'created_at' },
            { data: 'ip_address' },
            {
                data: 'id',
                render: function(data, type, row) {
                    return '<a data-id="' + row.id + '" data-toggle="modal" data-target="#detailModal" data-action="wpanel.logsDetail"><img src="' + cfg.assets.menu + '" data-toggle="tooltip" data-placement="top" title="Detalles"></a>';
                },
                orderable: false,
                searchable: false,
                className: 'text-center'
            }
        ]
    });

    function bindTooltips() {
        if (typeof $ === 'undefined' || typeof $.fn.tooltip === 'undefined') {
            return;
        }
        $('[data-toggle="tooltip"]').tooltip();
    }

    if (dataTable && dataTable.on) {
        dataTable.on('draw', function() {
            bindTooltips();
        });
    }
    bindTooltips();

    function filter() {
        vartype = $('#type').val();
        varevent = $('#event').val();
        auditid = $('#auditid').val();
        if (dataTable && dataTable.ajax) {
            dataTable.ajax.url(cfg.listBaseUrl + '/?type=' + vartype + '&event=' + varevent + '&auditid=' + auditid);
            dataTable.draw();
        }
    }

    function detail(obj) {
        const id = $(obj).attr('data-id');
        $('.modal-body').html('<center>Cargando...</center>');

        const post = (window.vetegramHelpers && window.vetegramHelpers.ajaxPost)
            ? window.vetegramHelpers.ajaxPost
            : function(url, data) { return $.post(url, data); };

        post(cfg.detailUrl, { id: id })
            .done(function(data) {
                let url = '';
                if (data.url != '') {
                    url = '<div class="row">' +
                        '<div class="col-md-12 text-center">' +
                        '<label>Url: ' + data.url + '</label>' +
                        '</div>' +
                        '</div>' +
                        '<div class="row">' +
                        '<div class="col-md-12"><p>&nbsp;</p></div>' +
                        '</div>';
                }
                const txt = '<div class="row">' +
                    '<div class="col-md-12 text-center">' +
                    '<strong>UserId ' + data.userid + ' | ' + data.name + ' | ' + data.email + ' | Modulo: ' + data.module + '</strong>' +
                    '</div>' +
                    '</div>' +
                    '<div class="row">' +
                    '<div class="col-md-12"><p>&nbsp;</p></div>' +
                    '</div>' +
                    url +
                    '<div class="table-responsive-lg">' +
                    '<table class="table">' +
                    '<thead>' +
                    '<tr>' +
                    '<th scope="col" style="width: 50%;">Registro viejo</th>' +
                    '<th scope="col" style="width: 50%;">Registro nuevo</th>' +
                    '</tr>' +
                    '</thead>' +
                    '<tr>' +
                    '<td>' +
                    data.oldRegister +
                    '</td>' +
                    '<td>' +
                    data.newRegister +
                    '</td>' +
                    '</tr>' +
                    '</table>' +
                    '</div>';
                $('.modal-body').html(txt);
            });
    }

    const actions = window.LogActions = window.LogActions || {};
    actions.filter = filter;
    actions.detail = detail;
})();
