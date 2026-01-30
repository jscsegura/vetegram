@extends('layouts.wpanel')

@section('title', 'Panel de administración - Razas de animales')

@section('css')
<style>
    #tableList_filter input[type=search] {
        width: 88%;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="page-title">
            <h3>Bit&aacute;cora de logs</h3>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <label>Evento</label>
        <select class="form-control" name="event" id="event">
            <option value="">Todos</option>
            <option value="created">Insertar</option>
            <option value="updated">Actualizar</option>
            <option value="deleted">Eliminar</option>
            <option value="restored">Restaurar</option>
            <option value="login">Login</option>
        </select>
    </div>
    <div class="col-md-4">
        <label>Tipo de movimiento</label>
        <select class="form-control" name="type" id="type">
            <option value="">Todos</option>
            @foreach ($types as $type)
            @php
            $model = $type->auditable_type;
            @endphp
            <option value="{{ $type->auditable_type }}">{{ ($model != 'Login') ? $model::getModelName() : 'Login' }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <label>Id del registro</label>
        <input type="text" name="auditid" id="auditid" value="" class="form-control" data-action="vetegramHelpers.enterOnlyNumbers" data-action-event="keydown" data-action-args="$event" maxlength="11">
    </div>
    <div class="col-md-2">
        <label>&nbsp;</label>
        <a data-action="filter-logs" class="btn btn-primary">Filtrar</a>
    </div>
</div>   

<div class="row">
    <div class="col-md-12">
        <p>&nbsp;</p>
    </div>
</div>   

<div id="container">
    <table id="tableList" class="table table-hover" style="width:100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>Evento</th>
                <th>Tipo</th>
                <th>Id registro</th>
                <th>Autor</th>
                <th>Creado</th>
                <th>IP</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>

<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Detalle de auditoria</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
</div>

@stop

@section('js')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap.min.css">
    <link href="https://cdn.datatables.net/v/bs/dt-1.13.4/datatables.min.css" rel="stylesheet"/>
    <script src="https://cdn.datatables.net/v/bs/dt-1.13.4/datatables.min.js"></script>

    <script>
        window.WPANEL_LOGS_INDEX_CONFIG = {
            listBaseUrl: "{{ url('wpanel/logs/list') }}",
            detailUrl: "{{ route('wp.logs.detail') }}",
            assets: {
                menu: "{{ asset('img/wpanel/menu.png') }}"
            }
        };
    </script>
    <script src="{{ asset('js/wpanel/common.js') }}"></script>
    <script src="{{ asset('js/wpanel/logs/index.js') }}"></script>
@stop
