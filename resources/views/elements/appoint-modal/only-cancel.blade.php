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
          <button type="button" class="btn btn-primary btn-sm px-4" data-appoint-action="only-cancel-save">{{ trans('dash.btn.title.process') }}</button>
        </div>
      </div>
    </div>
</div>

@push('scriptBottom')
<script>
  window.APPOINT_MODAL_CONFIG = window.APPOINT_MODAL_CONFIG || {};
  window.APPOINT_MODAL_CONFIG.onlyCancel = {
    ids: {
      modal: 'onlyCancelModal',
      idField: 'cancelIdAppointment',
      userField: 'IdUserAppointmentToCancel'
    },
    routes: {
      cancelOrReschedule: '{{ route('appoinment.cancelOrReschedule') }}'
    },
    labels: {
      titleCancel: '{{ trans('dash.msg.appoinment.title.cancel') }}',
      textCancel: '{{ trans('dash.msg.appoinment.confir.cancel') }}',
      btnCancel: '{{ trans('dash.label.yes.delete') }}',
      btnCancelReturn: '{{ trans('dash.msg.not.return') }}',
      errorPermit: '{{ trans('dash.msg.appoinment.error.permit') }}',
      errorHour: '{{ trans('dash.msg.appoinment.error.hour') }}',
      errorReschedule: '{{ trans('dash.msg.appoinment.error.reeschedule') }}'
    }
  };
</script>
@endpush
