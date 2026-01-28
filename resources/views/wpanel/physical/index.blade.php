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
            <h3>Categorias de examen fisico</h3>
        </div>
    </div>
    <div class="col-md-6 text-right">
        <a class="btn btn-primary" href="{{ route('wp.physical.create') }}"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Agregar categoria</a>
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
        var dataTable = $('#tableList').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            order: [[0, 'desc']],
            ajax: "{{ route('wp.physical.list') }}",
            paging: true,
            pageLength: 25,
            columns: [
                {data:'id'},
                {data:'title_es'},
                {data:'id', render: function(data, type, row) {
                    var btn = '<span id="enabledRow'+row.id+'"><a data="' + row.id + '" onclick="enabledRow(this);">';
                    if(row.enabled == 1) {
                        btn += '<img src="{{ asset('img/wpanel/enabled.png') }}">';
                    } else {
                        btn += '<img src="{{ asset('img/wpanel/disabled.png') }}">';
                    }
                    btn += '</a></span>';
                    return btn;
                }, 'orderable': false, 'searchable': false, 'className': "text-center"},
                {data:'id', render: function(data, type, row) {
                    var btn = '<a href="{{ url('wpanel/physical/options') }}/'+row.id+'"><img src="{{ asset('img/wpanel/menu.png') }}"></a>';
                    return btn;
                }, 'orderable': false, 'searchable': false, 'className': "text-center"},
                {data:'id', render: function(data, type, row) {
                    var btn = '<a href="{{ url('wpanel/physical') }}/'+row.id+'/edit"><img src="{{ asset('img/wpanel/edit.png') }}"></a>';
                    return btn;
                }, 'orderable': false, 'searchable': false, 'className': "text-center"},
                {data:'id', render: function(data, type, row) {
                    var btn = '<a data="' + row.id + '" onclick="deleteRow(this);"><img src="{{ asset('img/wpanel/delete.png') }}"></a>';
                    return btn;
                }, 'orderable': false, 'searchable': false, 'className': "text-center"},
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

        function enabledRow(obj) {
            var id = $(obj).attr('data');
            enabledRegister('{{ route('wp.physical.enabled') }}', 'id=' + id, 'enabledRow' + id);
        }
        function deleteRow(obj) {
            var id = $(obj).attr('data');
            var row = $(obj).parent().parent('tr');
            eliminateRegister('{{ route('wp.physical.delete') }}', 'id=' + id, row);
        }
    </script>
@stop