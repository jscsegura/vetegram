(function() {
    const module = window.AppointmentsStart;
    if (!module) {
        return;
    }
    const routes = module.routes || {};
    const texts = module.texts || {};
    const helpers = module.helpers || {};

    module.recipe = module.recipe || {};

    module.recipe.updateRecipe = function() {
        const id = module.state.appointmentId;
        const reason = $('#reason').val();
        const diagnosis = $('#diagnosis').val();
        const symptoms = $('#symptoms').val();
        const physical = $('#physicalExamData').val();
        const history = $('#history').val();
        const treatment = $('#treatment').val();
        const differential = $('#differential').val();
        const differentialOther = $('#differentialOtherInput').val();
        const definitive = $('#definitive').val();
        const definitiveOther = $('#definitiveOtherInput').val();

        if (!routes.update || !helpers.ajaxPost) {
            return;
        }

        helpers.ajaxPost(routes.update, {
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
                    text: texts.updateSuccess || '',
                    position: 'bottom-right',
                    textAlign: 'center',
                    loader: false,
                    hideAfter: 4000,
                    icon: 'success'
                });
                $('#btn-not-save').hide();
            } else {
                window.vetegramHelpers.toast({
                    text: texts.updateError || '',
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
                text: texts.updateError || '',
                position: 'bottom-right',
                textAlign: 'center',
                loader: false,
                hideAfter: 4000,
                icon: 'error'
            });
            $('#btn-not-save').show();
        });
    };

    module.recipe.removeRecipe = function(el) {
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
            title: texts.deleteRecipeTitle || '',
            text: texts.deleteRecipeConfirm || '',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: texts.deleteYes || '',
            cancelButtonText: texts.cancelNo || '',
            reverseButtons: true
        }).then((result) => {
            if (!result.isConfirmed || !routes.deleteRecipe) {
                return;
            }

            setCharge();
            if (!helpers.ajaxPost) {
                hideCharge();
                return;
            }
            helpers.ajaxPost(routes.deleteRecipe, { id: id }).done(function(data) {
                if (data && data.process == '1') {
                    $(obj).parent('div').parent('div').remove();
                } else if (data && data.process == '500') {
                    window.vetegramHelpers.toast({
                        text: texts.deleteRecipePermError || '',
                        position: 'bottom-right',
                        textAlign: 'center',
                        loader: false,
                        hideAfter: 4000,
                        icon: 'error'
                    });
                } else {
                    window.vetegramHelpers.toast({
                        text: texts.deleteRecipeError || '',
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

    module.recipe.finishRecipe = function(id, option) {
        if (!routes.finish) {
            return;
        }

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary btn-sm text-uppercase px-4 marginleft20',
                cancelButton: 'btn btn-danger btn-sm text-uppercase px-4'
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: texts.finishTitle || '',
            text: texts.finishConfirm || '',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: texts.finishYes || '',
            cancelButtonText: texts.cancelNo || '',
            reverseButtons: true
        }).then((result) => {
            if (!result.isConfirmed) {
                return;
            }

            setCharge();
            if (!helpers.ajaxPost) {
                hideCharge();
                return;
            }
            helpers.ajaxPost(routes.finish, { id: id, option: option }).done(function(data) {
                if (data && data.save == 1) {
                    if (option == 1 && routes.invoiceCreate) {
                        location.href = `${routes.invoiceCreate}/${data.id}`;
                    } else if (routes.index) {
                        location.href = routes.index;
                    }
                } else {
                    window.vetegramHelpers.toast({
                        text: texts.finishError || '',
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

    module.recipe.updateOther = function(type) {
        const otherLabel = texts.otherLabel || 'Otro';
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

        module.recipe.updateRecipe();
    };
})();
