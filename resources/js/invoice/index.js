(function() {
    const config = window.INVOICE_INDEX_CONFIG || {};
    const routes = config.routes || {};
    const labels = config.labels || {};
    const helpers = window.vetegramHelpers || {};

    function getEl(id) {
        return document.getElementById(id);
    }

    function getFilters() {
        const monthEl = getEl('monthselect');
        const yearEl = getEl('yearselect');
        const typeEl = getEl('billingFilter');
        const month = monthEl ? parseInt(monthEl.value || '0', 10) : 0;
        const year = yearEl ? parseInt(yearEl.value || '0', 10) : 0;
        const type = typeEl ? typeEl.value : '';
        return { month, year, type };
    }

    function navigateTo(month, year, type) {
        if (!routes.index) return;
        if (typeof setCharge === 'function') {
            setCharge();
        }
        const encodedMonth = window.btoa(String(month));
        const encodedYear = window.btoa(String(year));
        location.href = `${routes.index}/${encodedMonth}/${encodedYear}/${type}`;
    }

    function prevMonth() {
        const { month, year, type } = getFilters();
        if (!month || !year) return;
        let nextMonth = month;
        let nextYear = year;
        if (month === 1) {
            nextMonth = 12;
            nextYear = year - 1;
        } else {
            nextMonth = month - 1;
        }
        navigateTo(nextMonth, nextYear, type);
    }

    function nextMonth() {
        const { month, year, type } = getFilters();
        if (!month || !year) return;
        let nextMonth = month;
        let nextYear = year;
        if (month === 12) {
            nextMonth = 1;
            nextYear = year + 1;
        } else {
            nextMonth = month + 1;
        }
        navigateTo(nextMonth, nextYear, type);
    }

    function getInvoices() {
        const { month, year, type } = getFilters();
        if (!month || !year) return;
        navigateTo(month, year, type);
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
        const prevBtn = event.target.closest('[data-invoice-action="prev-month"]');
        if (prevBtn) {
            prevMonth();
            return;
        }

        const nextBtn = event.target.closest('[data-invoice-action="next-month"]');
        if (nextBtn) {
            nextMonth();
            return;
        }

        const resendBtn = event.target.closest('[data-invoice-action="resend"]');
        if (resendBtn) {
            const type = resendBtn.getAttribute('data-type');
            const clave = resendBtn.getAttribute('data-clave');
            resendDocument(type, clave);
        }
    });

    document.addEventListener('change', function(event) {
        const target = event.target;
        if (target && target.matches('[data-invoice-action="filter-change"]')) {
            getInvoices();
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        if (helpers.initSelect2) {
            helpers.initSelect2('.select2');
        }
    });
})();
