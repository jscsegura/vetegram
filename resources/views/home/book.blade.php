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
                                <a href="javascript:void(0);" data-id="{{ $hour->id }}" onclick="selectedHour(this);" class="selectDays d-block">{{ date('h:i A', strtotime($hour->hour)) }}</a>
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
                        <button class="btn btn-outline-primary px-5 mt-2" onclick="reserveHour();">{{ trans('dash.label.btn.continue') }}</button>
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
                                <a href="javascript:void(0);" data-id="{{ $pet->id }}" onclick="selectedPet(this);" class="thispets fw-medium d-flex align-items-center gap-2 position-relative w-100 text-decoration-none rounded-3 border border-2 border-secondary px-3 py-2">
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
                        <select class="form-select fc" id="breed" name="breed" aria-label="Select" onchange="changeBreed(this);">
                            <option selected>{{ trans('dash.label.selected') }}</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">{{ trans('dash.label.element.select.cut') }}</label>
                        <div class="row row-cols-1 row-cols-sm-2 g-2 g-md-3 mb-3" id="containerGrooming">
                            
                            <div class="col">
                                <a href="javascript:void(0);" data-id="0" onclick="selectedImage(this);" class="thisimages fw-medium d-flex align-items-center gap-2 position-relative w-100 text-decoration-none rounded-3 border border-2 border-secondary px-3 py-2">
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
              <button id="agendarBtn" onclick="sendAppointment();" type="button" class="btn btn-primary btn-sm fw-medium px-4">{{ trans('dash.label.title.schedule') }}</button>
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
        new dateDropper({
            selector: '.dDropper',
            format: 'dd/mm/y',
            expandable: true,
            showArrowsOnHover: true,
            onDropdownExit: changeDate
        })

        function selectedHour(obj) {
            var id = $(obj).attr('data-id');

            $('#hourSelected').val(id);

            $('.deleteD').remove();
            $('.selectDays').removeClass('active');
            $(obj).addClass('active');
            $(obj).append('<span class="deleteD" onclick="removeSelected(event);"><i class="fa-solid fa-minus"></i></span>');
        }

        function removeSelected(event) {
            event.stopPropagation();
            $('#hourSelected').val(0);

            $('.deleteD').remove();
            $('.selectDays').removeClass('active');
        }

        let userid = '{{ $vet_id }}';
        function changeDate(option) {
            
            var date = $('#dateShow').val();
            var parts = date.split('/');
            date = parts[2] + '-' + parts[1] + '-' + parts[0];
      
            setCharge();

            location.href = '{{ url('book/hours') }}/' + userid + '/' + btoa(date);
        }

        function reserveHour() {
            var hourid = $('#hourSelected').val();

            if(hourid > 0) {
                setCharge();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
                    }
                });
                
                $.post('{{ route('appoinment.reserveHour') }}', {id:hourid},
                    function (data){
                        if(data.reserve != '1') {
                            $.toast({
                                text: '{{ trans('dash.msg.error.hour.not.available') }}',
                                position: 'bottom-right',
                                textAlign: 'center',
                                loader: false,
                                hideAfter: 4000,
                                icon: 'warning'
                            });
                        }
                        if(data.reserve == '1') {
                            $('#bookModal').modal('show');
                        }
                        hideCharge();
                    }
                );
            }else{
                $.toast({
                    text: '{{ trans('dash.hour.not.choose') }}',
                    position: 'bottom-right',
                    textAlign: 'center',
                    loader: false,
                    hideAfter: 4000,
                    icon: 'error'
                });
            }
        }

        var assets = '{{ asset('/') }}';
        function selectedPet(obj) {
            var id = $(obj).attr('data-id');
            var id_vet = '{{ $doctor->id_vet }}';

            $('#petSelected').val(id);

            $('.unselectPet').remove();
            $('.thispets').removeClass('border-info');
            $('.thispets').addClass('border-secondary');

            $(obj).removeClass('border-secondary');
            $(obj).addClass('border-info');

            $(obj).append('<span class="unselectPet" onclick="removeSelectedPet(event);"><i class="fa-solid fa-minus"></i></span>');

            @if($doctor->rol_id == 6)
                $('.containerImg').remove();

                $.post('{{ route('search.getPetData') }}', {id:id, id_vet:id_vet},
                    function (data){
                        var options = '<option selected>{{ trans('dash.label.selected') }}</option>';
                        var optionSelect = '';

                        $.each(data.breeds, function(i, item) {
                            if(item.id == data.breedSelected) {
                                optionSelect = 'selected';
                            }else{
                                optionSelect = '';
                            }
                            options = options + '<option value="'+item.id+'" '+optionSelect+'>'+item.title+'</option>';
                        });

                        var images = '';
                        $.each(data.images, function(i, item) {
                            images = images + '<div class="col containerImg">' +
                                '<a href="javascript:void(0);" data-id="'+item.id+'" onclick="selectedImage(this);" class="thisimages fw-medium d-flex align-items-center gap-2 position-relative w-100 text-decoration-none rounded-3 border border-2 border-secondary px-3 py-2">' +
                                    '<span class="petPhoto d-inline-block rounded-circle" style="background-image: url('+assets+item.image+')"></span>' +
                                    '<span>'+item.title+'</span>' +
                                '</a>' +
                            '</div>';
                        });
                        
                        $('#breed').html(options);
                        $('#containerGrooming').prepend(images);
                    }
                );
            @endif
        }

        function selectedImage(obj) {
            var id = $(obj).attr('data-id');

            $('#imageSelected').val(id);

            $('.unselectImage').remove();
            $('.thisimages').removeClass('border-info');
            $('.thisimages').addClass('border-secondary');

            $(obj).removeClass('border-secondary');
            $(obj).addClass('border-info');

            $(obj).append('<span class="unselectImage" onclick="removeSelectedImage(event);"><i class="fa-solid fa-minus"></i></span>');

            const estilosOriginal = getComputedStyle(document.querySelector('.unselectPet'));
            const claseDestino = document.querySelector('.unselectImage');

            for (const propiedad in estilosOriginal) {
                if (typeof estilosOriginal[propiedad] === 'string' && estilosOriginal[propiedad] !== '') {
                    claseDestino.style[propiedad] = estilosOriginal[propiedad];
                }
            }

            if(id == 0) {
                $('#containerGroomingText').show();
            }else{
                $('#containerGroomingText').hide();
            }
        }

        function changeBreed (obj) {
            var id = $(obj).val();

            $('.containerImg').remove();
            $.post('{{ route('search.getPetDataImages') }}', {id:id},
                function (data){
                    var images = '';
                    $.each(data.images, function(i, item) {
                        images = images + '<div class="col containerImg">' +
                            '<a href="javascript:void(0);" data-id="'+item.id+'" onclick="selectedImage(this);" class="thisimages fw-medium d-flex align-items-center gap-2 position-relative w-100 text-decoration-none rounded-3 border border-2 border-secondary px-3 py-2">' +
                                '<span class="petPhoto d-inline-block rounded-circle" style="background-image: url('+assets+item.image+')"></span>' +
                                '<span>'+item.title+'</span>' +
                            '</a>' +
                        '</div>';
                    });
                    
                    $('#containerGrooming').prepend(images);
                }
            );
        }

        function removeSelectedPet() {
            event.stopPropagation();
            $('#petSelected').val(0);

            $('.unselectPet').remove();
            $('.thispets').removeClass('border-info');
            $('.thispets').addClass('border-secondary');
        }

        function removeSelectedImage() {
            event.stopPropagation();
            $('#imageSelected').val('');

            $('.unselectImage').remove();
            $('.thisimages').removeClass('border-info');
            $('.thisimages').addClass('border-secondary');
        }

        function sendAppointment() {
            var hour = $('#hourSelected').val();
            var pet  = $('#petSelected').val();
            var reason = $('#reason').val();

            var extValid = ['.jpg','.JPG','.jpeg','.JPEG','.png','.PNG','.gif','.GIF','.pdf','.PDF','.mp3','.mp4','.avi','.zip','.rar','.doc','.docx','.ppt','.pptx','.pptm','.pps','.ppsm','.ppsx','.xls','.xlsx'];
  
            var names = [];
            var isvalid = true;
            var counter = 0;
            for (var i = 0; i < $('#bookAttach').get(0).files.length; ++i) {
                var name = $('#bookAttach').get(0).files[i].name;
                names.push(name);
        
                var extension = name.substring(name.lastIndexOf("."));
                var position = jQuery.inArray(extension, extValid);
                if(position == -1) {
                    isvalid = false;
                    
                    $.toast({
                        text: '{{ trans('dash.msg.ext.not.valid') }}',
                        position: 'bottom-right',
                        textAlign: 'center',
                        loader: false,
                        hideAfter: 4000,
                        icon: 'warning'
                    });
                }
        
                counter++;
            }

            if(hour == 0) {
                $.toast({
                    text: '{{ trans('dash.hour.not.choose') }}',
                    position: 'bottom-right',
                    textAlign: 'center',
                    loader: false,
                    hideAfter: 4000,
                    icon: 'error'
                });
                isvalid = false;
            }
            if(pet == 0) {
                $.toast({
                    text: '{{ trans('dash.pet.not.choose') }}',
                    position: 'bottom-right',
                    textAlign: 'center',
                    loader: false,
                    hideAfter: 4000,
                    icon: 'error'
                });
                isvalid = false;
            }

            @if($doctor->rol_id == 6)
            if($('#imageSelected').val() == '') {
                $.toast({
                    text: '{{ trans('dash.image.not.choose') }}',
                    position: 'bottom-right',
                    textAlign: 'center',
                    loader: false,
                    hideAfter: 4000,
                    icon: 'error'
                });
                isvalid = false;
            }
            if($('#imageSelected').val() == '0') {
                if($('#grooming_personalize').val() == '') {
                    $.toast({
                        text: '{{ trans('dash.image.not.choose.personalize') }}',
                        position: 'bottom-right',
                        textAlign: 'center',
                        loader: false,
                        hideAfter: 4000,
                        icon: 'error'
                    });
                    isvalid = false;
                }
            }
            @endif

            if(isvalid) {
                setCharge2();
        
                var peticion = $.ajax({
                    url: '{{ route('search.saveBook') }}',
                    type: 'POST',
                    data: new FormData(document.getElementById('frmUploaderAppoinment')),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data, status, xhr) {
                        
                        if(data.save == 1) {
                            location.href = '{{ url('book-message') }}/' + data.id;
                        }else{
                            $.toast({
                                text: data.error,
                                position: 'bottom-right',
                                textAlign: 'center',
                                loader: false,
                                hideAfter: 4000,
                                icon: 'error'
                            });
                        }
            
                        hideCharge2();
                    },
                    error: function(xhr, status, error) {
                        $.toast({
                            text: '{{ trans('dash.msg.error.appoinment.save') }}',
                            position: 'bottom-right',
                            textAlign: 'center',
                            loader: false,
                            hideAfter: 4000,
                            icon: 'error'
                        });
            
                        hideCharge2();
                    }
                });
            }
        }
    </script>
@endpush