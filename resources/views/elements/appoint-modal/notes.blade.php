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
          <button type="button" onclick="saveNoteModal();" class="btn btn-primary btn-sm px-4">{{ trans('dash.text.btn.save') }}</button>
        </div>
      </div>
    </div>
</div>

@push('scriptBottom')
<script>
  function setIdAppointmentToNote(id, to = 0) {
    $('#noteToAppointment').val(to);
    $('#noteIdAppointment').val(id);
  }

  function saveNoteModal() {
    var id = $('#noteIdAppointment').val();
    var to = $('#noteToAppointment').val();
    var note = $('#noteMtitle').val();

    note = note.trim();

    if(note != '') {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
          }
      });

      setCharge();

      $.post('{{ route('appoinment.saveNote') }}', {id:id, note:note, to:to},
            function (data) {
              $('#noteMtitle').val('');

              if(data.save == 1) {
                $.toast({
                    text: '{{ trans('dash.label.msj.note.success') }}',
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
                $.toast({
                  text: '{{ trans('dash.label.msj.note.error') }}',
                  position: 'bottom-right',
                  textAlign: 'center',
                  loader: false,
                  hideAfter: 4000,
                  icon: 'error'
                });
              }           

              hideCharge();
            }
        );
      }else{
        $.toast({
          text: '{{ trans('dash.label.msj.note.require.text') }}',
          position: 'bottom-right',
          textAlign: 'center',
          loader: false,
          hideAfter: 4000,
          icon: 'error'
        });
      }
  }
</script>
@endpush