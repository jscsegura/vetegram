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
        <input type="text" name="auditid" id="auditid" value="" class="form-control" onkeydown="enterOnlyNumbers(event);" maxlength="11">
    </div>
    <div class="col-md-2">
        <label>&nbsp;</label>
        <a onclick="filter();" class="btn btn-primary">Filtrar</a>
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
        var vartype = '';
        var varevent = '';
        var auditid = '';
        var dataTable = $('#tableList').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            order: [[0, 'desc']],
            ajax: "{{ url('wpanel/logs/list') }}/?type=" + vartype + "&event=" + varevent + "&auditid=" + auditid,
            paging: true,
            pageLength: 25,
            columns: [
                {data:'id'},
                {data:'event'},
                {data:'auditable_type'},
                {data:'auditable_id'},
                {data:'author'},
                {data:'created_at'},
                {data:'ip_address'},
                {data:'id', render: function(data, type, row) {
                    var btn = '<a data-id="' + row.id + '" data-toggle="modal" data-target="#detailModal" onclick="detail(this);"><img src="{{ asset('img/wpanel/menu.png') }}" data-toggle="tooltip" data-placement="top" title="Detalles"></a>';
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

        var verDetall = function(tbody, table){
            table.on('draw', function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
        }
        verDetall("#tableList tbody",dataTable);

        function filter() {
            vartype = $('#type').val();
            varevent = $('#event').val();
            auditid = $('#auditid').val();
            dataTable.ajax.url("{{ url('wpanel/logs/list') }}/?type=" + vartype + "&event=" + varevent + "&auditid=" + auditid);
            dataTable.draw();
        }

        function detail(obj) {
            var id = $(obj).attr('data-id');

            $('.modal-body').html('<center>Cargando...</center>');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
                }
            });
            
            $.post('{{ route('wp.logs.detail') }}', {id:id},
                function (data) {
                    var url = '';
                    if(data.url != '') {
                        url = '<div class="row">'+
                                    '<div class="col-md-12 text-center">'+
                                        '<label>Url: ' + data.url + '</label>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="row">'+
                                    '<div class="col-md-12"><p>&nbsp;</p></div>'+
                                '</div>';
                    }
                    var txt = '<div class="row">'+
                                    '<div class="col-md-12 text-center">'+
                                        '<strong>UserId ' + data.userid + ' | ' + data.name + ' | ' + data.email + ' | Modulo: ' + data.module + '</strong>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="row">'+
                                    '<div class="col-md-12"><p>&nbsp;</p></div>'+
                                '</div>'+
                                url +
                                '<div class="table-responsive-lg">'+
                                    '<table class="table">'+
                                        '<thead>'+
                                            '<tr>'+
                                                '<th scope="col" style="width: 50%;">Registro viejo</th>'+
                                                '<th scope="col" style="width: 50%;">Registro nuevo</th>'+
                                            '</tr>'+
                                        '</thead>'+
                                        '<tr>'+
                                            '<td>'+
                                                data.oldRegister +
                                            '</td>'+
                                            '<td>'+
                                                data.newRegister +
                                            '</td>'+
                                        '</tr>'+
                                    '</table>'+
                                '</div>';

                    $('.modal-body').html(txt);
                }
            );
        }
    </script>
@stop