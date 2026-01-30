@extends('layouts.wpanel')

@section('title', 'Panel de administración - Cliente')

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
            <h3>Detalle del cliente</h3>
        </div>
    </div>
    <div class="col-md-6 text-right">
        <a class="btn btn-primary" data-action="log-with-user"><i class="fa fa-lock" aria-hidden="true"></i>&nbsp;Acceder como cliente</a>
        <a class="btn btn-warning" href="{{ route('wp.client.index') }}"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp;Regresar</a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <label>Nombre</label>
        <input type="text" readonly class="form-control" value="{{ $user->name }}">
    </div>
    <div class="col-md-6">
        <label>Correo</label>
        <input type="text" readonly class="form-control" value="{{ $user->email }}">
    </div>
</div>

<div class="row"><div class="col-md-12">&nbsp;</div></div>

<div class="row">
    <div class="col-md-6">
        <label>Tipo de identificación</label>
        <input type="text" readonly class="form-control" value="{{ ($user->type_dni == 2) ? 'Juridico' : 'Fisico' }}">
    </div>
    <div class="col-md-6">
        <label>Identificación</label>
        <input type="text" readonly class="form-control" value="{{ $user->dni }}">
    </div>
</div>

<div class="row"><div class="col-md-12">&nbsp;</div></div>

<div class="row">
    <div class="col-md-6">
        <label>Pais</label>
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
    <div class="col-md-4">
        <label>Teléfono</label>
        <input type="text" readonly class="form-control" value="{{ $user->phone }}">
    </div>
    <div class="col-md-4">
        <label>Login con Facebook</label>
        <input type="text" readonly class="form-control" value="{{ ($user->facebook == 1) ? 'Si' : 'No' }}">
    </div>
    <div class="col-md-4">
        <label>Login con Google</label>
        <input type="text" readonly class="form-control" value="{{ ($user->google == 1) ? 'Si' : 'No' }}">
    </div>
</div>

<div class="row"><div class="col-md-12">&nbsp;</div></div>

<div class="row">
    <div class="col-md-6">
        <label>Registro</label>
        <input type="text" readonly class="form-control" value="{{ $user->created_at }}">
    </div>
    <div class="col-md-6">
        <label>Ultimo Ingreso</label>
        <input type="text" readonly class="form-control" value="{{ $user->last_login }}">
    </div>
</div>

<div class="row"><div class="col-md-12">&nbsp;</div></div>

<div class="row">
    <div class="col-md-12">
        <div class="page-title">
            <h3>Mascotas</h3>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="grid simple">
            <div class="grid-body no-border">
                <table id="favor_sortable" class="table table-hover">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Raza</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($pets as $pet)
                            <tr>
                                <td>{{ $pet->id }}</td>
                                <td>{{ $pet->name }}</td>
                                <td>{{ (isset($pet['getType']['title_es'])) ? $pet['getType']['title_es'] : '' }}</td>
                                <td>{{ (isset($pet['getBreed']['title_es'])) ? $pet['getBreed']['title_es'] : '' }}</td>
                            </tr>      
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@stop

@section('js')
    <script>
        window.WPANEL_CLIENT_DETAIL_CONFIG = {
            loginUrl: "{{ route('wp.login.with.user', $user->id) }}",
            confirmTitle: "Acceder como cliente",
            confirmMessage: "Seguro que desea ingresar al panel de Vetegram como si fuera el cliente, cualquier accion se registrara como si fue hecha por el cliente"
        };
    </script>
    <script src="{{ asset('js/wpanel/client/detail.js') }}"></script>
@stop
