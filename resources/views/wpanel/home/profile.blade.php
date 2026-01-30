@extends('layouts.wpanel')

@section('title', 'Panel de administración')

@section('content')
<div class="page-title">
    <h3>Editar mi perfil</h3>
</div>

<div id="container">
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    
    <form method="post" name="frm" id="frm" method="post" enctype="multipart/form-data" action="{{ route('wp.home.save.profile') }}" data-action="wpanel.validate" data-action-event="submit" data-action-args="password|$el">
        
        @csrf
        
        <div class="row">
            <div class="col-md-6">
                <label>Nombre:</label>
                <input type="text" name="name" id="name" class="form-control requerido" value="{{ $user->name }}" maxlength="255">
            </div>
            <div class="col-md-6">
                <label>Apellidos:</label>
                <input type="text" name="lastname" id="lastname" class="form-control" value="{{ $user->lastname }}" maxlength="255">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12"><p>&nbsp;</p></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label>Correo:</label>
                <input type="text" name="email" id="email" class="form-control" value="{{ $user->email }}" maxlength="255" readonly>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12"><p>&nbsp;</p></div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label>Contraseña (Dejar en blanco para no cambiar):</label>
                <input type="password" name="txtPassword" id="txtPassword" class="form-control" maxlength="100" autocomplete="off">
            </div>
            <div class="col-md-6">
                <label>Confirmar Contrase&ntilde;a (*):</label>
                <input type="password" name="txtPasswordConfirm" id="txtPasswordConfirm" class="form-control" maxlength="100" autocomplete="off">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12"><p>&nbsp;</p></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label>Fotografia:</label>
                <div id="divPhoto">
                    @if($user->photo != "")
                        <img align="middle" src="{{ asset('files/user/image/' . $user->photo) }}" style="max-width: 200px;">
                        <img src="{{ asset('img/wpanel/deleteFile.png') }}" class="pointer" data-action="delete-file" data-url="{{ route('wp.users.deletefile') }}" data-payload="id={{ $user->id }}" data-target="divPhoto">
                    @else
                        <input type="file" name="photo" id="photo">
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12"><p>&nbsp;</p></div>
        </div>
    
        <div class="row">
            <div class="col-md-12">
                <br />
                <input type="submit" name="btnSubmit" id="btnSubmit" class="btn btn-primary" value="ACTUALIZAR">
            </div>
        </div>
    </form>
</div>

@stop