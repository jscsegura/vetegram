@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

  <section id="logBox" class="container">
      <div class="row h-100">

          @include('elements.loginBanner')

          <div id="logForm" class="col-xl-6 d-flex flex-column px-3 px-xl-5 mt-3 mt-xl-0">

            @include('elements.loginTop')

            <div>
              <h1 class="h3 text-uppercase text-center mt-4 mt-lg-0 mb-3 mb-lg-4">{{ trans('auth.usertype.type') }}</h1>
              <div class="d-grid d-md-flex flex-wrap gap-3">
                  <a href="{{ route('signup', 'vet') }}" class="btn btn-outline-secondary d-block rounded-3 border-2 border-secondary px-3 py-4 py-lg-5 col">
                      <i class="fa-solid fa-user-doctor fs-1 mb-2 text-primary"></i>
                      <p class="fs-5">{{ trans('auth.usertype.veterinary') }}</p>
                  </a>
                  <a href="{{ route('signup', 'owner') }}" class="btn btn-outline-secondary d-block rounded-3 border-2 border-secondary px-3 py-4 py-lg-5 col">
                      <i class="fa-solid fa-dog fs-1 mb-2 text-primary"></i>
                      <p class="fs-5">{{ trans('auth.usertype.animal') }}</p>
                  </a>
              </div>
            </div>

            <p class="mt-4 mt-xl-auto mb-3 mb-xl-0">{{ trans('auth.already.login') }} <a href="{{ route('home.index') }}" class="fw-medium">{{ trans('auth.sign.in') }}</a></p>

          </div>
      </div>
  </section>
@endsection

@push('scriptBottom')
@endpush