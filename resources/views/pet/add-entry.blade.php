@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

    @php
        $userInSession = ((isset(Auth::guard('web')->user()->id)) && (Auth::guard('web')->user()->rol_id != 8)) ? Auth::guard('web')->user() : null;
        $nameDoctor = (isset($userInSession->name)) ? $userInSession->name : '';
        $codeDoctor = (isset($userInSession->code)) ? $userInSession->code : '';
    @endphp

    @if(isset($userInSession->id))
        @include('elements.docmenu')
    @else
        @include('elements.alonetop')
    @endif
    
    <section class="container-fluid pb-0 pb-lg-4">
        <div class="row px-2 px-lg-3 mt-2 mt-lg-4 mb-3 mb-lg-5">

            <div class="smallCol mx-auto mt-2">

                <h2 class="h4 text-uppercase text-center text-md-start fw-normal mb-3">{{ trans('dash.label.add') }} <span class="text-info fw-bold">{{ trans('dash.label.vaccine.add') }}</span></h2>
                
                <form id="frmVaccineModaladd" name="frmVaccineModaladd" action="" enctype="multipart/form-data" method="post" data-action="prevent" data-action-event="submit">
                    @csrf

                    <input type="hidden" id="vaccineOffline" name="vaccineOffline" value="{{ $id }}">

                    <div class="mb-3">
                        <label for="doctorName" class="form-label small">{{ trans('dash.label.element.name') }}</label>
                        <input type="text" class="form-control fc requeridoAddVaccine" name="doctorName" id="doctorName" value="{{ $nameDoctor }}" @if($nameDoctor != '') readonly @endif>
                    </div>

                    <div class="mb-3">
                        <label for="doctorId" class="form-label small">{{ trans('dash.label.element.code') }}</label>
                        <input type="text" class="form-control fc requeridoAddVaccine" name="doctorId" id="doctorId" value="{{ $codeDoctor }}" @if($codeDoctor != '') readonly @endif data-action="vetegramHelpers.enterOnlyNumbers" data-action-event="keydown" data-action-args="$event">
                    </div>

                    <div class="mb-3">
                        <label for="vName" class="form-label small">{{ trans('dash.label.element.date.apply') }}</label>
                        <input type="text" class="form-control fc dDropper requeridoAddVaccine" name="vaccineDate" id="vaccineDate" readonly="true">
                    </div>

                    <div class="mb-3">
                        <label for="vName" class="form-label small">{{ trans('dash.label.element.drug') }}</label>
                        <input type="text" id="vaccineName" name="vaccineName" class="form-control fc requeridoAddVaccine" maxlength="255">
                    </div>

                    <div class="d-flex gap-4">
                        <div class="mb-3 w-50">
                            <label for="vName" class="form-label small">{{ trans('dash.label.element.brand') }}</label>
                            <input type="text" class="form-control fc" name="vaccineBrand" id="vaccineBrand">
                        </div>
                        <div class="mb-3 w-50">
                            <label for="vName" class="form-label small">{{ trans('dash.label.element.lot') }}</label>
                            <input type="text" class="form-control fc" name="vaccineBatch" id="vaccineBatch">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="vName" class="form-label small">{{ trans('dash.label.element.date.expire') }}</label>
                        <input type="text" class="form-control fc dDropper" name="vaccineDateExpire" id="vaccineDateExpire" readonly="true">
                    </div>

                    <div class="mb-4">
                        <label for="vName" class="form-label small mb-2">{{ trans('dash.label.element.image') }}</label>
                        <input class="form-control" type="file" name="vaccinePhoto" id="vaccinePhoto" style="padding: .375rem .75rem;">
                    </div>

                    <button type="button" data-action="Pet.saveToCreateVaccine" data-action-event="click" class="btn btn-primary px-4">{{ trans('dash.text.btn.save') }}</button>
                </form>

            </div>

        </div>
    </section>

    @include('elements.footer')

@endsection

@push('scriptBottom')
    <link rel="stylesheet" href="{{ asset('css/wpanel/library/jquery.toast.css') }}">
    <script src="{{ asset('js/wpanel/library/jquery.toast.js') }}"></script>
    <script src="{{ asset('js/front/datedropper.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        window.PET_ADD_ENTRY_CONFIG = {
            routes: {
                createVaccine: @json(route('appoinment.createVaccine'))
            },
            texts: {
                saveTitle: @json(trans('dash.msg.save.vaccine')),
                saveSuccess: @json(trans('dash.msg.save.vaccine.success')),
                saveError: @json(trans('dash.msg.error.save.vaccine')),
                createError: @json(trans('dash.msg.error.create.vaccine'))
            }
        };
    </script>
    <script src="{{ asset('js/pet/add-entry.js') }}"></script>
@endpush
