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
                
                <form id="frmVaccineModaladd" name="frmVaccineModaladd" action="" enctype="multipart/form-data" method="post" onsubmit="return false;">
                    @csrf

                    <input type="hidden" id="vaccineOffline" name="vaccineOffline" value="{{ $id }}">

                    <div class="mb-3">
                        <label for="doctorName" class="form-label small">{{ trans('dash.label.element.name') }}</label>
                        <input type="text" class="form-control fc requeridoAddVaccine" name="doctorName" id="doctorName" value="{{ $nameDoctor }}" @if($nameDoctor != '') onfocus="blur();" @endif>
                    </div>

                    <div class="mb-3">
                        <label for="doctorId" class="form-label small">{{ trans('dash.label.element.code') }}</label>
                        <input type="text" class="form-control fc requeridoAddVaccine" name="doctorId" id="doctorId" value="{{ $codeDoctor }}" @if($codeDoctor != '') onfocus="blur();" @endif onkeydown="enterOnlyNumbers(event);">
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

                    <button type="button" onclick="saveToCreateVaccine();" class="btn btn-primary px-4">{{ trans('dash.text.btn.save') }}</button>
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
        new dateDropper({
            selector: '.dDropper',
            format: 'd/m/y',
            expandable: true,
            showArrowsOnHover: true
        })

        function saveToCreateVaccine() {
            var validate = true;

            $('.requeridoAddVaccine').each(function(i, elem){
                var value = $(elem).val();
                var value = value.trim();
                if(value == ''){
                    $(elem).addClass('is-invalid');
                    validate = false;
                }else{
                    $(elem).removeClass('is-invalid');
                }
            });
            
            if(validate == true) {
                setCharge();

                $.ajax({
                    url: '{{ route('appoinment.createVaccine') }}',
                    type: 'POST',
                    data: new FormData(document.getElementById('frmVaccineModaladd')),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data, status, xhr) {  
                        hideCharge();
                        if(data.type == 200) {
                            const swalWithBootstrapButtons = Swal.mixin({
                                customClass: {
                                    confirmButton: 'btn btn-primary btn-sm text-uppercase px-4 marginleft20',
                                    cancelButton: 'btn btn-danger btn-sm text-uppercase px-4'
                                },
                                buttonsStyling: false
                            });

                            swalWithBootstrapButtons.fire({
                                title: '{{ trans('dash.msg.save.vaccine') }}',
                                text: '{{ trans('dash.msg.save.vaccine.success') }}',
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonText: 'Ok'
                            }).then((result) => {
                                location.reload();
                            });
                        }else{
                            $.toast({
                                text: '{{ trans('dash.msg.error.save.vaccine') }}',
                                position: 'bottom-right',
                                textAlign: 'center',
                                loader: false,
                                hideAfter: 4000,
                                icon: 'warning'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        $.toast({
                            text: '{{ trans('dash.msg.error.create.vaccine') }}',
                            position: 'bottom-right',
                            textAlign: 'center',
                            loader: false,
                            hideAfter: 4000,
                            icon: 'error'
                        });

                        hideCharge();
                    }
                });
            }
        }

        function enterOnlyNumbers(event){
            if ( event.keyCode == 8 || event.keyCode == 9 || (event.keyCode >= 37 && event.keyCode <= 40) || event.keyCode == 188 || event.keyCode == 190 ) {
            } else {
                if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                    event.preventDefault();
                }
            }
        }
    </script>
@endpush
