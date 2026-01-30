@extends('layouts.wpanel')

@section('title', 'Panel de administración - Vacunas')

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
            <h3>Items de vacunas y desparacitantes</h3>
        </div>
    </div>
    <div class="col-md-6 text-right">
        <a class="btn btn-primary" href="{{ route('wp.vaccine.create') }}"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Agregar item</a>
    </div>
</div>

<div id="container">
    <table id="tableList" class="table table-hover" style="width:100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>Tipo</th>
                <th>Titulo</th>
                <th>Intervalo</th>
                <th>Habilitar</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>

@stop

@section('js')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap.min.css">
    <link href="https://cdn.datatables.net/v/bs/dt-1.13.4/datatables.min.css" rel="stylesheet"/>
    <script src="https://cdn.datatables.net/v/bs/dt-1.13.4/datatables.min.js"></script>

    <script>
        window.WPANEL_VACCINE_INDEX_CONFIG = {
            listUrl: "{{ route('wp.vaccine.list') }}",
            enabledUrl: "{{ route('wp.vaccine.enabled') }}",
            deleteUrl: "{{ route('wp.vaccine.delete') }}",
            editBaseUrl: "{{ url('wpanel/vaccine') }}",
            assets: {
                enabled: "{{ asset('img/wpanel/enabled.png') }}",
                disabled: "{{ asset('img/wpanel/disabled.png') }}",
                edit: "{{ asset('img/wpanel/edit.png') }}",
                delete: "{{ asset('img/wpanel/delete.png') }}"
            }
        };
    </script>
    <script src="{{ asset('js/wpanel/common.js') }}"></script>
    <script src="{{ asset('js/wpanel/vaccine/index.js') }}"></script>
@stop
