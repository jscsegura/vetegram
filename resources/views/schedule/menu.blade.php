@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@include('elements.docmenu')

<section class="container-fluid pb-0 pb-lg-4">
    <div class="row px-2 px-lg-3 mt-2 mt-lg-4 mb-3 mb-lg-5">

        <div class="col-lg-10 col-xl-9 col-xxl-8 mx-auto mt-2">
            <h1 class="h4 text-uppercase text-center text-md-start fw-normal mb-2 mb-md-3">{{ trans('dash.schedule.menu.title') }}</h1>
            <div class="row g-3">
                <div class="col-md-6">
                    <a href="{{ route('schedule.schedule') }}" class="btn btn-primary p-4 d-block">
                        <span class="adminIcon"><i class="fa-solid fa-calendar-days"></i></span>
                        <span class="text-uppercase fw-semibold">{{ trans('dash.schedule.menu.schedule') }}</span>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('schedule.configuration') }}" class="btn btn-primary p-4 d-block">
                        <span class="adminIcon"><i class="fa-solid fa-gears"></i></span>
                        <span class="text-uppercase fw-semibold">{{ trans('dash.schedule.menu.configuration') }}</span>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('schedule.extra.index') }}" class="btn btn-primary p-4 d-block">
                        <span class="adminIcon"><i class="fa-solid fa-calendar-plus"></i></span>
                        <span class="text-uppercase fw-semibold">{{ trans('dash.schedule.menu.extra') }}</span>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('schedule.exception.index') }}" class="btn btn-primary p-4 d-block">
                        <span class="adminIcon"><i class="fa-solid fa-calendar-minus"></i></span>
                        <span class="text-uppercase fw-semibold">{{ trans('dash.schedule.menu.exception') }}</span>
                    </a>
                </div>

            </div>
        </div>

    </div>
</section>

@include('elements.footer')

@endsection

@push('scriptBottom')
@endpush