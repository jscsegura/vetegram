@extends('layouts.wpanel')

@section('title', 'Panel de administración - Tipos de animales')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="page-title">
            <h3>Agregar Raza de animal <span style="font-size: 0.6em">({{ $row->title_es }})</span></h3>
        </div>
    </div>
    <div class="col-md-6 text-right">
        <a class="btn btn-warning" href="{{ route('wp.animal-breed.index', $type) }}"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp;Regresar</a>
    </div>
</div>

<div id="container">
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    
    <form name="frm" id="frm" role="form" method="post" enctype="multipart/form-data" action="{{ route('wp.animal-breed.store') }}" data-action="wpanel.validate" data-action-event="submit" data-action-args="default|$el">
        @csrf

        <input type="hidden" name="type" id="type" value="{{ $type }}">

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
                <input type="button" name="btnCancel" id="btnCancel" class="btn btn-danger" value="CANCELAR" data-action="navigate" data-url="{{ route('wp.animal-breed.index', $type) }}">
            </div>
        </div>
    </form>
</div>

@stop