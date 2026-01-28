@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@include('elements.docmenu')

@php $weblang = \App::getLocale(); @endphp

<section class="container-fluid pb-0 pb-lg-4">
    <div class="row px-2 px-lg-3 mt-2 mt-lg-4">
        
        <form name="frmAddAppointment" id="frmAddAppointment" action="{{ route('appointment.store') }}" method="post" onsubmit="return validate();"  enctype="multipart/form-data" class="col-lg-10 col-xl-8 col-xxl-6 mx-auto mt-4 mt-lg-0 mb-lg-5">
            <h1 class="h4 text-uppercase text-center text-md-start fw-normal mb-3">{{ trans('dash.label.add') }} <span class="text-info fw-bold">{{ trans('dash.label.apointment') }}</span></h1>

            @csrf

            <input type="hidden" name="idvet" id="idvet" value="{{ $user->id_vet }}">

            <div class="d-flex flex-md-row gap-2 gap-md-4 justify-content-between mb-4">
                <div class="">
                    <i class="fa-solid fa-user fa-fw fs-5 text-primary mtIcon"></i>
                </div>
                <div class="flex-grow-1">
                    <label for="user" class="form-label small">{{ trans('dash.label.calendar') }}</label>
                    <select id="user" name="user" class="form-select fc select2 requerido" data-placeholder="{{ trans('dash.label.selected') }}" onchange="getHours('groomer');">
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
                        <select id="pet" name="pet" class="form-select fc select2 requerido" data-placeholder="{{ trans('dash.label.selected') }}" onchange="selectedPet();">
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
                        <input type="text" name="date" id="date" class="form-control fc dDropperHour requerido" onchange="getHours();" data-dd-opt-min-date="{{ date('Y/m/d') }}" size="14">
                    </div>
                    <div>
                        <label for="dtime" class="form-label small">{{ trans('dash.label.hour') }}</label>
                        <select id="hour" name="hour" class="form-select fc requerido" onchange="reserverHour(this);">
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
                    <input class="form-check-input" type="checkbox" value="1" id="addReminder" name="addReminder" onclick="setNotified();">
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
    $('.select2').select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
    });

    $('.select3').select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        dropdownParent: $('#recipeModal')
    });

    $('.select4').select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        dropdownParent: $('#createNewUser')
    });

    $('.select5').select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        dropdownParent: $('#createUserModal')
    });

    $('.select6').select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        dropdownParent: $('#createNewPet')
    });
    
    new dateDropper({
        selector: '.dDropperHour',
        format: 'd/m/y',
        expandable: true,
        showArrowsOnHover: true,
        onDropdownExit: getHours
    })

    new dateDropper({
        selector: '.dDropper',
        format: 'd/m/y',
        expandable: true,
        showArrowsOnHover: true
    })

    function setUrlDate () {
        var date = $('#date').val();

        if(date != '') {
            $('#urlToAvailable').attr('href', '{{ route('sett.edit') }}/' + btoa(date));
        }else{
            $('#urlToAvailable').attr('href', '{{ route('sett.edit') }}');
        }
    }

    function getHours(callGroomer = '') {
        var userid = $('#user').val();
        var date = $('#date').val();

        if((userid != '')&&(date != '')) {
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
                }
            });
            
            $.post('{{ route('appoinment.getHours') }}', {userid:userid, date:date},
                function (data){
                    var existHours = 0;
                    var htmlData = '';
                    var html = '<option value="">{{ trans('dash.label.selected') }}</option>';
                    $.each(data.rows, function(i, item) {
                        html = html + '<option value="'+item.id+'">'+item.hour+'</option>';
                        htmlData = htmlData + '<div class="col-6 col-sm-4 col-lg-3 p-2">' +
                                                '<a href="javascript:void(0);" data-id="'+item.id+'" onclick="selectedDay(this);" class="selectDays d-block thisAvailableDiv">'+convertirHora(item.hour)+'</a>' +
                                            '</div>';
                        existHours = 1;
                    });

                    if(existHours == 0) {
                        var html = '<option value="">{{ trans('dash.label.selected.notavailable') }}</option>';
                        htmlData = '{{ trans('dash.label.selected.notavailable') }}';
                    }

                    $('#hour').html(html);
                    $('.printerHoursAvailable').html(htmlData);
                }
            );
        }else{
            var html = '<option value="">{{ trans('dash.label.selected') }}</option>';
            $('#hour').html(html);
        }

        setUrlDate();

        if(callGroomer == 'groomer') {
            var rolid = $('#user').find('option:selected').attr('data-rol');
            if(rolid == 6) {
                $('#contGrooming').show();
                selectedPet();
            }else{
                $('#contGrooming').hide();
            }
        }
    }
    getHours('groomer');

    function selectedDay(obj) {
        var id = $(obj).attr('data-id');

        $('.thisAvailableDiv').removeClass('active');
        $(obj).addClass('active');

        $('#hour').val(id);
    }

    function reserverHour(obj) {
        var id = $(obj).val();
        if(id != '') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
                }
            });
            
            $.post('{{ route('appoinment.reserveHour') }}', {id:id},
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
                        getHours();
                    }
                }
            );
        }
    }

    function setNotified() {
        if($("#addReminder").prop("checked")) {
        	$('#containerNotified').show();
    	}else{
            $('#containerNotified').hide();
        }        
    }

    function validate() {
        var valid = true;

        var extValid = ['.jpg','.JPG','.jpeg','.JPEG','.png','.PNG','.gif','.GIF','.pdf','.PDF','.mp3','.mp4','.avi','.zip','.rar','.doc','.docx','.ppt','.pptx','.pptm','.pps','.ppsm','.ppsx','.xls','.xlsx'];
  
        $('.requerido').each(function(i, elem){
            var value = $(elem).val();
            var value = value.trim();
            if(value == ''){
                $(elem).addClass('is-invalid');
                valid = false;
            }else{
                $(elem).removeClass('is-invalid');
            }
        });

        if($("#addReminder").prop("checked")) {
        	$('.requeridoReminder').each(function(i, elem){
                var value = $(elem).val();
                var value = value.trim();
                if(value == ''){
                    $(elem).addClass('is-invalid');
                    valid = false;
                }else{
                    $(elem).removeClass('is-invalid');
                }
            });

            if(valid == true) {
                if($('#reminder_date').val() == '{{ date('j/n/Y') }}') {
                    var horaInput = $("#reminder_time").val();
                    var horaActual = new Date().toLocaleTimeString('en-US', {hour12: false, hour: '2-digit', minute: '2-digit'});
      
                    var tiempoEntrada = new Date('2000-01-01T' + horaInput);
                    var tiempoActual  = new Date('2000-01-01T' + horaActual);

                    if (tiempoEntrada < tiempoActual) {
                        $("#reminder_time").addClass('is-invalid');
                        valid = false;
                    }
                }
            }
    	}

        for (var i = 0; i < $('#fileModalMultiple').get(0).files.length; ++i) {
            var name = $('#fileModalMultiple').get(0).files[i].name;
    
            var extension = name.substring(name.lastIndexOf("."));
            var position = jQuery.inArray(extension, extValid);
            if(position == -1) {
                valid = false;
                
                $.toast({
                    text: '{{ trans('dash.msg.error.ext.file') }}',
                    position: 'bottom-right',
                    textAlign: 'center',
                    loader: false,
                    hideAfter: 4000,
                    icon: 'warning'
                });
            }
        }

        var showAlert = false;
        $('.requeridoModalMedicineAdd').each(function(i, elem){
            var value = $(elem).val();
            var value = value.trim();
            if(value == ''){
                $(elem).addClass('is-invalid');
                valid = false;
                showAlert = true;
            }else{
                $(elem).removeClass('is-invalid');
            }
        });

        if(showAlert == true) {
            $.toast({
                text: '{{ trans('dash.msg.error.recipe.fields') }}',
                position: 'bottom-right',
                textAlign: 'center',
                loader: false,
                hideAfter: 4000,
                icon: 'warning'
            });
        }

        var rolid = $('#user').find('option:selected').attr('data-rol');
        if(rolid == 6) {
            if($('#imageSelected').val() == '') {
                $.toast({
                    text: '{{ trans('dash.image.not.choose') }}',
                    position: 'bottom-right',
                    textAlign: 'center',
                    loader: false,
                    hideAfter: 4000,
                    icon: 'error'
                });
                valid = false;
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
                    valid = false;
                }
            }
        }

        if(valid == true) {
            setCharge();
            setLoad('btnSave', '{{ trans('dash.text.btn.save.process') }}');
        }

        return valid;
    }

    var medicines;
    var typesRecipe;
    function loadRecipeData() {
        var types = <?php echo json_encode($types); ?>;
        var medical = <?php echo json_encode($medicines); ?>;

        typesRecipe = '<option value="">{{ trans('dash.label.selected') }}</option>';
        $.each(types, function(i, item) {
          typesRecipe = typesRecipe + '<option value="'+item.id+'">'+item.title+'</option>';
        });

        medicines = '<option value=""></option>';
        $.each(medical, function(i, item) {
          medicines = medicines + '<option value="'+item.id+'" data-instruction="'+item.instructions+'">'+item.title+'</option>';
        });
    }
    loadRecipeData();

    function convertirHora(hora24) {
        var partes = hora24.split(':');
        var horas = parseInt(partes[0], 10);
        var minutos = partes[1];
        var segundos = partes[2];
        var periodo = horas >= 12 ? 'pm' : 'am';
        horas = horas % 12;
        horas = horas ? horas : 12; // El '0' debe convertirse en '12'
        return (horas < 10 ? '0' + horas : horas) + ':' + minutos + ' ' + periodo;
    }
</script>
@endpush