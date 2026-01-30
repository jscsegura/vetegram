const Appointments = window.Appointments = window.Appointments || {};
const appointmentsStartConfig = window.APPOINTMENTS_START_CONFIG || {};
const appointmentsStartTexts = appointmentsStartConfig.texts || {};
const appointmentsStartRoutes = appointmentsStartConfig.routes || {};
const appointmentsStartSelectors = appointmentsStartConfig.selectors || {};
const helpers = window.vetegramHelpers || {};

const appointmentsStart = {
    appointmentId: appointmentsStartConfig.appointmentId || null,
    recipeModal: appointmentsStartSelectors.recipeModal || '#recipeModal',
    addVaccineModal: appointmentsStartSelectors.addVaccineModal || '#addVaccine',
    addDesparationModal: appointmentsStartSelectors.addDesparationModal || '#addDesparation'
};

var reloadToComplete = true;

function initAppointmentsStartSelects() {
    if (!helpers.initSelect2 || typeof $ === 'undefined') {
        return;
    }
    helpers.initSelect2('.select2');
    helpers.initSelect2('.select3', { dropdownParent: $(appointmentsStart.recipeModal) });
    helpers.initSelect2('.select5', { dropdownParent: $(appointmentsStart.addVaccineModal) });
    helpers.initSelect2('.select6', { dropdownParent: $(appointmentsStart.addDesparationModal) });
}

function initAppointmentsStartDatepicker() {
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
    initAppointmentsStartSelects();
    initAppointmentsStartDatepicker();
});

function updateRecipe() {
    var id = appointmentsStart.appointmentId;
    var reason = $('#reason').val();
    var diagnosis = $('#diagnosis').val();
    var symptoms = $('#symptoms').val();
    var physical = $('#physicalExamData').val();
    var history = $('#history').val();
    var treatment = $('#treatment').val();

    var differential = $('#differential').val();
    var differentialOther = $('#differentialOtherInput').val();
    var definitive = $('#definitive').val();
    var definitiveOther = $('#definitiveOtherInput').val();

    if (!appointmentsStartRoutes.update) {
        return;
    }

    if (!helpers.ajaxPost) {
        return;
    }
    helpers.ajaxPost(appointmentsStartRoutes.update, {
        id: id,
        reason: reason,
        diagnosis: diagnosis,
        symptoms: symptoms,
        physical: physical,
        history: history,
        treatment: treatment,
        differential: differential,
        differentialOther: differentialOther,
        definitive: definitive,
        definitiveOther: definitiveOther
    }).done(function(data) {
        if (data && data.save == 1) {
            window.vetegramHelpers.toast({
                text: appointmentsStartTexts.updateSuccess || '',
                position: 'bottom-right',
                textAlign: 'center',
                loader: false,
                hideAfter: 4000,
                icon: 'success'
            });
            $('#btn-not-save').hide();
        } else {
            window.vetegramHelpers.toast({
                text: appointmentsStartTexts.updateError || '',
                position: 'bottom-right',
                textAlign: 'center',
                loader: false,
                hideAfter: 4000,
                icon: 'error'
            });
            $('#btn-not-save').show();
        }

        hideCharge();
    }).fail(function() {
        window.vetegramHelpers.toast({
            text: appointmentsStartTexts.updateError || '',
            position: 'bottom-right',
            textAlign: 'center',
            loader: false,
            hideAfter: 4000,
            icon: 'error'
        });
        $('#btn-not-save').show();
    });
}
Appointments.updateRecipe = updateRecipe;

