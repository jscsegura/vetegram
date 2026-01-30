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
          
          <button id="btn-SearchClient" type="button" class="btn btn-outline-primary btn-sm mb-2 d-table mx-auto px-3" data-appoint-action="search-client">
            <i class="fa-solid fa-magnifying-glass me-2"></i>{{ trans('dash.label.search') }}
          </button>
  
          <div id="printerCreateUser"></div>
        </div>
      </div>
    </div>
</div>

@push('scriptBottom')
<script>
    window.APPOINT_MODAL_CONFIG = window.APPOINT_MODAL_CONFIG || {};
    window.APPOINT_MODAL_CONFIG.searchUser = {
      ids: {
        modal: 'createUserModal',
        emailInput: 'searchClientInput',
        codeSelect: 'searchClientInputCode',
        phoneInput: 'searchClientInputPhone',
        resultsContainer: 'printerCreateUser',
        userSelect: 'userSearchInput',
        mainUserSelect: 'user',
        searchButton: 'btn-SearchClient',
        searchSelectedButton: 'btn-SearchClientSelected'
      },
      routes: {
        getClient: '{{ route('appoinment.getClient') }}',
        setClient: '{{ route('appoinment.setClient') }}'
      },
      labels: {
        search: '{{ trans('dash.label.search') }}',
        notResult: '{{ trans('dash.label.not.result') }}',
        userSelected: '{{ trans('dash.label.user.selected') }}',
        selected: '{{ trans('dash.label.selected') }}',
        createPet: '{{ trans('dash.label.create.pet') }}',
        createUser: '{{ trans('dash.label.element.create.user') }}'
      }
    };
</script>
@endpush
