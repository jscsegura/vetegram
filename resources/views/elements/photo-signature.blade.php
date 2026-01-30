<div class="modal fade" id="changePhoto" tabindex="-1" aria-labelledby="pencilBtnLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="fw-normal mb-0 text-secondary">{{ trans('dash.label.element.photo.profile') }}</h6>
          <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-3 p-md-4">
            <form method="post" id="formPhoto" name="formPhoto" enctype="multipart/form-data" method="post" action="{{ route('profile.updatePhoto') }}">
                @csrf
                <div>
                  <label for="profilePhoto" class="form-label small mb-1">{{ trans('dash.label.element.select.file') }}</label>
                  <input class="form-control" type="file" id="profilePhoto" name="profilePhoto" style="padding: .375rem .75rem;" accept="{{ App\Models\AppointmentAttachment::getExtensions(true) }}">
                </div>
            </form>
        </div>
        <div class="modal-footer px-3 px-md-4 pb-3 pb-md-4 pt-0">
          <button type="button" class="btn btn-primary btn-sm px-4" data-photo-action="photo-submit">{{ trans('dash.text.btn.save') }}</button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="signatureModal" tabindex="-1" aria-labelledby="signatureModalLabel" aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="fw-normal mb-0 text-secondary">{{ trans('dash.label.element.signature') }}</h6>
          <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-3 p-md-4">
            <div class="wrapSign">
                <canvas id="signature-pad" class="signature-pad" width=400 height=200></canvas>
            </div>
            <p class="mb-0 small text-center opacity-75 mt-2"><i class="fa-solid fa-triangle-exclamation me-2"></i>{{ trans('dash.label.element.draw') }}</p>
        </div>
        <div class="modal-footer gap-2 px-3 px-md-4 pb-3 pb-md-4 pt-0">
          <button id="clear" type="button" class="btn btn-outline-primary btn-sm px-4">{{ trans('dash.text.btn.erase') }}</button>
          <button type="button" id="saveSignature" class="btn btn-primary btn-sm px-4">{{ trans('dash.text.btn.save') }}</button>
        </div>
      </div>
    </div>
</div>

@push('scriptBottom')
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
@php
  $exts = explode(',', App\Models\AppointmentAttachment::getExtensions(true));
@endphp
<script>
  window.PHOTO_SIGNATURE_CONFIG = {
    routes: {
      setSignature: "{{ route('profile.setSignature') }}",
      setNotifications: "{{ route('profile.setNotifications') }}"
    },
    labels: {
      drawSignature: "{{ trans('dash.msg.draw.signature') }}",
      extNotValid: "{{ trans('dash.msg.ext.not.valid') }}",
      selectImage: "{{ trans('dash.msg.select.image') }}",
      notifiedChange: "{{ trans('dash.notified.change') }}"
    },
    allowedExtensions: <?php echo json_encode($exts); ?>
  };
</script>
<script src="{{ asset('js/common/photo-signature.js') }}"></script>
@endpush
