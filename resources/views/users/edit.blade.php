@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@php $weblang = \App::getLocale(); @endphp

@include('elements.docmenu')

<section class="container-fluid pb-0 pb-lg-4">
    <div class="row px-2 px-lg-3 mt-2 mt-lg-4">
        
        <form id="frmProfileEdit" name="frmProfileEdit" method="post" action="{{ route('profile.update') }}" onsubmit="return validSend();">
            <h1 class="h4 text-uppercase text-center text-md-start fw-bold mb-2 mb-md-3 px-xl-5">
                <a href="{{ route('adminuser.index') }}" class="btn btn-sm smIcon"><i class="fa-solid fa-arrow-left-long"></i></a>
                {{ trans('auth.register.complete.profile') }} <span class="text-info fw-bold">{{ trans('auth.register.of.user') }}</span>
            </h1>
            <input type="hidden" name="hideId" id="hideId" value="{{ $idUser }}">
            <input type="hidden" name="edituser" id="edituser" value="1">

            @csrf

            <div class="container-fluid px-xl-5">
                
                <div class="row">
                    <div class="col-lg-4">
                        <div class="docCol card rounded-3 border-2 border-secondary">
                            <div class="card-body p-3 p-lg-4">
                                <div class="d-grid d-sm-flex gap-3">
                                    @php
                                        $photo = asset('img/default2.png');
                                        if($user->photo != '') {
                                            $photo = asset($user->photo);
                                        }
                                    @endphp

                                    @if($user->id == $profile->id)
                                    <div class="docPhoto position-relative rounded-circle m-auto m-sm-0" style="background-image: url({{ $photo }});">
                                        <button type="button" class="pencilBtn" data-bs-toggle="modal" data-bs-target="#changePhoto">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>
                                    </div>
                                    @else
                                    <div class="docPhoto rounded-circle bg-black m-auto m-sm-0" style="background-image: url({{ $photo }});"></div>
                                    @endif

                                    <div class="d-grid align-content-center">
                                        <h3 class="h5 text-uppercase m-0 text-center text-sm-start">{{ (in_array($user->rol_id, [3,4,6])) ? 'Dr. ' . $user->name : $user->name }}</h3>
                                        <p class="text-center text-sm-start">{{ trans('dash.rol.name.' . $user->rol_id) }}</p>

                                        @if(($profile->rol_id != 8)&&($user->id == $profile->id))
                                            @if($profile->signature == '')
                                                <div class="text-center text-sm-start">
                                                    <button class="btn btn-secondary btn-sm text-uppercase px-4 mt-2" data-bs-toggle="modal" data-bs-target="#signatureModal" onclick="event.preventDefault();">Crear firma</button>
                                                </div>
                                            @else
                                                <div class="position-relative text-center text-sm-start">
                                                    <img class="profileSignature" src="{{ $profile->signature }}" alt="Firma">
                                                    <a class="link-secondary d-table mx-auto mx-sm-0 pointer" data-bs-toggle="modal" data-bs-target="#signatureModal"><small>Editar firma</small></a>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                @if ($user->rol_id != 8)
                                <div class="row mt-3">
                                    <div class="col">
                                        <h4 class="h2 text-center text-sm-start m-0">{{ $patients }}</h4>
                                        <p class="text-uppercase text-center text-sm-start"><small>{{ trans('dash.total.patients') }}</small></p>
                                    </div>
                                </div>
                                @endif

                                @if($user->id == $profile->id)
                                
                                <div class="mt-4">
                                    <p class="text-uppercase fw-medium mb-1"><small>{{ trans('dash.label.notifications') }}</small></p>
                                    <div class="form-check mb-1">
                                        <input class="form-check-input" type="checkbox" value="1" id="notifiedEmail" name="notifiedEmail" onclick="changeNotified();" @if($user->mailer == 1) checked @endif>
                                        <label class="form-check-label small" for="notifiedEmail">
                                            {{ trans('dash.label.notified.email') }}
                                        </label>
                                    </div>
                                    <div class="form-check mb-1">
                                        <input class="form-check-input" type="checkbox" value="1" id="notifiedSms" name="notifiedSms" onclick="changeNotified();" @if($vet->pro == 0) disabled @else @if($user->sms == 1) checked @endif @endif>
                                        <label class="form-check-label small" for="changePass">
                                            {{ trans('dash.label.notified.sms') }}
                                        </label>
                                        @if(($vet->pro == 0)&&($profile->rol_id == 3)) <a href="{{ route('plan') }}">{{ trans('dash.label.notified.require.pro') }}</a> @endif
                                    </div>
                                    <div class="form-check mb-1">
                                        <input class="form-check-input" type="checkbox" value="1" id="notifiedWhatsapp" name="notifiedWhatsapp" onclick="changeNotified();" @if($vet->pro == 0) disabled @else @if($user->whatsapp == 1) checked @endif @endif>
                                        <label class="form-check-label small" for="changePass">
                                            {{ trans('dash.label.notified.whatsapp') }}
                                        </label>
                                        @if(($vet->pro == 0)&&($profile->rol_id == 3)) <a href="{{ route('plan') }}">{{ trans('dash.label.notified.require.pro') }}</a> @endif
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 ps-lg-5 mt-4 mt-lg-0 mb-lg-5">

                        @if(session('success'))
                        <div class="alert alert-success small mt-3 mb-0" role="alert">
                            {{ session('success') }}
                        </div><br />
                        @endif

                        <div class="row g-xl-5">
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label for="dname" class="form-label small">{{ trans('auth.login.fullname') }}</label>
                                    <input type="text" class="form-control fc requerido" id="dname" name="dname" value="{{ $user->name }}">
                                </div>
                                
                                <div class="mb-4">
                                    <label for="dname" class="form-label small">{{ trans('auth.register.complete.phone.only') }}</label>
                                    <input type="text" class="form-control fc requerido" id="phone" name="phone" value="{{ $user->phone }}" onkeydown="enterOnlyNumbers(event);" maxlength="12">
                                </div>

                                <div class="mb-4">
                                    <label for="vEmail" class="form-label small">{{ trans('auth.login.email') }}</label>
                                    <input type="email" class="form-control fc" id="vEmail" value="{{ $user->email }}" disabled>
                                </div>
                                @if (!in_array($user->rol_id, [8,5,6,7]))
                                <div class="mb-4">
                                    <label for="vcode" class="form-label small">{{ trans('auth.register.complete.code') }} <span id="resultCode"></span></label>
                                    <input type="text" class="form-control fc" id="vcode" name="vcode" value="{{ $user->code }}" onchange="checkCode(this.value);" onkeydown="enterOnlyNumbers(event);" maxlength="50">
                                </div>
                                @endif

                            @if ($user->rol_id != 3)
                            </div>
                            <div class="col-md-4">
                            @endif

                                <div class="mb-4">
                                    <label for="country" class="form-label small">{{ trans('auth.register.complete.country') }}</label>
                                    <select class="form-select fc requerido select2" id="country" name="country" onchange="changeCountry(this);">
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}" data-phonecode="{{ $country->phonecode }}" @if($country->id == $user->country) selected="selected" @endif>{{ $country->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="province" class="form-label small">{{ trans('auth.register.complete.province') }}</label>
                                    <div id="provinceDiv" @if($user->country != 53) style="display: none;" @endif>
                                        <select class="form-select fc select2" name="province" id="province" onchange="getLocation(1, this.value);">
                                            <option value="">{{ trans('auth.register.complete.select') }}</option>
                                            @foreach ($provinces as $province)
                                                <option value="{{ $province->id }}" @if($province->id == $user->province) selected="selected" @endif>{{ $province->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <input type="text" class="form-control fc" id="province_alternate" name="province_alternate" @if($user->country == 53) style="display: none;" @else value="{{ $user->province }}" @endif maxlength="255">
                                </div>
                                <div class="mb-4">
                                    <label for="canton" class="form-label small">{{ trans('auth.register.complete.canton.only') }}</label>
                                    <div id="cantonDiv" @if($user->country != 53) style="display: none;" @endif>
                                        <select class="form-select fc select2" name="canton" id="canton" onchange="getLocation(2, this.value);">
                                            <option value="">{{ trans('auth.register.complete.select') }}</option>
                                            @foreach ($cantons1 as $canton)
                                                <option value="{{ $canton->id }}" @if($canton->id == $user->canton) selected="selected" @endif>{{ $canton->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <input type="text" class="form-control fc" id="canton_alternate" name="canton_alternate" @if($user->country == 53) style="display: none;" @else value="{{ $user->canton }}" @endif maxlength="255">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label for="district" class="form-label small">{{ trans('auth.register.complete.district.only') }}</label>
                                    <div id="districtDiv" @if($user->country != 53) style="display: none;" @endif>
                                        <select class="form-select fc select2" name="district" id="district">
                                            <option value="">{{ trans('auth.register.complete.select') }}</option>
                                            @foreach ($districts1 as $district)
                                                <option value="{{ $district->id }}" @if($district->id == $user->district) selected="selected" @endif>{{ $district->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <input type="text" class="form-control fc" id="district_alternate" name="district_alternate" @if($user->country == 53) style="display: none;" @else value="{{ $user->district }}" @endif maxlength="255">
                                </div>
                                <div class="mb-4">
                                    <label for="idtype" class="form-label small">{{ trans('auth.register.complete.typedni') }}</label>
                                    <select class="form-select fc requerido" name="idtype" id="idtype">
                                        <option value="1" @if($user->type_dni == 1) selected="selected" @endif>{{ trans('auth.register.complete.physical') }}</option>
                                        <option value="2" @if($user->type_dni == 2) selected="selected" @endif>{{ trans('auth.register.complete.juridic') }}</option>
                                        <option value="3" @if($user->type_dni == 3) selected="selected" @endif>{{ trans('auth.register.complete.passport') }}</option>
                                        <option value="4" @if($user->type_dni == 4) selected="selected" @endif>DIMEX</option>
                                        <option value="5" @if($user->type_dni == 5) selected="selected" @endif>NITE</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="idnumber" class="form-label small">{{ trans('auth.register.complete.dni') }}</label>
                                    <input type="text" class="form-control fc" id="idnumber" name="idnumber" value="{{ $user->dni }}" onkeydown="enterOnlyNumbers(event);" maxlength="20">
                                </div>
                                                        
                            @if ($user->rol_id != 3)
                            </div>
                            @endif

                                @if ($user->rol_id == 3)
                                <div class="mb-4">
                                    <label for="socialName" class="form-label small">{{ trans('auth.register.complete.social') }}</label>
                                    <input type="text" class="form-control fc" id="socialName" name="socialName" value="{{ (isset($vet->social_name)) ? $vet->social_name : '' }}" maxlength="255">
                                </div>
                                <div class="mb-4">
                                    <label for="clinicname" class="form-label small">{{ trans('auth.register.complete.name') }}</label>
                                    <input type="text" class="form-control fc" id="clinicname" name="clinicname" value="{{ (isset($vet->company)) ? $vet->company : '' }}" maxlength="255">
                                </div>
                                <div class="mb-4">
                                    <label for="vetaddress" class="form-label small">{{ trans('auth.register.complete.address') }}</label>
                                    <textarea class="form-control fc" id="vetaddress" name="vetaddress" rows="2">{{ (isset($vet->address)) ? $vet->address : '' }}</textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="country2" class="form-label small">{{ trans('auth.register.complete.country.clinic') }}</label>
                                    <select class="form-select fc requerido" id="country2" name="country2" onchange="changeCountry2(this);">
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}" data-phonecode="{{ $country->phonecode }}" @if((isset($vet->country))&&($country->id == $vet->country)) selected="selected" @endif>{{ $country->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                            @if ($user->rol_id == 3)
                            </div>
                            <div class="col-md-4">
                            @endif
                            
                                <div class="mb-4">
                                    <label for="province2" class="form-label small">{{ trans('auth.register.complete.province') }}</label>
                                    <div id="province2Div" @if((isset($vet->country))&&($vet->country != 53)) style="display: none;" @endif>
                                        <select class="form-select fc" name="province2" id="province2" onchange="getLocation2(1, this.value);">
                                            <option value="">{{ trans('auth.register.complete.select') }}</option>
                                            @foreach ($provinces as $province)
                                                <option value="{{ $province->id }}" @if((isset($vet->province))&&($province->id == $vet->province)) selected="selected" @endif>{{ $province->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <input type="text" class="form-control fc" id="province_alternate2" name="province_alternate2" @if((isset($vet->country))&&($vet->country == 53)) style="display: none;" @else value="{{ (isset($vet->province)) ? $vet->province : '' }}" @endif maxlength="255">
                                </div>
                                <div class="mb-4">
                                    <label for="canton2" class="form-label small">{{ trans('auth.register.complete.canton') }}</label>
                                    <div id="canton2Div" @if((isset($vet->country))&&($vet->country != 53)) style="display: none;" @endif>
                                        <select class="form-select fc" name="canton2" id="canton2" onchange="getLocation2(2, this.value);">
                                            <option value="">{{ trans('auth.register.complete.select') }}</option>
                                            @foreach ($cantons2 as $canton)
                                                <option value="{{ $canton->id }}" @if((isset($vet->canton))&&($canton->id == $vet->canton)) selected="selected" @endif>{{ $canton->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <input type="text" class="form-control fc" id="canton_alternate2" name="canton_alternate2" @if((isset($vet->country))&&($vet->country == 53)) style="display: none;" @else value="{{ (isset($vet->canton)) ? $vet->canton : '' }}" @endif maxlength="255">
                                </div>
                                <div class="mb-4">
                                    <label for="district2" class="form-label small">{{ trans('auth.register.complete.district') }}</label>
                                    <div id="district2Div" @if((isset($vet->country))&&($vet->country != 53)) style="display: none;" @endif>
                                        <select class="form-select fc" name="district2" id="district2" @if((isset($vet->country))&&($vet->country != 53)) style="display: none;" @endif>
                                            <option value="">{{ trans('auth.register.complete.select') }}</option>
                                            @foreach ($districts2 as $district)
                                                <option value="{{ $district->id }}" @if((isset($vet->district))&&($district->id == $vet->district)) selected="selected" @endif>{{ $district->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <input type="text" class="form-control fc" id="district_alternate2" name="district_alternate2" @if((isset($vet->country))&&($vet->country == 53)) style="display: none;" @else value="{{ (isset($vet->district)) ? $vet->district : '' }}" @endif maxlength="255">
                                </div>
                                <div class="mb-4">
                                    <label for="phonevet" class="form-label small">{{ trans('auth.register.complete.phone') }}</label>
                                    <input type="text" class="form-control fc" id="phonevet" name="phonevet" value="{{ (isset($vet->phone)) ? $vet->phone : '' }}" onkeydown="enterOnlyNumbers(event);" maxlength="255">
                                </div>
                                <div class="mb-4">
                                    <label for="specialty" class="form-label small">{{ trans('auth.register.complete.speciality') }}</label>
                                    <select id="specialty" name="specialty[]" class="form-select fc select2 requerido" data-placeholder="Seleccionar" multiple>
                                        @php $spec = (isset($vet->specialities)) ? json_decode($vet->specialities, true) : []; @endphp
                                        @foreach ($specialties as $specialty)
                                            <option value="{{ $specialty->id }}" @if(in_array($specialty->id, $spec)) selected="selected" @endif>{{ $specialty['title_' . $weblang] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="language" class="form-label small">{{ trans('auth.register.complete.lang') }}</label>
                                    <select id="language" name="language[]" class="form-select fc select2 requerido" data-placeholder="Seleccionar" multiple>
                                        @php $langs = (isset($vet->languages)) ? json_decode($vet->languages, true) : []; @endphp
                                        @foreach ($languages as $language)
                                            <option value="{{ $language->id }}" @if(in_array($language->id, $langs)) selected="selected" @endif>{{ $language['title_' . $weblang] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="row">
                            <div class="mb-12">&nbsp;</div>
                        </div>

                        <div class="d-grid d-sm-flex gap-2">
                            <button type="submit" class="btn btn-primary px-5">{{ trans('auth.btn.save.changes') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
</section>

@include('elements.footer')

@include('elements.photo-signature')

@endsection

@push('scriptBottom')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/wpanel/library/jquery.toast.css') }}">
<script src="{{ asset('js/wpanel/library/jquery.toast.js') }}"></script>
<script>
    $( '.select2' ).select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
    } );

    function changeCountry(obj) {
        var country = $(obj).val();
        var phonecode = $('#country option:selected').attr("data-phonecode");

        if(country == 53) {
            $('#provinceDiv').show();
            $('#cantonDiv').show();
            $('#districtDiv').show();

            $('#province_alternate').hide();
            $('#canton_alternate').hide();
            $('#district_alternate').hide();
        }else{
            $('#provinceDiv').hide();
            $('#cantonDiv').hide();
            $('#districtDiv').hide();

            $('#province_alternate').show();
            $('#canton_alternate').show();
            $('#district_alternate').show();
        }

        $('#phone').val('+' + phonecode);
    }

    function getLocation(type, value) {
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
                }
                if(type == 2) {
                    $('#district').html(html);
                }
            }
        });
    }

    function changeCountry2(obj) {
        var country = $(obj).val();
        var phonecode = $('#country2 option:selected').attr("data-phonecode");

        if(country == 53) {
            $('#province2Div').show();
            $('#canton2Div').show();
            $('#district2Div').show();

            $('#province_alternate2').hide();
            $('#canton_alternate2').hide();
            $('#district_alternate2').hide();
        }else{
            $('#province2Div').hide();
            $('#canton2Div').hide();
            $('#district2Div').hide();

            $('#province_alternate2').show();
            $('#canton_alternate2').show();
            $('#district_alternate2').show();
        }

        $('#phonevet').val('+' + phonecode);
    }

    function getLocation2(type, value) {
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
                    $('#canton2').html(html);
                    $('#district2').html('<option value="">{{ trans('auth.register.complete.select') }}</option>');
                }
                if(type == 2) {
                    $('#district2').html(html);
                }
            }
        });
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

            if($('#district_alternate').val() == ''){
                $('#district_alternate').addClass('is-invalid');
                validate = false;
            }else{
                $('#district_alternate').removeClass('is-invalid');
            }
        }

        if(($('#phone').val() == '+' + phonecode)) {
            $('#phone').addClass('is-invalid');
            validate = false;
        }

        @if ($user->rol_id == 3)
        var country = $('#country2').val();
        var phonecode = $('#country2 option:selected').attr("data-phonecode");

        if(country == 53) {
            if($('#province2').val() == ''){
                $('#province2').addClass('is-invalid');
                validate = false;
            }else{
                $('#province2').removeClass('is-invalid');
            }

            if($('#canton2').val() == ''){
                $('#canton2').addClass('is-invalid');
                validate = false;
            }else{
                $('#canton2').removeClass('is-invalid');
            }

            if($('#district2').val() == ''){
                $('#district2').addClass('is-invalid');
                validate = false;
            }else{
                $('#district2').removeClass('is-invalid');
            }
        }else{
            if($('#province_alternate2').val() == ''){
                $('#province_alternate2').addClass('is-invalid');
                validate = false;
            }else{
                $('#province_alternate2').removeClass('is-invalid');
            }

            if($('#canton_alternate2').val() == ''){
                $('#canton_alternate2').addClass('is-invalid');
                validate = false;
            }else{
                $('#canton_alternate2').removeClass('is-invalid');
            }

            if($('#district_alternate2').val() == ''){
                $('#district_alternate2').addClass('is-invalid');
                validate = false;
            }else{
                $('#district_alternate2').removeClass('is-invalid');
            }
        }

        if(($('#phonevet').val() == '+' + phonecode)) {
            $('#phonevet').addClass('is-invalid');
            validate = false;
        }
        @endif
        
        if(validate == true) {
            setCharge();
        }

        return validate;

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