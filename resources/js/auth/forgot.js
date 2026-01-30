(function() {
    const config = window.AUTH_FORGOT_CONFIG || {};
    const labels = config.labels || {};
    const helpers = window.vetegramHelpers || {};

    function validateEmail(value) {
        if (helpers.validateEmail) {
            return helpers.validateEmail(value);
        }
        return (value || '') !== '';
    }

    function handleSubmit(event) {
        const form = event.target;
        if (!form || form.tagName !== 'FORM') return;
        const emailInput = form.querySelector('#email');
        if (!emailInput) return;

        emailInput.classList.remove('is-invalid');
        const valid = validateEmail(emailInput.value);
        if (!valid) {
            emailInput.classList.add('is-invalid');
            event.preventDefault();
            return;
        }

        if (typeof setLoad === 'function') {
            setLoad('btnReset', labels.processing || '');
        }
    }

    document.addEventListener('submit', handleSubmit);
})();
