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
        var dataTable = $('#tableList').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            order: [[0, 'desc']],
            ajax: "{{ route('wp.veterinary.list') }}",
            paging: true,
            pageLength: 25,
            columns: [
                {data:'id'},
                {data:'social_name'},
                {data:'company'},
                {data:'phone'},
                {data:'id', render: function(data, type, row) {
                    var btn = '';
                    if(row.pro == 1) {
                        btn += '<a href="{{ url('wpanel/veterinary/pro') }}/'+row.id+'"><img src="{{ asset('img/wpanel/menu.png') }}"></a>';
                    } else {
                        btn += '<a><img src="{{ asset('img/wpanel/locked.png') }}"></a>';
                    }
                    btn += '</a></span>';
                    return btn;
                }, 'orderable': false, 'searchable': false, 'className': "text-center"},
                {data:'id', render: function(data, type, row) {
                    if(row.expire_status == 1) {
                        var btn = '<span style="color: red;">'+row.expire+'</span>';    
                    } else {
                        var btn = '<span>'+row.expire+'</span>';
                    }
                    return btn;
                }, 'orderable': false, 'searchable': false, 'className': "text-center"},
                {data:'id', render: function(data, type, row) {
                    var btn = '<a href="{{ url('wpanel/veterinary/users') }}/'+row.id+'"><img src="{{ asset('img/wpanel/menu.png') }}"></a>';
                    return btn;
                }, 'orderable': false, 'searchable': false, 'className': "text-center"}
            ],
            language: {
                sLengthMenu: '',
                sZeroRecords: 'No se encontraron resultados',
                sEmptyTable: 'Ningún dato disponible en esta tabla',
                sInfo: 'Registro _START_ al _END_ de un total de _TOTAL_ registros',
                sInfoEmpty: 'Mostrando registros del 0 al 0 de un total de 0 registros',
                sInfoFiltered: '',
                sSearch: 'Buscar:',
                oPaginate: {
                    "sFirst": 'Primero',
                    "sLast":  'Último',
                    "sNext": 'Siguiente',
                    "sPrevious": 'Anterior',
                },
            }
        });
    </script>
@stop