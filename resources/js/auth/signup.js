(function() {
    const config = window.AUTH_SIGNUP_CONFIG || {};
    const urls = config.urls || {};
    const labels = config.labels || {};
    const helpers = window.vetegramHelpers || {};

    function capitalizeFirstLetter(string) {
        if (!string) return '';
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

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

    function validateEmail(value) {
        if (helpers.validateEmail) {
            return helpers.validateEmail(value);
        }
        return (value || '') !== '';
    }

    function validateSignup(form) {
        let valid = true;
        const nameInput = form.querySelector('#name');
        const emailInput = form.querySelector('#email');
        const passwordInput = form.querySelector('#password');
        const cpasswordInput = form.querySelector('#cpassword');
        const termsCheck = form.querySelector('#termsCheck');

        [nameInput, emailInput, passwordInput, cpasswordInput, termsCheck].forEach((el) => {
            if (el) el.classList.remove('is-invalid');
        });

        if (!nameInput || (nameInput.value || '').trim() === '') {
            if (nameInput) nameInput.classList.add('is-invalid');
            valid = false;
        }

        if (!emailInput || !validateEmail(emailInput.value || '')) {
            if (emailInput) emailInput.classList.add('is-invalid');
            valid = false;
        }

        if (!passwordInput || (passwordInput.value || '').trim() === '') {
            if (passwordInput) passwordInput.classList.add('is-invalid');
            valid = false;
        }

        if (!cpasswordInput || (cpasswordInput.value || '').trim() === '') {
            if (cpasswordInput) cpasswordInput.classList.add('is-invalid');
            valid = false;
        }

        if (passwordInput && cpasswordInput && passwordInput.value !== cpasswordInput.value) {
            cpasswordInput.classList.add('is-invalid');
            valid = false;
        }

        if (termsCheck && !termsCheck.checked) {
            termsCheck.classList.add('is-invalid');
            valid = false;
        }

        if (valid && typeof setLoad === 'function') {
            setLoad('btnRegister', labels.processing || '');
        }

        return valid;
    }

    async function fetchInfo(value) {
        if (!urls.haciendaInfo) return;
        const nameInput = document.getElementById('name');
        let loadingModal = null;
        if (typeof $ !== 'undefined') {
            loadingModal = $('#loadingModal');
        }

        try {
            const res = await fetch(`${urls.haciendaInfo}?id=${encodeURIComponent(value)}&type=1`);
            if (!res.ok) {
                if (loadingModal) loadingModal.modal('toggle');
                return;
            }
            const body = await res.json();
            if (body && !body.ERROR) {
                const name = `${capitalizeFirstLetter((body.NOMBRE || '').toLowerCase())} ${capitalizeFirstLetter((body.APELLIDO1 || '').toLowerCase())} ${capitalizeFirstLetter((body.APELLIDO2 || '').toLowerCase())}`.trim();
                if (nameInput) nameInput.value = name;
            }
        } catch (e) {
            // no-op
        } finally {
            if (loadingModal) {
                loadingModal.modal('toggle');
            }
        }
    }

    document.addEventListener('click', function(event) {
        const toggle1 = event.target.closest('.btn-toggle-password');
        if (toggle1) {
            togglePassword(document.getElementById('password'), toggle1);
        }
        const toggle2 = event.target.closest('.btn-toggle-password2');
        if (toggle2) {
            togglePassword(document.getElementById('cpassword'), toggle2);
        }
    });

    document.addEventListener('change', function(event) {
        const target = event.target;
        if (!target || target.id !== 'idInput') return;
        const nameInput = document.getElementById('name');
        const loadingModal = typeof $ !== 'undefined' ? $('#loadingModal') : null;
        if (nameInput) nameInput.value = '';
        if (loadingModal) {
            loadingModal.modal('toggle');
        }
        const value = (target.value || '').trim();
        if (value === '') {
            if (loadingModal) loadingModal.modal('toggle');
            if (nameInput) nameInput.focus();
            return;
        }
        if (value.length < 9) {
            if (loadingModal) loadingModal.modal('toggle');
            return;
        }
        fetchInfo(value);
        if (nameInput) nameInput.focus();
    });

    document.addEventListener('submit', function(event) {
        const form = event.target;
        if (!form || form.id !== 'frmSignup') return;
        if (!validateSignup(form)) {
            event.preventDefault();
        }
    });
})();
