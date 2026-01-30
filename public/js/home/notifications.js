(function () {
    const Home = window.Home = window.Home || {};
    const config = window.HOME_NOTIFICATIONS_CONFIG || {};
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
    Home.sectionReminder = 1;

    if (typeof Home.dateDropper === 'function') {
        new dateDropper({
            selector: '.dDropperEdit',
            format: 'd/m/y',
            expandable: true,
            showArrowsOnHover: true,
            defaultDate: true
        });
    }

    function deleteReminder(obj) {
        if (!window.$ || !window.Swal) {
            return;
        }

        const id = $(obj).attr('data-id');
        const texts = config.texts || {};

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary btn-sm text-uppercase px-4 marginleft20',
                cancelButton: 'btn btn-danger btn-sm text-uppercase px-4'
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: texts.deleteTitle || '',
            text: texts.deleteConfirm || '',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: texts.yesDelete || '',
            cancelButtonText: texts.noCancel || '',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                if (typeof Home.setCharge === 'function') {
                    setCharge();
                }

                ajaxPost((config.routes && config.routes.remove) ? config.routes.remove : '', { id: id }, {
                    success: function (data) {
                        if (data.process === '1') {
                            location.reload();
                        } else if (window.vetegramHelpers && window.vetegramHelpers.toast) {
                            window.vetegramHelpers.toast({
                                text: texts.problemNotification || '',
                                position: 'bottom-right',
                                textAlign: 'center',
                                loader: false,
                                hideAfter: 4000,
                                icon: 'warning'
                            });
                        }

                        if (typeof Home.hideCharge === 'function') {
                            hideCharge();
                        }
                    }
                });
            }
        });
    }

    function setIdAppointmentToReminderEdit(id, description, date, hour, defaultDate, repeat, period, quantity) {
        $('#reminderIdEdit').val(id);
        $('#reminderDetailModalEdit').val(description);
        $('#reminderDateModalEdit').val(date);
        $('#reminderTimeModalEdit').val(hour);

        $('#reminderDateModalEdit').attr('data-dd-opt-default-date', defaultDate);

        if (repeat === 1) {
            $('#repeatReminderEdit').val(repeat);
            $('#periodReminderEdit').val(period);
            $('#quantityReminderEdit').val(quantity);
        } else {
            $('#repeatReminderEdit').val(0);
            $('#periodReminderEdit').val(1);
            $('#quantityReminderEdit').val('');

            $('#periodReminderEdit').attr('disabled', true);
            $('#quantityReminderEdit').attr('disabled', true);
        }
    }

    function saveReminderModalEdit() {
        let valid = true;
        const texts = config.texts || {};

        const id = $('#reminderIdEdit').val();
        const detail = $('#reminderDetailModalEdit').val();
        const date = $('#reminderDateModalEdit').val();
        const time = $('#reminderTimeModalEdit').val();

        $('.requeridoModalSetReminderEdit').each(function (i, elem) {
            let value = $(elem).val();
            value = value ? value.trim() : '';
            if (value === '') {
                $(elem).addClass('is-invalid');
                valid = false;
            } else {
                $(elem).removeClass('is-invalid');
            }
        });

        const repeat = $('#repeatReminderEdit').val();
        let quantity = 0;
        let period = 0;
        if (repeat === '1' || repeat === 1) {
            if ($('#quantityReminderEdit').val() === '') {
                $('#quantityReminderEdit').addClass('is-invalid');
                valid = false;
            } else {
                $('#quantityReminderEdit').removeClass('is-invalid');
            }

            quantity = $('#quantityReminderEdit').val();
            period = $('#periodReminderEdit').val();
        }

        if (valid) {
            if (typeof Home.setCharge === 'function') {
                setCharge();
            }

            ajaxPost((config.routes && config.routes.update) ? config.routes.update : '', {
                id: id,
                detail: detail,
                date: date,
                time: time,
                repeat: repeat,
                period: period,
                quantity: quantity
            }, {
                success: function (data) {
                    if (data.save === 1) {
                        location.reload();
                    } else if (data.save === 2) {
                    window.vetegramHelpers.toast({
                        text: texts.reminderAfterDate || '',
                        position: 'bottom-right',
                        textAlign: 'center',
                        loader: false,
                        hideAfter: 4000,
                        icon: 'error'
                    });
                } else if (data.save === 3) {
                    window.vetegramHelpers.toast({
                        text: texts.reminderPastDate || '',
                        position: 'bottom-right',
                        textAlign: 'center',
                        loader: false,
                        hideAfter: 4000,
                        icon: 'error'
                    });
                } else {
                    window.vetegramHelpers.toast({
                        text: texts.reminderError || '',
                        position: 'bottom-right',
                        textAlign: 'center',
                        loader: false,
                        hideAfter: 4000,
                        icon: 'error'
                    });
                }

                    if (typeof Home.hideCharge === 'function') {
                        hideCharge();
                    }
                }
            });
        }
    }

    function setRepeatEdit() {
        const repeat = $('#repeatReminderEdit').val();

        if (repeat === '1' || repeat === 1) {
            $('#periodReminderEdit').attr('disabled', false);
            $('#quantityReminderEdit').attr('disabled', false);
        } else {
            $('#periodReminderEdit').val('1');
            $('#quantityReminderEdit').val('');

            $('#periodReminderEdit').attr('disabled', true);
            $('#quantityReminderEdit').attr('disabled', true);
        }
    }

    Home.deleteReminder = deleteReminder;
    Home.setIdAppointmentToReminderEdit = setIdAppointmentToReminderEdit;
    Home.saveReminderModalEdit = saveReminderModalEdit;
    Home.setRepeatEdit = setRepeatEdit;
})();
