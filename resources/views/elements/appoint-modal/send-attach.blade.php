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
          <button type="button" class="btn btn-primary btn-sm px-4" data-appoint-action="send-attach">{{ trans('dash.btn.label.send') }}</button>
        </div>
      </div>
    </div>
</div>

@push('scriptBottom')
<script>
  window.APPOINT_MODAL_CONFIG = window.APPOINT_MODAL_CONFIG || {};
  window.APPOINT_MODAL_CONFIG.sendAttach = {
    ids: {
      modal: 'sendAttachModal',
      idField: 'setIdAppointmentToSendAttach',
      emailField: 'emailToSendAttach'
    },
    routes: {
      sendAttach: '{{ route('appoinment.sendAttach') }}'
    },
    labels: {
      sendSuccess: '{{ trans('dash.label.attach.sender') }}',
      sendError: '{{ trans('dash.label.attach.send.error') }}',
      emailInvalid: '{{ trans('dash.label.recipe.send.email') }}'
    }
  };
</script>
@endpush
