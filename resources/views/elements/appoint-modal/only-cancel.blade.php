<div class="modal fade" id="onlyCancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="fw-normal mb-0 text-secondary">{{ trans('dash.label.btn.cancel') }}</h6>
          <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-3 p-md-4">
          <input type="hidden" name="cancelIdAppointment" id="cancelIdAppointment" value="0">
          <input type="hidden" name="IdUserAppointmentToCancel" id="IdUserAppointmentToCancel" value="0">
          <div class="mb-2">
              <label class="form-check-label">{{ trans('dash.label.text.cancel') }}</label>
          </div>
        </div>
        <div class="modal-footer px-3 px-md-4 pb-3 pb-md-4 pt-0">
          <button type="button" onclick="confirmSaveActionCancel();" class="btn btn-primary btn-sm px-4">{{ trans('dash.btn.title.process') }}</button>
        </div>
      </div>
    </div>
</div>

@push('scriptBottom')
<script>  
    function setIdAppointmentToOnlyCancel(id, user_id, onlyReagend = 0) {
      $('#cancelIdAppointment').val(id);
      $('#IdUserAppointmentToCancel').val(user_id);

      confirmSaveActionOnlyCancel();
    }
    
    function confirmSaveActionOnlyCancel() {
      var valid = true;

      var id = $('#cancelIdAppointment').val();
      var user_id = $('#IdUserAppointmentToCancel').val();
      var date = '';
      var time = '';

      var option = 'cancelar';

      let title = '{{ trans('dash.msg.appoinment.title.cancel') }}';
      let text = '{{ trans('dash.msg.appoinment.confir.cancel') }}';
      let btn = '{{ trans('dash.label.yes.delete') }}';

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