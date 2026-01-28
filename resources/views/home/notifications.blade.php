@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@include('elements.docmenu')

<section class="container-fluid pb-0 pb-lg-4">
    <div class="row px-2 px-lg-3 mt-2 mt-lg-4">

        <div class="col-lg-8 col-xl-7 col-xxl-6 mx-auto">
        
            <div class="d-flex align-items-center gap-3 mb-2">
                <h1 class="text-uppercase h4 fw-bold mb-0">{{ trans('dash.label.recordatorios') }}</h1>
                <button class="btn btn-secondary btn-sm text-uppercase px-4 ms-auto" onclick="setIdAppointmentToReminder('0', '1', '1');" data-bs-toggle="modal" data-bs-target="#reminderModal">{{ trans('dash.label.new') }}</button>
            </div>

            <ul class="list-group list-group-flush notList">
                @if(count($reminders) > 0)
                    @foreach ($reminders as $reminder)
                        <li class="list-group-item lh-sm py-3">
                            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                                <div>
                                    <span class="nPoint"></span>
                                    <span class="fw-medium">{{ $reminder->description }}</span>
                                    <span class="d-block small mt-1">{{ date('d', strtotime($reminder->date)) . ' ' . strtolower(trans('dash.month.num' . (int)date('m', strtotime($reminder->date)))) . ', ' . date('Y', strtotime($reminder->date)) }} <span class="mx-2">|</span> {{ date('h:ia', strtotime($reminder->date)) }} <span class="mx-2">|</span> {{ $reminder->to }}</span>
                                </div>
                                <div class="d-flex gap-2">
                                    <button data-id="{{ $reminder->id }}" onclick="setIdAppointmentToReminderEdit('{{ $reminder->id }}', '{{ $reminder->description }}', '{{ date('d/m/Y', strtotime($reminder->date)) }}', '{{ date('H:i', strtotime($reminder->date)) }}', '{{ date('Y/m/d', strtotime($reminder->date)) }}', '{{ $reminder->repeat }}', '{{ $reminder->period }}', '{{ $reminder->quantity }}')" data-bs-toggle="modal" data-bs-target="#reminderModalEdit" type="button" class="editBtn"><i class="fa-regular fa-pen-to-square"></i></button>
                                    <button data-id="{{ $reminder->id }}" onclick="deleteReminder(this);" type="button" class="deleteBtn"><i class="fa-regular fa-trash-can"></i></button>
                                </div>
                            </div>
                        </li>
                    @endforeach
                @else
                    <li class="list-group-item lh-sm py-3 read">
                        <div class="d-flex justify-content-between align-items-center gap-3">
                            <div>
                                <span class="fw-medium">{{ trans('dash.label.not.notifications') }}</span>
                            </div>
                        </div>
                    </li>
                @endif
            </ul>

        </div>

    </div>
</section>

<div class="modal fade" id="reminderModalEdit" tabindex="-1" aria-labelledby="reminderModalLabelEdit" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="fw-normal mb-0 text-secondary">{{ trans('dash.label.edit.reminder') }}</h6>
          <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-3 p-md-4">
            <input type="hidden" name="reminderIdEdit" id="reminderIdEdit" value="0">

            <div class="d-flex gap-3 mb-3 justify-content-start">
                <i class="fa-solid fa-align-left fa-fw mt-1"></i>
                <textarea class="form-control fc requeridoModalSetReminderEdit" id="reminderDetailModalEdit" name="reminderDetailModalEdit" rows="1" placeholder="Escribir"></textarea>
            </div>
            <div class="d-flex gap-3 mb-3 justify-content-start">
                <i class="fa-regular fa-clock fa-fw mt-1"></i>
                <div class="flex-grow-1">
                    <input type="text" class="form-control fc dDropperEdit requeridoModalSetReminderEdit" id="reminderDateModalEdit" name="reminderDateModalEdit" value="" data-dd-opt-min-date="{{ date('Y/m/d') }}" readonly>
                </div>
                <div>
                    <input type="time" class="form-control fc requeridoModalSetReminderEdit" id="reminderTimeModalEdit" name="reminderTimeModalEdit" value="">
                </div>
            </div>

            <div class="d-flex gap-3 justify-content-start">
                <i class="fa-solid fa-repeat fa-fw mt-1"></i>
                <div class="flex-grow-1">
                    <select class="form-select fc" name="repeatReminderEdit" id="repeatReminderEdit" onchange="setRepeatEdit();">
                      <option value="0">{{ trans('dash.label.not.repeat') }}</option>
                      <option value="1">{{ trans('dash.label.repeat') }}</option>
                    </select>
                </div>
                <div>
                  <select class="form-select fc" name="periodReminderEdit" id="periodReminderEdit">
                    <option value="1">{{ trans('dash.period.day') }}</option>
                    <option value="2">{{ trans('dash.period.week') }}</option>
                    <option value="3">{{ trans('dash.period.month') }}</option>
                    <option value="4">{{ trans('dash.period.year') }}</option>
                  </select>
                </div>
                <div>
                  <input type="number" class="form-control fc" name="quantityReminderEdit" id="quantityReminderEdit" placeholder="{{ trans('dash.label.limit.num') }}" min="1" size="12">
                </div>
            </div>
        </div>
        <div class="modal-footer px-3 px-md-4 pb-3 pb-md-4 pt-0">
          <button type="button" onclick="saveReminderModalEdit();" class="btn btn-primary btn-sm px-4">{{ trans('dash.btn.update.changes') }}</button>
        </div>
      </div>
    </div>
