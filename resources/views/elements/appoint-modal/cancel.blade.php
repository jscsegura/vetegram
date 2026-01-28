<div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="fw-normal mb-0 text-secondary">{{ trans('dash.label.reschedule') }}</h6>
          <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-3 p-md-4">
          <input type="hidden" name="cancelIdAppointment" id="cancelIdAppointment" value="0">
          <input type="hidden" name="IdUserAppointmentToCancel" id="IdUserAppointmentToCancel" value="0">
          <div class="mb-2" id="divoptions">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="opcionesModalCancel" id="opcionesModalCancel1" value="cancelar" checked>
              <label class="form-check-label" for="opcionesModalCancel1">{{ trans('dash.label.btn.cancel') }}</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="opcionesModalCancel" id="opcionesModalCancel2" value="reagendar">
              <label class="form-check-label" for="opcionesModalCancel2">{{ trans('dash.label.reschedule') }}</label>
            </div>
          </div>
          <div id="dateModalCancel" style="display: none;">
            <div class="d-flex flex-row gap-3 mb-4">
              <div class="flex-grow-1">
                  <label for="date" class="form-label small">{{ trans('dash.label.date') }}</label>
                  <input type="text" name="dateModalCancelRe" id="dateModalCancelRe" class="form-control fc dDropperCancelModal requerido" size="14" data-dd-opt-min-date="{{ date('Y/m/d') }}">
              </div>
              <div>
                  <label for="dtime" class="form-label small">{{ trans('dash.label.hour') }}</label>
                  <select id="hourModalCancelRe" name="hourModalCancelRe" class="form-select fc requerido" onchange="reserverHourAppointmentToCancel(this);">
                      <option value="">{{ trans('dash.label.selected') }}</option>
                  </select>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer px-3 px-md-4 pb-3 pb-md-4 pt-0">
          <button type="button" onclick="confirmSaveActionCancel();" class="btn btn-primary btn-sm px-4">{{ trans('dash.text.btn.save') }}</button>
        </div>
      </div>
    </div>
</div>

@push('scriptBottom')
<script>
    var dateModalCancel = document.getElementById('dateModalCancel');
    
    // Obtiene los elementos de las opciones de radio
    var radioCancelar  = document.getElementById('opcionesModalCancel1');
    var radioReagendar = document.getElementById('opcionesModalCancel2');
    
    // Agrega un evento de cambio a las opciones de radio
    radioCancelar.addEventListener('change', function() {
      dateModalCancel.style.display = 'none';
    });
    
    radioReagendar.addEventListener('change', function() {
      dateModalCancel.style.display = 'block';
    });

    function setIdAppointmentToCancel(id, user_id, onlyReagend = 0) {
      $('#cancelIdAppointment').val(id);
      $('#IdUserAppointmentToCancel').val(user_id);

      new dateDropper({
          selector: '.dDropperCancelModal',
          format: 'd/m/y',
          expandable: true,
          showArrowsOnHover: true,
          onDropdownExit: getHoursAppointmentToCancel
      });

      if(onlyReagend == 1) {
        $("input[type='radio'][name='opcionesModalCancel'][value='reagendar']").prop('checked',true);
        $('#divoptions').hide();
        dateModalCancel.style.display = 'block';
      }else{
        $("input[type='radio'][name='opcionesModalCancel'][value='cancelar']").prop('checked',true);
        $('#divoptions').show();
        dateModalCancel.style.display = 'none';
      }
    }

    function getHoursAppointmentToCancel() {
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

    function reserverHourAppointmentToCancel(obj) {
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
                            text: '{{ trans('dash.msg.appoinment.hour.not') }}',
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

    function confirmSaveActionCancel() {
      var valid = true;

      var id = $('#cancelIdAppointment').val();
      var user_id = $('#IdUserAppointmentToCancel').val();
      var date = '';
      var time = '';

      var option = $('input[name="opcionesModalCancel"]:checked').val();

      let title = '';
      let text = '';
      let btn = '';

      if(option == 'cancelar') {
        title = '{{ trans('dash.msg.appoinment.title.cancel') }}';
        text = '{{ trans('dash.msg.appoinment.confir.cancel') }}';
        btn = '{{ trans('dash.label.yes.delete') }}';
      }else if(option == 'reagendar') {
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

        title = '{{ trans('dash.msg.appoinment.title.reeschedule') }}';
        text = '{{ trans('dash.msg.appoinment.confir.reeschedule') }}';
        btn = '{{ trans('dash.msg.yes.reeschedule') }}';
      }

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
                
                $.post('{{ route('appoinment.cancelOrReschedule') }}', {id:id, user_id:user_id, date:date, time:time, option:option},
                    function (data){
                      if(data.process == '1') {
                        location.reload();
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