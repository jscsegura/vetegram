(function() {
    const Invoice = window.Invoice = window.Invoice || {};
    const config = window.INVOICE_CREDIT_NOTE_CONFIG || {};
    const routes = config.routes || {};
    const ids = config.ids || {};
    const labels = config.labels || {};
    const helpers = window.vetegramHelpers || {};

    const invoiceIdEl = document.getElementById(ids.invoiceId || 'invoiceidnc');
    const reasonEl = document.getElementById(ids.reason || 'reasonnc');
    const actionEl = document.getElementById(ids.action || 'actionnc');

    function setInvoiceId(claveOrEl) {
        if (!invoiceIdEl) return;
        let clave = claveOrEl;
        if (claveOrEl && typeof claveOrEl === 'object' && typeof claveOrEl.getAttribute === 'function') {
            clave = claveOrEl.getAttribute('data-clave');
        }
        invoiceIdEl.value = clave || '';
    }

    function validateRequired() {
        let valid = true;
        const required = document.querySelectorAll('.requeridoNC');
        required.forEach((elem) => {
            const value = (elem.value || '').trim();
            if (value === '') {
                elem.classList.add('is-invalid');
                valid = false;
            } else {
                elem.classList.remove('is-invalid');
            }
        });
        return valid;
    }

    function saveCreditNote() {
        if (!routes.save) return;
        if (!validateRequired()) return;

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
            title: labels.confirmTitle || '',
            text: labels.confirmText || '',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: labels.confirmYes || '',
            cancelButtonText: labels.confirmNo || '',
            reverseButtons: true
        }).then((result) => {
            if (!result.isConfirmed) {
                return;
            }

            const clave = invoiceIdEl ? invoiceIdEl.value : '';
            const razon = reasonEl ? reasonEl.value : '';
            const action = actionEl ? actionEl.value : '';

            if (typeof setCharge === 'function') {
                setCharge();
            }

            const request = helpers.ajaxPost ? helpers.ajaxPost(routes.save, { clave: clave, razon: razon, action: action }) : $.post(routes.save, { clave: clave, razon: razon, action: action });
            if (request && request.done) {
                request.done(function(data) {
                    if (data && data.type == '200') {
                        if (SwalLib.close) {
                            SwalLib.close();
                        }
                        SwalLib.fire(labels.successTitle || '', (labels.successText || '') + (data.clave || ''), 'success');
                    } else {
                        if (window.vetegramHelpers && window.vetegramHelpers.toast) {
                            window.vetegramHelpers.toast({
                                text: labels.errorText || '',
                                position: 'bottom-right',
                                textAlign: 'center',
                                loader: false,
                                hideAfter: 4000,
                                icon: 'error'
                            });
                        }
                    }
                    if (typeof hideCharge === 'function') {
                        hideCharge();
                    }
                });
            }
        });
    }

    document.addEventListener('click', function(event) {
        const openBtn = event.target.closest('[data-invoice-action="credit-note-open"]');
        if (openBtn) {
            if (!openBtn.hasAttribute('data-action')) {
                setInvoiceId(openBtn.getAttribute('data-clave'));
            }
            return;
        }

        const saveBtn = event.target.closest('[data-invoice-action="credit-note-save"]');
        if (saveBtn) {
            saveCreditNote();
        }
    });

    Invoice.setIdInvoiceNc = setInvoiceId;
})();
