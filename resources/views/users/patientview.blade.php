@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@php $weblang = \App::getLocale(); @endphp

@include('elements.docmenu')

<section class="container-fluid pb-0 pb-lg-4">
    <div class="row px-2 px-lg-3 mt-2 mt-lg-4">
        
        <form id="frmProfile" name="frmProfile" method="post" action="{{ route('adminpatient.update') }}" data-action="Users.validSend" data-action-event="submit">
            <input type="hidden" name="hideId" id="hideId" value="{{ $idPet }}">
            
            <h1 class="h4 text-uppercase text-center text-md-start fw-normal mb-2 mb-md-3 px-xl-5">
                <a href="{{ route('adminpatient.index') }}" class="btn btn-sm smIcon"><i class="fa-solid fa-arrow-left-long"></i></a>
                {{ trans('dashadmin.label.profile.title') }} <span class="text-info fw-bold">{{ trans('dashadmin.label.pacient.title') }}</span>
            </h1>

            @csrf

            <div class="container-fluid px-xl-5">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="docCol card rounded-3 border-2 border-secondary">
                            <div class="card-body p-3 p-lg-4">
                                <div class="d-grid d-sm-flex gap-3">
                                    @php
                                        $photo = asset('img/default.png');
                                        if((isset($pet->photo)) && ($pet->photo != '')) {
                                            $photo = asset('files/' . $pet->photo);
                                        }
                                    @endphp
                                    <div class="docPhoto rounded-circle m-auto m-sm-0" style="background-image: url({{ $photo }});"></div>
                                    <div class="d-grid align-content-center">
                                        <h3 class="h5 text-uppercase m-0 text-center text-sm-start">{{ $pet->name }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 ps-lg-5 mt-4 mt-lg-0 mb-lg-5">

                        <div class="row g-xl-5">
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label for="dname" class="form-label small">{{ trans('auth.register.complete.namepet') }}</label>
                                    <input type="text" class="form-control fc" id="dname" name="dname" value="{{ $pet->name }}">
                                </div>
                                <div class="mb-4">
                                    <label for="canton" class="form-label small">{{ trans('dash.label.owner') }}</label>
                                    <select class="form-select fc select2 requerido" name="owner" id="owner">
                                        <option value="">{{ trans('auth.register.complete.select') }}</option>
                                        @foreach ($owners as $owner)
                                            <option value="{{ $owner->id }}" @if($pet->id_user == $owner->id) selected @endif>{{ $owner->name }}</option>    
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label for="dname" class="form-label small">{{ trans('auth.register.complete.type') }}</label>
                                    <select class="form-select fc select2 requerido" name="type" id="type" data-action="Users.getBreed" data-action-event="change" data-action-args="$el">
                                        <option value="">{{ trans('auth.register.complete.select') }}</option>
                                        @foreach ($animalTypes as $type)
                                            <option value="{{ $type->id }}" @if($pet->type == $type->id) selected @endif>{{ $type['title_' . $weblang] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label for="dname" class="form-label small">{{ trans('auth.register.complete.breed') }}</label>
                                    <select class="form-select fc select2 requerido" name="breed" id="breed">
                                        <option value="">{{ trans('auth.register.complete.select') }}</option>
                                        @foreach ($breeds as $breed)
                                            <option value="{{ $breed->id }}" @if($pet->breed == $breed->id) selected @endif>{{ $breed->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid d-sm-flex gap-2">
                            <button type="submit" class="btn btn-primary px-5">{{ trans('auth.btn.edit') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
</section>

@include('elements.footer')

@endsection

@push('scriptBottom')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    window.USERS_COMMON_CONFIG = {
        routes: {
            getBreed: @json(route('get.breed'))
        },
        texts: {
            selectLabel: @json(trans('auth.register.complete.select'))
        },
        selectors: {
            type: '#type',
            breed: '#breed'
        }
    };
</script>
<script src="{{ asset('js/users/common.js') }}"></script>
<script src="{{ asset('js/users/patient-view.js') }}"></script>
@endpush
