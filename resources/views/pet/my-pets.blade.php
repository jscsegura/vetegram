@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@php $weblang = \App::getLocale(); @endphp

@include('elements.ownermenu')

<section class="container-fluid pb-0 pb-lg-4 px-xl-5">
    <div class="row g-3 g-lg-4 px-0 px-lg-3 mt-0 mt-lg-4 col-xl-11 col-xxl-8 mx-auto">
        <div class="col-12 d-flex flex-column flex-sm-row gap-2 align-items-sm-center justify-content-between">
            <h1 class="h4 text-uppercase text-center text-sm-start fw-normal mb-0">{{ trans('dash.label.only.mis') }} <span class="text-info fw-bold">{{ trans('dash.menu.pets') }}</span></h1>
            <div>
                <button type="button" class="btn btn-primary btn-sm text-uppercase flex-grow-1 px-4 w-100" data-bs-toggle="modal" data-bs-target="#petModal">{{ trans('dash.label.add.pet') }}</button>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success small mt-3 mb-0" role="alert">
            {{ trans('dash.label.pet.created') }}
        </div>
        @endif

        @foreach ($pets as $pet)
            @php
                $photo = asset('img/default.png');
                if((isset($pet->photo)) && ($pet->photo != '')) {
                    $photo = asset('files/' . $pet->photo);
                }
            @endphp
            <div class="col-md-6 col-lg-4">
                <div class="card rounded-3 border-2 border-secondary">
                    <div class="card-body">
                        <a href="{{ route('pet.detail', App\Models\User::encryptor('encrypt', $pet->id)) }}" class="link-secondary d-flex align-items-center gap-3 p-0 text-decoration-none">
                            <div>
                                <div class="petPhoto2 rounded-circle" style="background-image: url({{ $photo }});"></div>
                            </div>
                            <div>
                                <div class="fs-5 text-uppercase fw-medium lh-sm">{{ $pet->name }}</div>
                                <small class="d-block">{{ trans('dash.label.btn.see.detail') }}<i class="fa-solid fa-arrow-right-long ms-2 mt-1"></i></small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

<div class="modal fade" id="petModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="bookModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="fw-normal mb-0 text-secondary">{{ trans('dash.label.add.pet') }}</h6>
          <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-3 p-md-4">
            <form name="frmCreatePet" id="frmCreatePet" method="post" action="{{ route('pets.savePet') }}" enctype="multipart/form-data" data-action="Pet.sendFormCreate" data-action-event="submit">
                @csrf
                <div class="mb-3">
                    <label for="pet" class="form-label small">{{ trans('dash.label.element.name.pet') }}</label>
                    <input type="text" name="name" id="name" class="form-control fc requerido">
                </div>

                <div class="mb-3">
                    <label for="petType" class="form-label small">{{ trans('dash.label.element.type.pet') }}</label>
                    <select name="animaltype" id="animaltype" class="form-select fc select4 requerido" data-action="Pet.getBreed" data-action-event="change">
                        <option value="">{{ trans('auth.register.complete.select') }}</option>
                        @foreach ($animalTypes as $type)
                            <option value="{{ $type->id }}">{{ $type['title_' . $weblang] }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="breed" class="form-label small">{{ trans('dash.label.element.breed') }}</label>
                    <select name="breed" id="breed" class="form-select fc select4 requerido">
                        <option value="">{{ trans('auth.register.complete.select') }}</option>
                    </select>
                </div>

                <div>
                    <label for="profilePhoto" class="form-label small mb-1">{{ trans('dash.label.element.photo') }} (300kb max.)</label>
                    <input class="form-control" type="file" id="file" name="file" style="padding: .375rem .75rem;" accept="image/*">
                </div>
            </form>
        </div>
        <div class="modal-footer px-3 px-md-4 pb-3 pb-md-4 pt-0">
          <button data-action="Pet.sendFormCreateValidate" data-action-event="click" id="agendarBtn" type="button" class="btn btn-primary btn-sm fw-medium px-4">{{ trans('dash.text.btn.save') }}</button>
        </div>
      </div>
    </div>
</div>

@include('elements.footer')

@endsection

@push('scriptBottom')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/wpanel/library/jquery.toast.css') }}">
    <script src="{{ asset('js/wpanel/library/jquery.toast.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        window.PET_COMMON_CONFIG = {
            routes: {
                getBreed: @json(route('get.breed'))
            },
            texts: {
                selectLabel: @json(trans('auth.register.complete.select'))
            }
        };
    </script>
    <script src="{{ asset('js/pet/common.js') }}"></script>
    <script src="{{ asset('js/pet/my-pets.js') }}"></script>
@endpush
