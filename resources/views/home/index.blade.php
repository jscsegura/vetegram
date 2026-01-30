@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

    <section id="logBox" class="container">
        <div class="row h-100">

            @include('elements.loginBanner')

            <div id="logForm" class="col-xl-6 d-flex flex-column px-3 px-xl-5 mt-3 mt-xl-0">
                
                @include('elements.loginTop')

                <div>
                    <h1 class="h4 text-uppercase text-center text-md-start mt-4 mt-xl-0 mb-1">{{ trans('auth.login.signin') }}</h1>
                    <p class="mb-4">{{ trans('auth.login.instruction') }}</p>

                    @if(session('success'))
                    <div class="alert alert-success small mt-3 mb-0" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif
                    
                    <form method="post" action="{{ route('login.submit') }}" data-action="Home.validLogin" data-action-event="submit">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="emailInput" class="form-label small">{{ trans('auth.login.email') }}</label>
                            <div class="input-group">
                                <input type="email" class="form-control" id="emailInput" name="emailInput" required>
                                <span class="input-group-text">
                                    <i class="fa-regular fa-envelope"></i>
                                </span>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label for="passwordInput" class="form-label small">{{ trans('auth.login.password') }}</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="passwordInput" name="passwordInput" required>
                                <span class="input-group-text btn-toggle-password">
                                    <i class="fa-regular fa-eye"></i>
                                </span>
                            </div>
                        </div>

                        @if(session('error'))
                        <div class="mt-3">
                            <div class="alert alert-danger mb-0">
                                <strong>Error!</strong> {{ session('error') }}
                            </div>
                        </div>
                        @endif

                        <p class="small mb-4">
                            <a href="{{ route('forgot') }}" class="d-table ms-auto">{{ trans('auth.login.forgot') }}</a>
                        </p>
                        
                        <button type="submit" class="btn btn-primary text-uppercase w-100" id="btnLogin">{{ trans('auth.login.signin') }}</button>
                    </form>
                    <div class="m-2 text-center">{{ trans('auth.login.or') }}</div>
                    <div class="row">
                        <div class="col-lg-6 mb-2 mb-lg-0">
                            <a href="{{ route('login.google') }}" class="btn btn-light w-100">
                                <svg class="loginLogo me-2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><defs><path id="A" d="M44.5 20H24v8.5h11.8C34.7 33.9 30.1 37 24 37c-7.2 0-13-5.8-13-13s5.8-13 13-13c3.1 0 5.9 1.1 8.1 2.9l6.4-6.4C34.6 4.1 29.6 2 24 2 11.8 2 2 11.8 2 24s9.8 22 22 22c11 0 21-8 21-22 0-1.3-.2-2.7-.5-4z"/></defs><clipPath id="B"><use xlink:href="#A"/></clipPath><g transform="matrix(.727273 0 0 .727273 -.954545 -1.45455)"><path d="M0 37V11l17 13z" clip-path="url(#B)" fill="#fbbc05"/><path d="M0 11l17 13 7-6.1L48 14V0H0z" clip-path="url(#B)" fill="#ea4335"/><path d="M0 37l30-23 7.9 1L48 0v48H0z" clip-path="url(#B)" fill="#34a853"/><path d="M48 48L17 24l-4-3 35-10z" clip-path="url(#B)" fill="#4285f4"/></g></svg>
                                <span class="small">{{ trans('auth.login.with.google') }}</span>
                            </a>
                        </div>
                        <div class="col-lg-6">
                            <a href="{{ route('login.facebook') }}" class="btn btn-light w-100">
                                <svg class="loginLogo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="#3b5999" d="M15.12,5.32H17V2.14A26.11,26.11,0,0,0,14.26,2C11.54,2,9.68,3.66,9.68,6.7V9.32H6.61v3.56H9.68V22h3.68V12.88h3.06l.46-3.56H13.36V7.05C13.36,6,13.64,5.32,15.12,5.32Z"></path></svg>
                                <span class="small">{{ trans('auth.login.with.facebook') }}</span>
                            </a>
                        </div>
                    </div>
                </div>

                <p class="mt-4 mt-xl-auto mb-3 mb-xl-0">{{ trans('auth.login.not.account') }} <a href="{{ route('usertype') }}" class="fw-medium">{{ trans('auth.login.create.account') }}</a></p>

            </div>
        </div>
    </section>

@endsection

@push('scriptBottom')
<script>
    window.HOME_INDEX_CONFIG = {
        processLabel: @json(trans('auth.text.btn.process'))
    };
</script>
<script src="{{ asset('js/home/index.js') }}"></script>
@endpush
