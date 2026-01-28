<div class="modal fade" id="createNewPet" tabindex="-1" aria-labelledby="createNewPetModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="fw-normal mb-0 text-secondary">{{ trans('dash.label.element.create.pet') }}</h6>
          <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-3 p-md-4">
          <form name="frmCreatePetModal" id="frmCreatePetModal" method="post" action="" onsubmit="return false;">
            @csrf
            <input type="hidden" name="useridCreatePetModal" id="useridCreatePetModal" value="0">
            
            <div class="d-flex flex-column flex-md-row gap-3 gap-md-4 mb-3">
              <div class="flex-grow-1">
                  <label for="" class="form-label small">{{ trans('dash.label.element.client') }}</label>
                  <input type="text" id="nameClientPetAdd" class="form-control fc" onfocus="blur();">
              </div>
              <div class="flex-grow-1">
                <label for="" class="form-label small">{{ trans('dash.label.element.client.email') }}</label>
                <input type="text" id="emailClientPetAdd" class="form-control fc" onfocus="blur();">
              </div>
            </div>

            <div class="d-flex flex-column flex-md-row gap-3 gap-md-4 mb-3">
              <div class="flex-grow-1">
                  <label for="" class="form-label small">{{ trans('dash.label.element.name.pet') }}</label>
                  <input type="text" id="nameModalCreatePet" name="nameModalCreatePet" class="form-control fc requeridoAddPet">
              </div>
              <div class="flex-grow-1">
                  <label for="" class="form-label small">{{ trans('dash.label.element.type.pet') }}</label>
                  <select id="typeCreatePet" name="typeCreatePet" class="form-select fc select6 requeridoAddPet" onchange="getBreedPet(this);">
                    <option value="">{{ trans('dash.label.selected') }}</option>
                    @foreach ($animalTypes as $type)
                        <option value="{{ $type->id }}">{{ $type['title_' . $weblang] }}</option>
                    @endforeach
                  </select>
              </div>
            </div>
            <div class="mb-3">
                <label for="" class="form-label small">{{ trans('dash.label.element.breed') }}</label>
                <select id="breedCreatePet" name="breedCreatePet" class="form-select fc select6 requeridoAddPet">
                  <option value="">{{ trans('dash.label.selected') }}</option>
                </select>
            </div>
            <button type="button" onclick="saveToCreatePet();" class="btn btn-primary mt-2">{{ trans('dash.text.btn.save') }}</button>
          </form>
        </div>
      </div>
    </div>
</div>

@push('scriptBottom')
<script>
  function chargeCreatePet() {
      var element = $('#userSearchInput').find('option:selected'); 
      
      var iduser = element.attr("data-iduser"); 
      var name = element.attr("data-name"); 
      var email = element.attr("data-email"); 

      if(iduser != '') {
        $('#useridCreatePetModal').val(iduser);
        $('#nameClientPetAdd').val(name);
        $('#emailClientPetAdd').val(email);

        $('#createUserModal').modal('hide');
        $('#createNewPet').modal('show');
      }
  }

  function getBreedPet(obj) {
      var type = $('#typeCreatePet').val();

      $.ajax({
          type: 'POST',
          url: '{{ route('get.breed') }}',
          dataType: "json",
          headers: {
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
          },
          data: {
              type: type
          },
          beforeSend: function() {},
          success: function(data){
              var html = '<option value="">{{ trans('dash.label.selected') }}</option>';
              $.each(data.rows, function(i, item) {
                  html = html + '<option value="'+item.id+'">'+item.title+'</option>';
              });

              $('#breedCreatePet').html(html);
          }
      });
  }

  function saveToCreatePet() {
    var validate = true;

    $('.requeridoAddPet').each(function(i, elem){
        var value = $(elem).val();
        var value = value.trim();
        if(value == ''){
            $(elem).addClass('is-invalid');
            validate = false;
        }else{
            $(elem).removeClass('is-invalid');
        }
    });
    
    if(validate == true) {
      setCharge();

      $.ajax({
          url: '{{ route('register.create-pet') }}',
          type: 'POST',
          data: new FormData(document.getElementById('frmCreatePetModal')),
          contentType: false,
          cache: false,
          processData: false,
          success: function(data, status, xhr) {  
            if(data.result == 'create') {
              $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
                }
              });
              
              var userid = $('#user').val();
              $.post('{{ route('appoinment.setClient') }}', {data:data.data, user:userid},
                  function (response) {
                      var html = '';
                      $.each(response.rows, function(i, item) {
                          html = html + '<option value="'+item.id+':'+item.id_user+'">'+ item.name + ' ('+item.get_user.name+')' +'</option>';
                      });

                      $('#pet').html(html);
                      $("#pet option[value='"+ data.data +"']").attr("selected", true);
                      
                      $('#useridCreatePetModal').val();
                      $('#nameClientPetAdd').val();
                      $('#emailClientPetAdd').val();
                      $('#nameModalCreatePet').val();
                      $('#typeCreatePet').val();
                      $('#breedCreatePet').val();
                      
                      $('#createNewPet').modal('hide');

                      hideCharge();
                  }
              );
            }else{
              $.toast({
                  text: '{{ trans('dash.label.error.create.pet') }}',
                  position: 'bottom-right',
                  textAlign: 'center',
                  loader: false,
                  hideAfter: 4000,
                  icon: 'error'
              });
              hideCharge();
            }
          },
          error: function(xhr, status, error) {
            $.toast({
                text: '{{ trans('dash.label.error.create.pet') }}',
                position: 'bottom-right',
                textAlign: 'center',
                loader: false,
                hideAfter: 4000,
                icon: 'error'
            });

            hideCharge();
          }
        });
    }
  }
</script>
@endpush