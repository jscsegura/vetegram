@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@include('elements.docmenu')

<section class="container-fluid pb-0 pb-lg-4">
    <div class="row px-2 px-lg-3 mt-2 mt-lg-4">
        
        <form class="col-xl-7 mx-auto mt-4 mt-lg-0 mb-lg-5" id="frmProfile" name="frmProfile" method="post" action="{{ route('inventory.update') }}" data-action="Inventory.validSend" data-action-event="submit">
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
                        <input type="text" class="form-control fc requerido" id="quantity" name="quantity" value="{{ $row->quantity }}" data-action="vetegramHelpers.enterOnlyNumbers" data-action-event="keydown" data-action-args="$event">
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
                            <input type="text" class="form-control fc requerido inventory-numeric" id="subprice" name="subprice" value="{{ $row->subprice }}" data-action="Inventory.calculatePrice" data-action-event="keyup" data-action-args="1">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-4">
                        <label for="iva" class="form-label small">{{ trans('dashadmin.label.add.tax.aggregate') }}</label>
                        <select class="form-select fc requerido" id="rate" name="rate" data-action="Inventory.calculatePrice" data-action-event="change" data-action-args="2">
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
                            <input type="text" class="form-control fc requerido inventory-numeric" id="price" name="price" value="{{ $row->price }}" data-action="Inventory.calculatePrice" data-action-event="keyup" data-action-args="3">
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
                        <input type="text" name="searchCabys" id="searchCabys" class="form-control" value="" data-action="Inventory.searchCabysMethod" data-action-event="keyup" data-action-args="$el">
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
          <button type="button" class="btn btn-primary btn-sm px-4" data-action="Inventory.getCode" data-action-event="click">{{ trans('dashadmin.label.select') }}</button>
        </div>
      </div>
    </div>
</div>

@endsection

@push('scriptBottom')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    window.INVENTORY_FORM_CONFIG = {
        texts: {
            cabysNotSearch: @json(trans('dashadmin.label.cabys.not.search'))
        },
        selectors: {
            cabysModal: '#cabysModal',
            cabysInput: '#cabys',
            cabysModalParent: '#cabysCode',
            rate: '#rate',
            subprice: '#subprice',
            price: '#price'
        }
    };
</script>
<script src="{{ asset('js/inventory/form.js') }}"></script>
@endpush
