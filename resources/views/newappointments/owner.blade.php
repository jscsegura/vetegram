@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@include('elements.ownermenu')

<section class="container-fluid pb-0 pb-lg-4 px-xl-5">
    <div class="row px-2 px-lg-3 mt-2 mt-lg-4">
        <div class="col">

            <h2 class="h4 text-uppercase text-center text-md-start fw-normal mb-2 mb-lg-3">{{ trans('dash.title.next') }} <span class="text-info fw-bold">{{ trans('dash.title.appointment') }}</span></h2>
            <div class="card rounded-3 border-2 border-secondary px-3 px-md-4 py-1 mb-3 mb-lg-5">
                <div class="card-body p-0">

                    @if(count($appointments) > 0)
                        @foreach ($appointments as $appointment)
                            @php
                                $photo = (isset($appointment['getDoctor']['photo'])) ? $appointment['getDoctor']['photo'] : asset('img/default2.png');
                            @endphp
                            <div class="petLine v3 d-grid d-md-flex justify-content-md-between gap-2 gap-md-3 py-3 py-md-4 align-items-center">
                                <div class="d-grid d-md-flex gap-2 gap-md-3 align-items-center">
                                    <div class="petPhoto rounded-circle m-auto m-md-0" style="background-image: url({{ $photo }});"></div>
                                    <div>
                                        <p class="m-0 lh-sm text-center text-md-start"><span class="text-uppercase fw-semibold">{{ (isset($appointment['getDoctor']['name'])) ? $appointment['getDoctor']['name'] : '' }}</span></p>
                                        <p class="small text-center text-md-start">{{ trans('dash.rol.name.4') }}</p>
                                    </div>
                                </div>
                                <div class="m-auto m-md-0">
                                    <p class="d-inline-block">
                                        @if($appointment->status == 1)
                                            <span class="badge statusW rounded-pill text-bg-primary">{{ trans('dash.label.progress') }}</span>
                                        @elseif($appointment->status == 2)
                                            <span class="badge statusW rounded-pill text-bg-success">{{ trans('dash.label.finish') }}</span>
                                        @elseif ($appointment->status == 3)
                                            <span class="badge statusW rounded-pill text-bg-danger">{{ trans('dash.label.cancel') }}</span>
                                        @else
                                            <span class="badge statusW rounded-pill text-bg-warning">{{ trans('dash.label.pending') }}</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="m-auto m-md-0">
                                    <p>{{ trans('dash.label.appoinment.to') }} <span class="fw-medium">{{ (isset($appointment['getPet']['name'])) ? $appointment['getPet']['name'] : '' }}</span></p>
                                </div>
                                <div class="text-center text-md-end">
                                    <p class="d-inline-block align-middle lh-sm"><span class="fw-medium">{{ date('d', strtotime($appointment->date)) . ' de ' . strtolower(trans('dash.month.num' . (int)date('m', strtotime($appointment->date)))) }}</span> <br><small>{{ date('h:i a', strtotime($appointment->hour)) }}</small></p>
                                    
                                    <div class="dropdown d-inline-block">
                                        <a class="btn btn-link btn-sm smIcon dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"></a>
                                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow rounded-3">
                                            <li><a class="dropdown-item small" href="{{ route('appointment.view', App\Models\User::encryptor('encrypt', $appointment->id)) }}">{{ trans('dash.label.btn.see') }}</a></li>
                                            @if(in_array($appointment->status, [0,1]))
                                            <li><a class="dropdown-item small" href="javascript:void(0);" data-action="Appointments.setIdAppointmentToOnlyCancel" data-action-event="click" data-action-args="{{ $appointment->id }}|{{ $appointment->id_user }}">{{ trans('dash.label.btn.cancel') }}</a></li>
                                            <li><a class="dropdown-item small" href="javascript:void(0);" data-action="Appointments.setIdAppointmentToOnlyReschedule" data-action-event="click" data-action-args="{{ $appointment->id }}|{{ $appointment->id_user }}" data-bs-toggle="modal" data-bs-target="#onlyRescheduleModal">{{ trans('dash.label.btn.reschedule') }}</a></li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="petLine d-grid d-sm-flex gap-2 gap-sm-3 py-3 py-sm-4 align-items-center">
                            <div class="d-grid d-sm-flex gap-2 gap-sm-3 align-items-center flex-grow-1">
                                <div>
                                    <p class="small text-center text-sm-start">{{ trans('dash.label.dash.not.appoinment') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>

            <h2 class="h4 text-uppercase text-center text-md-start fw-normal mb-2 mb-lg-3">{{ trans('dash.title.appointment') }} <span class="text-info fw-bold">{{ trans('dash.label.dash.previous') }}</span></h2>
            <div class="card rounded-3 border-2 border-secondary px-3 px-md-4 py-1 mb-3 mb-lg-5">
                <div class="card-body p-0">

                    @if(count($previous) > 0)
                        @foreach ($previous as $appointment)
                            @php
                                $photo = (isset($appointment['getDoctor']['photo'])) ? $appointment['getDoctor']['photo'] : asset('img/default2.png');
                            @endphp
                            <div class="petLine v3 d-grid d-md-flex justify-content-md-between gap-2 gap-md-3 py-3 py-md-4 align-items-center">
                                <div class="d-grid d-md-flex gap-2 gap-md-3 align-items-center">
                                    <div class="petPhoto rounded-circle m-auto m-md-0" style="background-image: url({{ $photo }});"></div>
                                    <div>
                                        <p class="m-0 lh-sm text-center text-md-start"><span class="text-uppercase fw-semibold">{{ (isset($appointment['getDoctor']['name'])) ? $appointment['getDoctor']['name'] : '' }}</span></p>
                                        <p class="small text-center text-md-start">{{ trans('dash.rol.name.4') }}</p>
                                    </div>
                                </div>
                                <div class="m-auto m-md-0">
                                    <p class="d-inline-block">
                                        @if($appointment->status == 1)
                                            <span class="badge statusW rounded-pill text-bg-primary">{{ trans('dash.label.progress') }}</span>
                                        @elseif($appointment->status == 2)
                                            <span class="badge statusW rounded-pill text-bg-success">{{ trans('dash.label.finish') }}</span>
                                        @elseif ($appointment->status == 3)
                                            <span class="badge statusW rounded-pill text-bg-danger">{{ trans('dash.label.cancel') }}</span>
                                        @else
                                            <span class="badge statusW rounded-pill text-bg-warning">{{ trans('dash.label.ausent') }}</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="m-auto m-md-0">
                                    <p>{{ trans('dash.label.appoinment.to') }} <span class="fw-medium">{{ (isset($appointment['getPet']['name'])) ? $appointment['getPet']['name'] : '' }}</span></p>
                                </div>
                                <div class="d-flex flex-column flex-md-row gap-3 justify-content-center justify-content-md-end">
                                    <p class="lh-sm text-center text-md-end"><span class="fw-medium">{{ date('d', strtotime($appointment->date)) . ' de ' . strtolower(trans('dash.month.num' . (int)date('m', strtotime($appointment->date)))) }}</span> <br><small>{{ date('h:i a', strtotime($appointment->hour)) }}</small></p>

                                    <div class="text-center text-md-end">
                                        <a class="apIcon last d-md-inline-block m-0 p-0" href="{{ route('appointment.view', App\Models\User::encryptor('encrypt', $appointment->id)) }}">
                                            <i class="fa-regular fa-eye"></i>
                                            <span class="small d-none d-lg-inline-block">Ver</span>
                                        </a>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="petLine d-grid d-sm-flex gap-2 gap-sm-3 py-3 py-sm-4 align-items-center">
                            <div class="d-grid d-sm-flex gap-2 gap-sm-3 align-items-center flex-grow-1">
                                <div>
                                    <p class="small text-center text-sm-start">{{ trans('dash.label.dash.not.appoinment') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</section>

@include('elements.footer')
@include('elements.appointmodals', ['ModalOnlycancel' => true, 'ModalOnlyReschedule' => true])

@endsection

@push('scriptBottom')
<script src="{{ asset('js/front/datedropper.js') }}"></script>

<link rel="stylesheet" href="{{ asset('css/wpanel/library/jquery.toast.css') }}">
<script src="{{ asset('js/wpanel/library/jquery.toast.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush