<div class="modal fade" id="recipeModal" tabindex="-1" aria-labelledby="recipeModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="fw-normal mb-0 text-secondary">{{ trans('dash.label.recipes') }}</h6>
          <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4 p-md-5">
          <form id="frmMedicineModal" name="frmMedicineModal" action="" method="post">
            @csrf
            <input type="hidden" id="medicineIdAppointment" name="medicineIdAppointment" value="0">
            <input type="hidden" name="medicineIdPetAppointment" id="medicineIdPetAppointment" value="0">
            <div id="printerRowsMedicines"></div>
            <a class="btn btn-outline-primary btn-sm px-4" data-appoint-action="recipe-add-row"><i class="fa-solid fa-plus me-2"></i>{{ trans('dash.label.add') }}</a>
          </form>
        </div>

        <div class="modal-footer px-3 px-md-4 pb-3 pb-md-4 pt-0 gap-2">
          <button type="button" class="btn btn-primary btn-sm px-4" data-appoint-action="recipe-save">{{ trans('dash.text.btn.save') }}</button>
        </div>
      </div>
    </div>
</div>

@push('scriptBottom')
<script>
  window.APPOINT_MODAL_CONFIG = window.APPOINT_MODAL_CONFIG || {};
  window.APPOINT_MODAL_CONFIG.recipe = {
    ids: {
      modal: 'recipeModal',
      form: 'frmMedicineModal',
      idField: 'medicineIdAppointment',
      petField: 'medicineIdPetAppointment',
      rowsContainer: 'printerRowsMedicines'
    },
    routes: {
      getRecipeData: '{{ route('appoinment.getRecipeData') }}',
      saveRecipe: '{{ route('appoinment.saveRecipe') }}'
    },
    labels: {
      selected: '{{ trans('dash.label.selected') }}',
      other: '{{ trans('dash.label.other') }}',
      name: '{{ trans('dash.label.name') }}',
      otherDrug: '{{ trans('dash.label.other.drug') }}',
      duration: '{{ trans('dash.label.duration') }}',
      take: '{{ trans('dash.label.take') }}',
      quantity: '{{ trans('dash.label.quantity') }}',
      additional: '{{ trans('dash.label.adicional') }}',
      recipeSuccess: '{{ trans('dash.label.recipe.add.success') }}',
      recipeError: '{{ trans('dash.label.recipe.add.error') }}'
    }
  };
</script>
@endpush
