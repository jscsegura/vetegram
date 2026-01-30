const Inventory = window.Inventory = window.Inventory || {};
const inventoryFormConfig = window.INVENTORY_FORM_CONFIG || {};
const inventoryFormTexts = inventoryFormConfig.texts || {};
const inventoryFormSelectors = inventoryFormConfig.selectors || {};
const helpers = window.vetegramHelpers || {};

const inventoryForm = {
    cabysModal: inventoryFormSelectors.cabysModal || '#cabysModal',
    cabysInput: inventoryFormSelectors.cabysInput || '#cabys',
    cabysModalParent: inventoryFormSelectors.cabysModalParent || '#cabysCode',
    rate: inventoryFormSelectors.rate || '#rate',
    subprice: inventoryFormSelectors.subprice || '#subprice',
    price: inventoryFormSelectors.price || '#price'
};

function initInventorySelects() {
    if (!helpers.initSelect2 || typeof $ === 'undefined') {
        return;
    }
    helpers.initSelect2('.select2');
    helpers.initSelect2('.select3', {
        dropdownParent: $(inventoryForm.cabysModalParent)
    });
}

initInventorySelects();

function validSend() {
    var validate = true;

    $('.requerido').each(function(i, elem){
        var value = $(elem).val();
        var value = value.trim();
        if(value == ''){
            $(elem).addClass('is-invalid');
            validate = false;
        }else{
            $(elem).removeClass('is-invalid');
        }
    });

    if(validate == true) {
        setCharge();
    }

    return validate;
}
Inventory.validSend = validSend;

function calculatePrice(type) {
    var subprice = $(inventoryForm.subprice).val();
    var price = $(inventoryForm.price).val();
    var rate = $(inventoryForm.rate).val();

    if(subprice == '') {
        subprice = 0;
    }

    if(price == '') {
        price = 0;
    }

    var taxes = 0;
    switch (rate) {
        case "01": taxes = 0; break;
        case "02": taxes = 1; break;
        case "03": taxes = 2; break;
        case "04": taxes = 4; break;
        case "05": taxes = 0; break;
        case "06": taxes = 4; break;
        case "07": taxes = 8; break;
        case "08": taxes = 13; break;
        case "09": taxes = 0.5; break;
        default: taxes = 0; break;
    }

    if(type == 1) {
        if((rate != '') && (taxes > 0)) {
            var impuesto = (taxes / 100) * parseFloat(subprice);
            var total = parseFloat(subprice) + parseFloat(impuesto);

            $(inventoryForm.price).val(total.toFixed(2));
        }else{
            $(inventoryForm.price).val(subprice);
        }
    } else if(type == 2) {
        if((rate != '') && (taxes > 0)) {
            var impuesto = (taxes / 100) * parseFloat(subprice);
            var total = parseFloat(subprice) + parseFloat(impuesto);

            $(inventoryForm.price).val(total.toFixed(2));
        }else{
            $(inventoryForm.price).val(subprice);
        }
    } else if(type == 3) {
        if((rate != '') && (taxes > 0)) {
            var montoBase = parseFloat(price) / (1 + (taxes / 100));

            $(inventoryForm.subprice).val(montoBase.toFixed(2));
        }else{
            $(inventoryForm.subprice).val(price);
        }
    }
}
Inventory.calculatePrice = calculatePrice;

function searchCabysMethod(obj) {
    var text = $(obj).val();
    var options = '';
    var notSearch = inventoryFormTexts.cabysNotSearch || '';

    if(text != '') {
        if (!isNaN(parseFloat(text)) && isFinite(text)) {
            $.getJSON("https://api.hacienda.go.cr/fe/cabys?codigo=" + text, function(json) {
                $.each(json, function(key, val) {
                    if (val.codigo) {
                        options += '<option value="'+val.codigo+'">' + val.descripcion + ' (' + val.codigo + ') ' + val.impuesto + '%</option>';
                    } else {
                        options = '<option value="">' + notSearch + '</option>';
                    }

                    $(inventoryForm.cabysModal).html(options);
                });
            });
        } else {
            $.getJSON("https://api.hacienda.go.cr/fe/cabys?q=" + text, function(json) {
                if (json.total > 0) {
                    $.each(json.cabys, function(key, val) {
                        options += '<option value="'+val.codigo+'">' + val.descripcion + ' (' + val.codigo + ') ' + val.impuesto + '%</option>';
                    });
                } else {
                    options = '<option value="">' + notSearch + '</option>';
                }

                $(inventoryForm.cabysModal).html(options);
            });
        }
    }else{
        options = '<option value="">' + notSearch + '</option>';
        $(inventoryForm.cabysModal).html(options);
    }
}
Inventory.searchCabysMethod = searchCabysMethod;

function getCode() {
    var code = $(inventoryForm.cabysModal).val();
    if(code != '') {
        $(inventoryForm.cabysInput).val(code);
        $(inventoryForm.cabysModalParent).modal('toggle');
    }
}
Inventory.getCode = getCode;

document.addEventListener('keydown', function(event) {
    const target = event.target;
    if (!target || !target.classList || !target.classList.contains('inventory-numeric')) {
        return;
    }
    if (helpers.enterOnlyNumbers) {
        helpers.enterOnlyNumbers(event);
    }
});
