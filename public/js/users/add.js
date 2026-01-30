const Users = window.Users = window.Users || {};
(function() {
    const config = window.USERS_COMMON_CONFIG || {};
    const routes = config.routes || {};
    const texts = config.texts || {};
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

    function initUserAddSelects() {
        if (window.vetegramUsers && window.vetegramUsers.initSelect2) {
            window.vetegramUsers.initSelect2('.select2');
        }
    }

    function setRol() {
        var roluser = $('#roluser').val();
        if (roluser == 4) {
            $('#containerCode').show();
        } else {
            $('#containerCode').hide();
        }
    }

    function changeCountry(obj) {
        var country = $(obj).val();
        var phonecode = $('#country option:selected').attr('data-phonecode');

        if (country == 53) {
            $('#provinceDiv').show();
            $('#cantonDiv').show();
            $('#districtDiv').show();

            $('#province_alternate').hide();
            $('#canton_alternate').hide();
            $('#district_alternate').hide();
        } else {
            $('#provinceDiv').hide();
            $('#cantonDiv').hide();
            $('#districtDiv').hide();

            $('#province_alternate').show();
            $('#canton_alternate').show();
            $('#district_alternate').show();
        }

        $('#phone').val('+' + phonecode);
    }

    function getLocation(type, value) {
        if (!routes.getLocation) {
            return;
        }
        ajaxPost(routes.getLocation, {
            type: type,
            value: value
        }, {
            success: function(data) {
                var html = '<option value="">' + (texts.selectLabel || '') + '</option>';
                $.each(data.rows || [], function(i, item) {
                    html = html + '<option value="' + item.id + '">' + item.title + '</option>';
                });

                if (type == 1) {
                    $('#canton').html(html);
                    $('#district').html('<option value="">' + (texts.selectLabel || '') + '</option>');
                }
                if (type == 2) {
                    $('#district').html(html);
                }
            }
        });
    }

    function checkCode(code) {
        if (window.vetegramUsers && window.vetegramUsers.checkVetCode) {
            window.vetegramUsers.checkVetCode(code, '#resultCode');
        }
    }

    function validSend() {
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

        var letraPattern = /[a-zA-Z]/;

        $('.requeridoLetra').each(function(i, elem) {
            if (!letraPattern.test($(elem).val())) {
                $(elem).addClass('is-invalid');
                validate = false;

                window.vetegramHelpers.toast({
                    text: texts.nameMustContainLetters || 'El nombre debe contener letras',
                    position: 'bottom-right',
                    textAlign: 'center',
                    loader: false,
                    hideAfter: 4000,
                    icon: 'error'
                });
            }
        });

        var emailValidator = helpers.validateEmail || function(email) {
            return /^[a-zA-Z0-9._+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/.test(email || '');
        };

        $('.requeridoEmail').each(function(i, elem) {
            if (!emailValidator($(elem).val())) {
                $(elem).addClass('is-invalid');
                validate = false;

                window.vetegramHelpers.toast({
                    text: texts.invalidEmail || 'El correo no es válido',
                    position: 'bottom-right',
                    textAlign: 'center',
                    loader: false,
                    hideAfter: 4000,
                    icon: 'error'
                });
            }
        });

        var country = $('#country').val();
        var phonecode = $('#country option:selected').attr('data-phonecode');

        if (country == 53) {
            if ($('#province').val() == '') {
                $('#province').addClass('is-invalid');
                validate = false;
            } else {
                $('#province').removeClass('is-invalid');
            }

            if ($('#canton').val() == '') {
                $('#canton').addClass('is-invalid');
                validate = false;
            } else {
                $('#canton').removeClass('is-invalid');
            }

            if ($('#district').val() == '') {
                $('#district').addClass('is-invalid');
                validate = false;
            } else {
                $('#district').removeClass('is-invalid');
            }
        } else {
            if ($('#province_alternate').val() == '') {
                $('#province_alternate').addClass('is-invalid');
                validate = false;
            } else {
                $('#province_alternate').removeClass('is-invalid');
            }

            if ($('#canton_alternate').val() == '') {
                $('#canton_alternate').addClass('is-invalid');
                validate = false;
            } else {
                $('#canton_alternate').removeClass('is-invalid');
            }

            if ($('#district_alternate').val() == '') {
                $('#district_alternate').addClass('is-invalid');
                validate = false;
            } else {
                $('#district_alternate').removeClass('is-invalid');
            }
        }

        if (window.vetegramUsers && !window.vetegramUsers.validatePhone('#phone', phonecode)) {
            validate = false;
        }

        if (validate == true) {
            setCharge();
        }

        return validate;
    }

    document.addEventListener('DOMContentLoaded', function() {
        initUserAddSelects();
    });

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

    Users.setRol = setRol;
    Users.changeCountry = changeCountry;
    Users.getLocation = getLocation;
    Users.checkCode = checkCode;
    Users.validSend = validSend;
})();
