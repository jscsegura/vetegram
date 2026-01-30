(function() {
    const config = window.INVOICE_UPTAKE_CONFIG || {};
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

    function showToast(text) {
        if (!text || !window.vetegramHelpers || !window.vetegramHelpers.toast) return;
        window.vetegramHelpers.toast({
            text: text,
            position: 'bottom-right',
            textAlign: 'center',
            loader: false,
            hideAfter: 4000,
            icon: 'warning'
        });
    }

    function validateXml(event) {
        const input = document.getElementById('uploadinvoice');
        const file = input && input.files ? input.files[0] : null;
        if (!file) {
            showToast(labels.selectFile);
            if (event) event.preventDefault();
            return false;
        }

        const allowedTypes = ['text/xml', 'xml'];
        if (allowedTypes.indexOf(file.type) === -1) {
            showToast(labels.selectXml);
            if (event) event.preventDefault();
            return false;
        }
        return true;
    }

    document.addEventListener('submit', function(event) {
        const form = event.target;
        if (form && form.id === 'frm') {
            validateXml(event);
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        initSelect2();
        initDateDropper();
    });
})();
