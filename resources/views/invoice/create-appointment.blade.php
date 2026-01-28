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
            <form name="frmInv" id="frmInv" action="{{ route('invoice.store') }}" method="post" onsubmit="return validaSubmitInvoice();">
                @csrf
                <input type="hidden" name="proformId" id="proformId" value="{{ (isset($proformId)) ? $proformId : 0 }}">
                <input type="hidden" name="typeInvoice" id="typeInvoice" value="0">
                <div class="card rounded-3 border-2 border-secondary px-2 px-lg-3 py-2 py-lg-3 mb-3">
                    <div class="row row-cols-1 row-cols-md-3 g-3 g-md-4 mb-4 mb-md-5 px-2">
                        <div>
                            <label for="clientName" class="form-label small">{{ trans('dash.label.element.client') }}</label>
                            <select class="form-select select2 requerido" name="client" id="client" onchange="selectClient(this);">
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
                                <tr id="rowInvoice{{ $row['id'] }}">
                                    <input type="hidden" name="productCode[]" id="productCode{{ $row['id'] }}" class="productCodeList" value="{{ $row['id'] }}">
                                    <input type="hidden" name="productId[]" id="productId{{ $row['id'] }}" value="{{ $row['id'] }}">

                                    <input type="hidden" name="cabys[]" id="cabys{{ $row['id'] }}" value="{{ $row['cabys'] }}">
                                    <input type="hidden" name="unit[]" id="unit{{ $row['id'] }}" value="{{ $row['unit'] }}">

                                    <td class="px-2 py-2 py-lg-4" data-label="Eliminar:">
                                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeRow('{{ $row['id'] }}');">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </td>
                                    <td class="px-2 py-2 py-lg-4" data-label="Cantidad:">
                                        <div class="d-table">
                                            <div class="input-group w-auto align-items-center">
                                                <input type="text" class="form-control form-control-sm fw-semibold text-center requerido" id="quantity{{ $row['id'] }}" name="quantity[]" value="{{ $row['quantity'] }}" onchange="setQuantity('{{ $row['id'] }}');" onkeydown="enterOnlyNumbers(event);" size="1">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-2 py-2 py-lg-4" data-label="Pro/Ser:">
                                        <select class="form-select form-select-sm select2 requerido" id="product{{ $row['id'] }}" name="product[]">
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
                                        <input type="text" class="form-control form-control-sm requerido" name="productSubPrice[]" id="productSubPrice{{ $row['id'] }}" value="{{ $row['subprice'] }}" onkeyup="calculatePrice('{{ $row['id'] }}', 1);" onkeydown="enterOnlyNumbers(event);">
                                    </td>
                                    <td class="px-2 py-2 py-lg-4" data-label="IVA:">
                                        <select class="form-select form-select-sm requerido" id="rate{{ $row['id'] }}" name="rate[]" onchange="calculatePrice('{{ $row['id'] }}', 2);">
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
                                        <input type="text" class="form-control form-control-sm requerido" name="productPrice[]" id="productPrice{{ $row['id'] }}" value="{{ $row['price'] }}" onkeyup="calculatePrice('{{ $row['id'] }}', 3);" onkeydown="enterOnlyNumbers(event);">
                                    </td>
                                    <td class="px-2 py-2 py-lg-4 text-end" data-label="Tot. lin.:" id="printPriceTotalLine{{ $row['id'] }}">¢{{ number_format(($row['quantity'] * $row['price']), 2, ".", ",") }}</td>
                                    @php
                                        $total = $total + ($row['quantity'] * $row['price']);
                                    @endphp
                                </tr>
                                @endforeach
                                
                                <tr id="btnAddline">
                                    <td class="px-2 py-0 py-md-2 py-lg-4 text-end shadow-none" colspan="9">
                                        <button type="button" onclick="newLine();" class="btn btn-outline-primary btn-sm px-4"><i class="fa-solid fa-plus me-1"></i>{{ trans('dash.label.add.line') }}</button>
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
                    <button type="button" onclick="createInvoice(0);" class="btn btn-primary px-4">{{ trans('dash.label.create.invoice') }}</button>
                    <button type="button" onclick="createInvoice(1);" class="btn btn-primary px-4">{{ trans('dash.label.create.proforma') }}</button>
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

