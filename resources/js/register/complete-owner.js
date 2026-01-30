const Setup = window.Setup = window.Setup || {};
const completeOwnerConfig = window.REGISTER_COMPLETE_OWNER_CONFIG || {};
const completeOwnerRoutes = completeOwnerConfig.routes || {};
const completeOwnerTexts = completeOwnerConfig.texts || {};
const completeOwnerLabels = completeOwnerConfig.labels || {};
const completeOwnerOptionTypes = completeOwnerConfig.optionTypes || '';
const helpers = window.vetegramHelpers || {};
const ajaxPost = helpers.ajaxPost || function(url, data, options) {
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

if (helpers.initSelect2) {
    helpers.initSelect2('.select2');
}

function changeTab(tabId) {
    const tabContent = document.getElementById('formSteps');
    const tabPane = tabContent.querySelector(`#${tabId}`);

    const allTabs = tabContent.querySelectorAll('.tab-pane');
    allTabs.forEach(tab => tab.classList.remove('show', 'active'));

    tabPane.classList.add('show', 'active');
}

function changeCountry(obj) {
    var country = $(obj).val();
    var phonecode = $('#country option:selected').attr("data-phonecode");

    if(country == 53) {
        $('#province').show();
        $('#canton').show();
        $('#district').show();

        $('#province_alternate').hide();
        $('#canton_alternate').hide();
        $('#district_alternate').hide();
    }else{
        $('#province').hide();
        $('#canton').hide();
        $('#district').hide();

        $('#province_alternate').show();
        $('#canton_alternate').show();
        $('#district_alternate').show();
    }

    $('#phone').val('+' + phonecode);
}
changeCountry($('#country'));

function getLocation(type, value) {
    ajaxPost(completeOwnerRoutes.getLocation, {
        type: type,
        value: value
    }, {
        beforeSend: function(){},
        success: function(data){
            var html = '<option value="">' + (completeOwnerTexts.select || 'Seleccionar') + '</option>';
            $.each(data.rows, function(i, item) {
                html = html + '<option value="'+item.id+'">'+item.title+'</option>';
            });

            if(type == 1) {
                $('#canton').html(html);
                $('#district').html('<option value="">' + (completeOwnerTexts.select || 'Seleccionar') + '</option>');
            }
            if(type == 2) {
                $('#district').html(html);
            }
        }
    });
}

function validateNext () {
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

    var country = $('#country').val();
    var phonecode = $('#country option:selected').attr("data-phonecode");

    if(country == 53) {
        if($('#province').val() == ''){
            $('#province').addClass('is-invalid');
            validate = false;
        }else{
            $('#province').removeClass('is-invalid');
        }

        if($('#canton').val() == ''){
            $('#canton').addClass('is-invalid');
            validate = false;
        }else{
            $('#canton').removeClass('is-invalid');
        }

        if($('#district').val() == ''){
            $('#district').addClass('is-invalid');
            validate = false;
        }else{
            $('#district').removeClass('is-invalid');
        }
    }else{
        if($('#province_alternate').val() == ''){
            $('#province_alternate').addClass('is-invalid');
            validate = false;
        }else{
            $('#province_alternate').removeClass('is-invalid');
        }

        if($('#canton_alternate').val() == ''){
            $('#canton_alternate').addClass('is-invalid');
            validate = false;
        }else{
            $('#canton_alternate').removeClass('is-invalid');
        }

        if($('#district_alternate').val() == ''){
            $('#district_alternate').addClass('is-invalid');
            validate = false;
        }else{
            $('#district_alternate').removeClass('is-invalid');
        }
    }

    if(($('#phone').val() == '+' + phonecode)) {
        $('#phone').addClass('is-invalid');
        validate = false;
    }

    if(validate == true) {
        changeTab('step2');
    }
}

let types = completeOwnerOptionTypes;
function addAnimal() {
    let breeds = '<option value="">' + (completeOwnerTexts.select || 'Seleccionar') + '</option>';

    var random = getRamdom();
    var html = '<div class="d-grid d-md-flex gap-2 gap-md-4 justify-content-md-between align-items-center py-3">'+
                    '<div class="w-100">'+
                        '<label for="petname" class="form-label small">' + (completeOwnerLabels.namepet || '') + '</label>'+
                        '<input type="text" class="form-control fc requerido2" id="petname'+random+'" name="petname[]" maxlength="255">'+
                    '</div>'+
                    '<div class="w-100">'+
                        '<label for="animaltype" class="form-label small">' + (completeOwnerLabels.type || '') + '</label>'+
                        '<select name="animaltype[]" id="animaltype'+random+'" class="form-select fc select2 requerido2" data-code="'+random+'" onchange="Setup.getBreed(this);">'+
                            types +
                        '</select>'+
                    '</div>'+
                    '<div class="w-100">'+
                        '<label for="breed" class="form-label small">' + (completeOwnerLabels.breed || '') + '</label>'+
                        '<select name="breed[]" id="breed'+random+'" class="form-select fc select2 requerido2">'+
                            breeds +
                        '</select>'+
                    '</div>'+
                    '<div class="text-center">'+
                        '<a onclick="Setup.removeAnimal(this);" class="btn btn-outline-danger btn-sm mt-1 mt-md-0"><i class="fa-solid fa-xmark"></i></a>'+
                    '</div>'+
                '</div>';

    $('#printAnimals').append(html);

    if (helpers.initSelect2) {
        helpers.initSelect2('#animaltype' + random);
        helpers.initSelect2('#breed' + random);
    }
}

function removeAnimal(obj) {
    $(obj).parent('div').parent('div').remove();
}

function getRamdom() {
    var random = Math.random();
    random = random + "";
    random = random.replace(".", "");

    return random;
}

function validSend() {
    var validate = true;

    $('.requerido2').each(function(i, elem){
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

function getBreed(obj) {
    var code = $(obj).attr('data-code');

    var type = $('#animaltype' + code).val();

    ajaxPost(completeOwnerRoutes.getBreed, {
        type: type
    }, {
        beforeSend: function(){},
        success: function(data){
            var html = '<option value="">' + (completeOwnerTexts.select || 'Seleccionar') + '</option>';
            $.each(data.rows, function(i, item) {
                html = html + '<option value="'+item.id+'">'+item.title+'</option>';
            });

            $('#breed' + code).html(html);
        }
    });
}

Setup.changeTab = changeTab;
Setup.changeCountry = changeCountry;
Setup.getLocation = getLocation;
Setup.validateNext = validateNext;
Setup.addAnimal = addAnimal;
Setup.removeAnimal = removeAnimal;
Setup.validSend = validSend;
Setup.getBreed = getBreed;
