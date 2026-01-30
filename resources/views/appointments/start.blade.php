@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@include('elements.docmenu')

@php $weblang = \App::getLocale(); @endphp

<section class="container pb-0 pb-lg-4">
    <div class="row px-2 px-lg-3 mt-2 mt-lg-4 mb-lg-5">
        <h1 class="h4 text-uppercase text-center text-md-start fw-normal mb-2 mb-md-3">{{ trans('dash.label.appointment.of') }} <span class="text-info fw-bold">{{ trans('dash.label.appointment.of.live') }}</span></h1>
        <form class="col order-1 order-lg-0 mt-2 mt-lg-0">

            <div class="d-flex flex-md-row gap-2 gap-md-4 justify-content-between mb-4">
                <div class="">
                    <i class="fa-solid fa-paw fa-fw fs-5 text-primary mtIcon"></i>
                </div>
                <div class="flex-grow-1">
                    <label for="petname" class="form-label small">{{ trans('dash.label.pet') }}</label>
                    <select id="petname" class="form-select fc select2" data-placeholder="Seleccionar" disabled>
                        <option></option>
                        <option selected>{{ (isset($appointment['getPet']['name'])) ? $appointment['getPet']['name'] : '' }} ({{ (isset($appointment['getClient']['name'])) ? $appointment['getClient']['name'] : '' }})</option>
                    </select>
                </div>
            </div>

            <div class="d-flex flex-md-row gap-2 gap-md-4 mb-4">
                <div>
                    <i class="fa-regular fa-clock fa-fw fs-5 text-primary mtIcon"></i>
                </div>
                <div class="flex-grow-1">
                    <label for="ddate" class="form-label small">{{ trans('dash.label.date') }}</label>
                    <input type="text" id="ddate" size="14" class="form-control fc dDropper" value="{{ date('d/m/Y', strtotime($appointment->date)) }}" data-dd-opt-default-date="{{ date('d/m/Y', strtotime($appointment->date)) }}" disabled>
                </div>
                <div>
                    <label for="dtime" class="form-label small">{{ trans('dash.label.hour') }}</label>
                    <select class="form-select fc" id="dtime" disabled>
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
                    <input type="text" id="reason" name="reason" class="form-control fc requiredThisForm" value="{{ $appointment->reason }}" data-action="Appointments.updateRecipe" data-action-event="change">
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
                <div>
                    <i class="fa-solid fa-stethoscope fa-fw fs-5 text-primary mtIcon"></i>
                </div>
                <div class="flex-grow-1">
                    <label for="symptoms" class="form-label small">{{ trans('dash.label.Symptoms.only') }}</label>
                    <input type="text" id="symptoms" name="symptoms" class="form-control fc requiredThisForm" maxlength="255" value="{{ $appointment->symptoms }}" autocomplete="off" data-action="Appointments.updateRecipe" data-action-event="change">
                </div>
            </div>

            <div class="d-flex flex-md-row gap-2 gap-md-4 mb-4">
                <div>
                    <i class="fa-solid fa-clock-rotate-left fa-fw fs-5 text-primary mtIcon"></i>
                </div>
                <div class="flex-grow-1">
                    <label for="history" class="form-label small">{{ trans('dash.history.actual') }}</label>
                    <input type="text" id="history" name="history" class="form-control fc" maxlength="255" value="{{ $appointment->history }}" autocomplete="off" data-action="Appointments.updateRecipe" data-action-event="change">
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
                        <a href="javascript:void(0);" class="d-flex gap-2 align-items-center justify-content-center bgGrey p-3 rounded link-secondary text-decoration-none" data-bs-toggle="modal" data-bs-target="#physicalExam">
                            <i class="fa-solid fa-plus fs-5 text-primary"></i>
                            <div>
                                <p class="fs-6 lh-sm mb-0 fw-medium"><small>{{ trans('dash.add.data') }}</small></p>
                            </div>
                        </a>
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
                    <select id="differential" name="differential" class="form-select fc select2" data-placeholder="Seleccionar" data-action="Appointments.updateOther" data-action-event="change" data-action-args="differential">
                        <option></option>
                        @foreach ($diagnostics as $diagnostic)
                        <option value="{{ $diagnostic['title_' . $weblang] }}" @if(in_array($appointment->differential, [$diagnostic['title_en'], $diagnostic['title_es']])) selected @endif>{{ $diagnostic['title_' . $weblang] }}</option>    
                        @endforeach
                        <option value="Otro" @if($appointment->differential == 'Otro') selected @endif>{{ trans('dash.label.other') }}</option>
                    </select>
                    
                    <div class="mt-4" id="differentialOther" @if($appointment->differential != 'Otro') style="display:none" @endif>
                        <input type="text" id="differentialOtherInput" name="differentialOtherInput" value="{{ $appointment->differential_other }}" class="form-control fc" placeholder="Escribir" data-action="Appointments.updateRecipe" data-action-event="change">
                    </div>
                </div>
            </div>
            
            <div class="d-flex flex-md-row gap-2 gap-md-4 mb-4">
                <div>
                    <i class="fa-solid fa-file-medical fa-fw fs-5 text-primary mtIcon"></i>
                </div>
                <div class="flex-grow-1">
                    <label for="definitive" class="form-label small">{{ trans('dash.definitive.title') }}</label>
                    <select id="definitive" name="definitive" class="form-select fc select2" data-placeholder="Seleccionar" data-action="Appointments.updateOther" data-action-event="change" data-action-args="definitive">
                        <option></option>
                        @foreach ($diagnostics as $diagnostic)
                        <option value="{{ $diagnostic['title_' . $weblang] }}" @if(in_array($appointment->definitive, [$diagnostic['title_en'], $diagnostic['title_es']])) selected @endif>{{ $diagnostic['title_' . $weblang] }}</option>    
                        @endforeach
                        <option value="Otro" @if($appointment->definitive == 'Otro') selected @endif>{{ trans('dash.label.other') }}</option>
                    </select>
                    
                    <div class="mt-4" id="definitiveOther" @if($appointment->definitive != 'Otro') style="display:none" @endif>
                        <input type="text" id="definitiveOtherInput" name="definitiveOtherInput" value="{{ $appointment->definitive_other }}" class="form-control fc" placeholder="Escribir" data-action="Appointments.updateRecipe" data-action-event="change">
                    </div>
                </div>
            </div>

            <div class="d-flex flex-md-row gap-2 gap-md-4 mb-4">
                <div>
                    <i class="fa-solid fa-hand-holding-medical fa-fw fs-5 text-primary mtIcon"></i>
                </div>
                <div class="flex-grow-1">
                    <label for="treatment" class="form-label small">{{ trans('dash.treatment.title') }}</label>
                    <textarea id="treatment" name="treatment" class="form-control fc" rows="1" data-action="Appointments.updateRecipe" data-action-event="change">{{ $appointment->treatment }}</textarea>
                </div>
            </div>

            <div class="d-flex flex-md-row gap-2 gap-md-4 mb-4">
                <div>
                    <i class="fa-regular fa-pen-to-square fa-fw fs-5 text-primary mtIcon"></i>
                </div>
                <div class="flex-grow-1">
                    <label id="editRecipe" for="fileRecipe" class="form-label small">{{ trans('dash.label.recipes') }}</label>

                    @foreach ($recipes as $recipe)
                        <div class="card border-2 border-info-subtle docCol pushLeft mt-2 mb-3">
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
                                <button type="button" data-id="{{ $recipe->id }}" data-action="Appointments.removeRecipe" data-action-event="click" data-action-args="$el" class="deleteR2"><i class="fa-solid fa-xmark"></i></button>
                                <div class="d-flex gap-2 justify-content-end">
                                    <a data-action="Appointments.setIdAppointmentToSendRecipe" data-action-event="click" data-action-args="{{ $recipe->id }}" class="btn btn-outline-primary btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#sendModal"><i class="fa-regular fa-envelope me-2"></i>{{ trans('dash.btn.label.send') }}</a>
                                    <a href="{{ route('appoinment.printrecipe', App\Models\User::encryptor('encrypt', $recipe->id)) }}" target="_blank" class="btn btn-outline-primary btn-sm mt-3"><i class="fa-solid fa-print me-2"></i>{{ trans('dash.btn.label.printer') }}</a>
                                    <a data-action="Appointments.setIdAppointmentToRecipeEdit" data-action-event="click" data-action-args="{{ $recipe->id }}" class="btn btn-outline-primary btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#recipeModalEdit"><i class="fa-solid fa-pencil me-2"></i>{{ trans('dash.label.btn.edit') }}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                    <div class="pushLeft mt-2 mt-sm-0">
                        <a data-action="Appointments.setIdAppointmentToMedicine" data-action-event="click" data-action-args="{{ $appointment->id }}" href="javascript:void(0);" class="d-flex gap-2 align-items-center justify-content-center bgGrey p-3 rounded link-secondary text-decoration-none" data-bs-toggle="modal" data-bs-target="#recipeModal">
                            <i class="fa-solid fa-plus fs-5 text-primary"></i>
                            <div>
                                <p class="fs-6 lh-sm mb-0 fw-medium"><small>{{ trans('dash.label.add.recipes') }}</small></p>
                            </div>
                        </a>
                    </div>

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
                            @php
                                $thisUser = Auth::guard('web')->user()->id;
                            @endphp
                            @foreach ($attachs as $attach)
                                @php
                                    $ext = pathinfo($attach->attach, PATHINFO_EXTENSION);
                                @endphp
                                <div class="col-12 col-xl-6 position-relative">
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
                                        @if($attach->created_by == $thisUser)
                                        <button type="button" data-id="{{ $attach->id }}" data-action="Appointments.removeFile" data-action-event="click" data-action-args="$el" class="btn btn-link p-2 opacity-75" title="Borrar"><i class="fa-regular fa-trash-can"></i></button>
                                        @endif
                                    </div>
                                </div>        
                            @endforeach
                            <div class="col-12 col-xl-6">
                                <a href="javascript:void(0);" data-action="Appointments.setIdAppointmentToAttach" data-action-event="click" data-action-args="{{ $appointment->id }}" class="d-flex gap-2 gap-sm-3 align-items-center justify-content-center border border-2 border-secondary p-3 rounded link-secondary text-decoration-none h-100" data-bs-toggle="modal" data-bs-target="#attachModal">
                                    <i class="fa-solid fa-plus fs-4 text-primary"></i>
                                    <div>
                                        <p class="fs-6 lh-sm mb-0 fw-medium"><small>{{ trans('dash.btn.add.new') }}</small></p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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

                        <div>
                            <a data-action="Appointments.setIdAppointmentToNote" data-action-event="click" data-action-args="{{ $appointment->id }}|0" href="javascript:void(0);" class="d-flex gap-2 align-items-center justify-content-center bgGrey p-3 rounded link-secondary text-decoration-none" data-bs-toggle="modal" data-bs-target="#noteModal">
                                <i class="fa-solid fa-plus fs-5 text-primary"></i>
                                <div>
                                    <p class="fs-6 lh-sm mb-0 fw-medium"><small>{{ trans('dash.label.add.notes') }}</small></p>
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
                    <label class="form-label small">{{ trans('dash.note.client.title') }}</label>
                    <div class="pushLeft mt-2 mt-sm-0">
                        @foreach ($notes as $note)
                            @if($note->to == 1)
                                <p class="mb-0">{{ $note->note }}</p>
                                <p class="small opacity-75 mt-1"><i class="fa-regular fa-clock me-2 opacity-75"></i>{{ date('d/m/Y', strtotime($note->created_at)) }}</p>
                                <hr>
                            @endif
                        @endforeach

                        <div>
                            <a data-action="Appointments.setIdAppointmentToNote" data-action-event="click" data-action-args="{{ $appointment->id }}|1" href="javascript:void(0);" class="d-flex gap-2 align-items-center justify-content-center bgGrey p-3 rounded link-secondary text-decoration-none" data-bs-toggle="modal" data-bs-target="#noteModal">
                                <i class="fa-solid fa-plus fs-5 text-primary"></i>
                                <div>
                                    <p class="fs-6 lh-sm mb-0 fw-medium"><small>{{ trans('dash.label.add.notes') }}</small></p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-column flex-sm-row gap-2 ms-0 ms-sm-4 ms-md-5">
                <button data-action="Appointments.finishRecipe" data-action-event="click" data-action-args="{{ $appointment->id }}|0" type="button" class="btn btn-primary px-4">{{ trans('dash.label.appointment.finish') }}</button>
                <button data-action="Appointments.finishRecipe" data-action-event="click" data-action-args="{{ $appointment->id }}|1" type="button" class="btn btn-outline-primary px-4">{{ trans('dash.label.appointment.finish.facture') }}</button>
            </div>
        </form>
        <div class="col-lg-4 order-0 order-lg-1 ps-lg-5 mb-4 mb-lg-0">
            <div class="docCol card rounded-3 border-2 border-secondary mb-3">
                <div class="card-body py-2 px-3">
                    <h1 class="h5 text-uppercase text-primary mt-2 mb-0 ms-2">{{ $appointment['getPet']['name'] }}</h1>
                    <table class="table info2 small mb-0">
                        <tbody>
                            <tr>
                                <td style="width: 50%;">
                                    <span class="fw-medium d-block">{{ trans('dash.label.element.breed') }}:</span>
                                    {{ (isset($pet['getBreed']['title_' . $weblang])) ? $pet['getBreed']['title_' . $weblang] : trans('dash.labe.no.info') }}
                                </td>
                                <td>
                                    <span class="fw-medium d-block">{{ trans('dash.label.element.age') }}:</span>
                                    {{ ($pet->age != '') ? App\Models\Pet::getAgeValue($pet->age) : trans('dash.labe.no.info') }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="fw-medium d-block">{{ trans('dash.label.element.sex') }}:</span>
                                    {{ ($pet->gender != '') ? trans('dash.label.sex.' . $pet->gender) : trans('dash.labe.no.info') }}
                                </td>
                                <td>
                                    <span class="fw-medium d-block">{{ trans('dash.label.element.sterilized') }}:</span>
                                    {{ ($pet->castrate == 1) ? 'Si' : 'No' }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="fw-medium d-block">Color:</span>
                                    {{ ($pet->color != '') ? $pet->color : trans('dash.labe.no.info') }}
                                </td>
                                <td>
                                    <span class="fw-medium d-block">{{ trans('dash.label.element.food') }}:</span>
                                    {{ ($pet->alimentation != '') ? $pet->alimentation : trans('dash.labe.no.info') }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="fw-medium d-block">{{ trans('dash.label.element.blood') }}:</span>
                                    {{ ($pet->blood != '') ? $pet->blood : trans('dash.labe.no.info') }}
                                </td>
                                <td>
                                    <span class="fw-medium d-block">{{ trans('dash.label.element.disease') }}:</span>
                                    {{ ($pet->disease != '') ? $pet->disease : trans('dash.labe.no.info') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <button type="button" class="editR4" data-bs-toggle="modal" data-bs-target="#petEditModal"><i class="fa-solid fa-pencil"></i></button>
            </div>

            <div class="accordion mt-1" id="accordionData">
                <div class="accordion-item">
                  <h2 class="accordion-header">
                    <button class="accordion-button collapsed fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                        {{ trans('dash.label.register.vaccine') }}
                    </button>
                  </h2>
                  <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionData">
                    <div class="accordion-body pb-2 pt-2">
                        @if(count($vaccines) > 0)
                            @foreach ($vaccines as $vaccine)
                            <div class="d-flex justify-content-between small py-1">
                                <span>{{ $vaccine->name }}, {{ date('d-m-Y', strtotime($vaccine->created_at)) }}</span>
                                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#detailVaccine" data-action="Appointments.showAppointmentVaccine" data-action-event="click" data-action-args="{{ App\Models\User::encryptor('encrypt', $vaccine->id) }}" class="fw-medium text-decoration-none"><i class="fa-solid fa-eye me-1"></i>Ver</a>
                            </div>
                            @endforeach
                        @else
                            <div class="d-flex justify-content-between border-info-subtle small py-2">
                                <span>{{ trans('dash.label.not.prevVaccines') }}</span>
                            </div> 
                        @endif
                        <div class="d-flex justify-content-end">
                            <a class="btn btn-outline-primary btn-sm mt-2 mb-2" data-action="Appointments.setIdAppointmentToVaccine" data-action-event="click" data-action-args="{{ $appointment->id_pet }}|{{ $appointment->id_owner }}" data-bs-toggle="modal" data-bs-target="#addVaccine"><i class="fa-solid fa-plus me-2"></i>{{ trans('dash.label.add') }}</a>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                      <button class="accordion-button collapsed fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseDesp" aria-expanded="false" aria-controls="flush-collapseDesp">
                          {{ trans('dash.label.register.desparation') }}
                      </button>
                    </h2>
                    <div id="flush-collapseDesp" class="accordion-collapse collapse" data-bs-parent="#accordionData">
                      <div class="accordion-body pb-2 pt-2">
                          @if(count($desparats) > 0)
                              @foreach ($desparats as $desparat)
                              <div class="d-flex justify-content-between small py-1">
                                  <span>{{ $desparat->name }}, {{ date('d-m-Y', strtotime($desparat->created_at)) }}</span>
                                  <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#detailVaccine" data-action="Appointments.showAppointmentVaccine" data-action-event="click" data-action-args="{{ App\Models\User::encryptor('encrypt', $desparat->id) }}" class="fw-medium text-decoration-none"><i class="fa-solid fa-eye me-1"></i>Ver</a>
                              </div>
                              @endforeach
                          @else
                              <div class="d-flex justify-content-between border-info-subtle small py-2">
                                  <span>{{ trans('dash.label.not.prevDesparation') }}</span>
                              </div> 
                          @endif
                          <div class="d-flex justify-content-end">
                              <a class="btn btn-outline-primary btn-sm mt-2 mb-2" data-action="Appointments.setIdAppointmentToDesparat" data-action-event="click" data-action-args="{{ $appointment->id_pet }}|{{ $appointment->id_owner }}" data-bs-toggle="modal" data-bs-target="#addDesparation"><i class="fa-solid fa-plus me-2"></i>{{ trans('dash.label.add') }}</a>
                          </div>
                      </div>
                    </div>
                  </div>
                <div class="accordion-item">
                  <h2 class="accordion-header">
                    <button class="accordion-button collapsed fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                        {{ trans('dash.label.previous.recipes') }}
                    </button>
                  </h2>
                  <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionData">
                    <div class="accordion-body pb-2 pt-2">
                        @if(count($prevRecipes) > 0)
                            @foreach ($prevRecipes as $recipe)
                            <div class="d-flex justify-content-between small py-1">
                                <span>{{ date('d', strtotime($recipe->created_at)) . ' ' . strtolower(trans('dash.month.num' . (int)date('m', strtotime($recipe->created_at)))) . ', ' . date('Y', strtotime($recipe->created_at)) }}</span>
                                <a href="javascript:void(0);" data-action="Appointments.setIdAppointmentToShow" data-action-event="click" data-action-args="{{ $recipe->id }}" data-bs-toggle="modal" data-bs-target="#showRecipe" class="fw-medium text-decoration-none"><i class="fa-solid fa-eye me-1"></i>{{ trans('dash.label.btn.see') }}</a>
                            </div>
                            @endforeach
                        @else
                            <div class="d-flex justify-content-between border-info-subtle small py-2">
                                <span>{{ trans('dash.label.not.prevrecipes') }}</span>
                            </div> 
                        @endif
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h2 class="accordion-header">
                    <button class="accordion-button collapsed fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                        {{ trans('dash.label.dating.history') }}
                    </button>
                  </h2>
                  <div id="flush-collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionData">
                    <div class="accordion-body pb-2 pt-2">
                        @if(count($prevAppointments) > 0)
                            @foreach ($prevAppointments as $prevAppointment)
                            <div class="d-flex justify-content-between small py-2">
                                <span>{{ date('d', strtotime($prevAppointment->date)) . ' ' . strtolower(trans('dash.month.num' . (int)date('m', strtotime($prevAppointment->date)))) . ', ' . date('Y', strtotime($prevAppointment->date)) }}</span>
                                <a href="{{ route('appointment.view', App\Models\User::encryptor('encrypt', $prevAppointment->id)) }}" class="fw-medium text-decoration-none"><i class="fa-solid fa-eye me-1"></i>{{ trans('dash.label.btn.see') }}</a>
                            </div>
                            @endforeach
                        @else
                            <div class="d-flex justify-content-between border-info-subtle small py-2">
                                <span>{{ trans('dash.label.not.prevappointment') }}</span>
                            </div>
                        @endif
                    </div>
                  </div>
                </div>
            </div>

            <div class="mt-3">
                <button type="button" data-action="Appointments.setIdAppointmentToReminder" data-action-event="click" data-action-args="{{ $appointment->id }}|0|0|{{ $appointment->id_pet }}" data-bs-toggle="modal" data-bs-target="#reminderModal" class="btn btn-secondary btn-sm text-uppercase px-4 w-100">
                    {{ trans('dash.reminder.add') }}
                </button>
            </div>

        </div>
        <div class="d-flex order-2 flex-column flex-md-row gap-2 gap-md-4">
            <div class="d-none d-md-block">
                <i class="fa-solid fa-angle-right fa-fw fs-5 mt-1 text-white"></i>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="petEditModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="bookModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="fw-normal mb-0 text-secondary">{{ trans('dash.label.btn.edit.pet') }}</h6>
          <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-3 p-md-4">
            <form name="frmEditPet" id="frmEditPet" method="post" action="{{ route('pets.editPet') }}" enctype="multipart/form-data" data-action="Appointments.sendFormEdit" data-action-event="submit">
                @csrf

                <input type="hidden" name="petId" id="petId" value="{{ $pet->id }}">
                <div class="mb-3">
                    <label for="name" class="form-label small">{{ trans('dash.label.element.name.pet') }}</label>
                    <input type="text" name="name" id="name" value="{{ $pet->name }}" class="form-control fc requeridoEditPet">
                </div>

                <div class="mb-3">
                    <label for="animaltype" class="form-label small">{{ trans('dash.label.element.type.pet') }}</label>
                    <select name="animaltype" id="animaltype" class="form-select fc select4 requeridoEditPet" data-action="Appointments.getBreed" data-action-event="change">
                        <option value="">{{ trans('auth.register.complete.select') }}</option>
                        @foreach ($allTypes as $type)
                            <option value="{{ $type->id }}" @if($type->id == $pet->type) selected='selected' @endif>{{ $type['title_' . $weblang] }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="breed" class="form-label small">{{ trans('dash.label.element.breed') }}</label>
                    <select name="breed" id="breed" class="form-select fc select4 requeridoEditPet">
                        <option value="">{{ trans('auth.register.complete.select') }}</option>
                        @foreach ($allBreed as $breed)
                            <option value="{{ $breed->id }}" @if($breed->id == $pet->breed) selected='selected' @endif>{{ $breed['title_' . $weblang] }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="row row-cols-1 row-cols-md-2 mb-3 g-3">
                    <div class="col">
                        <label for="petage" class="form-label small">{{ trans('dash.label.element.birthdate') }}</label>
                        <input type="text" name="petage" id="petage" value="{{ $pet->age }}" class="form-control fc dDropper">
                    </div>
                    <div class="col">
                        <label class="form-label small d-block mb-2">{{ trans('dash.label.element.sex') }}</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="sex" id="sexmale" value="macho" @if($pet->gender == 'macho') checked @endif>
                            <label class="form-check-label" for="sexmale">
                                {{ trans('dash.label.element.sex.male') }}
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="sex" id="sexfemale" value="hembra" @if($pet->gender == 'hembra') checked @endif>
                            <label class="form-check-label" for="sexfemale">
                                {{ trans('dash.label.element.sex.female') }}
                            </label>
                        </div>
                    </div>
                    <div class="col">
                        <label for="color" class="form-label small">Color</label>
                        <input type="text" name="color" id="color" value="{{ $pet->color }}" class="form-control fc">
                    </div>
                    <div class="col">
                        <label class="form-label small d-block mb-2">{{ trans('dash.label.element.sterilized') }}</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="castrated" id="castratedyes" value="1" @if($pet->castrate == 1) checked @endif>
                            <label class="form-check-label" for="castratedyes">
                                {{ trans('dash.label.yes') }}
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="castrated" id="castratedno" value="0" @if($pet->castrate == 0) checked @endif>
                            <label class="form-check-label" for="castratedno">
                                {{ trans('dash.label.not') }}
                            </label>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="feeding" class="form-label small">{{ trans('dash.label.element.food') }}</label>
                    <input type="text" name="feeding" id="feeding" value="{{ $pet->alimentation }}" class="form-control fc">
                </div>
                <div class="mb-3">
                    <label for="blood" class="form-label small">{{ trans('dash.label.element.blood') }}</label>
                    <select id="blood" name="blood" class="form-select fc">
                        <option value="" selected>{{ trans('dash.label.selected') }}</option>
                        <option value="A+" @if ($pet->blood == "A+") selected @endif>A+</option>
                        <option value="O+" @if ($pet->blood == "O+") selected @endif>O+</option>
                        <option value="B+" @if ($pet->blood == "B+") selected @endif>B+</option>
                        <option value="AB+" @if ($pet->blood == "AB+") selected @endif>AB+</option>
                        <option value="A-" @if ($pet->blood == "A-") selected @endif>A-</option>
                        <option value="O-" @if ($pet->blood == "O-") selected @endif>O-</option>
                        <option value="B-" @if ($pet->blood == "B-") selected @endif>B-</option>
                        <option value="AB-" @if ($pet->blood == "AB-") selected @endif>AB-</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="disease" class="form-label small">{{ trans('dash.label.element.disease') }}</label>
                    <input type="text" name="disease" id="disease" value="{{ $pet->disease }}" class="form-control fc">
                </div>

                <div class="form-check mt-4">
                    <input class="form-check-input" type="checkbox" value="1" id="deadFlag" name="deadFlag" @if($pet->dead_flag == 1) checked @endif>
                    <label class="form-check-label" for="deadFlag">
                        <span class="ms-1">{{ trans('dash.label.element.dead') }}</span>
                        <i class="fa-solid fa-ribbon ms-1 opacity-50"></i>
                    </label>
                </div>
                
            </form>
        </div>
        <div class="modal-footer px-3 px-md-4 pb-3 pb-md-4 pt-0">
          <button data-action="Appointments.sendFormEditValidate" data-action-event="click" id="agendarBtn" type="button" class="btn btn-primary btn-sm fw-medium px-4">{{ trans('dash.text.btn.save') }}</button>
        </div>
      </div>
    </div>
</div>

@include('elements.footer')
@include('elements.appointmodals', ['Modalrecipe' => true, 'Modalattach' => true, 'ModalsendRecipe' => true, 'Modalnote' => true, 'Modalcancel' => true, 'ModalrecipeEdit' => true, 'ModalAddVaccine' => true, 'ModalAddDesparat' => true, 'ModalShowRecipe' => true, 'Modalreminder' => true, 'ModalsendAttach' => true, 'PhysicalExam' => true])

@endsection

@push('scriptBottom')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('js/front/datedropper.js') }}"></script>

<link rel="stylesheet" href="{{ asset('css/wpanel/library/jquery.toast.css') }}">
<script src="{{ asset('js/wpanel/library/jquery.toast.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    window.APPOINTMENTS_START_CONFIG = {
        appointmentId: @json($appointment->id),
        routes: {
            update: @json(route('appointment.update')),
            deleteAttach: @json(route('appoinment.deleteAttach')),
            deleteRecipe: @json(route('appoinment.deleteRecipe')),
            finish: @json(route('appoinment.finish')),
            invoiceCreate: @json(route('invoice.create')),
            index: @json(route('appointment.index')),
            getBreed: @json(route('get.breed'))
        },
        texts: {
            updateSuccess: @json(trans('dash.msg.update.appoinment')),
            updateError: @json(trans('dash.msg.error.appoinment')),
            deleteAttachTitle: @json(trans('dash.msg.delete.attach')),
            deleteAttachConfirm: @json(trans('dash.msg.confir.delete.attach')),
            deleteYes: @json(trans('dash.label.yes.delete')),
            cancelNo: @json(trans('dash.label.no.cancel')),
            deleteAttachPermError: @json(trans('dash.msg.error.perm.attach')),
            deleteAttachError: @json(trans('dash.msg.error.delete.attach')),
            deleteRecipeTitle: @json(trans('dash.msg.delete.appoinment')),
            deleteRecipeConfirm: @json(trans('dash.msg.confir.delete.appoinment')),
            deleteRecipePermError: @json(trans('dash.msg.error.perm.appoinment')),
            deleteRecipeError: @json(trans('dash.msg.error.delete.appoinment')),
            finishTitle: @json(trans('dash.msg.finish.appoinment')),
            finishConfirm: @json(trans('dash.msg.confir.finish.appoinment')),
            finishConfirmInvoice: @json(trans('dash.msg.confir.finish.appoinment.invoice')),
            finishYes: @json(trans('dash.label.yes.finish')),
            finishError: @json(trans('dash.msg.error.finish.appoinment')),
            fieldsRequired: @json(trans('dash.label.fields.required')),
            select: @json(trans('auth.register.complete.select')),
            otherLabel: 'Otro'
        },
        selectors: {
            recipeModal: '#recipeModal',
            addVaccineModal: '#addVaccine',
            addDesparationModal: '#addDesparation'
        }
    };
</script>
<script src="{{ asset('js/appointments/start/core.js') }}"></script>
<script src="{{ asset('js/appointments/start/ui.js') }}"></script>
<script src="{{ asset('js/appointments/start/attachments.js') }}"></script>
<script src="{{ asset('js/appointments/start/vaccines.js') }}"></script>
<script src="{{ asset('js/appointments/start/recipe.js') }}"></script>
@endpush
