<div class="modal fade" id="createNewUser" tabindex="-1" aria-labelledby="createNewUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="fw-normal mb-0 text-secondary">{{ trans('dash.label.element.create.user') }}</h6>
          <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-3 p-md-4">
          <form name="frmCreateUser" id="frmCreateUser" method="post" action="" onsubmit="return false;">
            @csrf

            <input type="hidden" name="createPermission" id="createPermission" value="1">
            <input type="hidden" name="associateUserDoctor" id="associateUserDoctor" value="0">

            <div class="d-flex flex-column flex-md-row gap-3 gap-md-4 mb-3">
              <div class="flex-grow-1">
                  <label for="nameCreateuser" class="form-label small">{{ trans('dash.label.element.full.name') }}</label>
                  <input type="text" id="nameCreateuser" name="nameCreateuser" class="form-control fc requeridoAddUser">
              </div>
              <div class="flex-grow-1">
                  <label for="emailCreateuser" class="form-label small">{{ trans('dash.label.element.email') }}</label>
                  <input type="text" id="emailCreateuser" name="emailCreateuser" class="form-control fc requeridoAddUser">
              </div>
            </div>
            <div class="d-flex flex-column flex-md-row gap-3 gap-md-4 mb-3">
              <div class="flex-grow-1">
                  <label for="petNameCreateuser" class="form-label small">{{ trans('dash.label.element.name.pet') }}</label>
                  <input type="text" id="petNameCreateuser" name="petNameCreateuser" class="form-control fc requeridoAddUser">
              </div>
              <div class="flex-grow-1">
                  <label for="petTypeCreateuser" class="form-label small">{{ trans('dash.label.element.type.pet') }}</label>
                  <select id="petTypeCreateuser" name="petTypeCreateuser" class="form-select fc select4 requeridoAddUser" onchange="getBreed(this);">
                    <option value="">{{ trans('dash.label.selected') }}</option>
                    @foreach ($animalTypes as $type)
                        <option value="{{ $type->id }}">{{ $type['title_' . $weblang] }}</option>
                    @endforeach
                  </select>
              </div>
            </div>
            <div class="mb-3">
                <label for="petBreedCreateuser" class="form-label small">{{ trans('dash.label.element.breed') }}</label>
                <select id="petBreedCreateuser" name="petBreedCreateuser" class="form-select fc select4 requeridoAddUser">
                  <option value="">{{ trans('dash.label.selected') }}</option>
                </select>
            </div>
            <button onclick="saveToCreateUser();" type="button" class="btn btn-primary mt-2">{{ trans('dash.text.btn.save') }}</button>
          </form>
        </div>
      </div>
    </div>
</div>

@push('scriptBottom')
<script>
  function getBreed(obj) {
      var type = $('#petTypeCreateuser').val();

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

              $('#petBreedCreateuser').html(html);
          }
      });
  }

  function saveToCreateUser() {
    var validate = true;

    $('.requeridoAddUser').each(function(i, elem){
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
          url: '{{ route('register.create-owner') }}',
          type: 'POST',
          data: new FormData(document.getElementById('frmCreateUser')),
          contentType: false,
          cache: false,
          processData: false,
          success: function(data, status, xhr) {  
            if(data.result == 'userexist') {
              $.toast({
                  text: '{{ trans('dash.label.error.email.exist') }}',
                  position: 'bottom-right',
                  textAlign: 'center',
                  loader: false,
                  hideAfter: 4000,
                  icon: 'warning'
              });
              hideCharge();
            }else if(data.result == 'create') {
              $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
                }
              });
              
              var userid = $('#user').val();
              $.post('{{ route('appoinment.setClient') }}', {data:data.data, user:userid},
                  function (response) {
                      var associateUserDoctor = $('#associateUserDoctor').val();

                      if(associateUserDoctor == '1') {
                        location.reload();
                      }

                      var html = '';
                      $.each(response.rows, function(i, item) {
                          html = html + '<option value="'+item.id+':'+item.id_user+'">'+ item.name + ' ('+item.get_user.name+')' +'</option>';
                      });

                      $('#pet').html(html);
                      $("#pet option[value='"+ data.data +"']").attr("selected", true);

                      $('#nameCreateuser').val();
                      $('#emailCreateuser').val();
                      $('#petNameCreateuser').val();
                      $('#petTypeCreateuser').val();
                      $('#petBreedCreateuser').val();

                      $('#createNewUser').modal('hide');

                      hideCharge();
                  }
              );
            }else{
              $.toast({
                  text: '{{ trans('dash.label.error.create.user') }}',
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
                text: '{{ trans('dash.label.error.create.user') }}',
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