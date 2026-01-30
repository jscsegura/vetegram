(function () {
    const Home = window.Home = window.Home || {};
    const config = window.HOME_INDEX_CONFIG || {};
    const passwordInput = document.getElementById('passwordInput');
    const passwordToggleBtn = document.querySelector('.btn-toggle-password');

    if (passwordInput && passwordToggleBtn) {
        passwordToggleBtn.addEventListener('click', function () {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            passwordToggleBtn.innerHTML = isPassword
                ? '<i class="fa-regular fa-eye-slash"></i>'
                : '<i class="fa-regular fa-eye"></i>';
        });
    }

    const helpers = window.vetegramHelpers || {};
    const validaEmail = helpers.validateEmail || function (email) {
        const reg = /^[0-9a-z_\\-\\+.]+@[0-9a-z\\-\\.]+\\.[a-z]{2,8}$/i;
        return reg.test(email || '');
    };

    function validLogin() {
        let validate = true;

        if (!window.$) {
            return true;
        }

        $('#emailInput').removeClass('is-invalid');
        $('#passwordInput').removeClass('is-invalid');

        if (!validaEmail($('#emailInput').val())) {
            $('#emailInput').addClass('is-invalid');
            validate = false;
        }

        if ($('#passwordInput').val() === '') {
            $('#passwordInput').addClass('is-invalid');
            validate = false;
        }

        if (validate && typeof Home.setLoad === 'function') {
            const label = config.processLabel || '';
            setLoad('btnLogin', label);
        }

        return validate;
    }

    Home.validLogin = validLogin;
    Home.validaEmail = validaEmail;
})();
