@extends('layouts.wpanel')

@section('title', 'Panel de administración - Recetas')

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
            <h3>Tipos de tomas en recetas</h3>
        </div>
    </div>
    <div class="col-md-6 text-right">
        <a class="btn btn-primary" href="{{ route('wp.recipe-take.create') }}"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Agregar tipo de toma</a>
    </div>
</div>

<div id="container">
    <table id="tableList" class="table table-hover" style="width:100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>Titulo</th>
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
        window.WPANEL_RECIPE_TAKE_INDEX_CONFIG = {
            listUrl: "{{ route('wp.recipe-take.list') }}",
            enabledUrl: "{{ route('wp.recipe-take.enabled') }}",
            deleteUrl: "{{ route('wp.recipe-take.delete') }}",
            editBaseUrl: "{{ url('wpanel/recipe-take') }}",
            assets: {
                enabled: "{{ asset('img/wpanel/enabled.png') }}",
                disabled: "{{ asset('img/wpanel/disabled.png') }}",
                edit: "{{ asset('img/wpanel/edit.png') }}",
                delete: "{{ asset('img/wpanel/delete.png') }}"
            }
        };
    </script>
    <script src="{{ asset('js/wpanel/common.js') }}"></script>
    <script src="{{ asset('js/wpanel/recipe-take/index.js') }}"></script>
@stop
