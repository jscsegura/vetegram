@extends('layouts.wpanel')

@section('title', 'Panel de administración - Agregar Rubro')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="page-title">
            <h3>Agregar rubro planes</h3>
        </div>
    </div>
    <div class="col-md-6 text-right">
        <a class="btn btn-warning" href="{{ route('wp.setting.pro') }}"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp;Regresar</a>
    </div>
</div>

<div id="container">
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    
    <form name="frm" id="frm" role="form" method="post" enctype="multipart/form-data" action="{{ route('wp.setting.prostore') }}" onsubmit="return validate();">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <label>Rubro Español(*):</label>
                <input type="text" name="title_es" id="title_es" class="form-control requerido" maxlength="255">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12"><p>&nbsp;</p></div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <label>Rubro Inglés(*):</label>
                <input type="text" name="title_en" id="title_en" class="form-control requerido" maxlength="255">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12"><p>&nbsp;</p></div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <label>Plan (*):</label>
                <select name="pro" id="pro" class="form-control requerido">
                    <option value="">Seleccione el plan</option>
                    <option value="0">Plan Gratis</option>
                    <option value="1">Plan PRO</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12"><p>&nbsp;</p></div>
        </div>
    
        <div class="row">
            <div class="col-md-12">
                <br />
                <input type="submit" name="btnSubmit" id="btnSubmit" class="btn btn-primary" value="ACEPTAR">
                <input type="button" name="btnCancel" id="btnCancel" class="btn btn-danger" value="CANCELAR" onclick="window.open('{{ route('wp.setting.pro') }}','_self');">
            </div>
        </div>
    </form>
</div>

@stop