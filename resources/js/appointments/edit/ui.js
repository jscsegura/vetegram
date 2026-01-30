(function() {
    const module = window.AppointmentsEdit;
    if (!module) {
        return;
    }
    const texts = module.texts || {};

    module.ui = module.ui || {};

    module.ui.setToCancel = function(id, userId) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary btn-sm text-uppercase px-4 marginleft20',
                cancelButton: 'btn btn-danger btn-sm text-uppercase px-4'
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: texts.cancelTitle || '',
            text: texts.cancelConfirm || '',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: texts.cancelYes || '',
            cancelButtonText: texts.cancelNo || '',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $('#frmEditAppointment').append('<input type="hidden" name="cancel" value="1">');
                $('#id').val(id);
                $('#user').val(userId);
                $('#frmEditAppointment').submit();
            }
        });
    };
})();
