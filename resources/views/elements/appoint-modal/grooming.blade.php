<div class="modal fade" id="groomingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="bookModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="fw-normal mb-0 text-secondary">{{ trans('dash.label.data.appoinment') }}</h6>
          <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-3 p-md-4">
            <input type="hidden" name="imageSelected" id="imageSelected" value="0">
            <div class="mb-3">
                <label class="form-label">{{ trans('dash.label.element.breed') }}</label>
                <select class="form-select fc" id="breed" name="breed" aria-label="Select" data-appoint-action="grooming-breed">
                    <option selected>{{ trans('dash.label.selected') }}</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label class="form-label">{{ trans('dash.label.element.select.cut') }}</label>
                <div class="row row-cols-1 row-cols-sm-2 g-2 g-md-3 mb-3" id="containerGrooming">
                    
                    <div class="col">
                        <a href="javascript:void(0);" data-id="0" data-appoint-action="grooming-select" class="thisimages fw-medium d-flex align-items-center gap-2 position-relative w-100 text-decoration-none rounded-3 border border-2 border-secondary px-3 py-2">
                            <span class="petPhoto d-inline-block rounded-circle" style="background-image: url({{ asset('img/default.png') }})"></span>
                            <span>{{ trans('dash.label.other') }}</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="mb-3" id="containerGroomingText" style="display: none;">
                <label class="form-label">{{ trans('dash.label.element.select.cut.other') }}</label>
                <input type="text" name="grooming_personalize" id="grooming_personalize" value="" class="form-control fc" maxlength="254">
            </div>
        </div>
        <div class="modal-footer px-3 px-md-4 pb-3 pb-md-4 pt-0">
            <button type="button" class="btn btn-primary btn-sm px-4" data-appoint-action="grooming-save">{{ trans('dash.label.btn.continue') }}</button>
        </div>
      </div>
    </div>
</div>

@push('scriptBottom')
<script>
    window.APPOINT_MODAL_CONFIG = window.APPOINT_MODAL_CONFIG || {};
    window.APPOINT_MODAL_CONFIG.grooming = {
        ids: {
            modal: 'groomingModal',
            imageField: 'imageSelected',
            container: 'containerGrooming'
        },
        routes: {
            getPetData: '{{ route('search.getPetData') }}',
            getPetDataImages: '{{ route('search.getPetDataImages') }}'
        },
        labels: {
            selected: '{{ trans('dash.label.selected') }}',
            imageNotChoose: '{{ trans('dash.image.not.choose') }}',
            imageNotChoosePersonalize: '{{ trans('dash.image.not.choose.personalize') }}'
        },
        assetsBase: '{{ asset('/') }}'
    };
</script>
@endpush
