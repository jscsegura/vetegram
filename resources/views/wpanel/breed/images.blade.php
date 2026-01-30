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
    <div class="col-md-6">
        <div class="page-title">
            <h3>Imagenes de Grooming <span style="font-size: 0.6em">({{ $breed->title_es }})</span></h3>
        </div>
    </div>
    <div class="col-md-6 text-right">
        <a class="btn btn-warning" href="{{ route('wp.animal-breed.index', $breed->type) }}"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp;Regresar</a>
        <a class="btn btn-primary" href="{{ route('wp.animal-breed.createImage', $breed->id) }}"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Agregar imagen de grooming</a>
    </div>
</div>

<div id="container">
    <table id="tableList" class="table table-hover" style="width:100%;">
        <thead>
            <tr>
                <th>Id</th>
                <th>Titulo</th>
                <th>Imagen</th>
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
        window.WPANEL_BREED_IMAGES_CONFIG = {
            listUrl: "{{ route('wp.animal-breed.imagelist', $breed->id) }}",
            enabledUrl: "{{ route('wp.animal-breed.enabledImage') }}",
            deleteUrl: "{{ route('wp.animal-breed.deleteImage') }}",
            editBaseUrl: "{{ url('wpanel/animal-breed/edit-image') }}",
            assets: {
                enabled: "{{ asset('img/wpanel/enabled.png') }}",
                disabled: "{{ asset('img/wpanel/disabled.png') }}",
                edit: "{{ asset('img/wpanel/edit.png') }}",
                delete: "{{ asset('img/wpanel/delete.png') }}"
            }
        };
    </script>
    <script src="{{ asset('js/wpanel/common.js') }}"></script>
    <script src="{{ asset('js/wpanel/breed/images.js') }}"></script>
@stop
