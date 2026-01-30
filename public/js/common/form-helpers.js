(function() {
    function getCsrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    function select2Width($el) {
        return $el.data('width') ? $el.data('width') : $el.hasClass('w-100') ? '100%' : 'style';
    }

    function initSelect2(selector, options = {}, context = null) {
        if (typeof $ === 'undefined' || typeof $.fn.select2 === 'undefined') {
            return;
        }
        let $els;
        if (selector) {
            if (selector.jquery) {
                $els = selector;
            } else if (selector instanceof Element || selector === document || selector === window) {
                $els = $(selector);
            } else {
                const $ctx = context ? $(context) : $(document);
                $els = $ctx.find(selector);
            }
        } else {
            const $ctx = context ? $(context) : $(document);
            $els = $ctx.find('.select2');
        }
        if (!$els.length) return;
        $els.each(function() {
            const $el = $(this);
            $el.select2(Object.assign({
                theme: 'bootstrap-5',
                width: select2Width($el),
                placeholder: $el.data('placeholder')
            }, options));
        });
    }

    function ajaxPost(url, data, options = {}) {
        if (typeof $ === 'undefined') {
            return null;
        }
        return $.ajax(Object.assign({
            type: 'POST',
            url: url,
            dataType: 'json',
            headers: {
                "X-CSRF-TOKEN": getCsrfToken()
            },
            data: data
        }, options));
    }

    function ajaxFormPost(form, url, options = {}) {
        const targetForm = typeof form === 'string' ? document.querySelector(form) : form;
        if (!targetForm) {
            return Promise.resolve(null);
        }
        const actionUrl = url || targetForm.action || '';
        const formData = new FormData(targetForm);
        const omit = options.omit || [];
        omit.forEach((key) => formData.delete(key));
        const extra = options.append || {};
        Object.keys(extra).forEach((key) => formData.append(key, extra[key]));
        const headers = Object.assign({
            'X-CSRF-TOKEN': getCsrfToken()
        }, options.headers || {});
        const fetchOptions = Object.assign({
            method: options.method || 'POST',
            credentials: options.credentials || 'same-origin',
            headers: headers,
            body: formData
        }, options.fetchOptions || {});
        return fetch(actionUrl, fetchOptions);
    }

    function toast(options = {}) {
        if (!options) {
            return;
        }
        let opts = options;
        if (typeof options === 'string') {
            opts = { text: options };
        }
        if (window.vetegramHelpers && window.vetegramHelpers.toast) {
            return window.vetegramHelpers.toast(opts);
        }
        const text = opts.text || opts.heading || '';
        const icon = opts.icon || opts.type || 'info';
        if (window.toastr && typeof window.toastr[icon] === 'function') {
            return window.toastr[icon](text, opts.heading || '');
        }
        if (window.Swal) {
            return Swal.fire({
                title: opts.heading || '',
                text: text,
                icon: icon === 'warning' ? 'warning' : icon === 'error' ? 'error' : 'info',
                confirmButtonColor: '#4bc6f9'
            });
        }
        if (text) {
            alert(text);
        }
    }

    function toastSuccess(message, title) {
        const msg = message || 'OK';
        if (window.Swal) {
            return Swal.fire({
                title: title || 'Success',
                text: msg,
                icon: 'success',
                confirmButtonColor: '#4bc6f9'
            });
        }
        if (window.toastr && typeof window.toastr.success === 'function') {
            return window.toastr.success(msg, title);
        }
        alert(msg);
    }

    function toastError(message, title) {
        const msg = message || 'Error';
        if (window.Swal) {
            return Swal.fire({
                title: title || 'Error',
                text: msg,
                icon: 'error',
                confirmButtonColor: '#4bc6f9'
            });
        }
        if (window.toastr && typeof window.toastr.error === 'function') {
            return window.toastr.error(msg, title);
        }
        alert(msg);
    }

    function enterOnlyNumbers(event) {
        if (event.keyCode == 8 || event.keyCode == 9 || (event.keyCode >= 37 && event.keyCode <= 40) || event.keyCode == 188 || event.keyCode == 190) {
            return;
        }
        if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105)) {
            event.preventDefault();
        }
    }

    function validateEmail(email) {
        const reg = /^[0-9a-z_\-\+.]+@[0-9a-z\-\.]+\.[a-z]{2,8}$/i;
        return reg.test(email || '');
    }

    function normalizeString(str) {
        if (!str || typeof str.normalize !== 'function') {
            return str || '';
        }
        return str.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
    }

    window.vetegramHelpers = window.vetegramHelpers || {};
    window.vetegramHelpers.getCsrfToken = getCsrfToken;
    window.vetegramHelpers.initSelect2 = initSelect2;
    window.vetegramHelpers.ajaxPost = ajaxPost;
    window.vetegramHelpers.ajaxFormPost = ajaxFormPost;
    window.vetegramHelpers.toast = toast;
    window.vetegramHelpers.validateEmail = validateEmail;
    window.vetegramHelpers.normalizeString = normalizeString;
    window.vetegramHelpers.toastSuccess = toastSuccess;
    window.vetegramHelpers.toastError = toastError;
    window.vetegramHelpers.enterOnlyNumbers = enterOnlyNumbers;
})();
