@extends('layouts.wpanel')

@section('title', 'Panel de administración - Examen fisico')

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
            <h3>Opciones de examen fisico</h3>
        </div>
    </div>
    <div class="col-md-6 text-right">
        <a class="btn btn-warning" href="{{ route('wp.physical.index') }}"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp;Regresar</a>
        <a class="btn btn-primary" href="{{ route('wp.physical.createOptions', $categoryId) }}"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Agregar opción</a>
    </div>
</div>

<div id="container">
    <table id="tableList" class="table table-hover" style="width:100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>Titulo</th>
                <th>Habilitar</th>
                <th>Opciones</th>
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
        window.WPANEL_PHYSICAL_OPTIONS_CONFIG = {
            listUrl: "{{ route('wp.physical.listOptions', $categoryId) }}",
            enabledUrl: "{{ route('wp.physical.enabledOptions') }}",
            deleteUrl: "{{ route('wp.physical.deleteOptions') }}",
            suboptionsBaseUrl: "{{ url('wpanel/physical/suboptions') }}",
            editBaseUrl: "{{ url('wpanel/physical') }}",
            assets: {
                menu: "{{ asset('img/wpanel/menu.png') }}",
                enabled: "{{ asset('img/wpanel/enabled.png') }}",
                disabled: "{{ asset('img/wpanel/disabled.png') }}",
                edit: "{{ asset('img/wpanel/edit.png') }}",
                delete: "{{ asset('img/wpanel/delete.png') }}"
            }
        };
    </script>
    <script src="{{ asset('js/wpanel/common.js') }}"></script>
    <script src="{{ asset('js/wpanel/physical/options.js') }}"></script>
@stop
