const Pet = window.Pet = window.Pet || {};
var reloadToComplete = true;

document.addEventListener('DOMContentLoaded', function() {
    if (window.vetegramPetCommon && window.vetegramPetCommon.initPetEditSelect) {
        window.vetegramPetCommon.initPetEditSelect();
    }
});

function removeFile(obj) {
    if (window.vetegramPetCommon && window.vetegramPetCommon.removeAttachment) {
        window.vetegramPetCommon.removeAttachment(obj);
    }
}
Pet.removeFile = removeFile;
