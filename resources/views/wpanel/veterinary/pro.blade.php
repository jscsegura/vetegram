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
    <div class="col-md-6">
        <div class="page-title">
            <h3>Detalles plan PRO</h3>
        </div>
    </div>
    <div class="col-md-6 text-right">
        <a class="btn btn-warning" href="{{ route('wp.veterinary.index') }}"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp;Regresar</a>
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
                <th>Tiene Tarjeta</th>
                <th>Correo Afiliación</th>
                <th>Vencimiento Plan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $vet->id }}</td>
                <td>{{ $vet->social_name }}</td>
                <td>{{ $vet->company }}</td>
                <td>{{ $vet->phone }}</td>
                <td>{{ ($vet->token != '') ? 'Si' : 'No' }}</td>
                <td>{{ $vet->email_token }}</td>
                <td>
                    @php $now = date('Y-m-d'); @endphp
                    @if(strtotime($vet->expire) < strtotime($now))
                        <span style="color: red;">{{ date('d/m/Y', strtotime($vet->expire)) }}</span>
                    @else
                        <span>{{ date('d/m/Y', strtotime($vet->expire)) }}</span>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>

    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#menu1">Pagos Aprobados</a></li>
        <li><a data-toggle="tab" href="#menu2">Pagos Rechazados</a></li>
        <li><a data-toggle="tab" href="#menu3">Cancelaciones del plan</a></li>
      </ul>
      
      <div class="tab-content">
        <div id="menu1" class="tab-pane fade in active">
            <table id="tableList" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Moneda</th>
                        <th>Monto</th>
                        <th>Autorización</th>
                        <th>Numero de orden</th>
                        <th>Id Tilopay</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($payments) > 0)
                        @foreach ($payments as $payment)
                            <tr>
                                <td>{{ $payment->id }}</td>
                                <td>{{ $payment->currency }}</td>
                                <td>{{ $payment->amount }}</td>
                                <td>{{ $payment->auth }}</td>
                                <td>{{ $payment->orderNumber }}</td>
                                <td>{{ $payment->orderid }}</td>
                                <td>{{ date('d/m/Y h:i A', strtotime($payment->created_at)) }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7">No hay registros</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div id="menu2" class="tab-pane fade">
            <table id="tableList" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Moneda</th>
                        <th>Monto</th>
                        <th>Codigo</th>
                        <th>Respuesta</th>
                        <th>Numero de orden</th>
                        <th>Id Tilopay</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($rejecteds) > 0)
                        @foreach ($rejecteds as $rejected)
                            <tr>
                                <td>{{ $rejected->id }}</td>
                                <td>{{ $rejected->currency }}</td>
                                <td>{{ $rejected->amount }}</td>
                                <td>{{ $rejected->code }}</td>
                                <td>{{ $rejected->responseText }}</td>
                                <td>{{ $rejected->orderNumber }}</td>
                                <td>{{ $rejected->orderid }}</td>
                                <td>{{ date('d/m/Y h:i A', strtotime($rejected->created_at)) }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8">No hay registros</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div id="menu3" class="tab-pane fade">
            <table id="tableList" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Motivo</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($cancels) > 0)
                        @foreach ($cancels as $cancel)
                            <tr>
                                <td style="width: 15%;">{{ date('d/m/Y h:i A', strtotime($cancel->created_at)) }}</td>
                                <td>{{ $cancel->reason }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="2">No hay registros</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
      </div>
</div>

@stop