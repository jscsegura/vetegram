(function () {
    const Home = window.Home = window.Home || {};
    const config = window.HOME_SEARCH_CONFIG || {};
    const helpers = window.vetegramHelpers || {};
    const normalizeString = helpers.normalizeString || function (str) {
        if (!str || typeof str.normalize !== 'function') {
            return str || '';
        }
        return str.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
    };
    const validateEmail = helpers.validateEmail || function (email) {
        const reg = /^[0-9a-z_\-\+.]+@[0-9a-z\-\.]+\.[a-z]{2,8}$/i;
        return reg.test(email || '');
    };
    const ajaxPost = helpers.ajaxPost || function (url, data, options) {
        if (!window.$) {
            return null;
        }
        return $.ajax(Object.assign({
            type: 'POST',
            url: url,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': helpers.getCsrfToken ? helpers.getCsrfToken() : ''
            },
            data: data
        }, options));
    };

    function search() {
        let criteria = $('#magicSearch').attr('data-id');
        criteria = normalizeString(criteria);
        criteria = btoa(criteria || '');

        const base = (config.routes && config.routes.searchIndex) ? config.routes.searchIndex : '';
        location.href = base + '/?search=' + criteria;
    }

    function initMagicSearch() {
        if (!window.$ || !$.fn.magicsearch) {
            return;
        }

        let dataSource = config.querys || [];

        dataSource = dataSource.map(function (item) {
            item.company = normalizeString(item.company);
            item.address = normalizeString(item.address);
            return item;
        });

        $('#magicSearch').magicsearch({
            dataSource: dataSource,
            fields: ['socialname', 'company', 'email', 'website', 'address', 'resume', 'schedule'],
            id: 'id',
            format: '%company% \u00b7 %address%',
            multiple: true,
            focusShow: false,
            noResult: (config.texts && config.texts.noResult) ? config.texts.noResult : 'No hay resultados',
            multiField: 'company',
            multiStyle: {
                space: 4,
                width: 80
            }
        });
    }

    function startlogin() {
        let validate = true;

        $('#emailInput').removeClass('is-invalid');
        $('#passwordInput').removeClass('is-invalid');

        if (!validateEmail($('#emailInput').val())) {
            $('#emailInput').addClass('is-invalid');
            validate = false;
        }

        if ($('#passwordInput').val() === '') {
            $('#passwordInput').addClass('is-invalid');
            validate = false;
        }

        if (validate) {
            if (typeof Home.setCharge === 'function') {
                setCharge();
            }

            ajaxPost((config.routes && config.routes.loginAjax) ? config.routes.loginAjax : '', new FormData(document.getElementById('loginForm')), {
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    if (data.login === 'success') {
                        location.reload();
                    } else {
                        $('#loginError').show();
                        $('#loginErrorAlert').html('<strong>Error!</strong> ' + data.error);
                    }

                    if (typeof Home.hideCharge === 'function') {
                        hideCharge();
                    }
                },
                error: function () {
                    if (typeof Home.hideCharge === 'function') {
                        hideCharge();
                    }
                }
            });
        }

        return false;
    }

    function initPasswordToggle() {
        const passwordInput = document.getElementById('passwordInput');
        const passwordToggleBtn = document.querySelector('.btn-toggle-password');

        if (!passwordInput || !passwordToggleBtn) {
            return;
        }

        passwordToggleBtn.addEventListener('click', function () {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            passwordToggleBtn.innerHTML = isPassword
                ? '<i class="fa-regular fa-eye-slash"></i>'
                : '<i class="fa-regular fa-eye"></i>';
        });
    }

    $(function () {
        initMagicSearch();
        if (config.startSession) {
            initPasswordToggle();
        }
    });

    Home.search = search;

    if (config.startSession) {
        Home.startlogin = startlogin;
        Home.validaEmail = validateEmail;
    }
})();
