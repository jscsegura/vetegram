@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@include('elements.docmenu')

<section class="container-fluid pb-0 pb-lg-4 px-xl-5">
    <div class="row px-2 px-lg-3 mt-2 mt-lg-4">
        
        <div class="d-grid d-md-flex gap-2 gap-md-3 mb-2 mb-md-3 align-items-center">
            <h1 class="h4 text-uppercase text-center text-md-start mb-0">{{ trans('dash.title.history') }}</h1>
            <a href="{{ route('appointment.index') }}" class="btn btn-secondary btn-sm text-uppercase px-4">{{ trans('dash.label.next.appoinment') }}</a>
        </div>

        <div class="col-12">
            <div class="row justify-content-end align-items-center mb-3 mt-3 mt-lg-0">
                <div class="col-md-6 col-xl-8 d-flex gap-2 justify-content-center">
                    <a data-action="Appointments.prevMonth" data-action-event="click" class="circleArrow me-1"><i class="fa-solid fa-angle-left"></i></a>
                    <div>
                        <select name="monthselect" id="monthselect" class="form-select fs-5 fc" aria-label="{{ trans('dash.label.select.month') }}" data-action="Appointments.getAppoinments" data-action-event="change">
                            <option value="1" @if((int)$month == 1) selected="selected" @endif>{{ trans('dash.month.num1') }}</option>
                            <option value="2" @if((int)$month == 2) selected="selected" @endif>{{ trans('dash.month.num2') }}</option>
                            <option value="3" @if((int)$month == 3) selected="selected" @endif>{{ trans('dash.month.num3') }}</option>
                            <option value="4" @if((int)$month == 4) selected="selected" @endif>{{ trans('dash.month.num4') }}</option>
                            <option value="5" @if((int)$month == 5) selected="selected" @endif>{{ trans('dash.month.num5') }}</option>
                            <option value="6" @if((int)$month == 6) selected="selected" @endif>{{ trans('dash.month.num6') }}</option>
                            <option value="7" @if((int)$month == 7) selected="selected" @endif>{{ trans('dash.month.num7') }}</option>
                            <option value="8" @if((int)$month == 8) selected="selected" @endif>{{ trans('dash.month.num8') }}</option>
                            <option value="9" @if((int)$month == 9) selected="selected" @endif>{{ trans('dash.month.num9') }}</option>
                            <option value="10" @if((int)$month == 10) selected="selected" @endif>{{ trans('dash.month.num10') }}</option>
                            <option value="11" @if((int)$month == 11) selected="selected" @endif>{{ trans('dash.month.num11') }}</option>
                            <option value="12" @if((int)$month == 12) selected="selected" @endif>{{ trans('dash.month.num12') }}</option>
                        </select>
                    </div>
                    <div>
                        <select name="yearselect" id="yearselect" class="form-select fs-5 fc" aria-label="{{ trans('dash.label.select.year') }}" data-action="Appointments.getAppoinments" data-action-event="change">
                            @for ($i = date('Y') + 1; $i >= date('Y') - 2; $i--)
                                <option value="{{ $i }}" @if($i == $year) selected="selected" @endif>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <a data-action="Appointments.nextMonth" data-action-event="click" class="circleArrow ms-1"><i class="fa-solid fa-angle-right"></i></a>
                </div>
                <div class="col-md-3 col-xl-2 mt-3 mt-md-0">
                    <select name="useridselect" id="useridselect" class="form-select form-select-sm" aria-label="{{ trans('dash.label.select.doctor') }}" data-action="Appointments.getAppoinments" data-action-event="change">
                        @foreach ($vets as $vet)
                            <option value="{{ $vet->id }}" @if($vet->id == $userid) selected='selected' @endif>{{ ($vet->id == $user->id) ? $vet->name . ' ('. trans('dash.its.me') . ')' : $vet->name }}</option>    
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card rounded-3 border-2 border-secondary px-2 px-lg-3 py-2 py-lg-3 mb-0 mb-lg-5">
                <div class="card-body p-0">
                    <table class="table table-striped table-borderless mb-0 small align-middle cTable">
                        <tbody>
                            @if(count($appointments) > 0)
                                @foreach ($appointments as $appointment)
                                    <tr class="position-relative">
                                        <td class="px-2 px-lg-3 py-1 py-lg-4" data-label="{{ trans('dash.label.date') }}:" style="width: 130px;">
                                            <a class="btn btn-sm link-secondary px-0 px-md-1 py-0 py-md-2 text-start" href="{{ route('appointment.view', App\Models\User::encryptor('encrypt', $appointment->id)) }}">
                                                <span>{{ date('d', strtotime($appointment->date)) . ' ' . strtolower(trans('dash.month.num' . (int)date('m', strtotime($appointment->date)))) }}</span>
                                                <strong><span class="d-inline-block d-md-block ms-3 ms-md-0">{{ date('h:i a', strtotime($appointment->hour)) }}</span></strong>
                                            </a>
                                        </td>
                                        <td class="px-2 px-lg-3 py-1 py-lg-4" data-label="{{ trans('dash.label.pet') }}:" style="width: 130px;">
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
                                        <td class="px-2 px-lg-3 py-1 py-lg-4" data-label="{{ trans('dash.label.owner') }}:"><span class="user-select-none" data-bs-toggle="tooltip" data-bs-html="true" data-bs-offset="0,12" data-bs-title="{{ (isset($appointment['getClient']['phone'])) ? $appointment['getClient']['phone'] : '' }} <br> {{ (isset($appointment['getClient']['email'])) ? $appointment['getClient']['email'] : '' }}">{{ (isset($appointment['getClient']['name'])) ? $appointment['getClient']['name'] : '' }}<i class="fa-solid fa-circle-info opacity-75 ms-2"></i></span></td>
                                        <td class="px-2 px-lg-3 py-1 py-lg-4 text-end" data-label="{{ trans('dash.label.options') }}:">
                                            <div class="d-inline-block align-top">
                                                <a href="{{ route('appointment.view', App\Models\User::encryptor('encrypt', $appointment->id)) }}" class="apIcon d-md-inline-block mb-2 mb-md-0">
                                                    <i class="fa-regular fa-eye"></i>
                                                    <span class="d-none d-lg-inline-block">{{ trans('dash.label.btn.see') }}</span>
                                                </a>
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
@include('elements.appointmodals')

@endsection

@push('scriptBottom')
<script src="{{ asset('js/front/datedropper.js') }}"></script>
<script>
    window.APPOINTMENTS_HISTORY_CONFIG = {
        routes: {
            history: @json(route('appointment.history'))
        },
        selectors: {
            monthSelect: '#monthselect',
            yearSelect: '#yearselect',
            userSelect: '#useridselect'
        }
    };
</script>
<script src="{{ asset('js/appointments/history.js') }}"></script>
@endpush
