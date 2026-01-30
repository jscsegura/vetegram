@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@include('elements.docmenu')

<section class="container-fluid pb-0 pb-lg-4">
    <div class="row px-2 px-lg-3 mt-2 mt-lg-4">
        
        <form class="col-xl-9 mx-auto mt-4 mt-lg-0 mb-lg-5" id="frmProfile" name="frmProfile" method="post" action="{{ route('adminuser.store') }}" data-action="Users.validSend" data-action-event="submit">
            @csrf

            <h1 class="text-center text-md-start text-uppercase h4 fw-normal mb-3">
                <a href="{{ route('adminuser.index') }}" class="btn btn-sm smIcon"><i class="fa-solid fa-arrow-left-long"></i></a>
                {{ trans('dashadmin.label.title.add') }} <span class="text-info fw-bold">{{ trans('dashadmin.label.single.user') }}</span>
            </h1>

            <div class="row g-xl-5">
                <div class="col-md-4">
                    <div class="mb-4">
                        <label for="idtype" class="form-label small">{{ trans('auth.register.type.user') }}</label>
                        <select class="form-select fc requerido" name="roluser" id="roluser" data-action="Users.setRol" data-action-event="change">
                            <option value="4">{{ trans('dash.rol.name.4') }}</option>
                            <option value="5">{{ trans('dash.rol.name.5') }}</option>
                            <option value="6">{{ trans('dash.rol.name.6') }}</option>
                            <option value="7">{{ trans('dash.rol.name.7') }}</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="phone" class="form-label small">{{ trans('auth.register.complete.phone.only') }}</label>
                        <input type="text" class="form-control fc requerido" id="phone" name="phone" data-action="vetegramHelpers.enterOnlyNumbers" data-action-event="keydown" data-action-args="$event" maxlength="12">
                    </div>
                    <div class="mb-4">
                        <label for="country" class="form-label small">{{ trans('auth.register.complete.country') }}</label>
                        <select class="form-select fc requerido select2" id="country" name="country" data-action="Users.changeCountry" data-action-event="change" data-action-args="$el">
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}" data-phonecode="{{ $country->phonecode }}" @if($country->id == $vet->country) selected="selected" @endif>{{ $country->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="district" class="form-label small">{{ trans('auth.register.complete.district.only') }}</label>
                        <div id="districtDiv" @if($vet->country != 53) style="display: none;" @endif>
                            <select class="form-select fc select2" name="district" id="district">
                                <option value="">{{ trans('auth.register.complete.select') }}</option>
                                @foreach ($districts as $district)
                                    <option value="{{ $district->id }}" @if($district->id == $vet->district) selected="selected" @endif>{{ $district->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="text" class="form-control fc" id="district_alternate" name="district_alternate" @if($vet->country == 53) style="display: none;" @else value="{{ $vet->district }}" @endif maxlength="255">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-4">
                        <label for="name" class="form-label small">{{ trans('auth.login.fullname') }}</label>
                        <input type="text" class="form-control fc requerido requeridoLetra" id="name" name="name" value="">
                    </div>
                    <div class="mb-4">
                        <label for="idtype" class="form-label small">{{ trans('auth.register.complete.typedni') }}</label>
                        <select class="form-select fc requerido" name="idtype" id="idtype">
                            <option value="1">{{ trans('auth.register.complete.physical') }}</option>
                            <option value="2">{{ trans('auth.register.complete.juridic') }}</option>
                            <option value="3">{{ trans('auth.register.complete.passport') }}</option>
                            <option value="4">DIMEX</option>
                            <option value="5">NITE</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="province" class="form-label small">{{ trans('auth.register.complete.province') }}</label>
                        <div id="provinceDiv" @if($vet->country != 53) style="display: none;" @endif>
                            <select class="form-select fc select2" name="province" id="province" data-action="Users.getLocation" data-action-event="change" data-action-args="1|$value">
                                <option value="">{{ trans('auth.register.complete.select') }}</option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->id }}" @if($province->id == $vet->province) selected="selected" @endif>{{ $province->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="text" class="form-control fc" id="province_alternate" name="province_alternate" @if($vet->country == 53) style="display: none;" @else value="{{ $vet->province }}" @endif maxlength="255">
                    </div>
                    <div class="mb-4" id="containerCode">
                        <label for="vcode" class="form-label small">{{ trans('auth.register.complete.code') }} <span id="resultCode"></span></label>
                        <input type="text" class="form-control fc" id="vcode" name="vcode" value="" maxlength="50">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-4">
                        <label for="vEmail" class="form-label small">{{ trans('auth.login.email') }}</label>
                        <input type="email" class="form-control fc requerido requeridoEmail" id="vEmail" name="vEmail" value="">
                    </div>
                    <div class="mb-4">
                        <label for="idnumber" class="form-label small">{{ trans('auth.register.complete.dni') }}</label>
                        <input type="text" class="form-control fc requerido" id="idnumber" name="idnumber" data-action="vetegramHelpers.enterOnlyNumbers" data-action-event="keydown" data-action-args="$event" maxlength="12">
                    </div>
                    <div class="mb-4">
                        <label for="canton" class="form-label small">{{ trans('auth.register.complete.canton.only') }}</label>
                        <div id="cantonDiv" @if($vet->country != 53) style="display: none;" @endif>
                            <select class="form-select fc select2" name="canton" id="canton" data-action="Users.getLocation" data-action-event="change" data-action-args="2|$value">
                                <option value="">{{ trans('auth.register.complete.select') }}</option>
                                @foreach ($cantons as $canton)
                                    <option value="{{ $canton->id }}" @if($canton->id == $vet->canton) selected="selected" @endif>{{ $canton->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="text" class="form-control fc" id="canton_alternate" name="canton_alternate" @if($vet->country == 53) style="display: none;" @else value="{{ $vet->canton }}" @endif maxlength="255">
                    </div>
                </div>
                
            </div>
            <div class="alert alert-warning text-center mb-3 mb-md-4 small" role="alert">
                <i class="fa-solid fa-triangle-exclamation opacity-50 me-2"></i>El usuario va a poder agendar citas únicamente hasta que se verifique
            </div>
            <button type="submit" class="btn btn-primary px-5">{{ trans('dashadmin.label.inventory.save') }}</button>
            @if(session('error'))
            <div class="mt-3">
                <div class="alert alert-danger mb-0">
                    <strong>Error!</strong> {!! session('error') !!}
                </div>
            </div>
            @endif
        </form>

    </div>
</section>

@include('elements.footer')

@endsection

@push('scriptBottom')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<link rel="stylesheet" href="{{ asset('css/wpanel/library/jquery.toast.css') }}">
<script src="{{ asset('js/wpanel/library/jquery.toast.js') }}"></script>

<script>
    window.USERS_COMMON_CONFIG = {
        routes: {
            getLocation: @json(route('get.location')),
            checkVetCode: @json(route('check.vetcode'))
        },
        texts: {
            selectLabel: @json(trans('auth.register.complete.select')),
            nameMustContainLetters: @json('El nombre debe contener letras'),
            invalidEmail: @json('El correo no es válido')
        }
    };
</script>
<script src="{{ asset('js/users/common.js') }}"></script>
<script src="{{ asset('js/users/add.js') }}"></script>
@endpush
