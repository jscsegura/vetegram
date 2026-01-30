@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@include('elements.docmenu')

<section class="container-fluid pb-0 pb-lg-4">

    <div class="row px-2 px-lg-3 mt-2 mt-lg-4">
        <h1 class="h4 text-uppercase text-center text-md-start fw-normal mb-3"><a href="{{ route('schedule.extra.index') }}" class="btn btn-sm smIcon"><i class="fa-solid fa-arrow-left-long"></i></a>Configurar <span class="text-info fw-bold"> Disponibilidad Extra</span></h1>
        <form name="frmAddAppointment" id="frmAddAppointment" action="{{ route('schedule.extra.update') }}" method="post" enctype="multipart/form-data" class="col-lg-10 col-xl-8 col-xxl-6 mx-auto mt-4 mt-lg-0 mb-lg-5">
            @csrf
            <input type="hidden" name="hideId" id="hideId" value="{{ App\Models\User::encryptor('encrypt', $slot->id) }}">

            <div class="container mt-4 mx-auto" style="max-width: 600px;">

                <div class="container mt-4 mx-auto" style="max-width: 600px;">
                    <div class="border p-3 rounded-2 bg-light">

                        <div class="mb-4">
                            <h5 class="fw-bold text-primary mb-2">Disponibilidad extra</h5>
                            <p class="text-muted small mb-3">
                                Crea un horario extra para ajustarlo a tu disponibilidad.
                            </p>

                        </div>
                        <div class="d-flex flex-column flex-md-row align-items-md-center gap-3 mb-3 py-3">
                            <div class="flex-grow-1">
                                <label for="dateMode" class="form-label small fw-semibold">Describa la actividad que desea programar</label>
                                <input type="text" id="activityDescription" name="activityDescription" class="form-control text-center" placeholder="Descripción de la actividad" value="{{ old('activityDescription', $slot->description) }}" required>
                                <div id="activityDescriptionFeedback" class="invalid-feedback">Por favor, ingrese una descripción de la actividad.</div>
                            </div>
                        </div>
                        <div style="display:none;">
                            <div class="flex-grow-1">
                                <label for="dateMode" class="form-label small fw-semibold">Modo de selección de fecha</label>
                                <select id="dateMode" name="dateMode" class="form-select text-center">
                                    <option value="single" selected>Seleccionar una fecha</option>
                                    <option value="multiple">Seleccionar múltiples fechas</option>
                                    <option value="range">Seleccionar un rango de fechas</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex flex-column justify-content-center align-items-center py-4 mb-3">
                            <p id="dateInstruction" class="text-center small mt-2 text-primary">Elige un solo día en el que quieras agregar tu disponibilidad.</p>
                            <input type="text" id="datePicker" name="datePicker" class="form-control text-center" placeholder="Selecciona una fecha" data-date="{{ old('datePicker', $slot->date) }}">
                        </div>


                        <div class="d-flex align-items-start flex-column">
                            <div class="border rounded-3 p-2 px-3 mb-2">
                                <div class="d-flex align-items-start gap-3 flex-wrap w-100 mb-2" id="header">
                                    <label for="first-segment" class="form-label small fw-semibold py-2"> Indique el período de tiempo destinado a la actividad</label>
                                    <div id="first-segment" class="flex-grow-1 d-flex flex-column gap-1">

                                        <div style="padding-right: 1rem; margin-top: 0 !important; padding-top: 0 !important;" class="d-flex align-items-center gap-2 flex-wrap border p-2 rounded-2 bg-light"
                                            data-component="interval" size="6">


                                            <div class="flex-grow-1">
                                                <select class="form-select select2 form-select-m bg-white text-center"
                                                    name="schedule[0][from]">
                                                    @for ($h = 0; $h < 24; $h++)
                                                        @for ($m=0; $m < 60; $m +=15)
                                                        @php
                                                        $time=sprintf('%02d:%02d', $h, $m);
                                                        $timeCompare=$time.':00';
                                                        @endphp
                                                        <option value="{{ $time }}" {{ $timeCompare == $slot->start_time ? 'selected' : '' }}>{{ $time }}</option>
                                                        @endfor
                                                        @endfor
                                                </select>
                                            </div>
                                            <span class="text-muted">-</span>
                                            <div class="flex-grow-1">
                                                <select class="form-select select2 form-select-m bg-white text-center"
                                                    name="schedule[0][to]">
                                                    @for ($h = 0; $h < 24; $h++)
                                                        @for ($m=0; $m < 60; $m +=15)
                                                        @php
                                                        $time=sprintf('%02d:%02d', $h, $m);
                                                        $timeCompare=$time.':00';
                                                        @endphp
                                                        <option value="{{ $time }}" {{ $timeCompare == $slot->end_time ? 'selected' : '' }}>{{ $time }}</option>
                                                        @endfor
                                                        @endfor
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div id="segments" class="flex-grow-1 d-flex flex-column gap-1"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end me-3">
                    <div class="d-flex flex-column flex-md-row gap-2 gap-md-4">
                        <div class="d-none d-md-block">
                            <i class="fa-solid fa-angle-right fa-fw fs-5 mt-1 text-white"></i>
                        </div>
                        <div class="d-flex flex-column flex-sm-row gap-2">
                            <button type="submit" class="btn btn-primary px-4" id="btnSave">
                                Guardar <i class="fa-solid fa-angle-right fa-fw fs-5 mt-1 text-white"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>


