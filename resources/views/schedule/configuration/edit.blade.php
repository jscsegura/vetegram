@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@include('elements.docmenu')

<section class="container-fluid pb-0 pb-lg-4">
    <div class="row px-2 px-lg-3 mt-2 mt-lg-4">
        <h1 class="h4 text-uppercase text-center text-md-start fw-normal mb-3"><a href="{{ route('schedule.menu') }}" class="btn btn-sm smIcon"><i class="fa-solid fa-arrow-left-long"></i></a>{{ trans('dashadmin.label.title.add') }} <span class="text-info fw-bold">{{ trans('dash.schedule.configuration.title') }}</span></h1>
        <form class="col-xl-7 mx-auto mt-4 mt-lg-0 mb-lg-5" id="frmMedicine" name="frmMedicine" method="post" action="{{ route('schedule.configuration.update') }}" onsubmit="return validSend();">
            @csrf

        


            <div class="container-fluid">

                <!-- Anticipación -->
                <div class="card mb-4">
                    <div class="card-header fw-semibold small">
                        {{ trans('dash.schedule.configuration.section1') }}
                    </div>
                    <div class="card-body">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label small fw-semibold" for="min_time_value">
                                    {{ trans('dash.schedule.configuration.section1.min.title') }}
                                    <i class="fa fa-info-circle ms-1 text-muted"
                                        data-bs-toggle="tooltip"
                                        data-bs-trigger="hover focus"
                                        title="{{ trans('dash.schedule.configuration.section1.min.description') }}"></i>
                                </label>

                                <div class="input-group">
                                    <input type="number"
                                        class="form-control fc requerido"
                                        id="min_time_value"
                                        name="min_time_from_today"
                                        min="1"
                                        data-bs-toggle="tooltip"
                                        data-bs-trigger="focus"
                                        title="{{ trans('dash.schedule.configuration.section1.min.description') }}"
                                        value="{{ old('min_time_from_today', $configuration->min_time_from_today) }}">

                                    <select class="form-select fc requerido"
                                        id="min_time_unit"
                                        name="min_time_unit" style="max-width: 120px;">
                                        <option value="days">{{ trans('dash.schedule.configuration.elements.days') }}</option>
                                        <option value="hours">{{ trans('dash.schedule.configuration.elements.hours') }}</option>
                                        <option value="minutes" selected>{{ trans('dash.schedule.configuration.elements.minutes') }}</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <label class="form-label small fw-semibold" for="max_time_value">
                                    {{ trans('dash.schedule.configuration.section1.max.title') }}
                                    <i class="fa fa-info-circle ms-1 text-muted"
                                        data-bs-toggle="tooltip"
                                        data-bs-trigger="hover focus"
                                        title="{{ trans('dash.schedule.configuration.section1.max.description') }}"></i>
                                </label>

                                <div class="input-group">
                                    <input type="number"
                                        class="form-control fc requerido"
                                        id="max_time_value"
                                        name="max_time_from_today"
                                        min="1"
                                        data-bs-toggle="tooltip"
                                        data-bs-trigger="focus"
                                        title="{{ trans('dash.schedule.configuration.section1.max.description') }}"
                                        value="{{ old('max_time_from_today', $configuration->max_time_from_today) }}">

                                    <select class="form-select fc requerido"
                                        id="max_time_unit"
                                        name="max_time_unit"
                                        style="max-width: 120px;">
                                        <option value="days">{{ trans('dash.schedule.configuration.elements.days') }}</option>
                                        <option value="hours">{{ trans('dash.schedule.configuration.elements.hours') }}</option>
                                        <option value="minutes" selected>{{ trans('dash.schedule.configuration.elements.minutes') }}</option>
                                    </select>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

                <!-- Duración -->
                <div class="card mb-4">
                    <div class="card-header fw-semibold small">
                        {{ trans('dash.schedule.configuration.section2') }}
                    </div>
                    <div class="card-body">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label small fw-semibold" for="time_before_appointment">
                                    {{ trans('dash.schedule.configuration.section2.prev.title') }}
                                    <i class="fa fa-info-circle ms-1 text-muted"
                                        data-bs-toggle="tooltip"
                                        data-bs-trigger="hover focus"
                                        title="{{ trans('dash.schedule.configuration.section2.prev.description') }}"></i>
                                </label>
                                <input type="number"
                                    class="form-control fc requerido"
                                    id="time_before_appointment"
                                    name="time_before_appointment"
                                    data-bs-toggle="tooltip"
                                    data-bs-trigger="focus"
                                    title="{{ trans('dash.schedule.configuration.section2.prev.description') }}"
                                    value="{{ old('time_before_appointment', $configuration->time_before_appointment) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-semibold" for="time_after_appointment">
                                    {{ trans('dash.schedule.configuration.section2.post.title') }}
                                    <i class="fa fa-info-circle ms-1 text-muted"
                                        data-bs-toggle="tooltip"
                                        data-bs-trigger="hover focus"
                                        title="{{ trans('dash.schedule.configuration.section2.post.description') }}"></i>
                                </label>
                                <input type="number"
                                    class="form-control fc requerido"
                                    id="time_after_appointment"
                                    name="time_after_appointment"
                                    data-bs-toggle="tooltip"
                                    data-bs-trigger="focus"
                                    title="{{ trans('dash.schedule.configuration.section2.post.description') }}"
                                    value="{{ old('time_after_appointment', $configuration->time_after_appointment) }}">
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Límites -->
                <div class="card mb-4">
                    <div class="card-header fw-semibold small">
                        {{ trans('dash.schedule.configuration.section3') }}
                    </div>
                    <div class="card-body">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label small fw-semibold" for="procedure_break_time">
                                    {{ trans('dash.schedule.configuration.section3.break.title') }}
                                    <i class="fa fa-info-circle ms-1 text-muted"
                                        data-bs-toggle="tooltip"
                                        data-bs-trigger="hover focus"
                                        title="{{ trans('dash.schedule.configuration.section3.break.description') }}"></i>
                                </label>
                                <input type="number"
                                    class="form-control fc requerido"
                                    id="procedure_break_time"
                                    name="procedure_break_time"
                                    data-bs-toggle="tooltip"
                                    data-bs-trigger="focus"
                                    title="{{ trans('dash.schedule.configuration.section3.break.description') }}"
                                    value="{{ old('procedure_break_time', $configuration->procedure_break_time) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-semibold" for="daily_appointment_limit">
                                    {{ trans('dash.schedule.configuration.section3.daily.title') }}
                                    <i class="fa fa-info-circle ms-1 text-muted"
                                        data-bs-toggle="tooltip"
                                        data-bs-trigger="hover focus"
                                        title="{{ trans('dash.schedule.configuration.section3.daily.description') }}"></i>
                                </label>
                                <input type="number"
                                    class="form-control fc requerido"
                                    id="daily_appointment_limit"
                                    name="daily_appointment_limit"
                                    data-bs-toggle="tooltip"
                                    data-bs-trigger="focus"
                                    title="{{ trans('dash.schedule.configuration.section3.daily.description') }}"
                                    value="{{ old('daily_appointment_limit', $configuration->daily_appointment_limit) }}">
                            </div>

                        </div>
                    </div>
                </div>

            </div>



            <button type="submit" class="btn btn-primary px-5">{{ trans('dashadmin.label.inventory.save') }}</button>
        </form>

    </div>
</section>

@include('elements.footer')



@endsection

@push('scriptBottom')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltips.forEach(el => new bootstrap.Tooltip(el));
    });
</script>

@endpush