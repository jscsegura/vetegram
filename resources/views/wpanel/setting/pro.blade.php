@extends('layouts.wpanel')

@section('title', 'Panel de administración - Planes PRO')

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
            <h3>Rubros del plan PRO</h3>
        </div>
    </div>
    <div class="col-md-6 text-right">
        <a class="btn btn-primary" href="{{ route('wp.setting.procreate') }}"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Agregar rubro</a>
    </div>
</div>

<div id="container">
    <table id="tableList" class="table table-hover" style="width:100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>Titulo</th>
                <th>Plan</th>
                <th>Habilitar</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            @if(count($pros) > 0)
                @foreach ($pros as $pro)
                    <tr>
                        <td>{{ $pro->id }}</td>
                        <td>{{ $pro->title_es }}</td>
                        <td>{{ ($pro->pro == 1) ? 'PRO' : 'GRATIS' }}</td>
                        <td>
                            <span id="enabledRow{{ $pro->id }}">
                                <a data="{{ $pro->id }}" onclick="enabledRow(this);">
                                    @if($pro->enabled == 1)
                                        <img src="{{ asset('img/wpanel/enabled.png') }}">
                                    @else
                                        <img src="{{ asset('img/wpanel/disabled.png') }}">
                                    @endif
                                </a>
                            </span>
                        </td>
                        <td>
                            <a href="{{ url('wpanel/setting-pro') }}/{{ $pro->id }}/edit"><img src="{{ asset('img/wpanel/edit.png') }}"></a>
                        </td>
                        <td>
                            <a data="{{ $pro->id }}" onclick="deleteRow(this);"><img src="{{ asset('img/wpanel/delete.png') }}"></a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr><td colspan="6" class="text-center">No existen registros</td></tr>
            @endif
        </tbody>
    </table>
</div>

@stop

@section('js')
    <script>
        function enabledRow(obj) {
            var id = $(obj).attr('data');
            enabledRegister('{{ route('wp.setting.proenabled') }}', 'id=' + id, 'enabledRow' + id);
        }
        function deleteRow(obj) {
            var id = $(obj).attr('data');
            var row = $(obj).parent().parent('tr');
            eliminateRegister('{{ route('wp.setting.prodelete') }}', 'id=' + id, row);
        }
    </script>
@stop