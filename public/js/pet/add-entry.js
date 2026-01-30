const Pet = window.Pet = window.Pet || {};
const helpers = window.vetegramHelpers || {};
const ajaxPost = helpers.ajaxPost || function(url, data, options) {
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

function initPetAddEntryDatepicker() {
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

document.addEventListener('DOMContentLoaded', function() {
    initPetAddEntryDatepicker();
});

function saveToCreateVaccine() {
    const config = window.PET_ADD_ENTRY_CONFIG || {};
    const routes = config.routes || {};
    const texts = config.texts || {};
    var validate = true;

    $('.requeridoAddVaccine').each(function(i, elem) {
        var value = $(elem).val();
        var value = value.trim();
        if (value == '') {
            $(elem).addClass('is-invalid');
            validate = false;
        } else {
            $(elem).removeClass('is-invalid');
        }
    });

    if (validate == true) {
        setCharge();

        ajaxPost(routes.createVaccine, new FormData(document.getElementById('frmVaccineModaladd')), {
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                hideCharge();
                if (data && data.type == 200) {
                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-primary btn-sm text-uppercase px-4 marginleft20',
                            cancelButton: 'btn btn-danger btn-sm text-uppercase px-4'
                        },
                        buttonsStyling: false
                    });

                    swalWithBootstrapButtons.fire({
                        title: texts.saveTitle || '',
                        text: texts.saveSuccess || '',
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonText: 'Ok'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    window.vetegramHelpers.toast({
                        text: texts.saveError || '',
                        position: 'bottom-right',
                        textAlign: 'center',
                        loader: false,
                        hideAfter: 4000,
                        icon: 'warning'
                    });
                }
            },
            error: function() {
                window.vetegramHelpers.toast({
                    text: texts.createError || '',
                    position: 'bottom-right',
                    textAlign: 'center',
                    loader: false,
                    hideAfter: 4000,
                    icon: 'error'
                });

                hideCharge();
            }
        });
    }
}
Pet.saveToCreateVaccine = saveToCreateVaccine;
