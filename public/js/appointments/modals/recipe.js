const Appointments = window.Appointments = window.Appointments || {};
(function() {
    var cfg = window.APPOINT_MODAL_CONFIG && window.APPOINT_MODAL_CONFIG.recipe;
    if (!cfg) return;

    var helpers = window.vetegramHelpers || {};
    var ids = cfg.ids || {};
    var labels = cfg.labels || {};
    var routes = cfg.routes || {};
    var ajaxPost = helpers.ajaxPost || function(url, data, options) {
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

    var medicines = '';
    var typesRecipe = '';

    function getEl(id, fallbackId) {
        return document.getElementById(id || fallbackId);
    }

    function shouldReload() {
        return (window.AppointmentsStart && window.AppointmentsStart.state && window.AppointmentsStart.state.reloadToComplete) ||
            (window.AppointmentsEdit && window.AppointmentsEdit.state && window.AppointmentsEdit.state.reloadToComplete);
    }

    function setIdAppointmentToMedicine(id, pet) {
        var idField = getEl(ids.idField, 'medicineIdAppointment');
        var petField = getEl(ids.petField, 'medicineIdPetAppointment');
        if (idField) idField.value = id || 0;
        if (petField) petField.value = pet || 0;

        setCharge();
        var container = getEl(ids.rowsContainer, 'printerRowsMedicines');
        if (container) container.innerHTML = '';

        var request = helpers.ajaxPost
            ? helpers.ajaxPost(routes.getRecipeData, {})
            : $.post(routes.getRecipeData, {});

        request.done(function(data) {
            medicines = '<option value=""></option><option value="0" data-instruction="">' + (labels.other || '') + '</option>';
            $.each(data.medicines || [], function(i, item) {
                medicines += '<option value="' + item.id + '" data-instruction="' + item.instructions + '">' + item.title + '</option>';
            });

            typesRecipe = '<option value="">' + (labels.selected || '') + '</option>';
            $.each(data.types || [], function(i, item) {
                typesRecipe += '<option value="' + item.id + '">' + item.title + '</option>';
            });

            Appointments.medicines = medicines;
            Appointments.typesRecipe = typesRecipe;

            setRowMedicine(false);
            hideCharge();
        });
    }
    Appointments.setIdAppointmentToMedicine = setIdAppointmentToMedicine;

    function setRowMedicine(showDelete) {
        var random = getRandom();
        var btnDelete = '';
        if (showDelete) {
            btnDelete = '<button type="button" class="deleteR" data-appoint-action="recipe-delete-row"><i class="fa-solid fa-xmark"></i></button>';
        }

        var txt = '<div class="position-relative hr2 rounded p-3 mb-4">' +
            btnDelete +
            '<div class="d-flex flex-column flex-xl-row gap-3 mb-3 justify-content-start">' +
            '<i class="fa-solid fa-prescription-bottle fa-fw mt-0 mt-xl-1 text-primary"></i>' +
            '<div class="flex-grow-1">' +
            '<label class="form-label small">' + (labels.name || '') + '</label>' +
            '<select class="form-select fc fsmall select3 requeridoModalMedicine" id="medicineModalAp' + random + '" name="medicineModalAp[]" data-placeholder="Seleccionar" data-appoint-action="recipe-medicine-change" data-identifier="' + random + '">' +
            medicines +
            '</select>' +
            '</div>' +
            '<div id="parentDiv' + random + '" style="display:none;">' +
            '<label class="form-label small">' + (labels.otherDrug || '') + '</label>' +
            '<input type="text" class="form-control fc fsmall" maxlength="255" id="otherModalAp' + random + '" name="otherModalAp[]" onfocus="blur();">' +
            '</div>' +
            '<div>' +
            '<label class="form-label small">' + (labels.duration || '') + '</label>' +
            '<input type="text" class="form-control fc fsmall requeridoModalMedicine" id="durationModalAp' + random + '" name="durationModalAp[]" maxlength="255">' +
            '</div>' +
            '<div>' +
            '<label class="form-label small">' + (labels.take || '') + '</label>' +
            '<select class="form-select fc fsmall requeridoModalMedicine" id="takeModalAp' + random + '" name="takeModalAp[]">' +
            typesRecipe +
            '</select>' +
            '</div>' +
            '<div>' +
            '<label class="form-label small">' + (labels.quantity || '') + '</label>' +
            '<input type="text" class="form-control fc fsmall requeridoModalMedicine" size="7" id="quantityModalAp' + random + '" name="quantityModalAp[]" maxlength="255">' +
            '</div>' +
            '</div>' +
            '<div class="d-flex flex-column flex-xl-row gap-3 mb-1 justify-content-start">' +
            '<i class="fa-solid fa-prescription-bottle fa-fw mt-1 text-white d-none d-xl-block"></i>' +
            '<div class="flex-grow-1">' +
            '<label class="form-label small">' + (labels.additional || '') + '</label>' +
            '<textarea class="form-control fc fsmall requeridoModalMedicine" id="indicationsModalAp' + random + '" name="indicationsModalAp[]" rows="1"></textarea>' +
            '</div>' +
            '</div>' +
            '</div>';

        var container = getEl(ids.rowsContainer, 'printerRowsMedicines');
        if (container) {
            container.insertAdjacentHTML('beforeend', txt);
        }

        if (helpers.initSelect2) {
            helpers.initSelect2('#medicineModalAp' + random, { dropdownParent: $('#recipeModal') });
        }
    }
    Appointments.setRowMedicine = setRowMedicine;

    function setInstruction(select) {
        var identifier = select.getAttribute('data-identifier');
        if (!identifier) return;
        var option = select.options[select.selectedIndex];
        var myTag = option ? option.getAttribute('data-instruction') : '';
        var value = option ? option.value : '';

        var otherInput = getEl('otherModalAp' + identifier);
        var parentDiv = getEl('parentDiv' + identifier);
        var indication = getEl('indicationsModalAp' + identifier);

        if (value === '0') {
            if (otherInput) {
                otherInput.setAttribute('onfocus', '');
                otherInput.classList.add('requeridoModalMedicine');
            }
            if (parentDiv) parentDiv.style.display = 'block';
        } else {
            if (otherInput) {
                otherInput.value = '';
                otherInput.setAttribute('onfocus', 'blur();');
                otherInput.classList.remove('requeridoModalMedicine');
                otherInput.classList.remove('is-invalid');
            }
            if (parentDiv) parentDiv.style.display = 'none';
        }
        if (indication) indication.value = myTag || '';
    }
    Appointments.setInstruction = setInstruction;

    function deleteRowMedicine(button) {
        var wrapper = button.closest('.position-relative');
        if (wrapper) wrapper.remove();
    }
    Appointments.deleteRowMedicine = deleteRowMedicine;

    function saveRecipe() {
        var valid = true;
        document.querySelectorAll('.requeridoModalMedicine').forEach(function(elem) {
            var value = (elem.value || '').trim();
            if (value === '') {
                elem.classList.add('is-invalid');
                valid = false;
            } else {
                elem.classList.remove('is-invalid');
            }
        });

        if (!valid) return;

        setCharge();
        ajaxPost(routes.saveRecipe, new FormData(getEl(ids.form, 'frmMedicineModal')), {
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data.save == 1) {
                    var container = getEl(ids.rowsContainer, 'printerRowsMedicines');
                    if (container) container.innerHTML = '';
                    setRowMedicine(false);
                    window.vetegramHelpers.toast({
                        text: labels.recipeSuccess || '',
                        position: 'bottom-right',
                        textAlign: 'center',
                        loader: false,
                        hideAfter: 4000,
                        icon: 'success'
                    });
                    if (shouldReload()) {
                        location.reload();
                    }
                } else {
                    window.vetegramHelpers.toast({
                        text: labels.recipeError || '',
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
                    text: labels.recipeError || '',
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
    Appointments.saveRecipe = saveRecipe;

    function getRandom() {
        var random = Math.random() + '';
        random = random.replace('.', '').replaceAll(/0/g, '1');
        return random;
    }
    Appointments.getRandom = getRandom;

    document.addEventListener('click', function(e) {
        var addRow = e.target.closest('[data-appoint-action="recipe-add-row"]');
        if (addRow) {
            setRowMedicine(true);
        }

        var deleteRow = e.target.closest('[data-appoint-action="recipe-delete-row"]');
        if (deleteRow) {
            deleteRowMedicine(deleteRow);
        }

        var save = e.target.closest('[data-appoint-action="recipe-save"]');
        if (save) {
            saveRecipe();
        }
    });

    document.addEventListener('change', function(e) {
        if (e.target && e.target.matches('[data-appoint-action="recipe-medicine-change"]')) {
            setInstruction(e.target);
        }
    });
})();
