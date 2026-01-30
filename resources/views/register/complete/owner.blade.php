@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@php $weblang = \App::getLocale(); @endphp

<div class="container-fluid">
    <div class="d-flex align-items-center justify-content-between px-2 px-lg-3 py-3">
        <div>
            <!-- <svg class="dashLogo" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1000 224" style="enable-background:new 0 0 1000 224;" xml:space="preserve">
                <path style="fill:#4BC6F9;" d="M146.4,160c0,1.5-1.2,2.8-2.8,2.8c-1.5,0-2.8-1.2-2.8-2.8s1.2-2.8,2.8-2.8 C145.2,157.2,146.4,158.5,146.4,160"/>
                <path style="fill:#4BC6F9;" d="M223.2,112c0-61.6-50-111.6-111.6-111.6S0,50.4,0,112c0,0.9,0,1.7,0,2.6c0,0,0,0.1,0,0.1l22.3-22.4 l-0.1-0.2l33.4-34.5h0.3c5.1-5.4,10.3-10.2,15.3-14.4c9.1-7.6,17.5-13.3,24.3-17.5c0.5,4.1,0.7,10.3-1.5,17.1 c-2.2,7-1.7,9.4-1.2,12.8c0.2,1.1,1.1,2,2.3,2h86.2c0.2,0.7,0.4,1.3,0.8,1.9c0.4,0.6,0.9,1,1.5,1.4c-3.6,6.8-8.1,13-13.4,18.5 C165,85.1,159,90,152.5,94c-6.7-0.7-13.2-2.1-19.4-4.2c-6.2-2.1-12-4.9-17.5-8.2c3.9,3.7,8.2,7.1,12.8,10c4.6,2.9,9.4,5.5,14.6,7.5 c-11,5-23.3,7.9-36.3,7.9c-2.1,0-4.2-0.1-6.3-0.2c-2.1-0.2-4.2-0.4-6.2-0.7v116.2c5.7,0.9,11.5,1.4,17.4,1.4c10.1,0,20-1.4,29.3-3.9 c0.3-0.1,0.5-0.1,0.8-0.2v-34.2c0-0.3-0.1-0.5-0.4-0.6l0,0c-0.8-0.6-1.5-1-1.7-1.1c-0.2-0.1-0.4-0.2-0.6-0.3c-3-1.3-4.9,0-8-0.7 c-6.4-1.5-11.9-10.5-10-15.8c1.1-2.9,3.5-2.2,7-6.4c0.7-0.9,1.3-1.7,1.7-2.4c0.8-1.5,1.1-2.8,1.5-4.1c0.4-1.5,1-3,2.5-5 c4.2-5.5,8.8-5.4,9.2-9.2c0.2-2.5-1.7-3.3-3.1-7.6c-1.2-3.6-1-6.8-0.8-9c3.6,2.2,8,5.2,12.8,9.2c4.8,4,9.8,9,14.6,15.2l3.9,4.6 l27.2,31c3.6-4.3,6.8-8.9,9.7-13.7C217.4,152.7,223.2,133,223.2,112z"/>
                <path style="fill:#FFFFFF;" d="M189.4,55.8c-0.1-1.2-1.1-2.1-2.2-2.2c-1.7-0.2-3.1,1.2-2.9,2.9c0.1,1.2,1.1,2.1,2.2,2.2 C188.2,59,189.6,57.5,189.4,55.8"/>
                <path style="fill:#4BC6F9;" d="M93.5,32.4c-0.8,0.9-1.6,1.7-2.4,2.6c-0.8,0.9-1.5,1.8-2.2,2.7c-1.4,1.8-2.7,3.7-3.8,5.8 c-1.1,2-2,4.1-2.8,6.3c-0.8,2.2-1.5,4.4-2.1,6.7c-0.1-2.4,0.2-4.8,0.8-7.1c0.6-2.3,1.5-4.6,2.6-6.7c1.1-2.1,2.6-4.1,4.3-5.8 C89.5,35.1,91.4,33.6,93.5,32.4"/>
                <path d="M982.5,62.3h-4.1v11h-2.7v-11h-4.1v-2.2h11V62.3z M997.3,73.2l-0.6-9.1l-4.1,9.1h-1.3l-4.2-9.1l-0.6,9.1h-2.7l0.9-13.2h2.8 l4.4,9.5l4.3-9.5h2.8l0.9,13.2H997.3z"/>
                <polygon style="fill:#152630;" points="247,78.9 272,78.9 292.7,133.4 313.2,78.9 338.1,78.9 303.5,162.8 281.8,162.8 "/>
                <polygon style="fill:#152630;" points="412.8,143.5 412.8,162.8 349.8,162.8 349.8,78.9 412,78.9 412,98.2 373.2,98.2 373.2,110.9  407.7,110.9 407.7,130.2 373.2,130.2 373.2,143.5 "/>
                <polygon style="fill:#152630;" points="495.3,98.2 471.2,98.2 471.2,162.8 447.8,162.8 447.8,98.2 423.7,98.2 423.7,78.9 495.3,78.9 "/>
                <polygon style="fill:#152630;" points="572.6,143.5 572.6,162.8 509.6,162.8 509.6,78.9 571.8,78.9 571.8,98.2 532.9,98.2 532.9,110.9 567.5,110.9 567.5,130.2 532.9,130.2 532.9,143.5 "/>
                <path style="fill:#152630;" d="M672.6,120.9c0,25.4-16.8,43.1-43.2,43.1c-27.2,0-45.3-17.2-45.3-43.1s17.8-43.1,45.3-43.1 c12.9,0,24,3.7,31.4,9.9l-15.3,14.5c-2.8-3.2-8.2-5.1-15.8-5.1c-12.9,0-21.5,9.5-21.5,23.8c0,14.3,8.5,23.8,21.3,23.8 c9.7,0,16.4-4.9,18.4-12.6h-16.4v-19.3h40.8C672.4,115.5,672.6,118.1,672.6,120.9"/>
                <path style="fill:#152630;" d="M720.7,135.4h-10.2v27.4h-23.3V78.9h39.3c18.4,0,30.6,11.3,30.6,28.2c0,10.2-5,18.5-13.5,23.3 l20.7,32.3H737L720.7,135.4z M710.5,116.1h11.2c6.8,0,11.3-3.6,11.3-9c0-5.3-3.5-9-9.1-9h-13.5V116.1z"/>
                <path style="fill:#152630;" d="M830.1,151.3h-32.6l-4.3,11.4h-24.9L803,78.9h21.6l34.7,83.9h-24.9L830.1,151.3z M822.8,132.1l-9-24 l-9.1,24H822.8z"/>
                <polygon style="fill:#152630;" points="948.1,162.8 945.5,117.8 925.9,162.8 913.7,162.8 894.2,118 891.5,162.8 868.1,162.8 874.4,78.9 900.6,78.9 919.8,124 939.1,78.9 965.3,78.9 971.5,162.8 "/>
                <path style="fill:#4BC6F9;" d="M103.9,73c-0.5,1.4-1.9,2.3-3.5,2.1c-1.6-0.2-2.8-1.5-2.9-3.1c-0.1-1.4,0.7-2.7,1.9-3.3 c0.4-0.2,0.9-0.3,1.4-0.3c1.9,0,3.4,1.5,3.4,3.4C104.2,72.2,104.1,72.6,103.9,73"/>
            </svg> -->
            <object data="{{asset('img/logo.svg')}}" class="dashlogo"></object>
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
        <form class="col-xl-9 mx-auto mt-4 mt-lg-0 mb-lg-5" id="frmProfile" name="frmProfile" method="post" action="{{ route('register.complete-save') }}" data-action="Setup.validSend" data-action-event="submit">
            <h1 class="text-center text-md-start text-uppercase h4 fw-normal mb-3">{{ trans('auth.register.complete.cmp') }} <span class="text-info fw-bold">{{ trans('auth.register.complete.profile') }}</span></h1>

            @csrf
            <div class="tab-content" id="formSteps">
                <div class="tab-pane fade show active" id="step1">
                    <div class="row g-xl-5">
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="dname" class="form-label small">{{ trans('auth.login.fullname') }}</label>
                                <input type="text" class="form-control fc" id="name" name="name" value="{{ $user->name }}" readonly>
                            </div>
                            <div class="mb-4">
                                <label for="country" class="form-label small">{{ trans('auth.register.complete.country') }}</label>
                                <select class="form-select fc requerido select2" name="country" id="country" data-action="Setup.changeCountry" data-action-event="change" data-action-args="$el">
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}" data-phonecode="{{ $country->phonecode }}" @if($country->default == 1) selected="selected" @endif>{{ $country->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="phone" class="form-label small">{{ trans('auth.register.complete.phone.only') }}</label>
                                <input type="text" class="form-control fc requerido" id="phone" name="phone" data-action="vetegramHelpers.enterOnlyNumbers" data-action-event="keydown" data-action-args="$event" maxlength="255">
                            </div>
                        </div>
                        <div class="col-md-4">
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
                                <label for="idnumber" class="form-label small">{{ trans('auth.register.complete.dni') }}</label>
                                <input type="text" class="form-control fc requerido" id="idnumber" name="idnumber" data-action="vetegramHelpers.enterOnlyNumbers" data-action-event="keydown" data-action-args="$event" maxlength="20">
                            </div>
                            <div class="mb-4">
                                <label for="vEmail" class="form-label small">{{ trans('auth.login.email') }}</label>
                                <input type="email" class="form-control fc" id="vEmail" name="vEmail" value="{{ $user->email }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="province" class="form-label small">{{ trans('auth.register.complete.province.only') }}</label>
                                <select class="form-select fc select2" name="province" id="province" data-action="Setup.getLocation" data-action-event="change" data-action-args="1|$value">
                                    <option value="">{{ trans('auth.register.complete.select') }}</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}">{{ $province->title }}</option>
                                    @endforeach
                                </select>
                                <input type="text" class="form-control fc" id="province_alternate" name="province_alternate" style="display: none;" maxlength="255">
                            </div>
                            <div class="mb-4">
                                <label for="canton" class="form-label small">{{ trans('auth.register.complete.canton.only') }}</label>
                                <select class="form-select fc select2" name="canton" id="canton" data-action="Setup.getLocation" data-action-event="change" data-action-args="2|$value">
                                    <option value="">{{ trans('auth.register.complete.select') }}</option>
                                </select>
                                <input type="text" class="form-control fc" id="canton_alternate" name="canton_alternate" style="display: none;" maxlength="255">
                            </div>
                            <div class="mb-4">
                                <label for="district" class="form-label small">{{ trans('auth.register.complete.district.only') }}</label>
                                <select class="form-select fc select2" name="district" id="district">
                                    <option value="">{{ trans('auth.register.complete.select') }}</option>
                                </select>
                                <input type="text" class="form-control fc" id="district_alternate" name="district_alternate" style="display: none;" maxlength="255">
                            </div>
                        </div>
                    </div>
                    <div class="d-grid d-sm-flex gap-2">
                        <button type="button" class="btn btn-primary px-5" data-action="Setup.validateNext" data-action-event="click">{{ trans('auth.register.complete.next') }}</button>
                    </div>
                </div>
                <div class="tab-pane fade" id="step2" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                    <h2 class="h5 d-table fw-medium lh-1 text-uppercase mx-auto mt-4 text-secondary mb-1 mb-md-3 border-bottom pb-1">{{ trans('auth.register.complete.animal') }}</h2>
                    <div id="printAnimals">
                        @php
                            $optionTypes = '<option value="">' . trans('auth.register.complete.select') . '</option>';
                            foreach ($animalTypes as $type) {
                                $optionTypes .= '<option value="' . $type->id . '">' . $type['title_' . $weblang] . '</option>';
                            }
                        @endphp
                        
                        @if(count($pets) > 0)
                            @foreach ($pets as $pet)
                                <div class="d-grid d-md-flex gap-2 gap-md-4 justify-content-md-between align-items-center py-3">
                                    <div class="w-100">
                                        <label for="petname" class="form-label small">{{ trans('auth.register.complete.namepet') }}</label>
                                        <input type="text" class="form-control fc requerido2" value="{{ $pet->name }}" maxlength="255" readonly>
                                    </div>
                                    <div class="w-100">
                                        <label for="animaltype" class="form-label small">{{ trans('auth.register.complete.type') }}</label>
                                        <input type="text" class="form-control fc requerido2" value="{{ $pet['getType']['title_' . $weblang] }}" maxlength="255" readonly>
                                    </div>
                                    <div class="w-100">
                                        <label for="breed" class="form-label small">{{ trans('auth.register.complete.breed') }}</label>
                                        <input type="text" class="form-control fc requerido2" value="{{ $pet['getBreed']['title_' . $weblang] }}" maxlength="255" readonly>
                                    </div>
                                    <div class="text-center">
                                        <a class="btn btn-outline-success btn-sm pe-none mt-1 mt-md-0"><i class="fa-solid fa-check"></i></a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="d-grid d-md-flex gap-2 gap-md-4 justify-content-md-between align-items-center py-3">
                                <div class="w-100">
                                    <label for="petname" class="form-label small">{{ trans('auth.register.complete.namepet') }}</label>
                                    <input type="text" class="form-control fc requerido2" id="petname1" name="petname[]" value="" maxlength="255">
                                </div>
                                <div class="w-100">
                                    <label for="animaltype" class="form-label small">{{ trans('auth.register.complete.type') }}</label>
                                    <select name="animaltype[]" id="animaltype1" class="form-select fc select2 requerido2" data-code="1" data-action="Setup.getBreed" data-action-event="change" data-action-args="$el">
                                        <?php echo $optionTypes; ?>
                                    </select>
                                </div>
                                <div class="w-100">
                                    <label for="breed" class="form-label small">{{ trans('auth.register.complete.breed') }}</label>
                                    <select name="breed[]" id="breed1" class="form-select fc select2 requerido2">
                                        <option value="">{{ trans('auth.register.complete.select') }}</option>
                                    </select>
                                </div>
                                <div class="text-center">
                                    <a class="btn btn-outline-success btn-sm pe-none mt-1 mt-md-0"><i class="fa-solid fa-check"></i></a>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="d-block d-md-table">
                        <a data-action="Setup.addAnimal" data-action-event="click" class="btn btn-outline-secondary btn-sm mb-2 w-100">
                            <i class="fa-solid fa-plus text-primary me-1"></i>
                            {{ trans('auth.register.complete.addOther') }}
                        </a>
                    </div>
                    <div class="d-grid d-sm-flex gap-2 mt-4">
                        <button type="button" class="btn btn-secondary px-5" data-action="Setup.changeTab" data-action-event="click" data-action-args="step1">{{ trans('auth.register.complete.previous') }}</button>
                        <button type="submit" class="btn btn-primary px-5">{{ trans('auth.register.complete.save') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@include('elements.footer')

@endsection

@push('scriptBottom')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    window.REGISTER_COMPLETE_OWNER_CONFIG = {
        routes: {
            getLocation: @json(route('get.location')),
            getBreed: @json(route('get.breed'))
        },
        texts: {
            select: @json(trans('auth.register.complete.select'))
        },
        labels: {
            namepet: @json(trans('auth.register.complete.namepet')),
            type: @json(trans('auth.register.complete.type')),
            breed: @json(trans('auth.register.complete.breed'))
        },
        optionTypes: @json($optionTypes)
    };
</script>
<script src="{{ asset('js/register/complete-owner.js') }}"></script>
@endpush
