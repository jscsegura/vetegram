const Inventory = window.Inventory = window.Inventory || {};
const inventoryPreviewConfig = window.INVENTORY_PREVIEW_CONFIG || {};
const inventoryPreviewTexts = inventoryPreviewConfig.texts || {};
const inventoryPreviewSelectors = inventoryPreviewConfig.selectors || {};
const helpers = window.vetegramHelpers || {};

const inventoryPreview = {
    cabysModal: inventoryPreviewSelectors.cabysModal || '#cabysModal',
    cabysModalParent: inventoryPreviewSelectors.cabysModalParent || '#cabysCode',
    currentInput: inventoryPreviewSelectors.currentInput || '#currentInput'
};

function initInventoryPreviewSelects() {
    if (!helpers.initSelect2 || typeof $ === 'undefined') {
        return;
    }
    helpers.initSelect2('.select3', {
        dropdownParent: $(inventoryPreview.cabysModalParent)
    });
}

initInventoryPreviewSelects();

function changeCurrentInput(input) {
    let cinput = document.querySelector(inventoryPreview.currentInput);
    if (cinput) {
        cinput.value = input;
    }
}
Inventory.changeCurrentInput = changeCurrentInput;

function searchCabysMethod(obj) {
    var text = $(obj).val();
    var options = '';
    var notSearch = inventoryPreviewTexts.cabysNotSearch || '';

    if (text != '') {
        if (!isNaN(parseFloat(text)) && isFinite(text)) {
            $.getJSON("https://api.hacienda.go.cr/fe/cabys?codigo=" + text, function(json) {
                $.each(json, function(key, val) {
                    if (val.codigo) {
                        options += '<option value="' + val.codigo + '">' + val.descripcion + ' (' + val.codigo + ') ' + val.impuesto + '%</option>';
                    } else {
                        options = '<option value="">' + notSearch + '</option>';
                    }

                    $(inventoryPreview.cabysModal).html(options);
                });
            });
        } else {
            $.getJSON("https://api.hacienda.go.cr/fe/cabys?q=" + text, function(json) {
                if (json.total > 0) {
                    $.each(json.cabys, function(key, val) {
                        options += '<option value="' + val.codigo + '">' + val.descripcion + ' (' + val.codigo + ') ' + val.impuesto + '%</option>';
                    });
                } else {
                    options = '<option value="">' + notSearch + '</option>';
                }

                $(inventoryPreview.cabysModal).html(options);
            });
        }
    } else {
        options = '<option value="">' + notSearch + '</option>';
        $(inventoryPreview.cabysModal).html(options);
    }
}
Inventory.searchCabysMethod = searchCabysMethod;

function getCode() {
    const cinput = document.querySelector(inventoryPreview.currentInput);
    var code = $(inventoryPreview.cabysModal).val();
    if (cinput && code != '') {
        let currentInput = document.getElementById(cinput.value);
        if (currentInput) {
            currentInput.value = code;
        }
        $(inventoryPreview.cabysModalParent).modal('toggle');
    }
}
Inventory.getCode = getCode;

function removeMedicine(id) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-primary btn-sm text-uppercase px-4 marginleft20',
            cancelButton: 'btn btn-danger btn-sm text-uppercase px-4'
        },
        buttonsStyling: false
    });

    swalWithBootstrapButtons.fire({
        title: inventoryPreviewTexts.deleteTitle || '',
        text: inventoryPreviewTexts.deleteConfirm || '',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: inventoryPreviewTexts.deleteYes || '',
        cancelButtonText: inventoryPreviewTexts.deleteNo || '',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $('#row' + id).remove();
        }
    });
}
Inventory.removeMedicine = removeMedicine;
