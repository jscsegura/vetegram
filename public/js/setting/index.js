(function() {
    const Settings = window.Settings = window.Settings || {};
    const cfg = window.SETTING_INDEX_CONFIG || {};
    const helpers = window.vetegramHelpers || {};

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

    function initSelects() {
        if (helpers.initSelect2) {
            helpers.initSelect2('.select2', {
                closeOnSelect: false
            });
            return;
        }
    }

    function initTooltips() {
        if (!window.bootstrap || !document.querySelectorAll) {
            return;
        }
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltipTriggerList.forEach((el) => {
            new bootstrap.Tooltip(el);
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

    function validategenerate() {
        let valid = validateRequired('.loadfield');

        let start = $('#loadStart').val();
        let end = $('#loadEnd').val();

        start = (start || '').replace(/:/g, '');
        end = (end || '').replace(/:/g, '');

        if (start && end && parseInt(start, 10) >= parseInt(end, 10)) {
            valid = false;
            $('#loadEnd').addClass('is-invalid');
        }

        if (valid) {
            if (typeof setCharge === 'function') {
                setCharge();
            }
        }

        return valid;
    }

    function addHours() {
        if (!validateRequired('.requeridoadd')) {
            return;
        }

        if (typeof setLoad === 'function') {
            setLoad('btn-addhour', cfg.saveProcessLabel || 'Procesando...');
        }

        const day = $('#templateDay').val();
        const hour = $('#templateHour').val();
        const minute = $('#templateMinute').val();

        const post = helpers.ajaxPost
            ? helpers.ajaxPost
            : function(url, data) { return $.post(url, data); };

        post(cfg.addHourUrl, { day: day, hour: hour, minute: minute })
            .done(function(data) {
                if (data.type === '200') {
                    const counter = $('#setDay' + day).attr('data-counter');
                    const html = '<p data-hour="' + data.text + '" class="d-flex align-items-center m-0 datelist' + day + '">' + data.hour + ' <span class="deleteH" data-day="' + day + '" data-id="' + data.id + '" data-action="Settings.deleteHour" data-action-event="click" data-action-args="$el"><i class="fa-solid fa-xmark"></i></span></p>';

                    if (counter == 0) {
                        $('#setDay' + day)
                            .addClass('d-flex flex-row flex-wrap align-items-start justify-content-center gap-2')
                            .html(html)
                            .attr('data-counter', '1');
                    } else {
                        let lastElement = $('#setDay' + day);
                        let insert = false;
                        $('.datelist' + day).each(function() {
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
                    $('#initialFrm').hide();
                }

                if (data.type === '401' && window.Swal) {
                    Swal.fire({
                        title: cfg.hourExistsTitle || 'Horario ya existe',
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
                    stopLoad('btn-addhour', cfg.addHourStopLabel || 'label.add');
                }
            });
    }

    function deleteHour(obj) {
        const day = $(obj).attr('data-day');
        const id = $(obj).attr('data-id');

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary btn-sm text-uppercase px-4 marginleft20',
                cancelButton: 'btn btn-danger btn-sm text-uppercase px-4'
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: cfg.deleteHourTitle || 'Eliminar horario?',
            text: cfg.deleteHourText || '',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: cfg.deleteYesLabel || 'Si, eliminar',
            cancelButtonText: cfg.deleteNoLabel || 'No, cancelar',
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

            post(cfg.deleteHourUrl, { id: id })
                .done(function(data) {
                    if (data.isdelete === '1') {
                        const p = $(obj).parent('p');
                        const element = $(obj).parent('p').parent('div');
                        $(p).remove();

                        const quantity = $(element).find('p').toArray().length;
                        if (quantity === 0) {
                            $('#setDay' + day)
                                .removeClass('d-flex flex-row flex-wrap align-items-start justify-content-center gap-2')
                                .html('<p class="text-secondary fw-normal text-center opacity-75 m-0">' + (cfg.noHoursLabel || 'No hay horario') + '</p>')
                                .attr('data-counter', '0');
                        }
                    } else if (window.Swal) {
                        Swal.fire({
                            title: cfg.deleteHourErrorTitle || 'Error al eliminar',
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
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary btn-sm text-uppercase px-4 marginleft20',
                cancelButton: 'btn btn-danger btn-sm text-uppercase px-4'
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: cfg.deleteAllTitle || 'Eliminar horarios?',
            text: cfg.deleteAllText || '',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: cfg.deleteYesLabel || 'Si, eliminar',
            cancelButtonText: cfg.deleteNoLabel || 'No, cancelar',
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

            post(cfg.deleteAllUrl, { template: true })
                .done(function() {
                    location.reload();
                });
        });
    }

    function updateMode() {
        const mode = $('input[name="mode"]:checked').val();
        const onlineBooking = $('#onlineBooking').prop('checked') ? 1 : 0;

        if (typeof setLoad === 'function') {
            setLoad('btn-mode', cfg.saveProcessLabel || 'Procesando...');
        }

        const post = (window.vetegramHelpers && window.vetegramHelpers.ajaxPost)
            ? window.vetegramHelpers.ajaxPost
            : function(url, data) { return $.post(url, data); };

        post(cfg.updateModeUrl, { mode: mode, onlineBooking: onlineBooking })
            .always(function() {
                if (typeof stopLoad === 'function') {
                    stopLoad('btn-mode', cfg.saveLabelHtml || (cfg.saveLabel || 'Guardar'));
                }
            });
    }

    Settings.validategenerate = validategenerate;
    Settings.addHours = addHours;
    Settings.deleteHour = deleteHour;
    Settings.deleteAllHour = deleteAllHour;
    Settings.updateMode = updateMode;

    document.addEventListener('DOMContentLoaded', function() {
        initDateDropper();
        initSelects();
        initTooltips();
    });
})();
