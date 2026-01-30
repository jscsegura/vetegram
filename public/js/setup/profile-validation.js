(function() {
    const module = window.SetupCompleteProfile = window.SetupCompleteProfile || {};
    const validation = module.validation = module.validation || {};
    const config = module.config || window.SETUP_COMPLETE_PROFILE_CONFIG || {};
    const texts = module.texts || config.texts || {};

    function getText(key, fallback) {
        if (module.getText) {
            return module.getText(key, fallback);
        }
        return texts[key] || fallback || '';
    }

    validation.validateStep = function(stepId) {
        let validate = true;
        const step = document.getElementById(stepId);
        if (!step) {
            return true;
        }

        $(step).find('.requerido').each(function(_i, elem) {
            const value = $(elem).val();
            let isEmpty = false;
            if (Array.isArray(value)) {
                isEmpty = value.length === 0;
            } else {
                const text = (value === null || value === undefined) ? '' : value.toString().trim();
                isEmpty = text === '';
            }
            if (isEmpty) {
                $(elem).addClass('is-invalid');
                validate = false;
            } else {
                $(elem).removeClass('is-invalid');
            }
        });

        if (stepId === 'step1') {
            const isVet = $('input[name="mycode"]:checked').val() === '1';
            const vcodeInput = $('#vcode');
            if (isVet) {
                if (vcodeInput.val().trim() === '') {
                    vcodeInput.addClass('is-invalid');
                    validate = false;
                } else {
                    vcodeInput.removeClass('is-invalid');
                }
            } else {
                vcodeInput.removeClass('is-invalid');
            }
        }

        if (stepId === 'step3') {
            const speciesSelected = $('input[name="species[]"]:checked').length > 0;
            if (!speciesSelected) {
                $('#speciesGroup').addClass('border-danger');
                $('#speciesError').show();
                validate = false;
            } else {
                $('#speciesGroup').removeClass('border-danger');
                $('#speciesError').hide();
            }
        }

        if (stepId === 'step4') {
            const country = $('#country').val();
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
            }
        }

        return validate;
    };

    validation.stepIsReady = function(stepId) {
        const step = document.getElementById(stepId);
        if (!step) {
            return true;
        }

        let ok = true;
        $(step).find('.requerido').each(function(_i, elem) {
            const value = $(elem).val();
            if (!value || value.toString().trim() === '') {
                ok = false;
                return false;
            }
        });

        if (stepId === 'step1') {
            const isVet = $('input[name="mycode"]:checked').val() === '1';
            if (isVet && $('#vcode').val().trim() === '') {
                ok = false;
            }
        }

        if (stepId === 'step3') {
            if ($('input[name="species[]"]:checked').length === 0) {
                ok = false;
            }
        }

        if (stepId === 'step4') {
            const country = $('#country').val();
            if (country == 53) {
                if ($('#province').val() === '' || $('#canton').val() === '' || $('#district').val() === '') {
                    ok = false;
                }
            } else {
                if ($('#province_alternate').val() === '' || $('#canton_alternate').val() === '') {
                    ok = false;
                }
            }
            if ($('#lat').val() === '' || $('#lng').val() === '') {
                ok = false;
            }
        }

        return ok;
    };

    validation.validSend = function() {
        let validate = true;
        let firstInvalid = null;
        const markInvalid = (elem) => {
            if (!elem) return;
            if (!firstInvalid) {
                firstInvalid = elem;
            }
        };

        $('.requerido').each(function(_i, elem) {
            const value = $(elem).val();
            let valueText = '';
            if (Array.isArray(value)) {
                valueText = value.join(',').trim();
            } else {
                valueText = (value === null || value === undefined) ? '' : value.toString().trim();
            }
            if (valueText === '') {
                $(elem).addClass('is-invalid');
                validate = false;
                markInvalid(elem);
            } else {
                $(elem).removeClass('is-invalid');
            }
        });

        if ($('input[name="mycode"]:checked').val() === '1') {
            if ($('#vcode').val().trim() === '') {
                $('#vcode').addClass('is-invalid');
                validate = false;
                markInvalid($('#vcode').get(0));
            } else {
                $('#vcode').removeClass('is-invalid');
            }
        }

        const speciesSelected = $('input[name="species[]"]:checked').length > 0;
        if (!speciesSelected) {
            $('#speciesGroup').addClass('border-danger');
            $('#speciesError').show();
            validate = false;
            markInvalid($('#speciesGroup').get(0));
        } else {
            $('#speciesGroup').removeClass('border-danger');
            $('#speciesError').hide();
        }

        const country = $('#country').val();
        const phonecode = $('#country option:selected').attr('data-phonecode');

        if (country == 53) {
            if ($('#province').val() == '') {
                $('#province').addClass('is-invalid');
                validate = false;
                markInvalid($('#province').get(0));
            } else {
                $('#province').removeClass('is-invalid');
            }

            if ($('#canton').val() == '') {
                $('#canton').addClass('is-invalid');
                validate = false;
                markInvalid($('#canton').get(0));
            } else {
                $('#canton').removeClass('is-invalid');
            }

            if ($('#district').val() == '') {
                $('#district').addClass('is-invalid');
                validate = false;
                markInvalid($('#district').get(0));
            } else {
                $('#district').removeClass('is-invalid');
            }
        } else {
            if ($('#province_alternate').val() == '') {
                $('#province_alternate').addClass('is-invalid');
                validate = false;
                markInvalid($('#province_alternate').get(0));
            } else {
                $('#province_alternate').removeClass('is-invalid');
            }

            if ($('#canton_alternate').val() == '') {
                $('#canton_alternate').addClass('is-invalid');
                validate = false;
                markInvalid($('#canton_alternate').get(0));
            } else {
                $('#canton_alternate').removeClass('is-invalid');
            }
        }

        if (window._itiPhone) {
            if (!window._itiPhone.isValidNumber()) {
                $('#phone').addClass('is-invalid');
                validate = false;
                markInvalid($('#phone').get(0));
            } else {
                $('#phone').removeClass('is-invalid');
            }
            try { $('#phone').val(window._itiPhone.getNumber()); } catch (_e) {}
        } else if ($('#phone').val().trim() === '' || $('#phone').val() == '+' + phonecode) {
            $('#phone').addClass('is-invalid');
            validate = false;
            markInvalid($('#phone').get(0));
        }

        if ($('#lat').val() == '' || $('#lng').val() == '') {
            $('#clinicMap').addClass('border-danger');
            validate = false;
            markInvalid($('#clinicMap').get(0));
        } else {
            $('#clinicMap').removeClass('border-danger');
        }

        if ($('#schedule_enabled').val() === '1' && window.Schedule && window.Schedule.validateSchedule) {
            if (!window.Schedule.validateSchedule()) {
                validate = false;
            }
        }

        if (validate === true) {
            if (typeof setCharge === 'function') {
                setCharge();
            }
            return true;
        }

        if (firstInvalid) {
            firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
        if (window.Swal) {
            Swal.fire({
                title: getText('errorTitle', 'Missing information'),
                text: getText('errorRequired', 'Please complete the required fields before finishing.'),
                icon: 'error',
                confirmButtonText: getText('ok', 'OK'),
                confirmButtonColor: '#4bc6f9',
                buttonsStyling: true
            });
        } else {
            alert(getText('errorRequired', 'Please complete the required fields before finishing.'));
        }

        return false;
    };
})();
