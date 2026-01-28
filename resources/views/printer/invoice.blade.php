@extends('layouts.empty')

@section('content')
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Imprimir receta</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <style>
            @media print{
                .btn-dark { display: none !important }
            }
        </style>
    </head>

    <body onload="window.print();">

        <section class="invoiceWidth pb-0 pb-lg-4">
            <div class="row px-2 px-lg-3 mt-2 mt-lg-4 mb-lg-5">
                <div class="col">
                    <h1 class="h4 text-uppercase justify-content-center justify-content-md-start fw-normal mb-2 mb-lg-3 flex-grow-1 d-flex gap-1 align-items-center">
                        <a href="{{ route('invoice.index') }}" class="btn btn-sm smIcon"><i class="fa-solid fa-arrow-left-long"></i></a>
                        <span>{{ trans('dash.label.detail') }} <span class="text-info fw-bold">@if($doctype == 0) {{ trans('dash.label.invoice') }} @elseif($doctype == 1) {{ trans('dash.label.ticket') }} @elseif($doctype == 2) {{ trans('dash.label.invoice.credit') }} @endif</span></span>
                    </h1>
                    <div class="card rounded-3 border-2 border-secondary px-2 px-lg-3 py-2 py-lg-3 mb-3">
                        <a class="btn btn-link btn-sm smIcon position-absolute end-0 top-0 me-2 mt-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </a>

                        <div class="text-center mb-4 border-bottom pb-3 mt-4 mt-sm-0 mx-2">
                            <h2 class="h4 fw-normal mb-1 mb-sm-0"><span class="fw-medium">#</span> {{ $invoice['CLAVE'] }}</h2>
                            <p>
                                {{ trans('dash.label.date') }}: {{ date('d/m/Y', strtotime($invoice['FECHAEMISION'])) }} <i class="ms-2">{{ date('h:ia', strtotime($invoice['FECHAEMISION'])) }}</i>
                                <span class="px-2 opacity-50 d-none d-sm-inline">|</span>
                                <br class="d-block d-sm-none">
                                {{ trans('dash.label.status') }}: 
                                @switch ($invoice['APPROVED'])
                                    @case ('1') <span class="text-success fw-semibold">{{ trans('dash.label.status.invoice.approved') }}</span> @break
                                    @case ('E1') <span class="text-danger fw-semibold">{{ trans('dash.label.status.invoice.rejected.xml') }}</span> @break
                                    @case ('E2') <span class="text-danger fw-semibold">{{ trans('dash.label.status.invoice.no.connection') }}</span> @break
                                    @case ('E3') <span class="text-danger fw-semibold">{{ trans('dash.label.status.invoice.error') }}</span> @break
                                    @case ('0') <span class="text-danger fw-semibold">{{ trans('dash.label.status.invoice.not.approved') }}</span> @break
                                    @case ('W') <span class="text-danger fw-semibold">{{ trans('dash.label.status.invoice.waiting') }}</span> @break
                                    @default <span class="text-danger fw-semibold">{{ trans('dash.label.status.invoice.rejected') }}</span> @break
                                @endswitch
                            </p>
                        </div>
                        <div class="row row-cols-1 row-cols-md-2 g-3 g-md-4 mb-4 mb-md-5 px-2">
                            <div>
                                <label for="clientName" class="form-label small">{{ trans('dash.label.element.client') }}</label>
                                <input type="text" class="form-control fc" id="clientName" value="{{ $invoice['CLIENT'] }}" disabled>
                            </div>
                            <div>
                                <label for="metodoPago" class="form-label small">{{ trans('dash.label.element.payment.method') }}</label>
                                <select class="form-select fc" id="metodoPago" name="metodoPago" disabled>
                                    <option selected>{{ $invoice['PAYMENT'] }}</option>
                                </select>
                            </div>
                            <div>
                                <label for="formaPago" class="form-label small">{{ trans('dash.label.element.payment.form') }}</label>
                                <select class="form-select fc" id="formaPago" name="formaPago" disabled>
                                    <option selected>{{ $invoice['PAYMENTMODE'] }}</option>
                                </select>
                            </div>
                            <div>
                                <label for="moneda" class="form-label small">{{ trans('dash.label.currency') }}</label>
                                <input type="text" class="form-control fc" id="moneda" value="Colones" disabled>
                            </div>
                        </div>

                        <h2 class="h4 fw-normal text-primary text-center">{{ trans('dash.label.detail') }}</h2>
                        <table>
                            <table class="table table-striped table-borderless mb-0 small align-middle rTable v2">
                                <thead>
                                    <tr>
                                        <th class="px-2 px-lg-3 text-center" style="width: 90px;">{{ trans('dash.label.quantity') }}</th>
                                        <th class="px-2 px-lg-3">{{ trans('dash.label.element.product.service') }}</th>
                                        <th class="px-2 px-lg-3">{{ trans('dash.label.detail') }}</th>
                                        <th class="px-2 px-lg-3">{{ trans('dash.label.gravado') }}</th>
                                        <th class="px-2 px-lg-3">%IVA</th>
                                        <th class="px-2 px-lg-3 text-end">{{ trans('dash.label.precio') }}</th>
                                        <th class="px-2 px-lg-3 text-end">{{ trans('dash.label.total.line') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($details as $detail)
                                    <tr>
                                        <td class="px-2 px-lg-3 py-2 py-lg-4 text-center" data-label="{{ trans('dash.label.quantity') }}:">
                                            {{ $detail['AMOUNT'] }}
                                        </td>
                                        <td class="px-2 px-lg-3 py-2 py-lg-4" data-label="Pro/Ser:">
                                            {{ $detail['LINETYPE'] }}
                                        </td>
                                        <td class="px-2 px-lg-3 py-2 py-lg-4" data-label="{{ trans('dash.label.detail') }}:">
                                            {{ $detail['DESCRIPTION'] }}
                                        </td>
                                        <td class="px-2 px-lg-3 py-2 py-lg-4" data-label="{{ trans('dash.label.gravado') }}:">{{ ucfirst($detail['TIPO']) }}</td>
                                        <td class="px-2 px-lg-3 py-2 py-lg-4" data-label="IVA:">
                                            @switch($detail['TARIFACODIGO'])
                                                @case('01') 0% @break
                                                @case('02') 1% @break
                                                @case('03') 2% @break
                                                @case('04') 4% @break
                                                @case('05') 0% @break
                                                @case('06') 4% @break
                                                @case('07') 8% @break
                                                @case('08') 13% @break
                                                @case('09') 0.5% @break
                                                @default
                                            @endswitch
                                        </td>
                                        <td class="px-2 px-lg-3 py-2 py-lg-4 text-end" data-label="{{ trans('dash.label.precio') }}:">¢{{ number_format($detail['UNITPRICE'], 2, ".", ",") }}</td>
                                        <td class="px-2 px-lg-3 py-2 py-lg-4 text-end" data-label="Tot. lin.:">¢{{ number_format($detail['UNITPRICE'] * $detail['AMOUNT'], 2, ".", ",") }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </table>
                        <!--<table>
                            <table class="table table-borderless mb-0 small align-middle rTable v2">
                                <tbody>
                                    <tr>
                                        <td class="px-2 px-lg-3 py-2 py-lg-4 text-end border-top" data-label="Total:">
                                            <span class="me-2 fw-medium d-none d-md-inline-block">Total:</span><span class="fw-bold">¢{{-- number_format($invoice->total, 2, ".", ",") --}}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </table>-->
                    </div>
                </div>
            </div>
        </section>
    </body>

    </html>
@endsection