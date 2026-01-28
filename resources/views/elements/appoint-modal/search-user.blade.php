<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="fw-normal mb-0 text-secondary">{{ trans('dash.label.search.client') }}</h6>
          <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-3 p-md-4">
          <p class="text-center small mb-3"><i class="fa-solid fa-triangle-exclamation text-warning me-2"></i>{{ trans('dash.label.search.options') }}</p>
            <div class="d-flex flex-column flex-sm-row mb-3 gap-sm-3">
                <div><label for="searchClientInput" class="form-label small mb-0 text-start text-sm-end" style="width: 118px">{{ trans('dash.label.element.email') }}</label></div>
                <input type="text" id="searchClientInput" name="searchClientInput" class="form-control fc" maxlength="255" autocomplete="off">
            </div>

          <div class="d-flex flex-column flex-sm-row gap-sm-3 mb-3">
              <div><label for="searchClientInputCode" class="form-label small mb-0 text-start text-sm-end" style="width: 118px">{{ trans('dash.label.country') }}</label></div>
              <div class="flex-grow-1">
                <select class="form-select fc select5" name="searchClientInputCode" id="searchClientInputCode">
                  @foreach ($countries as $country)
                    <option value="{{ $country->phonecode }}" @if($countryDefault == $country->id) selected @endif>{{ $country->title }} ({{ $country->phonecode }})</option>
                  @endforeach
                </select>
              </div>
          </div>
          <div class="d-flex flex-column flex-sm-row gap-sm-3 mb-4">
            <div><label for="searchClientInputPhone" class="form-label small mb-0 text-start text-sm-end" style="width: 118px">{{ trans('dash.label.phone') }}</label></div>
            <input type="text" name="searchClientInputPhone" id="searchClientInputPhone" class="form-control fc" autocomplete="off">
          </div>
          
          <button onclick="searchClient(this);" id="btn-SearchClient" type="button" class="btn btn-outline-primary btn-sm mb-2 d-table mx-auto px-3">
            <i class="fa-solid fa-magnifying-glass me-2"></i>{{ trans('dash.label.search') }}
          </button>
  
          <div id="printerCreateUser"></div>
        </div>
      </div>
    </div>
</div>

@push('scriptBottom')
<script>
    function searchClient() {
      var email = $('#searchClientInput').val();
      var codePhone = $('#searchClientInputCode').val();
      var phone = $('#searchClientInputPhone').val();
  
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
          }
      });
      
      if((email != "") || (phone != "")) {
        setLoad('btn-SearchClient', '{{ trans('dash.label.search') }}');
        $.post('{{ route('appoinment.getClient') }}', {email: email, codePhone: codePhone, phone: phone},
            function (data) {
                var html = '';
                $.each(data.rows, function(i, item) {
                    html = html + '<option value="'+item.id+':'+item.id_user+'" data-iduser="' + item.get_user.id + '" data-name="' + item.get_user.name + '" data-email="' + item.get_user.email + '">' + item.name + ' ('+item.get_user.name+')</option>';
                });

                var createPet = '<div class="col col-md-6"><button type="button" onclick="chargeCreatePet();" class="btn btn-secondary btn-sm w-100"><i class="fa-solid fa-paw me-2"></i>{{ trans('dash.label.create.pet') }}</button></div>';
                if(html == '') {
                  createPet = '';
                  html = html + '<option value="" data-iduser="" data-name="" data-email="">{{ trans('dash.label.not.result') }}</option>';
                }
  
                var txt = '<div class="d-flex flex-column flex-sm-row gap-3">'+
                      '<div class="flex-grow-1">'+
                        '<label for="userSearchInput" class="form-label small">{{ trans('dash.label.user.selected') }}</label>'+
                        '<select id="userSearchInput" name="userSearchInput" class="form-select fc">' + html + '</select>'+
                      '</div>'+
                      '<button onclick="searchClientSelected();" id="btn-SearchClientSelected" type="button" class="btn btn-primary btn-sm align-self-sm-end"><i class="fa-solid fa-arrow-right me-2"></i>{{ trans('dash.label.selected') }}</button>'+
                    '</div>'+
                    
                    '<div class="row mt-4">'+
                      createPet +
                      '<div class="col col-md-6"><button type="button" class="btn btn-secondary btn-sm w-100" data-bs-toggle="modal" data-bs-target="#createNewUser"><i class="fa-solid fa-user me-2"></i>{{ trans('dash.label.element.create.user') }}</button></div>'+
                    '</div>';
  
                $('#printerCreateUser').html(txt);
  
                stopLoad('btn-SearchClient', '{{ trans('dash.label.search') }}');
            }
        );
      }
    }
  
    function searchClientSelected() {
      var data = $('#userSearchInput').val();
      var user = $('#user').val();
  
      if(data != '') {
        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
          }
        });

        setLoad('btn-SearchClientSelected', '{{ trans('dash.label.selected') }}');
        $.post('{{ route('appoinment.setClient') }}', {data:data, user:user},
            function (response) {
                var html = '';
                $.each(response.rows, function(i, item) {
                    html = html + '<option value="'+item.id+':'+item.id_user+'">'+ item.name + ' ('+item.get_user.name+')' +'</option>';
                });

                $('#pet').html(html);
                $("#pet option[value='"+ data +"']").attr("selected", true);

                $('#createUserModal').modal('hide');

                stopLoad('btn-SearchClientSelected', '{{ trans('dash.label.selected') }}');
            }
        );
      }
    }
  </script>
  @endpush