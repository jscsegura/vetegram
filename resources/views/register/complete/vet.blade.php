@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@php
    $weblang = \App::getLocale();
    $vet = $vet ?? null;
    $vetSpecialties = (isset($vet->specialities) && $vet->specialities) ? json_decode($vet->specialities, true) : [];
    $vetSpecies = (isset($vet->species) && $vet->species) ? json_decode($vet->species, true) : [];
    $vetLanguages = (isset($vet->languages) && $vet->languages) ? json_decode($vet->languages, true) : [];
    $vetServices = (isset($vet->services) && $vet->services) ? json_decode($vet->services, true) : [];
    if (!is_array($vetSpecialties)) {
        $vetSpecialties = [];
    }
    if (!is_array($vetSpecies)) {
        $vetSpecies = [];
    }
    if (!is_array($vetLanguages)) {
        $vetLanguages = [];
    }
    if (!is_array($vetServices)) {
        $vetServices = [];
    }
    $vetCountry = $user->country ?? ($vet->country ?? null);
    $vetProvince = $user->province ?? ($vet->province ?? null);
    $vetCanton = $user->canton ?? ($vet->canton ?? null);
    $vetDistrict = $user->district ?? ($vet->district ?? null);
    $vetCode = $user->code ?? ($vet->code ?? '');
    $myCodeValue = ($vetCode !== '' && $vetCode !== null) ? 1 : 2;
@endphp

<div class="container-fluid">
    <div class="d-flex align-items-center justify-content-between px-2 px-lg-3 py-3">
        <div>
            <img src="{{ asset('img/logo.svg') }}?v={{ filemtime(public_path('img/logo.svg')) }}" alt="Vetegram" style="height: 64px;">
        </div>
        @if (Config::get('app.locale') == 'en')
        <a href="{{ route('change.language', ['es'])}}" class="btn btn-outline-secondary btn-sm text-uppercase">Es</a>
        @endif
        @if (Config::get('app.locale') == 'es')
        <a href="{{ route('change.language', ['en'])}}" class="btn btn-outline-secondary btn-sm text-uppercase">En</a>
        @endif
    </div>
</div>

