@extends('layouts.wpanel')

@section('title', 'Panel de administración - Clientes')

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
            <h3>Clientes (Dueños de mascotas)</h3>
        </div>
    </div>
</div>

<div id="container">
    <table id="tableList" class="table table-hover" style="width:100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Detalle</th>
                <th>Validado</th>
                <th>Bloqueado</th>
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
        window.WPANEL_CLIENT_INDEX_CONFIG = {
            listUrl: "{{ route('wp.client.list') }}",
            lockUrl: "{{ route('wp.client.lock') }}",
            enabledUrl: "{{ route('wp.client.enabled') }}",
            detailBaseUrl: "{{ url('wpanel/client/detail') }}",
            confirmTitle: "Validar correo",
            confirmMessage: "\u00bfDesea confirmar la direcci\u00f3n de correo electronica del usuario como v\u00e1lida?",
            assets: {
                menu: "{{ asset('img/wpanel/menu.png') }}",
                active: "{{ asset('img/wpanel/active.png') }}",
                deactivated: "{{ asset('img/wpanel/deactivated.png') }}",
                enabled: "{{ asset('img/wpanel/enabled.png') }}",
                disabled: "{{ asset('img/wpanel/disabled.png') }}"
            }
        };
    </script>
    <script src="{{ asset('js/wpanel/common.js') }}"></script>
    <script src="{{ asset('js/wpanel/client/index.js') }}"></script>
@stop
