const Appointments = window.Appointments = window.Appointments || {};
const appointmentsEditConfig = window.APPOINTMENTS_EDIT_CONFIG || {};
const appointmentsEditTexts = appointmentsEditConfig.texts || {};
const appointmentsEditRoutes = appointmentsEditConfig.routes || {};
const appointmentsEditSelectors = appointmentsEditConfig.selectors || {};
const helpers = window.vetegramHelpers || {};

const appointmentsEdit = {
    appointmentId: appointmentsEditConfig.appointmentId || null,
    recipeModal: appointmentsEditSelectors.recipeModal || '#recipeModal'
};

var reloadToComplete = true;

function initAppointmentsEditSelects() {
    if (!helpers.initSelect2 || typeof $ === 'undefined') {
        return;
    }
    helpers.initSelect2('.select2');
    helpers.initSelect2('.select3', { dropdownParent: $(appointmentsEdit.recipeModal) });
}

function initAppointmentsEditDatepicker() {
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
    initAppointmentsEditSelects();
    initAppointmentsEditDatepicker();
});

function updateRecipe() {
    var id = appointmentsEdit.appointmentId;
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

    if (!appointmentsEditRoutes.update) {
        return;
    }

    if (!helpers.ajaxPost) {
        return;
    }
    helpers.ajaxPost(appointmentsEditRoutes.update, {
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
                text: appointmentsEditTexts.updateSuccess || '',
                position: 'bottom-right',
                textAlign: 'center',
                loader: false,
                hideAfter: 4000,
                icon: 'success'
            });
            $('#btn-not-save').hide();
        } else {
            window.vetegramHelpers.toast({
                text: appointmentsEditTexts.updateError || '',
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
            text: appointmentsEditTexts.updateError || '',
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
        title: appointmentsEditTexts.deleteAttachTitle || '',
        text: appointmentsEditTexts.deleteAttachConfirm || '',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: appointmentsEditTexts.deleteYes || '',
        cancelButtonText: appointmentsEditTexts.cancelNo || '',
        reverseButtons: true
    }).then((result) => {
        if (!result.isConfirmed) {
            return;
        }
        if (!appointmentsEditRoutes.deleteAttach) {
            return;
        }

        setCharge();
        if (!helpers.ajaxPost) {
            hideCharge();
            return;
        }
        helpers.ajaxPost(appointmentsEditRoutes.deleteAttach, { id: id }).done(function(data) {
            if (data && data.process == '1') {
                $(obj).parent('div').parent('div').remove();
            } else if (data && data.process == '500') {
                window.vetegramHelpers.toast({
                    text: appointmentsEditTexts.deleteAttachPermError || '',
                    position: 'bottom-right',
                    textAlign: 'center',
                    loader: false,
                    hideAfter: 4000,
                    icon: 'error'
                });
            } else {
                window.vetegramHelpers.toast({
                    text: appointmentsEditTexts.deleteAttachError || '',
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
        title: appointmentsEditTexts.deleteRecipeTitle || '',
        text: appointmentsEditTexts.deleteRecipeConfirm || '',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: appointmentsEditTexts.deleteYes || '',
        cancelButtonText: appointmentsEditTexts.cancelNo || '',
        reverseButtons: true
    }).then((result) => {
        if (!result.isConfirmed) {
            return;
        }
        if (!appointmentsEditRoutes.deleteRecipe) {
            return;
        }

        setCharge();
        if (!helpers.ajaxPost) {
            hideCharge();
            return;
        }
        helpers.ajaxPost(appointmentsEditRoutes.deleteRecipe, { id: id }).done(function(data) {
            if (data && data.process == '1') {
                $(obj).parent('div').parent('div').remove();
            } else if (data && data.process == '500') {
                window.vetegramHelpers.toast({
                    text: appointmentsEditTexts.deleteRecipePermError || '',
                    position: 'bottom-right',
                    textAlign: 'center',
                    loader: false,
                    hideAfter: 4000,
                    icon: 'error'
                });
            } else {
                window.vetegramHelpers.toast({
                    text: appointmentsEditTexts.deleteRecipeError || '',
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
        title: appointmentsEditTexts.cancelTitle || '',
        text: appointmentsEditTexts.cancelConfirm || '',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: appointmentsEditTexts.cancelYes || '',
        cancelButtonText: appointmentsEditTexts.cancelNoAlt || 'No',
        reverseButtons: true
    }).then((result) => {
        if (!result.isConfirmed) {
            return;
        }
        if (!appointmentsEditRoutes.cancelOrReschedule) {
            return;
        }

        setCharge();
        if (!helpers.ajaxPost) {
            hideCharge();
            return;
        }
        helpers.ajaxPost(appointmentsEditRoutes.cancelOrReschedule, {
            id: id,
            user_id: user_id,
            date: '',
            time: '',
            option: option
        }).done(function(data) {
            if (data && data.process == '1') {
                if (appointmentsEditRoutes.index) {
                    location.href = appointmentsEditRoutes.index;
                }
            } else if (data && data.process == '500') {
                window.vetegramHelpers.toast({
                    text: appointmentsEditTexts.cancelError || '',
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
Appointments.setToCancel = setToCancel;

function updateOther(type) {
    const otherLabel = appointmentsEditTexts.otherLabel || 'Otro';
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
