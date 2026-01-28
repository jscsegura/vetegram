@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@include('elements.docmenu')

<section class="container-fluid pb-0 pb-lg-4 px-xl-5">
    <div class="row px-2 px-lg-3 mt-2 mt-lg-4">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-3">
            <h1 class="h4 text-uppercase justify-content-center justify-content-md-start fw-normal mb-0 flex-grow-1 d-flex gap-1 align-items-center">
                <a href="{{ route('inventory.index') }}" class="btn btn-sm smIcon"><i class="fa-solid fa-arrow-left-long"></i></a>
                <span>{{ trans('dashadmin.label.inventory.list.of') }} <span class="text-info fw-bold">{{ trans('dashadmin.label.title.history') }}</span></span>
                <span>{{ $info->product }}</span>
            </h1>
        </div> 
        <div class="col"> 
            <div class="card rounded-3 border-2 border-secondary px-2 px-lg-3 py-2 py-lg-3 mb-0 mb-lg-5">
                <div class="card-body p-0">
                    <table class="table table-striped table-borderless mb-0 small align-middle cTable">
                        <thead>
                            <tr>
                                <th class="px-2 px-lg-3 py-1 py-lg-3 text-uppercase small" scope="col">{{ trans('dashadmin.label.created') }}</th>
                                <th class="px-2 px-lg-3 py-1 py-lg-3 text-uppercase small" scope="col">{{ trans('dashadmin.label.inventory.history.movement_type') }}</th>
                                <th class="px-2 px-lg-3 py-1 py-lg-3 text-uppercase small" scope="col">{{ trans('dashadmin.label.quantity') }}</th>
                                <th class="px-2 px-lg-3 py-1 py-lg-3 text-uppercase small" scope="col">{{ trans('dashadmin.label.notes') }}</th>
                                <th class="px-2 px-lg-3 py-1 py-lg-3 text-uppercase small" scope="col">{{ trans('dashadmin.label.owner') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rows as $row)
                                @php
                                    $rowid = App\Models\User::encryptor('encrypt', $row->id);
                                @endphp
                                <tr id="row{{ $rowid }}"> 
                                    <td class="px-2 px-lg-3 py-1 py-lg-3" data-label="{{ trans('dashadmin.label.created') }}:">{{ $row->created_at }}</td>
                                    <td class="px-2 px-lg-3 py-1 py-lg-3" data-label="{{ trans('dashadmin.label.inventory.history.movement_type') }}:">{{ ucfirst($row->movement_type->value) }}</td>
                                    <td class="px-2 px-lg-3 py-1 py-lg-3" data-label="{{ trans('dashadmin.label.quantity') }}:">{{ $row->movement_type->value == 'salida' ? '-' : '' }}{{ $row->quantity }}</td>
                                    <td class="px-2 px-lg-3 py-1 py-lg-3" data-label="{{ trans('dashadmin.label.notes') }}:">{{ $row->notes }}</td>
                                    <td class="px-2 px-lg-3 py-1 py-lg-3" data-label="{{ trans('dashadmin.label.owner') }}:">{{ $row->name }} {{ $row->lastname }}</td>
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
@endpush
