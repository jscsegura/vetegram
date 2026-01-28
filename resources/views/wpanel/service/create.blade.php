@extends('layouts.wpanel')

@section('title', 'Panel de administración - Agregar Servicio')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="page-title">
            <h3>Agregar servicio del Landing</h3>
        </div>
    </div>
    <div class="col-md-6 text-right">
        <a class="btn btn-warning" href="{{ route('wp.service.index') }}"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp;Regresar</a>
    </div>
</div>

<div id="container">
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    
    <form name="frm" id="frm" role="form" method="post" enctype="multipart/form-data" action="{{ route('wp.service.store') }}" onsubmit="return validate();">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <label>Titulo Español(*):</label>
                <input type="text" name="title_es" id="title_es" class="form-control requerido" maxlength="255">
            </div>
            <div class="col-md-6">
                <label>Titulo Inglés(*):</label>
                <input type="text" name="title_en" id="title_en" class="form-control requerido" maxlength="255">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12"><p>&nbsp;</p></div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label>Descripción Español(*):</label>
                <input type="text" name="description_es" id="description_es" class="form-control" maxlength="255">
            </div>
            <div class="col-md-6">
                <label>Descripción Inglés(*):</label>
                <input type="text" name="description_en" id="description_en" class="form-control" maxlength="255">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12"><p>&nbsp;</p></div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label>Imagen:</label>
                <input type="file" name="photo" id="photo" class="requerido" accept="image/png, image/jpeg, image/jpg">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12"><p>&nbsp;</p></div>
        </div>
    
        <div class="row">
            <div class="col-md-12">
                <br />
                <input type="submit" name="btnSubmit" id="btnSubmit" class="btn btn-primary" value="ACEPTAR">
                <input type="button" name="btnCancel" id="btnCancel" class="btn btn-danger" value="CANCELAR" onclick="window.open('{{ route('wp.service.index') }}','_self');">
            </div>
        </div>
    </form>
</div>

@stop