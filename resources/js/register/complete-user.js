const Setup = window.Setup = window.Setup || {};
const completeUserConfig = window.REGISTER_COMPLETE_USER_CONFIG || {};
const completeUserRoutes = completeUserConfig.routes || {};
const completeUserTexts = completeUserConfig.texts || {};
const completeUserInitial = completeUserConfig.initial || {};
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

function changeCountry(obj, first = 0) {
    var country = $(obj).val();
    var phonecode = $('#country option:selected').attr("data-phonecode");

    if(country == 53) {
        $('#provinceDiv').show();
        $('#cantonDiv').show();
        $('#districtDiv').show();

        $('#province_alternate').hide();
        $('#canton_alternate').hide();
        $('#district_alternate').hide();
    }else{
        $('#provinceDiv').hide();
        $('#cantonDiv').hide();
        $('#districtDiv').hide();

        $('#province_alternate').show();
        $('#canton_alternate').show();
        $('#district_alternate').show();
    }

    if(first == 1) {
        phonecode = completeUserInitial.phone || '';
        $('#phone').val(phonecode);
    }else{
        $('#phone').val('+' + phonecode);
    }
}
changeCountry($('#country'), 1);

function getLocation(type, value) {
    ajaxPost(completeUserRoutes.getLocation, {
        type: type,
        value: value
    }, {
        beforeSend: function(){},
        success: function(data){
            var html = '<option value="">' + (completeUserTexts.select || 'Seleccionar') + '</option>';
            $.each(data.rows, function(i, item) {
                html = html + '<option value="'+item.id+'">'+item.title+'</option>';
            });

            if(type == 1) {
                $('#canton').html(html);
                $('#district').html('<option value="">' + (completeUserTexts.select || 'Seleccionar') + '</option>');
            }
            if(type == 2) {
                $('#district').html(html);
            }
        }
    });
}

function checkCode(code) {
    ajaxPost(completeUserRoutes.checkVetCode, {
        code: code
    }, {
        beforeSend: function(){},
        success: function(data){
            if(data.id == 0) {
                $('#resultCode').html('<i class="fa fa-times" style="color: red;" aria-hidden="true"></i>');
            }else{
                $('#resultCode').html('<i class="fa fa-check"  style="color: green;" aria-hidden="true"></i>');
            }
        }
    });
}

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
        setCharge();
    }

    return validate;
}

const vcodeInput = $('#vcode');
if (vcodeInput.length) {
    vcodeInput.on('change', function() {
        checkCode($(this).val());
    });
    vcodeInput.on('keydown', function(event) {
        if (helpers.enterOnlyNumbers) {
            helpers.enterOnlyNumbers(event);
        }
    });
}

Setup.changeCountry = changeCountry;
Setup.getLocation = getLocation;
Setup.checkCode = checkCode;
Setup.validSend = validSend;
