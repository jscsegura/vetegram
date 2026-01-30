@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@include('elements.docmenu')

<section class="invoiceWidth pb-0 pb-lg-4">
    <div class="row px-2 px-lg-3 mt-2 mt-lg-4 mb-lg-5">
        <div class="col">
            <h1 class="h4 text-uppercase justify-content-center justify-content-md-start fw-normal mb-2 mb-lg-3 flex-grow-1 d-flex gap-1 align-items-center">
                <span>{{ trans('dash.label.newa') }} <span class="text-info fw-bold">{{ trans('dash.label.invoice') }}</span></span>
            </h1>
            <form name="frmInv" id="frmInv" action="{{ route('invoice.store') }}" method="post">
                @csrf
                <input type="hidden" name="proformId" id="proformId" value="{{ (isset($proformId)) ? $proformId : 0 }}">
                <input type="hidden" name="typeInvoice" id="typeInvoice" value="0">
                <div class="card rounded-3 border-2 border-secondary px-2 px-lg-3 py-2 py-lg-3 mb-3">
                    <div class="row row-cols-1 row-cols-md-3 g-3 g-md-4 mb-4 mb-md-5 px-2">
                        <div>
                            <label for="clientName" class="form-label small">{{ trans('dash.label.element.client') }}</label>
                            <select class="form-select select2 requerido" name="client" id="client" data-invoice-action="client-select">
                                <option value="0" data-name="{{ trans('dash.label.client.contado') }}" data-phone="" data-email="" data-typedni="" data-dni="">{{ trans('dash.label.new.client') }}</option>
                                @foreach ($owner as $client)
                                <option value="{{ $client->id }}" data-name="{{ $client->name }}" data-phone="{{ $client->phone }}" data-email="{{ $client->email }}" data-typedni="{{ $client->type_dni }}" data-dni="{{ $client->dni }}" @if((isset($invoice->user_id)) && ($invoice->user_id == $client->id)) selected @endif>{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="" class="form-label small">{{ trans('auth.login.fullname') }}</label>
                            <input type="text" name="invoiceName" id="invoiceName" class="form-control fc requerido" value="{{ (isset($invoice->name)) ? $invoice->name : '' }}">
                        </div>
                        <div>
                            <label for="" class="form-label small">{{ trans('auth.register.complete.typedni') }}</label>
                            <select class="form-select fc" name="invoiceDniType" id="invoiceDniType">
                                <option value="1" @if((isset($invoice->type_dni)) && ($invoice->type_dni == '1')) selected @endif>{{ trans('auth.register.complete.physical') }}</option>
                                <option value="2" @if((isset($invoice->type_dni)) && ($invoice->type_dni == '2')) selected @endif>{{ trans('auth.register.complete.juridic') }}</option>
                                <option value="3" @if((isset($invoice->type_dni)) && ($invoice->type_dni == '3')) selected @endif>{{ trans('auth.register.complete.passport') }}</option>
                                <option value="4" @if((isset($invoice->type_dni)) && ($invoice->type_dni == '4')) selected @endif>DIMEX</option>
                                <option value="5" @if((isset($invoice->type_dni)) && ($invoice->type_dni == '5')) selected @endif>NITE</option>
                            </select>
                        </div>
                        <div>
                            <label for="" class="form-label small">{{ trans('auth.register.complete.dni') }}</label>
                            <input type="text" class="form-control fc" name="invoiceDni" id="invoiceDni" value="{{ (isset($invoice->dni)) ? $invoice->dni : '' }}">
                        </div>
                        <div>
                            <label for="" class="form-label small">{{ trans('auth.register.complete.phone.only') }}</label>
                            <input type="text" class="form-control fc" name="invoicePhone" id="invoicePhone" value="{{ (isset($invoice->phone)) ? $invoice->phone : '' }}">
                        </div>
                        <div>
                            <label for="" class="form-label small">{{ trans('auth.login.email') }}</label>
                            <input type="text" class="form-control fc" name="invoiceEmail" id="invoiceEmail" value="{{ (isset($invoice->email)) ? $invoice->email : '' }}">
                        </div>
                        <div>
                            <label for="metodoPago" class="form-label small">{{ trans('dash.label.element.payment.method') }}</label>
                            <select class="form-select fc requerido" id="paymentMethod" name="paymentMethod">
                                <option value="01" @if((isset($invoice->payment)) && ($invoice->payment == '01')) selected @endif>{{ trans('dash.label.element.cash') }}</option>
                                <option value="02" @if((isset($invoice->payment)) && ($invoice->payment == '02')) selected @endif>{{ trans('dash.label.element.card') }}</option>
                                <option value="03" @if((isset($invoice->payment)) && ($invoice->payment == '03')) selected @endif>{{ trans('dash.label.element.cheque') }}</option>
                                <option value="04" @if((isset($invoice->payment)) && ($invoice->payment == '04')) selected @endif>{{ trans('dash.label.element.transfer') }}</option>
                            </select>
                        </div>
                        <div>
                            <label for="formaPago" class="form-label small">{{ trans('dash.label.element.payment.form') }}</label>
                            <select class="form-select fc requerido" id="paymentType" name="paymentType">
                                <option value="01" @if((isset($invoice->type_payment)) && ($invoice->type_payment == '01')) selected @endif>{{ trans('dash.label.element.contado') }}</option>
                                <option value="02" @if((isset($invoice->type_payment)) && ($invoice->type_payment == '02')) selected @endif>{{ trans('dash.label.element.credit') }}</option>
                                <option value="03" @if((isset($invoice->type_payment)) && ($invoice->type_payment == '03')) selected @endif>{{ trans('dash.label.element.consignation') }}</option>
                                <option value="04" @if((isset($invoice->type_payment)) && ($invoice->type_payment == '04')) selected @endif>{{ trans('dash.label.element.apartado') }}</option>
                            </select>
                        </div>
                        <div>
                            <label for="moneda" class="form-label small">{{ trans('dash.label.currency') }}</label>
                            <input type="text" class="form-control fc" id="currency" value="Colones" disabled>
                        </div>
                    </div>

                    <h2 class="h4 fw-normal text-primary text-center">{{ trans('dash.label.detail') }}</h2>
                    <table>
                        <table class="table table-striped table-borderless mb-0 small align-middle rTable v2">
                            <thead>
                                <tr>
                                    <th class="px-2" style="width: 53px;"></th>
                                    <th class="px-2" style="width: 72px;">{{ trans('dash.label.quantity') }}</th>
                                    <th class="px-2" style="width: 260px;">{{ trans('dash.label.element.product.service') }}</th>
                                    <th class="px-2">{{ trans('dash.label.detail') }}</th>
                                    <th class="px-2">{{ trans('dash.label.gravado') }}</th>
                                    <th class="px-2" style="width: 120px;">Subtotal</th>
                                    <th class="px-2">%IVA</th>
                                    <th class="px-2" style="width: 120px;">{{ trans('dash.label.precio') }}</th>
                                    <th class="px-2 text-end">{{ trans('dash.label.total.line') }}</th>
                                </tr>
                            </thead>
                            <tbody id="rowsInvoice">
                                @php
                                    $total = 0;
                                @endphp
                                @foreach ($rows as $row)
                                <tr id="rowInvoice{{ $row['id'] }}" data-line-id="{{ $row['id'] }}">
                                    <input type="hidden" name="productCode[]" id="productCode{{ $row['id'] }}" class="productCodeList" value="{{ $row['id'] }}">
                                    <input type="hidden" name="productId[]" id="productId{{ $row['id'] }}" value="{{ $row['id'] }}">

                                    <input type="hidden" name="cabys[]" id="cabys{{ $row['id'] }}" value="{{ $row['cabys'] }}">
                                    <input type="hidden" name="unit[]" id="unit{{ $row['id'] }}" value="{{ $row['unit'] }}">

                                    <td class="px-2 py-2 py-lg-4" data-label="Eliminar:">
                                        <button type="button" class="btn btn-outline-danger btn-sm" data-invoice-action="line-remove" data-line-id="{{ $row['id'] }}">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </td>
                                    <td class="px-2 py-2 py-lg-4" data-label="Cantidad:">
                                        <div class="d-table">
                                            <div class="input-group w-auto align-items-center">
                                                <input type="text" class="form-control form-control-sm fw-semibold text-center requerido invoice-numeric" id="quantity{{ $row['id'] }}" name="quantity[]" value="{{ $row['quantity'] }}" data-invoice-action="line-quantity" data-line-id="{{ $row['id'] }}" size="1">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-2 py-2 py-lg-4" data-label="Pro/Ser:">
                                        <select class="form-select form-select-sm select2 requerido" id="product{{ $row['id'] }}" name="product[]" data-invoice-action="line-product" data-line-id="{{ $row['id'] }}">
                                            <option value="{{ $row['id'] }}">{{ $row['title'] }}</option>
                                        </select>
                                    </td>
                                    <td class="px-2 py-2 py-lg-4" data-label="Detalle:">
                                        <input type="text" class="form-control form-control-sm w-auto requerido" name="detail[]" id="detail{{ $row['id'] }}" value="{{ $row['title'] }}">
                                    </td>
                                    <td class="px-2 py-2 py-lg-4" data-label="Gravado:">
                                        <select class="form-select form-select-sm requerido" id="gravado{{ $row['id'] }}" name="gravado[]">
                                            <option value=""></option>
                                            <option value="gravado" @if($row['type'] == 'gravado') selected @endif>{{ trans('dash.label.gravado') }}</option>
                                            <option value="exento" @if($row['type'] == 'exento') selected @endif>{{ trans('dash.label.exento') }}</option>
                                        </select>
                                    </td>
                                    <td class="px-2 py-2 py-lg-4" data-label="Precio:">
                                        <input type="text" class="form-control form-control-sm requerido invoice-numeric" name="productSubPrice[]" id="productSubPrice{{ $row['id'] }}" value="{{ $row['subprice'] }}" data-invoice-action="line-subprice" data-line-id="{{ $row['id'] }}">
                                    </td>
                                    <td class="px-2 py-2 py-lg-4" data-label="IVA:">
                                        <select class="form-select form-select-sm requerido" id="rate{{ $row['id'] }}" name="rate[]" data-invoice-action="line-rate" data-line-id="{{ $row['id'] }}">
                                            <option value=""></option>
                                            <option value="01" @if($row['rate'] == '01') selected @endif>0%</option>
                                            <option value="02" @if($row['rate'] == '02') selected @endif>1%</option>
                                            <option value="03" @if($row['rate'] == '03') selected @endif>2%</option>
                                            <option value="04" @if($row['rate'] == '04') selected @endif>4%</option>
                                            <option value="05" @if($row['rate'] == '05') selected @endif>0%</option>
                                            <option value="06" @if($row['rate'] == '06') selected @endif>4%</option>
                                            <option value="07" @if($row['rate'] == '07') selected @endif>8%</option>
                                            <option value="08" @if($row['rate'] == '08') selected @endif>13%</option>
                                            <option value="09" @if($row['rate'] == '09') selected @endif>0.5%</option>
                                        </select>
                                    </td>
                                    <td class="px-2 py-2 py-lg-4 text-end" data-label="Precio:">
                                        <input type="text" class="form-control form-control-sm requerido invoice-numeric" name="productPrice[]" id="productPrice{{ $row['id'] }}" value="{{ $row['price'] }}" data-invoice-action="line-price" data-line-id="{{ $row['id'] }}">
                                    </td>
                                    <td class="px-2 py-2 py-lg-4 text-end" data-label="Tot. lin.:" id="printPriceTotalLine{{ $row['id'] }}">¢{{ number_format(($row['quantity'] * $row['price']), 2, ".", ",") }}</td>
                                    @php
                                        $total = $total + ($row['quantity'] * $row['price']);
                                    @endphp
                                </tr>
                                @endforeach
                                
                                <tr id="btnAddline">
                                    <td class="px-2 py-0 py-md-2 py-lg-4 text-end shadow-none" colspan="9">
                                        <button type="button" class="btn btn-outline-primary btn-sm px-4" data-invoice-action="line-add"><i class="fa-solid fa-plus me-1"></i>{{ trans('dash.label.add.line') }}</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </table>
                    <table>
                        <table class="table table-borderless mb-0 small align-middle rTable v2">
                            <tbody>
                                <tr>
                                    <td class="px-2 py-2 py-lg-4 text-end border-top" data-label="Total:">
                                        <span class="me-2 fw-medium d-none d-md-inline-block">Total:</span><span class="fw-bold" id="printerGranTotal">¢{{ number_format($total, 2, ".", ",") }}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </table>
                </div>
                <div class="d-flex gap-2 flex-column flex-sm-row">
                    <button type="button" class="btn btn-primary px-4" data-invoice-action="create-invoice" data-invoice-type="0">{{ trans('dash.label.create.invoice') }}</button>
                    <button type="button" class="btn btn-primary px-4" data-invoice-action="create-invoice" data-invoice-type="1">{{ trans('dash.label.create.proforma') }}</button>
                </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

<script>
    window.INVOICE_CREATE_CONFIG = {
        products: @json($products),
        labels: {
            selectLabel: "{{ trans('dash.label.selected') }}",
            addLine: "{{ trans('dash.label.add.line') }}",
            deleteRowTitle: "{{ trans('dash.msg.delete.row.invoice') }}",
            deleteRowText: "{{ trans('dash.msg.confir.delete.row.invoice') }}",
            deleteYes: "{{ trans('dash.label.yes.delete') }}",
            deleteNo: "{{ trans('dash.label.no.cancel') }}"
        }
    };
</script>
<script src="{{ asset('js/invoice/create-appointment.js') }}"></script>
@endpush
