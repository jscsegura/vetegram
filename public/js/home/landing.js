(function () {
    const Home = window.Home = window.Home || {};
    const config = window.HOME_LANDING_CONFIG || {};
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

    function initScrollSpy() {
        if (window.bootstrap && window.bootstrap.ScrollSpy) {
            new bootstrap.ScrollSpy(document.body, {
                target: '#navBarMain',
                threshold: '0,1',
                rootMargin: '-30% 0% -70%',
                smoothScroll: true
            });
        }
    }

    function initBackToTop() {
        const button = document.getElementById('btTop');
        if (!button) {
            return;
        }

        function toggle() {
            if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
                button.style.display = 'block';
            } else {
                button.style.display = 'none';
            }
        }

        function backToTop() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }

        window.addEventListener('scroll', toggle);
        button.addEventListener('click', backToTop);
        toggle();
    }

    function validaFrmContact() {
        let validate = true;

        $('#fname').removeClass('is-invalid');
        $('#email').removeClass('is-invalid');
        $('#message').removeClass('is-invalid');

        if ($('#fname').val() === '') {
            $('#fname').addClass('is-invalid');
            validate = false;
        }

        if (!validateEmail($('#email').val())) {
            $('#email').addClass('is-invalid');
            validate = false;
        }

        if ($('#message').val() === '') {
            $('#message').addClass('is-invalid');
            validate = false;
        }

        if (validate) {
            const fname = $('#fname').val();
            const email = $('#email').val();
            const message = $('#message').val();

            $('#btnsender').html(config.texts ? config.texts.sending : '');
            $('#btnsender').attr('disabled', true);

            ajaxPost((config.routes && config.routes.contact) ? config.routes.contact : '', {
                fname: fname,
                email: email,
                message: message
            }, {
                beforeSend: function () {},
                success: function () {
                    $('#btnsender').html(config.texts ? config.texts.send : '');
                    $('#btnsender').attr('disabled', false);
                    $('#printerSend').css('display', 'block');
                }
            });
        }
    }

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

    document.addEventListener('DOMContentLoaded', function () {
        initScrollSpy();
        initBackToTop();
        initMagicSearch();
    });

    Home.validaFrmContact = validaFrmContact;
    Home.search = search;
})();
