@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@include('elements.docmenu')

@php $weblang = \App::getLocale(); @endphp

<section class="container-fluid pb-0 pb-lg-4">
    <div class="row px-2 px-lg-3 mt-2 mt-lg-4">
        
        <form name="frmAddAppointment" id="frmAddAppointment" action="{{ route('appointment.store') }}" method="post" data-action="Appointments.validate" data-action-event="submit"  enctype="multipart/form-data" class="col-lg-10 col-xl-8 col-xxl-6 mx-auto mt-4 mt-lg-0 mb-lg-5">
            <h1 class="h4 text-uppercase text-center text-md-start fw-normal mb-3">{{ trans('dash.label.add') }} <span class="text-info fw-bold">{{ trans('dash.label.apointment') }}</span></h1>

            @csrf

            <input type="hidden" name="idvet" id="idvet" value="{{ $user->id_vet }}">

            <div class="d-flex flex-md-row gap-2 gap-md-4 justify-content-between mb-4">
                <div class="">
                    <i class="fa-solid fa-user fa-fw fs-5 text-primary mtIcon"></i>
                </div>
                <div class="flex-grow-1">
                    <label for="user" class="form-label small">{{ trans('dash.label.calendar') }}</label>
                    <select id="user" name="user" class="form-select fc select2 requerido" data-placeholder="{{ trans('dash.label.selected') }}" data-action="Appointments.getHours" data-action-event="change" data-action-args="groomer">
                        <option></option>
                        @foreach ($vets as $vet)
                            <option value="{{ $vet->id }}" @if($vet->id == $user->id) selected='selected' @endif data-rol="{{ $vet->rol_id }}">{{ ($vet->id == $user->id) ? $vet->name . ' ('. trans('dash.its.me') . ')' : $vet->name }}</option>    
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="d-flex flex-md-row gap-2 gap-md-4 mb-4">
                <div class="">
                    <i class="fa-solid fa-paw fa-fw fs-5 text-primary mtIcon"></i>
                </div>
                <div class="flex-grow-1 d-flex flex-column flex-sm-row gap-3 align-items-sm-end">
                    <div class="flex-grow-1">
                        <label for="pet" class="form-label small">{{ trans('dash.label.pet') }}</label>
                        <select id="pet" name="pet" class="form-select fc select2 requerido" data-placeholder="{{ trans('dash.label.selected') }}" data-action="Appointments.selectedPet" data-action-event="change">
                            <option></option>
                            @foreach ($pets as $pet)
                                <option value="{{ $pet->id . ':' . $pet->id_user }}">{{ $pet->name . ' (' . $pet['getUser']['name'] . ')' }}</option>
                            @endforeach
                        </select>
                    </div>

                    <a href="javascript:void(0);" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createUserModal">
                        <i class="fa-solid fa-search me-1"></i>
                        {{ trans('dash.label.search') }}
                    </a>
                    <a href="javascript:void(0);" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#createNewUser">
                        <i class="fa-solid fa-plus me-1"></i>
                        {{ trans('dash.label.create') }}
                    </a>
                </div>
            </div>

            <div class="d-flex flex-md-row gap-2 gap-md-4 mb-4">
                <div class="">
                    <i class="fa-regular fa-clock fa-fw fs-5 text-primary mtIcon"></i>
                </div>
                <div class="flex-grow-1 d-flex flex-column flex-sm-row gap-3 align-items-sm-end">
                    <div class="flex-grow-1">
                        <label for="date" class="form-label small">{{ trans('dash.label.date') }}</label>
                        <input type="text" name="date" id="date" class="form-control fc dDropperHour requerido" data-action="Appointments.getHours" data-action-event="change" data-dd-opt-min-date="{{ date('Y/m/d') }}" size="14">
                    </div>
                    <div>
                        <label for="dtime" class="form-label small">{{ trans('dash.label.hour') }}</label>
                        <select id="hour" name="hour" class="form-select fc requerido" data-action="Appointments.reserverHour" data-action-event="change" data-action-args="$el">
                            <option value="">{{ trans('dash.label.selected') }}</option>
                        </select>
                    </div>
                    {{-- <a id="urlToAvailable" href="{{ url('/setting-edit') }}" class="btn btn-outline-primary btn-sm">
                        <i class="fa-solid fa-calendar-days me-1"></i>
                        {{ trans('dash.label.availability') }}
                    </a> --}}
                    <button id="urlToAvailable" type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#availabilityModal">
                        <i class="fa-solid fa-calendar-days me-1"></i>
                        {{ trans('dash.label.availability') }}
                    </button>
                </div>
            </div>

            <div class="d-flex flex-md-row gap-2 gap-md-4 mb-4">
                <div>
                    <i class="fa-solid fa-info fa-fw fs-5 text-primary mtIcon"></i>
                </div>
                <div class="flex-grow-1">
                    <label for="reason" class="form-label small">{{ trans('dash.label.reason') }}</label>
                    <input type="text" id="reason" name="reason" class="form-control fc" maxlength="255" autocomplete="off">
                </div>
            </div>

            <div class="d-flex flex-md-row gap-2 gap-md-4 mb-4">
                <div>
                    <i class="fa-solid fa-paperclip fa-fw fs-5 text-primary mtIcon"></i>
                </div>
                <div class="flex-grow-1">
                    <label for="formFileMultiple" class="form-label small mb-2">{{ trans('dash.label.attachments') }}</label>
                    <input class="form-control" type="file" id="fileModalMultiple" name="fileModalMultiple[]" multiple style="padding: .375rem .75rem;">
                </div>
            </div>

            <div class="d-flex flex-md-row gap-2 gap-md-4 mb-4">
                <div>
                    <i class="fa-regular fa-pen-to-square fa-fw fs-5 text-primary mtIcon"></i>
                </div>
                <div class="flex-grow-1">
                    <label id="editRecipe" for="fileRecipe" class="form-label small mb-2">{{ trans('dash.label.recipes') }}</label>

                    <div class="pushLeft">
                        <a href="javascript:void(0);" class="d-flex gap-2 align-items-center justify-content-center bgGrey p-3 rounded link-secondary text-decoration-none" data-bs-toggle="modal" data-bs-target="#recipeModalToAdd">
                            <i class="fa-solid fa-plus fs-5 text-primary"></i>
                            <div>
                                <p class="fs-6 lh-sm mb-0 fw-medium"><small>{{ trans('dash.label.add.recipes') }}</small></p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div style="display: none;" id="contGrooming">
                <div class="d-flex flex-md-row gap-2 gap-md-4 mb-4">
                    <div>
                        <i class="fa-solid fa-soap fa-fw fs-5 text-primary mtIcon"></i>
                    </div>
                    <div class="flex-grow-1">
                        <label id="editRecipe" class="form-label small mb-2">Grooming</label>

                        <div class="pushLeft">
                            <a href="javascript:void(0);" class="d-flex gap-2 align-items-center justify-content-center bgGrey p-3 rounded link-secondary text-decoration-none" data-bs-toggle="modal" data-bs-target="#groomingModal">
                                <i class="fa-solid fa-plus fs-5 text-primary"></i>
                                <div>
                                    <p class="fs-6 lh-sm mb-0 fw-medium"><small>{{ trans('dash.label.select.grooming') }}</small></p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-md-row gap-2 gap-md-4 mb-4">
                <div>
                    <i class="fa-regular fa-file-lines fa-fw fs-5 text-primary mtIcon"></i>
                </div>
                <div class="flex-grow-1">
                    <label class="form-label small mb-2">{{ trans('dash.label.notes') }}</label>
                    <textarea class="form-control fc" id="notetitle" name="notetitle" rows="2"></textarea>
                </div>
            </div>

            <div class="d-flex flex-row gap-2 gap-md-4 mb-1">
                <div>
                    <i class="fa-regular fa-bell fa-fw fs-5 text-primary mtIcon"></i>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" value="1" id="addReminder" name="addReminder" data-action="Appointments.setNotified" data-action-event="click">
                    <label class="form-check-label small" for="addReminder">
                        {{ trans('dash.label.title.reminder') }}
                    </label>
                </div>
            </div>

            <div id="containerNotified" style="display: none;">
                <div class="d-flex flex-md-row flex-wrap gap-2 gap-md-4 mb-2">
                    <div>
                        <i class="fa-regular fa-bell fa-fw fs-5 text-white mtIcon"></i>
                    </div>
                    <div class="d-flex flex-column flex-sm-row flex-grow-1 gap-3">
                        <div class="flex-grow-1">
                            <label class="form-label small">{{ trans('dash.label.btn.reminder') }}</label>
                            <select name="reminder_type" id="reminder_type" class="form-select fc requeridoReminder" aria-label="Select person">
                                <option value="">{{ trans('dash.label.selected') }}</option>
                                <option value="1">{{ trans('dash.label.for.me') }}</option>
                                <option value="2">{{ trans('dash.label.for.owner') }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label small">{{ trans('dash.label.date') }} <small class="ms-1">({{ trans('dash.label.btn.reminder') }})</small></label>
                            <input type="text" id="reminder_date" name="reminder_date" class="form-control fc dDropper requeridoReminder" data-dd-opt-min-date="{{ date('Y/m/d') }}" readonly>
                        </div>
                        <div>
                            <label class="form-label small">{{ trans('dash.label.hour') }} <small class="ms-1">({{ trans('dash.label.btn.reminder') }})</small></label>
                            <input type="time" id="reminder_time" name="reminder_time" class="form-control fc requeridoReminder">
                        </div>
                    </div>
                </div>
                
                <div class="d-flex flex-md-row gap-2 gap-md-4 mb-4">
                    <div class="">
                        <i class="fa-regular fa-bell fa-fw fs-5 text-white"></i>
                    </div>
                    <div class="flex-grow-1">
                        <label class="form-label small">{{ trans('dash.label.detail') }}</label>
                        <textarea class="form-control fc requeridoReminder" id="reminder_detail" name="reminder_detail" rows="1"></textarea>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-column flex-md-row gap-2 gap-md-4">
                <div class="d-none d-md-block">
                    <i class="fa-solid fa-angle-right fa-fw fs-5 mt-1 text-white"></i>
                </div>
                <div class="d-flex flex-column flex-sm-row gap-2">
                    <button type="submit" class="btn btn-primary px-4" id="btnSave">{{ trans('dash.text.btn.save') }}</button>
                </div>
            </div>

            @if(session('error'))
            <div class="d-flex flex-column flex-md-row gap-3 mt-4">
                <div class="d-none d-md-block">
                    <i class="fa-solid fa-angle-right fa-fw fs-5 mt-1 text-white"></i>
                </div>
                <div class="alert alert-danger flex-grow-1">
                    <strong>Error!</strong> {!! session('error') !!}
                </div>
            </div>
            @endif

            @include('elements.appointmodals', ['ModalrecipeToAdd' => true, 'grooming' => true])
        </form>
    </div>
</section>

<div class="modal fade" id="availabilityModal" tabindex="-1" aria-labelledby="availabilityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="fw-normal mb-0 text-secondary">{{ trans('dash.label.availability') }}</h6>
          <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body py-3 py-md-4 px-5">
            <div class="row printerHoursAvailable">
                {{ trans('dash.label.selected.notavailable') }}
            </div>
        </div>
        <div class="modal-footer justify-content-center px-3 px-md-4 pb-3 pb-md-4 pt-0">
          <button type="button" data-bs-dismiss="modal" class="btn btn-outline-primary btn-sm px-4">{{ trans('dash.label.close') }}</button>
        </div>
      </div>
    </div>
</div>

@include('elements.footer')
@include('elements.appointmodals', ['ModalSearchUser' => true, 'ModalCreatePet' => true, 'ModalCreateUser' => true])

@endsection

@push('scriptBottom')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('js/front/datedropper.js') }}"></script>

