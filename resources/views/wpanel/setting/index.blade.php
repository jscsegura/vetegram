@extends('layouts.wpanel')

@section('title', 'Panel de administración - Configuración')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="page-title">
            <h3>Configuración</h3>
        </div>
    </div>
    <div class="col-md-6 text-right">
        <a class="btn btn-primary" href="{{ route('wp.setting.pro') }}"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Rubros planes PRO</a>
    </div>
</div>

<div id="container">
    <form name="frm" id="frm" role="form" method="post" enctype="multipart/form-data" action="{{ route('wp.settings.update', $setting->id) }}" onsubmit="return validate();">
        @csrf

        <div class="row">
            <div class="col-md-12">
                <h4><strong>Correo electrónico</strong></h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label>Host:</label>
                <input type="text" name="email_host" id="email_host" class="form-control" maxlength="255" value="{{ $setting->email_host }}">
            </div>
            <div class="col-md-6">
                <label>Usuario:</label>
                <input type="text" name="email_user" id="email_user" class="form-control" maxlength="255" value="{{ $setting->email_user }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-12"><p>&nbsp;</p></div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label>Contraseña:</label>
                <input type="password" name="email_pass" id="email_pass" class="form-control" maxlength="255" value="{{ $setting->email_pass }}">
            </div>
            <div class="col-md-6">
                <label>Puerto:</label>
                <input type="text" name="email_port" id="email_port" class="form-control" maxlength="10" value="{{ $setting->email_port }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-12"><p>&nbsp;</p></div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label>Nombre remitente:</label>
                <input type="text" name="email_from" id="email_from" class="form-control" maxlength="255" value="{{ $setting->email_from }}">
            </div>
            <div class="col-md-6">
                <label>Encriptación:</label>
                <select name="email_tls" id="email_tls" class="form-control">
                    <option value="tls" @if($setting->email_tls == 'tls') selected="selected" @endif>TLS</option>
                    <option value="ssl" @if($setting->email_tls == 'ssl') selected="selected" @endif>SSL</option>
                    <option value="" @if($setting->email_tls == '') selected="selected" @endif>Sin encriptación</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12"><p>&nbsp;</p></div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <label>Email para notificaciones:</label>
                <input type="text" name="email_to" id="email_to" class="form-control" maxlength="255" value="{{ $setting->email_to }}">
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12"><p>&nbsp;</p></div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h4><strong>Google</strong></h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label>Google Id:</label>
                <input type="text" name="google_id" id="google_id" class="form-control" maxlength="255" value="{{ $setting->google_id }}">
            </div>
            <div class="col-md-6">
                <label>Google Secret:</label>
                <input type="text" name="google_secret" id="google_secret" class="form-control" maxlength="255" value="{{ $setting->google_secret }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-12"><p>&nbsp;</p></div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h4><strong>Facebook</strong></h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label>Facebook Id:</label>
                <input type="text" name="facebook_id" id="facebook_id" class="form-control" maxlength="255" value="{{ $setting->facebook_id }}">
            </div>
            <div class="col-md-6">
                <label>Facebook Secret:</label>
                <input type="text" name="facebook_secret" id="facebook_secret" class="form-control" maxlength="255" value="{{ $setting->facebook_secret }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-12"><p>&nbsp;</p></div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h4><strong>Términos y condiciones</strong></h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <label>Términos (Español):</label>
                <textarea name="term_es" id="term_es" class="form-control editor">{{ $setting->term_es }}</textarea>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12"><p>&nbsp;</p></div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <label>Términos (Inglés):</label>
                <textarea name="term_en" id="term_en" class="form-control editor">{{ $setting->term_en }}</textarea>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12"><p>&nbsp;</p></div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h4><strong>Facturación</strong></h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <label>Usuario:</label>
                <input type="text" name="user_invoice" id="user_invoice" class="form-control" maxlength="255" value="{{ $setting->user_invoice }}">
            </div>
            <div class="col-md-4">
                <label>Contraseña:</label>
                <input type="password" name="pass_invoice" id="pass_invoice" class="form-control" maxlength="255" value="{{ $setting->pass_invoice }}">
            </div>
            <div class="col-md-4">
                <label>Ambiente:</label>
                <select name="environment_invoice" id="environment_invoice" class="form-control">
                    <option value="0" @if($setting->environment_invoice == 0) selected @endif>Producción</option>
                    <option value="1" @if($setting->environment_invoice == 1) selected @endif>Pruebas</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12"><p>&nbsp;</p></div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h4><strong>Capacidad planes</strong></h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <label>Precio plan PRO:</label>
                <input type="text" name="price_pro" id="price_pro" class="form-control" maxlength="255" value="{{ $setting->price_pro }}" onkeydown="enterOnlyNumbers(event);">
            </div>
            <div class="col-md-4">
                <label>Máximo consultas plan Gratis:</label>
                <input type="text" name="max_appointment_free" id="max_appointment_free" class="form-control" maxlength="11" value="{{ $setting->max_appointment_free }}" onkeydown="enterOnlyNumbers(event);">
            </div>
            <div class="col-md-4">
                <label>Máximo usuarios plan Gratis:</label>
                <input type="text" name="max_user_free" id="max_user_free" class="form-control" maxlength="11" value="{{ $setting->max_user_free }}" onkeydown="enterOnlyNumbers(event);">
            </div>
        </div>

        <div class="row">
            <div class="col-md-12"><p>&nbsp;</p></div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <label>Máximo almacenamiento plan Gratis (en MB):</label>
                <input type="text" name="max_storage_free" id="max_storage_free" class="form-control" maxlength="11" value="{{ $setting->max_storage_free }}" onkeydown="enterOnlyNumbers(event);">
            </div>
            <div class="col-md-4">
                <label>Máximo consultas plan Pro (0 para ilimitado):</label>
                <input type="text" name="max_appointment_pro" id="max_appointment_pro" class="form-control" maxlength="11" value="{{ $setting->max_appointment_pro }}" onkeydown="enterOnlyNumbers(event);">
            </div>
            <div class="col-md-4">
                <label>Máximo usuarios plan Pro (0 para ilimitado):</label>
                <input type="text" name="max_user_pro" id="max_user_pro" class="form-control" maxlength="11" value="{{ $setting->max_user_pro }}" onkeydown="enterOnlyNumbers(event);">
            </div>
        </div>

        <div class="row">
            <div class="col-md-12"><p>&nbsp;</p></div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <label>Máximo almacenamiento plan Pro (en MB):</label>
                <input type="text" name="max_storage_pro" id="max_storage_pro" class="form-control" maxlength="11" value="{{ $setting->max_storage_pro }}" onkeydown="enterOnlyNumbers(event);">
            </div>
        </div>

        <div class="row">
            <div class="col-md-12"><p>&nbsp;</p></div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h4><strong>Configuración Tilopay</strong></h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <label>Llave Api:</label>
                <input type="text" name="tilopay_key" id="tilopay_key" class="form-control" maxlength="255" value="{{ $setting->tilopay_key }}">
            </div>
            <div class="col-md-4">
                <label>Usuario Api:</label>
                <input type="text" name="tilopay_user" id="tilopay_user" class="form-control" maxlength="255" value="{{ $setting->tilopay_user }}">
            </div>
            <div class="col-md-4">
                <label>Contraseña Api:</label>
                <input type="text" name="tilopay_pass" id="tilopay_pass" class="form-control" maxlength="255" value="{{ $setting->tilopay_pass }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-12"><p>&nbsp;</p></div>
        </div>
    
        <div class="row">
            <div class="col-md-12">
                <br />
                <input type="submit" name="btnSubmit" id="btnSubmit" class="btn btn-primary" value="ACEPTAR">
                <input type="button" name="btnCancel" id="btnCancel" class="btn btn-danger" value="CANCELAR" onclick="window.open('{{ route('wp.home') }}','_self');">
            </div>
        </div>

        <div class="row">
            <div class="col-md-12"><p>&nbsp;</p></div>
        </div>
    </form>
</div>

@stop

@section('js')
    <script>
        function enterOnlyNumbers(event){
            if ( event.keyCode == 8 || event.keyCode == 9 || (event.keyCode >= 37 && event.keyCode <= 40) || event.keyCode == 188 || event.keyCode == 190 ) {
            } else {
                if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                    event.preventDefault();
                }
            }
        }
    </script>
@stop