(function() {
    const Setup = window.Setup = window.Setup || {};
    const module = window.SetupCompleteProfile = window.SetupCompleteProfile || {};
    const config = window.SETUP_COMPLETE_PROFILE_CONFIG || {};
    const helpers = window.vetegramHelpers || {};

    module.config = config;
    module.helpers = helpers;
    module.routes = config.routes || {};
    module.texts = config.texts || {};
    module.initial = config.initial || {};
    module.images = config.images || {};
    module.state = module.state || {};
    module.state.isProfileComplete = !!config.isProfileComplete;

    module.ajaxPost = helpers.ajaxPost || function(url, data, options) {
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

    module.getText = module.getText || function(key, fallback) {
        return module.texts[key] || fallback || '';
    };

    function initSelects() {
        if (helpers.initSelect2) {
            helpers.initSelect2('.select2');
            helpers.initSelect2('#specialty', { closeOnSelect: false });
        }
    }

    initSelects();

    $('input[name="species[]"]').on('change', function() {
        if ($('input[name="species[]"]:checked').length > 0) {
            $('#speciesGroup').removeClass('border-danger');
            $('#speciesError').hide();
        }
    });

    function selectDefaultLanguageFromIp() {
        const languageSelect = $('#language');
        if (!languageSelect.length) return;
        const current = languageSelect.val();
        if (current && current.length) return;

        const languageMap = {
            'CR': ['Español', 'Spanish'],
            'ES': ['Español', 'Spanish'],
            'MX': ['Español', 'Spanish'],
            'AR': ['Español', 'Spanish'],
            'BO': ['Español', 'Spanish'],
            'CL': ['Español', 'Spanish'],
            'CO': ['Español', 'Spanish'],
            'CU': ['Español', 'Spanish'],
            'DO': ['Español', 'Spanish'],
            'EC': ['Español', 'Spanish'],
            'GT': ['Español', 'Spanish'],
            'HN': ['Español', 'Spanish'],
            'NI': ['Español', 'Spanish'],
            'PA': ['Español', 'Spanish'],
            'PE': ['Español', 'Spanish'],
            'PR': ['Español', 'Spanish'],
            'PY': ['Español', 'Spanish'],
            'UY': ['Español', 'Spanish'],
            'VE': ['Español', 'Spanish'],
            'BR': ['Portuguese', 'Portugués'],
            'US': ['English', 'Inglés'],
            'GB': ['English', 'Inglés'],
            'CA': ['English', 'Inglés'],
            'AU': ['English', 'Inglés'],
            'NZ': ['English', 'Inglés'],
            'IE': ['English', 'Inglés']
        };

        function trySelectByNames(names) {
            if (!names || !names.length) return false;
            let selectedId = null;
            languageSelect.find('option').each(function() {
                const text = ($(this).text() || '').trim().toLowerCase();
                if (!text) return;
                for (const name of names) {
                    if (text.includes(name.toLowerCase())) {
                        selectedId = $(this).val();
                        return false;
                    }
                }
            });
            if (selectedId) {
                languageSelect.val([selectedId]).trigger('change');
                return true;
            }
            return false;
        }

        fetch('https://ipapi.co/json/')
            .then(res => res.json())
            .then(data => {
                const code = (data && data.country_code) ? data.country_code.toUpperCase() : null;
                if (!code) return;
                const names = languageMap[code] || [];
                if (!trySelectByNames(names)) {
                    if (code === 'US' || code === 'GB') {
                        trySelectByNames(['English', 'Inglés']);
                    }
                }
            })
            .catch(() => {});
    }

    module.selectDefaultLanguageFromIp = selectDefaultLanguageFromIp;
    selectDefaultLanguageFromIp();

    function toggleVetCode(isVet) {
        if (isVet) {
            $('#vetCodeBlock').show();
        } else {
            $('#vetCodeBlock').hide();
            $('#vcode').val('').removeClass('is-invalid');
            $('#resultCode').html('');
        }
    }

    module.toggleVetCode = toggleVetCode;

    function setupDropzone(dropId, inputId, previewId, removeBtnId, removeFlagId, defaultSrc = '', hasImage = false) {
        const drop = document.getElementById(dropId);
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);
        const removeBtn = document.getElementById(removeBtnId);
        const removeFlag = document.getElementById(removeFlagId);

        if (!drop || !input) {
            return;
        }

        drop.addEventListener('click', () => input.click());

        drop.addEventListener('dragover', (e) => {
            e.preventDefault();
            drop.classList.add('border-primary');
        });

        drop.addEventListener('dragleave', () => {
            drop.classList.remove('border-primary');
        });

        drop.addEventListener('drop', (e) => {
            e.preventDefault();
            drop.classList.remove('border-primary');
            if (e.dataTransfer && e.dataTransfer.files && e.dataTransfer.files.length > 0) {
                input.files = e.dataTransfer.files;
                updatePreview(input, preview);
                if (removeFlag) removeFlag.value = '0';
            }
        });

        input.addEventListener('change', () => {
            updatePreview(input, preview, removeBtn);
            if (removeFlag) removeFlag.value = '0';
        });

        if (removeBtn) {
            removeBtn.addEventListener('click', () => {
                input.value = '';
                if (preview) {
                    preview.src = defaultSrc || '';
                    if (!defaultSrc) {
                        preview.style.display = 'none';
                    }
                }
                removeBtn.style.display = 'none';
                if (removeFlag) removeFlag.value = '1';
            });
            if (!hasImage) {
                removeBtn.style.display = 'none';
            }
        }
    }

    function updatePreview(input, preview, removeBtn) {
        if (!preview || !input.files || !input.files[0]) {
            return;
        }
        const file = input.files[0];
        if (!file.type.startsWith('image/')) {
            return;
        }
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
        if (removeBtn) {
            removeBtn.style.display = 'inline-block';
        }
    }

    module.setupDropzone = setupDropzone;
    module.updatePreview = updatePreview;

    function changeCountry(obj) {
        const $target = $(obj);
        const country = $target.val();
        const phonecode = $('#country option:selected').attr('data-phonecode');

        if (country == 53) {
            $('#provinceGroup').show();
            $('#cantonGroup').show();
            $('#districtGroup').show();

            $('#provinceAltGroup').hide();
            $('#cantonAltGroup').hide();

            $('#canton').prop('disabled', ($('#province').val() == ''));
            $('#district').prop('disabled', ($('#canton').val() == ''));
        } else {
            $('#provinceGroup').hide();
            $('#cantonGroup').hide();
            $('#districtGroup').hide();

            $('#provinceAltGroup').show();
            $('#cantonAltGroup').show();
        }

        if (!window._itiPhone && ($('#phone').val() === '' || $('#phone').val() === '+' + phonecode)) {
            $('#phone').val('+' + phonecode);
        }
        if (module.map && module.map.updateMapFromAddress) {
            setTimeout(module.map.updateMapFromAddress, 200);
        }
    }

    module.changeCountry = changeCountry;

    function getLocation(type, value, selectedCanton = null, selectedDistrict = null) {
        if (type == 1) {
            $('#canton').prop('disabled', true);
            $('#district').prop('disabled', true);
        }
        module.ajaxPost(module.routes.getLocation || '/register/get-location', {
            type: type,
            value: value
        }, {
            beforeSend: function() {},
            success: function(data) {
                let html = `<option value="">${module.getText('select', 'Select')}</option>`;
                $.each(data.rows, function(_i, item) {
                    html = html + '<option value="' + item.id + '">' + item.title + '</option>';
                });

                if (type == 1) {
                    $('#canton').html(html);
                    $('#district').html(`<option value="">${module.getText('select', 'Select')}</option>`);
                    $('#canton').prop('disabled', false);
                    $('#district').prop('disabled', true);
                    if (selectedCanton) {
                        $('#canton').val(selectedCanton).trigger('change');
                        if (selectedDistrict) {
                            getLocation(2, selectedCanton, null, selectedDistrict);
                        }
                    }
                }
                if (type == 2) {
                    $('#district').html(html);
                    $('#district').prop('disabled', false);
                    if (selectedDistrict) {
                        $('#district').val(selectedDistrict).trigger('change');
                    }
                }
                if (module.map && module.map.updateMapFromAddress) {
                    setTimeout(module.map.updateMapFromAddress, 200);
                }
            }
        });
    }

    module.getLocation = getLocation;

    function checkCode(code) {
        module.ajaxPost(module.routes.checkVetCode || '/register/check-vetcode', {
            code: code
        }, {
            beforeSend: function() {},
            success: function(data) {
                if (data.id == 0) {
                    $('#resultCode').html('<i class="fa fa-times" style="color: red;" aria-hidden="true"></i>');
                } else {
                    $('#resultCode').html('<i class="fa fa-check"  style="color: green;" aria-hidden="true"></i>');
                }
            }
        });
    }

    module.checkCode = checkCode;

    changeCountry($('#country'));

    $('#province').on('change', function() {
        if ($('#country').val() == 53) {
            const hasProvince = $(this).val() !== '';
            $('#canton').prop('disabled', !hasProvince);
            if (!hasProvince) {
                $('#canton').val('').trigger('change');
                $('#district').prop('disabled', true).val('');
            }
        }
    });

    $('#canton').on('change', function() {
        if ($('#country').val() == 53) {
            const hasCanton = $(this).val() !== '';
            $('#district').prop('disabled', !hasCanton);
            if (!hasCanton) {
                $('#district').val('');
            }
        }
    });

    const initialCountry = module.initial.country;
    const initialProvince = module.initial.province;
    const initialCanton = module.initial.canton;
    const initialDistrict = module.initial.district;

    if (initialCountry) {
        $('#country').val(initialCountry).trigger('change');
        changeCountry($('#country').get(0));
        if (initialCountry == 53 && initialProvince) {
            $('#province').val(initialProvince).trigger('change');
            getLocation(1, initialProvince, initialCanton, initialDistrict);
        }
    }

    $('input[name="mycode"]').on('change', function() {
        toggleVetCode(this.value === '1');
    });
    toggleVetCode($('input[name="mycode"]:checked').val() === '1');

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

    setupDropzone('profilePhotoDrop', 'profilePhoto', 'profilePhotoPreview', 'removeProfilePhotoBtn', 'removeProfilePhoto', module.images.profilePhoto || '', !!module.images.profilePhotoHasImage);
    setupDropzone('clinicLogoDrop', 'clinicLogo', 'clinicLogoPreview', 'removeClinicLogoBtn', 'removeClinicLogo', module.images.clinicLogo || '', !!module.images.clinicLogoHasImage);

    const phoneInput = document.getElementById('phone');
    if (phoneInput && window.intlTelInput) {
        const iti = window.intlTelInput(phoneInput, {
            initialCountry: 'auto',
            separateDialCode: true,
            nationalMode: false,
            geoIpLookup: function(callback) {
                fetch('https://ipapi.co/json/')
                    .then(res => res.json())
                    .then(data => callback((data && data.country_code) ? data.country_code.toLowerCase() : 'us'))
                    .catch(() => callback('us'));
            },
            utilsScript: 'https://cdn.jsdelivr.net/npm/intl-tel-input@23.1.1/build/js/utils.js'
        });

        window._itiPhone = iti;
        if (phoneInput.value) {
            try { iti.setNumber(phoneInput.value); } catch (_e) {}
        }
    }

    if (module.map && module.map.init) {
        module.map.init();
    }
    if (module.tabs && module.tabs.init) {
        module.tabs.init();
    }
    if (module.draft && module.draft.init) {
        module.draft.init();
    }

    const router = window.vetegramActionRouter;
    if (router && router.register) {
        router.register('changeTab', function() {
            if (module.tabs && module.tabs.changeTab) {
                return module.tabs.changeTab.apply(null, arguments);
            }
        });
        router.register('nextStep', function() {
            if (module.tabs && module.tabs.nextStep) {
                return module.tabs.nextStep.apply(null, arguments);
            }
        });
        router.register('validSend', function() {
            if (module.validation && module.validation.validSend) {
                return module.validation.validSend.apply(null, arguments);
            }
            return true;
        });
        router.register('changeCountry', function(el) {
            return changeCountry(el);
        });
        router.register('getLocation', function(type, value) {
            return getLocation(type, value);
        });
        router.register('checkCode', function(value) {
            return checkCode(value);
        });
        router.register('enterOnlyNumbers', function(event) {
            if (helpers.enterOnlyNumbers) {
                return helpers.enterOnlyNumbers(event);
            }
        });
    }

    Setup.changeTab = module.tabs ? module.tabs.changeTab : undefined;
    Setup.nextStep = module.tabs ? module.tabs.nextStep : undefined;
    Setup.validSend = module.validation ? module.validation.validSend : undefined;
    Setup.changeCountry = changeCountry;
    Setup.getLocation = getLocation;
    Setup.checkCode = checkCode;
})();