</section>
@endsection

@push('scriptBottom')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('js/front/datedropper.js') }}"></script>

<link rel="stylesheet" href="{{ asset('css/wpanel/library/jquery.toast.css') }}">
<script src="{{ asset('js/wpanel/library/jquery.toast.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
<style>
    /* Centrar solo el valor mostrado en el select */
    .select2-container--bootstrap-5 .select2-selection__rendered {
        text-align: center !important;
    }

    /* Mantener las opciones del dropdown alineadas a la izquierda */
    .select2-results__option {
        text-align: left !important;
    }
</style>
<style>
    /* Oculta completamente el input */
    #datePicker {
        display: none !important;
    }

    /* Opcional: elimina margen si quieres que el calendario quede pegado */
    .mb-3 {
        margin-bottom: 0 !important;
    }
</style>
<script>
    window.SCHEDULE_EXTRA_FORM_CONFIG = {
        locale: @json(app()->getLocale()),
        texts: {
            instructionSingle: @json(trans('dash.schedule.extra.section3.instruction1')),
            instructionRange: @json(trans('dash.schedule.extra.section3.instruction2')),
            instructionMultiple: @json(trans('dash.schedule.extra.section3.instruction3')),
            placeholderSingle: @json(trans('dash.schedule.extra.section3.placeholder1')),
            placeholderRange: @json(trans('dash.schedule.extra.section3.placeholder2')),
            placeholderMultiple: @json(trans('dash.schedule.extra.section3.placeholder3')),
            overlapBoth: @json('Revisa los horarios: algunos se solapan y otros tienen inicio mayor que el fin.'),
            overlapInvalid: @json('Este segmento tiene un horario de inicio mayor que el de fin.'),
            overlapOnly: @json('Algunos horarios se están solapando, revisa los segmentos.'),
            overlapTitle: @json('Error'),
            overlapAlert: @json('Hay horarios que se cruzan. Por favor corrígelos antes de continuar.'),
            overlapConfirm: @json('Aceptar')
        }
    };
</script>
<script src="{{ asset('js/schedule/extra-form.js') }}"></script>
<style>
    /* Estilo para segmentos con solapamientos */
    .overlap {
        border-color: #dc3545 !important;
        position: relative;
        margin-top: 25px !important;
    }

    .overlap-message {
        position: absolute;
        bottom: 100%;
        left: 0;
        margin-top: 0.25rem;
        background-color: #f8d7da;
        color: #842029;
        padding: 0.3rem 0.6rem;
        font-size: 0.875rem;
        border: 1px solid #f5c2c7;
        border-radius: 0.25rem;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        white-space: nowrap;
        z-index: 10;
    }
</style>
@endpush
