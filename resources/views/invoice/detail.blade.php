@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@include('elements.docmenu')

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
                <div class="dropdown d-inline-block">
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow rounded-3">
                        @if((in_array($doctype, [0]))&&(($invoice['APPROVED'] == 1)))
                        <li><button type="button" class="dropdown-item small" data-bs-toggle="modal" data-bs-target="#creditNoteModal" onclick="setIdInvoiceNc('{{ $invoice['CLAVE'] }}');">{{ trans('dash.label.invoice.credit') }}</button></li>
                        @endif
                        @if($invoice['APPROVED'] != 1)
                        <li><a class="dropdown-item small" onclick="resendDocument(0, '{{ $invoice['CLAVE'] }}');">{{ trans('dash.invoice.index.btn.resend') }}</a></li>
                        @endif
                        
                        @if($invoice['CLAVE'] != '')
                        <li><a class="dropdown-item small" href="https://vetegram.sistelix.com/documents/pdf.php?token={{ $invoice['CLAVE'] }}" target="_blank">{{ trans('dash.label.btn.see') }} PDF</a></li>
                        <li><a href="https://documentos.factulix.com/pmlix/Tiquetes/Tiquetes/Tiquete-{{ $invoice['CLAVE'] }}.xml" target="_blank" class="dropdown-item small">{{ trans('dash.label.btn.see') }} XML</a></li>
                        <li><a href="https://documentos.factulix.com/pmlix/Tiquetes/Respuestas/Tiquete-{{ $invoice['CLAVE'] }}-respuesta.xml" target="_blank" class="dropdown-item small">{{ trans('dash.label.btn.see') }} XML {{ trans('dash.label.payment.response') }}</a></li>
                        {{--<li><button type="button" class="dropdown-item small" data-bs-toggle="modal" data-bs-target="#sendMailModal">Enviar por email</button></li>--}}
                        @endif
                        
                        <li><a class="dropdown-item small" href="{{ route('invoice.detail', ['id' => $invoice['CLAVE'], 'doctype' => $doctype, 'printer' => 'printer']) }}" target="_blank">{{ trans('dash.btn.label.printer') }}</a></li>
                    </ul>
                </div>

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
                <div class="row row-cols-1 row-cols-md-3 g-3 g-md-4 mb-4 mb-md-5 px-2">
                    <div>
                        <label for="clientName" class="form-label small">{{ trans('dash.label.element.client') }}</label>
                        <input type="text" class="form-control fc" id="clientName" value="{{ $invoice['CLIENT'] }}" disabled>
                    </div>
                    <div>
                        <label for="" class="form-label small">Nombre</label>
                        <input type="text" class="form-control fc" disabled>
                    </div>
                    <div>
                        <label for="" class="form-label small">Tipo de identificación</label>
                        <select class="form-select fc" disabled>
                            <option value="01"></option>
                        </select>
                    </div>
                    <div>
                        <label for="" class="form-label small">Nº identificación</label>
                        <input type="text" class="form-control fc" disabled>
                    </div>
                    <div>
                        <label for="" class="form-label small">Teléfono</label>
                        <input type="text" class="form-control fc" disabled>
                    </div>
                    <div>
                        <label for="" class="form-label small">Correo electrónico</label>
                        <input type="text" class="form-control fc" disabled>
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

@include('elements.footer')

@include('invoice/credit-note')

<div class="modal fade" id="sendMailModal" tabindex="-1" aria-labelledby="sendMailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="fw-normal mb-0 text-secondary">Enviar por email</h6>
                <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 p-md-4">
                <div>
                    <input type="text" name="emailToSendInvoice" id="emailToSendInvoice" class="form-control fc" placeholder="Email">
                </div>
            </div>
            <div class="modal-footer px-3 px-md-4 pb-3 pb-md-4 pt-0">
                <button type="button" class="btn btn-primary btn-sm px-4">Enviar</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scriptBottom')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('js/front/datedropper.js') }}"></script>

<link rel="stylesheet" href="{{ asset('css/wpanel/library/jquery.toast.css') }}">
<script src="{{ asset('js/wpanel/library/jquery.toast.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $('.select2').select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
    } );
    
    new dateDropper({
        selector: '.dDropper',
        format: 'd/m/y',
        expandable: true,
        showArrowsOnHover: true,
    })

    function resendDocument(type, clave) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary btn-sm text-uppercase px-4 marginleft20',
                cancelButton: 'btn btn-danger btn-sm text-uppercase px-4'
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: '{{ trans('dash.invoice.index.msg.resend') }}',
            text: '{{ trans('dash.invoice.index.msg.resend.text') }}',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: '{{ trans('dash.invoice.index.yes') }}',
            cancelButtonText: '{{ trans('dash.invoice.index.no') }}',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
                    }
                });

                setCharge();
                
                $.post('{{ route('invoice.resend') }}', {type:type, clave:clave},
                    function (data){
                        location.reload();

                        hideCharge();
                    }
                );
            }
        });
    }
</script>
@endpush