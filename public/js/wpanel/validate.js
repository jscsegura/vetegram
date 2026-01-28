if(typeof jsNotifications != 'undefined'){
    var objInstanceName=new jsNotifications({
            autoCloseTime : 8,
            showAlerts: true,
            title: 'Mensaje'
    });
    $(function(){
        if(objInstanceName.isAvailable()){
            if(objInstanceName.getStatus()==1) $('#divBottomBar').fadeIn(1200);
        }
    });
}

function validateNoMsj() {

    var validate = true;

    $('.requerido').each(function (i, elem) {
        if ($(elem).val() === '') {
            $(elem).css({'border': '1px solid red'});
            validate = false;
        } else {
            $(elem).css({'border': '1px solid #E6E6E6'});
        }
    });

    return validate;
}

function validate(filter){

    var validate = true;
    var revalidate = true;

    $('.requerido').each(function(i, elem){
    	if($(elem).val() == ''){
            $(elem).css({'border':'1px solid red'});
            validate = false;
    	}else{
            $(elem).css({'border':'1px solid #E6E6E6'});
    	}
    });

    $('.requeridoEmail').each(function(i, elem){
    	if(!validaEmail($(elem).val())){
            $(elem).css({'border':'1px solid red'});
            validate = false;
    	}else{
            $(elem).css({'border':'1px solid #E6E6E6'});
    	}
    });

    /*$('.requeridoEditor').each(function(i, elem){
        if (tinyMCE) tinyMCE.triggerSave();
        var id = $(elem).attr('id');
    	if($(elem).val() == ''){
            $('#'+id+"_ifr").css({'border':'1px solid red'});
            validate = false;
    	}else{
            $('#'+id+"_ifr").css({'border':'1px solid #E6E6E6'});
    	}
    });*/

    if(filter != null){
        switch (filter){
            case 1:revalidate = validatePassword();break;
        }
    }
    if(!revalidate){validate = false;}

    if(validate == false){
        objInstanceName.show('error','Vuelva a intentarlo',false,'Debe rellenar los campos requeridos (*)');
        return false;
    }else{
        $('.loadingTmp').show();
        return true;
    }
}

function validatePassword(){

    var validate = true;

    var pass = $("#txtPassword").val();
    var repass = $("#txtPasswordConfirm").val();

    if(pass != repass){
        validate = false;
        $("#txtPassword").css({'border':'1px solid red'});
        $("#txtPasswordConfirm").css({'border':'1px solid red'});
    }
    return validate;
}

function validaEmail(email) {
    var reg=/^[0-9a-z_\-\.]+@[0-9a-z\-\.]+\.[a-z]{2,4}$/i;
    if(reg.test(email)){
        return true;
    }else{
        return false;
    }
}

function enterOnlyNumbers(event){
    if ( event.keyCode == 8 || event.keyCode == 9 || (event.keyCode >= 37 && event.keyCode <= 40) || event.keyCode == 188 || event.keyCode == 190 ) {
    } else {
        if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
            event.preventDefault();
        }
    }
}

function enabledRegister(route, data, update){
    $.ajax({
        type: 'POST',
        url: route,
        data:data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function(){
            $('.loadingTmp').css('display','block');
        },
        success: function(data){
            $('#'+update).html(data);
            $('.loadingTmp').css('display','none');
        }
    });
}

function eliminateRegister(route, data, update){
    bootbox.confirm({
        title: "Confirmación",
        message: "Seguro que desea eliminar este registro???",
        className: 'confirm_bootbox',
        buttons: {
            confirm: {
                label: '<i class="fa fa-times"></i> Si, Eliminar ',
                className: 'btn-success'
            },
            cancel: {
                label: ' No, Cancelar ',
                className: 'btn-danger'
            }
        },
        callback: function (result) {
            if(result){
                $.ajax({
                    type: 'POST',
                    url: route,
                    data:data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function(objeto){
                        $('.loadingTmp').css('display','block');
                    },
                    success: function(data){
                        $(update).fadeOut("slow").remove();
                        $('.loadingTmp').css('display','none');
                    }
                });
            }
        }
    });
}

function eliminateRegisterFile(route, data, update){
    bootbox.confirm({
        title: "Confirmación",
        message: "Seguro que desea eliminar este archivo???",
        className: 'confirm_bootbox',
        buttons: {
            confirm: {
                label: '<i class="fa fa-times"></i> Si, Eliminar ',
                className: 'btn-success'
            },
            cancel: {
                label: ' No, Cancelar ',
                className: 'btn-danger'
            }
        },
        callback: function (result) {
            if(result){
                $.ajax({
                    type: 'POST',
                    url: route,
                    data:data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function(objeto){
                        $('.loadingTmp').css('display','block');
                    },
                    success: function(data){
                        $('#'+update).html(data);
                        $('.loadingTmp').css('display','none');
                    }
                });
            }
        }
    });
}