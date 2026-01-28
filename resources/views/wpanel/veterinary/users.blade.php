@extends('layouts.wpanel')

@section('title', 'Panel de administración - Usuarios de veterianaria')

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
            <h3>Usuarios de la veterinaria</h3>
        </div>
    </div>
    <div class="col-md-6 text-right">
        <a class="btn btn-default" id="btnplus" data-plus="0" onclick="showPlus(this);"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Ver más detalles</a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <label>Veterinaria</label>
        <input type="text" onfocus="blur()" class="form-control" value="{{ $vet->company }}">
    </div>
    <div class="col-md-6">
        <label>Razón Social</label>
        <input type="text" onfocus="blur()" class="form-control" value="{{ $vet->social_name }}">
    </div>
</div>

<div class="row"><div class="col-md-12">&nbsp;</div></div>

<div id="moreDetails" style="display: none;">
    <div class="row">
        <div class="col-md-6">
            <label>País</label>
            <input type="text" onfocus="blur()" class="form-control" value="{{ (isset($country->title)) ? $country->title : '' }}">
        </div>
        <div class="col-md-6">
            <label>Provincia</label>
            <input type="text" onfocus="blur()" class="form-control" value="{{ $province }}">
        </div>
    </div>

    <div class="row"><div class="col-md-12">&nbsp;</div></div>

    <div class="row">
        <div class="col-md-6">
            <label>Cantón</label>
            <input type="text" onfocus="blur()" class="form-control" value="{{ $canton }}">
        </div>
        <div class="col-md-6">
            <label>Distrito</label>
            <input type="text" onfocus="blur()" class="form-control" value="{{ $district }}">
        </div>
    </div>

    <div class="row"><div class="col-md-12">&nbsp;</div></div>

    <div class="row">
        <div class="col-md-12">
            <label>Dirección</label>
            <input type="text" onfocus="blur()" class="form-control" value="{{ $vet->address }}">
        </div>
    </div>

    <div class="row"><div class="col-md-12">&nbsp;</div></div>

    <div class="row">
        <div class="col-md-6">
            <label>Teléfono</label>
            <input type="text" onfocus="blur()" class="form-control" value="{{ $vet->phone }}">
        </div>
        <div class="col-md-6">
            <label>Registro</label>
            <input type="text" onfocus="blur()" class="form-control" value="{{ $vet->created_at }}">
        </div>
    </div>

    <div class="row"><div class="col-md-12">&nbsp;</div></div>

    <div class="row">
        <div class="col-md-6">
            <label>Especialidades</label>
            @foreach ($specialties as $specialty)
                <button type="button" class="btn btn-white">{{ $specialty->title_es }}</button>
            @endforeach
        </div>
        <div class="col-md-6">
            <label>Idiomas</label>
            @foreach ($langs as $lang)
                <button type="button" class="btn btn-white">{{ $lang->title_es }}</button>    
            @endforeach
        </div>
    </div>
</div>

<div class="row"><div class="col-md-12">&nbsp;</div></div>

<div id="container">
    <table id="tableList" class="table table-hover" style="width:100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>Perfil</th>
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
            ajax: "{{ route('wp.veterinary.listUsers') }}/?id={{ $id }}",
            paging: true,
            pageLength: 25,
            columns: [
                {data:'id'},
                {data:'rol_id', render: function(data, type, row) {
                    var txt = '';
                    switch (row.rol_id) {
                        case 3: txt = 'Administrador';
                            break;
                        case 4: txt = 'Veterinario';
                            break;
                        case 5: txt = 'Cajero';
                            break;
                        case 6: txt = 'Groomer';
                            break;
                        case 7: txt = 'Contador';
                            break;
                        default: txt = 'NA';
                            break;
                    }
                    return txt;
                }, 'orderable': false, 'searchable': false, 'className': "text-left"},
                {data:'name'},
                {data:'email'},
                {data:'phone'},
                {data:'id', render: function(data, type, row) {
                    var btn = '<a href="{{ url('wpanel/veterinary/detail') }}/'+row.id+'"><img src="{{ asset('img/wpanel/menu.png') }}"></a>';
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
            enabledRegister('{{ route('wp.veterinary.lock') }}', 'id=' + id, 'lockRow' + id);
        }

        function showPlus(obj) {
            var plus = $(obj).attr('data-plus');

            if(plus == '0') {
                $(obj).attr('data-plus', '1');
                $('#btnplus').html('<i class="fa fa-minus" aria-hidden="true"></i>&nbsp;Ocultar detalles');
                $('#moreDetails').show(1000);
            }else{
                $(obj).attr('data-plus', '0');
                $('#btnplus').html('<i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Ver más detalles');
                $('#moreDetails').hide(1000);
            }
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
                        enabledRegister('{{ route('wp.veterinary.enabled') }}', 'id=' + id, 'enabledRow' + id);
                    }
                }
            });
        }
    </script>
@stop