</div>

@include('elements.footer')
@include('elements.appointmodals', ['Modalreminder' => true])

@endsection

@push('scriptBottom')
<link rel="stylesheet" href="{{ asset('css/wpanel/library/jquery.toast.css') }}">
<script src="{{ asset('js/wpanel/library/jquery.toast.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    var sectionReminder = 1;
    new dateDropper({
          selector: '.dDropperEdit',
          format: 'd/m/y',
          expandable: true,
          showArrowsOnHover: true,
          defaultDate: true
    })

    function deleteReminder(obj) {
        var id = $(obj).attr('data-id');

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary btn-sm text-uppercase px-4 marginleft20',
                cancelButton: 'btn btn-danger btn-sm text-uppercase px-4'
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: '{{ trans('dash.label.delete.notification') }}',
            text: '{{ trans('dash.label.delete.notification.confirm') }}',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: '{{ trans('dash.label.yes.delete') }}',
            cancelButtonText: '{{ trans('dash.label.no.cancel') }}',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
                    }
                });

                setCharge();
                
                $.post('{{ route('notification.remove') }}', {id:id},
                    function (data){
                      if(data.process == '1') {
                        location.reload();
                      }else{
                        $.toast({
                            text: '{{ trans('dash.label.problem.notification') }}',
                            position: 'bottom-right',
                            textAlign: 'center',
                            loader: false,
                            hideAfter: 4000,
                            icon: 'warning'
                        });
                      }

                      hideCharge();
                    }
                );
            }
        });
    }

    function setIdAppointmentToReminderEdit(id, description, date, hour, defaultDate, repeat, period, quantity) {
        $('#reminderIdEdit').val(id);
        $('#reminderDetailModalEdit').val(description);
        $('#reminderDateModalEdit').val(date);
        $('#reminderTimeModalEdit').val(hour);

        $('#reminderDateModalEdit').attr('data-dd-opt-default-date', defaultDate);

        if(repeat == 1) {
            $('#repeatReminderEdit').val(repeat);
            $('#periodReminderEdit').val(period);
            $('#quantityReminderEdit').val(quantity);
        } else {
            $('#repeatReminderEdit').val(0);
            $('#periodReminderEdit').val(1);
            $('#quantityReminderEdit').val('');

            $('#periodReminderEdit').attr('disabled', true);
            $('#quantityReminderEdit').attr('disabled', true);
        }
    }

    function saveReminderModalEdit() {
        var valid = true;
  
        var id     = $('#reminderIdEdit').val();
        var detail = $('#reminderDetailModalEdit').val();
        var date   = $('#reminderDateModalEdit').val();
        var time   = $('#reminderTimeModalEdit').val();
    
        $('.requeridoModalSetReminderEdit').each(function(i, elem){
            var value = $(elem).val();
            var value = value.trim();
            if(value == ''){
                $(elem).addClass('is-invalid');
                valid = false;
            }else{
                $(elem).removeClass('is-invalid');
            }
        });

        var repeat   = $('#repeatReminderEdit').val();
        var quantity = 0;
        var period   = 0;
        if(repeat == 1) {
            if($('#quantityReminderEdit').val() == ''){
            $('#quantityReminderEdit').addClass('is-invalid');
            valid = false;
            }else{
            $('#quantityReminderEdit').removeClass('is-invalid');
            }

            quantity = $('#quantityReminderEdit').val();
            period   = $('#periodReminderEdit').val();
        }
    
        if(valid == true) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
                }
            });
    
            setCharge();
    
            $.post('{{ route('appoinment.updateReminder') }}', {id:id, detail:detail, date:date, time:time, repeat:repeat, period:period, quantity:quantity},
            function (data) {
                
                if(data.save == 1) {
                    location.reload();
                }else if(data.save == 2) {
                    $.toast({
                        text: 'No puede crear recordatorios posterior a la fecha de la cita',
                        position: 'bottom-right',
                        textAlign: 'center',
                        loader: false,
                        hideAfter: 4000,
                        icon: 'error'
                    });
                }else if(data.save == 3) {
                    $.toast({
                        text: 'No puede crear recordatorios en fechas anteriores',
                        position: 'bottom-right',
                        textAlign: 'center',
                        loader: false,
                        hideAfter: 4000,
                        icon: 'error'
                    });
                }else{
                    $.toast({
                        text: 'Ocurrio un problema al agregar el recordatorio',
                        position: 'bottom-right',
                        textAlign: 'center',
                        loader: false,
                        hideAfter: 4000,
                        icon: 'error'
                    });
                }           
    
                hideCharge();
            }
            );
        }
    }

    function setRepeatEdit() {
      var repeat = $('#repeatReminderEdit').val();

      if(repeat == 1) {
        $('#periodReminderEdit').attr('disabled', false);
        $('#quantityReminderEdit').attr('disabled', false);
      }else{
        $('#periodReminderEdit').val('1');
        $('#quantityReminderEdit').val('');

        $('#periodReminderEdit').attr('disabled', true);
        $('#quantityReminderEdit').attr('disabled', true);
      }
    }
</script>
@endpush