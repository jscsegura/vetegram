const Appointments = window.Appointments = window.Appointments || {};
(function() {
    var cfg = window.APPOINT_MODAL_CONFIG && window.APPOINT_MODAL_CONFIG.recipeAdd;
    if (!cfg) return;

    var helpers = window.vetegramHelpers || {};
    var ids = cfg.ids || {};
    var labels = cfg.labels || {};

    function getEl(id, fallbackId) {
        return document.getElementById(id || fallbackId);
    }

    function setRowMedicineAdd() {
        var emptyRow = getEl(ids.emptyRow, 'medicineNotRow');
        if (emptyRow) emptyRow.style.display = 'none';

        var random = getRandom();
        var medicines = window.medicines || '';
        var typesRecipe = window.typesRecipe || '';

        var txt = '<div class="position-relative hr2 rounded p-3 mb-4 rowAddmedic">' +
            '<a data-appoint-action="recipe-add-delete" class="deleteR"><i class="fa-solid fa-xmark"></i></a>' +
            '<div class="d-flex flex-column flex-xl-row gap-3 mb-3 justify-content-start">' +
            '<i class="fa-solid fa-prescription-bottle fa-fw mt-0 mt-xl-1 text-primary"></i>' +
            '<div class="flex-grow-1">' +
            '<label class="form-label small">' + (labels.name || '') + '</label>' +
            '<select class="form-select fc fsmall select3 requeridoModalMedicineAdd" id="medicineModalAp' + random + '" name="medicineModalAp[]" data-placeholder="Seleccionar" data-appoint-action="recipe-add-change" data-identifier="' + random + '">' +
            medicines +
            '</select>' +
            '</div>' +
            '<div>' +
            '<label class="form-label small">' + (labels.otherDrug || 'Otro medicamento') + '</label>' +
            '<input type="text" class="form-control fc fsmall" maxlength="255">' +
            '</div>' +
            '<div>' +
            '<label class="form-label small">' + (labels.duration || '') + '</label>' +
            '<input type="text" class="form-control fc fsmall requeridoModalMedicineAdd" id="durationModalAp' + random + '" name="durationModalAp[]" maxlength="255">' +
            '</div>' +
            '<div>' +
            '<label class="form-label small">' + (labels.take || '') + '</label>' +
            '<select class="form-select fc fsmall requeridoModalMedicineAdd" id="takeModalAp' + random + '" name="takeModalAp[]">' +
            typesRecipe +
            '</select>' +
            '</div>' +
            '<div>' +
            '<label class="form-label small">' + (labels.quantity || '') + '</label>' +
            '<input type="text" class="form-control fc fsmall requeridoModalMedicineAdd" size="7" id="quantityModalAp' + random + '" name="quantityModalAp[]" maxlength="255">' +
            '</div>' +
            '</div>' +
            '<div class="d-flex flex-column flex-xl-row gap-3 mb-1 justify-content-start">' +
            '<i class="fa-solid fa-prescription-bottle fa-fw mt-1 text-white d-none d-xl-block"></i>' +
            '<div class="flex-grow-1">' +
            '<label class="form-label small">' + (labels.additional || '') + '</label>' +
            '<textarea class="form-control fc fsmall requeridoModalMedicineAdd" id="indicationsModalAp' + random + '" name="indicationsModalAp[]" rows="1"></textarea>' +
            '</div>' +
            '</div>' +
            '</div>';

        var container = getEl(ids.rowsContainer, 'printerRowsMedicinesAdd');
        if (container) {
            container.insertAdjacentHTML('beforeend', txt);
        }

        if (helpers.initSelect2) {
            helpers.initSelect2('#medicineModalAp' + random);
        }
    }
    Appointments.setRowMedicineAdd = setRowMedicineAdd;

    function setInstructionAdd(select) {
        var identifier = select.getAttribute('data-identifier');
        if (!identifier) return;
        var option = select.options[select.selectedIndex];
        var myTag = option ? option.getAttribute('data-instruction') : '';
        var indication = getEl('indicationsModalAp' + identifier);
        if (indication) indication.value = myTag || '';
    }
    Appointments.setInstructionAdd = setInstructionAdd;

    function deleteRowMedicineAdd(button) {
        var wrapper = button.closest('.rowAddmedic');
        if (wrapper) wrapper.remove();
        var count = document.getElementsByClassName('rowAddmedic').length;
        if (count === 0) {
            var emptyRow = getEl(ids.emptyRow, 'medicineNotRow');
            if (emptyRow) emptyRow.style.display = '';
        }
    }
    Appointments.deleteRowMedicineAdd = deleteRowMedicineAdd;

    function saveRecipeAdd() {
        var valid = true;
        document.querySelectorAll('.requeridoModalMedicineAdd').forEach(function(elem) {
            var value = (elem.value || '').trim();
            if (value === '') {
                elem.classList.add('is-invalid');
                valid = false;
            } else {
                elem.classList.remove('is-invalid');
            }
        });

        if (valid) {
            $('#recipeModalToAdd').modal('hide');
        }
    }
    Appointments.saveRecipeAdd = saveRecipeAdd;

    function getRandom() {
        var random = Math.random() + '';
        random = random.replace('.', '').replaceAll(/0/g, '1');
        return random;
    }
    Appointments.getRandomAdd = getRandom;

    document.addEventListener('click', function(e) {
        var addRow = e.target.closest('[data-appoint-action="recipe-add-row"]');
        if (addRow) {
            setRowMedicineAdd();
        }

        var deleteRow = e.target.closest('[data-appoint-action="recipe-add-delete"]');
        if (deleteRow) {
            deleteRowMedicineAdd(deleteRow);
        }

        var save = e.target.closest('[data-appoint-action="recipe-add-save"]');
        if (save) {
            saveRecipeAdd();
        }
    });

    document.addEventListener('change', function(e) {
        if (e.target && e.target.matches('[data-appoint-action="recipe-add-change"]')) {
            setInstructionAdd(e.target);
        }
    });
})();
