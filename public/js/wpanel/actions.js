(function() {
    const helpers = window.vetegramWpanel || {};
    const actions = window.WpanelActions = window.WpanelActions || {};
    const logActions = window.LogActions = window.LogActions || {};
    const router = window.vetegramActionRouter;

    function getIdFromEl(el, fallbackId) {
        if (fallbackId) return fallbackId;
        if (!el) return '';
        return el.getAttribute('data-id') || el.getAttribute('data-row-id') || el.getAttribute('data') || '';
    }

    function getUrlFromEl(el, fallbackUrl) {
        if (fallbackUrl) return fallbackUrl;
        if (!el) return '';
        return el.getAttribute('data-url') || '';
    }

    function getTargetFromEl(el, fallbackTarget) {
        if (fallbackTarget) return fallbackTarget;
        if (!el) return '';
        return el.getAttribute('data-target') || '';
    }

    actions.validate = actions.validate || function(mode, form, el) {
        const targetForm = form || el || document.querySelector('form[data-action="wpanel.validate"]');
        if (!helpers.validateForm || !helpers.validateNoMsg) {
            return true;
        }
        if (mode === 'nomsg') {
            return helpers.validateNoMsg(targetForm);
        }
        if (mode === 'password') {
            return helpers.validateForm(targetForm, { checkPassword: true });
        }
        return helpers.validateForm(targetForm);
    };

    actions.toggleEnabled = actions.toggleEnabled || function(el, url, id, target) {
        const finalUrl = getUrlFromEl(el, url);
        const finalId = getIdFromEl(el, id);
        const finalTarget = getTargetFromEl(el, target);
        if (!finalUrl || !finalId) {
            return false;
        }
        if (typeof enabledRegister === 'function') {
            enabledRegister(finalUrl, 'id=' + finalId, finalTarget);
        }
        return true;
    };

    actions.toggleActive = actions.toggleActive || function(el, url, id, target) {
        return actions.toggleEnabled(el, url, id, target);
    };

    actions.togglePro = actions.togglePro || function(el, url, id, target) {
        return actions.toggleEnabled(el, url, id, target);
    };

    actions.deleteRow = actions.deleteRow || function(el, url, id) {
        const finalUrl = getUrlFromEl(el, url);
        const finalId = getIdFromEl(el, id);
        if (!finalUrl || !finalId) {
            return false;
        }
        if (typeof eliminateRegister === 'function') {
            const row = document.querySelector('#row' + finalId) || (el ? el.closest('tr') : null);
            eliminateRegister(finalUrl, 'id=' + finalId, row);
        }
        return true;
    };

    actions.deleteFile = actions.deleteFile || function(url, payload, target, el) {
        const finalUrl = url || getUrlFromEl(el);
        const finalPayload = payload || (el ? el.getAttribute('data-payload') : '');
        const finalTarget = target || getTargetFromEl(el);
        if (!finalUrl || !finalPayload || !finalTarget) {
            return false;
        }
        if (typeof eliminateRegisterFile === 'function') {
            eliminateRegisterFile(finalUrl, finalPayload, finalTarget);
        }
        return true;
    };

    actions.open = actions.open || function(url, _arg2, el) {
        const targetUrl = url || (el ? el.getAttribute('data-url') : '');
        if (!targetUrl) return false;
        window.open(targetUrl, '_blank');
        return true;
    };

    if (router && router.register) {
        router.register('wpanel.validate', function(mode, form, el) {
            return actions.validate(mode, form, el);
        });
        router.register('wpanel.toggleEnabled', function(_arg1, _arg2, el) {
            return actions.toggleEnabled(el);
        });
        router.register('wpanel.toggleActive', function(_arg1, _arg2, el) {
            return actions.toggleActive(el);
        });
        router.register('wpanel.togglePro', function(_arg1, _arg2, el) {
            return actions.togglePro(el);
        });
        router.register('wpanel.deleteRow', function(url, id, el) {
            return actions.deleteRow(el, url, id);
        });
        router.register('wpanel.deleteFile', function(url, payload, target, el) {
            return actions.deleteFile(url, payload, target, el);
        });
        router.register('wpanel.open', function(url, _arg2, el) {
            return actions.open(url, null, el);
        });
        router.register('wpanel.logsDetail', function(_arg1, _arg2, el) {
            if (logActions.detail) {
                return logActions.detail(el);
            }
        });
        router.register('wpanel.logsFilter', function() {
            if (logActions.filter) {
                return logActions.filter();
            }
        });
        router.register('wpanel.logWithUser', function() {
            if (logActions.logWithUser) {
                return logActions.logWithUser();
            }
        });
    }
})();
