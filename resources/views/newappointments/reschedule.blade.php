@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

    @include('elements.docmenu')

    <section class="container-fluid pb-0 pb-lg-4">
        <div class="row px-2 px-lg-3 mt-2 mt-lg-4 mb-3 mb-lg-5">

            <div class="smallCol mx-auto mt-2">
                <input type="hidden" name="cancelIdAppointment" id="cancelIdAppointment" value="{{ $idEncrypt }}">
                <input type="hidden" name="IdUserAppointmentToCancel" id="IdUserAppointmentToCancel" value="{{ $appointment->id_user }}">

                <h2 class="h4 text-uppercase text-center text-md-start fw-normal mb-3">{{ trans('dash.label.btn.reschedule') }} <span class="text-info fw-bold">{{ trans('dash.label.apointment') }}</span></h2>
                <div class="card rounded-3 border-2 border-secondary p-3 p-md-4 mb-3 mb-lg-5">
                    
                    <div class="col-12" style="display: none;" id="containerSuccess">
                        <div class="alert alert-success text-center mb-2" role="alert">
                            <i class="fa-solid fa-check opacity-50 me-2"></i>{{ trans('dash.label.reschedule.complete') }}
                        </div>
                    </div>
                    
                    @if($appointment->status == 2)
                    <div class="col-12">
                        <div class="alert alert-warning text-center mb-2" role="alert">
                            <i class="fa-solid fa-triangle-exclamation opacity-50 me-2"></i>{{ trans('dash.label.not.reschedule.isfinish') }}
                        </div>
                    </div>
                    @elseif($appointment->status == 3)
                    <div class="col-12">
                        <div class="alert alert-warning text-center mb-2" role="alert">
                            <i class="fa-solid fa-triangle-exclamation opacity-50 me-2"></i>{{ trans('dash.label.not.reschedule.iscancel') }}
                        </div>
                    </div>
                    @else
                    <p class="fs-5 text-center mb-3">{{ trans('dash.label.new.date') }} <span class="text-uppercase fw-medium">{{ (isset($appointment['getPet']['name'])) ? $appointment['getPet']['name'] : '' }}</span></p>
                    <div class="d-flex flex-row gap-3 mb-4">
                        <div class="flex-grow-1">
                            <label for="date" class="form-label small">{{ trans('dash.label.date') }}</label>
                            <input type="text" name="dateModalCancelRe" id="dateModalCancelRe" class="form-control fc dDropper requerido" size="14" readonly="true" data-dd-opt-min-date="{{ date('Y/m/d') }}">
                        </div>
                        <div>
                            <label for="dtime" class="form-label small">{{ trans('dash.label.hour') }}</label>
                            <select id="hourModalCancelRe" name="hourModalCancelRe" class="form-select fc requerido">
                                <option value="">{{ trans('dash.label.selected') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="mx-auto">
                        <button type="submit" class="btn btn-primary px-5" onclick="confirmSaveActionReschedule();">{{ trans('dash.text.btn.save') }}</button>
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </section>

    @include('elements.footer')

@endsection

@push('scriptBottom')
<script src="{{ asset('js/front/datedropper.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/wpanel/library/jquery.toast.css') }}">
<script src="{{ asset('js/wpanel/library/jquery.toast.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    new dateDropper({
        selector: '.dDropper',
        format: 'd/m/y',
        expandable: true,
        showArrowsOnHover: true,
        onDropdownExit: getHours
    })

    function getHours() {
        var userid = $('#IdUserAppointmentToCancel').val();
        var date = $('#dateModalCancelRe').val();

        if((userid != '')&&(date != '')) {
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
                }
            });
            
            $.post('{{ route('appoinment.getHours') }}', {userid:userid, date:date},
                function (data){
                    var existHours = 0;

                    var html = '<option value="">{{ trans('dash.label.selected') }}</option>';
                    $.each(data.rows, function(i, item) {
                        html = html + '<option value="'+item.id+'">'+item.hour+'</option>';
                        existHours = 1;
                    });
                    
                    if(existHours == 0) {
                        var html = '<option value="">{{ trans('dash.label.selected.notavailable') }}</option>';
                    }

                    $('#hourModalCancelRe').html(html);
                }
            );
        }else{
            var html = '<option value="">{{ trans('dash.label.selected') }}</option>';
            $('#hourModalCancelRe').html(html);
        }
    }

    function confirmSaveActionReschedule() {
      var valid = true;

      var id = $('#cancelIdAppointment').val();
      var user_id = $('#IdUserAppointmentToCancel').val();
      var date = '';
      var time = '';

      var option = 'reagendar';

      var date = $('#dateModalCancelRe').val();
      var time = $('#hourModalCancelRe').val();

      if(date == ''){
          $('#dateModalCancelRe').addClass('is-invalid');
          valid = false;
      }else{
          $('#dateModalCancelRe').removeClass('is-invalid');
      }

      if(time == ''){
          $('#hourModalCancelRe').addClass('is-invalid');
          valid = false;
      }else{
          $('#hourModalCancelRe').removeClass('is-invalid');
      }

      let title = '{{ trans('dash.msg.appoinment.title.reeschedule') }}';
      let text = '{{ trans('dash.msg.appoinment.confir.reeschedule') }}';
      let btn = '{{ trans('dash.msg.yes.reeschedule') }}';
      
      if(valid == true) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary btn-sm text-uppercase px-4 marginleft20',
                cancelButton: 'btn btn-danger btn-sm text-uppercase px-4'
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: title,
            text: text,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: btn,
            cancelButtonText: '{{ trans('dash.msg.not.return') }}',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
                    }
                });

                setCharge();
                
                $.post('{{ route('appoinment.cancelOrReschedule') }}', {id:id, user_id:user_id, date:date, time:time, option:option, encrypt:true},
                    function (data){
                      if(data.process == '1') {
                        $('#containerSuccess').show();
                      }else if(data.process == '500') {
                        $.toast({
                            text: '{{ trans('dash.msg.appoinment.error.permit') }}',
                            position: 'bottom-right',
                            textAlign: 'center',
                            loader: false,
                            hideAfter: 4000,
                            icon: 'error'
                        });
                      }else if(data.process == '401') {
                        $.toast({
                            text: '{{ trans('dash.msg.appoinment.error.hour') }}',
                            position: 'bottom-right',
                            textAlign: 'center',
                            loader: false,
                            hideAfter: 4000,
                            icon: 'warning'
                        });
                      }else{
                        $.toast({
                            text: '{{ trans('dash.msg.appoinment.error.reeschedule') }}',
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
        });
      }
    }
</script>
@endpush
