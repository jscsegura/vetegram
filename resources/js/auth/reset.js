(function() {
    const config = window.AUTH_RESET_CONFIG || {};
    const labels = config.labels || {};

    function togglePassword(input, button) {
        if (!input || !button) return;
        if (input.type === 'password') {
            input.type = 'text';
            button.innerHTML = '<i class="fa-regular fa-eye-slash"></i>';
        } else {
            input.type = 'password';
            button.innerHTML = '<i class="fa-regular fa-eye"></i>';
        }
    }

    function validateReset(form) {
        let valid = true;
        const password = form.querySelector('#password');
        const confirmation = form.querySelector('#password_confirmation');

        if (password) password.classList.remove('is-invalid');
        if (confirmation) confirmation.classList.remove('is-invalid');

        if (!password || (password.value || '').trim() === '') {
            if (password) password.classList.add('is-invalid');
            valid = false;
        }

        if (!confirmation || (confirmation.value || '').trim() === '') {
            if (confirmation) confirmation.classList.add('is-invalid');
            valid = false;
        }

        if (password && confirmation && password.value !== confirmation.value) {
            confirmation.classList.add('is-invalid');
            valid = false;
        }

        if (valid && typeof setLoad === 'function') {
            setLoad('btnReset', labels.processing || '');
        }

        return valid;
    }

    document.addEventListener('click', function(event) {
        const toggle1 = event.target.closest('.btn-toggle-password');
        if (toggle1) {
            togglePassword(document.getElementById('password'), toggle1);
        }
        const toggle2 = event.target.closest('.btn-toggle-password2');
        if (toggle2) {
            togglePassword(document.getElementById('password_confirmation'), toggle2);
        }
    });

    document.addEventListener('submit', function(event) {
        const form = event.target;
        if (!form || form.tagName !== 'FORM') return;
        if (!validateReset(form)) {
            event.preventDefault();
        }
    });
})();
