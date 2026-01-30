@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@include('elements.docmenu')

<section class="container-fluid pb-0 pb-lg-4 px-xl-5">
    <div class="row px-2 px-lg-3 mt-2 mt-lg-4">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-3">
            <h1 class="h4 text-uppercase justify-content-center justify-content-md-start fw-normal mb-0 flex-grow-1 d-flex gap-1 align-items-center">
                <a href="{{ route('admin') }}" class="btn btn-sm smIcon"><i class="fa-solid fa-arrow-left-long"></i></a>
                <span>{{ trans('dashadmin.label.inventory.list.of') }} <span class="text-info fw-bold">{{ trans('dashadmin.label.title.user') }}</span></span>
            </h1>
            <div class="d-flex gap-2 align-items-center">
                <input class="form-control fc" type="text" name="searchUser" id="searchUser" placeholder="{{ trans('dashadmin.label.inventory.searh') }}" aria-label="default input example" value="{{ $search }}">
                <button type="button" data-action="Users.searchRows" data-action-event="click" class="btn btn-light btn-sm"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
            @if($limiteExcede == true)
            <a href="javascript:void(0);" data-action="Users.excedeLimite" data-action-event="click" class="btn btn-primary btn-sm d-block text-uppercase px-4">{{ trans('dashadmin.label.add.user') }}</a>
            @else
            <a href="{{ route('adminuser.add') }}" class="btn btn-primary btn-sm d-block text-uppercase px-4">{{ trans('dashadmin.label.add.user') }}</a>
            @endif
        </div>

        <div class="col">
            <div class="card rounded-3 border-2 border-secondary px-2 px-lg-3 py-2 py-lg-3 mb-0 mb-lg-5">
                <div class="card-body p-0">
                    <table class="table table-striped table-borderless mb-0 small align-middle rTable v2">
                        <thead>
                            <tr>
                                <th class="px-2 px-lg-3 py-1 py-lg-3 text-uppercase small" style="width: 80px;"></th>
                                <th class="px-2 px-lg-3 py-1 py-lg-3 text-uppercase small" scope="col">{{ trans('dashadmin.label.column.name') }}</th>
                                <th class="px-2 px-lg-3 py-1 py-lg-3 text-uppercase small" scope="col">{{ trans('dashadmin.label.column.speciality') }}</th>
                                <th class="px-2 px-lg-3 py-1 py-lg-3 text-uppercase small" scope="col">{{ trans('dashadmin.label.column.email') }}</th>
                                <th class="px-2 px-lg-3 py-1 py-lg-3 text-uppercase small" scope="col">{{ trans('dashadmin.label.column.phone') }}</th>
                                <th class="px-2 px-lg-3 py-1 py-lg-3 text-uppercase text-center small" scope="col">{{ trans('dashadmin.label.column.enabled') }}</th>
                                <th class="px-2 px-lg-3 py-1 py-lg-3 text-uppercase small"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rows as $row)
                                @php
                                    $rowid = App\Models\User::encryptor('encrypt', $row->id);
                                    $photo = asset('img/default2.png');
                                    if($row->photo != '') {
                                        $photo = asset($row->photo);
                                    }
                                @endphp
                                <tr id="row{{ $rowid }}">
                                    <td class="px-2 px-lg-3 py-2 py-lg-3" data-label="{{ trans('dashadmin.label.column.photo') }}:">
                                        <div class="petPhoto d-inline-block align-top rounded-circle m-0" style="background-image: url({{ $photo }});"></div>
                                    </td>
                                    <td class="px-2 px-lg-3 py-2 py-lg-3 fw-semibold" data-label="{{ trans('dashadmin.label.column.name') }}:">
                                        {{ $row->name }}
                                        @if($row->complete == 0)
                                        <div><span class="badge rounded-pill text-bg-secondary px-3 text-capitalize mt-1"><i class="fa-solid fa-triangle-exclamation me-2"></i>{{ trans('dashadmin.label.pending') }}</span></div>
                                        @endif
                                    </td>
                                    <td class="px-2 px-lg-3 py-2 py-lg-3" data-label="{{ trans('dashadmin.label.column.special') }}.:">{{ trans('dash.rol.name.' . $row->rol_id) }}</td>
                                    <td class="px-2 px-lg-3 py-2 py-lg-3 text-break" data-label="{{ trans('dashadmin.label.column.email') }}:">{{ $row->email }}</td>
                                    <td class="px-2 px-lg-3 py-2 py-lg-3" data-label="{{ trans('dashadmin.label.column.phone') }}:">{{ $row->phone }}</td>
                                    <td class="px-2 px-lg-3 py-2 py-lg-3 text-center" data-label="{{ trans('dashadmin.label.column.enabled') }}:">
                                        <div class="form-check fs-6 form-switch d-inline-block align-middle">
                                            <input class="form-check-input" type="checkbox" role="switch" id="enabledRow{{ $rowid }}" name="enabledRow" data-action="Users.changeStatus" data-action-event="click" data-action-args="{{ $rowid }}|$el" @if($row->lock == 0) checked @endif @if($row->rol_id == 3) disabled @endif>
                                        </div>
                                    </td>
                                    <td class="px-2 px-lg-3 py-2 py-lg-3" data-label="{{ trans('dashadmin.label.inventory.options') }}:">
                                        <div class="d-flex gap-1 justify-content-md-end">
                                            <a class="apIcon d-md-flex gap-1 align-items-center" href="{{ route('adminuser.edit', $rowid) }}">
                                                <i class="fa-regular fa-eye"></i>
                                                <span class="d-none d-lg-inline-block">{{ trans('dashadmin.label.inventory.see') }}</span>
                                            </a>
                                            @if($row->rol_id != 3)
                                            <a class="apIcon d-md-flex gap-1 align-items-center" href="javascript:void(0);" data-action="Users.removeUser" data-action-event="click" data-action-args="{{ $rowid }}|$el">
                                                <i class="fa-regular fa-trash-can"></i>
                                                <span class="d-none d-lg-inline-block">{{ trans('dashadmin.label.inventory.delete') }}</span>
                                            </a>
                                            @endif
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
    window.USERS_INDEX_CONFIG = {
        routes: {
            searchBase: @json(url('adminuser/list')),
            deleteUser: @json(route('adminuser.delete')),
            changeStatus: @json(route('adminuser.changeLock'))
        },
        texts: {
            deleteTitle: @json(trans('dashadmin.msg.delete.user')),
            deleteConfirm: @json(trans('dashadmin.msg.confir.delete.user')),
            deleteYes: @json(trans('dashadmin.label.yes.delete')),
            deleteNo: @json(trans('dashadmin.label.not.delete')),
            deleteError: @json(trans('dashadmin.msg.error.delete.user')),
            statusSuccess: @json(trans('dashadmin.msg.success.enabled.medicine')),
            statusError: @json(trans('dashadmin.msg.error.enabled.medicine')),
            limitTitle: @json(trans('dash.swal.msg.limite.users')),
            limitMessage: @json(trans('dash.swal.msg.limite.users.text', ['maxUsers' => $maxUsers]) . " <a href='" . route('plan') . "'>" . trans('auth.label.text.here') . "</a>")
        }
    };
</script>
<script src="{{ asset('js/users/index.js') }}"></script>
@endpush
