@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@include('elements.docmenu')

<section class="container-fluid pb-0 pb-lg-4">
    <div class="row px-2 px-lg-3 mt-2 mt-lg-4">
        
        <form class="col-xl-7 mx-auto mt-4 mt-lg-0 mb-lg-5" id="frmProfile" name="frmProfile" method="post" action="{{ route('inventory.update') }}" onsubmit="return validSend();">
            @csrf
            <input type="hidden" name="hideId" id="hideId" value="{{ App\Models\User::encryptor('encrypt', $row->id) }}">

            <h1 class="text-center text-md-start text-uppercase h4 fw-normal mb-3">
                <a href="{{ route('inventory.index') }}" class="btn btn-sm smIcon"><i class="fa-solid fa-arrow-left-long"></i></a>
                {{ trans('dashadmin.label.title.edit') }} <span class="text-info fw-bold">{{ trans('dashadmin.label.title.product') }}</span>
            </h1>

            <div class="row gx-xl-5">
                <div class="col-md-6">
                    <div class="mb-4">
                        <label for="mname" class="form-label small">{{ trans('dashadmin.label.inventory.name') }}</label>
                        <input type="text" class="form-control fc requerido" id="mname" name="mname" value="{{ $row->title }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-4">
                        <label for="detalles" class="form-label small">{{ trans('dashadmin.label.detail') }}</label>
                        <input type="text" class="form-control fc requerido" id="detail" name="detail" value="{{ $row->description }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-4">
                        <label for="quantity" class="form-label small">{{ trans('dashadmin.label.quantity') }}</label>
                        <input type="text" class="form-control fc requerido" id="quantity" name="quantity" value="{{ $row->quantity }}" onkeydown="enterOnlyNumbers(event);">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-4">
                        <label for="mindicator" class="form-label small">{{ trans('dashadmin.label.inventory.indication') }}</label>
                        <input type="text" class="form-control fc requerido" id="mindicator" name="mindicator" value="{{ $row->instructions }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-4">
                        <label for="mindicator" class="form-label small">{{ trans('dashadmin.label.add.taxed') }}</label>
                        <select class="form-select fc requerido" name="type" id="type">
                            <option value="gravado" @if($row->type == 'gravado') selected @endif>{{ trans('dashadmin.label.add.taxed') }}</option>
                            <option value="exento" @if($row->type == 'exento') selected @endif>{{ trans('dashadmin.label.add.exonerated') }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-4">
                        <label for="cabys" class="form-label small">{{ trans('dashadmin.label.add.cabys.code') }}</label>
                        <div class="d-flex gap-3">
                            <input type="text" class="form-control fc requerido" id="cabys" name="cabys" value="{{ $row->cabys }}">
                            <button type="button" class="btn btn-outline-primary btn-sm py-0" data-bs-toggle="modal" data-bs-target="#cabysCode"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-4">
                        <label for="unity" class="form-label small">{{ trans('dashadmin.label.add.unit') }}</label>
                        <select class="form-select fc requerido" id="unit" name="unit">
                            <option value="">{{ trans('dashadmin.label.select') }}</option>
                            <option value="Producto" @if($row->unit == 'Producto') selected @endif>Producto</option>
                            <option value="Servicio" @if($row->unit == 'Servicio') selected @endif>Servicio</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-4">
                        <label for="subprice" class="form-label small">{{ trans('dashadmin.label.add.price.not.vat') }}</label>
                        <div class="input-group">
                            <span class="input-group-text fc rounded-0">¢</span>
                            <input type="text" class="form-control fc requerido" id="subprice" name="subprice" value="{{ $row->subprice }}" onkeydown="enterOnlyNumbers(event);" onkeyup="calculatePrice(1);">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-4">
                        <label for="iva" class="form-label small">{{ trans('dashadmin.label.add.tax.aggregate') }}</label>
                        <select class="form-select fc requerido" id="rate" name="rate" onchange="calculatePrice(2);">
                            <option value="">{{ trans('dashadmin.label.select') }}</option>
                            <option value="01" @if($row->rate == '01') selected @endif>Tarifa 0% (Exento)</option>
                            <option value="02" @if($row->rate == '02') selected @endif>Tarifa reducida 1%</option>
                            <option value="03" @if($row->rate == '03') selected @endif>Tarifa reducida 2%</option>
                            <option value="04" @if($row->rate == '04') selected @endif>Tarifa reducida 4%</option>
                            <option value="05" @if($row->rate == '05') selected @endif>Transitorio 0%</option>
                            <option value="06" @if($row->rate == '06') selected @endif>Transitorio 4%</option>
                            <option value="07" @if($row->rate == '07') selected @endif>Transitorio 8%</option>
                            <option value="08" @if($row->rate == '08') selected @endif>Tarifa general 13%</option>
                            <option value="09" @if($row->rate == '09') selected @endif>Tarifa reducida 0.5%</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-4">
                        <label for="price" class="form-label small">{{ trans('dashadmin.label.add.price') }}</label>
                        <div class="input-group">
                            <span class="input-group-text fc rounded-0">¢</span>
                            <input type="text" class="form-control fc requerido" id="price" name="price" value="{{ $row->price }}" onkeydown="enterOnlyNumbers(event);" onkeyup="calculatePrice(3);">
                        </div>
                    </div>
                </div>
                
            </div>

            <button type="submit" class="btn btn-primary px-5">{{ trans('dashadmin.label.inventory.save') }}</button>
        </form>

    </div>
</section>

@include('elements.footer')

<div class="modal fade" id="cabysCode" tabindex="-1" aria-labelledby="cabysCodeLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="fw-normal mb-0 text-secondary">{{ trans('dashadmin.label.cabys.search') }}</h6>
          <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-3 p-md-4">
            <form method="post" enctype="multipart/form-data">
              
                <div class="row">
                    <div class="col-md-12">
                        <label for="searchCabys" class="form-label small mb-1">{{ trans('dashadmin.label.cabys.criteria') }}</label>
                        <input type="text" name="searchCabys" id="searchCabys" class="form-control" value="" onkeyup="searchCabysMethod(this);">
                    </div>   
                </div>

                <div class="row">
                    <div class="col-md-12">
                        &nbsp;
                    </div>   
                </div>

                <div>
                  <label for="cabysModal" class="form-label small mb-1">{{ trans('dashadmin.label.cabys.codes') }}</label>
                  <select class="form-select select3" name="cabysModal" id="cabysModal"></select>
              </div>

            </form>
        </div>
        <div class="modal-footer px-3 px-md-4 pb-3 pb-md-4 pt-0">
          <button type="button" class="btn btn-primary btn-sm px-4" onclick="getCode();">{{ trans('dashadmin.label.select') }}</button>
        </div>
      </div>
    </div>
</div>

@endsection

@push('scriptBottom')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $('.select2').select2({
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
    });

    $('.select3').select2({
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        dropdownParent: $('#cabysCode')
    });

    function validSend() {
        var validate = true;

        $('.requerido').each(function(i, elem){
            var value = $(elem).val();
            var value = value.trim();
            if(value == ''){
                $(elem).addClass('is-invalid');
                validate = false;
            }else{
                $(elem).removeClass('is-invalid');
            }
        });

        if(validate == true) {
            setCharge();
        }

        return validate;
    }

    function calculatePrice(type) {
        var subprice = $('#subprice').val();
        var price = $('#price').val();
        var rate = $('#rate').val();

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

                $('#price').val(total.toFixed(2));
            }else{
                $('#price').val(subprice);
            }
        } else if(type == 2) {
            if((rate != '') && (taxes > 0)) {
                var impuesto = (taxes / 100) * parseFloat(subprice);
                var total = parseFloat(subprice) + parseFloat(impuesto);

                $('#price').val(total.toFixed(2));
            }else{
                $('#price').val(subprice);
            }
        } else if(type == 3) {
            if((rate != '') && (taxes > 0)) {
                var montoBase = parseFloat(price) / (1 + (taxes / 100));

                $('#subprice').val(montoBase.toFixed(2));
            }else{
                $('#subprice').val(price);
            }
        }
    }

    function searchCabysMethod(obj) {
        var text = $(obj).val();

        var options = '';

        if(text != '') {
            if (!isNaN(parseFloat(text)) && isFinite(text)) {
                $.getJSON("https://api.hacienda.go.cr/fe/cabys?codigo=" + text, function(json) {
                    $.each(json, function(key, val) {  
                        if (val.codigo) {
                            options += '<option value="'+val.codigo+'">' + val.descripcion + ' (' + val.codigo + ') ' + val.impuesto + '%</option>';
                        } else {
                            options = '<option value="">{{ trans('dashadmin.label.cabys.not.search') }}</option>';
                        }  

                        $('#cabysModal').html(options);
                    }); 
                });
            } else {
                $.getJSON("https://api.hacienda.go.cr/fe/cabys?q=" + text, function(json) {
                    if (json.total > 0) {
                        $.each(json.cabys, function(key, val) {
                            options += '<option value="'+val.codigo+'">' + val.descripcion + ' (' + val.codigo + ') ' + val.impuesto + '%</option>';
                        }); 
                    } else {
                        options = '<option value="">{{ trans('dashadmin.label.cabys.not.search') }}</option>';
                    }

                    $('#cabysModal').html(options);
                });
            }
        }else{
            options = '<option value="">{{ trans('dashadmin.label.cabys.not.search') }}</option>';
            $('#cabysModal').html(options);
        }
    }

    function getCode() {
        var code = $('#cabysModal').val();
        if(code != '') {
            $('#cabys').val(code);
            $('#cabysCode').modal('toggle');
        }
    }
</script>
@endpush