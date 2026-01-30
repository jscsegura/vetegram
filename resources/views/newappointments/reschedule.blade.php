@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

    @include('elements.docmenu')

    <section class="container-fluid pb-0 pb-lg-4">
        <div class="row px-2 px-lg-3 mt-2 mt-lg-4 mb-3 mb-lg-5">

            <div class="smallCol mx-auto mt-2">
                <input type="hidden" name="cancelIdAppointment" id="cancelIdAppointment" value="{{ $idEncrypt }}">
                <input type="hidden" name="IdUserAppointmentToCancel" id="IdUserAppointmentToCancel" value="{{ $appointment->id_user }}">

                <h2 class="h4 text-uppercase text-center text-md-start fw-normal mb-3">{{ trans('dash.label.btn.reschedule') }} <span class="text-info fw-bold">{{ trans('dash.label.apointment') }}</span></h2>
                <div class="card rounded-3 border-2 border-secondary p-3 p-md-4 mb-3 mb-lg-5">
                    
                    <div class="col-12" style="display: none;" id="containerSuccess">
                        <div class="alert alert-success text-center mb-2" role="alert">
                            <i class="fa-solid fa-check opacity-50 me-2"></i>{{ trans('dash.label.reschedule.complete') }}
                        </div>
                    </div>
                    
                    @if($appointment->status == 2)
                    <div class="col-12">
                        <div class="alert alert-warning text-center mb-2" role="alert">
                            <i class="fa-solid fa-triangle-exclamation opacity-50 me-2"></i>{{ trans('dash.label.not.reschedule.isfinish') }}
                        </div>
                    </div>
                    @elseif($appointment->status == 3)
                    <div class="col-12">
                        <div class="alert alert-warning text-center mb-2" role="alert">
                            <i class="fa-solid fa-triangle-exclamation opacity-50 me-2"></i>{{ trans('dash.label.not.reschedule.iscancel') }}
                        </div>
                    </div>
                    @else
                    <p class="fs-5 text-center mb-3">{{ trans('dash.label.new.date') }} <span class="text-uppercase fw-medium">{{ (isset($appointment['getPet']['name'])) ? $appointment['getPet']['name'] : '' }}</span></p>
                    <div class="d-flex flex-row gap-3 mb-4">
                        <div class="flex-grow-1">
                            <label for="date" class="form-label small">{{ trans('dash.label.date') }}</label>
                            <input type="text" name="dateModalCancelRe" id="dateModalCancelRe" class="form-control fc dDropper requerido" size="14" readonly="true" data-dd-opt-min-date="{{ date('Y/m/d') }}">
                        </div>
                        <div>
                            <label for="dtime" class="form-label small">{{ trans('dash.label.hour') }}</label>
                            <select id="hourModalCancelRe" name="hourModalCancelRe" class="form-select fc requerido">
                                <option value="">{{ trans('dash.label.selected') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="mx-auto">
                        <button type="submit" class="btn btn-primary px-5" data-action="Appointments.confirmSaveActionReschedule" data-action-event="click">{{ trans('dash.text.btn.save') }}</button>
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </section>

    @include('elements.footer')

@endsection

@push('scriptBottom')
<script src="{{ asset('js/front/datedropper.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/wpanel/library/jquery.toast.css') }}">
<script src="{{ asset('js/wpanel/library/jquery.toast.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    window.APPOINTMENTS_RESCHEDULE_CONFIG = {
        routes: {
            getHours: @json(route('appoinment.getHours')),
            cancelOrReschedule: @json(route('appoinment.cancelOrReschedule'))
        },
        texts: {
            selected: @json(trans('dash.label.selected')),
            notAvailable: @json(trans('dash.label.selected.notavailable')),
            confirmTitle: @json(trans('dash.msg.appoinment.title.reeschedule')),
            confirmText: @json(trans('dash.msg.appoinment.confir.reeschedule')),
            confirmYes: @json(trans('dash.msg.yes.reeschedule')),
            confirmNo: @json(trans('dash.msg.not.return')),
            errorPermit: @json(trans('dash.msg.appoinment.error.permit')),
            errorHour: @json(trans('dash.msg.appoinment.error.hour')),
            errorReschedule: @json(trans('dash.msg.appoinment.error.reeschedule'))
        },
        selectors: {
            userInput: '#IdUserAppointmentToCancel',
            dateInput: '#dateModalCancelRe',
            hourInput: '#hourModalCancelRe',
            appointmentIdInput: '#cancelIdAppointment',
            successContainer: '#containerSuccess'
        }
    };
</script>
<script src="{{ asset('js/appointments/reschedule.js') }}"></script>
@endpush
