(function() {
    const router = window.vetegramActionRouter = window.vetegramActionRouter || {};
    const actions = router.actions = router.actions || {};

    router.register = function(name, handler) {
        actions[name] = handler;
    };

    router.resolve = function(action) {
        if (!action) {
            return null;
        }
        if (actions[action]) {
            return actions[action];
        }
        const parts = action.split('.');
        let ctx = window;
        for (const part of parts) {
            if (ctx && Object.prototype.hasOwnProperty.call(ctx, part)) {
                ctx = ctx[part];
            } else {
                ctx = null;
                break;
            }
        }
        return typeof ctx === 'function' ? ctx : null;
    };

    function coerceValue(value, el, event) {
        if (value === '$el') return el;
        if (value === '$event') return event;
        if (value === '$value') return el && 'value' in el ? el.value : undefined;
        if (value === '$checked') return el && 'checked' in el ? el.checked : undefined;
        if (value === 'true') return true;
        if (value === 'false') return false;
        if (value && /^-?\\d+(?:\\.\\d+)?$/.test(value)) return Number(value);
        return value;
    }

    function parseArgs(argString, el, event) {
        if (!argString) return [];
        return argString.split('|')
            .map((part) => part.trim())
            .filter((part) => part.length > 0)
            .map((part) => coerceValue(part, el, event));
    }

    function handleEvent(eventName, event) {
        const target = event.target.closest('[data-action]');
        if (!target) {
            return;
        }
        const expected = target.getAttribute('data-action-event') || (target.tagName === 'FORM' ? 'submit' : 'click');
        if (expected !== eventName) {
            return;
        }
        const action = target.getAttribute('data-action');
        if (!action) {
            return;
        }
        const args = parseArgs(target.getAttribute('data-action-args'), target, event);
        const handler = router.resolve(action);
        if (!handler) {
            return;
        }
        const result = handler.apply(null, args.concat([target, event]));
        if (result === false || target.hasAttribute('data-action-prevent')) {
            event.preventDefault();
        }
        if (target.hasAttribute('data-action-stop')) {
            event.stopPropagation();
        }
    }

    ['click', 'change', 'keydown', 'submit'].forEach((eventName) => {
        document.addEventListener(eventName, (event) => handleEvent(eventName, event));
    });

    router.register('prevent', function() {
        return false;
    });

    router.register('stop-propagation', function(_arg, _arg2, _el, event) {
        if (event && typeof event.stopPropagation === 'function') {
            event.stopPropagation();
        }
        return false;
    });

    router.register('trigger-file', function(selector, _arg2, _el, event) {
        const target = selector ? document.querySelector(selector) : null;
        if (event && typeof event.stopPropagation === 'function') {
            event.stopPropagation();
        }
        if (target && typeof target.click === 'function') {
            target.click();
        }
        return false;
    });

    router.register('navigate', function(url, _arg2, el) {
        const target = url || (el ? el.getAttribute('data-url') : '');
        if (target) {
            window.location.href = target;
        }
    });

    router.register('print', function() {
        if (typeof window.print === 'function') {
            window.print();
        }
    });

    router.register('modal.show', function(selector) {
        if (!selector) return;
        if (window.bootstrap && window.bootstrap.Modal) {
            const el = document.querySelector(selector);
            if (el) {
                const modal = window.bootstrap.Modal.getOrCreateInstance(el);
                modal.show();
            }
            return;
        }
        if (window.$ && typeof window.$.fn.modal === 'function') {
            window.$(selector).modal('show');
        }
    });

    router.register('wpanel.validate', function(mode, form, el) {
        const actions = window.WpanelActions || {};
        if (actions.validate) {
            return actions.validate(mode, form, el);
        }
        return true;
    });

    router.register('delete-file', function(url, payload, target, el) {
        const actions = window.WpanelActions || {};
        if (actions.deleteFile) {
            return actions.deleteFile(url, payload, target, el);
        }
    });

    router.register('toggle-enabled', function(_arg1, _arg2, el) {
        const actions = window.WpanelActions || {};
        if (actions.toggleEnabled) {
            return actions.toggleEnabled(el);
        }
    });
    router.register('toggle-active', function(_arg1, _arg2, el) {
        const actions = window.WpanelActions || {};
        if (actions.toggleActive) {
            return actions.toggleActive(el);
        }
    });
    router.register('toggle-pro', function(_arg1, _arg2, el) {
        const actions = window.WpanelActions || {};
        if (actions.togglePro) {
            return actions.togglePro(el);
        }
    });


    router.register('delete-row', function(url, id, el) {
        const actions = window.WpanelActions || {};
        if (actions.deleteRow) {
            return actions.deleteRow(el, url, id);
        }
    });

    router.register('log-with-user', function() {
        const actions = window.LogActions || {};
        if (actions.logWithUser) {
            return actions.logWithUser();
        }
    });

    router.register('show-plus', function(_arg1, _arg2, el) {
        const actions = window.WpanelActions || {};
        if (actions.showPlus && el) {
            return actions.showPlus(el);
        }
    });

    router.register('filter-logs', function() {
        const actions = window.LogActions || {};
        if (actions.filter) {
            return actions.filter();
        }
    });

    router.register('logs-detail', function(_arg1, _arg2, el) {
        const actions = window.LogActions || {};
        if (actions.detail && el) {
            return actions.detail(el);
        }
    });
})();
