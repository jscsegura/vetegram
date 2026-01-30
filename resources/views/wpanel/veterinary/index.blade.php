@extends('layouts.wpanel')

@section('title', 'Panel de administración - Veterinarias')

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
            <h3>Veterinarias</h3>
        </div>
    </div>
</div>

<div id="container">
    <table id="tableList" class="table table-hover" style="width:100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>Razón Social</th>
                <th>Clínica</th>
                <th>Teléfono</th>
                <th>Pro</th>
                <th>Vence</th>
                <th>Usuarios</th>
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
        window.WPANEL_VETERINARY_INDEX_CONFIG = {
            listUrl: "{{ route('wp.veterinary.list') }}",
            proBaseUrl: "{{ url('wpanel/veterinary/pro') }}",
            usersBaseUrl: "{{ url('wpanel/veterinary/users') }}",
            assets: {
                menu: "{{ asset('img/wpanel/menu.png') }}",
                locked: "{{ asset('img/wpanel/locked.png') }}"
            }
        };
    </script>
    <script src="{{ asset('js/wpanel/common.js') }}"></script>
    <script src="{{ asset('js/wpanel/veterinary/index.js') }}"></script>
@stop
