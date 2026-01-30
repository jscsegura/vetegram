const Appointments = window.Appointments = window.Appointments || {};
const appointmentsAddConfig = window.APPOINTMENTS_ADD_CONFIG || {};
const appointmentsAddTexts = appointmentsAddConfig.texts || {};
const appointmentsAddRoutes = appointmentsAddConfig.routes || {};
const appointmentsAddData = appointmentsAddConfig.data || {};
const appointmentsAddSelectors = appointmentsAddConfig.selectors || {};
const helpers = window.vetegramHelpers || {};

const appointmentsAdd = {
    recipeModal: appointmentsAddSelectors.recipeModal || '#recipeModal',
    createNewUser: appointmentsAddSelectors.createNewUser || '#createNewUser',
    createUserModal: appointmentsAddSelectors.createUserModal || '#createUserModal',
    createNewPet: appointmentsAddSelectors.createNewPet || '#createNewPet',
    dateInput: appointmentsAddSelectors.dateInput || '#date',
    userSelect: appointmentsAddSelectors.userSelect || '#user',
    hourSelect: appointmentsAddSelectors.hourSelect || '#hour',
    urlToAvailable: appointmentsAddSelectors.urlToAvailable || '#urlToAvailable',
    groomingContainer: appointmentsAddSelectors.groomingContainer || '#contGrooming'
};

function initAppointmentAddSelects() {
    if (!helpers.initSelect2 || typeof $ === 'undefined') {
        return;
    }
    helpers.initSelect2('.select2');
    helpers.initSelect2('.select3', { dropdownParent: $(appointmentsAdd.recipeModal) });
    helpers.initSelect2('.select4', { dropdownParent: $(appointmentsAdd.createNewUser) });
    helpers.initSelect2('.select5', { dropdownParent: $(appointmentsAdd.createUserModal) });
    helpers.initSelect2('.select6', { dropdownParent: $(appointmentsAdd.createNewPet) });
}

function initAppointmentAddDatepickers() {
    if (typeof dateDropper === 'undefined') {
        return;
    }
    new dateDropper({
        selector: '.dDropperHour',
        format: 'd/m/y',
        expandable: true,
        showArrowsOnHover: true,
        onDropdownExit: getHours
    });

    new dateDropper({
        selector: '.dDropper',
        format: 'd/m/y',
        expandable: true,
        showArrowsOnHover: true
    });
}

document.addEventListener('DOMContentLoaded', function() {
    initAppointmentAddSelects();
    initAppointmentAddDatepickers();
});

function setUrlDate() {
    var date = $(appointmentsAdd.dateInput).val();
    if (!appointmentsAddRoutes.settingsEdit) {
        return;
    }
    if (date != '') {
        $(appointmentsAdd.urlToAvailable).attr('href', `${appointmentsAddRoutes.settingsEdit}/${btoa(date)}`);
    } else {
        $(appointmentsAdd.urlToAvailable).attr('href', appointmentsAddRoutes.settingsEdit);
    }
}
Appointments.setUrlDate = setUrlDate;

function getHours(callGroomer = '') {
    var userid = $(appointmentsAdd.userSelect).val();
    var date = $(appointmentsAdd.dateInput).val();

    if ((userid != '') && (date != '')) {
        if (!appointmentsAddRoutes.getHours) {
            return;
        }

        if (!helpers.ajaxPost) {
            return;
        }
        helpers.ajaxPost(appointmentsAddRoutes.getHours, { userid: userid, date: date }).done(function(data) {
            var existHours = 0;
            var htmlData = '';
            var html = `<option value="">${appointmentsAddTexts.selected || ''}</option>`;

            $.each(data.rows || [], function(i, item) {
                html = html + '<option value="' + item.id + '">' + item.hour + '</option>';
                htmlData = htmlData + '<div class="col-6 col-sm-4 col-lg-3 p-2">' +
                    '<a href="javascript:void(0);" data-id="' + item.id + '" onclick="selectedDay(this);" class="selectDays d-block thisAvailableDiv">' + convertirHora(item.hour) + '</a>' +
                    '</div>';
                existHours = 1;
            });

            if (existHours == 0) {
                html = `<option value="">${appointmentsAddTexts.selectedNotAvailable || ''}</option>`;
                htmlData = appointmentsAddTexts.selectedNotAvailable || '';
            }

            $(appointmentsAdd.hourSelect).html(html);
            $('.printerHoursAvailable').html(htmlData);
        });
    } else {
        var html = `<option value="">${appointmentsAddTexts.selected || ''}</option>`;
        $(appointmentsAdd.hourSelect).html(html);
    }

    setUrlDate();

    if (callGroomer == 'groomer') {
        var rolid = $(appointmentsAdd.userSelect).find('option:selected').attr('data-rol');
        if (rolid == 6) {
            $(appointmentsAdd.groomingContainer).show();
            if (typeof selectedPet === 'function') {
                selectedPet();
            }
        } else {
            $(appointmentsAdd.groomingContainer).hide();
        }
    }
}
Appointments.getHours = getHours;

function selectedDay(obj) {
    var id = $(obj).attr('data-id');

    $('.thisAvailableDiv').removeClass('active');
    $(obj).addClass('active');

    $(appointmentsAdd.hourSelect).val(id);
}
Appointments.selectedDay = selectedDay;