@php echo '<script> var arrayProducts = ' . json_encode($products) . ';</script>'; @endphp

<script>
    var varBtnAddLine = '<tr id="btnAddline">' +
                            '<td class="px-2 px-lg-3 py-0 py-md-2 py-lg-4 text-end shadow-none" colspan="9">' +
                                '<button type="button" onclick="newLine();" class="btn btn-outline-primary btn-sm px-4"><i class="fa-solid fa-plus me-1"></i>Agregar línea</button>' +
                            '</td>' +
                        '</tr>';

    $('.select2').select2({
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
    });
    
    new dateDropper({
        selector: '.dDropper',
        format: 'd/m/y',
        expandable: true,
        showArrowsOnHover: true,
    });

    function selectClient(obj) {        
        var name = $(obj).find('option:selected').attr('data-name');
        var phone = $(obj).find('option:selected').attr('data-phone');
        var email = $(obj).find('option:selected').attr('data-email');
        var typedni = $(obj).find('option:selected').attr('data-typedni');
        var dni = $(obj).find('option:selected').attr('data-dni');

        $('#invoiceName').val(name);
        $('#invoiceDniType').val(typedni);
        $('#invoiceDni').val(dni);
        $('#invoicePhone').val(phone);
        $('#invoiceEmail').val(email);
    }

    function createInvoice(type) {
        $('#typeInvoice').val(type);
        $('#frmInv').submit();
    }

    function validaSubmitInvoice() {
        var valida = true;

        $('.requerido').each(function(i, elem){
            var value = $(elem).val();
            var value = value.trim();
            if(value == ''){
                $(elem).addClass('is-invalid');
                valida = false;
            }else{
                $(elem).removeClass('is-invalid');
            }
        });

        if(valida == true) {
            setCharge();
        }

        return valida;
    }

    function newLine() {
        var random = getRamdom();

        var listProducts = '<option value="">{{ trans('dash.label.selected') }}</option><option value="0" random="'+random+'" data-id="0" description="" subprice="0" price="0" type="gravado" cabys="3564001000000" rate="08" unit="Producto">Otro</option>';
        $.each(arrayProducts, function(index, value) {
            listProducts = listProducts + '<option value="'+value.id+'" random="'+random+'" data-id="'+value.id+'" description="'+value.description+'" subprice="'+value.subprice+'" price="'+value.price+'" type="'+value.type+'" cabys="'+value.cabys+'" rate="'+value.rate+'" unit="'+value.unit+'">'+value.title+'</option>';
        });

        var txt = '<tr id="rowInvoice'+random+'">' +
                    '<input type="hidden" name="productCode[]" id="productCode'+random+'" class="productCodeList" value="'+random+'">' +
                    '<input type="hidden" name="productId[]" id="productId'+random+'" value="0">' +
                    '<input type="hidden" name="cabys[]" id="cabys'+random+'" value="">' +
                    '<input type="hidden" name="unit[]" id="unit'+random+'" value="">' +
                    '<td class="px-2 py-2 py-lg-4" data-label="Eliminar:">' +
                        '<button type="button" class="btn btn-outline-danger btn-sm" onclick="removeRow(\''+random+'\');">' +
                            '<i class="fa-solid fa-xmark"></i>' +
                        '</button>' +
                    '</td>' +
                    '<td class="px-2 py-2 py-lg-4" data-label="Cantidad:">' +
                        '<div class="d-table">' +
                            '<div class="input-group w-auto align-items-center">' +
                                '<input type="text" class="form-control form-control-sm fw-semibold text-center requerido" id="quantity'+random+'" name="quantity[]" value="1" size="1" onchange="setQuantity(\''+random+'\');" onkeydown="enterOnlyNumbers(event);">' +
                            '</div>' +
                        '</div>' +
                    '</td>' +
                    '<td class="px-2 py-2 py-lg-4" data-label="Pro/Ser:">' +
                        '<select class="form-select form-select-sm select2 requerido" id="product'+random+'" name="product[]" onchange="selectRow(this);">' +
                            listProducts +
                        '</select>' +
                    '</td>' +
                    '<td class="px-2 py-2 py-lg-4" data-label="Detalles:">' +
                        '<input type="text" class="form-control form-control-sm requerido" name="detail[]" id="detail'+random+'" value="">' +
                    '</td>' +
                    '<td class="px-2 py-2 py-lg-4" data-label="Gravado:">' +
                        '<select class="form-select form-select-sm requerido" id="gravado'+random+'" name="gravado[]">' +
                            '<option value=""></option>' +
                            '<option value="gravado">Gravado</option>' +
                            '<option value="exento">Exento</option>' +
                        '</select>' +
                    '</td>' +
                    '<td class="px-2 py-2 py-lg-4" data-label="Precio:">' +
                        '<input type="text" class="form-control form-control-sm requerido" name="productSubPrice[]" id="productSubPrice'+random+'" value="0" onkeyup="calculatePrice(\''+random+'\', 1);" onkeydown="enterOnlyNumbers(event);">' +
                    '</td>' +
                    '<td class="px-2 py-2 py-lg-4" data-label="IVA:">' +
                        '<select class="form-select form-select-sm requerido" id="rate'+random+'" name="rate[]" onchange="calculatePrice(\''+random+'\', 2);">' +
                            '<option value=""></option>' +
                            '<option value="01">0%</option>' +
                            '<option value="02">1%</option>' +
                            '<option value="03">2%</option>' +
                            '<option value="04">4%</option>' +
                            '<option value="05">0%</option>' +
                            '<option value="06">4%</option>' +
                            '<option value="07">8%</option>' +
                            '<option value="08">13%</option>' +
                            '<option value="09">0.5%</option>' +
                        '</select>' +
                    '</td>' +
                    '<td class="px-2 py-2 py-lg-4 text-end" data-label="Precio:">' +
                        '<input type="text" class="form-control form-control-sm requerido" name="productPrice[]" id="productPrice'+random+'" value="0" onkeyup="calculatePrice(\''+random+'\', 3);" onkeydown="enterOnlyNumbers(event);">' +
                    '</td>' +
                    '<td class="px-2 py-2 py-lg-4 text-end" data-label="Tot. lin.:" id="printPriceTotalLine'+random+'">¢0.00</td>' +
                '</tr>';

        $('#btnAddline').remove();
        $('#rowsInvoice').append(txt);
        $('#rowsInvoice').append(varBtnAddLine);

        $('.select2').select2({
            theme: "bootstrap-5",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: $( this ).data( 'placeholder' ),
        });
    }

    function selectRow(obj) {
        var option = $(obj).find('option:selected');

        var random = option.attr('random');
        var id = option.attr('data-id');
        var description = option.attr('description');
        var subprice = option.attr('subprice');
        var price = option.attr('price');
        var type = option.attr('type');
        var cabys = option.attr('cabys');
        var rate = option.attr('rate'); 
        var cabys = option.attr('cabys'); 
        var unit = option.attr('unit'); 
           
        $('#productId' + random).val(id);
        $('#productSubPrice' + random).val(subprice);
        $('#productPrice' + random).val(price);
        $('#detail' + random).val(description);
        $('#gravado' + random).val(type);
        $('#rate' + random).val(rate);
        $('#cabys' + random).val(cabys);
        $('#unit' + random).val(unit);

        if(price > 0) {
            var quantity = $('#quantity' + random).val();
            if (isNaN(quantity)) {
                quantity = 1;
            }
            $('#printPriceTotalLine' + random).html('¢' + numeral(price * quantity).format('0,0.00'));
        }else{
            $('#printPriceTotalLine' + random).html('¢0.00');
        }

        setTotals();
    }

    function setQuantity(id) {
        var price = $('#productPrice' + id).val();
        var quantity = $('#quantity' + id).val();

        if(price > 0) {
            if (isNaN(quantity)) {
                quantity = 1;
            }

            $('#printPriceTotalLine' + id).html('¢' + numeral(price * quantity).format('0,0.00'));
        }else{
            $('#printPriceTotalLine' + id).html('¢0.00');
        }

        setTotals();
    }

    function calculatePrice(id, type) {
        var subprice = $('#productSubPrice' + id).val();
        var price = $('#productPrice' + id).val();
        var rate = $('#rate' + id).val();

        if(subprice == '') {
            subprice = 0;
        }

        if(price == '') {
            price = 0;
        }

        var taxes = 0;
        switch (rate) {
            case "01": taxes = 0; break;
            case "02": taxes = 1; break;
            case "03": taxes = 2; break;
            case "04": taxes = 4; break;
            case "05": taxes = 0; break;
            case "06": taxes = 4; break;
            case "07": taxes = 8; break;
            case "08": taxes = 13; break;
            case "09": taxes = 0.5; break;
            default: taxes = 0; break;
        }

        if(type == 1) {
            if((rate != '') && (taxes > 0)) {
                var impuesto = (taxes / 100) * parseFloat(subprice);
                var total = parseFloat(subprice) + parseFloat(impuesto);

                $('#productPrice' + id).val(total.toFixed(2));
            }else{
                $('#productPrice' + id).val(subprice);
            }
        } else if(type == 2) {
            if((rate != '') && (taxes > 0)) {
                var impuesto = (taxes / 100) * parseFloat(subprice);
                var total = parseFloat(subprice) + parseFloat(impuesto);

                $('#productPrice' + id).val(total.toFixed(2));
            }else{
                $('#productPrice' + id).val(subprice);
            }
        } else if(type == 3) {
            if((rate != '') && (taxes > 0)) {
                var montoBase = parseFloat(price) / (1 + (taxes / 100));

                $('#productSubPrice' + id).val(montoBase.toFixed(2));
            }else{
                $('#productSubPrice' + id).val(price);
            }
        }

        setQuantity(id);
    }

    function setTotals() {
        var total = 0;

        $('.productCodeList').each(function(index, elemento) {
            var code = $(this).val();

            var price = $('#productPrice' + code).val();
            var quantity = $('#quantity' + code).val();

            if(price > 0) {
                if (isNaN(quantity)) {
                    quantity = 1;
                }

                total = total + (price * quantity);
            }
        });

        $('#printerGranTotal').html('¢' + numeral(total).format('0,0.00'));
    }

    function removeRow(id) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary btn-sm text-uppercase px-4 marginleft20',
                cancelButton: 'btn btn-danger btn-sm text-uppercase px-4'
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: '{{ trans('dash.msg.delete.row.invoice') }}',
            text: '{{ trans('dash.msg.confir.delete.row.invoice') }}',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: '{{ trans('dash.label.yes.delete') }}',
            cancelButtonText: '{{ trans('dash.label.no.cancel') }}',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $('#rowInvoice' + id).remove();

                setTotals();
            }
        });
    }

    function getRamdom() {
        var random = Math.random();
        random = random + "";
        random = random.replace(".", "");
        random = random.replaceAll(/0/g, "1");

        return random;
    }

    function enterOnlyNumbers(event){
        if (event.keyCode == 8 || event.keyCode == 9 || (event.keyCode >= 37 && event.keyCode <= 40) || (event.keyCode == 190)) {
        } else {
            if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault();
            }
        }
    }
</script>
@endpush