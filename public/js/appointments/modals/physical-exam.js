(function() {
    var cfg = window.APPOINT_MODAL_CONFIG && window.APPOINT_MODAL_CONFIG.physicalExam;
    if (!cfg) return;

    var ids = cfg.ids || {};
    var initial = cfg.initial || [];
    var physicalComplete = cfg.physicalComplete === true;

    function getEl(id, fallbackId) {
        return document.getElementById(id || fallbackId);
    }

    function renderInitial() {
        var container = getEl(ids.printer, 'printerPhysicalOptions');
        if (!container) return;

        container.innerHTML = '';
        var totalAdd = 0;
        var arrayOfArrays = [];

        (initial || []).forEach(function(elem) {
            var row = '';
            if (elem.subopt) {
                if (elem.value) {
                    row = '<div class="cyanBg py-2 px-3 rounded">' + elem.cat + ' <i class="fa-solid fa-arrow-right-long small mx-1"></i>  ' + elem.opt + ' <i class="fa-solid fa-arrow-right-long small mx-1"></i> ' + elem.subopt + ': <strong>' + elem.value + '</strong></div>';
                } else {
                    row = '<div class="cyanBg py-2 px-3 rounded">' + elem.cat + ' <i class="fa-solid fa-arrow-right-long small mx-1"></i>  ' + elem.opt + ': <strong>' + elem.subopt + '</strong></div>';
                }
            } else if (elem.value) {
                row = '<div class="cyanBg py-2 px-3 rounded">' + elem.cat + ' <i class="fa-solid fa-arrow-right-long small mx-1"></i> ' + elem.opt + ': <strong>' + elem.value + '</strong></div>';
            } else {
                row = '<div class="cyanBg py-2 px-3 rounded">' + elem.cat + ' <i class="fa-solid fa-arrow-right-long small mx-1"></i> <strong>' + elem.opt + '</strong></div>';
            }

            if (row) {
                container.insertAdjacentHTML('beforeend', row);
                totalAdd++;
                arrayOfArrays.push({
                    idcat: elem.idcat,
                    cat: elem.cat,
                    idopt: elem.idopt,
                    opt: elem.opt,
                    idsubopt: elem.idsubopt,
                    subopt: elem.subopt,
                    value: elem.value
                });
            }
        });

        if (totalAdd > 0) {
            if (physicalComplete) {
                container.insertAdjacentHTML('beforeend', '<button type="button" class="editR4" data-bs-toggle="modal" data-bs-target="#physicalExam"><i class="fa-solid fa-pencil"></i></button>');
            }
            var btn = getEl(ids.button, 'physicalExamButton');
            if (btn) btn.style.display = 'none';
            container.style.display = '';
        } else {
            if (physicalComplete) {
                var btn2 = getEl(ids.button, 'physicalExamButton');
                if (btn2) btn2.style.display = '';
            }
            container.style.display = 'none';
        }

        var dataField = getEl(ids.dataField, 'physicalExamData');
        if (dataField) {
            dataField.value = JSON.stringify(arrayOfArrays);
        }
    }

    function onModalHidden() {
        var container = getEl(ids.printer, 'printerPhysicalOptions');
        if (!container) return;

        container.innerHTML = '';
        var totalAdd = 0;
        var arrayOfArrays = [];

        document.querySelectorAll('.inputPhysical').forEach(function(elem) {
            var type = elem.getAttribute('type');
            var value = '';
            var row = '';

            var category = elem.getAttribute('data-cat') || '';
            var option = elem.getAttribute('data-opt') || '';
            var suboption = elem.getAttribute('data-subopt') || '';

            var idcategory = elem.getAttribute('id-cat') || '';
            var idoption = elem.getAttribute('id-opt') || '';
            var idsuboption = elem.getAttribute('id-subopt') || '';

            if (type === 'text' || type === 'number') {
                if (elem.value !== '') {
                    value = elem.value;
                    if (suboption) {
                        row = '<div class="cyanBg py-2 px-3 rounded">' + category + ' <i class="fa-solid fa-arrow-right-long small mx-1"></i>  ' + option + ' <i class="fa-solid fa-arrow-right-long small mx-1"></i> ' + suboption + ': <strong>' + value + '</strong></div>';
                    } else {
                        row = '<div class="cyanBg py-2 px-3 rounded">' + category + ' <i class="fa-solid fa-arrow-right-long small mx-1"></i> ' + option + ': <strong>' + value + '</strong></div>';
                    }
                }
            }

            if (type === 'radio' && elem.checked) {
                if (suboption) {
                    row = '<div class="cyanBg py-2 px-3 rounded">' + category + ' <i class="fa-solid fa-arrow-right-long small mx-1"></i>  ' + option + ': <strong>' + suboption + '</strong></div>';
                } else {
                    row = '<div class="cyanBg py-2 px-3 rounded">' + category + ' <i class="fa-solid fa-arrow-right-long small mx-1"></i> <strong>' + option + '</strong></div>';
                }
            }

            if (row) {
                container.insertAdjacentHTML('beforeend', row);
                totalAdd++;
                arrayOfArrays.push({
                    idcat: idcategory,
                    cat: category,
                    idopt: idoption,
                    opt: option,
                    idsubopt: idsuboption,
                    subopt: suboption,
                    value: value
                });
            }
        });

        if (totalAdd > 0) {
            container.insertAdjacentHTML('beforeend', '<button type="button" class="editR4" data-bs-toggle="modal" data-bs-target="#physicalExam"><i class="fa-solid fa-pencil"></i></button>');
            var btn = getEl(ids.button, 'physicalExamButton');
            if (btn) btn.style.display = 'none';
            container.style.display = '';
        } else {
            var btn2 = getEl(ids.button, 'physicalExamButton');
            if (btn2) btn2.style.display = '';
            container.style.display = 'none';
        }

        var dataField = getEl(ids.dataField, 'physicalExamData');
        if (dataField) {
            dataField.value = JSON.stringify(arrayOfArrays);
        }

        if (typeof updateRecipe === 'function') {
            updateRecipe();
        }
    }

    renderInitial();

    $(document).ready(function() {
        $('#physicalExam').on('hidden.bs.modal', function() {
            onModalHidden();
        });
    });
})();
