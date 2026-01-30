const Inventory = window.Inventory = window.Inventory || {};
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
Inventory.validSend = validSend;
