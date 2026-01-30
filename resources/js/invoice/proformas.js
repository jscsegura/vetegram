(function() {
    const config = window.INVOICE_PROFORMAS_CONFIG || {};
    const routes = config.routes || {};
    const labels = config.labels || {};
    const helpers = window.vetegramHelpers || {};

    function deleteProforma(id) {
        if (!routes.delete || !id) return;
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
            title: labels.deleteTitle || '',
            text: labels.deleteText || '',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: labels.deleteYes || '',
            cancelButtonText: labels.deleteNo || '',
            reverseButtons: true
        }).then((result) => {
            if (!result.isConfirmed) {
                return;
            }
            if (typeof setCharge === 'function') {
                setCharge();
            }
            const request = helpers.ajaxPost ? helpers.ajaxPost(routes.delete, { id: id }) : $.post(routes.delete, { id: id });
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
        const deleteBtn = event.target.closest('[data-invoice-action="delete-proforma"]');
        if (deleteBtn) {
            const id = deleteBtn.getAttribute('data-proforma-id');
            deleteProforma(id);
        }
    });
})();
