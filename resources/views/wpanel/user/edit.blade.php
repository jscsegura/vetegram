@extends('layouts.wpanel')

@section('title', 'Panel de administración - Editar usuario')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="page-title">
            <h3>Editar usuario</h3>
        </div>
    </div>
    <div class="col-md-6 text-right">
        <a class="btn btn-warning" href="{{ route('wp.users.index') }}"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp;Regresar</a>
    </div>
</div>

<div id="container">
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    
    <form method="post" name="frm" id="frm" role="form" enctype="multipart/form-data" action="{{ url('wpanel/users/' . $user->id) }}" onsubmit="return validate(1);">
        
        {{ method_field('PUT') }}
        @csrf
        
        <div class="row">
            <div class="col-md-6">
                <label>Nombre (*):</label>
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
                <input type="text" name="email" id="email" class="form-control requeridoEmail" value="{{ $user->email }}" maxlength="255" onfocus="blur()">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12"><p>&nbsp;</p></div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label>Contraseña (Dejar en blanco para no cambiar):</label>
                <input type="password" name="txtPassword" id="txtPassword" value="" class="form-control" maxlength="100" autocomplete="off">
            </div>
            <div class="col-md-6">
                <label>Confirmar Contrase&ntilde;a (*):</label>
                <input type="password" name="txtPasswordConfirm" id="txtPasswordConfirm" value="" class="form-control" maxlength="100" autocomplete="off">
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
                        <img src="{{ asset('img/wpanel/deleteFile.png') }}" class="pointer" onclick="eliminateRegisterFile('{{ route('wp.users.deletefile') }}', 'id={{ $user->id }}', 'divPhoto');">
                    @else
                        <input type="file" name="photo" id="photo">
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12"><p>&nbsp;</p></div>
        </div>
    
        <label>Roles:</label>
        <?php
        foreach ($sections as $section) { ?>
            <label>
                <input type="checkbox" name="chkRole[]" id="chkRole{{ $section->id }}" value="{{ $section->id }}" @if(in_array($section->id, $rols)) checked @endif>
                {{ $section->title }}
            </label>
            <?php
        }
        ?>
    
        <div class="row">
            <div class="col-md-12">
                <br />
                <input type="submit" name="btnSubmit" id="btnSubmit" class="btn btn-primary" value="ACEPTAR">
                <input type="button" name="btnCancel" id="btnCancel" class="btn btn-danger" value="CANCELAR" onclick="window.open('{{ route('wp.users.index') }}','_self');">
            </div>
        </div>
    </form>
</div>

@stop