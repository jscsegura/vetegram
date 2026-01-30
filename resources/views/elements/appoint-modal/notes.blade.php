<div class="modal fade" id="noteModal" tabindex="-1" aria-labelledby="noteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="fw-normal mb-0 text-secondary">{{ trans('dash.label.notes') }}</h6>
          <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-3 p-md-4">
          <div>
            <input type="hidden" id="noteIdAppointment" name="noteIdAppointment" value="0">
            <input type="hidden" id="noteToAppointment" name="noteToAppointment" value="0">
            <textarea class="form-control fc" id="noteMtitle" name="noteMtitle" rows="2" placeholder="{{ trans('dash.text.add.note') }}"></textarea>
          </div>
        </div>
        <div class="modal-footer px-3 px-md-4 pb-3 pb-md-4 pt-0">
          <button type="button" class="btn btn-primary btn-sm px-4" data-appoint-action="note-save">{{ trans('dash.text.btn.save') }}</button>
        </div>
      </div>
    </div>
</div>

@push('scriptBottom')
<script>
  window.APPOINT_MODAL_CONFIG = window.APPOINT_MODAL_CONFIG || {};
  window.APPOINT_MODAL_CONFIG.notes = {
    ids: {
      modal: 'noteModal',
      idField: 'noteIdAppointment',
      toField: 'noteToAppointment',
      noteField: 'noteMtitle'
    },
    routes: {
      saveNote: '{{ route('appoinment.saveNote') }}'
    },
    labels: {
      noteSuccess: '{{ trans('dash.label.msj.note.success') }}',
      noteError: '{{ trans('dash.label.msj.note.error') }}',
      noteRequired: '{{ trans('dash.label.msj.note.require.text') }}'
    }
  };
</script>
@endpush
