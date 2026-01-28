@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

    <section id="logBox" class="container">
        <div class="row h-100">

            @include('elements.loginBanner')

			<div id="logForm" class="col-xl-6 d-flex flex-column px-3 px-xl-5 mt-3 mt-xl-0">
				
				@include('elements.loginTop')

				<div>
					<h1 class="h4 text-uppercase text-center text-md-start mt-4 mt-xl-0 mb-1">{{ trans('auth.login.signup') }}</h1>
					<p class="mb-4">{{ trans('auth.login.signup.description') }}</p>
					<form class="row" name="frmSignup" id="frmSignup" method="post" action="{{ route('register') }}" onsubmit="return validateSignup();">
                        @csrf
                        <input type="hidden" name="rol" id="rol" value="{{ $type }}">
                        <div class="col-lg-6 mb-3">
							<label for="idInput" class="form-label small">{{ trans('auth.register.complete.dni') }}</label>
							<div class="input-group">
								<input type="text" class="form-control" id="idInput" name="idInput" required autocomplete="off">
								<span class="input-group-text">
									<i class="fa-regular fa-id-card"></i>
								</span>
							</div>
						</div>
						<div class="col-lg-6 mb-3">
							<label for="nameInput" class="form-label small">{{ trans('auth.login.fullname') }}</label>
							<div class="input-group">
								<input type="text" class="form-control" id="name" name="name" required autocomplete="off">
								<span class="input-group-text">
									<i class="fa-regular fa-user"></i>
								</span>
							</div>
						</div>
						<div class="col-lg-6 mb-3">
							<label for="emailInput" class="form-label small">{{ trans('auth.login.email') }}</label>
							<div class="input-group">
								<input type="email" class="form-control" id="email" name="email" required autocomplete="off">
								<span class="input-group-text">
									<i class="fa-regular fa-envelope"></i>
								</span>
							</div>
						</div>
						<div class="col-lg-6 mb-3">
							<label for="passwordInput" class="form-label small">{{ trans('auth.login.password') }}</label>
							<div class="input-group">
								<input type="password" class="form-control" id="password" name="password" required autocomplete="off">
								<span class="input-group-text btn-toggle-password">
									<i class="fa-regular fa-eye"></i>
								</span>
							</div>
						</div>
						<div class="col-lg-6 mb-3">
							<label for="cpasswordInput" class="form-label small">{{ trans('auth.login.confirm.password') }}</label>
							<div class="input-group">
								<input type="password" class="form-control" id="cpassword" name="cpassword" required autocomplete="off">
								<span class="input-group-text btn-toggle-password2">
									<i class="fa-regular fa-eye"></i>
								</span>
							</div>
						</div>
                        <div>
                            <div class="form-check mb-4 fs-5">
                                <input class="form-check-input" type="checkbox" value="termsCheck" id="termsCheck">
                                <label class="form-check-label smallFc" for="termsCheck">
                                    {{ trans('auth.login.terms.title') }} <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal" class="fw-medium">{{ trans('auth.terms') }}</a>
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary text-uppercase w-100" id="btnRegister">{{ trans('auth.login.started') }}</button>
                        </div>

						@if(session('error'))
                        <div class="mt-3">
                            <div class="alert alert-danger mb-0">
                                <strong>Error!</strong> {{ session('error') }}
                            </div>
                        </div>
                        @endif
					</form>
					<div class="m-2 text-center">{{ trans('auth.login.or') }}</div>
					<div class="row">
						<div class="col-md-6 mb-2 mb-xl-0">
							<a href="{{ route('register.google', $type) }}" class="btn btn-light w-100">
								<svg class="loginLogo me-2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><defs><path id="A" d="M44.5 20H24v8.5h11.8C34.7 33.9 30.1 37 24 37c-7.2 0-13-5.8-13-13s5.8-13 13-13c3.1 0 5.9 1.1 8.1 2.9l6.4-6.4C34.6 4.1 29.6 2 24 2 11.8 2 2 11.8 2 24s9.8 22 22 22c11 0 21-8 21-22 0-1.3-.2-2.7-.5-4z"/></defs><clipPath id="B"><use xlink:href="#A"/></clipPath><g transform="matrix(.727273 0 0 .727273 -.954545 -1.45455)"><path d="M0 37V11l17 13z" clip-path="url(#B)" fill="#fbbc05"/><path d="M0 11l17 13 7-6.1L48 14V0H0z" clip-path="url(#B)" fill="#ea4335"/><path d="M0 37l30-23 7.9 1L48 0v48H0z" clip-path="url(#B)" fill="#34a853"/><path d="M48 48L17 24l-4-3 35-10z" clip-path="url(#B)" fill="#4285f4"/></g></svg>
								<span class="small">{{ trans('auth.login.with.google') }}</span>
							</a>
						</div>
						<div class="col-md-6">
							<a href="{{ route('register.facebook', $type) }}" class="btn btn-light w-100">
								<svg class="loginLogo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="#3b5999" d="M15.12,5.32H17V2.14A26.11,26.11,0,0,0,14.26,2C11.54,2,9.68,3.66,9.68,6.7V9.32H6.61v3.56H9.68V22h3.68V12.88h3.06l.46-3.56H13.36V7.05C13.36,6,13.64,5.32,15.12,5.32Z"></path></svg>
								<span class="small">{{ trans('auth.login.with.facebook') }}</span>
							</a>
						</div>
					</div>
				</div>

				<p class="mt-4 mt-xl-auto mb-3 mb-xl-0">{{ trans('auth.already.login') }} <a href="{{ route('home.index') }}" class="fw-medium">{{ trans('auth.sign.in') }}</a></p>

			</div>
        </div>
    </section>

    <div id="termsModal" class="modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">{{ trans('auth.terms') }}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
            	{!! (isset($setting['term_' . \App::getLocale()])) ? $setting['term_' . \App::getLocale()] : '' !!}
            </div>
          </div>
        </div>
	</div>

    <div id="loadingModal" class="modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
          <div class="modal-content">
            <div class="modal-body p-4 text-center">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
          </div>
        </div>
	</div>
