const Appointments = window.Appointments = window.Appointments || {};
(function() {
    var cfg = window.APPOINT_MODAL_CONFIG && window.APPOINT_MODAL_CONFIG.recipeEdit;
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

    function setIdAppointmentToRecipeEdit(id) {
        var idField = getEl(ids.idField, 'medicineIdAppointmentEdit');
        if (idField) idField.value = id || 0;

        setCharge();
        var container = getEl(ids.rowsContainer, 'printerRowsMedicinesEdit');
        if (container) container.innerHTML = '';

        var request = helpers.ajaxPost
            ? helpers.ajaxPost(routes.getRecipeData, { id: id, get: true })
            : $.post(routes.getRecipeData, { id: id, get: true });

        request.done(function(data) {
            medicines = '<option value="" selected></option><option value="0" data-instruction="">' + (labels.other || '') + '</option>';
            $.each(data.medicines || [], function(i, item) {
                medicines += '<option value="' + item.id + '" data-instruction="' + item.instructions + '">' + item.title + '</option>';
            });

            typesRecipe = '<option value="">' + (labels.selected || '') + '</option>';
            $.each(data.types || [], function(i, item) {
                typesRecipe += '<option value="' + item.id + '">' + item.title + '</option>';
            });

            Appointments.medicines = medicines;
            Appointments.typesRecipe = typesRecipe;

            $.each((data.recipe && data.recipe.detail) || [], function(i, item) {
                setRowMedicineEdit(item.id, item.id_medicine, item.duration, item.id_take, item.quantity, item.instruction, item.title);
            });

            hideCharge();
        });
    }
    Appointments.setIdAppointmentToRecipeEdit = setIdAppointmentToRecipeEdit;

    function setRowMedicineEdit(id, idMedicine, duration, idTake, quantity, instruction, title) {
        var random = id && id !== 0 ? id : getRandom();

        var txt = '<div class="position-relative hr2 rounded p-3 mb-4 containerRowRecipe">' +
            '<button type="button" class="deleteR" data-appoint-action="recipe-edit-delete"><i class="fa-solid fa-xmark"></i></button>' +
            '<div class="d-flex flex-column flex-xl-row gap-3 mb-3 justify-content-start">' +
            '<i class="fa-solid fa-prescription-bottle fa-fw mt-0 mt-xl-1 text-primary"></i>' +
            '<div class="flex-grow-1">' +
            '<input type="hidden" name="medicineModalApId[]" id="medicineModalApId' + random + '" value="' + id + '">' +
            '<label class="form-label small">' + (labels.name || '') + '</label>' +
            '<select class="form-select fc fsmall select3 requeridoModalMedicineEdit" id="medicineModalAp' + random + '" name="medicineModalAp[]" data-placeholder="Seleccionar" data-appoint-action="recipe-edit-change" data-identifier="' + random + '">' +
            medicines +
            '</select>' +
            '</div>' +
            '<div id="parentDiv' + random + '" style="display:none;">' +
            '<label class="form-label small">' + (labels.otherDrug || '') + '</label>' +
            '<input type="text" class="form-control fc fsmall" maxlength="255" id="otherModalAp' + random + '" name="otherModalAp[]" onfocus="blur();">' +
            '</div>' +
            '<div>' +
            '<label class="form-label small">' + (labels.duration || '') + '</label>' +
            '<input type="text" class="form-control fc fsmall requeridoModalMedicineEdit" id="durationModalAp' + random + '" name="durationModalAp[]" value="' + (duration || '') + '" maxlength="255">' +
            '</div>' +
            '<div>' +
            '<label class="form-label small">' + (labels.take || '') + '</label>' +
            '<select class="form-select fc fsmall requeridoModalMedicineEdit" id="takeModalAp' + random + '" name="takeModalAp[]">' +
            typesRecipe +
            '</select>' +
            '</div>' +
            '<div>' +
            '<label class="form-label small">' + (labels.quantity || '') + '</label>' +
            '<input type="text" class="form-control fc fsmall requeridoModalMedicineEdit" size="7" id="quantityModalAp' + random + '" name="quantityModalAp[]" value="' + (quantity || '') + '" maxlength="255">' +
            '</div>' +
            '</div>' +
            '<div class="d-flex flex-column flex-xl-row gap-3 mb-1 justify-content-start">' +
            '<i class="fa-solid fa-prescription-bottle fa-fw mt-1 text-white d-none d-xl-block"></i>' +
            '<div class="flex-grow-1">' +
            '<label class="form-label small">' + (labels.additional || '') + '</label>' +
            '<textarea class="form-control fc fsmall requeridoModalMedicineEdit" id="indicationsModalAp' + random + '" name="indicationsModalAp[]" rows="1">' + (instruction || '') + '</textarea>' +
            '</div>' +
            '</div>' +
            '</div>';

        var container = getEl(ids.rowsContainer, 'printerRowsMedicinesEdit');
        if (container) {
            container.insertAdjacentHTML('beforeend', txt);
        }

        if ($.isNumeric(idMedicine) && idMedicine == 0) {
            $('#medicineModalAp' + random).val(0).trigger('change');
            $('#otherModalAp' + random).attr('onfocus', '');
            $('#otherModalAp' + random).addClass('requeridoModalMedicineEdit');
            $('#otherModalAp' + random).val(title || '');
        } else if ($.isNumeric(idMedicine) && idMedicine > 0) {
            $('#medicineModalAp' + random).val(idMedicine).trigger('change');
            $('#otherModalAp' + random).val('');
            $('#otherModalAp' + random).attr('onfocus', 'blur();');
            $('#otherModalAp' + random).removeClass('requeridoModalMedicineEdit');
        }

        if (idTake && idTake !== 0) {
            $('#takeModalAp' + random).val(idTake).change();
        }

        if (helpers.initSelect2) {
            helpers.initSelect2('#medicineModalAp' + random, { dropdownParent: $('#recipeModalEdit') });
        }
    }
    Appointments.setRowMedicineEdit = setRowMedicineEdit;

    function setInstructionEdit(select) {
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
                otherInput.classList.add('requeridoModalMedicineEdit');
            }
            if (parentDiv) parentDiv.style.display = 'block';
        } else {
            if (otherInput) {
                otherInput.value = '';
                otherInput.setAttribute('onfocus', 'blur();');
                otherInput.classList.remove('requeridoModalMedicineEdit');
                otherInput.classList.remove('is-invalid');
            }
            if (parentDiv) parentDiv.style.display = 'none';
        }

        if (indication) indication.value = myTag || '';
    }
    Appointments.setInstructionEdit = setInstructionEdit;

    function deleteRowMedicineEdit(button) {
        var wrapper = button.closest('.containerRowRecipe');
        if (wrapper) wrapper.remove();
    }
    Appointments.deleteRowMedicineEdit = deleteRowMedicineEdit;

    function saveRecipeEdit() {
        var valid = true;
        document.querySelectorAll('.requeridoModalMedicineEdit').forEach(function(elem) {
            var value = (elem.value || '').trim();
            if (value === '') {
                elem.classList.add('is-invalid');
                valid = false;
            } else {
                elem.classList.remove('is-invalid');
            }
        });

        var count = document.getElementsByClassName('containerRowRecipe').length;
        if (count === 0) {
            window.vetegramHelpers.toast({
                text: labels.addMedicineRequired || '',
                position: 'bottom-right',
                textAlign: 'center',
                loader: false,
                hideAfter: 4000,
                icon: 'warning'
            });
            valid = false;
        }

        if (!valid) return;

        setCharge();
        ajaxPost(routes.updateRecipe, new FormData(getEl(ids.form, 'frmMedicineModalEdit')), {
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data.save == 1) {
                    location.reload();
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
    Appointments.saveRecipeEdit = saveRecipeEdit;

    function getRandom() {
        var random = Math.random() + '';
        random = random.replace('.', '').replaceAll(/0/g, '1');
        return random;
    }
    Appointments.getRandomEdit = getRandom;

    document.addEventListener('click', function(e) {
        var addRow = e.target.closest('[data-appoint-action="recipe-edit-add"]');
        if (addRow) {
            setRowMedicineEdit();
        }

        var deleteRow = e.target.closest('[data-appoint-action="recipe-edit-delete"]');
        if (deleteRow) {
            deleteRowMedicineEdit(deleteRow);
        }

        var save = e.target.closest('[data-appoint-action="recipe-edit-save"]');
        if (save) {
            saveRecipeEdit();
        }
    });

    document.addEventListener('change', function(e) {
        if (e.target && e.target.matches('[data-appoint-action="recipe-edit-change"]')) {
            setInstructionEdit(e.target);
        }
    });
})();
