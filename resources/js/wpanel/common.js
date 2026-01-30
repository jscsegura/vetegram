(function() {
    const helpers = window.vetegramWpanel = window.vetegramWpanel || {};

    if (!helpers.dataTableLanguage) {
        helpers.dataTableLanguage = {
            sLengthMenu: '',
            sZeroRecords: 'No se encontraron resultados',
            sEmptyTable: 'Ning\u00fan dato disponible en esta tabla',
            sInfo: 'Registro _START_ al _END_ de un total de _TOTAL_ registros',
            sInfoEmpty: 'Mostrando registros del 0 al 0 de un total de 0 registros',
            sInfoFiltered: '',
            sSearch: 'Buscar:',
            oPaginate: {
                sFirst: 'Primero',
                sLast: '\u00daltimo',
                sNext: 'Siguiente',
                sPrevious: 'Anterior'
            }
        };
    }

    helpers.initDataTable = function(config) {
        if (typeof $ === 'undefined' || typeof $.fn.DataTable === 'undefined') {
            return null;
        }
        const selector = config.selector || '#tableList';
        const $table = $(selector);
        if (!$table.length) {
            return null;
        }
        const options = Object.assign({
            processing: true,
            serverSide: true,
            responsive: true,
            order: [[0, 'desc']],
            paging: true,
            pageLength: 25,
            language: helpers.dataTableLanguage
        }, config);
        return $table.DataTable(options);
    };

    helpers.getCsrfToken = function() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    };

    helpers.setLoading = function(show) {
        const loader = document.querySelector('.loadingTmp');
        if (loader) {
            loader.style.display = show ? 'block' : 'none';
        }
    };

    helpers.validateForm = function(form, options = {}) {
        if (!form) {
            return true;
        }
        const showMessage = options.showMessage !== false;
        const checkPassword = options.checkPassword === true;

        let isValid = true;

        form.querySelectorAll('.requerido').forEach((elem) => {
            if (!elem.value) {
                elem.style.border = '1px solid red';
                isValid = false;
            } else {
                elem.style.border = '1px solid #E6E6E6';
            }
        });

        form.querySelectorAll('.requeridoEmail').forEach((elem) => {
            const val = elem.value || '';
            const reg = /^[0-9a-z_\-\.]+@[0-9a-z\-\.]+\.[a-z]{2,4}$/i;
            if (!reg.test(val)) {
                elem.style.border = '1px solid red';
                isValid = false;
            } else {
                elem.style.border = '1px solid #E6E6E6';
            }
        });

        if (checkPassword) {
            const pass = document.getElementById('txtPassword');
            const repass = document.getElementById('txtPasswordConfirm');
            if (pass && repass && pass.value !== repass.value) {
                pass.style.border = '1px solid red';
                repass.style.border = '1px solid red';
                isValid = false;
            }
        }

        if (!isValid) {
            if (showMessage && typeof objInstanceName !== 'undefined') {
                objInstanceName.show('error', 'Vuelva a intentarlo', false, 'Debe rellenar los campos requeridos (*)');
            }
            return false;
        }
        helpers.setLoading(true);
        return true;
    };

    helpers.validateNoMsg = function(form) {
        if (!form) {
            return true;
        }
        let isValid = true;
        form.querySelectorAll('.requerido').forEach((elem) => {
            if (!elem.value) {
                elem.style.border = '1px solid red';
                isValid = false;
            } else {
                elem.style.border = '1px solid #E6E6E6';
            }
        });
        return isValid;
    };

})();
