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
        var dataTable = $('#tableList').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            order: [[0, 'desc']],
            ajax: "{{ route('wp.client.list') }}",
            paging: true,
            pageLength: 25,
            columns: [
                {data:'id'},
                {data:'name'},
                {data:'email'},
                {data:'phone'},
                {data:'id', render: function(data, type, row) {
                    var btn = '<a href="{{ url('wpanel/client/detail') }}/'+row.id+'"><img src="{{ asset('img/wpanel/menu.png') }}"></a>';
                    return btn;
                }, 'orderable': false, 'searchable': false, 'className': "text-center"},
                {data:'id', render: function(data, type, row) {
                    var btn = '';
                    if(row.enabled == 1) {
                        btn += '<span id="enabledRow'+row.id+'"><a data="' + row.id + '">';
                        btn += '<img width="25px" src="{{ asset('img/wpanel/active.png') }}">';
                        btn += '</a></span>';
                    } else {
                        btn += '<span id="enabledRow'+row.id+'"><a data="' + row.id + '" onclick="activeRow(this);">';
                        btn += '<img width="25px" src="{{ asset('img/wpanel/deactivated.png') }}">';
                        btn += '</a></span>';
                    }
                    
                    return btn;
                }, 'orderable': false, 'searchable': false, 'className': "text-center"},
                {data:'id', render: function(data, type, row) {
                    var btn = '<span id="lockRow'+row.id+'"><a data="' + row.id + '" onclick="enabledRow(this);">';
                    if(row.lock == 1) {
                        btn += '<img src="{{ asset('img/wpanel/enabled.png') }}">';
                    } else {
                        btn += '<img src="{{ asset('img/wpanel/disabled.png') }}">';
                    }
                    btn += '</a></span>';
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
            enabledRegister('{{ route('wp.client.lock') }}', 'id=' + id, 'lockRow' + id);
        }

        function activeRow(obj) {
            var id = $(obj).attr('data');
            
            bootbox.confirm({
                title: "Validar correo",
                message: "¿Desea confirmar la dirección de correo electronica del usuario como válida?",
                className: 'confirm_bootbox',
                buttons: {
                    confirm: {
                        label: '<i class="fa fa-times"></i> Si, Validar ',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: ' No, Cancelar ',
                        className: 'btn-danger'
                    }
                },
                callback: function (result) {
                    if(result){
                        enabledRegister('{{ route('wp.client.enabled') }}', 'id=' + id, 'enabledRow' + id);
                    }
                }
            });
        }
    </script>
@stop