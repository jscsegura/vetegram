const Appointments = window.Appointments = window.Appointments || {};
const appointmentsCancelConfig = window.APPOINTMENTS_CANCEL_CONFIG || {};
const appointmentsCancelTexts = appointmentsCancelConfig.texts || {};
const appointmentsCancelRoutes = appointmentsCancelConfig.routes || {};
const helpers = window.vetegramHelpers || {};

function cancelAjaxPost(url, data, options = {}) {
    if (helpers.ajaxPost) {
        return helpers.ajaxPost(url, data, options);
    }
    if (typeof $ === 'undefined') {
        return null;
    }
    const token = helpers.getCsrfToken ? helpers.getCsrfToken() : '';
    return $.ajax(Object.assign({
        type: 'POST',
        url: url,
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': token
        },
        data: data
    }, options));
}

function setToCancel(id, user_id) {
    var option = 'cancelar';

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-primary btn-sm text-uppercase px-4 marginleft20',
            cancelButton: 'btn btn-danger btn-sm text-uppercase px-4'
        },
        buttonsStyling: false
    });

    swalWithBootstrapButtons.fire({
        title: appointmentsCancelTexts.cancelTitle || '',
        text: appointmentsCancelTexts.cancelConfirm || '',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: appointmentsCancelTexts.cancelYes || '',
        cancelButtonText: appointmentsCancelTexts.cancelNo || 'No',
        reverseButtons: true
    }).then((result) => {
        if (!result.isConfirmed) {
            return;
        }
        if (!appointmentsCancelRoutes.cancelOrReschedule) {
            return;
        }

        setCharge();

        cancelAjaxPost(appointmentsCancelRoutes.cancelOrReschedule, {
            id: id,
            user_id: user_id,
            date: '',
            time: '',
            option: option
        }, {
            success: function(data) {
                if (data && data.process == '1') {
                    location.reload();
                } else if (data && data.process == '500') {
                    window.vetegramHelpers.toast({
                        text: appointmentsCancelTexts.cancelError || '',
                        position: 'bottom-right',
                        textAlign: 'center',
                        loader: false,
                        hideAfter: 4000,
                        icon: 'error'
                    });
                }
                hideCharge();
            },
            error: function() {
                window.vetegramHelpers.toast({
                    text: appointmentsCancelTexts.cancelError || '',
                    position: 'bottom-right',
                    textAlign: 'center',
                    loader: false,
                    hideAfter: 4000,
                    icon: 'error'
                });
                hideCharge();
            }
        });
    });
}
Appointments.setToCancel = setToCancel;
