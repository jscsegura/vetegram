@extends('layouts.wpanel')

@section('title', 'Panel de administración - Colegiados')

@section('css')
<style>
    #tableList_filter input[type=search] {
        width: 88%;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="page-title">
            <h3>Actualizar lista de colegiados</h3>
        </div>
    </div>
    <div class="col-md-6 text-right">
        <a class="btn btn-primary" href="{{ route('wp.college.format') }}"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;Descargar formato</a>
    </div>
</div>

<div id="container">
    <div class="row">
        <div class="col-md-12">
            <form name="form" id="form" method="post" action="{{ route('wp.college.store') }}" enctype="multipart/form-data" onsubmit="return validate();">
                @csrf

                <div class="row">
                    <div class="col-md-12">
                        <label>Documento Excel</label>
                        <input type="file" name="file" id="file" class="custom-file-input requerido" accept=".xlsx,.xls">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">&nbsp;</div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label>Acciones</label>
                        <select name="action" id="action" class="form-control">
                            <option value="0">Agregar/actualizar los registros sin eliminar los demas</option>
                            <option value="1">Eliminar todos los existentes y agregar los registros</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">&nbsp;</div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <br />
                        <input type="submit" name="btnSubmit" id="btnSubmit" class="btn btn-primary" value="ACEPTAR">
                        <input type="button" name="btnCancel" id="btnCancel" class="btn btn-danger" value="CANCELAR" onclick="window.open('{{ route('wp.college.index') }}','_self');">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@stop

@section('js')
<script>

    </script>
@stop