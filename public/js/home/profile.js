(function () {
    const Home = window.Home = window.Home || {};
    const config = window.HOME_PROFILE_CONFIG || {};
    const texts = config.texts || {};
    const routes = config.routes || {};
    const userRoleId = Number(config.userRoleId || 0);
    const helpers = window.vetegramHelpers || {};
    const ajaxPost = helpers.ajaxPost || function (url, data, options) {
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

    $(function () {
        if (helpers.initSelect2) {
            helpers.initSelect2('.select2');
        }
        const vcodeInput = $('#vcode');
        if (vcodeInput.length && helpers.enterOnlyNumbers) {
            vcodeInput.on('keydown', function (event) {
                helpers.enterOnlyNumbers(event);
            });
        }
    });

    function changePassword() {
        if ($('#changePass').prop('checked')) {
            $('.divPassw').show();
        } else {
            $('.divPassw').hide();
        }
    }

    function changeCountry(obj) {
        const country = $(obj).val();
        const phonecode = $('#country option:selected').attr('data-phonecode');

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
        ajaxPost(routes.location || '', { type: type, value: value }, {
            beforeSend: function () {},
            success: function (data) {
                let html = '<option value="">' + (texts.select || '') + '</option>';
                $.each(data.rows, function (i, item) {
                    html = html + '<option value="' + item.id + '">' + item.title + '</option>';
                });

                if (type == 1) {
                    $('#canton').html(html);
                    $('#district').html('<option value="">' + (texts.select || '') + '</option>');
                }
                if (type == 2) {
                    $('#district').html(html);
                }
            }
        });
    }

    function changeCountry2(obj) {
        const country = $(obj).val();
        const phonecode = $('#country2 option:selected').attr('data-phonecode');

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
        ajaxPost(routes.location || '', { type: type, value: value }, {
            beforeSend: function () {},
            success: function (data) {
                let html = '<option value="">' + (texts.select || '') + '</option>';
                $.each(data.rows, function (i, item) {
                    html = html + '<option value="' + item.id + '">' + item.title + '</option>';
                });

                if (type == 1) {
                    $('#canton2').html(html);
                    $('#district2').html('<option value="">' + (texts.select || '') + '</option>');
                }
                if (type == 2) {
                    $('#district2').html(html);
                }
            }
        });
    }

    function checkCode(code) {
        ajaxPost(routes.checkVetCode || '', { code: code }, {
            beforeSend: function () {},
            success: function (data) {
                if (data.id == 0) {
                    $('#resultCode').html('<i class="fa fa-times" style="color: red;" aria-hidden="true"></i>');
                } else {
                    $('#resultCode').html('<i class="fa fa-check" style="color: green;" aria-hidden="true"></i>');
                }
            }
        });
    }

    function validSend() {
        let validate = true;

        $('.requerido').each(function (i, elem) {
            let value = $(elem).val();
            value = value ? value.trim() : '';
            if (value === '') {
                $(elem).addClass('is-invalid');
                validate = false;
            } else {
                $(elem).removeClass('is-invalid');
            }
        });

        const country = $('#country').val();
        let phonecode = $('#country option:selected').attr('data-phonecode');

        if (country == 53) {
            if ($('#province').val() === '') {
                $('#province').addClass('is-invalid');
                validate = false;
            } else {
                $('#province').removeClass('is-invalid');
            }

            if ($('#canton').val() === '') {
                $('#canton').addClass('is-invalid');
                validate = false;
            } else {
                $('#canton').removeClass('is-invalid');
            }

            if ($('#district').val() === '') {
                $('#district').addClass('is-invalid');
                validate = false;
            } else {
                $('#district').removeClass('is-invalid');
            }
        } else {
            if ($('#province_alternate').val() === '') {
                $('#province_alternate').addClass('is-invalid');
                validate = false;
            } else {
                $('#province_alternate').removeClass('is-invalid');
            }

            if ($('#canton_alternate').val() === '') {
                $('#canton_alternate').addClass('is-invalid');
                validate = false;
            } else {
                $('#canton_alternate').removeClass('is-invalid');
            }

            if ($('#district_alternate').val() === '') {
                $('#district_alternate').addClass('is-invalid');
                validate = false;
            } else {
                $('#district_alternate').removeClass('is-invalid');
            }
        }

        if ($('#phone').val() === '+' + phonecode) {
            $('#phone').addClass('is-invalid');
            validate = false;
        }

        if (userRoleId === 3) {
            const country2 = $('#country2').val();
            phonecode = $('#country2 option:selected').attr('data-phonecode');

            if (country2 == 53) {
                if ($('#province2').val() === '') {
                    $('#province2').addClass('is-invalid');
                    validate = false;
                } else {
                    $('#province2').removeClass('is-invalid');
                }

                if ($('#canton2').val() === '') {
                    $('#canton2').addClass('is-invalid');
                    validate = false;
                } else {
                    $('#canton2').removeClass('is-invalid');
                }

                if ($('#district2').val() === '') {
                    $('#district2').addClass('is-invalid');
                    validate = false;
                } else {
                    $('#district2').removeClass('is-invalid');
                }
            } else {
                if ($('#province_alternate2').val() === '') {
                    $('#province_alternate2').addClass('is-invalid');
                    validate = false;
                } else {
                    $('#province_alternate2').removeClass('is-invalid');
                }

                if ($('#canton_alternate2').val() === '') {
                    $('#canton_alternate2').addClass('is-invalid');
                    validate = false;
                } else {
                    $('#canton_alternate2').removeClass('is-invalid');
                }

                if ($('#district_alternate2').val() === '') {
                    $('#district_alternate2').addClass('is-invalid');
                    validate = false;
                } else {
                    $('#district_alternate2').removeClass('is-invalid');
                }
            }

            if ($('#phonevet').val() === '+' + phonecode) {
                $('#phonevet').addClass('is-invalid');
                validate = false;
            }
        }

        if ($('#changePass').prop('checked')) {
            if ($('#actualpass').val() === '') {
                $('#actualpass').addClass('is-invalid');
                validate = false;
            } else {
                $('#actualpass').removeClass('is-invalid');
            }

            if ($('#newpass').val() === '') {
                $('#newpass').addClass('is-invalid');
                validate = false;
            } else {
                $('#newpass').removeClass('is-invalid');
            }

            if ($('#actualpass').val() !== $('#newpass').val()) {
                $('#newpass').addClass('is-invalid');
                validate = false;
            }
        }

        const letraPattern = /[a-zA-Z]/;

        $('.requeridoLetra').each(function (i, elem) {
            if (!letraPattern.test($(elem).val())) {
                $(elem).addClass('is-invalid');
                validate = false;

                if (window.vetegramHelpers && window.vetegramHelpers.toast) {
                    window.vetegramHelpers.toast({
                        text: texts.nameLetters || '',
                        position: 'bottom-right',
                        textAlign: 'center',
                        loader: false,
                        hideAfter: 4000,
                        icon: 'error'
                    });
                }
            }
        });

        if (validate && typeof Home.setCharge === 'function') {
            setCharge();
        }

        return validate;
    }

    Home.changePassword = changePassword;
    Home.changeCountry = changeCountry;
    Home.getLocation = getLocation;
    Home.changeCountry2 = changeCountry2;
    Home.getLocation2 = getLocation2;
    Home.checkCode = checkCode;
    Home.validSend = validSend;
})();
