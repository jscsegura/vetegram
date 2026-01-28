<div class="modal fade" id="sendAttachModal" tabindex="-1" aria-labelledby="sendAttachModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="fw-normal mb-0 text-secondary">{{ trans('dash.label.send.attach') }}</h6>
          <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-3 p-md-4">
          <div>
            <input type="hidden" name="setIdAppointmentToSendAttach" id="setIdAppointmentToSendAttach" value="0">
            <input type="text" name="emailToSendAttach" id="emailToSendAttach" class="form-control fc" placeholder="{{ trans('dash.label.element.email') }}">
          </div>
        </div>
        <div class="modal-footer px-3 px-md-4 pb-3 pb-md-4 pt-0">
          <button onclick="sendAttachModal();" type="button" class="btn btn-primary btn-sm px-4">{{ trans('dash.btn.label.send') }}</button>
        </div>
      </div>
    </div>
</div>

@push('scriptBottom')
<script>
  function setIdAppointmentToSendAttach(id, email = '') {
    $('#setIdAppointmentToSendAttach').val(id);

    if(email != '') {
      $('#emailToSendAttach').val(email);
    }
  }

  function sendAttachModal() {
    var id    = $('#setIdAppointmentToSendAttach').val();
    var email = $('#emailToSendAttach').val();

    var emailPattern = /^[a-zA-Z0-9._+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

    email = email.trim();

    if((email != '') && (emailPattern.test(email))) {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
          }
      });

      setCharge();

      $.post('{{ route('appoinment.sendAttach') }}', {id:id, email:email},
            function (data) {
              
              if(data.send == '1') {
                $('#emailToSendAttach').val('');

                $.toast({
                    text: '{{ trans('dash.label.attach.sender') }}',
                    position: 'bottom-right',
                    textAlign: 'center',
                    loader: false,
                    hideAfter: 4000,
                    icon: 'success'
                });
              }else{
                $.toast({
                  text: '{{ trans('dash.label.attach.send.error') }}',
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
      }else{
        $.toast({
          text: '{{ trans('dash.label.recipe.send.email') }}',
          position: 'bottom-right',
          textAlign: 'center',
          loader: false,
          hideAfter: 4000,
          icon: 'error'
        });
      }
  }
</script>
@endpush