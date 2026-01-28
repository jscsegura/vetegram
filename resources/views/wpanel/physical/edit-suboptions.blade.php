@extends('layouts.wpanel')

@section('title', 'Panel de administración - Editar examen fisico')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="page-title">
            <h3>Editar sub opción</h3>
        </div>
    </div>
    <div class="col-md-6 text-right">
        <a class="btn btn-warning" href="{{ route('wp.physical.Suboptions', $option->id_option) }}"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp;Regresar</a>
    </div>
</div>

<div id="container">
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    
    <form method="post" name="frm" id="frm" role="form" enctype="multipart/form-data" action="{{ url('wpanel/physical/update-suboptions/' . $option->id) }}" onsubmit="return validate();">
        
        {{ method_field('PUT') }}

        @csrf
        
        <div class="row">
            <div class="col-md-6">
                <label>Titulo Español(*):</label>
                <input type="text" name="title_es" id="title_es" class="form-control requerido" value="{{ $option->title_es }}" maxlength="255">
            </div>
            <div class="col-md-6">
                <label>Titulo Inglés(*):</label>
                <input type="text" name="title_en" id="title_en" class="form-control requerido" value="{{ $option->title_en }}" maxlength="255">
            </div>
        </div>

        <div class="row">
            <div class="col-md-12"><p>&nbsp;</p></div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label>Tipo de opción (*):</label>
                <select name="type" id="type" class="form-control requerido">
                    <option value="1" @if($option->type == 1) selected @endif>Campo de texto</option>
                    <option value="2" @if($option->type == 2) selected @endif>Campo numerico</option>
                    <option value="3" @if($option->type == 3) selected @endif>Seleccion unica</option>
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
                <input type="button" name="btnCancel" id="btnCancel" class="btn btn-danger" value="CANCELAR" onclick="window.open('{{ route('wp.physical.Suboptions', $option->id_option) }}','_self');">
            </div>
        </div>
    </form>
</div>

@stop