  <div class="modal fade" id="attachModal" tabindex="-1" aria-labelledby="attachModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h6 class="fw-normal mb-0 text-secondary">{{ trans('dash.label.attachments') }}</h6>
            <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-3 p-md-4">
              <form name="frmUploaderAttachModal" id="frmUploaderAttachModal" method="post" enctype="multipart/form-data">
                <div>
                    @csrf
                    <input type="hidden" name="attachIdAppointment" id="attachIdAppointment" value="0">
                    <input type="hidden" name="attachIdPetAppointment" id="attachIdPetAppointment" value="0">
                    
                    <label for="fileModalMultiple" class="form-label small mb-1">{{ trans('dash.label.select.attach') }}</label>
                    <input class="form-control" type="file" id="fileModalMultiple" name="fileModalMultiple[]" multiple accept="{{ App\Models\AppointmentAttachment::getExtensions() }}" style="padding: .375rem .75rem;">
                </div>
  
                <p id="progressAttachModal">
                  <span style="width:0%"></span>
                  <em>0%</em>
                </p>
              
              </form>
          </div>
          <div class="modal-footer px-3 px-md-4 pb-3 pb-md-4 pt-0">
            <button type="button" class="btn btn-primary btn-sm px-4" data-appoint-action="attach-save">{{ trans('dash.text.btn.save') }}</button>
          </div>
        </div>
      </div>
  </div>

  @push('scriptBottom')
  @php
    $exts = explode(',', App\Models\AppointmentAttachment::getExtensions());
  @endphp
  <script>
    window.APPOINT_MODAL_CONFIG = window.APPOINT_MODAL_CONFIG || {};
    window.APPOINT_MODAL_CONFIG.attach = {
      ids: {
        modal: 'attachModal',
        form: 'frmUploaderAttachModal',
        idField: 'attachIdAppointment',
        petField: 'attachIdPetAppointment',
        fileInput: 'fileModalMultiple'
      },
      routes: {
        saveAttach: '{{ route('appoinment.saveAttach') }}'
      },
      labels: {
        extNotValid: '{{ trans('dash.msg.ext.not.valid') }}',
        attachSuccess: '{{ trans('dash.msg.attach.success') }}',
        attachError: '{{ trans('dash.msg.error.attach') }}'
      },
      allowedExtensions: <?php echo json_encode($exts); ?>
    };
  </script>
  @endpush
