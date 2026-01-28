function setLoad(id, text) {
    $('#' + id).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>&nbsp;' + text);
}

function stopLoad(id, text) {
    $('#' + id).html(text);
}

function setCharge() {
    $('#divCharge').fadeIn();
}

function hideCharge() {
    $('#divCharge').fadeOut();
}

function setCharge2() {
    $('#divCharge2').fadeIn();
}

function hideCharge2() {
    $('#divCharge2').fadeOut();
}