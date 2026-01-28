@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@include('elements.docmenu')

<section class="container-fluid pb-0 pb-lg-4">
    <div class="row px-2 px-lg-3 mt-2 mt-lg-4">
        
        <form class="col-xl-9 mx-auto mt-4 mt-lg-0 mb-lg-5" id="frmProfile" name="frmProfile" method="post" action="{{ route('adminuser.store') }}" onsubmit="return validSend();">
            @csrf

            <h1 class="text-center text-md-start text-uppercase h4 fw-normal mb-3">
                <a href="{{ route('adminuser.index') }}" class="btn btn-sm smIcon"><i class="fa-solid fa-arrow-left-long"></i></a>
                {{ trans('dashadmin.label.title.add') }} <span class="text-info fw-bold">{{ trans('dashadmin.label.single.user') }}</span>
            </h1>

            <div class="row g-xl-5">
                <div class="col-md-4">
                    <div class="mb-4">
                        <label for="idtype" class="form-label small">{{ trans('auth.register.type.user') }}</label>
                        <select class="form-select fc requerido" name="roluser" id="roluser" onchange="setRol();">
                            <option value="4">{{ trans('dash.rol.name.4') }}</option>
                            <option value="5">{{ trans('dash.rol.name.5') }}</option>
                            <option value="6">{{ trans('dash.rol.name.6') }}</option>
                            <option value="7">{{ trans('dash.rol.name.7') }}</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="phone" class="form-label small">{{ trans('auth.register.complete.phone.only') }}</label>
                        <input type="text" class="form-control fc requerido" id="phone" name="phone" onkeydown="enterOnlyNumbers(event);" maxlength="12">
                    </div>
                    <div class="mb-4">
                        <label for="country" class="form-label small">{{ trans('auth.register.complete.country') }}</label>
                        <select class="form-select fc requerido select2" id="country" name="country" onchange="changeCountry(this);">
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
                            <select class="form-select fc select2" name="province" id="province" onchange="getLocation(1, this.value);">
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
                        <input type="text" class="form-control fc" id="vcode" name="vcode" value="" onchange="checkCode(this.value);" onkeydown="enterOnlyNumbers(event);" maxlength="50">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-4">
                        <label for="vEmail" class="form-label small">{{ trans('auth.login.email') }}</label>
                        <input type="email" class="form-control fc requerido requeridoEmail" id="vEmail" name="vEmail" value="">
                    </div>
                    <div class="mb-4">
                        <label for="idnumber" class="form-label small">{{ trans('auth.register.complete.dni') }}</label>
                        <input type="text" class="form-control fc requerido" id="idnumber" name="idnumber" onkeydown="enterOnlyNumbers(event);" maxlength="12">
                    </div>
                    <div class="mb-4">
                        <label for="canton" class="form-label small">{{ trans('auth.register.complete.canton.only') }}</label>
                        <div id="cantonDiv" @if($vet->country != 53) style="display: none;" @endif>
                            <select class="form-select fc select2" name="canton" id="canton" onchange="getLocation(2, this.value);">
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
    $('.select2').select2({
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
    });

    function setRol() {
        var roluser = $('#roluser').val();

        if((roluser == 4)) {
            $('#containerCode').show();
        }else{
            $('#containerCode').hide();
        }
    }

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

        var letraPattern = /[a-zA-Z]/;

        $('.requeridoLetra').each(function(i, elem){
            if(!letraPattern.test($(elem).val())){
                $(elem).addClass('is-invalid');
                validate = false;

                $.toast({
                    text: 'El nombre debe contener letras',
                    position: 'bottom-right',
                    textAlign: 'center',
                    loader: false,
                    hideAfter: 4000,
                    icon: 'error'
                });
            }
        });

        var emailPattern = /^[a-zA-Z0-9._+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

        $('.requeridoEmail').each(function(i, elem){
            if(!emailPattern.test($(elem).val())){
                $(elem).addClass('is-invalid');
                validate = false;

                $.toast({
                    text: 'El correo no es válido',
                    position: 'bottom-right',
                    textAlign: 'center',
                    loader: false,
                    hideAfter: 4000,
                    icon: 'error'
                });
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