(function () {
    const Home = window.Home = window.Home || {};
    const config = window.HOME_PLAN_CONFIG || {};
    const helpers = window.vetegramHelpers || {};
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

    function callPlan() {
        if (!window.Swal) {
            if (config.routes && config.routes.payment) {
                location.href = config.routes.payment;
            }
            return;
        }

        const texts = config.texts || {};
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary btn-sm text-uppercase px-4 marginleft20',
                cancelButton: 'btn btn-danger btn-sm text-uppercase px-4'
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: texts.title || '',
            text: texts.text || '',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: texts.confirm || '',
            cancelButtonText: texts.cancel || '',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed && config.routes && config.routes.payment) {
                location.href = config.routes.payment;
            }
        });
    }

    function cancelPlan() {
        if (!window.$) {
            return;
        }

        $('#planWhy').removeClass('is-invalid');
        const reason = $('#planWhy').val();

        if (reason !== '') {
            if (typeof Home.setCharge === 'function') {
                setCharge();
            }

            ajaxPost((config.routes && config.routes.cancel) ? config.routes.cancel : '', { reason: reason }, {
                beforeSend: function () {},
                success: function () {
                    location.reload();
                }
            });
        } else {
            $('#planWhy').addClass('is-invalid');
        }
    }

    Home.callPlan = callPlan;
    Home.cancelPlan = cancelPlan;
})();
