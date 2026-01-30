@extends('layouts.wpanel')

@section('title', 'Panel de administración - Editar Especialidad')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="page-title">
            <h3>Editar slider del Landing</h3>
        </div>
    </div>
    <div class="col-md-6 text-right">
        <a class="btn btn-warning" href="{{ route('wp.slider.index') }}"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp;Regresar</a>
    </div>
</div>

<div id="container">
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    
    <form method="post" name="frm" id="frm" role="form" enctype="multipart/form-data" action="{{ url('wpanel/slider/' . $slider->id) }}" data-action="wpanel.validate" data-action-event="submit" data-action-args="default|$el">
        
        {{ method_field('PUT') }}
        @csrf
        
        <div class="row">
            <div class="col-md-6">
                <label>Titulo Español(*):</label>
                <input type="text" name="title_es" id="title_es" class="form-control requerido" value="{{ $slider->title_es }}" maxlength="255">
            </div>
            <div class="col-md-6">
                <label>Titulo Inglés(*):</label>
                <input type="text" name="title_en" id="title_en" class="form-control requerido" value="{{ $slider->title_en }}" maxlength="255">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12"><p>&nbsp;</p></div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label>Descripción Español(*):</label>
                <input type="text" name="description_es" id="description_es" class="form-control" value="{{ $slider->description_es }}" maxlength="255">
            </div>
            <div class="col-md-6">
                <label>Descripción Inglés(*):</label>
                <input type="text" name="description_en" id="description_en" class="form-control" value="{{ $slider->description_en }}" maxlength="255">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12"><p>&nbsp;</p></div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label>Imagen (1920px * 800px):</label>
                <div id="divPhoto">
                    @if($slider->image != "")
                        <img align="middle" src="{{ asset('files/' . $slider->image) }}" style="max-width: 200px;">
                        <img src="{{ asset('img/wpanel/deleteFile.png') }}" class="pointer" data-action="delete-file" data-url="{{ route('wp.slider.deletefile') }}" data-payload="id={{ $slider->id }}" data-target="divPhoto">
                    @else
                        <input type="file" name="photo" id="photo" class="requerido" accept="image/png, image/jpeg, image/jpg">
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <label>Imagen (800px * 950px):</label>
                <div id="divPhoto2">
                    @if($slider->image_movil != "")
                        <img align="middle" src="{{ asset('files/' . $slider->image_movil) }}" style="max-width: 200px;">
                        <img src="{{ asset('img/wpanel/deleteFile.png') }}" class="pointer" data-action="delete-file" data-url="{{ route('wp.slider.deletefileMovil') }}" data-payload="id={{ $slider->id }}" data-target="divPhoto2">
                    @else
                        <input type="file" name="photomovil" id="photomovil" class="requerido" accept="image/png, image/jpeg, image/jpg">
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
                <input type="submit" name="btnSubmit" id="btnSubmit" class="btn btn-primary" value="ACEPTAR">
                <input type="button" name="btnCancel" id="btnCancel" class="btn btn-danger" value="CANCELAR" data-action="navigate" data-url="{{ route('wp.slider.index') }}">
            </div>
        </div>
    </form>
</div>

@stop