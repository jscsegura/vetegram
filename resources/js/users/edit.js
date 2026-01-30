const Users = window.Users = window.Users || {};
(function() {
    const config = window.USERS_COMMON_CONFIG || {};
    const routes = config.routes || {};
    const texts = config.texts || {};
    const editConfig = window.USERS_EDIT_CONFIG || {};
    const hasClinicSection = !!editConfig.hasClinicSection;
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

    function initUserEditSelects() {
        if (window.vetegramUsers && window.vetegramUsers.initSelect2) {
            window.vetegramUsers.initSelect2('.select2');
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

    function changeCountry2(obj) {
        if (!hasClinicSection) {
            return;
        }
        var country = $(obj).val();
        var phonecode = $('#country2 option:selected').attr('data-phonecode');

        if (country == 53) {
            $('#province2Div').show();
            $('#canton2Div').show();
            $('#district2Div').show();

            $('#province_alternate2').hide();
            $('#canton_alternate2').hide();
            $('#district_alternate2').hide();
        } else {
            $('#province2Div').hide();
            $('#canton2Div').hide();
            $('#district2Div').hide();

            $('#province_alternate2').show();
            $('#canton_alternate2').show();
            $('#district_alternate2').show();
        }

        $('#phonevet').val('+' + phonecode);
    }

    function getLocation2(type, value) {
        if (!hasClinicSection || !routes.getLocation) {
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
                    $('#canton2').html(html);
                    $('#district2').html('<option value="">' + (texts.selectLabel || '') + '</option>');
                }
                if (type == 2) {
                    $('#district2').html(html);
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

        if (hasClinicSection) {
            var country2 = $('#country2').val();
            var phonecode2 = $('#country2 option:selected').attr('data-phonecode');

            if (country2 == 53) {
                if ($('#province2').val() == '') {
                    $('#province2').addClass('is-invalid');
                    validate = false;
                } else {
                    $('#province2').removeClass('is-invalid');
                }

                if ($('#canton2').val() == '') {
                    $('#canton2').addClass('is-invalid');
                    validate = false;
                } else {
                    $('#canton2').removeClass('is-invalid');
                }

                if ($('#district2').val() == '') {
                    $('#district2').addClass('is-invalid');
                    validate = false;
                } else {
                    $('#district2').removeClass('is-invalid');
                }
            } else {
                if ($('#province_alternate2').val() == '') {
                    $('#province_alternate2').addClass('is-invalid');
                    validate = false;
                } else {
                    $('#province_alternate2').removeClass('is-invalid');
                }

                if ($('#canton_alternate2').val() == '') {
                    $('#canton_alternate2').addClass('is-invalid');
                    validate = false;
                } else {
                    $('#canton_alternate2').removeClass('is-invalid');
                }

                if ($('#district_alternate2').val() == '') {
                    $('#district_alternate2').addClass('is-invalid');
                    validate = false;
                } else {
                    $('#district_alternate2').removeClass('is-invalid');
                }
            }

            if (window.vetegramUsers && !window.vetegramUsers.validatePhone('#phonevet', phonecode2)) {
                validate = false;
            }
        }

        if (validate == true) {
            setCharge();
        }

        return validate;
    }

    document.addEventListener('DOMContentLoaded', function() {
        initUserEditSelects();
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

    Users.changeCountry = changeCountry;
    Users.getLocation = getLocation;
    Users.changeCountry2 = changeCountry2;
    Users.getLocation2 = getLocation2;
    Users.checkCode = checkCode;
    Users.validSend = validSend;
})();
