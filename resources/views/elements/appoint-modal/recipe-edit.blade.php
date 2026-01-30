<div class="modal fade" id="recipeModalEdit" tabindex="-1" aria-labelledby="recipeModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="fw-normal mb-0 text-secondary">{{ trans('dash.label.recipes') }}</h6>
          <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4 p-md-5">
          <form id="frmMedicineModalEdit" name="frmMedicineModalEdit" action="" method="post">
            @csrf
            <input type="hidden" id="medicineIdAppointmentEdit" name="medicineIdAppointmentEdit" value="0">
            <div id="printerRowsMedicinesEdit"></div>
            <a class="btn btn-outline-primary btn-sm px-4" data-appoint-action="recipe-edit-add"><i class="fa-solid fa-plus me-2"></i>{{ trans('dash.label.add') }}</a>
          </form>
        </div>

        <div class="modal-footer px-3 px-md-4 pb-3 pb-md-4 pt-0 gap-2">
          <button type="button" class="btn btn-primary btn-sm px-4" data-appoint-action="recipe-edit-save">{{ trans('dash.label.save.changes') }}</button>
        </div>
      </div>
    </div>
</div>

@push('scriptBottom')
<script>
  window.APPOINT_MODAL_CONFIG = window.APPOINT_MODAL_CONFIG || {};
  window.APPOINT_MODAL_CONFIG.recipeEdit = {
    ids: {
      modal: 'recipeModalEdit',
      form: 'frmMedicineModalEdit',
      idField: 'medicineIdAppointmentEdit',
      rowsContainer: 'printerRowsMedicinesEdit'
    },
    routes: {
      getRecipeData: '{{ route('appoinment.getRecipeData') }}',
      updateRecipe: '{{ route('appoinment.updateRecipe') }}'
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
      addMedicineRequired: '{{ trans('dash.label.add.require.medicine') }}',
      recipeError: '{{ trans('dash.label.error.add.recipe') }}'
    }
  };
</script>
@endpush
