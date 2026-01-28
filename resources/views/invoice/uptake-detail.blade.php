@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@include('elements.docmenu')

<section class="invoiceWidth2 pb-0 pb-lg-4">
    <div class="row px-2 px-lg-3 mt-2 mt-lg-4 mb-lg-5">
        <div class="col">
            <form name="frm" id="frm" action="{{ route('process.uptakeSave') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <h1 class="h4 text-uppercase justify-content-center justify-content-md-start fw-normal mb-2 mb-lg-3 flex-grow-1 d-flex gap-1 align-items-center">
                    <span>Aceptar <span class="text-info fw-bold">factura</span></span>
                </h1>
                <div class="card rounded-3 border-2 border-secondary px-3 px-lg-4 py-3 py-lg-4 mb-3">

                    <div class="row g-3 g-md-4 mb-2 px-2">

                        <input type="hidden" name="MedioPago" id="MedioPago" value="{{ $MedioPago }}">
                        <input type="hidden" name="CodigoMoneda" id="CodigoMoneda" value="{{ $CodigoMoneda }}">
                        <input type="hidden" name="TipoCambio" id="TipoCambio" value="{{ $TipoCambio }}">
                        <input type="hidden" name="fechaEmision" id="fechaEmision" value="{{ $fechaEmision }}">
                        <input type="hidden" name="CondicionVenta" id="CondicionVenta" value="{{ $CondicionVenta }}">

                        <div class="col-8">
                            <label for="Clave" class="form-label small">Clave</label>
                            <input type="text" class="form-control" id="Clave" name="Clave" value="{{ $Clave }}" onfocus="blur();">
                        </div>
                        <div class="col-4">
                            <label for="NumeroConsecutivo" class="form-label small">Numero Consecutivo</label>
                            <input type="text" class="form-control" id="NumeroConsecutivo" name="NumeroConsecutivo" value="{{ $NumeroConsecutivo }}" onfocus="blur();">
                        </div>
                        <div class="col-12">
                            <label for="nombreEmisor" class="form-label small">Nombre Emisor</label>
                            <input type="text" class="form-control" id="nombreEmisor" name="nombreEmisor" value="{{ $emisor['Nombre'] }}" onfocus="blur();">
                        </div>
                        <div class="col-4">
                            <label for="typeEmisor" class="form-label small">Tipo Identificación</label>
                            <input type="text" class="form-control" id="typeEmisor" name="typeEmisor" value="{{ $emisor['Identificacion']['Tipo'] }}" onfocus="blur();">
                        </div>
                        <div class="col-8">
                            <label for="dniEmisor" class="form-label small">Identificación Emisor</label>
                            <input type="text" class="form-control" id="dniEmisor" name="dniEmisor" value="{{ $emisor['Identificacion']['Numero'] }}" onfocus="blur();">
                        </div>
                        <div class="col-6">
                            <label for="totalTaxes" class="form-label small">Total Impuestos</label>
                            <input type="text" class="form-control" id="totalTaxes" name="totalTaxes" value="{{ $TotalImpuesto }}" onfocus="blur();">
                        </div>
                        <div class="col-6">
                            <label for="totalFactura" class="form-label small">Total Factura</label>
                            <input type="text" class="form-control" id="totalFactura" name="totalFactura" value="{{ $TotalComprobante }}" onfocus="blur();">
                        </div>
                        
                        <div class="col-6 col-md-6">
                            <label for="uptake" class="form-label small">Tipo de aceptación</label>
                            <select class="form-select fc" id="uptake" name="uptake">
                                <option value="1" @if($uptake == '1') selected @endif>Aceptado</option>
                                <option value="2" @if($uptake == '2') selected @endif>Aceptación parcial</option>
                                <option value="3" @if($uptake == '3') selected @endif>Rechazado</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-6">
                            <label for="condition" class="form-label small">Condición de impuesto</label>
                            <select class="form-select fc" id="condition" name="condition">
                                <option value="01" @if($condition == '01') selected @endif>Genera crédito IVA</option>
                                <option value="02" @if($condition == '02') selected @endif>Genera Crédito parcial del IVA</option>
                                <option value="03" @if($condition == '03') selected @endif>Bienes de Capital</option>
                                <option value="04" @if($condition == '04') selected @endif>Gasto corriente no genera crédito</option>
                                <option value="05" @if($condition == '05') selected @endif>Proporcionalidad</option>
                            </select>
                        </div>
                    </div>

                </div>

                <button type="submit" class="btn btn-primary px-4">Enviar</button>
            </form>
        </div>
    </div>
</section>

@include('elements.footer')

@endsection

@push('scriptBottom')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('js/front/datedropper.js') }}"></script>

<link rel="stylesheet" href="{{ asset('css/wpanel/library/jquery.toast.css') }}">
<script src="{{ asset('js/wpanel/library/jquery.toast.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
</script>
@endpush