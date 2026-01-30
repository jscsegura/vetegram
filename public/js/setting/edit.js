(function() {
    const Settings = window.Settings = window.Settings || {};
    const cfg = window.SETTING_EDIT_CONFIG || {};

    function initDateDropper() {
        if (typeof dateDropper === 'undefined') {
            return;
        }
        new dateDropper({
            selector: '.dDropper',
            format: 'd/m/y',
            expandable: true,
            showArrowsOnHover: true
        });
    }

    function validateRequired(selector) {
        let valid = true;
        $(selector).each(function(_, elem) {
            const value = $(elem).val();
            const text = (value === null || value === undefined) ? '' : value.toString().trim();
            if (text === '') {
                $(elem).addClass('is-invalid');
                valid = false;
            } else {
                $(elem).removeClass('is-invalid');
            }
        });
        return valid;
    }

    function getDate() {
        const date = $('#daySearch').val();
        if (date) {
            location.href = cfg.editBaseUrl + '/' + btoa(date);
        }
    }

    function chargeTemplate(obj) {
        const date = $(obj).attr('data-date');
        const day = $(obj).attr('data-day');

        if (typeof setLoad === 'function') {
            setLoad('btn-template', cfg.loadingTemplateLabel || 'Cargando plantilla');
        }

        const post = (window.vetegramHelpers && window.vetegramHelpers.ajaxPost)
            ? window.vetegramHelpers.ajaxPost
            : function(url, data) { return $.post(url, data); };

        post(cfg.setTemplateUrl, { date: date, day: day })
            .done(function() {
                location.reload();
            });
    }

    function addHours(obj) {
        if (!validateRequired('.requeridoadd')) {
            return;
        }

        const date = $(obj).attr('data-date');
        const hour = $('#templateHour').val();
        const minute = $('#templateMinute').val();

        if (typeof setLoad === 'function') {
            setLoad('btn-addhour', cfg.saveProcessLabel || 'Procesando...');
        }

        const post = (window.vetegramHelpers && window.vetegramHelpers.ajaxPost)
            ? window.vetegramHelpers.ajaxPost
            : function(url, data) { return $.post(url, data); };

        post(cfg.addAvailableHourUrl, { date: date, hour: hour, minute: minute })
            .done(function(data) {
                if (data.type === '200') {
                    const html = '<p data-hour="' + data.text + '" class="datelist d-flex align-items-center m-0">' + data.hour + ' <span class="deleteH" data-id="' + data.id + '" data-action="Settings.deleteHour" data-action-event="click" data-action-args="$el"><i class="fa-solid fa-xmark"></i></span></p>';

                    const count = document.getElementsByClassName('datelist').length;
                    if (count === 0) {
                        $('.settingsDays').append(html);
                        $('#container-template').hide();
                    } else {
                        let lastElement = $('.card-body');
                        let insert = false;
                        $('.datelist').each(function() {
                            const aux = $(this).attr('data-hour');
                            if (parseInt(aux, 10) > parseInt(data.text, 10)) {
                                $(this).before(html);
                                insert = true;
                                return false;
                            }
                            lastElement = $(this);
                        });

                        if (!insert) {
                            $(lastElement).after(html);
                        }
                    }
                }

                if (data.type === '401' && window.Swal) {
                    Swal.fire({
                        title: cfg.hourExistsTitle || 'Ya existe el horario que intenta ingresar',
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        }
                    });
                }
            })
            .always(function() {
                if (typeof stopLoad === 'function') {
                    stopLoad('btn-addhour', cfg.addHourStopLabel || '<i class="fa-solid fa-plus me-2"></i>Agregar');
                }
            });
    }

    function deleteNotAvailable() {
        if (!window.Swal) {
            return;
        }
        Swal.fire(
            cfg.notAvailableTitle || 'No se puede eliminar',
            cfg.notAvailableText || 'Para poder eliminar este horario debe eliminar o reagendar la cita que esta ocupando su lugar',
            'error'
        );
    }

    function deleteHour(obj) {
        const id = $(obj).attr('data-id');

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary btn-sm text-uppercase px-4 marginleft20',
                cancelButton: 'btn btn-danger btn-sm text-uppercase px-4'
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: cfg.deleteHourTitle || '¿Eliminar horario?',
            text: cfg.deleteHourText || 'Seguro que desea eliminar este horario de su agenda',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: cfg.deleteYesLabel || 'Si, eliminar!',
            cancelButtonText: cfg.deleteNoLabel || 'No, cancelar!',
            reverseButtons: true
        }).then((result) => {
            if (!result.isConfirmed) {
                return;
            }

            if (typeof setCharge === 'function') {
                setCharge();
            }

            const post = (window.vetegramHelpers && window.vetegramHelpers.ajaxPost)
                ? window.vetegramHelpers.ajaxPost
                : function(url, data) { return $.post(url, data); };

            post(cfg.deleteAvailableHourUrl, { id: id })
                .done(function(data) {
                    if (data.isdelete === '1') {
                        const p = $(obj).parent('p');
                        const element = $(obj).parent('p').parent('div');
                        $(p).remove();

                        const quantity = $(element).find('p').toArray().length;
                        if (quantity === 0) {
                            $('#container-template').show();
                        }
                    } else if (window.Swal) {
                        Swal.fire({
                            title: cfg.deleteHourErrorTitle || 'Ocurrio un error al eliminar el horario',
                            showClass: {
                                popup: 'animate__animated animate__fadeInDown'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOutUp'
                            }
                        });
                    }
                })
                .always(function() {
                    if (typeof hideCharge === 'function') {
                        hideCharge();
                    }
                });
        });
    }

    function deleteAllHour() {
        const date = cfg.date;
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary btn-sm text-uppercase px-4 marginleft20',
                cancelButton: 'btn btn-danger btn-sm text-uppercase px-4'
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: cfg.deleteAllTitle || '¿Eliminar todos los horarios?',
            text: cfg.deleteAllText || 'Seguro que desea eliminar todos los horarios del dia seleccionado, no será posible eliminar los que esten reservados o confirmados.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: cfg.deleteYesLabel || 'Si, eliminar!',
            cancelButtonText: cfg.deleteNoLabel || 'No, cancelar!',
            reverseButtons: true
        }).then((result) => {
            if (!result.isConfirmed) {
                return;
            }

            if (typeof setCharge === 'function') {
                setCharge();
            }

            const post = (window.vetegramHelpers && window.vetegramHelpers.ajaxPost)
                ? window.vetegramHelpers.ajaxPost
                : function(url, data) { return $.post(url, data); };

            post(cfg.deleteAllUrl, { date: date })
                .done(function() {
                    location.reload();
                });
        });
    }

    Settings.getDate = getDate;
    Settings.chargeTemplate = chargeTemplate;
    Settings.addHours = addHours;
    Settings.deleteNotAvailable = deleteNotAvailable;
    Settings.deleteHour = deleteHour;
    Settings.deleteAllHour = deleteAllHour;

    document.addEventListener('DOMContentLoaded', function() {
        initDateDropper();
    });
})();
