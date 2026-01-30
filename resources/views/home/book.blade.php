@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

    @include('elements.ownermenu')

    <section class="container-fluid pb-0 pb-lg-5">

        <div class="row px-0 px-lg-3 mt-2 mt-lg-4 mx-auto col-xl-11 col-xxl-9">

            <div class="col-md-6 col-xl-4 mx-auto px-2">
                <div class="card rounded-3 border-2 border-secondary">
                    <div class="card-body p-3 p-lg-4">
                        @php
                            $photo = asset('img/default2.png');
                            if($doctor->photo != '') {
                                $photo = asset($doctor->photo);
                            }
                        @endphp
                        <div class="petPhoto2 rounded-circle mx-auto" style="background-image: url({{ $photo }});"></div>
                        <h1 class="h3 text-center mt-2 mb-0">{{ $doctor->name }}</h1>
                        <p class="text-center mb-2 small">{{ (isset($doctor['getVet']['company'])) ? $doctor['getVet']['company'] : '' }}</p>
                        <ul class="list-group justify-content-center list-group-flush mt-3 small">
                            <li class="list-group-item d-flex px-0">
                                <i class="fa-solid fa-id-card fa-fw me-2 mt-1 text-primary"></i>
                                <span>
                                    {{ $doctor->code }}
                                    <small class="d-block opacity-75">{{ trans('dash.label.college') }}</small>
                                </span>
                            </li>
                            
                            @if($ubication != '')
                            <li class="list-group-item d-flex px-0">
                                <i class="fa-solid fa-location-dot fa-fw me-2 mt-1 text-primary"></i>
                                <span>{{ $ubication }}</span>
                                {{-- <a href="javascript:void(0);" class="ms-3 fw-medium">Ver mapa</a> --}}
                            </li>
                            @endif

                            @if((isset($doctor['getVet']['address']))&&($doctor['getVet']['address'] != ''))
                            <li class="list-group-item d-flex px-0">
                                <i class="fa-solid fa-map fa-fw me-2 mt-1 text-primary"></i>
                                <span>{{ (isset($doctor['getVet']['address'])) ? $doctor['getVet']['address'] : '' }}</span>
                            </li>
                            @endif
                            {{-- <li class="list-group-item px-0"><i class="fa-solid fa-receipt fa-fw me-2 text-primary"></i>¢25.000</li> --}}
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-8 mt-4 mt-xl-0 ps-xl-5">

                @php
                    $dayselected  = date("d", strtotime($date));
                    $montselected = date("m", strtotime($date));
                    $yearselected = date("Y", strtotime($date));

                    $firstYear = date('Y');
                    $totalDays = date("t", strtotime($date));
                    $dayminus = date('Y-m-d', strtotime('-1 day', strtotime($date)));
                    $dayplus  = date('Y-m-d', strtotime('+1 day', strtotime($date)));
                @endphp

                <h2 class="h5 fw-medium text-primary text-center mb-3">{{ trans('dash.label.availability') }}</h2>
                
                <div class="col-lg-5 mx-lg-auto">
                    <label class="form-label small">{{ trans('dash.label.date') }}</label>
                    <input type="text" name="dateShow" id="dateShow" class="form-control fc dDropper" value="{{ $dayselected.'/'.$montselected.'/'.$yearselected.'' }}">
                </div>

                <div class="row mt-3 mt-md-4">
                    @if(count($hours) > 0)
                        @foreach ($hours as $hour)
                            <div class="col-6 col-sm-4 col-lg-3 p-2">
                                <a href="javascript:void(0);" data-id="{{ $hour->id }}" data-action="Home.selectedHour" data-action-event="click" data-action-args="$el" class="selectDays d-block">{{ date('h:i A', strtotime($hour->hour)) }}</a>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12">
                            <div class="alert alert-warning text-center mb-2" role="alert">
                                <i class="fa-solid fa-triangle-exclamation opacity-50 me-2"></i>{{ trans('dash.label.no.schedule') }}
                            </div>
                        </div>
                    @endif
                    
                    <div class="col-12 p-2 text-center">
                        <button class="btn btn-outline-primary px-5 mt-2" data-action="Home.reserveHour" data-action-event="click">{{ trans('dash.label.btn.continue') }}</button>
                    </div>
                </div>

            </div>
        </div>

    </section>

    @include('elements.footer')

    <div class="modal fade" id="bookModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="bookModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h6 class="fw-normal mb-0 text-secondary">{{ trans('dash.label.data.appoinment') }}</h6>
              <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 p-md-4">
                <form name="frmUploaderAppoinment" id="frmUploaderAppoinment" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="hourSelected" id="hourSelected" value="0">
                    <input type="hidden" name="petSelected" id="petSelected" value="0">
                    <input type="hidden" name="imageSelected" id="imageSelected" value="0">
                    <input type="hidden" name="doctor" id="doctor" value="{{ $vet_id }}">

                    <p class="form-label mb-2">{{ trans('dash.label.select.pet') }}</p>
                    
                    <div class="row row-cols-1 row-cols-sm-2 g-2 g-md-3 mb-3">
                        @foreach ($pets as $pet)
                            @php
                                $photo = asset('img/default.png');
                                if((isset($pet->photo)) && ($pet->photo != '')) {
                                    $photo = asset('files/' . $pet->photo);
                                }
                            @endphp
                            
                            <div class="col">
                                <a href="javascript:void(0);" data-id="{{ $pet->id }}" data-action="Home.selectedPet" data-action-event="click" data-action-args="$el" class="thispets fw-medium d-flex align-items-center gap-2 position-relative w-100 text-decoration-none rounded-3 border border-2 border-secondary px-3 py-2">
                                    <span class="petPhoto d-inline-block rounded-circle" style="background-image: url({{ $photo }})"></span>
                                    <span>{{ $pet->name }}</span>
                                </a>
                            </div>

                        @endforeach
                    </div>

                    <div class="mb-3" @if($doctor->rol_id == 6) style="display: none;" @endif>
                        <textarea class="form-control fc" id="reason" name="reason" rows="1" placeholder="{{ trans('dash.label.reason') }}">{{ ($doctor->rol_id == 6) ? 'Grooming' : '' }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="bookAttach" class="form-label mb-2">{{ trans('dash.label.attachments') }} ({{ trans('dash.label.optional') }})</label>
                        <input class="form-control" type="file" id="bookAttach" name="bookAttach[]" style="padding: .375rem .75rem;" multiple>
                    </div>

                    @if($doctor->rol_id == 6)
                    <div class="mb-3">
                        <label class="form-label">{{ trans('dash.label.element.breed') }}</label>
                        <select class="form-select fc" id="breed" name="breed" aria-label="Select" data-action="Home.changeBreed" data-action-event="change" data-action-args="$el">
                            <option selected>{{ trans('dash.label.selected') }}</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">{{ trans('dash.label.element.select.cut') }}</label>
                        <div class="row row-cols-1 row-cols-sm-2 g-2 g-md-3 mb-3" id="containerGrooming">
                            
                            <div class="col">
                                <a href="javascript:void(0);" data-id="0" data-action="Home.selectedImage" data-action-event="click" data-action-args="$el" class="thisimages fw-medium d-flex align-items-center gap-2 position-relative w-100 text-decoration-none rounded-3 border border-2 border-secondary px-3 py-2">
                                    <span class="petPhoto d-inline-block rounded-circle" style="background-image: url({{ asset('img/default.png') }})"></span>
                                    <span>{{ trans('dash.label.other') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3" id="containerGroomingText" style="display: none;">
                        <label class="form-label">{{ trans('dash.label.element.select.cut.other') }}</label>
                        <input type="text" name="grooming_personalize" id="grooming_personalize" value="" class="form-control fc" maxlength="254">
                    </div>
                    @endif

                </form>
            </div>
            <div class="modal-footer px-3 px-md-4 pb-3 pb-md-4 pt-0">
              <button id="agendarBtn" data-action="Home.sendAppointment" data-action-event="click" type="button" class="btn btn-primary btn-sm fw-medium px-4">{{ trans('dash.label.title.schedule') }}</button>
            </div>
          </div>
        </div>
    </div>
      
@endsection

@push('scriptBottom')
    <link rel="stylesheet" href="{{ asset('css/wpanel/library/jquery.toast.css') }}">
    <script src="{{ asset('js/wpanel/library/jquery.toast.js') }}"></script>
    <script src="{{ asset('js/front/datedropper.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        window.HOME_BOOK_CONFIG = {
            vetId: @json($vet_id),
            doctorRoleId: @json((int) $doctor->rol_id),
            doctorVetId: @json($doctor->id_vet),
            assetsBase: @json(asset('/')),
            routes: {
                reserveHour: @json(route('appoinment.reserveHour')),
                getPetData: @json(route('search.getPetData')),
                getPetDataImages: @json(route('search.getPetDataImages')),
                saveBook: @json(route('search.saveBook'))
            },
            urls: {
                bookHoursBase: @json(url('book/hours')),
                bookMessageBase: @json(url('book-message'))
            },
            texts: {
                hourNotAvailable: @json(trans('dash.msg.error.hour.not.available')),
                hourNotChoose: @json(trans('dash.hour.not.choose')),
                petNotChoose: @json(trans('dash.pet.not.choose')),
                imageNotChoose: @json(trans('dash.image.not.choose')),
                imageNotChoosePersonalize: @json(trans('dash.image.not.choose.personalize')),
                extNotValid: @json(trans('dash.msg.ext.not.valid')),
                appointmentSaveError: @json(trans('dash.msg.error.appoinment.save')),
                selectedLabel: @json(trans('dash.label.selected'))
            }
        };
    </script>
    <script src="{{ asset('js/home/book.js') }}"></script>
@endpush
