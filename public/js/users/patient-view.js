const Users = window.Users = window.Users || {};
(function() {
    function initPatientViewSelects() {
        if (window.vetegramUsers && window.vetegramUsers.initSelect2) {
            window.vetegramUsers.initSelect2('.select2');
        }
    }

    function getBreed() {
        if (window.vetegramUsers && window.vetegramUsers.getBreed) {
            window.vetegramUsers.getBreed('#type', '#breed');
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

        if (validate == true) {
            setCharge();
        }

        return validate;
    }

    document.addEventListener('DOMContentLoaded', function() {
        initPatientViewSelects();
    });

    Users.getBreed = getBreed;
    Users.validSend = validSend;
})();