function reserverHour(obj) {
    var id = $(obj).val();
    if (id != '') {
        if (!appointmentsAddRoutes.reserveHour) {
            return;
        }
        if (!helpers.ajaxPost) {
            return;
        }
        helpers.ajaxPost(appointmentsAddRoutes.reserveHour, { id: id }).done(function(data) {
            if (data.reserve != '1') {
                window.vetegramHelpers.toast({
                    text: appointmentsAddTexts.hourNotAvailable || '',
                    position: 'bottom-right',
                    textAlign: 'center',
                    loader: false,
                    hideAfter: 4000,
                    icon: 'warning'
                });
                getHours();
            }
        });
    }
}
Appointments.reserverHour = reserverHour;

function setNotified() {
    if ($('#addReminder').prop('checked')) {
        $('#containerNotified').show();
    } else {
        $('#containerNotified').hide();
    }
}
Appointments.setNotified = setNotified;

function validate() {
    var valid = true;

    var extValid = ['.jpg', '.JPG', '.jpeg', '.JPEG', '.png', '.PNG', '.gif', '.GIF', '.pdf', '.PDF', '.mp3', '.mp4', '.avi', '.zip', '.rar', '.doc', '.docx', '.ppt', '.pptx', '.pptm', '.pps', '.ppsm', '.ppsx', '.xls', '.xlsx'];

    $('.requerido').each(function(i, elem) {
        var value = $(elem).val();
        var value = value.trim();
        if (value == '') {
            $(elem).addClass('is-invalid');
            valid = false;
        } else {
            $(elem).removeClass('is-invalid');
        }
    });

    if ($('#addReminder').prop('checked')) {
        $('.requeridoReminder').each(function(i, elem) {
            var value = $(elem).val();
            var value = value.trim();
            if (value == '') {
                $(elem).addClass('is-invalid');
                valid = false;
            } else {
                $(elem).removeClass('is-invalid');
            }
        });

        if (valid == true) {
            if ($('#reminder_date').val() == appointmentsAddTexts.todayDate) {
                var horaInput = $('#reminder_time').val();
                var horaActual = new Date().toLocaleTimeString('en-US', { hour12: false, hour: '2-digit', minute: '2-digit' });

                var tiempoEntrada = new Date('2000-01-01T' + horaInput);
                var tiempoActual = new Date('2000-01-01T' + horaActual);

                if (tiempoEntrada < tiempoActual) {
                    $('#reminder_time').addClass('is-invalid');
                    valid = false;
                }
            }
        }
    }

    for (var i = 0; i < $('#fileModalMultiple').get(0).files.length; ++i) {
        var name = $('#fileModalMultiple').get(0).files[i].name;

        var extension = name.substring(name.lastIndexOf('.'));
        var position = jQuery.inArray(extension, extValid);
        if (position == -1) {
            valid = false;

            window.vetegramHelpers.toast({
                text: appointmentsAddTexts.errorExtFile || '',
                position: 'bottom-right',
                textAlign: 'center',
                loader: false,
                hideAfter: 4000,
                icon: 'warning'
            });
        }
    }

    var showAlert = false;
    $('.requeridoModalMedicineAdd').each(function(i, elem) {
        var value = $(elem).val();
        var value = value.trim();
        if (value == '') {
            $(elem).addClass('is-invalid');
            valid = false;
            showAlert = true;
        } else {
            $(elem).removeClass('is-invalid');
        }
    });

    if (showAlert == true) {
        window.vetegramHelpers.toast({
            text: appointmentsAddTexts.errorRecipeFields || '',
            position: 'bottom-right',
            textAlign: 'center',
            loader: false,
            hideAfter: 4000,
            icon: 'warning'
        });
    }

    var rolid = $(appointmentsAdd.userSelect).find('option:selected').attr('data-rol');
    if (rolid == 6) {
        if ($('#imageSelected').val() == '') {
            window.vetegramHelpers.toast({
                text: appointmentsAddTexts.imageNotChoose || '',
                position: 'bottom-right',
                textAlign: 'center',
                loader: false,
                hideAfter: 4000,
                icon: 'error'
            });
            valid = false;
        }
        if ($('#imageSelected').val() == '0') {
            if ($('#grooming_personalize').val() == '') {
                window.vetegramHelpers.toast({
                    text: appointmentsAddTexts.imageNotChoosePersonalize || '',
                    position: 'bottom-right',
                    textAlign: 'center',
                    loader: false,
                    hideAfter: 4000,
                    icon: 'error'
                });
                valid = false;
            }
        }
    }

    if (valid == true) {
        setCharge();
        setLoad('btnSave', appointmentsAddTexts.saveProcessing || '');
    }

    return valid;
}
Appointments.validate = validate;

var medicines;
var typesRecipe;
function loadRecipeData() {
    var types = appointmentsAddData.types || [];
    var medical = appointmentsAddData.medicines || [];

    typesRecipe = `<option value="">${appointmentsAddTexts.selected || ''}</option>`;
    $.each(types, function(i, item) {
        typesRecipe = typesRecipe + '<option value="' + item.id + '">' + item.title + '</option>';
    });

    medicines = '<option value=""></option>';
    $.each(medical, function(i, item) {
        medicines = medicines + '<option value="' + item.id + '" data-instruction="' + item.instructions + '">' + item.title + '</option>';
    });
}
loadRecipeData();

function convertirHora(hora24) {
    var partes = hora24.split(':');
    var horas = parseInt(partes[0], 10);
    var minutos = partes[1];
    var periodo = horas >= 12 ? 'pm' : 'am';
    horas = horas % 12;
    horas = horas ? horas : 12;
    return (horas < 10 ? '0' + horas : horas) + ':' + minutos + ' ' + periodo;
}
Appointments.convertirHora = convertirHora;

getHours('groomer');
