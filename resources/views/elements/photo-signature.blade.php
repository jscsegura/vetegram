<div class="modal fade" id="changePhoto" tabindex="-1" aria-labelledby="pencilBtnLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="fw-normal mb-0 text-secondary">{{ trans('dash.label.element.photo.profile') }}</h6>
          <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-3 p-md-4">
            <form method="post" id="formPhoto" name="formPhoto" enctype="multipart/form-data" method="post" action="{{ route('profile.updatePhoto') }}" onsubmit="return validaImage();">
                @csrf
                <div>
                  <label for="profilePhoto" class="form-label small mb-1">{{ trans('dash.label.element.select.file') }}</label>
                  <input class="form-control" type="file" id="profilePhoto" name="profilePhoto" style="padding: .375rem .75rem;" accept="{{ App\Models\AppointmentAttachment::getExtensions(true) }}">
                </div>
            </form>
        </div>
        <div class="modal-footer px-3 px-md-4 pb-3 pb-md-4 pt-0">
          <button type="button" onclick="sendFormPhoto();" class="btn btn-primary btn-sm px-4">{{ trans('dash.text.btn.save') }}</button>
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
<script>
    //firma
    const myModalEl = document.getElementById('signatureModal')
    myModalEl.addEventListener('shown.bs.modal', event => {
        
        var canvas = document.getElementById('signature-pad');

        function resizeCanvas() {
            var ratio =  Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);
        }

        window.onresize = resizeCanvas;
        resizeCanvas();

        var signaturePad = new SignaturePad(canvas, {
            backgroundColor: 'rgb(255, 255, 255)' // necessary for saving image as JPEG; can be removed is only saving as PNG or SVG
        });

        document.getElementById('clear').addEventListener('click', function () {
            signaturePad.clear();
        });

        document.getElementById('saveSignature').addEventListener('click', function () {
            if(signaturePad.isEmpty()) {
                $.toast({
                    text: '{{ trans('dash.msg.draw.signature') }}',
                    position: 'bottom-right',
                    textAlign: 'center',
                    loader: false,
                    hideAfter: 3000,
                    icon: 'warning'
                });
            }else{
                var signature = signaturePad.toDataURL('image/png');

                setCharge();
                
                $.ajax({
                    type: 'POST',
                    url: '{{ route('profile.setSignature') }}',
                    dataType: "json",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    data: {
                        signature: signature
                    },
                    beforeSend: function(){},
                    success: function(data){
                        location.reload();
                    }
                });
            }
        });
    })

    function sendFormPhoto() {
        $('#formPhoto').submit();
    }

    @php
    $exts = explode(',', App\Models\AppointmentAttachment::getExtensions(true));
    @endphp
    function validaImage() {
        var extValid = <?php echo json_encode($exts); ?>;

        var validate = true;

        var img = document.getElementById('profilePhoto');

        if (img.files.length > 0) {
            
            var nameFile = img.files[0].name;
            
            var extension = nameFile.split('.').pop();
            
            var position = jQuery.inArray(extension, extValid);
            if(position == -1) {
                validate = false;
                
                $.toast({
                    text: '{{ trans('dash.msg.ext.not.valid') }}',
                    position: 'bottom-right',
                    textAlign: 'center',
                    loader: false,
                    hideAfter: 4000,
                    icon: 'warning'
                });
            }
        }else{
            validate = false;

            $.toast({
              text: '{{ trans('dash.msg.select.image') }}',
              position: 'bottom-right',
              textAlign: 'center',
              loader: false,
              hideAfter: 4000,
              icon: 'warning'
            });
        }

        if(validate == true) {
            setCharge2();

            return true;
        }else{
            return false;
        }

    }

    function changeNotified() {
        var mailer = 0;
        var sms = 0;
        var whatsapp = 0;

        if($('#notifiedEmail').is(':checked')) {
            mailer = 1;
        }
        if($('#notifiedSms').is(':checked')) {
            sms = 1;
        }
        if($('#notifiedWhatsapp').is(':checked')) {
            whatsapp = 1;
        }
                
        $.ajax({
            type: 'POST',
            url: '{{ route('profile.setNotifications') }}',
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: {
                mailer : mailer,
                sms : sms,
                whatsapp : whatsapp
            },
            beforeSend: function(){},
            success: function(data){
                $.toast({
                    text: '{{ trans('dash.notified.change') }}',
                    position: 'bottom-right',
                    textAlign: 'center',
                    loader: false,
                    hideAfter: 4000,
                    icon: 'success'
                });
            }
        });
    }
</script>
@endpush