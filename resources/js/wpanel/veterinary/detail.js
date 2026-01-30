(function() {
    const cfg = window.WPANEL_VETERINARY_DETAIL_CONFIG || {};

    function logWithUser() {
        if (typeof bootbox === 'undefined') {
            if (cfg.loginUrl) {
                $('.loadingTmp').css('display', 'block');
                location.href = cfg.loginUrl;
            }
            return;
        }
        bootbox.confirm({
            title: cfg.confirmTitle || 'Acceder como usuario',
            message: cfg.confirmMessage || 'Seguro que desea ingresar al panel de Vetegram como si fuera el usuario, cualquier accion se registrara como si fue hecha por el usuario',
            className: 'confirm_bootbox',
            buttons: {
                confirm: {
                    label: '<i class="fa fa-times"></i> Si, Ingresar ',
                    className: 'btn-success'
                },
                cancel: {
                    label: ' No, Cancelar ',
                    className: 'btn-danger'
                }
            },
            callback: function(result) {
                if (result) {
                    $('.loadingTmp').css('display', 'block');
                    location.href = cfg.loginUrl;
                }
            }
        });
    }

    const actions = window.LogActions = window.LogActions || {};
    actions.logWithUser = logWithUser;
})();
