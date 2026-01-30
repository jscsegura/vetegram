@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@include('elements.ownermenu')

<section class="container-fluid pb-0 pb-lg-4 px-xl-5">
    <div class="row px-2 px-lg-3">
        <div class="col-lg-9">
            <div id="pawsBg" class="card text-bg-primary mb-5 rounded-4">
                <div class="card-body p-3 p-sm-4 p-lg-5 pb-5 pb-sm-5">
                    <h1 class="h3 card-title text-uppercase text-white">{{ trans('dash.label.dash.welcome') }} <span class="text-dark">{{ $name }}</span></h1>
                    @if($remaining > 0)
                    <p class="card-text">¡{{ trans('dash.label.dash.haves') }} <span class="text-dark fw-medium">{{ $remaining }} {{ trans('dash.label.dash.appoinment.today') }}!</span><br>{{ trans('dash.label.dash.remember.prev') }}</p>
                    @else
                        <p class="card-text">¡{{ trans('dash.label.dash.not.haves.owner') }}! <br>{{ trans('dash.label.dash.remember.prev') }}</p>
                    @endif
                    <div class="petsBanner">
                        <img src="{{ asset('img/pets.png') }}" alt="Imagen de mascotas">
                    </div>
                </div>
            </div>

            <h2 class="h4 text-uppercase text-center text-md-start fw-normal mb-2 mb-lg-3">{{ trans('dash.title.next') }} <span class="text-info fw-bold">{{ trans('dash.title.appointment') }}</span></h2>
            <div class="card rounded-3 border-2 border-secondary px-3 px-md-4 py-1 mb-3 mb-lg-5">
                <div class="card-body p-0">

                    @if(count($appointments) > 0)
                        @foreach ($appointments as $appointment)
                            @php
                                $photo = (isset($appointment['getDoctor']['photo'])) ? $appointment['getDoctor']['photo'] : asset('img/default2.png');
                            @endphp
                            <div class="petLine d-grid d-md-flex justify-content-md-between gap-2 gap-md-3 py-3 py-md-4 align-items-center">
                                <div class="d-grid d-md-flex gap-2 gap-md-3 align-items-center">
                                    <div>
                                        <div class="petPhoto rounded-circle m-auto m-md-0" style="background-image: url({{ $photo }});"></div>
                                    </div>
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
                                <div class="d-table mx-auto">
                                    {{-- <p class="small text-center text-sm-start">{{ trans('dash.label.dash.not.appoinment') }}</p> --}}
                                    <a href="{{ route('search.index') }}" class="btn btn-secondary btn-sm text-uppercase px-4">{{ trans('dash.add.appointment') }}</a>
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
                            <div class="petLine d-grid d-md-flex justify-content-md-between gap-2 gap-md-3 py-3 py-md-4 align-items-center">
                                <div class="d-grid d-md-flex gap-2 gap-md-3 align-items-center">
                                    <div>
                                        <div class="petPhoto rounded-circle m-auto m-md-0" style="background-image: url({{ $photo }});"></div>
                                    </div>
                                    <div>
                                        <p class="m-0 lh-sm text-center text-md-start"><span class="text-uppercase fw-semibold">{{ (isset($appointment['getDoctor']['name'])) ? $appointment['getDoctor']['name'] : '' }}</span></p>
                                        <p class="small text-center text-md-start">{{ trans('dash.rol.name.4') }}</p>
                                    </div>
                                </div>
                                <div class="m-auto m-md-0">
                                    <p class="d-inline-block">
                                        @if($appointment->status == 1)
                                            <span class="statusW badge rounded-pill w-100 text-bg-primary">{{ trans('dash.label.progress') }}</span>
                                        @elseif($appointment->status == 2)
                                            <span class="statusW badge rounded-pill w-100 text-bg-success">{{ trans('dash.label.finish') }}</span>
                                        @elseif ($appointment->status == 3)
                                            <span class="statusW badge rounded-pill w-100 text-bg-danger">{{ trans('dash.label.cancel') }}</span>
                                        @else
                                            <span class="statusW badge rounded-pill w-100 text-bg-warning">{{ trans('dash.label.pending') }}</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="m-auto m-md-0">
                                    <p>{{ trans('dash.label.appoinment.to') }} <span class="fw-medium">{{ (isset($appointment['getPet']['name'])) ? $appointment['getPet']['name'] : '' }}</span></p>
                                </div>
                                <div class="d-flex flex-column flex-md-row gap-3 justify-content-center justify-content-md-end align-items-center">
                                    <p class="lh-sm text-center text-md-end"><span class="fw-medium">{{ date('d', strtotime($appointment->date)) . ' ' . trans('dash.label.of') . ' ' . strtolower(trans('dash.month.num' . (int)date('m', strtotime($appointment->date)))) }}</span> <br><small>{{ date('h:i a', strtotime($appointment->hour)) }}</small></p>
                                    
                                    <div class="text-center text-md-end">
                                        <a class="apIcon last align-items-center gap-1 d-md-flex m-0 p-0" href="{{ route('appointment.view', App\Models\User::encryptor('encrypt', $appointment->id)) }}">
                                            <i class="fa-regular fa-eye"></i>
                                            <span class="small d-none d-lg-block">{{ trans('dash.label.btn.see') }}</span>
                                        </a>
                                    </div>
                                    {{-- <div class="dropdown d-inline-block">
                                        <a class="btn btn-link btn-sm smIcon dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"></a>
                                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow rounded-3">
                                            <li><a class="dropdown-item small" href="{{ route('appointment.view', App\Models\User::encryptor('encrypt', $appointment->id)) }}">{{ trans('dash.label.btn.see') }}</a></li>
                                        </ul>
                                    </div> --}}
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
        <div class="col-lg-3">
            <div class="docCol card rounded-3 border-2 border-secondary">
                <div class="card-body p-3 p-lg-4">
                    <h3 class="h4 text-uppercase text-center text-md-start fw-normal mb-3">{{ trans('dash.label.dash.your') }} <span class="text-info fw-bold">{{ trans('dash.label.dash.pets') }}</span></h3>
                    <div class="border-bottom border-2 border-secondary pb-2">
                        @foreach ($pets as $pet)
                            @php
                                $photo = asset('img/default.png');
                                if((isset($pet->photo)) && ($pet->photo != '')) {
                                    $photo = asset('files/' . $pet->photo);
                                }
                            @endphp
                            <div class="d-grid d-sm-flex gap-2 gap-sm-3 my-3">
                                <a href="{{ route('pet.detail', App\Models\User::encryptor('encrypt', $pet->id)) }}">
                                    <div class="docPhoto2 rounded-circle m-auto m-sm-0" style="background-image: url({{ $photo }});"></div>
                                </a>
                                <div class="d-grid align-content-center">
                                    <a href="{{ route('pet.detail', App\Models\User::encryptor('encrypt', $pet->id)) }}" class="link-secondary m-0 text-center text-sm-start text-decoration-none">
                                        <span class="fs-6 text-uppercase fw-medium">{{ $pet->name }}</span>
                                        <small class="d-block">{{ trans('dash.label.btn.see.detail') }}<i class="fa-solid fa-arrow-right-long ms-2"></i></small>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <h6 class="text-uppercase text-center text-sm-start mt-4 mt-sm-5 mb-2 mb-sm-0">{{ trans('dash.label.dash.alerts') }}</h6>
                    <div class="card border-0 bg-transparent">
                        <div class="card-body p-0">

                            @if(count($reminders) > 0)
                                @php
                                    $now = date('Y-m-d H:i:s');
                                @endphp
                                @foreach ($reminders as $reminder)
                                    @php
                                        $photo = asset('img/default2.png');
                                        if((isset($reminder['pet']['photo']))&&($reminder['pet']['photo'] != '')) {
                                            $photo = asset('files/' . $reminder['pet']['photo']);
                                        }

                                        $now = Carbon\Carbon::parse($now);
                                        $date = Carbon\Carbon::parse($reminder->date);
                                        
                                        $hours  = $now->diffInHours($date);
                                        $minute = $now->diffInMinutes($date);
                                    @endphp
                                    <div class="d-grid d-sm-flex gap-1 gap-sm-3 align-items-center py-2 py-sm-3 border-bottom border-2 border-secondary">
                                        <div class="d-grid d-sm-flex gap-2 gap-sm-3 align-items-center flex-grow-1">
                                            <div class="petPhoto rounded-circle m-auto m-sm-0" style="background-image: url({{ $photo }});"></div>
                                            <div>
                                                <p class="m-0 text-uppercase lh-sm text-center text-sm-start"><small class="text-dark fw-bolder">{{ $reminder->description }}</small></p>
                                                <p class="small text-center text-sm-start">{{ (isset($reminder['pet']['name'])) ? $reminder['pet']['name'] : '' }}</p>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-center text-sm-start"><small>{{ ($hours > 0) ? $hours . ' hora(s)' : $minute . ' minutos' }}</small></p>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                            <div class="d-grid d-sm-flex gap-1 gap-sm-3 align-items-center py-2 py-sm-3 border-bottom border-2 border-secondary">
                                <div class="d-grid d-sm-flex gap-2 gap-sm-3 align-items-center flex-grow-1">
                                    <p class="mb-3 lh-sm text-center text-sm-start"><i class="fa-solid fa-triangle-exclamation opacity-50 me-2"></i>{{ trans('dash.label.dash.not.alerts') }}</p>
                                </div>
                            </div>
                            @endif

                        </div>
                    </div>

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