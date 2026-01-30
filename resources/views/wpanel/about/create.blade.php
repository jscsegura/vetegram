@extends('layouts.wpanel')

@section('title', 'Panel de administración - Nosotros')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="page-title">
            <h3>Agregar rubro sobre nosotros</h3>
        </div>
    </div>
    <div class="col-md-6 text-right">
        <a class="btn btn-warning" href="{{ route('wp.about.index') }}"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp;Regresar</a>
    </div>
</div>

<div id="container">
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    
    <form name="frm" id="frm" role="form" method="post" enctype="multipart/form-data" action="{{ route('wp.about.store') }}" data-action="wpanel.validate" data-action-event="submit" data-action-args="default|$el">
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
                <label>Icono:</label>
                <input type="text" name="icon" id="icon" class="form-control requerido" value="" data-action="open-icons">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12"><p>&nbsp;</p></div>
        </div>
    
        <div class="row">
            <div class="col-md-12">
                <br />
                <input type="submit" name="btnSubmit" id="btnSubmit" class="btn btn-primary" value="ACEPTAR">
                <input type="button" name="btnCancel" id="btnCancel" class="btn btn-danger" value="CANCELAR" data-action="navigate" data-url="{{ route('wp.about.index') }}">
            </div>
        </div>
    </form>
</div>

<div class="modal" id="iconModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Listado de iconos</h5>
            </div>
            <div class="modal-body">
                <input type="text" name="myInput" id="myInput" value="" class="form-control" placeholder="Filtrar">
                <br />
                <div class="table-responsive">
                    <table class="table table-hover" id="tableicons">
                        <thead>
                            <tr>
                                <th style="width: 75%;">Icono</th>
                                <th style="width: 25%;">Seleccionar</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyprinter">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('js')
    <script src="{{ asset('js/wpanel/library/icons.js') }}"></script>
@stop