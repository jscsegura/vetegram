(function() {
    const config = window.INVOICE_DETAIL_CONFIG || {};
    const routes = config.routes || {};
    const labels = config.labels || {};
    const helpers = window.vetegramHelpers || {};

    function initSelect2() {
        if (helpers.initSelect2) {
            helpers.initSelect2('.select2');
        }
    }

    function initDateDropper() {
        if (typeof dateDropper === 'undefined') {
            return;
        }
        new dateDropper({
            selector: '.dDropper',
            format: 'd/m/y',
            expandable: true,
            showArrowsOnHover: true
        });
    }

    function resendDocument(type, clave) {
        if (!routes.resend || !clave) return;
        const SwalLib = window.Swal || window.swal;
        if (!SwalLib) return;

        const swalWithBootstrapButtons = SwalLib.mixin({
            customClass: {
                confirmButton: 'btn btn-primary btn-sm text-uppercase px-4 marginleft20',
                cancelButton: 'btn btn-danger btn-sm text-uppercase px-4'
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: labels.resendTitle || '',
            text: labels.resendText || '',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: labels.resendYes || '',
            cancelButtonText: labels.resendNo || '',
            reverseButtons: true
        }).then((result) => {
            if (!result.isConfirmed) {
                return;
            }
            if (typeof setCharge === 'function') {
                setCharge();
            }
            const request = helpers.ajaxPost ? helpers.ajaxPost(routes.resend, { type: type, clave: clave }) : $.post(routes.resend, { type: type, clave: clave });
            if (request && request.done) {
                request.done(function() {
                    location.reload();
                    if (typeof hideCharge === 'function') {
                        hideCharge();
                    }
                });
            }
        });
    }

    document.addEventListener('click', function(event) {
        const resendBtn = event.target.closest('[data-invoice-action="resend"]');
        if (resendBtn) {
            const type = resendBtn.getAttribute('data-type');
            const clave = resendBtn.getAttribute('data-clave');
            resendDocument(type, clave);
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        initSelect2();
        initDateDropper();
    });
})();
