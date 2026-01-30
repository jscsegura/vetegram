(function() {
    const module = window.AppointmentsStart;
    if (!module) {
        return;
    }

    module.ui = module.ui || {};

    module.ui.sendFormEditValidate = function() {
        $('#frmEditPet').submit();
    };

    module.ui.sendFormEdit = function() {
        var validate = true;

        $('.requeridoEditPet').each(function(i, elem) {
            var value = $(elem).val();
            value = value.trim();
            if (value == '') {
                $(elem).addClass('is-invalid');
                validate = false;
            } else {
                $(elem).removeClass('is-invalid');
            }
        });

        if (validate == true) {
            setCharge2();
            return true;
        }

        return false;
    };
})();