<link rel="stylesheet" href="{{ asset('css/wpanel/library/jquery.toast.css') }}">
<script src="{{ asset('js/wpanel/library/jquery.toast.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    window.APPOINTMENTS_ADD_CONFIG = {
        routes: {
            settingsEdit: @json(route('sett.edit')),
            getHours: @json(route('appoinment.getHours')),
            reserveHour: @json(route('appoinment.reserveHour'))
        },
        texts: {
            selected: @json(trans('dash.label.selected')),
            selectedNotAvailable: @json(trans('dash.label.selected.notavailable')),
            hourNotAvailable: @json(trans('dash.msg.error.hour.not.available')),
            errorExtFile: @json(trans('dash.msg.error.ext.file')),
            errorRecipeFields: @json(trans('dash.msg.error.recipe.fields')),
            imageNotChoose: @json(trans('dash.image.not.choose')),
            imageNotChoosePersonalize: @json(trans('dash.image.not.choose.personalize')),
            saveProcessing: @json(trans('dash.text.btn.save.process')),
            todayDate: @json(date('j/n/Y'))
        },
        data: {
            types: @json($types),
            medicines: @json($medicines)
        },
        selectors: {
            recipeModal: '#recipeModal',
            createNewUser: '#createNewUser',
            createUserModal: '#createUserModal',
            createNewPet: '#createNewPet',
            dateInput: '#date',
            userSelect: '#user',
            hourSelect: '#hour',
            urlToAvailable: '#urlToAvailable',
            groomingContainer: '#contGrooming'
        }
    };
</script>
<script src="{{ asset('js/appointments/add.js') }}"></script>
@endpush
