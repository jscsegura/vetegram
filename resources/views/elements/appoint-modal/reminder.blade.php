<div class="modal fade" id="reminderModal" tabindex="-1" aria-labelledby="reminderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="fw-normal mb-0 text-secondary">{{ trans('dash.label.btn.reminder') }}</h6>
          <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-3 p-md-4">
            <input type="hidden" name="reminderIdAppointment" id="reminderIdAppointment" value="0">
            <input type="hidden" name="reminderToReload" id="reminderToReload" value="0">
            <input type="hidden" name="idIsForPet" id="idIsForPet" value="0">

            <input type="hidden" name="sms" id="sms" value="0">
            <input type="hidden" name="whatsapp" id="whatsapp" value="0">

            <div class="d-flex gap-3 mb-3 justify-content-start" id="containerReminderTo">
              <i class="fa-regular fa-user fa-fw mt-1"></i>
              <select class="form-select fc requeridoModalSetReminder" id="reminderToModal" name="reminderToModal" aria-label="Select person">
                <option value="">{{ trans('dash.label.selected') }}</option>
                <option value="1">{{ trans('dash.label.for.me') }}</option>
                <option value="2">{{ trans('dash.label.for.owner') }}</option>
              </select>
            </div>
            <div class="d-flex gap-3 mb-3 justify-content-start">
                <i class="fa-solid fa-align-left fa-fw mt-1"></i>
                <textarea class="form-control fc requeridoModalSetReminder" id="reminderDetailModal" name="reminderDetailModal" rows="1" placeholder="{{ trans('dash.label.write') }}"></textarea>
            </div>
            <div class="d-flex gap-3 mb-3 justify-content-start">
                <i class="fa-regular fa-clock fa-fw mt-1"></i>
                <div class="flex-grow-1">
                    <input type="text" class="form-control fc dDropperFuture requeridoModalSetReminder" id="reminderDateModal" name="reminderDateModal" data-dd-opt-min-date="{{ date('Y/m/d') }}" readonly>
                </div>
                <div>
                    <input type="time" class="form-control fc requeridoModalSetReminder" id="reminderTimeModal" name="reminderTimeModal">
                </div>
            </div>
            <div class="d-flex gap-3 justify-content-start">
                <i class="fa-solid fa-repeat fa-fw mt-1"></i>
                <div class="flex-grow-1">
                    <select class="form-select fc" name="repeatReminder" id="repeatReminder" data-appoint-action="reminder-repeat">
                      <option value="0">{{ trans('dash.label.not.repeat') }}</option>
                      <option value="1">{{ trans('dash.label.repeat') }}</option>
                    </select>
                </div>
                <div>
                  <select class="form-select fc" name="periodReminder" id="periodReminder" disabled>
                    <option value="1">{{ trans('dash.period.day') }}</option>
                    <option value="2">{{ trans('dash.period.week') }}</option>
                    <option value="3">{{ trans('dash.period.month') }}</option>
                    <option value="4">{{ trans('dash.period.year') }}</option>
                  </select>
                </div>
                <div>
                  <input type="number" class="form-control fc" name="quantityReminder" id="quantityReminder" placeholder="{{ trans('dash.label.limit.num') }}" min="1" size="12" disabled>
                </div>
            </div>
        </div>
        <div class="modal-footer px-3 px-md-4 pb-3 pb-md-4 pt-0">
          <button type="button" class="btn btn-primary btn-sm px-4" data-appoint-action="reminder-save">{{ trans('dash.text.btn.save') }}</button>
        </div>
      </div>
    </div>
</div>

@push('scriptBottom')
<script src="{{ asset('js/front/datedropper.js') }}"></script>
<script>
  window.APPOINT_MODAL_CONFIG = window.APPOINT_MODAL_CONFIG || {};
  window.APPOINT_MODAL_CONFIG.reminder = {
    ids: {
      modal: 'reminderModal',
      idField: 'reminderIdAppointment',
      reloadField: 'reminderToReload',
      petField: 'idIsForPet',
      smsField: 'sms',
      whatsappField: 'whatsapp',
      toSelect: 'reminderToModal',
      detailInput: 'reminderDetailModal',
      dateInput: 'reminderDateModal',
      timeInput: 'reminderTimeModal',
      repeatSelect: 'repeatReminder',
      periodSelect: 'periodReminder',
      quantityInput: 'quantityReminder'
    },
    routes: {
      saveReminder: '{{ route('appoinment.saveReminder') }}'
    },
    labels: {
      reminderSuccess: '{{ trans('dash.label.reminder.add.success') }}',
      reminderDateError: '{{ trans('dash.label.reminder.date.error') }}',
      reminderDateBeforeError: '{{ trans('dash.label.reminder.date.error.before') }}',
      reminderError: '{{ trans('dash.label.reminder.add.error') }}'
    }
  };
</script>
@endpush
