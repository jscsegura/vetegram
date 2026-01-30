(function () {
    const Home = window.Home = window.Home || {};
    const config = window.HOME_DASH_CONFIG || {};

    if (typeof Home.dateDropper === 'function') {
        const options = Object.assign({
            selector: '.dDropper',
            format: 'd/m/y',
            expandable: true,
            showArrowsOnHover: true
        }, config.dateDropper || {});
        new dateDropper(options);
    }

    function startAppointment(url) {
        if (!window.Swal) {
            if (url) {
                location.href = url;
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
            if (result.isConfirmed && url) {
                location.href = url;
            }
        });
    }

    Home.startAppointment = startAppointment;
})();
