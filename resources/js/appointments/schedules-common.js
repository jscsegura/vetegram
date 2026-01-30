(function() {
    const cfg = window.APPOINTMENTS_SCHEDULE_VIEW_CONFIG || {};
    const routes = cfg.routes || {};
    const ranges = cfg.ranges || {};
    const rangeTypes = cfg.rangeTypes || { month: 1, week: 2, day: 3 };

    function getRangeConfig(range) {
        return ranges[range] || null;
    }

    function getValue(selector) {
        if (!selector || typeof $ === 'undefined') {
            return '';
        }
        return $(selector).val();
    }

    function setValue(selector, value) {
        if (!selector || typeof $ === 'undefined') {
            return;
        }
        $(selector).val(value);
    }

    function navigate(range, from, to) {
        if (!routes.scheduleBase) {
            return;
        }
        const config = getRangeConfig(range);
        if (!config) {
            return;
        }
        const userId = getValue(config.userSelect);
        if (typeof setCharge === 'function') {
            setCharge();
        }
        const type = rangeTypes[range] || '';
        location.href = `${routes.scheduleBase}/${btoa(userId)}/${btoa(from)}/${btoa(to)}/${type}`;
    }

    function handleNavClick(event) {
        const trigger = event.target.closest('[data-schedule-nav]');
        if (!trigger) {
            return;
        }
        event.preventDefault();
        const range = trigger.getAttribute('data-schedule-nav');
        const direction = trigger.getAttribute('data-direction') || 'prev';
        const config = getRangeConfig(range);
        if (!config) {
            return;
        }
        const from = getValue(config[direction + 'From']);
        const to = getValue(config[direction + 'To']);
        if (!from || !to) {
            return;
        }
        setValue(config.fromInput, from);
        setValue(config.toInput, to);
        navigate(range, from, to);
    }

    function handleUserChange(event) {
        const target = event.target.closest('[data-schedule-user]');
        if (!target) {
            return;
        }
        const range = target.getAttribute('data-schedule-user');
        const config = getRangeConfig(range);
        if (!config) {
            return;
        }
        const from = getValue(config.fromInput);
        const to = getValue(config.toInput);
        if (!from || !to) {
            return;
        }
        navigate(range, from, to);
    }

    document.addEventListener('click', handleNavClick);
    document.addEventListener('change', handleUserChange);
})();
