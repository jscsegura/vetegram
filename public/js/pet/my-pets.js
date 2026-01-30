const Pet = window.Pet = window.Pet || {};
const helpers = window.vetegramHelpers || {};

function initMyPetsSelects() {
    if (!helpers.initSelect2 || typeof $ === 'undefined') {
        return;
    }
    helpers.initSelect2('.select4', {
        dropdownParent: $('#petModal')
    });
}

document.addEventListener('DOMContentLoaded', function() {
    initMyPetsSelects();
});

function getBreed() {
    if (window.vetegramPetCommon && window.vetegramPetCommon.getBreed) {
        window.vetegramPetCommon.getBreed();
    }
}
Pet.getBreed = getBreed;

function sendFormCreateValidate() {
    $('#frmCreatePet').submit();
}
Pet.sendFormCreateValidate = sendFormCreateValidate;

function sendFormCreate() {
    var validate = true;

    $('.requerido').each(function(i, elem) {
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
Pet.sendFormCreate = sendFormCreate;
