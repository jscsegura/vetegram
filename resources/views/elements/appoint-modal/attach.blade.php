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
            <button type="button" onclick="saveAttachModal();" class="btn btn-primary btn-sm px-4">{{ trans('dash.text.btn.save') }}</button>
          </div>
        </div>
      </div>
  </div>

  @push('scriptBottom')
  @php
    $exts = explode(',', App\Models\AppointmentAttachment::getExtensions());
  @endphp
  <script>
    function setIdAppointmentToAttach(id, pet = 0) {
      $('#attachIdAppointment').val(id);
      $('#attachIdPetAppointment').val(pet);
    }
  
    var peticion;
    function saveAttachModal() {
      var extValid = <?php echo json_encode($exts); ?>;
      
      var names = [];
      var isvalid = true;
      var counter = 0;
      for (var i = 0; i < $('#fileModalMultiple').get(0).files.length; ++i) {
          var name = $('#fileModalMultiple').get(0).files[i].name;
          names.push(name);
  
          var extension = name.substring(name.lastIndexOf("."));
          var position = jQuery.inArray(extension, extValid);
          if(position == -1) {
            isvalid = false;
              
            $.toast({
              text: '{{ trans('dash.msg.ext.not.valid') }}',
              position: 'bottom-right',
              textAlign: 'center',
              loader: false,
              hideAfter: 4000,
              icon: 'warning'
            });
          }
  
          counter++;
      }
  
      if((isvalid) && (counter > 0)) {
        setCharge2();
  
        peticion = $.ajax({
          xhr: function() {
              var progress = $('#progressAttachModal'),
              xhr = $.ajaxSettings.xhr();
  
              progress.show();
  
              xhr.upload.onprogress = function(ev) {
                  if (ev.lengthComputable) {
                      var percentComplete = parseInt((ev.loaded / ev.total) * 100);
                      $('#progressAttachModal em').html(percentComplete + "%");
                      $("#progressAttachModal span").css("width", percentComplete + "%");
                  }
              };
  
              return xhr;
          },
          url: '{{ route('appoinment.saveAttach') }}',
          type: 'POST',
          data: new FormData(document.getElementById('frmUploaderAttachModal')),
          contentType: false,
          cache: false,
          processData: false,
          success: function(data, status, xhr) {
            $('#progressAttachModal').hide();
  
            $('#fileModalMultiple').val('');
  
            if(data.save == 1) {
              $.toast({
                  text: '{{ trans('dash.msg.attach.success') }}',
                  position: 'bottom-right',
                  textAlign: 'center',
                  loader: false,
                  hideAfter: 4000,
                  icon: 'success'
              });

              if (typeof reloadToComplete !== 'undefined') {
                location.reload();
              }
            }else{
              if(data.error != '') {
                  $.toast({
                    text: data.error,
                    position: 'bottom-right',
                    textAlign: 'center',
                    loader: false,
                    hideAfter: 10000,
                    icon: 'error'
                });
              }else{
                $.toast({
                  text: '{{ trans('dash.msg.error.attach') }}',
                  position: 'bottom-right',
                  textAlign: 'center',
                  loader: false,
                  hideAfter: 4000,
                  icon: 'error'
                });
              }
            }
  
            hideCharge2();
          },
          error: function(xhr, status, error) {
            $('#progressAttachModal').hide();
  
            $.toast({
                text: '{{ trans('dash.msg.error.attach') }}',
                position: 'bottom-right',
                textAlign: 'center',
                loader: false,
                hideAfter: 4000,
                icon: 'error'
            });
  
            hideCharge2();
          }
        });
      }
    }
  </script>
  @endpush