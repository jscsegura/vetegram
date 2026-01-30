@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@include('elements.docmenu')

<section class="container-fluid pb-0 pb-lg-4 px-xl-5">
    <div class="row px-2 px-lg-3 mt-2 mt-lg-4">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-3">
            <h1 class="h4 text-uppercase justify-content-center justify-content-md-start fw-normal mb-0 flex-grow-1 d-flex gap-1 align-items-center">
                <a href="{{ route('admin') }}" class="btn btn-sm smIcon"><i class="fa-solid fa-arrow-left-long"></i></a>
                <span>{{ trans('dashadmin.label.inventory.list.of') }} <span class="text-info fw-bold">{{ trans('dashadmin.label.title.products') }}</span></span>
            </h1>
            <div class="d-flex gap-2 align-items-center">
                <input class="form-control fc" type="text" name="searchMedicine" id="searchMedicine" placeholder="{{ trans('dashadmin.label.inventory.searh') }}" aria-label="default input example" value="{{ $search }}">
                <button type="button" data-action="Inventory.searchRows" data-action-event="click" class="btn btn-light btn-sm"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
            <a href="{{ route('inventory.upload') }}" class="btn btn-primary btn-sm d-block text-uppercase px-4">{{ trans('dashadmin.label.add.product.xml') }}</a>
            <a href="{{ route('inventory.add') }}" class="btn btn-primary btn-sm d-block text-uppercase px-4">{{ trans('dashadmin.label.add.product') }}</a>
        </div>

        <div class="col">
            <div class="card rounded-3 border-2 border-secondary px-2 px-lg-3 py-2 py-lg-3 mb-0 mb-lg-5">
                <div class="card-body p-0">
                    <table class="table table-striped table-borderless mb-0 small align-middle cTable">
                        <thead>
                            <tr>
                                <th class="px-2 px-lg-3 py-1 py-lg-3 text-uppercase small" scope="col">{{ trans('dashadmin.label.inventory.barcode') }}</th>
                                <th class="px-2 px-lg-3 py-1 py-lg-3 text-uppercase small" scope="col">{{ trans('dashadmin.label.inventory.name') }}</th>
                                <th class="px-2 px-lg-3 py-1 py-lg-3 text-uppercase small" scope="col">{{ trans('dashadmin.label.add.price') }}</th>
                                <th class="px-2 px-lg-3 py-1 py-lg-3 text-uppercase small" scope="col">{{ trans('dashadmin.label.quantity') }}</th>
                                <th class="px-2 px-lg-3 py-1 py-lg-3 text-uppercase small" scope="col">{{ trans('dashadmin.label.add.cabys.code') }}</th>
                                <th class="px-2 px-lg-3 py-1 py-lg-3 text-uppercase small text-center" scope="col">{{ trans('dashadmin.label.add.tax') }}</th>
                                <!--<th class="px-2 px-lg-3 py-1 py-lg-3 text-uppercase text-center small" scope="col" style="width: 90px">Markeplace</th>-->
                                <th class="px-2 px-lg-3 py-1 py-lg-3 text-uppercase text-center small" scope="col" style="width: 110px">{{ trans('dashadmin.label.inventory.recipe') }}</th>
                                <th class="px-2 px-lg-3 py-1 py-lg-3 text-uppercase small prodWidth text-center">{{ trans('dashadmin.label.action') }}</th>
                            </tr>
                        </thead> 
                        <tbody>
                            @foreach ($rows as $row)
                                @php 
                                    $rowid = App\Models\User::encryptor('encrypt', $row->id);
                                @endphp
                                <tr id="row{{ $rowid }}">
                                    <td class="px-2 px-lg-3 py-1 py-lg-3" data-label="{{ trans('dashadmin.label.inventory.barcode') }}:">{{ $row->barcode }}</td>
                                    <td class="px-2 px-lg-3 py-1 py-lg-3" data-label="{{ trans('dashadmin.label.inventory.name') }}:">{{ $row->title }}</td>
                                    <td class="px-2 px-lg-3 py-1 py-lg-3" data-label="{{ trans('dashadmin.label.add.price') }}:">¢{{ number_format($row->price, 2, ".", ",") }}</td>
                                    <td class="px-2 px-lg-3 py-1 py-lg-3" data-label="{{ trans('dashadmin.label.quantity') }}:">{{ preg_replace('/\.?0+$/', '', number_format($row->quantity, 2, '.', '')) }}</td>
                                    <td class="px-2 px-lg-3 py-1 py-lg-3" data-label="Cabys">{{ $row->cabys }}</td>
                                    <td class="px-2 px-lg-3 py-1 py-lg-3 text-center" data-label="{{ trans('dashadmin.label.add.tax') }}:">
                                        @switch($row->rate)
                                            @case('01') 0% @break
                                            @case('02') 1% @break
                                            @case('03') 2% @break
                                            @case('04') 4% @break
                                            @case('05') 0% @break
                                            @case('06') 4% @break
                                            @case('07') 8% @break
                                            @case('08') 13% @break
                                            @case('09') 0.5% @break
                                            @default --- @break
                                        @endswitch
                                    </td>
                                    <!--<td class="px-2 px-lg-3 py-1 py-lg-3 text-center" data-label="Markeplace:">
                                        <div class="form-check fs-6 form-switch d-inline-block align-middle">
                                            <input class="form-check-input" type="checkbox" role="switch" id="enabledMarkeplace" name="enabledMarkeplace">
                                        </div>
                                    </td>-->
                                    <td class="px-2 px-lg-3 py-1 py-lg-3 text-center" data-label="{{ trans('dashadmin.label.inventory.enabled') }}:">
                                        <div class="form-check fs-6 form-switch d-inline-block align-middle">
                                            <input class="form-check-input" type="checkbox" role="switch" id="enabledRow{{ $rowid }}" name="enabledRow" data-action="Inventory.changeStatus" data-action-event="click" data-action-args="{{ $rowid }}|$el" @if($row->enabled == 1) checked @endif>
                                        </div>
                                    </td>
                                    <td class="px-2 px-lg-3 py-1 py-lg-3 text-center" data-label="{{ trans('dashadmin.label.inventory.options') }}:">
                                        <div class="d-inline-block align-left gap-2"> 
                                            <a class="apIcon d-md-inline-block" href="{{ route('inventory.edit', $rowid) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ trans('dashadmin.label.inventory.edit') }}">
                                                <i class="fa-solid fa-pencil"></i>
                                            </a>
                                            <a class="apIcon d-md-inline-block" href="{{ route('inventory.history', $rowid) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ trans('dashadmin.label.title.history') }}">
                                                <i class="fa-solid fa-history"></i> 
                                            </a>
                                            <a class="apIcon d-md-inline-block" href="javascript:void(0);" data-action="Inventory.removeMedicine" data-action-event="click" data-action-args="{{ $rowid }}|$el" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ trans('dashadmin.label.inventory.delete') }}">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>    
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            {{ $rows->links() }} 
            
        </div>
    </div>