<div class="container-fluid px-xl-5 pb-0 pb-lg-4">
    <div class="row px-2 px-lg-3 mt-lg-4">
        <form class="col-xl-9 mx-auto mt-4 mt-lg-0 mb-lg-5 wizard-form" id="frmProfile" name="frmProfile" method="post" action="{{ route('register.complete-save') }}" onsubmit="return validSend();" enctype="multipart/form-data">
            <h1 class="text-center text-md-start text-uppercase h4 fw-normal mb-2">{{ trans('auth.register.complete.cmp') }} <span class="text-info fw-bold">{{ trans('auth.register.complete.profile') }}</span></h1>
            <p class="text-center text-md-start text-muted mb-4">{{ trans('auth.register.complete.intro') }}</p>

            @csrf

            <div class="d-flex flex-wrap align-items-center gap-2 mb-4">
                <button type="button" class="btn btn-primary btn-sm text-uppercase step-btn" data-step="step1" onclick="changeTab('step1')">1. {{ trans('auth.register.complete.step.identity') }}</button>
                <button type="button" class="btn btn-outline-secondary btn-sm text-uppercase step-btn" data-step="step2" onclick="changeTab('step2')">2. {{ trans('auth.register.complete.step.clinic') }}</button>
                <button type="button" class="btn btn-outline-secondary btn-sm text-uppercase step-btn" data-step="step3" onclick="changeTab('step3')">3. {{ trans('auth.register.complete.step.specialties') }}</button>
                <button type="button" class="btn btn-outline-secondary btn-sm text-uppercase step-btn" data-step="step4" onclick="changeTab('step4')">4. {{ trans('auth.register.complete.step.location') }}</button>
            </div>

            <div class="tab-content" id="formSteps">
                <div class="tab-pane fade show active" id="step1">
                    <div class="row g-4 g-xl-5">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="dname" class="form-label small">{{ trans('auth.login.fullname') }}</label>
                                <input type="text" class="form-control fc" id="name" name="name" value="{{ $user->name }}" readonly>
                            </div>
                            <div class="mb-4">
                                <label for="vEmail" class="form-label small">{{ trans('auth.login.email') }}</label>
                                <input type="email" class="form-control fc" id="vEmail" name="vEmail" value="{{ $user->email }}" readonly>
                            </div>
                            <div class="mb-4">
                                <label for="idtype" class="form-label small">{{ trans('auth.register.complete.typedni') }}</label>
                                <select class="form-select fc requerido" name="idtype" id="idtype">
                                    <option value="1" @if($user->type_dni == 1) selected @endif>{{ trans('auth.register.complete.physical') }}</option>
                                    <option value="2" @if($user->type_dni == 2) selected @endif>{{ trans('auth.register.complete.juridic') }}</option>
                                    <option value="3" @if($user->type_dni == 3) selected @endif>{{ trans('auth.register.complete.passport') }}</option>
                                    <option value="4" @if($user->type_dni == 4) selected @endif>DIMEX</option>
                                    <option value="5" @if($user->type_dni == 5) selected @endif>NITE</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="idnumber" class="form-label small">{{ trans('auth.register.complete.dni') }}</label>
                                <input type="text" class="form-control fc requerido" id="idnumber" name="idnumber" value="{{ $user->dni ?? '' }}" onkeydown="enterOnlyNumbers(event);" maxlength="50">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label small">{{ trans('auth.register.complete.photo.label') }}</label>
                                <div id="profilePhotoDrop" class="border border-2 border-secondary rounded-3 p-3 text-center">
                                    <input type="file" id="profilePhoto" name="profilePhoto" class="d-none" accept="image/*">
                                    <input type="hidden" id="removeProfilePhoto" name="removeProfilePhoto" value="0">
                                    <div class="small text-muted">{{ trans('auth.register.complete.photo.hint') }}</div>
                                    <div class="d-flex justify-content-center gap-2 mt-2 flex-wrap">
                                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="event.stopPropagation(); document.getElementById('profilePhoto').click();">
                                            {{ trans('auth.register.complete.photo.btn') }}
                                        </button>
                                        <button type="button" class="btn btn-outline-danger btn-sm" id="removeProfilePhotoBtn" onclick="event.stopPropagation();" style="{{ (isset($user->photo) && $user->photo != '') ? '' : 'display:none;' }}">
                                            {{ trans('auth.register.complete.photo.remove') }}
                                        </button>
                                    </div>
                                    @php
                                        $profilePhoto = asset('img/default2.png');
                                        if(isset($user->photo) && $user->photo != '') {
                                            $profilePhoto = asset($user->photo);
                                        }
                                    @endphp
                                    <div class="mt-3 d-flex justify-content-center">
                                        <img id="profilePhotoPreview" src="{{ $profilePhoto }}" class="img-fluid rounded-3" style="max-height: 160px;">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small">{{ trans('auth.register.complete.ismycodelabel') }}</label>
                                <div class="d-flex flex-column gap-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="mycode" id="mycodeYes" value="1" @if($myCodeValue == 1) checked @endif>
                                        <label class="form-check-label small" for="mycodeYes">{{ trans('auth.register.complete.ismycode') }}</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="mycode" id="mycodeNo" value="2" @if($myCodeValue == 2) checked @endif>
                                        <label class="form-check-label small" for="mycodeNo">{{ trans('auth.register.complete.notismycode') }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4" id="vetCodeBlock" style="{{ ($myCodeValue == 1) ? '' : 'display:none;' }}">
                                <label for="vcode" class="form-label small">{{ trans('auth.register.complete.code') }} <span id="resultCode"></span></label>
                                <input type="text" class="form-control fc requerido-vcode" id="vcode" name="vcode" value="{{ $vetCode }}" onchange="checkCode(this.value);" onkeydown="enterOnlyNumbers(event);" maxlength="50">
                            </div>
                        </div>
                    </div>
                    @include('register.complete.action-bar', [
                        'step' => 'step1',
                        'backStep' => null,
                        'nextStep' => 'step2',
                        'nextLabel' => trans('auth.register.complete.next.save')
                    ])
                </div>

                <div class="tab-pane fade" id="step2">
                    <div class="row g-4 g-xl-5">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="socialName" class="form-label small">{{ trans('auth.register.complete.social') }}</label>
                                <input type="text" class="form-control fc requerido" id="socialName" name="socialName" value="{{ $vet->social_name ?? '' }}" maxlength="255">
                            </div>
                            <div class="mb-4">
                                <label for="clinicname" class="form-label small">{{ trans('auth.register.complete.name') }}</label>
                                <input type="text" class="form-control fc requerido" id="clinicname" name="clinicname" value="{{ $vet->company ?? '' }}" maxlength="255">
                            </div>
                            <div class="mb-4">
                                <label for="idtypevet" class="form-label small">{{ trans('auth.register.complete.typedni.clinic') }}</label>
                                <select class="form-select fc requerido" name="idtypevet" id="idtypevet">
                                    <option value="1" @if(($vet->type_dni ?? null) == 1) selected @endif>{{ trans('auth.register.complete.physical') }}</option>
                                    <option value="2" @if(($vet->type_dni ?? null) == 2) selected @endif>{{ trans('auth.register.complete.juridic') }}</option>
                                    <option value="3" @if(($vet->type_dni ?? null) == 3) selected @endif>{{ trans('auth.register.complete.passport') }}</option>
                                    <option value="4" @if(($vet->type_dni ?? null) == 4) selected @endif>DIMEX</option>
                                    <option value="5" @if(($vet->type_dni ?? null) == 5) selected @endif>NITE</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="idnumbervet" class="form-label small">{{ trans('auth.register.complete.dni.clinic') }}</label>
                                <input type="text" class="form-control fc requerido" id="idnumbervet" name="idnumbervet" value="{{ $vet->dni ?? '' }}" onkeydown="enterOnlyNumbers(event);" maxlength="50">
                            </div>
                            <div class="mb-4">
                                <label for="email_clinic" class="form-label small">{{ trans('auth.login.email.clinic') }}</label>
                                <input type="email" class="form-control fc requerido" id="email_clinic" name="email_clinic" value="{{ $vet->email ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="phone" class="form-label small">{{ trans('auth.register.complete.phone') }}</label>
                                <input type="tel" class="form-control fc requerido" id="phone" name="phone" value="{{ $vet->phone ?? $user->phone ?? '' }}" autocomplete="tel">
                            </div>
                            <div class="mb-4">
                                <label for="website_clinic" class="form-label small">{{ trans('auth.login.website.clinic') }}</label>
                                <input type="text" class="form-control fc" id="website_clinic" name="website_clinic" value="{{ $vet->website ?? '' }}">
                            </div>
                            <div class="mb-4">
                                <label class="form-label small">{{ trans('auth.register.complete.logo.label') }}</label>
                                <div id="clinicLogoDrop" class="border border-2 border-secondary rounded-3 p-3 text-center">
                                    <input type="file" id="clinicLogo" name="clinicLogo" class="d-none" accept="image/*">
                                    <input type="hidden" id="removeClinicLogo" name="removeClinicLogo" value="0">
                                    <div class="small text-muted">{{ trans('auth.register.complete.logo.hint') }}</div>
                                    <div class="d-flex justify-content-center gap-2 mt-2 flex-wrap">
                                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="event.stopPropagation(); document.getElementById('clinicLogo').click();">
                                            {{ trans('auth.register.complete.logo.btn') }}
                                        </button>
                                        <button type="button" class="btn btn-outline-danger btn-sm" id="removeClinicLogoBtn" onclick="event.stopPropagation();" style="{{ (isset($vet->logo) && $vet->logo != '') ? '' : 'display:none;' }}">
                                            {{ trans('auth.register.complete.logo.remove') }}
                                        </button>
                                    </div>
                                    @php
                                        $clinicLogo = '';
                                        if(isset($vet->logo) && $vet->logo != '') {
                                            $clinicLogo = asset($vet->logo);
                                        }
                                    @endphp
                                    <div class="mt-3 d-flex justify-content-center">
                                        <img id="clinicLogoPreview" src="{{ $clinicLogo }}" class="img-fluid rounded-3" style="max-height: 160px; {{ ($clinicLogo == '') ? 'display:none;' : '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="language" class="form-label small">{{ trans('auth.register.complete.lang') }}</label>
                                <select id="language" name="language[]" class="form-select fc select2 requerido" data-placeholder="Seleccionar" multiple>
                                    @foreach ($languages as $language)
                                        <option value="{{ $language->id }}" @if(in_array($language->id, $vetLanguages)) selected @endif>{{ $language['title_' . $weblang] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    @include('register.complete.action-bar', [
                        'step' => 'step2',
                        'backStep' => 'step1',
                        'nextStep' => 'step3',
                        'nextLabel' => trans('auth.register.complete.next.save')
                    ])
                </div>

                <div class="tab-pane fade" id="step3">
                    <div class="row g-4 g-xl-5">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label small">{{ trans('auth.register.complete.species.label') }}</label>
                                <div class="small text-muted mb-2 fst-italic opacity-75">{{ trans('auth.register.complete.species.hint') }}</div>
                                <div id="speciesGroup" class="border border-2 border-secondary rounded-3 p-3">
                                    <div class="row g-2">
                                        @foreach ($species as $item)
                                            <div class="col-6 col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="species[]" id="species_{{ $item->id }}" value="{{ $item->id }}" @if(in_array($item->id, $vetSpecies)) checked @endif>
                                                    <label class="form-check-label small" for="species_{{ $item->id }}">{{ $item['title_' . $weblang] }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div id="speciesError" class="invalid-feedback mt-2" style="display:none;">{{ trans('auth.register.complete.species.error') }}</div>
                            </div>
                            <div class="mb-4">
                                <label for="specialty" class="form-label small">{{ trans('auth.register.complete.specialties.label') }}</label>
                                <div class="small text-muted mb-2 fst-italic opacity-75">{{ trans('auth.register.complete.specialties.hint') }}</div>
                                <select id="specialty" name="specialty[]" class="form-select fc select2" data-placeholder="{{ trans('auth.register.complete.select') }}" multiple>
                                    @foreach ($specialtyGroupsView as $group)
                                        @if (count($group['items']) > 0)
                                            <optgroup label="{{ $group['label'] }}">
                                                @foreach ($group['items'] as $item)
                                                    <option value="{{ $item['id'] }}" @if(in_array($item['id'], $vetSpecialties)) selected @endif>{{ $item['label'] }}</option>
                                                @endforeach
                                            </optgroup>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label small">{{ trans('auth.register.complete.services.label') }}</label>
                                <div class="small text-muted mb-2 fst-italic opacity-75">{{ trans('auth.register.complete.services.hint') }}</div>
                                <div class="border border-2 border-secondary rounded-3 p-3">
                                    @foreach ($clinicServices as $service)
                                        <div class="form-check form-switch mb-2">
                                            <input class="form-check-input" type="checkbox" name="services[]" id="service_{{ $service->id }}" value="{{ $service->id }}" @if(in_array($service->id, $vetServices)) checked @endif>
                                            <label class="form-check-label small" for="service_{{ $service->id }}">{{ $service['title_' . $weblang] }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('register.complete.action-bar', [
                        'step' => 'step3',
                        'backStep' => 'step2',
                        'nextStep' => 'step4',
                        'nextLabel' => trans('auth.register.complete.next.save')
                    ])
                </div>

                <div class="tab-pane fade" id="step4">
                    <div class="row g-4 g-xl-5">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="country" class="form-label small">{{ trans('auth.register.complete.country') }}</label>
                                <select class="form-select fc requerido select2" name="country" id="country" onchange="changeCountry(this);">
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}" data-phonecode="{{ $country->phonecode }}" @if(($vetCountry && $country->id == $vetCountry) || (!$vetCountry && $country->default == 1)) selected="selected" @endif>{{ $country->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4" id="provinceGroup" style="{{ ($vetCountry && $vetCountry != 53) ? 'display: none;' : '' }}">
                                <label for="province" class="form-label small">{{ trans('auth.register.complete.province') }}</label>
                                <select class="form-select fc select2" name="province" id="province" onchange="getLocation(1, this.value);">
                                    <option value="">{{ trans('auth.register.complete.select') }}</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}" @if($vetProvince && $province->id == $vetProvince) selected @endif>{{ $province->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4" id="cantonGroup" style="{{ ($vetCountry && $vetCountry != 53) ? 'display: none;' : '' }}">
                                <label for="canton" class="form-label small">{{ trans('auth.register.complete.canton') }}</label>
                                <select class="form-select fc select2" name="canton" id="canton"  onchange="getLocation(2, this.value);">
                                    <option value="">{{ trans('auth.register.complete.select') }}</option>
                                </select>
                            </div>
                            <div class="mb-4" id="districtGroup" style="{{ ($vetCountry && $vetCountry != 53) ? 'display: none;' : '' }}">
                                <label for="district" class="form-label small">{{ trans('auth.register.complete.district') }}</label>
                                <select class="form-select fc select2" name="district" id="district">
                                    <option value="">{{ trans('auth.register.complete.select') }}</option>
                                </select>
                            </div>
                            <div class="mb-4" id="provinceAltGroup" style="{{ ($vetCountry && $vetCountry != 53) ? '' : 'display: none;' }}">
                                <label for="province_alternate" class="form-label small">{{ trans('auth.register.complete.state') }}</label>
                                <input type="text" class="form-control fc" id="province_alternate" name="province_alternate" value="{{ ($vetCountry && $vetCountry != 53) ? $vetProvince : '' }}" maxlength="255">
                            </div>
                            <div class="mb-4" id="cantonAltGroup" style="{{ ($vetCountry && $vetCountry != 53) ? '' : 'display: none;' }}">
                                <label for="canton_alternate" class="form-label small">{{ trans('auth.register.complete.city') }}</label>
                                <input type="text" class="form-control fc" id="canton_alternate" name="canton_alternate" value="{{ ($vetCountry && $vetCountry != 53) ? $vetCanton : '' }}" maxlength="255">
                            </div>
                            <div class="mb-4">
                                <label for="vetaddress" class="form-label small">{{ trans('auth.register.complete.address') }}</label>
                                <textarea class="form-control fc requerido" id="vetaddress" name="vetaddress" rows="2">{{ isset($vet->address) ? str_replace("<br />", "", $vet->address) : '' }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label small">{{ trans('auth.register.complete.map.label') }}</label>
                                <div class="small text-muted mb-2">{{ trans('auth.register.complete.map.hint') }}</div>
                                <div id="mapWrap" class="position-relative">
                                    <div id="mapLoading" class="map-loading d-none">
                                        <div class="spinner-border text-primary" role="status" aria-hidden="true"></div>
                                        <span class="ms-2">{{ trans('auth.register.complete.map.loading') }}</span>
                                    </div>
                                    <div id="clinicMap" class="border border-2 border-secondary rounded-3" style="height: 280px; width: 100%;"></div>
                                </div>
                                <input type="hidden" id="lat" name="lat" value="{{ $vet->lat ?? '' }}">
                                <input type="hidden" id="lng" name="lng" value="{{ $vet->lng ?? '' }}">
                            </div>
                        </div>
                    </div>
                    @include('register.complete.action-bar', [
                        'step' => 'step4',
                        'backStep' => 'step3',
                        'submit' => true,
                        'nextLabel' => trans('auth.register.complete.finish')
                    ])
                </div>
            </div>
        </form>
    </div>
</div>

@include('elements.footer')

@endsection


@push('scriptBottom')
<style>
    :root {
        --wizard-bar-height: 64px;
        --wizard-footer-height: 44px;
    }
    .wizard-form {
        padding-bottom: calc(var(--wizard-bar-height) + var(--wizard-footer-height));
    }
    .wizard-action-bar {
        position: fixed;
        left: 0;
        right: 0;
        bottom: var(--wizard-footer-height);
        background: #fff;
        border-top: 1px solid rgba(0, 0, 0, 0.08);
        box-shadow: 0 -6px 16px rgba(0, 0, 0, 0.06);
        padding: 0;
        z-index: 1020;
    }
    .wizard-action-bar-inner {
        min-height: var(--wizard-bar-height);
        padding: 10px 0;
        margin-bottom: 0 !important;
        max-width: 960px;
    }
    .app-footer {
        position: fixed !important;
        left: 0;
        right: 0;
        bottom: 0;
        height: var(--wizard-footer-height);
        margin-top: 0 !important;
        z-index: 1010;
    }
    .wizard-action-bar .btn-primary {
        background-color: #4bc6f9;
        border-color: #4bc6f9;
        color: #fff;
    }
    .wizard-action-bar .btn-primary:hover,
    .wizard-action-bar .btn-primary:focus {
        background-color: #3fbef2;
        border-color: #3fbef2;
        color: #fff;
    }
    .map-loading {
        position: absolute;
        top: 12px;
        left: 12px;
        z-index: 1001;
        background: rgba(255, 255, 255, 0.95);
        border: 1px solid rgba(0, 0, 0, 0.08);
        border-radius: 999px;
        padding: 6px 12px;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .map-hidden {
        visibility: hidden;
    }
</style>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@23.1.1/build/css/intlTelInput.css">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@23.1.1/build/js/intlTelInput.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $('.select2').select2({
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
    });
    $('#specialty').select2({
        theme: "bootstrap-5",
        width: $('#specialty').data('width') ? $('#specialty').data('width') : $('#specialty').hasClass('w-100') ? '100%' : 'style',
        placeholder: $('#specialty').data('placeholder'),
        closeOnSelect: false
    });

    $('input[name="species[]"]').on('change', function() {
        if ($('input[name="species[]"]:checked').length > 0) {
            $('#speciesGroup').removeClass('border-danger');
            $('#speciesError').hide();
        }
    });

    function selectDefaultLanguageFromIp() {
        const languageSelect = $('#language');
        if (!languageSelect.length) return;
        const current = languageSelect.val();
        if (current && current.length) return;

        const languageMap = {
            'CR': ['Español', 'Spanish'],
            'ES': ['Español', 'Spanish'],
            'MX': ['Español', 'Spanish'],
            'AR': ['Español', 'Spanish'],
            'BO': ['Español', 'Spanish'],
            'CL': ['Español', 'Spanish'],
            'CO': ['Español', 'Spanish'],
            'CU': ['Español', 'Spanish'],
            'DO': ['Español', 'Spanish'],
            'EC': ['Español', 'Spanish'],
            'GT': ['Español', 'Spanish'],
            'HN': ['Español', 'Spanish'],
            'NI': ['Español', 'Spanish'],
            'PA': ['Español', 'Spanish'],
            'PE': ['Español', 'Spanish'],
            'PR': ['Español', 'Spanish'],
            'PY': ['Español', 'Spanish'],
            'UY': ['Español', 'Spanish'],
            'VE': ['Español', 'Spanish'],
            'BR': ['Portuguese', 'Portugués'],
            'US': ['English', 'Inglés'],
            'GB': ['English', 'Inglés'],
            'CA': ['English', 'Inglés'],
            'AU': ['English', 'Inglés'],
            'NZ': ['English', 'Inglés'],
            'IE': ['English', 'Inglés']
        };

        function trySelectByNames(names) {
            if (!names || !names.length) return false;
            let selectedId = null;
            languageSelect.find('option').each(function() {
                const text = ($(this).text() || '').trim().toLowerCase();
                if (!text) return;
                for (const name of names) {
                    if (text.includes(name.toLowerCase())) {
                        selectedId = $(this).val();
                        return false;
                    }
                }
            });
            if (selectedId) {
                languageSelect.val([selectedId]).trigger('change');
                return true;
            }
            return false;
        }

        fetch('https://ipapi.co/json/')
            .then(res => res.json())
            .then(data => {
                const code = (data && data.country_code) ? data.country_code.toUpperCase() : null;
                if (!code) return;
                const names = languageMap[code] || [];
                if (!trySelectByNames(names)) {
                    if (code === 'US' || code === 'GB') {
                        trySelectByNames(['English', 'Inglés']);
                    }
                }
            })
            .catch(() => {});
    }

    selectDefaultLanguageFromIp();

    async function changeTab(tabId, options = {}) {
        if (!options.skipDraft) {
            await saveDraft();
        }
        const tabContent = document.getElementById('formSteps');
        const tabPane = tabContent.querySelector(`#${tabId}`);

        const allTabs = tabContent.querySelectorAll('.tab-pane');
        allTabs.forEach(tab => tab.classList.remove('show', 'active'));

        tabPane.classList.add('show', 'active');

        const allSteps = document.querySelectorAll('.step-btn');
        allSteps.forEach(btn => {
            btn.classList.remove('btn-primary');
            btn.classList.add('btn-outline-secondary');
        });
        const activeBtn = document.querySelector(`.step-btn[data-step="${tabId}"]`);
        if (activeBtn) {
            activeBtn.classList.remove('btn-outline-secondary');
            activeBtn.classList.add('btn-primary');
        }
        window.scrollTo({ top: 0, behavior: 'smooth' });
        if (tabId === 'step4' && window._clinicMap) {
            setTimeout(() => {
                window._clinicMap.invalidateSize();
                const lat = parseFloat($('#lat').val());
                const lng = parseFloat($('#lng').val());
                if (!isNaN(lat) && !isNaN(lng) && window._setClinicMarker) {
                    window._setClinicMarker(lat, lng);
                    window._clinicMap.setView([lat, lng], 16);
                }
            }, 200);
        }
        updateActionButtons();
    }

    async function nextStep(currentStep, nextStepId) {
        if (!validateStep(currentStep)) {
            return;
        }
        setNextLoading(currentStep, true);
        await saveDraft();
        setNextLoading(currentStep, false);
        changeTab(nextStepId, { skipDraft: true });
    }

    async function saveDraft() {
        const form = document.getElementById('frmProfile');
        if (!form) {
            return;
        }
        const formData = new FormData(form);
        formData.append('draft', '1');
        try {
            await fetch(form.action, {
                method: 'POST',
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                body: formData
            });
        } catch (e) {}
    }

    function validateStep(stepId) {
        let validate = true;
        const step = document.getElementById(stepId);
        if (!step) {
            return true;
        }

        $(step).find('.requerido').each(function(i, elem){
            const value = $(elem).val();
            let isEmpty = false;
            if (Array.isArray(value)) {
                isEmpty = value.length === 0;
            } else {
                const text = (value === null || value === undefined) ? '' : value.toString().trim();
                isEmpty = text === '';
            }
            if (isEmpty) {
                $(elem).addClass('is-invalid');
                validate = false;
            } else {
                $(elem).removeClass('is-invalid');
            }
        });

        if (stepId === 'step1') {
            const isVet = $('input[name="mycode"]:checked').val() === '1';
            const vcodeInput = $('#vcode');
            if (isVet) {
                if (vcodeInput.val().trim() === '') {
                    vcodeInput.addClass('is-invalid');
                    validate = false;
                } else {
                    vcodeInput.removeClass('is-invalid');
                }
            } else {
                vcodeInput.removeClass('is-invalid');
            }
        }

        if (stepId === 'step3') {
            const speciesSelected = $('input[name="species[]"]:checked').length > 0;
            if (!speciesSelected) {
                $('#speciesGroup').addClass('border-danger');
                $('#speciesError').show();
                validate = false;
            } else {
                $('#speciesGroup').removeClass('border-danger');
                $('#speciesError').hide();
            }
        }

        if (stepId === 'step4') {
            var country = $('#country').val();
            if(country == 53) {
                if($('#province').val() == ''){
                    $('#province').addClass('is-invalid');
                    validate = false;
                }else{
                    $('#province').removeClass('is-invalid');
                }

                if($('#canton').val() == ''){
                    $('#canton').addClass('is-invalid');
                    validate = false;
                }else{
                    $('#canton').removeClass('is-invalid');
                }

                if($('#district').val() == ''){
                    $('#district').addClass('is-invalid');
                    validate = false;
                }else{
                    $('#district').removeClass('is-invalid');
                }
            }else{
                if($('#province_alternate').val() == ''){
                    $('#province_alternate').addClass('is-invalid');
                    validate = false;
                }else{
                    $('#province_alternate').removeClass('is-invalid');
                }

            if($('#canton_alternate').val() == ''){
                $('#canton_alternate').addClass('is-invalid');
                validate = false;
            }else{
                $('#canton_alternate').removeClass('is-invalid');
            }
        }
        }

        return validate;
    }

    function toggleVetCode(isVet) {
        if (isVet) {
            $('#vetCodeBlock').show();
        } else {
            $('#vetCodeBlock').hide();
            $('#vcode').val('').removeClass('is-invalid');
            $('#resultCode').html('');
        }
    }

    function getActiveStepId() {
        const activeStep = document.querySelector('.tab-pane.show.active');
        return activeStep ? activeStep.id : null;
    }

    function stepIsReady(stepId) {
        const step = document.getElementById(stepId);
        if (!step) {
            return true;
        }

        let ok = true;
        $(step).find('.requerido').each(function(i, elem){
            const value = $(elem).val();
            if (!value || value.toString().trim() === '') {
                ok = false;
                return false;
            }
        });

        if (stepId === 'step1') {
            const isVet = $('input[name="mycode"]:checked').val() === '1';
            if (isVet && $('#vcode').val().trim() === '') {
                ok = false;
            }
        }

        if (stepId === 'step3') {
            if ($('input[name="species[]"]:checked').length === 0) {
                ok = false;
            }
        }

        if (stepId === 'step4') {
            const country = $('#country').val();
            if (country == 53) {
                if ($('#province').val() === '' || $('#canton').val() === '' || $('#district').val() === '') {
                    ok = false;
                }
            } else {
                if ($('#province_alternate').val() === '' || $('#canton_alternate').val() === '') {
                    ok = false;
                }
            }
            if ($('#lat').val() === '' || $('#lng').val() === '') {
                ok = false;
            }
        }

        return ok;
    }

    function updateActionButtons() {
        const activeStep = getActiveStepId();
        if (!activeStep) {
            return;
        }
        const ready = stepIsReady(activeStep);
        const btn = document.querySelector(`.wizard-next-btn[data-step="${activeStep}"]`);
        if (btn) {
            btn.disabled = !ready;
        }
    }

    function setNextLoading(stepId, isLoading) {
        const btn = document.querySelector(`.wizard-next-btn[data-step="${stepId}"]`);
        if (!btn) return;
        const defaultLabel = btn.getAttribute('data-default-label') || btn.textContent;
        const loadingLabel = btn.getAttribute('data-loading-label') || defaultLabel;
        btn.disabled = isLoading;
        btn.textContent = isLoading ? loadingLabel : defaultLabel;
    }

    function setupDropzone(dropId, inputId, previewId, removeBtnId, removeFlagId, defaultSrc = '', hasImage = false) {
        const drop = document.getElementById(dropId);
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);
        const removeBtn = document.getElementById(removeBtnId);
        const removeFlag = document.getElementById(removeFlagId);

        if (!drop || !input) {
            return;
        }

        drop.addEventListener('click', () => input.click());

        drop.addEventListener('dragover', (e) => {
            e.preventDefault();
            drop.classList.add('border-primary');
        });

        drop.addEventListener('dragleave', () => {
            drop.classList.remove('border-primary');
        });

        drop.addEventListener('drop', (e) => {
            e.preventDefault();
            drop.classList.remove('border-primary');
            if (e.dataTransfer && e.dataTransfer.files && e.dataTransfer.files.length > 0) {
                input.files = e.dataTransfer.files;
                updatePreview(input, preview);
                if (removeFlag) removeFlag.value = '0';
            }
        });

        input.addEventListener('change', () => {
            updatePreview(input, preview, removeBtn);
            if (removeFlag) removeFlag.value = '0';
        });

        if (removeBtn) {
            removeBtn.addEventListener('click', () => {
                input.value = '';
                if (preview) {
                    preview.src = defaultSrc || '';
                    if (!defaultSrc) {
                        preview.style.display = 'none';
                    }
                }
                removeBtn.style.display = 'none';
                if (removeFlag) removeFlag.value = '1';
            });
            if (!hasImage) {
                removeBtn.style.display = 'none';
            }
        }
    }

    function updatePreview(input, preview, removeBtn) {
        if (!preview || !input.files || !input.files[0]) {
            return;
        }
        const file = input.files[0];
        if (!file.type.startsWith('image/')) {
            return;
        }
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
        if (removeBtn) {
            removeBtn.style.display = 'inline-block';
        }
    }

    function changeCountry(obj) {
        var country = $(obj).val();
        var phonecode = $('#country option:selected').attr("data-phonecode");

        if(country == 53) {
            $('#provinceGroup').show();
            $('#cantonGroup').show();
            $('#districtGroup').show();

            $('#provinceAltGroup').hide();
            $('#cantonAltGroup').hide();

            $('#canton').prop('disabled', ($('#province').val() == ''));
            $('#district').prop('disabled', ($('#canton').val() == ''));
        }else{
            $('#provinceGroup').hide();
            $('#cantonGroup').hide();
            $('#districtGroup').hide();

            $('#provinceAltGroup').show();
            $('#cantonAltGroup').show();
        }

        if (!window._itiPhone && ($('#phone').val() === '' || $('#phone').val() === '+' + phonecode)) {
            $('#phone').val('+' + phonecode);
        }
        if (window._updateMapFromAddress) {
            setTimeout(window._updateMapFromAddress, 200);
        }
    }
    changeCountry($('#country'));

    $('#province').on('change', function() {
        if ($('#country').val() == 53) {
            const hasProvince = $(this).val() !== '';
            $('#canton').prop('disabled', !hasProvince);
            if (!hasProvince) {
                $('#canton').val('').trigger('change');
                $('#district').prop('disabled', true).val('');
            }
        }
    });

    $('#canton').on('change', function() {
        if ($('#country').val() == 53) {
            const hasCanton = $(this).val() !== '';
            $('#district').prop('disabled', !hasCanton);
            if (!hasCanton) {
                $('#district').val('');
            }
        }
    });

    function getLocation(type, value, selectedCanton = null, selectedDistrict = null) {
        if(type == 1) {
            $('#canton').prop('disabled', true);
            $('#district').prop('disabled', true);
        }
        $.ajax({
            type: 'POST',
            url: '{{ route('get.location') }}',
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: {
                type: type,
                value: value
            },
            beforeSend: function(){},
            success: function(data){
                var html = '<option value="">{{ trans('auth.register.complete.select') }}</option>';
                $.each(data.rows, function(i, item) {
                    html = html + '<option value="'+item.id+'">'+item.title+'</option>';
                });

                if(type == 1) {
                    $('#canton').html(html);
                    $('#district').html('<option value="">{{ trans('auth.register.complete.select') }}</option>');
                    $('#canton').prop('disabled', false);
                    $('#district').prop('disabled', true);
                    if (selectedCanton) {
                        $('#canton').val(selectedCanton).trigger('change');
                        if (selectedDistrict) {
                            getLocation(2, selectedCanton, null, selectedDistrict);
                        }
                    }
                }
                if(type == 2) {
                    $('#district').html(html);
                    $('#district').prop('disabled', false);
                    if (selectedDistrict) {
                        $('#district').val(selectedDistrict).trigger('change');
                    }
                }
                if (window._updateMapFromAddress) {
                    setTimeout(window._updateMapFromAddress, 200);
                }
            }
        });
    }

    const initialCountry = @json($vetCountry);
    const initialProvince = @json($vetProvince);
    const initialCanton = @json($vetCanton);
    const initialDistrict = @json($vetDistrict);

    if (initialCountry) {
        $('#country').val(initialCountry).trigger('change');
        changeCountry($('#country').get(0));
        if (initialCountry == 53 && initialProvince) {
            $('#province').val(initialProvince).trigger('change');
            getLocation(1, initialProvince, initialCanton, initialDistrict);
        }
    }

    function checkCode(code) {
        $.ajax({
            type: 'POST',
            url: '{{ route('check.vetcode') }}',
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: {
                code: code
            },
            beforeSend: function(){},
            success: function(data){
                if(data.id == 0) {
                    $('#resultCode').html('<i class="fa fa-times" style="color: red;" aria-hidden="true"></i>');
                }else{
                    $('#resultCode').html('<i class="fa fa-check"  style="color: green;" aria-hidden="true"></i>');
                }
            }
        });
    }

    function validSend() {
        var validate = true;

        $('.requerido').each(function(i, elem){
            var value = $(elem).val();
            var value = value.trim();
            if(value == ''){
                $(elem).addClass('is-invalid');
                validate = false;
            }else{
                $(elem).removeClass('is-invalid');
            }
        });

        if($('input[name="mycode"]:checked').val() === '1') {
            if($('#vcode').val().trim() == ''){
                $('#vcode').addClass('is-invalid');
                validate = false;
            }else{
                $('#vcode').removeClass('is-invalid');
            }
        }

        const speciesSelected = $('input[name="species[]"]:checked').length > 0;
        if (!speciesSelected) {
            $('#speciesGroup').addClass('border-danger');
            $('#speciesError').show();
            validate = false;
        } else {
            $('#speciesGroup').removeClass('border-danger');
            $('#speciesError').hide();
        }

        var country = $('#country').val();
        var phonecode = $('#country option:selected').attr("data-phonecode");

        if(country == 53) {
            if($('#province').val() == ''){
                $('#province').addClass('is-invalid');
                validate = false;
            }else{
                $('#province').removeClass('is-invalid');
            }

            if($('#canton').val() == ''){
                $('#canton').addClass('is-invalid');
                validate = false;
            }else{
                $('#canton').removeClass('is-invalid');
            }

            if($('#district').val() == ''){
                $('#district').addClass('is-invalid');
                validate = false;
            }else{
                $('#district').removeClass('is-invalid');
            }
        }else{
            if($('#province_alternate').val() == ''){
                $('#province_alternate').addClass('is-invalid');
                validate = false;
            }else{
                $('#province_alternate').removeClass('is-invalid');
            }

            if($('#canton_alternate').val() == ''){
                $('#canton_alternate').addClass('is-invalid');
                validate = false;
            }else{
                $('#canton_alternate').removeClass('is-invalid');
            }
        }

        if (window._itiPhone) {
            if (!window._itiPhone.isValidNumber()) {
                $('#phone').addClass('is-invalid');
                validate = false;
            } else {
                $('#phone').removeClass('is-invalid');
            }
            try { $('#phone').val(window._itiPhone.getNumber()); } catch (e) {}
        } else if($('#phone').val().trim() === '' || $('#phone').val() == '+' + phonecode) {
            $('#phone').addClass('is-invalid');
            validate = false;
        }

        if($('#lat').val() == '' || $('#lng').val() == '') {
            $('#clinicMap').addClass('border-danger');
            validate = false;
        } else {
            $('#clinicMap').removeClass('border-danger');
        }

        if(validate == true) {
            setCharge();
        }

        return validate;

    }

    setupDropzone('profilePhotoDrop', 'profilePhoto', 'profilePhotoPreview', 'removeProfilePhotoBtn', 'removeProfilePhoto', @json($profilePhoto), @json(isset($user->photo) && $user->photo != ''));
    setupDropzone('clinicLogoDrop', 'clinicLogo', 'clinicLogoPreview', 'removeClinicLogoBtn', 'removeClinicLogo', @json($clinicLogo), @json(isset($vet->logo) && $vet->logo != ''));

    $('input[name="mycode"]').on('change', function() {
        toggleVetCode(this.value === '1');
    });
    toggleVetCode($('input[name="mycode"]:checked').val() === '1');

    $('#frmProfile').on('input change', 'input, select, textarea', function() {
        updateActionButtons();
    });
    updateActionButtons();

    const phoneInput = document.getElementById('phone');
    if (phoneInput && window.intlTelInput) {
        const iti = window.intlTelInput(phoneInput, {
            initialCountry: "auto",
            separateDialCode: true,
            nationalMode: false,
            geoIpLookup: function(callback) {
                fetch('https://ipapi.co/json/')
                    .then(res => res.json())
                    .then(data => callback((data && data.country_code) ? data.country_code.toLowerCase() : 'us'))
                    .catch(() => callback('us'));
            },
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@23.1.1/build/js/utils.js",
        });

        window._itiPhone = iti;
        if (phoneInput.value) {
            try { iti.setNumber(phoneInput.value); } catch (e) {}
        }
    }

    const mapEl = document.getElementById('clinicMap');
    let map = null;
    let marker = null;
    const initialLat = parseFloat($('#lat').val() || '0');
    const initialLng = parseFloat($('#lng').val() || '0');
    const defaultCenter = (initialLat && initialLng) ? [initialLat, initialLng] : [9.933, -84.083];

    if (mapEl && typeof L !== 'undefined') {
        map = L.map('clinicMap').setView(defaultCenter, (initialLat && initialLng) ? 16 : 12);
        window._clinicMap = map;
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        const markerIcon = L.divIcon({
            className: '',
            html: '<div style="width:16px;height:16px;background:#4bc6f9;border:3px solid #152630;border-radius:50%;box-shadow:0 0 0 4px rgba(75,198,249,.25);"></div>',
            iconSize: [16, 16],
            iconAnchor: [8, 8]
        });

        function setMarker(lat, lng) {
            if (!marker) {
                marker = L.marker([lat, lng], { icon: markerIcon, draggable: true }).addTo(map);
                marker.on('dragend', function(e) {
                    const pos = e.target.getLatLng();
                    $('#lat').val(pos.lat.toFixed(6));
                    $('#lng').val(pos.lng.toFixed(6));
                });
            } else {
                marker.setLatLng([lat, lng]);
            }
            $('#lat').val(lat.toFixed(6));
            $('#lng').val(lng.toFixed(6));
        }
        window._setClinicMarker = setMarker;

        if (initialLat && initialLng) {
            setMarker(initialLat, initialLng);
        }

        map.on('click', function(e) {
            setMarker(e.latlng.lat, e.latlng.lng);
        });

        let geocodeController = null;
        function setMapLoading(isLoading) {
            const loader = document.getElementById('mapLoading');
            const mapEl = document.getElementById('clinicMap');
            if (!loader) return;
            loader.classList.toggle('d-none', !isLoading);
            if (mapEl) {
                mapEl.classList.toggle('map-hidden', isLoading);
            }
        }
        async function geocode(query, signal = null) {
            if (!query) return null;
            const url = `https://nominatim.openstreetmap.org/search?format=json&limit=1&q=${encodeURIComponent(query)}`;
            let res = null;
            try {
                res = await fetch(url, { headers: { 'Accept-Language': 'es,en' }, signal });
            } catch (e) {
                return null;
            }
            if (!res.ok) return null;
            const data = await res.json();
            if (!data.length) return null;
            const bbox = data[0].boundingbox
                ? [
                    [parseFloat(data[0].boundingbox[0]), parseFloat(data[0].boundingbox[2])],
                    [parseFloat(data[0].boundingbox[1]), parseFloat(data[0].boundingbox[3])]
                  ]
                : null;
            return { lat: parseFloat(data[0].lat), lng: parseFloat(data[0].lon), bbox };
        }

        async function updateMapFromAddress() {
            const countryText = $('#country option:selected').text();
            const provinceText = $('#province option:selected').text();
            const cantonText = $('#canton option:selected').text();
            const districtText = $('#district option:selected').text();
            const altProvince = $('#province_alternate').val();
            const altCanton = $('#canton_alternate').val();
            const address = $('#vetaddress').val();
            const hasSavedPin = $('#lat').val() !== '' && $('#lng').val() !== '';
            if (hasSavedPin) {
                setMarker(parseFloat($('#lat').val()), parseFloat($('#lng').val()));
            }

            const parts = [];
            if (countryText) parts.push(countryText);
            if (countryText && countryText.toLowerCase().includes('costa') && provinceText) parts.push(provinceText);
            if (countryText && countryText.toLowerCase().includes('costa') && cantonText) parts.push(cantonText);
            if (countryText && countryText.toLowerCase().includes('costa') && districtText) parts.push(districtText);
            if (altProvince) parts.push(altProvince);
            if (altCanton) parts.push(altCanton);
            if (!hasSavedPin && address) parts.push(address);

            const query = parts.filter(Boolean).join(', ');
            if (!query) {
                return;
            }
            if (geocodeController) {
                geocodeController.abort();
            }
            geocodeController = new AbortController();
            setMapLoading(true);
            const result = await geocode(query, geocodeController.signal);
            setMapLoading(false);
            if (result) {
                const onlyCountry =
                    !!countryText &&
                    !address &&
                    !provinceText &&
                    !cantonText &&
                    !districtText &&
                    !altProvince &&
                    !altCanton;
                if (onlyCountry && result.bbox) {
                    map.fitBounds(result.bbox, { padding: [20, 20] });
                } else {
                    map.setView([result.lat, result.lng], 14);
                }
                setMarker(result.lat, result.lng);
            }
        }

        $('#country, #province, #canton, #district').on('change', function() {
            updateMapFromAddress();
        });
        $('#province_alternate, #canton_alternate').on('input', function() {
            updateMapFromAddress();
        });

        window._updateMapFromAddress = updateMapFromAddress;

        const mapEl = document.getElementById('clinicMap');
        const latNow = parseFloat($('#lat').val() || '0');
        const lngNow = parseFloat($('#lng').val() || '0');
        if (mapEl && (!latNow || !lngNow)) {
            setMapLoading(true);
            updateMapFromAddress().finally(() => {
                setMapLoading(false);
            });
        }
    }

    function enterOnlyNumbers(event){
        if ( event.keyCode == 8 || event.keyCode == 9 || (event.keyCode >= 37 && event.keyCode <= 40) || event.keyCode == 188 || event.keyCode == 190 ) {
        } else {
            if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault();
            }
        }
    }
</script>
@endpush
