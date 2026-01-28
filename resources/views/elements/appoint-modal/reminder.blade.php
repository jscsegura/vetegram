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
                    <select class="form-select fc" name="repeatReminder" id="repeatReminder" onchange="setRepeat();">
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
          <button type="button" onclick="saveReminderModal();" class="btn btn-primary btn-sm px-4">{{ trans('dash.text.btn.save') }}</button>
        </div>
      </div>
    </div>
</div>

@push('scriptBottom')
<script src="{{ asset('js/front/datedropper.js') }}"></script>

<script>
    new dateDropper({
          selector: '.dDropperFuture',
          format: 'd/m/y',
          expandable: true,
          showArrowsOnHover: true,
    })
    
    function setIdAppointmentToReminder(id, onlyForMe = 0, requiredReload = 0, petid = 0, sms = '') {
      $('#reminderIdAppointment').val(id);
      $('#idIsForPet').val(petid);

      if(onlyForMe == 1) {
        $("#reminderToModal option[value='2']").remove();
        $("#reminderToModal option[value=1]").attr("selected",true);
      }
      if(requiredReload == 1) {
        $("#reminderToReload").val(1);
      }

      if(sms == 'sms') {
        $('#sms').val(1);
      }else if(sms == 'whatsapp') {
        $('#whatsapp').val(1);
      }else if(sms == 'sms-whatsapp') {
        $('#sms').val(1);
        $('#whatsapp').val(1);
      }
    }
  
    function saveReminderModal() {
      var valid = true;
  
      var id       = $('#reminderIdAppointment').val();
      var isPetId  = $('#idIsForPet').val();
      var to       = $('#reminderToModal').val();
      var detail   = $('#reminderDetailModal').val();
      var date     = $('#reminderDateModal').val();
      var time     = $('#reminderTimeModal').val();
      var isReload = $("#reminderToReload").val();

      var sms = $("#sms").val();
      var whatsapp = $("#whatsapp").val();
  
      $('.requeridoModalSetReminder').each(function(i, elem){
          var value = $(elem).val();
          var value = value.trim();
          if(value == ''){
              $(elem).addClass('is-invalid');
              valid = false;
          }else{
              $(elem).removeClass('is-invalid');
          }
      });

      var repeat   = $('#repeatReminder').val();
      var quantity = 0;
      var period   = 0;
      if(repeat == 1) {
        if($('#quantityReminder').val() == ''){
          $('#quantityReminder').addClass('is-invalid');
          valid = false;
        }else{
          $('#quantityReminder').removeClass('is-invalid');
        }

        quantity = $('#quantityReminder').val();
        period   = $('#periodReminder').val();
      }
  
      if(valid == true) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
            }
        });
  
        setCharge();

        var section = 0;
        if(typeof(sectionReminder) !== "undefined") {
          section = sectionReminder;
        }
  
        $.post('{{ route('appoinment.saveReminder') }}', {id:id, to:to, detail:detail, date:date, time:time, section:section, isPetId:isPetId, sms:sms, whatsapp:whatsapp, repeat:repeat, period:period, quantity:quantity},
          function (data) {
              
            if(data.save == 1) {
              $('#reminderToModal').val('');
              $('#reminderDetailModal').val('');
              $('#reminderDateModal').val('');
              $('#reminderTimeModal').val('');
              
              if(isReload == 1) {
                location.reload();
              }else{
                $.toast({
                    text: '{{ trans('dash.label.reminder.add.success') }}',
                    position: 'bottom-right',
                    textAlign: 'center',
                    loader: false,
                    hideAfter: 4000,
                    icon: 'success'
                });
              }
            }else if(data.save == 2) {
              $.toast({
                  text: '{{ trans('dash.label.reminder.date.error') }}',
                  position: 'bottom-right',
                  textAlign: 'center',
                  loader: false,
                  hideAfter: 4000,
                  icon: 'error'
              });
            }else if(data.save == 3) {
              $.toast({
                  text: '{{ trans('dash.label.reminder.date.error.before') }}',
                  position: 'bottom-right',
                  textAlign: 'center',
                  loader: false,
                  hideAfter: 4000,
                  icon: 'error'
              });
            }else{
              $.toast({
                text: '{{ trans('dash.label.reminder.add.error') }}',
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
      }
      
    }

    function setRepeat() {
      var repeat = $('#repeatReminder').val();

      if(repeat == 1) {
        $('#periodReminder').attr('disabled', false);
        $('#quantityReminder').attr('disabled', false);
      }else{
        $('#periodReminder').val('1');
        $('#quantityReminder').val('');

        $('#periodReminder').attr('disabled', true);
        $('#quantityReminder').attr('disabled', true);
      }
    }
  </script>
  @endpush