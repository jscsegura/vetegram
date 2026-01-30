<div class="modal fade" id="createNewUser" tabindex="-1" aria-labelledby="createNewUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="fw-normal mb-0 text-secondary">{{ trans('dash.label.element.create.user') }}</h6>
          <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-3 p-md-4">
          <form name="frmCreateUser" id="frmCreateUser" method="post" action="" data-action="prevent" data-action-event="submit">
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
                  <select id="petTypeCreateuser" name="petTypeCreateuser" class="form-select fc select4 requeridoAddUser" data-appoint-action="create-user-breed">
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
            <button type="button" class="btn btn-primary mt-2" data-appoint-action="create-user-save">{{ trans('dash.text.btn.save') }}</button>
          </form>
        </div>
      </div>
    </div>
</div>

@push('scriptBottom')
<script>
  window.APPOINT_MODAL_CONFIG = window.APPOINT_MODAL_CONFIG || {};
  window.APPOINT_MODAL_CONFIG.createUser = {
    ids: {
      modal: 'createNewUser',
      form: 'frmCreateUser',
      typeSelect: 'petTypeCreateuser',
      breedSelect: 'petBreedCreateuser',
      associateField: 'associateUserDoctor'
    },
    routes: {
      getBreed: '{{ route('get.breed') }}',
      createOwner: '{{ route('register.create-owner') }}',
      setClient: '{{ route('appoinment.setClient') }}'
    },
    labels: {
      selected: '{{ trans('dash.label.selected') }}',
      emailExists: '{{ trans('dash.label.error.email.exist') }}',
      errorCreate: '{{ trans('dash.label.error.create.user') }}'
    }
  };
</script>
@endpush
