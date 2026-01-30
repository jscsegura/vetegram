@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@include('elements.docmenu')

<section class="container-fluid pb-0 pb-lg-4 px-xl-5">
    <div class="row px-2 px-lg-3 mt-2 mt-lg-4">
        
        <div class="d-grid d-md-flex gap-2 gap-md-3 mb-2 mb-md-3 align-items-center">
            <h1 class="h4 text-uppercase text-center text-md-start fw-normal mb-0">{{ trans('dash.title.next') }} <span class="text-info fw-bold">{{ trans('dash.title.appointment') }}</span></h1>
            <a href="{{ route('appointment.history') }}" class="btn btn-secondary btn-sm text-uppercase px-4">{{ trans('dash.title.see.history') }}</a>
            <div class="col-12 col-md-auto d-flex gap-2 ms-auto">
                <a href="{{ route('appointment.add') }}" class="btn btn-primary btn-sm text-uppercase flex-grow-1 px-4 me-1">{{ trans('dash.add.appointment') }}</a>
                <a href="{{ route('appointment.index') }}" class="btn btn-info btn-sm d-flex active"><i class="fa-solid fa-table-list m-auto"></i></a>
                <a href="{{ route('appointment.schedule') }}" class="btn btn-info btn-sm d-flex"><i class="fa-solid fa-calendar-days m-auto"></i></a>
            </div>
        </div>

        <div class="col-12">
            <div class="row justify-content-end mb-3 mt-3 mt-lg-0">
                <div class="col-md-6 col-xl-8 d-flex gap-2 justify-content-center">
                    <input type="hidden" name="monthCalendar" id="monthCalendar" value="{{ (int)$month }}">
                    <input type="hidden" name="yearCalendar" id="yearCalendar" value="{{ $year }}">
                    <a data-action="Appointments.prevMonth" data-action-event="click" class="circleArrow"><i class="fa-solid fa-angle-left"></i></a>
                    <h2 class="h4 fw-normal px-2 mb-0">{{ trans('dash.month.num' . (int)$month) . ' ' . $year }}</h2>
                    <a data-action="Appointments.nextMonth" data-action-event="click" class="circleArrow"><i class="fa-solid fa-angle-right"></i></a>
                </div>
                <div class="col-md-3 col-xl-2 mt-3 mt-md-0">
                    <select name="useridselect" id="useridselect" class="form-select form-select-sm" aria-label="{{ trans('dash.label.select.doctor') }}" data-action="Appointments.getUser" data-action-event="change">
                        @foreach ($vets as $vet)
                            <option value="{{ $vet->id }}" @if($vet->id == $userid) selected='selected' @endif>{{ ($vet->id == $user->id) ? $vet->name . ' ('. trans('dash.its.me') . ')' : $vet->name }}</option>    
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card rounded-3 border-2 border-secondary px-2 px-lg-3 py-2 py-lg-3 mb-0 mb-lg-5">
                <div class="card-body p-0" id="preload">
                    <table class="table table-striped table-borderless mb-0 small align-middle cTable">
                        <tbody>
                            @if(count($appointments) > 0)
                                @foreach ($appointments as $appointment)
                                    <tr class="position-relative">
                                        <td class="px-2 px-lg-3 py-1 py-lg-4" data-label="{{ trans('dash.label.date') }}:" style="width: 130px;">
                                            <a class="btn btn-sm link-secondary px-0 px-md-1 py-0 py-md-2 text-start" href="{{ route('appointment.view', App\Models\User::encryptor('encrypt', $appointment->id)) }}">
                                                <span class="fw-normal">{{ date('d', strtotime($appointment->date)) . ' ' . strtolower(trans('dash.month.num' . (int)date('m', strtotime($appointment->date)))) }}</span>
                                                <strong><span class="d-inline-block d-md-block ms-3 ms-md-0">{{ date('h:i a', strtotime($appointment->hour)) }}</span></strong>
                                            </a>
                                        </td>
                                        <td class="px-2 px-lg-3 py-1 py-lg-4" data-label="{{ trans('dash.label.pet') }}:">
                                            <a href="{{ route('pet.detail', App\Models\User::encryptor('encrypt', $appointment->id_pet)) }}" class="btn btn-sm link-secondary text-uppercase px-0 px-md-1 py-0 py-md-2"><strong>{{ (isset($appointment['getPet']['name'])) ? $appointment['getPet']['name'] : '' }}</strong></a>
                                        </td>
                                        @if($appointment->status == 1)
                                            <td class="px-2 px-lg-3 py-1 py-lg-4" data-label="{{ trans('dash.label.status') }}:" style="width: 140px;"><span class="badge statusW rounded-pill text-bg-primary">{{ trans('dash.label.progress') }}</span></td>
                                        @elseif($appointment->status == 2)
                                            <td class="px-2 px-lg-3 py-1 py-lg-4" data-label="{{ trans('dash.label.status') }}:" style="width: 140px;"><span class="badge statusW rounded-pill text-bg-success">{{ trans('dash.label.finish') }}</span></td>
                                        @elseif ($appointment->status == 3)
                                            <td class="px-2 px-lg-3 py-1 py-lg-4" data-label="{{ trans('dash.label.status') }}:" style="width: 140px;"><span class="badge statusW rounded-pill text-bg-danger">{{ trans('dash.label.cancel') }}</span></td>
                                        @else
                                            <td class="px-2 px-lg-3 py-1 py-lg-4" data-label="{{ trans('dash.label.status') }}:" style="width: 140px;"><span class="badge statusW rounded-pill text-bg-warning">{{ trans('dash.label.pending') }}</span></td>
                                        @endif
                                        <td class="px-2 px-lg-3 py-1 py-lg-4" data-label="{{ trans('dash.label.owner') }}:"><span class="user-select-none" data-bs-toggle="tooltip" data-bs-html="true" data-bs-offset="0,12" data-bs-title="{{ (isset($appointment['getClient']['phone'])) ? $appointment['getClient']['phone'] : '' }} <br> {{ (isset($appointment['getClient']['email'])) ? $appointment['getClient']['email'] : '' }}">{{ (isset($appointment['getClient']['name'])) ? $appointment['getClient']['name'] : '' }}<span class="d-none d-md-inline-block"></span><i class="fa-solid fa-circle-info opacity-75 ms-2"></i></span></td>
                                        <td class="px-2 px-lg-3 py-1 py-lg-4 text-end" data-label="{{ trans('dash.label.options') }}:">
                                            <div class="d-inline-block align-top">
                                                <button data-action="Appointments.setIdAppointmentToNote" data-action-event="click" data-action-args="{{ $appointment->id }}" class="apIcon d-md-inline-block m-0 p-0" data-bs-toggle="modal" data-bs-target="#noteModal">
                                                    <i class="fa-regular fa-file-lines"></i>
                                                    <span class="d-none d-lg-inline-block">{{ trans('dash.label.notes') }}</span>
                                                </button>
                                                <button data-action="Appointments.setIdAppointmentToAttach" data-action-event="click" data-action-args="{{ $appointment->id }}" class="apIcon d-md-inline-block m-0 p-0" data-bs-toggle="modal" data-bs-target="#attachModal">
                                                    <i class="fa-solid fa-paperclip"></i>
                                                    <span class="d-none d-lg-inline-block">{{ trans('dash.label.attachments') }}</span>
                                                </button>
                                                <button data-action="Appointments.setIdAppointmentToMedicine" data-action-event="click" data-action-args="{{ $appointment->id }}" class="apIcon d-md-inline-block m-0 p-0" data-bs-toggle="modal" data-bs-target="#recipeModal">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                    <span class="d-none d-lg-inline-block">{{ trans('dash.label.recipes') }}</span>
                                                </button>
                                                @if(in_array($appointment->status, [0,1]))
                                                <button class="apIcon d-md-inline-block m-0 p-0" data-action="Appointments.startAppointment" data-action-event="click" data-action-args="{{ route('appointment.start', App\Models\User::encryptor('encrypt', $appointment->id)) }}">
                                                    <i class="fa-regular fa-circle-play"></i>
                                                    <span class="d-none d-lg-inline-block">{{ trans('dash.label.start') }}</span>
                                                </button>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-2 py-lg-4 h-0 text-center" style="width: 35px;">
                                            <a class="btn btn-link btn-sm smIcon optIcons" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </a>
                                            <div class="dropdown d-inline-block">
                                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow rounded-3">
                                                <li><a class="dropdown-item small" href="{{ route('appointment.view', App\Models\User::encryptor('encrypt', $appointment->id)) }}">{{ trans('dash.label.btn.see') }}</a></li>
                                                @if(in_array($appointment->status, [0,1]))
                                                <li><a class="dropdown-item small" href="{{ route('appointment.edit', App\Models\User::encryptor('encrypt', $appointment->id)) }}">{{ trans('dash.label.btn.edit') }}</a></li>
                                                <li><a class="dropdown-item small" href="javascript:void(0);" data-action="Appointments.setIdAppointmentToOnlyCancel" data-action-event="click" data-action-args="{{ $appointment->id }}|{{ $appointment->id_user }}">{{ trans('dash.label.btn.cancel') }}</a></li>
                                                <li><a class="dropdown-item small" href="javascript:void(0);" data-action="Appointments.setIdAppointmentToOnlyReschedule" data-action-event="click" data-action-args="{{ $appointment->id }}|{{ $appointment->id_user }}" data-bs-toggle="modal" data-bs-target="#onlyRescheduleModal">{{ trans('dash.label.btn.reschedule') }}</a></li>
                                                <li><a class="dropdown-item small" data-action="Appointments.setIdAppointmentToReminder" data-action-event="click" data-action-args="{{ $appointment->id }}" data-bs-toggle="modal" data-bs-target="#reminderModal">{{ trans('dash.label.btn.reminder') }}</a></li>
                                                @endif
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="position-relative">
                                    <td class="px-12 px-lg-12 py-12 py-lg-12" style="width: 100%; text-align: center;"><strong>{{ trans('dash.label.no.registers') }}</strong></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

@include('elements.footer')
@include('elements.appointmodals', ['Modalreminder' => true, 'Modalrecipe' => true, 'Modalattach' => true, 'Modalnote' => true, 'ModalOnlycancel' => true, 'ModalOnlyReschedule' => true])

@endsection

@push('scriptBottom')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('js/front/datedropper.js') }}"></script>

<link rel="stylesheet" href="{{ asset('css/wpanel/library/jquery.toast.css') }}">
<script src="{{ asset('js/wpanel/library/jquery.toast.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    window.APPOINTMENTS_INDEX_CONFIG = {
        routes: {
            index: @json(route('appointment.index'))
        },
        texts: {
            startTitle: @json(trans('dash.msg.start.appoinment')),
            startConfirm: @json(trans('dash.msg.confir.start.appoinment')),
            startYes: @json(trans('dash.label.yes.start')),
            startNo: @json(trans('dash.label.not'))
        },
        selectors: {
            monthInput: '#monthCalendar',
            yearInput: '#yearCalendar',
            userSelect: '#useridselect',
            recipeModal: '#recipeModal'
        }
    };
</script>
<script src="{{ asset('js/appointments/index.js') }}"></script>
@endpush
