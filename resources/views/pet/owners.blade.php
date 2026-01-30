@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@include('elements.docmenu')

@php $weblang = \App::getLocale(); @endphp

<section class="container-fluid pb-0 pb-lg-4">
    <div class="row px-2 px-lg-3 mt-2 mt-lg-4">

        <div class="container-fluid px-xl-5">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-auto align-items-sm-center gap-3 mb-3 mb-md-4">
                <h1 class="h4 text-uppercase text-center text-sm-start fw-bold m-0">{{ trans('dash.label.owners') }}</h1>
                <div class="d-flex gap-2 align-items-center">
                    <input class="form-control fc" type="text" name="searchOwner" id="searchOwner" placeholder="Buscar" aria-label="default input example" value="{{ $search }}">
                    <button type="button" class="btn btn-light btn-sm" data-owners-action="search"><i class="fa-solid fa-magnifying-glass"></i></button>
                    <a href="javascript:void(0);" class="btn btn-secondary btn-sm text-nowrap ms-1" data-bs-toggle="modal" data-bs-target="#createNewUser" data-owners-action="create-user">
                        <i class="fa-solid fa-plus me-1"></i>{{ trans('dash.label.create') }}
                    </a>
                </div>
            </div>

            <div class="row g-3 g-md-4">

                @if(count($users) > 0)
                    @foreach ($users as $user)
                        <div class="col-md-4 col-lg-3">
                            <div class="card rounded-3 border-2 border-secondary h-100">
                                <div class="accordion accordion-flush bg-transparent" id="accordionExample">
                                    <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed fw-medium text-black rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $user->id }}" aria-expanded="false" aria-controls="collapseOne">
                                            <i class="fa-solid fa-user text-primary me-2"></i>{{ $user->name }}
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $user->id }}" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="d-flex flex-column justify-content-center gap-1">
                                                @if($user->phone != '')
                                                <span><i class="fa-solid fa-phone fa-fw me-2 text-secondary-emphasis small"></i>{{ $user->phone }}</span>
                                                @endif
                                                <span><i class="fa-solid fa-envelope fa-fw me-2 text-secondary-emphasis small"></i>{{ $user->email }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="card-body border-2 border-secondary border-top">
                                    <p class="mb-2 small fw-medium text-uppercase">{{ trans('dash.menu.pets') }}</p>
                                    <div class="row g-3">
                                        @if(count($user['getPets']) > 0)
                                            @foreach ($user['getPets'] as $pet)
                                                @php
                                                    $photo = asset('img/default.png');
                                                    if((isset($pet->photo)) && ($pet->photo != '')) {
                                                        $photo = asset('files/' . $pet->photo);
                                                    }
                                                @endphp
                                                <div class="col-6">
                                                    <a href="{{ route('pet.detail', App\Models\User::encryptor('encrypt', $pet->id)) }}" class="d-flex align-items-center gap-2 btn p-0">
                                                        <div class="petPhoto rounded-circle" style="background-image: url({{ $photo }});"></div>
                                                        <div class="fw-semibold">{{ $pet->name }}</div>
                                                    </a>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="col-6">
                                                <div class="fw-semibold">{{ trans('dash.label.no.pets') }}</div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-6">
                        <div class="fw-semibold">{{ trans('dash.label.no.owners') }}</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

@include('elements.footer')
@include('elements.appointmodals', ['ModalCreateUser' => true])

@endsection

@push('scriptBottom')
<script>
    window.OWNERS_CONFIG = {
        routes: {
            owners: "{{ route('pet.owners') }}"
        },
        ids: {
            searchInput: "searchOwner",
            associateInput: "associateUserDoctor"
        }
    };
</script>
<script src="{{ asset('js/pet/owners.js') }}"></script>
@endpush
