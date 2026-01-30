@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@include('elements.docmenu')

@php $weblang = \App::getLocale(); @endphp

<section class="container-fluid pb-0 pb-lg-4">
    <div class="row px-2 px-lg-3 mt-1 mt-lg-4">
        <form class="col-lg-10 col-xl-8 col-xxl-6 mx-auto mt-4 mt-lg-0 mb-lg-5">
            <h1 class="h4 d-flex align-items-center gap-2 text-uppercase justify-content-center justify-content-md-start fw-normal mb-3">
                <a href="javascript:history.back();" class="fs-5"><i class="fa-solid fa-angle-left backBtn2"></i></a>
                {{ trans('dash.label.btn.see') }} <span class="text-info fw-bold">{{ trans('dash.label.apointment') }}</span>
            </h1>

            @if(Auth::guard('web')->user()->rol_id == 8)
            <div class="d-flex flex-md-row gap-2 gap-md-4 justify-content-between mb-4">
                <div class="">
                    <i class="fa-solid fa-user-doctor fa-fw fs-5 text-primary mtIcon"></i>
                </div>
                <div class="flex-grow-1">
                    <label class="form-label small">{{ trans('dash.rol.name.4') }}</label>
                    <div class="border-bottom pb-2">
                        <p class="fw-medium c888">{{ (isset($appointment['getDoctor']['name'])) ? $appointment['getDoctor']['name'] : '' }} <span class="d-block fw-normal small">{{ (isset($vetName->company)) ? '('.$vetName->company.')' : '' }}</span> </p>
                    </div>
                </div>
            </div>
            @endif

            <div class="d-flex flex-md-row gap-2 gap-md-4 justify-content-between mb-4">
                <div class="">
                    <i class="fa-solid fa-paw fa-fw fs-5 text-primary mtIcon"></i>
                </div>
                <div class="flex-grow-1">
                    <label for="petname" class="form-label small">{{ trans('dash.label.pet') }}</label>
                    <select id="petname" class="form-select fc select2" data-placeholder="{{ trans('dash.label.selected') }}" disabled>
                        <option></option>
                        <option selected>{{ (isset($appointment['getPet']['name'])) ? $appointment['getPet']['name'] : '' }} ({{ (isset($appointment['getClient']['name'])) ? $appointment['getClient']['name'] : '' }})</option>
                    </select>
                </div>
            </div>

            <div class="d-flex flex-md-row gap-2 gap-md-4 mb-4">
                <div class="">
                    <i class="fa-regular fa-clock fa-fw fs-5 text-primary mtIcon"></i>
                </div>
                <div class="flex-grow-1">
                    <label for="ddate" class="form-label small">{{ trans('dash.label.date') }}</label>
                    <input type="text" id="ddate" class="form-control fc dDropper" value="{{ date('d/m/Y', strtotime($appointment->date)) }}" data-dd-opt-default-date="{{ date('d/m/Y', strtotime($appointment->date)) }}" disabled>
                </div>
                <div class="">
                    <label for="dtime" class="form-label small">{{ trans('dash.label.hour') }}</label>
                    <select class="form-select fc w-auto" id="dtime" disabled>
                        <option value=""></option>
                        <option value="" selected>{{ date('h:i a', strtotime($appointment->hour)) }}</option>
                    </select>
                </div>
            </div>

            <div class="d-flex flex-md-row gap-2 gap-md-4 mb-4">
                <div class="">
                    <i class="fa-solid fa-info fa-fw fs-5 text-primary mtIcon"></i>
                </div>
                <div class="flex-grow-1">
                    <label for="reason" class="form-label small">{{ trans('dash.label.reason') }}</label>
                    <input type="text" id="reason" class="form-control fc" value="{{ $appointment->reason }}" disabled>
                </div>
            </div>

            @if($appointment->breed_grooming != 0)
            <div class="d-flex flex-md-row gap-2 gap-md-4 mb-4">
                <div class="">
                    <i class="fa-solid fa-dog fa-fw fs-5 text-primary mtIcon"></i>
                </div>
                <div class="flex-grow-1">
                    <label for="breed" class="form-label small">{{ trans('dash.label.breed.and.cut') }}</label>
                    <input type="text" id="breed" class="form-control fc" value="{{ App\Models\AnimalBreed::getBreed($appointment->breed_grooming, $weblang); }}" disabled>

                    @php
                        $dataImage = App\Models\AnimalBreedImage::getImage($appointment->image_grooming, $weblang);
                        if($appointment->desc_grooming != '') {
                            $dataImage['image'] = '';
                            $dataImage['title'] = '' . trans('dash.label.other') . ': ' . $appointment->desc_grooming;
                        }
                    @endphp

                    <div class="fw-medium d-flex align-items-center gap-2 position-relative w-100 text-decoration-none rounded-3 border border-2 border-secondary px-3 py-2 mt-3">
                        @if($dataImage['image'] != '')
                        <span class="petPhoto d-inline-block rounded-circle" style="background-image: url({{ asset($dataImage['image']) }})"></span>
                        @endif
                        <span>{{ $dataImage['title'] }}</span>
                    </div>
                </div>
            </div>
            @endif

            <div class="d-flex flex-md-row gap-2 gap-md-4 mb-4">
                <div class="">
                    <i class="fa-solid fa-stethoscope fa-fw fs-5 text-primary mtIcon"></i>
                </div>
                <div class="flex-grow-1">
                    <label for="symptoms" class="form-label small">{{ trans('dash.label.Symptoms.only') }}</label>
                    <textarea class="form-control fc" id="symptoms" rows="2" disabled>{{ $appointment->symptoms }}</textarea>
                </div>
            </div>

            <div class="d-flex flex-md-row gap-2 gap-md-4 mb-4">
                <div>
                    <i class="fa-solid fa-clock-rotate-left fa-fw fs-5 text-primary mtIcon"></i>
                </div>
                <div class="flex-grow-1">
                    <label for="history" class="form-label small">{{ trans('dash.history.actual') }}</label>
                    <input type="text" id="history" name="history" class="form-control fc" maxlength="255" value="{{ $appointment->history }}" disabled>
                </div>
            </div>

            <div class="d-flex flex-md-row gap-2 gap-md-4 mb-4">
                <div>
                    <i class="fa-solid fa-weight-scale fa-fw fs-5 text-primary mtIcon"></i>
                </div>
                <div class="flex-grow-1">
                    <label class="form-label small">{{ trans('dash.exam.physical') }}</label>
                    <div class="position-relative border border-2 border-info-subtle docCol rounded p-3 d-flex flex-column flex-sm-row flex-wrap gap-2 mt-1 mb-3 small" id="printerPhysicalOptions" style="display: none !important;"></div>
                    
                    <div class="pushLeft mt-2 mt-sm-0" id="physicalExamButton">
                        
                    </div>
                </div>
                <textarea id="physicalExamData" name="physicalExamData" style="display: none;"></textarea>
            </div>

            <div class="d-flex flex-md-row gap-2 gap-md-4 mb-4">
                <div>
                    <i class="fa-solid fa-file-waveform fa-fw fs-5 text-primary mtIcon"></i>
                </div>
                <div class="flex-grow-1">
                    <label for="differential" class="form-label small">{{ trans('dash.differential.title') }}</label>
                    <select id="differential" name="differential" class="form-select fc select2" data-placeholder="Seleccionar" disabled>
                        <option></option>
                        @foreach ($diagnostics as $diagnostic)
                        <option value="{{ $diagnostic['title_' . $weblang] }}" @if(in_array($appointment->differential, [$diagnostic['title_en'], $diagnostic['title_es']])) selected @endif>{{ $diagnostic['title_' . $weblang] }}</option>    
                        @endforeach
                        <option value="Otro" @if($appointment->differential == 'Otro') selected @endif>{{ trans('dash.label.other') }}</option>
                    </select>
                    
                    <div class="mt-4" id="differentialOther" @if($appointment->differential != 'Otro') style="display:none" @endif>
                        <input type="text" id="differentialOtherInput" name="differentialOtherInput" value="{{ $appointment->differential_other }}" class="form-control fc" disabled>
                    </div>
                </div>
            </div>
            
            <div class="d-flex flex-md-row gap-2 gap-md-4 mb-4">
                <div>
                    <i class="fa-solid fa-file-medical fa-fw fs-5 text-primary mtIcon"></i>
                </div>
                <div class="flex-grow-1">
                    <label for="definitive" class="form-label small">{{ trans('dash.definitive.title') }}</label>
                    <select id="definitive" name="definitive" class="form-select fc select2" data-placeholder="Seleccionar" disabled>
                        <option></option>
                        @foreach ($diagnostics as $diagnostic)
                        <option value="{{ $diagnostic['title_' . $weblang] }}" @if(in_array($appointment->definitive, [$diagnostic['title_en'], $diagnostic['title_es']])) selected @endif>{{ $diagnostic['title_' . $weblang] }}</option>    
                        @endforeach
                        <option value="Otro" @if($appointment->definitive == 'Otro') selected @endif>{{ trans('dash.label.other') }}</option>
                    </select>
                    
                    <div class="mt-4" id="definitiveOther" @if($appointment->definitive != 'Otro') style="display:none" @endif>
                        <input type="text" id="definitiveOtherInput" name="definitiveOtherInput" value="{{ $appointment->definitive_other }}" class="form-control fc" disabled>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-md-row gap-2 gap-md-4 mb-4">
                <div>
                    <i class="fa-solid fa-hand-holding-medical fa-fw fs-5 text-primary mtIcon"></i>
                </div>
                <div class="flex-grow-1">
                    <label for="treatment" class="form-label small">{{ trans('dash.treatment.title') }}</label>
                    <textarea id="treatment" name="treatment" class="form-control fc" rows="1" disabled>{{ $appointment->treatment }}</textarea>
                </div>
            </div>

            <div class="d-flex flex-md-row gap-2 gap-md-4 mb-4">
                <div>
                    <i class="fa-regular fa-pen-to-square fa-fw fs-5 text-primary mtIcon"></i>
                </div>
                <div class="flex-grow-1">
                    <label id="editRecipe" for="fileRecipe" class="form-label small">{{ trans('dash.label.recipes') }}</label>

                    @if(count($recipes) > 0)
                        @foreach ($recipes as $recipe)
                            <div class="card border-2 border-info-subtle docCol pushLeft mt-2 mt-sm-1">
                                <div class="card-body p-2 p-md-3">
                                    <table class="table mb-0 small align-middle rTable">
                                        <thead>
                                            <tr>
                                                <th class="text-primary-emphasis text-uppercase fw-medium"><small>{{ trans('dash.label.name') }}</small></th>
                                                <th class="text-primary-emphasis text-uppercase fw-medium"><small>{{ trans('dash.label.duration') }}</small></th>
                                                <th class="text-primary-emphasis text-uppercase fw-medium text-center"><small>{{ trans('dash.label.take') }}</small></th>
                                                <th class="text-primary-emphasis text-uppercase fw-medium text-center"><small>{{ trans('dash.label.quantity') }}</small></th>
                                                <th class="text-primary-emphasis text-uppercase fw-medium"><small>{{ trans('dash.label.notes') }}</small></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($recipe->detail as $detail)
                                                <tr>
                                                    <td data-label="{{ trans('dash.label.name') }}:" class="fw-medium py-1 py-md-3">{{ $detail->title }}</td>
                                                    <td data-label="{{ trans('dash.label.duration') }}:" class="py-1 py-md-3">{{ $detail->duration }}</td>
                                                    <td data-label="{{ trans('dash.label.take') }}:" class="py-1 py-md-3 text-center">{{ $detail->take }}</td>
                                                    <td data-label="{{ trans('dash.label.quantity') }}:" class="py-1 py-md-3 text-center">{{ $detail->quantity }}</td>
                                                    <td data-label="{{ trans('dash.label.notes') }}:" class="py-1 py-md-3 d-flex"><span class="flex-1">{{ $detail->instruction }}</span></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a data-action="Appointments.setIdAppointmentToSendRecipe" data-action-event="click" data-action-args="{{ $recipe->id }}" class="btn btn-outline-primary btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#sendModal"><i class="fa-regular fa-envelope me-2"></i>{{ trans('dash.btn.label.send') }}</a>
                                        <a href="{{ route('appoinment.printrecipe', App\Models\User::encryptor('encrypt', $recipe->id)) }}" target="_blank" class="btn btn-outline-primary btn-sm mt-3"><i class="fa-solid fa-print me-2"></i>{{ trans('dash.btn.label.printer') }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="pushLeft mt-2 mt-sm-0">
                            <p class="mb-0">{{ trans('dash.label.not.recipes') }}</p>
                        </div>
                    @endif

                </div>
            </div>

            <div class="d-flex flex-md-row gap-2 gap-md-4 mb-4">
                <div>
                    <i class="fa-solid fa-paperclip fa-fw fs-5 text-primary mtIcon"></i>
                </div>
                <div class="flex-grow-1">
                    <label for="formFileMultiple" class="form-label small mb-2">{{ trans('dash.label.attachments') }}</label>
                    
                    <div class="pushLeft">
                        <div class="row g-3">
                            @if(count($attachs) > 0)
                                @foreach ($attachs as $attach)
                                    @php
                                        $ext = pathinfo($attach->attach, PATHINFO_EXTENSION);
                                    @endphp
                                    <div class="col-12 col-md-6">
                                        <div class="d-flex align-items-center border border-2 border-secondary rounded h-100 pe-2">
                                            <a target="_blank" href="{{ asset('files/' . $attach->folder . '/' . $attach->attach) }}" class="flex-1 d-flex gap-2 gap-sm-3 link-secondary p-3 text-decoration-none">
                                                @if(in_array($ext, ['jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG', 'gif', 'GIF']))
                                                    <i class="fa-regular fa-file-image fs-2"></i>
                                                @elseif (in_array($ext, ['pdf', 'PDF']))
                                                    <i class="fa-regular fa-file-pdf fs-2"></i>
                                                @else
                                                    <i class="fa-regular fa-file fs-2"></i>
                                                @endif
                                                <div>
                                                    <p class="fs-6 lh-sm mb-0 fw-medium"><small class="text-break">{{ $attach->title }}</small></p>
                                                    <p class="small lh-sm"><small>{{ date('d', strtotime($attach->created_at)) . ' de ' . strtolower(trans('dash.month.num' . (int)date('m', strtotime($attach->created_at)))) . ', ' . date('Y', strtotime($attach->created_at)) }}</small></p>
                                                </div>
                                            </a>
                                            <button type="button" class="btn btn-link p-2 opacity-75" title="Enviar" data-action="Appointments.setIdAppointmentToSendAttach" data-action-event="click" data-action-args="{{ $attach->id }}|{{ $appointment['getClient']['email'] }}" data-bs-toggle="modal" data-bs-target="#sendAttachModal"><i class="fa-regular fa-envelope"></i></button>
                                        </div>
                                    </div>        
                                @endforeach
                            @else
                                <div>
                                    <p class="mb-0 text-center"><i class="fa-regular fa-circle-xmark me-2 opacity-75"></i>{{ trans('dash.label.not.attachments') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if(Auth::guard('web')->user()->rol_id != 8)
            <div class="d-flex flex-md-row gap-2 gap-md-4 mb-4">
                <div>
                    <i class="fa-solid fa-notes-medical fa-fw fs-5 text-primary mtIcon"></i>
                </div>
                <div class="flex-grow-1">
                    <label class="form-label small">{{ trans('dash.note.vet.title') }}</label>
                    <div class="pushLeft mt-2 mt-sm-0">
                        @foreach ($notes as $note)
                            @if($note->to == 0)
                                <p class="mb-0">{{ $note->note }}</p>
                                <p class="small opacity-75 mt-1"><i class="fa-regular fa-clock me-2 opacity-75"></i>{{ date('d/m/Y', strtotime($note->created_at)) }}</p>
                                <hr>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <div class="d-flex flex-md-row gap-2 gap-md-4 mb-4">
                <div>
                    <i class="fa-regular fa-file-lines fa-fw fs-5 text-primary mtIcon"></i>
                </div>
                <div class="flex-grow-1">
                    <label class="form-label small">@if(Auth::guard('web')->user()->rol_id != 8) {{ trans('dash.note.client.title') }} @else {{ trans('dash.label.notes') }} @endif</label>
                    <div class="pushLeft mt-2 mt-sm-0">
                        @foreach ($notes as $note)
                            @if($note->to == 1)
                                <p class="mb-0">{{ $note->note }}</p>
                                <p class="small opacity-75 mt-1"><i class="fa-regular fa-clock me-2 opacity-75"></i>{{ date('d/m/Y', strtotime($note->created_at)) }}</p>
                                <hr>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            @if(Auth::guard('web')->user()->rol_id != 8)
            <div class="d-flex flex-column flex-md-row gap-2 gap-md-4">
                <div class="d-none d-md-block">
                    <i class="fa-solid fa-angle-right fa-fw fs-5 mt-1 text-white"></i>
                </div>
                <div class="d-flex flex-column flex-sm-row gap-2">
                    <a href="{{ route('appointment.edit', App\Models\User::encryptor('encrypt', $appointment->id)) }}" class="btn btn-primary px-4">{{ trans('dash.label.btn.edit') }}</a>
                </div>
            </div>
            @endif
        </form>
    </div>
</section>

@include('elements.footer')
@include('elements.appointmodals', ['ModalsendRecipe' => true, 'ModalsendAttach' => true, 'PhysicalExam' => true])

@endsection

@push('scriptBottom')
<link rel="stylesheet" href="{{ asset('css/wpanel/library/jquery.toast.css') }}">
<script src="{{ asset('js/wpanel/library/jquery.toast.js') }}"></script>
@endpush