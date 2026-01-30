const helpers = window.vetegramHelpers || {};

function initPetVaccinesDatepicker() {
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

function initPetVaccinesSelects() {
    if (window.vetegramPetCommon && window.vetegramPetCommon.initPetEditSelect) {
        window.vetegramPetCommon.initPetEditSelect();
    }
    if (!helpers.initSelect2 || typeof $ === 'undefined') {
        return;
    }
    helpers.initSelect2('.select5', {
        dropdownParent: $('#addVaccine')
    });
    helpers.initSelect2('.select6', {
        dropdownParent: $('#addDesparation')
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.getElementById('wrapPtabs');
    if (tabs) {
        tabs.scrollLeft = tabs.scrollWidth - tabs.clientWidth;
    }
    initPetVaccinesDatepicker();
    initPetVaccinesSelects();
});
