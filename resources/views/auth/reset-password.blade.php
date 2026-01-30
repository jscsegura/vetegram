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
                    
                    <form method="post" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">
                        
                        <div class="mb-3">
                            <label for="emailInput" class="form-label small">{{ trans('auth.login.email') }}</label>
                            <div class="input-group">
                                <input type="email" class="form-control" id="email" name="email" value="{{ $email }}" readonly>
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
    window.AUTH_RESET_CONFIG = {
        labels: {
            processing: "{{ trans('auth.text.btn.process') }}"
        }
    };
</script>
<script src="{{ asset('js/auth/reset.js') }}"></script>
@endpush
