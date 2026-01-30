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
              <input class="form-check-input" type="radio" name="opcionesModalCancel" id="opcionesModalCancel1" value="cancelar" checked data-appoint-action="cancel-option">
              <label class="form-check-label" for="opcionesModalCancel1">{{ trans('dash.label.btn.cancel') }}</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="opcionesModalCancel" id="opcionesModalCancel2" value="reagendar" data-appoint-action="cancel-option">
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
                  <select id="hourModalCancelRe" name="hourModalCancelRe" class="form-select fc requerido" data-appoint-action="cancel-hour">
                      <option value="">{{ trans('dash.label.selected') }}</option>
                  </select>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer px-3 px-md-4 pb-3 pb-md-4 pt-0">
          <button type="button" class="btn btn-primary btn-sm px-4" data-appoint-action="cancel-save">{{ trans('dash.text.btn.save') }}</button>
        </div>
      </div>
    </div>
</div>

@push('scriptBottom')
<script>
  window.APPOINT_MODAL_CONFIG = window.APPOINT_MODAL_CONFIG || {};
  window.APPOINT_MODAL_CONFIG.cancel = {
    ids: {
      modal: 'cancelModal',
      idField: 'cancelIdAppointment',
      userField: 'IdUserAppointmentToCancel',
      dateWrap: 'dateModalCancel',
      dateInput: 'dateModalCancelRe',
      hourSelect: 'hourModalCancelRe',
      optionsWrap: 'divoptions'
    },
    routes: {
      getHours: '{{ route('appoinment.getHours') }}',
      reserveHour: '{{ route('appoinment.reserveHour') }}',
      cancelOrReschedule: '{{ route('appoinment.cancelOrReschedule') }}'
    },
    labels: {
      selected: '{{ trans('dash.label.selected') }}',
      selectedNotAvailable: '{{ trans('dash.label.selected.notavailable') }}',
      hourNotAvailable: '{{ trans('dash.msg.appoinment.hour.not') }}',
      titleCancel: '{{ trans('dash.msg.appoinment.title.cancel') }}',
      textCancel: '{{ trans('dash.msg.appoinment.confir.cancel') }}',
      btnCancel: '{{ trans('dash.label.yes.delete') }}',
      titleReschedule: '{{ trans('dash.msg.appoinment.title.reeschedule') }}',
      textReschedule: '{{ trans('dash.msg.appoinment.confir.reeschedule') }}',
      btnReschedule: '{{ trans('dash.msg.yes.reeschedule') }}',
      btnCancelReturn: '{{ trans('dash.msg.not.return') }}',
      errorPermit: '{{ trans('dash.msg.appoinment.error.permit') }}',
      errorHour: '{{ trans('dash.msg.appoinment.error.hour') }}',
      errorReschedule: '{{ trans('dash.msg.appoinment.error.reeschedule') }}'
    }
  };
</script>
@endpush
