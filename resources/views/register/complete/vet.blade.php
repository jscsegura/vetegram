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
    $isProfileComplete = (isset($user->complete) && $user->complete == 1);
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
        <form class="col-xl-9 mx-auto mt-4 mt-lg-0 mb-lg-5 wizard-form" id="frmProfile" name="frmProfile" method="post" action="{{ route('register.complete-save') }}" data-action="Setup.validSend" data-action-event="submit" enctype="multipart/form-data">
            <h1 class="text-center text-md-start text-uppercase h4 fw-normal mb-2">{{ trans('auth.register.complete.cmp') }} <span class="text-info fw-bold">{{ trans('auth.register.complete.profile') }}</span></h1>
            <p class="text-center text-md-start text-muted mb-4">{{ trans('auth.register.complete.intro') }}</p>

            @csrf

            <div class="d-flex flex-wrap align-items-center gap-2 mb-4">
                <button type="button" class="btn btn-primary btn-sm text-uppercase step-btn" data-step="step1" data-action="Setup.changeTab" data-action-event="click" data-action-args="step1">1. {{ trans('auth.register.complete.step.identity') }}</button>
                <button type="button" class="btn btn-outline-secondary btn-sm text-uppercase step-btn" data-step="step2" data-action="Setup.changeTab" data-action-event="click" data-action-args="step2">2. {{ trans('auth.register.complete.step.clinic') }}</button>
                <button type="button" class="btn btn-outline-secondary btn-sm text-uppercase step-btn" data-step="step3" data-action="Setup.changeTab" data-action-event="click" data-action-args="step3">3. {{ trans('auth.register.complete.step.specialties') }}</button>
                <button type="button" class="btn btn-outline-secondary btn-sm text-uppercase step-btn" data-step="step4" data-action="Setup.changeTab" data-action-event="click" data-action-args="step4">4. {{ trans('auth.register.complete.step.location') }}</button>
                <button type="button" class="btn btn-outline-secondary btn-sm text-uppercase step-btn" data-step="step5" data-action="Setup.changeTab" data-action-event="click" data-action-args="step5">5. {{ trans('auth.register.complete.step.schedule') }}</button>
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
                                <input type="text" class="form-control fc requerido" id="idnumber" name="idnumber" value="{{ $user->dni ?? '' }}" data-action="vetegramHelpers.enterOnlyNumbers" data-action-event="keydown" data-action-args="$event" maxlength="50">
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
                                        <button type="button" class="btn btn-outline-secondary btn-sm" data-action="trigger-file" data-action-event="click" data-action-args="#profilePhoto">
                                            {{ trans('auth.register.complete.photo.btn') }}
                                        </button>
                                        <button type="button" class="btn btn-outline-danger btn-sm" id="removeProfilePhotoBtn" data-action="stop-propagation" data-action-event="click" style="{{ (isset($user->photo) && $user->photo != '') ? '' : 'display:none;' }}">
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
                                <input type="text" class="form-control fc requerido-vcode" id="vcode" name="vcode" value="{{ $vetCode }}" maxlength="50">
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
                                <input type="text" class="form-control fc requerido" id="idnumbervet" name="idnumbervet" value="{{ $vet->dni ?? '' }}" data-action="vetegramHelpers.enterOnlyNumbers" data-action-event="keydown" data-action-args="$event" maxlength="50">
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
                                        <button type="button" class="btn btn-outline-secondary btn-sm" data-action="trigger-file" data-action-event="click" data-action-args="#clinicLogo">
                                            {{ trans('auth.register.complete.logo.btn') }}
                                        </button>
                                        <button type="button" class="btn btn-outline-danger btn-sm" id="removeClinicLogoBtn" data-action="stop-propagation" data-action-event="click" style="{{ (isset($vet->logo) && $vet->logo != '') ? '' : 'display:none;' }}">
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
                                <select class="form-select fc requerido select2" name="country" id="country" data-action="Setup.changeCountry" data-action-event="change" data-action-args="$el">
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}" data-phonecode="{{ $country->phonecode }}" @if(($vetCountry && $country->id == $vetCountry) || (!$vetCountry && $country->default == 1)) selected="selected" @endif>{{ $country->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4" id="provinceGroup" style="{{ ($vetCountry && $vetCountry != 53) ? 'display: none;' : '' }}">
                                <label for="province" class="form-label small">{{ trans('auth.register.complete.province') }}</label>
                                <select class="form-select fc select2" name="province" id="province" data-action="Setup.getLocation" data-action-event="change" data-action-args="1|$value">
                                    <option value="">{{ trans('auth.register.complete.select') }}</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}" @if($vetProvince && $province->id == $vetProvince) selected @endif>{{ $province->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4" id="cantonGroup" style="{{ ($vetCountry && $vetCountry != 53) ? 'display: none;' : '' }}">
                                <label for="canton" class="form-label small">{{ trans('auth.register.complete.canton') }}</label>
                                <select class="form-select fc select2" name="canton" id="canton" data-action="Setup.getLocation" data-action-event="change" data-action-args="2|$value">
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
                        'nextStep' => 'step5',
                        'nextLabel' => trans('auth.register.complete.next.save')
                    ])
                </div>

                <div class="tab-pane fade" id="step5">
                    <div class="row g-4 g-xl-5">
                        <div class="col-12">
                            <h2 class="h5 text-uppercase mb-1">{{ trans('auth.register.complete.step.schedule') }}</h2>
                            <p class="text-muted mb-2">{{ trans('auth.register.complete.schedule.hint') }}</p>
                        </div>
                        <div class="col-12">
                            <input type="hidden" id="schedule_enabled" name="schedule_enabled" value="{{ isset($schedule) && $schedule ? 1 : 0 }}">
                            <div class="border rounded-3 p-3 bg-white">
                                @include('schedule.schedule._fields', ['schedule' => $schedule ?? null])
                            </div>
                        </div>
                    </div>
                    @include('register.complete.action-bar', [
                        'step' => 'step5',
                        'backStep' => 'step4',
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
<link rel="stylesheet" href="{{ asset('css/setup/complete-profile.css') }}">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@23.1.1/build/css/intlTelInput.css">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@23.1.1/build/js/intlTelInput.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    window.SETUP_COMPLETE_PROFILE_CONFIG = {
        routes: {
            getLocation: @json(route('get.location')),
            checkVetCode: @json(route('check.vetcode')),
            stepSave: {
                step1: @json(route('register.complete-save.identity')),
                step2: @json(route('register.complete-save.clinic')),
                step3: @json(route('register.complete-save.specialties')),
                step4: @json(route('register.complete-save.location')),
                step5: @json(route('register.complete-save.schedule'))
            }
        },
        texts: {
            select: @json(trans('auth.register.complete.select')),
            errorTitle: @json(trans('auth.register.complete.error.title')),
            errorRequired: @json(trans('auth.register.complete.error.required')),
            ok: @json(trans('auth.register.complete.ok'))
        },
        initial: {
            country: @json($vetCountry),
            province: @json($vetProvince),
            canton: @json($vetCanton),
            district: @json($vetDistrict)
        },
        images: {
            profilePhoto: @json($profilePhoto),
            profilePhotoHasImage: @json(isset($user->photo) && $user->photo != ''),
            clinicLogo: @json($clinicLogo),
            clinicLogoHasImage: @json(isset($vet->logo) && $vet->logo != '')
        },
        isProfileComplete: @json($isProfileComplete)
    };
</script>
<script src="{{ asset('js/setup/profile-validation.js') }}"></script>
<script src="{{ asset('js/setup/profile-draft.js') }}"></script>
<script src="{{ asset('js/setup/profile-map.js') }}"></script>
<script src="{{ asset('js/setup/profile-tabs.js') }}"></script>
<script src="{{ asset('js/setup/complete-profile.js') }}"></script>

@include('schedule.schedule._script')
@endpush
