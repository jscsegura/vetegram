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
        <a class="btn btn-default" id="btnplus" data-plus="0" data-action="show-plus"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Ver más detalles</a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <label>Veterinaria</label>
        <input type="text" readonly class="form-control" value="{{ $vet->company }}">
    </div>
    <div class="col-md-6">
        <label>Razón Social</label>
        <input type="text" readonly class="form-control" value="{{ $vet->social_name }}">
    </div>
</div>

<div class="row"><div class="col-md-12">&nbsp;</div></div>

<div id="moreDetails" style="display: none;">
    <div class="row">
        <div class="col-md-6">
            <label>País</label>
            <input type="text" readonly class="form-control" value="{{ (isset($country->title)) ? $country->title : '' }}">
        </div>
        <div class="col-md-6">
            <label>Provincia</label>
            <input type="text" readonly class="form-control" value="{{ $province }}">
        </div>
    </div>

    <div class="row"><div class="col-md-12">&nbsp;</div></div>

    <div class="row">
        <div class="col-md-6">
            <label>Cantón</label>
            <input type="text" readonly class="form-control" value="{{ $canton }}">
        </div>
        <div class="col-md-6">
            <label>Distrito</label>
            <input type="text" readonly class="form-control" value="{{ $district }}">
        </div>
    </div>

    <div class="row"><div class="col-md-12">&nbsp;</div></div>

    <div class="row">
        <div class="col-md-12">
            <label>Dirección</label>
            <input type="text" readonly class="form-control" value="{{ $vet->address }}">
        </div>
    </div>

    <div class="row"><div class="col-md-12">&nbsp;</div></div>

    <div class="row">
        <div class="col-md-6">
            <label>Teléfono</label>
            <input type="text" readonly class="form-control" value="{{ $vet->phone }}">
        </div>
        <div class="col-md-6">
            <label>Registro</label>
            <input type="text" readonly class="form-control" value="{{ $vet->created_at }}">
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
        window.WPANEL_VETERINARY_USERS_CONFIG = {
            listUrl: "{{ route('wp.veterinary.listUsers') }}/?id={{ $id }}",
            lockUrl: "{{ route('wp.veterinary.lock') }}",
            enabledUrl: "{{ route('wp.veterinary.enabled') }}",
            detailBaseUrl: "{{ url('wpanel/veterinary/detail') }}",
            showDetailsLabel: "<i class=\"fa fa-plus\" aria-hidden=\"true\"></i>&nbsp;Ver m\u00e1s detalles",
            hideDetailsLabel: "<i class=\"fa fa-minus\" aria-hidden=\"true\"></i>&nbsp;Ocultar detalles",
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
    <script src="{{ asset('js/wpanel/veterinary/users.js') }}"></script>
@stop
