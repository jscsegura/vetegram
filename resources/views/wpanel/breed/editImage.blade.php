@extends('layouts.wpanel')

@section('title', 'Panel de administración - Razas de animales')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="page-title">
            <h3>Editar foto de Grooming <span style="font-size: 0.6em">({{ $breed->title_es }})</span></h3>
        </div>
    </div>
    <div class="col-md-6 text-right">
        <a class="btn btn-warning" href="{{ route('wp.animal-breed.images', $breed->id) }}"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp;Regresar</a>
    </div>
</div>

<div id="container">
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    
    <form method="post" name="frm" id="frm" role="form" enctype="multipart/form-data" action="{{ url('wpanel/animal-breed/update-image/' . $breed->id) }}" data-action="wpanel.validate" data-action-event="submit" data-action-args="default|$el">
        
        @csrf
        
        <div class="row">
            <div class="col-md-6">
                <label>Titulo Español(*):</label>
                <input type="text" name="title_es" id="title_es" class="form-control requerido" value="{{ $breed->title_es }}" maxlength="255">
            </div>
            <div class="col-md-6">
                <label>Titulo Inglés(*):</label>
                <input type="text" name="title_en" id="title_en" class="form-control requerido" value="{{ $breed->title_en }}" maxlength="255">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12"><p>&nbsp;</p></div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label>Imagen de Grooming(*):</label>
                <div id="divPhoto">
                    @if($row->image != "")
                        <img align="middle" src="{{ asset($row->image) }}" style="max-width: 200px;">
                        <img src="{{ asset('img/wpanel/deleteFile.png') }}" class="pointer" data-action="delete-file" data-url="{{ route('wp.animal-breed.deletefile') }}" data-payload="id={{ $row->id }}" data-target="divPhoto">
                    @else
                        <input type="file" name="photo" id="photo" class="requerido" accept="image/png, image/jpeg, image/jpg">
                    @endif
                </div>
            </div>
        </div>
    
        <div class="row">
            <div class="col-md-12">
                <br />
                <input type="submit" name="btnSubmit" id="btnSubmit" class="btn btn-primary" value="ACEPTAR">
                <input type="button" name="btnCancel" id="btnCancel" class="btn btn-danger" value="CANCELAR" data-action="navigate" data-url="{{ route('wp.animal-breed.images', $breed->id) }}">
            </div>
        </div>
    </form>
</div>

@stop