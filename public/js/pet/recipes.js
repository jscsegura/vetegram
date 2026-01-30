var reloadToComplete = true;
const helpers = window.vetegramHelpers || {};

function initPetRecipesSelects() {
    if (helpers.initSelect2 && typeof $ !== 'undefined') {
        helpers.initSelect2('.select2');
        helpers.initSelect2('.select3', {
            dropdownParent: $('#recipeModal')
        });
    }

    if (window.vetegramPetCommon && window.vetegramPetCommon.initPetEditSelect) {
        window.vetegramPetCommon.initPetEditSelect();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    initPetRecipesSelects();
});