function removeFile(obj) {
    var id = $(obj).attr('data-id');

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-primary btn-sm text-uppercase px-4 marginleft20',
            cancelButton: 'btn btn-danger btn-sm text-uppercase px-4'
        },
        buttonsStyling: false
    });

    swalWithBootstrapButtons.fire({
        title: appointmentsStartTexts.deleteAttachTitle || '',
        text: appointmentsStartTexts.deleteAttachConfirm || '',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: appointmentsStartTexts.deleteYes || '',
        cancelButtonText: appointmentsStartTexts.cancelNo || '',
        reverseButtons: true
    }).then((result) => {
        if (!result.isConfirmed) {
            return;
        }
        if (!appointmentsStartRoutes.deleteAttach) {
            return;
        }

        setCharge();
        if (!helpers.ajaxPost) {
            hideCharge();
            return;
        }
        helpers.ajaxPost(appointmentsStartRoutes.deleteAttach, { id: id }).done(function(data) {
            if (data && data.process == '1') {
                $(obj).parent('div').parent('div').remove();
            } else if (data && data.process == '500') {
                window.vetegramHelpers.toast({
                    text: appointmentsStartTexts.deleteAttachPermError || '',
                    position: 'bottom-right',
                    textAlign: 'center',
                    loader: false,
                    hideAfter: 4000,
                    icon: 'error'
                });
            } else {
                window.vetegramHelpers.toast({
                    text: appointmentsStartTexts.deleteAttachError || '',
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
}
Appointments.removeFile = removeFile;

function removeRecipe(obj) {
    var id = $(obj).attr('data-id');

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-primary btn-sm text-uppercase px-4 marginleft20',
            cancelButton: 'btn btn-danger btn-sm text-uppercase px-4'
        },
        buttonsStyling: false
    });

    swalWithBootstrapButtons.fire({
        title: appointmentsStartTexts.deleteRecipeTitle || '',
        text: appointmentsStartTexts.deleteRecipeConfirm || '',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: appointmentsStartTexts.deleteYes || '',
        cancelButtonText: appointmentsStartTexts.cancelNo || '',
        reverseButtons: true
    }).then((result) => {
        if (!result.isConfirmed) {
            return;
        }
        if (!appointmentsStartRoutes.deleteRecipe) {
            return;
        }

        setCharge();
        if (!helpers.ajaxPost) {
            hideCharge();
            return;
        }
        helpers.ajaxPost(appointmentsStartRoutes.deleteRecipe, { id: id }).done(function(data) {
            if (data && data.process == '1') {
                $(obj).parent('div').parent('div').remove();
            } else if (data && data.process == '500') {
                window.vetegramHelpers.toast({
                    text: appointmentsStartTexts.deleteRecipePermError || '',
                    position: 'bottom-right',
                    textAlign: 'center',
                    loader: false,
                    hideAfter: 4000,
                    icon: 'error'
                });
            } else {
                window.vetegramHelpers.toast({
                    text: appointmentsStartTexts.deleteRecipeError || '',
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
}
Appointments.removeRecipe = removeRecipe;

function finishRecipe(id, option) {
    var validate = true;

    $('.requiredThisForm').each(function(i, elem) {
        var value = $(elem).val();
        var value = value.trim();
        if (value == '') {
            $(elem).addClass('is-invalid');
            validate = false;
        } else {
            $(elem).removeClass('is-invalid');
        }
    });

    if (!validate) {
        window.vetegramHelpers.toast({
            text: appointmentsStartTexts.fieldsRequired || '',
            position: 'bottom-right',
            textAlign: 'center',
            loader: false,
            hideAfter: 4000,
            icon: 'error'
        });
        return false;
    }

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-primary btn-sm text-uppercase px-4 marginleft20',
            cancelButton: 'btn btn-danger btn-sm text-uppercase px-4'
        },
        buttonsStyling: false
    });

    var text = appointmentsStartTexts.finishConfirm || '';
    if (option == 1) {
        text = appointmentsStartTexts.finishConfirmInvoice || '';
    }

    swalWithBootstrapButtons.fire({
        title: appointmentsStartTexts.finishTitle || '',
        text: text,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: appointmentsStartTexts.finishYes || '',
        cancelButtonText: appointmentsStartTexts.cancelNo || '',
        reverseButtons: true
    }).then((result) => {
        if (!result.isConfirmed) {
            return;
        }
        if (!appointmentsStartRoutes.finish) {
            return;
        }

        setCharge();
        if (!helpers.ajaxPost) {
            hideCharge();
            return;
        }
        helpers.ajaxPost(appointmentsStartRoutes.finish, { id: id }).done(function(data) {
            if (data && data.process == '1') {
                if (option == 1) {
                    if (appointmentsStartRoutes.invoiceCreate) {
                        location.href = `${appointmentsStartRoutes.invoiceCreate}/${data.id}`;
                    }
                } else if (appointmentsStartRoutes.index) {
                    location.href = appointmentsStartRoutes.index;
                }
            } else {
                window.vetegramHelpers.toast({
                    text: appointmentsStartTexts.finishError || '',
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
}
Appointments.finishRecipe = finishRecipe;

function getBreed() {
    var type = $('#animaltype').val();
    if (!appointmentsStartRoutes.getBreed) {
        return;
    }

    const request = helpers.ajaxPost
        ? helpers.ajaxPost(appointmentsStartRoutes.getBreed, { type: type }, { beforeSend: function() {} })
        : $.ajax({
            type: 'POST',
            url: appointmentsStartRoutes.getBreed,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': helpers.getCsrfToken ? helpers.getCsrfToken() : ''
            },
            data: {
                type: type
            },
            beforeSend: function() {}
        });

    request.done(function(data) {
        var html = `<option value="">${appointmentsStartTexts.select || ''}</option>`;
        $.each(data.rows || [], function(i, item) {
            html = html + '<option value="' + item.id + '">' + item.title + '</option>';
        });

        $('#breed').html(html);
    });
}
Appointments.getBreed = getBreed;

function sendFormEditValidate() {
    $('#frmEditPet').submit();
}
Appointments.sendFormEditValidate = sendFormEditValidate;

function sendFormEdit() {
    var validate = true;

    $('.requeridoEditPet').each(function(i, elem) {
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
        setCharge2();
        return true;
    }

    return false;
}
Appointments.sendFormEdit = sendFormEdit;

function updateOther(type) {
    const otherLabel = appointmentsStartTexts.otherLabel || 'Otro';
    if (type == 'differential') {
        if ($('#differential').val() == otherLabel) {
            $('#differentialOther').show();
        } else {
            $('#differentialOtherInput').val('');
            $('#differentialOther').hide();
        }
    } else if (type == 'definitive') {
        if ($('#definitive').val() == otherLabel) {
            $('#definitiveOther').show();
        } else {
            $('#definitiveOtherInput').val('');
            $('#definitiveOther').hide();
        }
    }

    updateRecipe();
}
Appointments.updateOther = updateOther;
