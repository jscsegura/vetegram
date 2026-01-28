@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

    <section id="logBox" class="container">
        <div class="row h-100">

            @include('elements.loginBanner')

            <div id="logForm" class="col-xl-6 d-flex flex-column px-3 px-xl-5 mt-3 mt-xl-0">
                
                @include('elements.loginTop')

                <div>
                    <div class="d-inline-block mt-3 mt-lg-0 mb-3">
                        <a href="{{ route('home.index') }}" class="d-flex align-items-center text-body text-decoration-none">
							<i class="fa-solid fa-angle-left backBtn"></i>
                            <span class="ms-2">{{ trans('auth.login.back') }}</span>
                        </a>
                    </div>

                    <h1 class="h4 text-uppercase mt-4 mt-lg-0 mb-1">{{ trans('auth.reset.title') }}</h1>
                    <p class="mb-4">{{ trans('auth.reset.instruction') }}</p>
                    
                    <form method="post" action="{{ route('password.update') }}" onsubmit="return validReset();">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">
                        
                        <div class="mb-3">
                            <label for="emailInput" class="form-label small">{{ trans('auth.login.email') }}</label>
                            <div class="input-group">
                                <input type="email" class="form-control" id="email" name="email" value="{{ $email }}" onfocus="blur()">
                                <span class="input-group-text">
                                    <i class="fa-regular fa-envelope"></i>
                                </span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="passwordInput" class="form-label small">{{ trans('auth.login.password') }}</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password" required autocomplete="off">
                                <span class="input-group-text btn-toggle-password">
                                    <i class="fa-regular fa-eye"></i>
                                </span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="passwordInput" class="form-label small">{{ trans('auth.login.confirm.password') }}</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required autocomplete="off">
                                <span class="input-group-text btn-toggle-password2">
                                    <i class="fa-regular fa-eye"></i>
                                </span>
                            </div>
                        </div>

                        @if(session('error'))
                        <div class="alert alert-danger">
                            <strong>Error!</strong> {{ session('error') }}
                        </div>
                        @endif

                        <button type="submit" class="btn btn-primary text-uppercase w-100" id="btnReset">{{ trans('auth.reset.confirm') }}</button>
                    </form>
                </div>

                <p class="mt-4 mt-xl-auto mb-3 mb-xl-0">{{ trans('auth.login.not.account') }} <a href="{{ route('usertype') }}" class="fw-medium">{{ trans('auth.login.create.account') }}</a></p>

            </div>
        </div>
    </section>

@endsection

@push('scriptBottom')
<script>
    const passwordInput = document.getElementById('password');
    const passwordConfirm = document.getElementById('password_confirmation');
    const passwordToggleBtn = document.querySelector('.btn-toggle-password');
    const passwordToggleBtn2 = document.querySelector('.btn-toggle-password2');
    
    passwordToggleBtn.addEventListener('click', function() {
      if (passwordInput.type === 'password') {
         passwordInput.type = 'text';
         passwordToggleBtn.innerHTML = '<i class="fa-regular fa-eye-slash"></i>';
      } else {
         passwordInput.type = 'password';
         passwordToggleBtn.innerHTML = '<i class="fa-regular fa-eye"></i>';
      }
    });
    passwordToggleBtn2.addEventListener('click', function() {
      if (passwordConfirm.type === 'password') {
        passwordConfirm.type = 'text';
        passwordToggleBtn2.innerHTML = '<i class="fa-regular fa-eye-slash"></i>';
      } else {
        passwordConfirm.type = 'password';
        passwordToggleBtn2.innerHTML = '<i class="fa-regular fa-eye"></i>';
      }
    });

    function validReset() {
        var validate = true;

        $('#password').removeClass('is-invalid');
        $('#password_confirmation').removeClass('is-invalid');

        if($('#password').val() == ''){
            $('#password').addClass('is-invalid');
            validate = false;
        }

        if($('#password_confirmation').val() == ''){
            $('#password_confirmation').addClass('is-invalid');
            validate = false;
        }

        if($('#password').val() != $('#password_confirmation').val()){
            $('#password_confirmation').addClass('is-invalid');
            validate = false;
        }

        if(validate == true) {
            setLoad('btnReset', '{{ trans('auth.text.btn.process') }}');
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
 </script>
@endpush