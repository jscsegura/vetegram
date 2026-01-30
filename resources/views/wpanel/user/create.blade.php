@extends('layouts.wpanel')

@section('title', 'Panel de administración - Agregar usuario')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="page-title">
            <h3>Agregar usuario</h3>
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
    
    <form name="frm" id="frm" role="form" method="post" enctype="multipart/form-data" action="{{ route('wp.users.store') }}" data-action="wpanel.validate" data-action-event="submit" data-action-args="password|$el">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <label>Nombre (*):</label>
                <input type="text" name="name" id="name" class="form-control requerido" maxlength="255">
            </div>
            <div class="col-md-6">
                <label>Apellidos:</label>
                <input type="text" name="lastname" id="lastname" class="form-control" maxlength="255">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12"><p>&nbsp;</p></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label>Correo (*):</label>
                <input type="text" name="email" id="email" class="form-control requeridoEmail" maxlength="255" value="">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12"><p>&nbsp;</p></div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label>Contraseña (*):</label>
                <input type="password" name="txtPassword" id="txtPassword" class="form-control requerido" maxlength="100" autocomplete="off">
            </div>
            <div class="col-md-6">
                <label>Confirmar Contrase&ntilde;a (*):</label>
                <input type="password" name="txtPasswordConfirm" id="txtPasswordConfirm" class="form-control requerido" maxlength="100" autocomplete="off">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12"><p>&nbsp;</p></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label>Fotografia:</label>
                <input type="file" name="photo" id="photo">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12"><p>&nbsp;</p></div>
        </div>
    
        <label>Roles:</label>
        @foreach ($sections as $section)
            <label>
                <input type="checkbox" name="chkRole[]" id="chkRole{{ $section->id }}" value="{{ $section->id }}">
                {{ $section->title }}
            </label>
        @endforeach
    
        <div class="row">
            <div class="col-md-12">
                <br />
                <input type="submit" name="btnSubmit" id="btnSubmit" class="btn btn-primary" value="ACEPTAR">
                <input type="button" name="btnCancel" id="btnCancel" class="btn btn-danger" value="CANCELAR" data-action="navigate" data-url="{{ route('wp.users.index') }}">
            </div>
        </div>
    </form>
</div>

@stop