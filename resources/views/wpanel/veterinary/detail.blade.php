@extends('layouts.wpanel')

@section('title', 'Panel de administración - Usuario de veterianaria')

@section('css')
<style>
    #tableList_filter input[type=search] {
        width: 88%;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="page-title">
            <h3>Detalle del usuario</h3>
        </div>
    </div>
    <div class="col-md-6 text-right">
        <a class="btn btn-primary" onclick="logWithUser();"><i class="fa fa-lock" aria-hidden="true"></i>&nbsp;Acceder como usuario</a>
        <a class="btn btn-warning" href="{{ route('wp.veterinary.users', $user->id_vet) }}"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp;Regresar</a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <label>Nombre</label>
        <input type="text" onfocus="blur()" class="form-control" value="{{ $user->name }}">
    </div>
    <div class="col-md-6">
        <label>Correo</label>
        <input type="text" onfocus="blur()" class="form-control" value="{{ $user->email }}">
    </div>
</div>

<div class="row"><div class="col-md-12">&nbsp;</div></div>

<div class="row">
    <div class="col-md-6">
        <label>Tipo de identificación</label>
        <input type="text" onfocus="blur()" class="form-control" value="{{ ($user->type_dni == 2) ? 'Juridico' : 'Fisico' }}">
    </div>
    <div class="col-md-6">
        <label>Identificación</label>
        <input type="text" onfocus="blur()" class="form-control" value="{{ $user->dni }}">
    </div>
</div>

<div class="row"><div class="col-md-12">&nbsp;</div></div>

<div class="row">
    <div class="col-md-6">
        <label>Pais</label>
        <input type="text" onfocus="blur()" class="form-control" value="{{ (isset($country->title)) ? $country->title : '' }}">
    </div>
    <div class="col-md-6">
        <label>Provincia</label>
        <input type="text" onfocus="blur()" class="form-control" value="{{ $province }}">
    </div>
</div>

<div class="row"><div class="col-md-12">&nbsp;</div></div>

<div class="row">
    <div class="col-md-6">
        <label>Cantón</label>
        <input type="text" onfocus="blur()" class="form-control" value="{{ $canton }}">
    </div>
    <div class="col-md-6">
        <label>Distrito</label>
        <input type="text" onfocus="blur()" class="form-control" value="{{ $district }}">
    </div>
</div>

<div class="row"><div class="col-md-12">&nbsp;</div></div>

<div class="row">
    <div class="col-md-6">
        <label>Teléfono</label>
        <input type="text" onfocus="blur()" class="form-control" value="{{ $user->phone }}">
    </div>
    <div class="col-md-6">
        <label>Codigo Veterinario</label>
        <input type="text" onfocus="blur()" class="form-control" value="{{ $user->code }}">
    </div>
</div>

<div class="row"><div class="col-md-12">&nbsp;</div></div>

<div class="row">
    <div class="col-md-6">
        <label>Login con Facebook</label>
        <input type="text" onfocus="blur()" class="form-control" value="{{ ($user->facebook == 1) ? 'Si' : 'No' }}">
    </div>
    <div class="col-md-6">
        <label>Login con Google</label>
        <input type="text" onfocus="blur()" class="form-control" value="{{ ($user->google == 1) ? 'Si' : 'No' }}">
    </div>
</div>

<div class="row"><div class="col-md-12">&nbsp;</div></div>

<div class="row">
    <div class="col-md-6">
        <label>Registro</label>
        <input type="text" onfocus="blur()" class="form-control" value="{{ $user->created_at }}">
    </div>
    <div class="col-md-6">
        <label>Ultimo Ingreso</label>
        <input type="text" onfocus="blur()" class="form-control" value="{{ $user->last_login }}">
    </div>
</div>

@stop

@section('js')
    <script>
        function logWithUser() {
            bootbox.confirm({
                title: "Acceder como usuario",
                message: "Seguro que desea ingresar al panel de Vetegram como si fuera el usuario, cualquier accion se registrará como si fue hecha por el usuario",
                className: 'confirm_bootbox',
                buttons: {
                    confirm: {
                        label: '<i class="fa fa-times"></i> Si, Ingresar ',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: ' No, Cancelar ',
                        className: 'btn-danger'
                    }
                },
                callback: function (result) {
                    if(result){
                        $('.loadingTmp').css('display','block');
                            
                        location.href = '{{ route('wp.login.with.user', $user->id) }}';
                    }
                }
            });
        }
    </script>
@stop