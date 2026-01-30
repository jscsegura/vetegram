@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

    <section id="logBox" class="container">
        <div class="row h-100">

            @include('elements.loginBanner')

			<div id="logForm" class="col-xl-6 d-flex flex-column px-3 px-xl-5 mt-3 mt-xl-0">

				@include('elements.loginTop')

				<div>
                    <div class="d-inline-block mt-3 mb-3">
                        <a href="{{ route('home.index') }}" class="d-flex align-items-center text-body text-decoration-none">
							<i class="fa-solid fa-angle-left backBtn"></i>
                            <span class="ms-2">{{ trans('auth.login.back') }}</span>
                        </a>
                    </div>
					<h1 class="h4 text-uppercase text-center text-md-start mb-2">{{ trans('auth.login.forgot') }}</h1>
                    <p class="mb-4">{{ trans('auth.login.forgot.instructions') }}</p>
					<form method="post" action="{{ route('forgot.submit') }}">
						@csrf
						
						<div class="mb-3">
							<label for="emailInput" class="form-label small">{{ trans('auth.login.email') }}</label>
							<div class="input-group">
								<input type="email" class="form-control" id="email" name="email" required>
								<span class="input-group-text">
									<i class="fa-regular fa-envelope"></i>
								</span>
							</div>
						</div>
						
						<button type="submit" class="btn btn-primary text-uppercase w-100" id="btnReset">{{ trans('auth.login.reset') }}</button>

						@if(session('success'))
                        <div class="alert alert-success small mt-3 mb-0" role="alert">
                            {{ session('success') }}
                        </div>
						@endif

						@if(session('error'))
                        <div class="alert alert-danger small mt-3 mb-0" role="alert">
                            {{ session('error') }}
                        </div>
                        @endif
					</form>
				</div>

				<p class="mt-4 mt-xl-auto mb-3 mb-xl-0">{{ trans('auth.login.not.account') }} <a href="{{ route('usertype') }}" class="fw-medium">{{ trans('auth.login.create.account') }}</a></p>

			</div>
        </div>
    </section>

@endsection

@push('scriptBottom')
<script>
    window.AUTH_FORGOT_CONFIG = {
        labels: {
            processing: "{{ trans('auth.text.btn.process') }}"
        }
    };
</script>
<script src="{{ asset('js/auth/forgot.js') }}"></script>
@endpush
