@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@php $weblang = \App::getLocale(); @endphp

@include('elements.docmenu')

<section class="container-fluid pb-0 pb-lg-4 px-xl-5">
    <div class="row px-2 px-lg-3 mt-2 mt-lg-4">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-3">
            <h1 class="h4 text-uppercase justify-content-center justify-content-md-start fw-normal mb-0 flex-grow-1 d-flex gap-1 align-items-center">
                <a href="{{ route('admin') }}" class="btn btn-sm smIcon"><i class="fa-solid fa-arrow-left-long"></i></a>
                <span>{{ trans('dash.label.only.list.of') }} <span class="text-info fw-bold">{{ trans('dash.label.only.patients') }}</span></span>
            </h1>
            <div class="d-flex gap-2 align-items-center">
                <input class="form-control fc" type="text" name="searchUser" id="searchUser" placeholder="{{ trans('dashadmin.label.inventory.searh') }}" aria-label="default input example" value="{{ $search }}">
                <button type="button" onclick="searchRows();" class="btn btn-light btn-sm"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
            <a href="{{ route('adminpatient.add') }}" class="btn btn-primary btn-sm d-block text-uppercase px-4">{{ trans('dash.label.add.patient') }}</a>
        </div>

        <div class="col">
            <div class="card rounded-3 border-2 border-secondary px-2 px-lg-3 py-2 py-lg-3 mb-0 mb-lg-5">
                <div class="card-body p-0">
                    <table class="table table-striped table-borderless mb-0 small align-middle cTable">
                        <thead>
                            <tr>
                                <th class="px-2 px-lg-3 py-1 py-lg-3 text-uppercase small" style="width: 80px;"></th>
                                <th class="px-2 px-lg-3 py-1 py-lg-3 text-uppercase small" scope="col">{{ trans('dash.label.name') }}</th>
                                <th class="px-2 px-lg-3 py-1 py-lg-3 text-uppercase small" scope="col">{{ trans('dash.label.element.type') }}</th>
                                <th class="px-2 px-lg-3 py-1 py-lg-3 text-uppercase small" scope="col">{{ trans('dash.label.element.breed') }}</th>
                                <th class="px-2 px-lg-3 py-1 py-lg-3 text-uppercase small" scope="col">{{ trans('dash.label.owner') }}</th>
                                <th class="px-2 px-lg-3 py-1 py-lg-3 text-uppercase small" scope="col">{{ trans('dash.label.contact') }}</th>
                                <th class="px-2 px-lg-3 py-1 py-lg-3 text-uppercase small"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pets as $row)
                                @php
                                    $rowid = App\Models\User::encryptor('encrypt', $row->id);
                                    $photo = asset('img/default.png');
                                    if((isset($pet->photo)) && ($pet->photo != '')) {
                                        $photo = asset('files/' . $pet->photo);
                                    }
                                @endphp
                                <tr>
                                    <td class="px-2 px-lg-3 py-1 py-lg-3" data-label="Foto:">
                                        <div class="petPhoto d-inline-block align-top rounded-circle m-0" style="background-image: url({{ $photo }});"></div>
                                    </td>
                                    <td class="px-2 px-lg-3 py-1 py-lg-3 fw-semibold text-uppercase" data-label="{{ trans('dash.label.name') }}:">{{ $row->name }}</td>
                                    <td class="px-2 px-lg-3 py-1 py-lg-3" data-label="{{ trans('dash.label.element.type') }}:">{{ (isset($row['getType']['title_' . $weblang])) ? $row['getType']['title_' . $weblang] : '' }}</td>
                                    <td class="px-2 px-lg-3 py-1 py-lg-3" data-label="{{ trans('dash.label.element.breed') }}:">{{ (isset($row['getBreed']['title_' . $weblang])) ? $row['getBreed']['title_' . $weblang] : '' }}</td>
                                    <td class="px-2 px-lg-3 py-1 py-lg-3" data-label="{{ trans('dash.label.owner') }}:">{{ ($row['getUser']['name']) ? $row['getUser']['name'] : '' }}</td>
                                    <td class="px-2 px-lg-3 py-1 py-lg-3" data-label="{{ trans('dash.label.contact') }}:">{{ ($row['getUser']['phone']) ? $row['getUser']['phone'] : '' }}</td>
                                    <td class="px-2 px-lg-3 py-1 py-lg-3 text-end" data-label="{{ trans('dash.label.options') }}:">
                                        <div class="d-inline-block align-top">
                                            <a class="apIcon d-md-inline-block" href="{{ route('adminpatient.view', $rowid) }}">
                                                <i class="fa-solid fa-pencil"></i>
                                                <span class="d-none d-lg-inline-block">{{ trans('dash.label.btn.see') }}</span>
                                            </a>
                                            <a class="apIcon d-md-inline-block" href="{{ route('pet.detail', $rowid) }}">
                                                <i class="fa-solid fa-file-invoice"></i>
                                                <span class="d-none d-lg-inline-block">{{ trans('dash.menu.owners.singular') }}</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{ $pets->links() }}

        </div>

    </div>
</section>

@include('elements.footer')

@endsection

@push('scriptBottom')
<script>
    function searchRows() {
        var search = $('#searchUser').val();

        location.href = '{{ url('adminpatient/list') }}/' + btoa(search);
    }
</script>
@endpush