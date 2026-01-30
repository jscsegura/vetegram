<div class="modal fade" id="createNewPet" tabindex="-1" aria-labelledby="createNewPetModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="fw-normal mb-0 text-secondary">{{ trans('dash.label.element.create.pet') }}</h6>
          <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-3 p-md-4">
          <form name="frmCreatePetModal" id="frmCreatePetModal" method="post" action="" data-action="prevent" data-action-event="submit">
            @csrf
            <input type="hidden" name="useridCreatePetModal" id="useridCreatePetModal" value="0">
            
            <div class="d-flex flex-column flex-md-row gap-3 gap-md-4 mb-3">
              <div class="flex-grow-1">
                  <label for="" class="form-label small">{{ trans('dash.label.element.client') }}</label>
                  <input type="text" id="nameClientPetAdd" class="form-control fc" readonly>
              </div>
              <div class="flex-grow-1">
                <label for="" class="form-label small">{{ trans('dash.label.element.client.email') }}</label>
                <input type="text" id="emailClientPetAdd" class="form-control fc" readonly>
              </div>
            </div>

            <div class="d-flex flex-column flex-md-row gap-3 gap-md-4 mb-3">
              <div class="flex-grow-1">
                  <label for="" class="form-label small">{{ trans('dash.label.element.name.pet') }}</label>
                  <input type="text" id="nameModalCreatePet" name="nameModalCreatePet" class="form-control fc requeridoAddPet">
              </div>
              <div class="flex-grow-1">
                  <label for="" class="form-label small">{{ trans('dash.label.element.type.pet') }}</label>
                  <select id="typeCreatePet" name="typeCreatePet" class="form-select fc select6 requeridoAddPet" data-appoint-action="create-pet-breed">
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
            <button type="button" class="btn btn-primary mt-2" data-appoint-action="create-pet-save">{{ trans('dash.text.btn.save') }}</button>
          </form>
        </div>
      </div>
    </div>
</div>

@push('scriptBottom')
<script>
  window.APPOINT_MODAL_CONFIG = window.APPOINT_MODAL_CONFIG || {};
  window.APPOINT_MODAL_CONFIG.createPet = {
    ids: {
      modal: 'createNewPet',
      form: 'frmCreatePetModal',
      userIdField: 'useridCreatePetModal',
      nameField: 'nameClientPetAdd',
      emailField: 'emailClientPetAdd',
      typeSelect: 'typeCreatePet',
      breedSelect: 'breedCreatePet'
    },
    routes: {
      getBreed: '{{ route('get.breed') }}',
      createPet: '{{ route('register.create-pet') }}',
      setClient: '{{ route('appoinment.setClient') }}'
    },
    labels: {
      selected: '{{ trans('dash.label.selected') }}',
      errorCreate: '{{ trans('dash.label.error.create.pet') }}'
    }
  };
</script>
@endpush
