<div class="modal fade" id="showRecipe" tabindex="-1" aria-labelledby="addRecipeShowLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="fw-normal mb-0 text-secondary">{{ trans('dash.label.recipes') }}</h6>
                <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 p-md-4">
                <div class="card border-2 border-info-subtle docCol pushLeft mt-2 mb-3">
                    <div class="card-body p-2 p-md-3">
                        <table class="table mb-0 small align-middle rTable">
                            <thead>
                                <tr>
                                    <th class="text-primary-emphasis text-uppercase fw-medium"><small>{{ trans('dash.label.name') }}</small></th>
                                    <th class="text-primary-emphasis text-uppercase fw-medium"><small>{{ trans('dash.label.duration') }}</small></th>
                                    <th class="text-primary-emphasis text-uppercase fw-medium text-center"><small>{{ trans('dash.label.take') }}</small></th>
                                    <th class="text-primary-emphasis text-uppercase fw-medium text-center"><small>{{ trans('dash.label.quantity') }}</small></th>
                                    <th class="text-primary-emphasis text-uppercase fw-medium"><small>{{ trans('dash.label.notes') }}</small></th>
                                </tr>
                            </thead>
                            <tbody id="tbodyShowRecipe"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scriptBottom')
    <script>
        window.APPOINT_MODAL_CONFIG = window.APPOINT_MODAL_CONFIG || {};
        window.APPOINT_MODAL_CONFIG.showRecipe = {
            ids: {
                modal: 'showRecipe',
                container: 'tbodyShowRecipe'
            },
            routes: {
                getRecipeData: '{{ route('appoinment.getRecipeData') }}'
            },
            labels: {
                name: '{{ trans('dash.label.name') }}',
                duration: '{{ trans('dash.label.duration') }}',
                take: '{{ trans('dash.label.take') }}',
                quantity: '{{ trans('dash.label.quantity') }}',
                notes: '{{ trans('dash.label.notes') }}'
            }
        };
    </script>
@endpush
