<div class="modal fade" id="addEntryVaccine" tabindex="-1" aria-labelledby="sendExternalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="fw-normal mb-0 text-secondary">{{ trans('dash.label.send.vaccine') }}</h6>
          <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-3 p-md-4">
          <div>
            <input type="hidden" name="setIdPetToVaccine" id="setIdPetToVaccine" value="0">
            <input type="text" name="emailToSendVaccine" id="emailToSendVaccine" class="form-control fc" placeholder="{{ trans('dash.label.element.email') }}">
          </div>
        </div>
        <div class="modal-footer px-3 px-md-4 pb-3 pb-md-4 pt-0">
          <button type="button" class="btn btn-primary btn-sm px-4" data-appoint-action="external-vaccine-send">{{ trans('dash.btn.label.send') }}</button>
        </div>
      </div>
    </div>
</div>

@push('scriptBottom')
<script>
  window.APPOINT_MODAL_CONFIG = window.APPOINT_MODAL_CONFIG || {};
  window.APPOINT_MODAL_CONFIG.addExternalVaccine = {
    ids: {
      modal: 'addEntryVaccine',
      idField: 'setIdPetToVaccine',
      emailField: 'emailToSendVaccine'
    },
    routes: {
      sendEntryVaccine: '{{ route('appoinment.sendEntryVaccine') }}'
    },
    labels: {
      sendSuccess: '{{ trans('dash.label.vaccine.sender') }}',
      sendError: '{{ trans('dash.label.vaccine.send.error') }}',
      emailInvalid: '{{ trans('dash.label.recipe.send.email') }}'
    }
  };
</script>
@endpush
