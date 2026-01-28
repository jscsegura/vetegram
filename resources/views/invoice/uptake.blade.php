@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@include('elements.docmenu')

<section class="invoiceWidth2 pb-0 pb-lg-4">
    <div class="row px-2 px-lg-3 mt-2 mt-lg-4 mb-lg-5">
        <div class="col">

            @if(isset($error))
                <div class="alert alert-danger small mt-3 mb-0" role="alert">
                    {{ $error }}
                </div>
                <br>
            @endif

            @if(isset($message))
                <div class="alert alert-{{ $msgType }} small mt-3 mb-0" role="alert">
                    {{ $message }}
                </div>
                <br>
            @endif

            <form name="frm" id="frm" action="{{ route('process.uptake') }}" method="POST" onsubmit="return validateXml();" enctype="multipart/form-data">
                @csrf
                <h1 class="h4 text-uppercase justify-content-center justify-content-md-start fw-normal mb-2 mb-lg-3 flex-grow-1 d-flex gap-1 align-items-center">
                    <span>Aceptar <span class="text-info fw-bold">factura</span></span>
                </h1>
                <div class="card rounded-3 border-2 border-secondary px-3 px-lg-4 py-3 py-lg-4 mb-3">

                    <div class="row g-3 g-md-4 mb-2 px-2">
                        <div class="col-12">
                            <label for="uploadinvoice" class="form-label small">Subir factura</label>
                            <input type="file" class="form-control" id="uploadinvoice" name="uploadinvoice" style="padding: .375rem .75rem;" accept="text/xml">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="uptake" class="form-label small">Tipo de aceptación</label>
                            <select class="form-select fc" id="uptake" name="uptake">
                                <option value="1" selected>Aceptado</option>
                                <option value="2">Aceptación parcial</option>
                                <option value="3">Rechazado</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="condition" class="form-label small">Condición de impuesto</label>
                            <select class="form-select fc" id="condition" name="condition">
                                <option value="01" selected>Genera crédito IVA</option>
                                <option value="02">Genera Crédito parcial del IVA</option>
                                <option value="03">Bienes de Capital</option>
                                <option value="04">Gasto corriente no genera crédito</option>
                                <option value="05">Proporcionalidad</option>
                            </select>
                        </div>
                    </div>

                </div>

                <button type="submit" class="btn btn-primary px-4">Subir</button>
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

    function validateXml() {
        var inputFile = $('#uploadinvoice')[0].files[0];

        if (!inputFile) {
            $.toast({
                text: '{{ trans('dash.msg.select.file') }}',
                position: 'bottom-right',
                textAlign: 'center',
                loader: false,
                hideAfter: 4000,
                icon: 'warning'
            });
            event.preventDefault();
            return false;
        }

        var tiposPermitidos = ['text/xml', 'xml'];
        if ($.inArray(inputFile.type, tiposPermitidos) === -1) {
            $.toast({
                text: '{{ trans('dash.msg.select.file.only.xml') }}',
                position: 'bottom-right',
                textAlign: 'center',
                loader: false,
                hideAfter: 4000,
                icon: 'warning'
            });
            event.preventDefault();
            return false;
        }

        return true;

    }
</script>
@endpush