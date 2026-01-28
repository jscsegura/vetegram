@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@include('elements.docmenu')

@php $weblang = \App::getLocale(); @endphp

<section class="container-fluid pb-0 pb-lg-4 px-xxl-5">
    <div class="row px-2 px-lg-3 mt-2 mt-lg-4">
        
        <div class="col-md-7 col-xl-3 mx-auto">
            @include('elements.petDetail')
        </div>
        
        <div class="col-12 col-xl-9 ps-xl-4 mt-2 mt-lg-0">

            @include('elements.topPet')

            @if(session('success'))
            <div class="alert alert-success small mt-3 mb-0" role="alert">
                {{ session('success') }}
            </div><br />
            @endif

            @if((Auth::guard('web')->user()->rol_id != 8) && ($credentials['access'] == false))
            <div class="alert alert-warning text-center mb-3 mb-md-4 small" role="alert">
                <i class="fa-solid fa-triangle-exclamation opacity-50 me-2"></i>{{ trans('dash.msg.page.limit.owners') }}
            </div>
            @endif

            <div class="d-flex flex-column flex-md-row justify-content-end align-items-center mb-2 mb-sm-3 gap-3 gap-md-4">
                @if($sectionVaccine == 1)
                    <p class="small text-center text-md-end lh-sm">
                        <i class="fa-solid fa-triangle-exclamation me-1 text-warning"></i>
                        <span class="opacity-75">{{ trans('dash.label.only.authorized.desparation') }}</span>
                    </p>
                    
                    @if((Auth::guard('web')->user()->rol_id != 8)&&($pet->dead_flag == 0))
                        <a href="javascript:void(0);" class="btn btn-secondary btn-sm px-4 text-uppercase" onclick="setIdAppointmentToDesparat('{{ $pet->id }}', '{{ $owner->id }}');" data-bs-toggle="modal" data-bs-target="#addDesparation"><i class="fa-solid fa-syringe me-2"></i>{{ trans('dash.label.add.desparation') }}</a>
                    @endif
                @else
                    <p class="small text-center text-md-end lh-sm">
                        <i class="fa-solid fa-triangle-exclamation me-1 text-warning"></i>
                        <span class="opacity-75">{{ trans('dash.label.only.authorized.vaccine') }}</span>
                    </p>
                    
                    @if((Auth::guard('web')->user()->rol_id != 8)&&($pet->dead_flag == 0))
                        <a href="javascript:void(0);" class="btn btn-secondary btn-sm px-4 text-uppercase" onclick="setIdAppointmentToVaccine('{{ $pet->id }}', '{{ $owner->id }}');" data-bs-toggle="modal" data-bs-target="#addVaccine"><i class="fa-solid fa-syringe me-2"></i>{{ trans('dash.label.add.vaccine') }}</a>
                    @endif
                @endif

                @if(Auth::guard('web')->user()->rol_id == 8)
                    <a href="javascript:void(0);" class="btn btn-secondary btn-sm px-4 text-uppercase" onclick="setIdExternalToEntryVaccine('{{ $pet->id }}');" data-bs-toggle="modal" data-bs-target="#addEntryVaccine"><i class="fa-solid fa-syringe me-2"></i>{{ trans('dash.label.add.vaccine.external') }}</a>
                @endif
            </div>
            
            <div class="card border-0 mb-0 mb-lg-5">
                <div class="card-body p-0">
                    @if(count($vaccines) > 0)

                    <table class="table mb-0 small align-middle rTable">
                        <thead>
                            <tr>
                                <th class="text-primary-emphasis text-uppercase fw-medium" style="width: 130px;"><small>{{ trans('dash.label.element.apply') }}</small></th>
                                <th class="text-primary-emphasis text-uppercase fw-medium"><small>{{ trans('dash.label.element.drug') }}</small></th>
                                <th class="text-primary-emphasis text-uppercase fw-medium text-center"><small>{{ trans('dash.label.element.brand') }}</small></th>
                                <th class="text-primary-emphasis text-uppercase fw-medium text-center"><small>{{ trans('dash.label.element.lot') }}</small></th>
                                <th class="text-primary-emphasis text-uppercase fw-medium text-center"><small>{{ trans('dash.label.element.expire') }}</small></th>
                                <th class="text-primary-emphasis text-uppercase fw-medium text-center"><small>{{ trans('dash.label.element.photo') }}</small></th>
                                <th class="text-primary-emphasis text-uppercase fw-medium text-center"><small>{{ trans('dash.label.element.professional') }}</small></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vaccines as $vaccine)
                                <tr>
                                    <td data-label="{{ trans('dash.label.element.apply') }}:" class="fw-medium py-1 py-md-3">{{ ($vaccine->date != '') ? date('d/m/Y', strtotime($vaccine->date)) : date('d/m/Y', strtotime($vaccine->created_at)) }}</td>
                                    <td data-label="{{ trans('dash.label.element.drug') }}:" class="py-1 py-md-3">{{ $vaccine->name }}</td>
                                    <td data-label="{{ trans('dash.label.element.brand') }}:" class="py-1 py-md-3 text-center">{{ ($vaccine->brand != '') ? $vaccine->brand : 'NA' }}</td>
                                    <td data-label="{{ trans('dash.label.element.lot') }}:" class="py-1 py-md-3 text-center">{{ ($vaccine->batch != '') ? $vaccine->batch : 'NA' }}</td>
                                    <td data-label="{{ trans('dash.label.element.expire') }}:" class="py-1 py-md-3 text-center">{{ ($vaccine->expire != '') ? date('d/m/Y', strtotime($vaccine->expire)) : 'NA' }}</td>
                                    <td data-label="{{ trans('dash.label.element.photo') }}:" class="py-1 py-md-3 text-center">
                                        @if($vaccine->photo != '')
                                        <img src="{{ asset($vaccine->photo) }}" alt="Vacuna" class="vaccineImg">
                                        @endif
                                    </td>
                                    <td data-label="{{ trans('dash.label.element.professional') }}:" class="py-1 py-md-3 text-center">
                                        <p class="d-inline-block">{{ (isset($vaccine['getDoctor']['name'])) ? $vaccine['getDoctor']['name'] : $vaccine->doctor_name }}</p><br>
                                        @if((isset($vaccine['getDoctor']['signature'])) && ($vaccine['getDoctor']['signature'] != ''))
                                        <img src="{{ $vaccine['getDoctor']['signature'] }}" alt="Firma" class="vaccineImg">
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                        @if($sectionVaccine == 1)
                            <div>
                                <p class="mb-0 text-center"><i class="fa-regular fa-circle-xmark me-2 opacity-75"></i>{{ trans('dash.label.not.desparation') }}</p>
                            </div>
                        @else
                            <div>
                                <p class="mb-0 text-center"><i class="fa-regular fa-circle-xmark me-2 opacity-75"></i>{{ trans('dash.label.not.vaccine') }}</p>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@include('elements.footer')
@if($sectionVaccine == 1)
    @include('elements.appointmodals', ['ModalAddDesparat' => true, 'ModalExternalAddVaccine' => true, 'Modalreminder' => true])
@else
    @include('elements.appointmodals', ['ModalAddVaccine' => true, 'ModalExternalAddVaccine' => true, 'Modalreminder' => true])
@endif

@endsection

@push('scriptBottom')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/wpanel/library/jquery.toast.css') }}">
<script src="{{ asset('js/wpanel/library/jquery.toast.js') }}"></script>
<script src="{{ asset('js/front/datedropper.js') }}"></script>

<script>
    const miDiv = document.getElementById('wrapPtabs');
    miDiv.scrollLeft = miDiv.scrollWidth - miDiv.clientWidth;

    new dateDropper({
        selector: '.dDropper',
        format: 'd/m/y',
        expandable: true,
        showArrowsOnHover: true
    })

    $('.select4').select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        dropdownParent: $('#petEditModal')
    });

    $('.select5').select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        dropdownParent: $('#addVaccine')
    });

    $('.select6').select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        dropdownParent: $('#addDesparation')
    });
</script>
@endpush