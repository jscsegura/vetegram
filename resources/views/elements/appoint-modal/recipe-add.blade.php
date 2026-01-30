<div class="modal fade" id="recipeModalToAdd" tabindex="-1" aria-labelledby="recipeModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="fw-normal mb-0 text-secondary">{{ trans('dash.label.recipes') }}</h6>
          <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4 p-md-5">
            <div id="printerRowsMedicinesAdd">
              <div class="position-relative hr2 rounded p-3 mb-4" id="medicineNotRow">
                <div class="d-flex flex-column flex-xl-row gap-3 mb-3 justify-content-start">
                    <label for="drugs" class="form-label small">{{ trans('dash.label.not.add.drugs') }}</label>
                </div>
              </div>
            </div>
            <a class="btn btn-outline-primary btn-sm px-4" data-appoint-action="recipe-add-row"><i class="fa-solid fa-plus me-2"></i>{{ trans('dash.label.add') }}</a>
        </div>

        <div class="modal-footer px-3 px-md-4 pb-3 pb-md-4 pt-0 gap-2">
          <button type="button" class="btn btn-primary btn-sm px-4" data-appoint-action="recipe-add-save">{{ trans('dash.label.btn.continue') }}</button>
        </div>
      </div>
    </div>
</div>

@push('scriptBottom')
<script>
  window.APPOINT_MODAL_CONFIG = window.APPOINT_MODAL_CONFIG || {};
  window.APPOINT_MODAL_CONFIG.recipeAdd = {
    ids: {
      modal: 'recipeModalToAdd',
      rowsContainer: 'printerRowsMedicinesAdd',
      emptyRow: 'medicineNotRow'
    },
    labels: {
      name: '{{ trans('dash.label.name') }}',
      duration: '{{ trans('dash.label.duration') }}',
      take: '{{ trans('dash.label.take') }}',
      quantity: '{{ trans('dash.label.quantity') }}',
      additional: '{{ trans('dash.label.adicional') }}',
      otherDrug: '{{ trans('dash.label.other.drug') }}'
    }
  };
</script>
@endpush
