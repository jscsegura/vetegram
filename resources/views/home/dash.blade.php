@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@include('elements.docmenu')

@php $weblang = \App::getLocale(); @endphp

<section class="container-fluid pb-0 pb-lg-4 px-xl-5">
    <div class="row px-2 px-lg-3">
        <div class="col-lg-8">
            <div id="pawsBg" class="card text-bg-primary mb-4 mb-sm-5 rounded-4">
                <div class="card-body p-3 p-sm-4 p-lg-5">
                    <h1 class="h3 card-title text-uppercase text-white">¡{{ trans('dash.label.dash.welcome') }} <span class="text-dark">{{ $name }}!</span></h1>
                    @if($remaining > 0)
                        <p class="card-text">¡{{ trans('dash.label.dash.haves') }} <span class="text-dark fw-medium">{{ $remaining }} {{ trans('dash.label.dash.patient') }}</span> {{ trans('dash.label.dash.remaining.today') }}! <br>{{ trans('dash.label.dash.remember.prev.doctor') }}</p>
                    @else
                        <p class="card-text">¡{{ trans('dash.label.dash.not.haves') }}! <br>{{ trans('dash.label.dash.remember.prev.doctor') }}</p>
                    @endif
                </div>
            </div>
            
            @if(count($appointments) > 0)
                <div class="row">
                    <div class="col-md-8">
                        <h2 class="h4 text-uppercase text-center text-md-start fw-normal mb-3">{{ trans('dash.title.appointment') }} <span class="text-info fw-bold">{{ trans('dash.label.dash.today') }}</span></h2>
                    </div>
                    <div class="col-md-4" style="text-align: right;">
                        <a href="{{ route('appointment.add') }}" class="btn btn-secondary btn-sm text-uppercase px-4">{{ trans('dash.add.appointment') }}</a>
                    </div>
                </div>
            @else
                <h2 class="h4 text-uppercase text-center text-md-start fw-normal mb-3">{{ trans('dash.title.appointment') }} <span class="text-info fw-bold">{{ trans('dash.label.dash.today') }}</span></h2>
            @endif

            <div class="card rounded-3 border-2 border-secondary px-3 px-sm-4 py-1 mb-3 mb-lg-5">
                <div class="card-body p-0">
                    @if(count($appointments) > 0)
                        @foreach ($appointments as $appointment)
                            @php
                                $photo = asset('img/default.png');
                                if((isset($appointment['getPet']['photo'])) && ($appointment['getPet']['photo'] != '')) {
                                    $photo = asset('files/' . $appointment['getPet']['photo']);
                                }
                            @endphp
                            <div class="petLine v2 d-grid d-sm-flex gap-2 gap-sm-3 py-3 py-sm-4 align-items-center">
                                <div class="d-grid d-sm-flex gap-2 gap-sm-3 align-items-center flex-grow-1">
                                    <div>
                                        <a href="{{ route('pet.detail', App\Models\User::encryptor('encrypt', $appointment->id_pet)) }}" class="petPhoto rounded-circle m-auto m-sm-0" style="background-image: url({{ $photo }});"></a>
                                    </div>
                                    <div>
                                        <p class="m-0 lh-sm text-center text-sm-start"><a class="link-secondary text-decoration-none text-uppercase fw-semibold" href="{{ route('pet.detail', App\Models\User::encryptor('encrypt', $appointment->id_pet)) }}">{{ (isset($appointment['getPet']['name'])) ? $appointment['getPet']['name'] : '' }}</a> <small>({{ (isset($appointment['getClient']['name'])) ? $appointment['getClient']['name'] : '' }})</small></p>
                                        <p class="small text-center text-sm-start">{{ $appointment->reason }}</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-center">
                                    <p class="me-4">
                                        @if($appointment->status == 3)
                                        <i class="fa-solid fa-circle-xmark me-2 text-danger"></i>
                                        @else
                                        <i class="fa-solid fa-circle-check me-2 text-success"></i>
                                        @endif
                                        {{ date('h:i a', strtotime($appointment->hour)) }}
                                    </p>
                                    <div>
                                        @if(in_array($appointment->status, [0,1]))
                                        <button class="apIcon last d-md-inline-block m-0 p-0" data-action="Home.startAppointment" data-action-event="click" data-action-args="{{ route('appointment.start', App\Models\User::encryptor('encrypt', $appointment->id)) }}">
                                            <i class="fa-regular fa-circle-play"></i>
                                            <span>{{ trans('dash.label.start') }}</span>
                                        </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                    <div class="petLine d-grid d-sm-flex gap-2 gap-sm-3 py-3 py-sm-4 align-items-center">
                        <div class="d-grid d-sm-flex gap-2 gap-sm-3 align-items-center flex-grow-1">
                            <div class="d-table mx-auto">
                                <a href="{{ route('appointment.add') }}" class="btn btn-secondary btn-sm text-uppercase px-4">{{ trans('dash.add.appointment') }}</a>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="docCol card rounded-3 border-2 border-secondary">
                <div class="card-body p-3 p-lg-4">
                    <div class="d-grid d-sm-flex gap-3">
                        @php
                            $photo = asset('img/default2.png');
                            if($user->photo != '') {
                                $photo = asset($user->photo);
                            }
                        @endphp
                        <div class="docPhoto rounded-circle m-auto m-sm-0" style="background-image: url({{ $photo }});"></div>
                        <div class="d-grid align-content-center">
                            <h3 class="h5 text-uppercase m-0 text-center text-sm-start">{{ (in_array($user->rol_id, [3,4,6])) ? 'Dr. ' . $user->name : $user->name }}</h3>
                            <p class="text-center text-sm-start">{{ trans('dash.rol.name.' . $user->rol_id) }}</p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        {{-- <div class="col-6 border-end border-2 border-secondary">
                            <h4 class="h2 m-0">{{ $user->rate }}</h4>
                            <p class="text-uppercase"><small>Overall Rating</small></p>
                        </div> --}}
                        <div class="col">
                            <h4 class="h2 text-center text-sm-start m-0">{{ $patients }}</h4>
                            <p class="text-uppercase text-center text-sm-start"><small>{{ trans('dash.total.patients') }}</small></p>
                        </div>
                    </div>
                    <h6 class="text-uppercase text-center text-sm-start mt-4 mb-2 mb-sm-0">{{ trans('dash.label.dash.alerts') }}</h6>
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
                                            <div class="petPhoto rounded-circle bg-black m-auto m-sm-0" style="background-image: url({{ $photo }});"></div>
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
                    
                    @if($vet->pro == 0)
                    <div id="upgradeBanner" class="mt-5 p-4 rounded-3 position-relative">
                        <span class="d-table fs-5 fw-medium text-white mb-3 w-75 lh-sm">{{ trans('dash.label.pro.need.more.space') }}</span>
                        <a href="{{ route('plan') }}" class="btn btn-secondary bg-white fw-medium border border-2 border-info position-relative z-1">
                            <i class="fa-solid fa-circle-arrow-up me-2"></i>{{ trans('dash.label.pro.more.space') }}
                        </a>
                        <img class="imgDoctor" src="{{ asset('img/upgrade2.png') }}" alt="Upgrade">
                    </div>
                    @endif

                    @if($vet->pro == 1)
                    <div class="mt-4">
                        <h4 class="h4 text-uppercase mb-3">Plan <small class="px-1 opacity-50"><i class="fa-solid fa-arrow-right-long small"></i></small> <span class="text-primary">Vetegram Pro</span></h4>
                        <ul>
                            @foreach ($pros as $pro)
                            <li>{{ $pro['title_' . $weblang] }}</li>    
                            @endforeach
                        </ul>
                        <div class="text-center text-md-start">
                            <a href="mailto:pro@vetegram.com" class="btn btn-primary">{{ trans('dash.label.pro.support') }}: pro@vetegram.com</a>
                        </div>
                    </div>
                    @endif

                </div>
            </div>
            {{-- <h3 class="h5 text-uppercase text-center mt-4 text-md-start">Revenue</h3>
            <div class="docCol card rounded-3 border-2 border-secondary mb-1 mb-lg-5">
                <div class="card-body p-3 p-lg-4">
                    <div class="row">
                        <div class="col-6 border-end border-2 border-secondary">
                            <h4 class="h2 m-0">$3204</h4>
                            <p class="text-uppercase"><small>This Month</small></p>
                        </div>
                        <div class="col-6 ps-4">
                            <h4 class="h2 m-0">$892</h4>
                            <p class="text-uppercase"><small>This Week</small></p>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</section>

@include('elements.footer')
@include('elements.appointmodals', ['Modalreminder' => true, 'Modalcancel' => true])

@endsection

@push('scriptBottom')
<script src="{{ asset('js/front/datedropper.js') }}"></script>

<link rel="stylesheet" href="{{ asset('css/wpanel/library/jquery.toast.css') }}">
<script src="{{ asset('js/wpanel/library/jquery.toast.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    window.HOME_DASH_CONFIG = {
        texts: {
            title: @json(trans('dash.msg.start.appoinment')),
            text: @json(trans('dash.msg.confir.start.appoinment')),
            confirm: @json(trans('dash.label.yes.start')),
            cancel: @json(trans('dash.label.not'))
        }
    };
</script>
<script src="{{ asset('js/home/dash.js') }}"></script>
@endpush
