@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

    @include('elements.ownermenu')

    <section class="container-fluid pb-0 pb-lg-5">

        <div class="row px-2 px-lg-3 mt-2 mt-lg-4 mx-auto col-lg-7 col-xl-6 col-xxl-5">
            <div class="alert alert-light p-4 p-lg-5 mb-0" role="alert">
                <div class="d-flex flex-column flex-lg-row gap-2 gap-lg-3 align-items-center justify-content-center mb-3 text-center">
                    <i class="fa-regular fa-circle-check text-success h1 mb-0"></i>
                    <p class="mb-0 fs-4 lh-sm text-uppercase">¡{{ trans('dash.label.confirm.appointment.is') }} <span class="text-success-emphasis">{{ trans('dash.label.confirm.appointment.confirm') }}!</span></p>
                </div>
                <p class="fw-normal text-center">{{ trans('dash.label.confirm.appointment.day') }} <span class="fw-medium text-decoration-underline">{{ date('d', strtotime($appointment->date)) . ' ' . strtolower(trans('dash.month.num' . (int)date('m', strtotime($appointment->date)))) . ' ' . trans('dash.label.of') . ' ' . date('Y', strtotime($appointment->date)) }}</span> {{ trans('dash.label.confirm.appointment.at') }} <span class="fw-medium text-decoration-underline">{{ date('h:i a', strtotime($appointment->hour)) }}</span> {{ trans('dash.label.confirm.appointment.doctor') }} <strong>{{ (isset($appointment['getDoctor']['name'])) ? $appointment['getDoctor']['name'] : '' }}</strong></p>
            </div>
            <div><a href="{{ route('dash') }}" class="btn btn-primary btn-sm d-table text-uppercase flex-grow-1 px-4 mt-3 mx-auto">{{ trans('dash.label.element.back') }}</a></div>
        </div>

    </section>

    @include('elements.footer')
      
@endsection

@push('scriptBottom')
    <link rel="stylesheet" href="{{ asset('css/wpanel/library/jquery.toast.css') }}">
    <script src="{{ asset('js/wpanel/library/jquery.toast.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
