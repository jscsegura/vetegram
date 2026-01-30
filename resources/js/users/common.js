(function() {
    const config = window.USERS_COMMON_CONFIG || {};
    const routes = config.routes || {};
    const texts = config.texts || {};
    const selectors = config.selectors || {};
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

    function initSelect2(selector, options = {}) {
        if (!helpers.initSelect2) {
            return;
        }
        helpers.initSelect2(selector, options);
    }

    function checkVetCode(code, resultSelector) {
        if (!routes.checkVetCode || typeof $ === 'undefined') {
            return;
        }
        const target = resultSelector || '#resultCode';
        ajaxPost(routes.checkVetCode, { code: code }, {
            success: function(data) {
                if (data && data.id == 0) {
                    $(target).html('<i class="fa fa-times" style="color: red;" aria-hidden="true"></i>');
                } else {
                    $(target).html('<i class="fa fa-check" style="color: green;" aria-hidden="true"></i>');
                }
            }
        });
    }

    function validatePhone(phoneSelector, phoneCode) {
        if (typeof $ === 'undefined') {
            return true;
        }
        const $phone = $(phoneSelector);
        if (!$phone.length || !phoneCode) {
            return true;
        }
        if ($phone.val() === '+' + phoneCode) {
            $phone.addClass('is-invalid');
            return false;
        }
        $phone.removeClass('is-invalid');
        return true;
    }

    const enterOnlyNumbers = helpers.enterOnlyNumbers || function() {};

    function getBreed(typeSelector, breedSelector) {
        if (!routes.getBreed || typeof $ === 'undefined') {
            return;
        }
        const typeEl = typeSelector || selectors.type || '#type';
        const breedEl = breedSelector || selectors.breed || '#breed';
        const type = $(typeEl).val();

        ajaxPost(routes.getBreed, { type: type }, {
            success: function(data) {
                let html = '<option value="">' + (texts.selectLabel || '') + '</option>';
                $.each(data.rows || [], function(i, item) {
                    html = html + '<option value="' + item.id + '">' + item.title + '</option>';
                });
                $(breedEl).html(html);
            }
        });
    }

    window.vetegramUsers = {
        initSelect2: initSelect2,
        checkVetCode: checkVetCode,
        validatePhone: validatePhone,
        enterOnlyNumbers: enterOnlyNumbers,
        getBreed: getBreed
    };
})();