@endsection

@push('scriptBottom')
<script>
    
    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    const passwordInput = document.getElementById('password');
    const passwordToggleBtn = document.querySelector('.btn-toggle-password');
    const idInput = document.querySelector('#idInput');
    const nameInput = document.querySelector('#name');
    const loadingModal = $("#loadingModal");
    
    idInput.addEventListener('change', function() {
        nameInput.value = '';
        loadingModal.modal('toggle');
        value = this.value;
        if(value == '') {
            loadingModal.modal('toggle');
            nameInput.focus();
        } else if(value.length < 9) {
            console.log("too short");
            loadingModal.modal('toggle');
        } else {
            fetchInfo(this.value);
        }
        nameInput.focus();
    });

    passwordToggleBtn.addEventListener('click', function() {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            passwordToggleBtn.innerHTML = '<i class="fa-regular fa-eye-slash"></i>';
        } else {
            passwordInput.type = 'password';
            passwordToggleBtn.innerHTML = '<i class="fa-regular fa-eye"></i>';
        }
    });

    const cpasswordInput = document.getElementById('cpassword');
    const cpasswordToggleBtn = document.querySelector('.btn-toggle-password2');
    
    cpasswordToggleBtn.addEventListener('click', function() {
        if (cpasswordInput.type === 'password') {
            cpasswordInput.type = 'text';
            cpasswordToggleBtn.innerHTML = '<i class="fa-regular fa-eye-slash"></i>';
        } else {
            cpasswordInput.type = 'password';
            cpasswordToggleBtn.innerHTML = '<i class="fa-regular fa-eye"></i>';
        }
    });

    function validateSignup() {
        var validate = true;

		$('#name').removeClass('is-invalid');
        $('#email').removeClass('is-invalid');
		$('#password').removeClass('is-invalid');
        $('#cpassword').removeClass('is-invalid');
		$('#termsCheck').removeClass('is-invalid');

		if($('#name').val() == ''){
            $('#name').addClass('is-invalid');
            validate = false;
        }

		if(!validaEmail($('#email').val())){
            $('#email').addClass('is-invalid');
            validate = false;
        }

		if($('#password').val() == ''){
            $('#password').addClass('is-invalid');
            validate = false;
        }

        if($('#cpassword').val() == ''){
            $('#cpassword').addClass('is-invalid');
            validate = false;
        }

        if($('#password').val() != $('#cpassword').val()){
            $('#cpassword').addClass('is-invalid');
            validate = false;
        }

		if(!$("#termsCheck").prop("checked")) {
        	$('#termsCheck').addClass('is-invalid');
            validate = false;
    	}

		if(validate == true) {
            setLoad('btnRegister', '{{ trans('auth.text.btn.process') }}');
        }
        
        return validate;
    }

	function validaEmail(email) {
        var reg=/^[0-9a-z_\-\+.]+@[0-9a-z\-\.]+\.[a-z]{2,8}$/i;
        if(reg.test(email)){
            return true;
        }else{
            return false;
        }
    }

    async function fetchInfo(value) {
        res = await fetch('/staging2/getHaciendaInfo?id=' + value + '&type=1');
        if(!res.ok) {
           console.log(res.status);
        } else {
            body = await res.json();
            console.log(body);

            if(body.ERROR) {
                console.log(body.error);
                nameInput.focus();
            } else {
                name = capitalizeFirstLetter(body.NOMBRE.toLowerCase()) + ' ' +  capitalizeFirstLetter(body.APELLIDO1.toLowerCase()) + ' ' + capitalizeFirstLetter(body.APELLIDO2.toLowerCase());
                nameInput.value = name;
            }
        }
        loadingModal.modal('toggle');
    }
 </script>
@endpush
