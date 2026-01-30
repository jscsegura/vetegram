@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@include('elements.docmenu')

<section class="container-fluid pb-0 pb-lg-4 px-xl-5">
    <div class="row px-2 px-lg-3 mt-2 mt-lg-4">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-3">
            <h1 class="h4 text-uppercase justify-content-center justify-content-md-start fw-normal mb-0 flex-grow-1 d-flex gap-1 align-items-center">
                <a href="{{ route('schedule.menu') }}" class="btn btn-sm smIcon"><i class="fa-solid fa-arrow-left-long"></i></a>
                <span>{{ trans('dashadmin.label.inventory.list.of') }} <span class="text-info fw-bold">{{ trans('dash.schedule.exception.title') }}</span></span>
            </h1>
            <div class="d-flex gap-2 align-items-center">
                <input class="form-control fc" type="text" name="searchException" id="searchException" placeholder="{{ trans('dash.schedule.exception.search') }}" aria-label="default input example" value="{{ $search }}">
                <button type="button" class="btn btn-light btn-sm" data-schedule-action="exception-search"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
            <a href="{{ route('schedule.exception.add') }}" class="btn btn-primary btn-sm d-block text-uppercase px-4">{{ trans('dash.schedule.exception.add') }}</a>
        </div>

        <div class="col">
            <div class="card rounded-3 border-2 border-secondary px-2 px-lg-3 py-2 py-lg-3 mb-0 mb-lg-5">
                <div class="card-body p-0">
                    <table class="table table-striped table-borderless mb-0 small align-middle cTable">
                        <thead>
                            <tr>
                                <th class="px-2 px-lg-3 py-1 py-lg-3 text-uppercase small" scope="col">{{ trans('dash.schedule.exception.description') }}</th>
                                <th class="px-2 px-lg-3 py-1 py-lg-3 text-uppercase small" scope="col">{{ trans('dash.schedule.exception.date') }}</th>
                                <th class="px-2 px-lg-3 py-1 py-lg-3 text-uppercase small" scope="col">{{ trans('dash.schedule.exception.start') }}</th>
                                <th class="px-2 px-lg-3 py-1 py-lg-3 text-uppercase small" scope="col">{{ trans('dash.schedule.exception.end') }}</th>
                                <th class="px-2 px-lg-3 py-1 py-lg-3 text-uppercase small prodWidth text-center">{{ trans('dash.schedule.action') }}</th>
                            </tr>
                        </thead> 
                        <tbody>
                            @foreach ($rows as $row)
                                @php 
                                    $rowid = App\Models\User::encryptor('encrypt', $row->id);
                                @endphp
                                <tr id="row{{ $rowid }}">
                                    <td class="px-2 px-lg-3 py-1 py-lg-3" data-label="{{ trans('dash.schedule.exception.description') }}:">{{ $row->description }}</td>
                                    <td class="px-2 px-lg-3 py-1 py-lg-3" data-label="{{ trans('dash.schedule.exception.date') }}:">{{ $row->date }}</td>
                                    <td class="px-2 px-lg-3 py-1 py-lg-3" data-label="{{ trans('dash.schedule.exception.start') }}:">{{ $row->start_time }}</td>
                                    <td class="px-2 px-lg-3 py-1 py-lg-3" data-label="{{ trans('dash.schedule.exception.end') }}:">{{ $row->end_time }}</td>
                                   
                                    <td class="px-2 px-lg-3 py-1 py-lg-3 text-center" data-label="{{ trans('dash.schedule.exception.options') }}:">
                                        <div class="d-inline-block align-left gap-2"> 
                                            <a class="apIcon d-md-inline-block" href="{{ route('schedule.exception.edit', $rowid) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ trans('dash.schedule.exception.edit') }}">
                                                <i class="fa-solid fa-pencil"></i>
                                            </a>
                                            <a class="apIcon d-md-inline-block" href="javascript:void(0);" data-schedule-action="exception-delete" data-row-id="{{ $rowid }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ trans('dash.schedule.exception.delete') }}">
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
    window.SCHEDULE_EXCEPTION_INDEX_CONFIG = {
        routes: {
            searchBase: @json(url('schedule/exception/index')),
            delete: @json(route('schedule.exception.delete'))
        },
        texts: {
            deleteTitle: @json(trans('dash.schedule.exception.msg.delete')),
            deleteConfirm: @json(trans('dash.schedule.exception.msg.confirm.delete')),
            deleteYes: @json(trans('dash.schedule.exception.yes.delete')),
            deleteNo: @json(trans('dash.schedule.exception.not.delete')),
            deleteError: @json(trans('dash.schedule.exception.msg.error.delete'))
        }
    };
</script>
<script src="{{ asset('js/schedule/exception-index.js') }}"></script>
@endpush
