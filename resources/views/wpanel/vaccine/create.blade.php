@extends('layouts.wpanel')

@section('title', 'Panel de administración - Vacunas')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="page-title">
            <h3>Agregar Item de vacuna</h3>
        </div>
    </div>
    <div class="col-md-6 text-right">
        <a class="btn btn-warning" href="{{ route('wp.vaccine.index') }}"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp;Regresar</a>
    </div>
</div>

<div id="container">
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    
    <form name="frm" id="frm" role="form" method="post" enctype="multipart/form-data" action="{{ route('wp.vaccine.store') }}" onsubmit="return validate();">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <label>Tipo:</label>
                <select name="type" id="type" class="form-control requerido">
                    <option value="1">Vacuna</option>
                    <option value="2">Desparasitante</option>
                </select>
            </div>
            <div class="col-md-6">
                <label>Intervalo en días:</label>
                <input type="number" name="interval" id="interval" class="form-control requerido" maxlength="255">
            </div>
        </div>

        <div class="row">
            <div class="col-md-12"><p>&nbsp;</p></div>
        </div>

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
            <div class="col-md-12">
                <br />
                <input type="submit" name="btnSubmit" id="btnSubmit" class="btn btn-primary" value="ACEPTAR">
                <input type="button" name="btnCancel" id="btnCancel" class="btn btn-danger" value="CANCELAR" onclick="window.open('{{ route('wp.vaccine.index') }}','_self');">
            </div>
        </div>
    </form>
</div>

@stop