</section>

@include('elements.footer')

@endsection

@push('scriptBottom')
<link rel="stylesheet" href="{{ asset('css/wpanel/library/jquery.toast.css') }}">
<script src="{{ asset('js/wpanel/library/jquery.toast.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    window.INVENTORY_INDEX_CONFIG = {
        routes: {
            searchBase: @json(url('inventory/list')),
            deleteUrl: @json(route('inventory.delete')),
            changeEnabledUrl: @json(route('inventory.changeEnabled'))
        },
        texts: {
            deleteTitle: @json(trans('dashadmin.msg.delete.medicine')),
            deleteConfirm: @json(trans('dashadmin.msg.confir.delete.medicine')),
            deleteYes: @json(trans('dashadmin.label.yes.delete')),
            deleteNo: @json(trans('dashadmin.label.not.delete')),
            deleteError: @json(trans('dashadmin.msg.error.delete.medicine')),
            enabledSuccess: @json(trans('dashadmin.msg.success.enabled.medicine')),
            enabledError: @json(trans('dashadmin.msg.error.enabled.medicine'))
        },
        selectors: {
            searchInput: '#searchMedicine',
            rowPrefix: '#row'
        }
    };
</script>
<script src="{{ asset('js/inventory/index.js') }}"></script>


@endpush
