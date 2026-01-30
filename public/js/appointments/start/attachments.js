(function() {
    const module = window.AppointmentsStart;
    if (!module) {
        return;
    }
    const routes = module.routes || {};
    const texts = module.texts || {};
    const helpers = module.helpers || {};

    module.attachments = module.attachments || {};

    module.attachments.removeFile = function(el) {
        const obj = el || this;
        const id = $(obj).attr('data-id');
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary btn-sm text-uppercase px-4 marginleft20',
                cancelButton: 'btn btn-danger btn-sm text-uppercase px-4'
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: texts.deleteAttachTitle || '',
            text: texts.deleteAttachConfirm || '',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: texts.deleteYes || '',
            cancelButtonText: texts.cancelNo || '',
            reverseButtons: true
        }).then((result) => {
            if (!result.isConfirmed || !routes.deleteAttach) {
                return;
            }

            setCharge();
            if (!helpers.ajaxPost) {
                hideCharge();
                return;
            }
            helpers.ajaxPost(routes.deleteAttach, { id: id }).done(function(data) {
                if (data && data.process == '1') {
                    $(obj).parent('div').parent('div').remove();
                } else if (data && data.process == '500') {
                    window.vetegramHelpers.toast({
                        text: texts.deleteAttachPermError || '',
                        position: 'bottom-right',
                        textAlign: 'center',
                        loader: false,
                        hideAfter: 4000,
                        icon: 'error'
                    });
                } else {
                    window.vetegramHelpers.toast({
                        text: texts.deleteAttachError || '',
                        position: 'bottom-right',
                        textAlign: 'center',
                        loader: false,
                        hideAfter: 4000,
                        icon: 'error'
                    });
                }

                hideCharge();
            });
        });
    };
})();
