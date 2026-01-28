@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

    <section id="logBox" class="container">
        <div class="row h-100">

            @include('elements.loginBanner')

			<div id="logForm" class="col-xl-6 d-flex flex-column px-2 px-xl-5 mt-3 mt-xl-0">
				
                @include('elements.loginTop')

				<div>
					<h1 class="h4 text-uppercase text-center text-md-start mt-4 mt-xl-0 mb-1">{{ trans('auth.register.verified.complete') }}</h1>
					<p class="mb-4">{{ trans('auth.register.verified.description') }}</p>
					
                    @if($verified == true)
                    <div class="alert alert-success small mt-3 mb-0" role="alert">
                        {{ trans('auth.register.verified.true') }}
                    </div>
                    @endif

                    @if($verified == false)
                    <div class="alert alert-danger small mt-3 mb-0" role="alert">
                        {{ trans('auth.register.verified.false') }}
                    </div>
                    @endif

                    <p>&nbsp;</p>

                    <a href="{{ route('home.index') }}" class="btn btn-primary text-uppercase w-100" id="btnContinue">{{ trans('auth.btn.continue') }}</a>

				</div>

				<p class="mt-4 mt-lg-auto mb-2 mb-lg-0">{{ trans('auth.already.login') }} <a href="{{ route('home.index') }}" class="fw-medium">{{ trans('auth.sign.in') }}</a></p>

			</div>
        </div>
    </section>
@endsection