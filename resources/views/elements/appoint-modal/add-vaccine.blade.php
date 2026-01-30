<div class="modal fade" id="addVaccine" tabindex="-1" aria-labelledby="addVaccineLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="fw-normal mb-0 text-secondary">{{ trans('dash.label.add.vaccine') }}</h6>
                <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 p-md-4">
                <form id="frmVaccineModaladd" name="frmVaccineModaladd" action="" enctype="multipart/form-data" method="post" data-action="prevent" data-action-event="submit">
                    @csrf
                    <input type="hidden" id="sectionVaccineAdd" name="sectionVaccineAdd" value="0">
                    <input type="hidden" id="vaccineIdPet" name="vaccineIdPet" value="0">
                    <input type="hidden" id="vaccineIdOwner" name="vaccineIdOwner" value="0">

                    @php
                        $now = date('Y-m-d');
                    @endphp

                    <div class="mb-3">
                        <label for="vaccineDate" class="form-label small">{{ trans('dash.label.element.date.apply') }}</label>
                        <input type="text" class="form-control fc dDropper requeridoAddVaccine" name="vaccineDate" id="vaccineDate" value="{{ date('d/m/Y', strtotime($now)) }}" data-dd-opt-default-date="{{ date('Y/m/d', strtotime($now)) }}">
                    </div>

                    <div class="mb-3">
                        <label for="vaccineName" class="form-label small">{{ trans('dash.label.element.drug') }}</label>
                        {{-- <input type="text" id="vaccineName" name="vaccineName" class="form-control fc " maxlength="255"> --}}
                        <select id="vaccineName" name="vaccineName" class="form-select fc select5 requeridoAddVaccine" data-placeholder="Seleccionar" data-appoint-action="vaccine-interval">
                            <option></option>
                            @foreach ($vaccineItems as $item)
                            <option value="{{ $item['title_' . $weblang] }}" data-interval="{{ $item->interval }}">{{ $item['title_' . $weblang] }}</option>    
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="interval" class="form-label small">{{ trans('dash.label.element.interval') }}</label>
                        <div class="input-group">
                            <input type="text" id="interval" name="interval" class="form-control fc" maxlength="255">
                            <span class="input-group-text fc rounded-0">{{ trans('dash.label.element.days') }}</span>
                        </div>
                    </div>

                    <div class="d-flex gap-4">
                        <div class="mb-3 w-50">
                            <label for="vaccineBrand" class="form-label small">{{ trans('dash.label.element.brand') }}</label>
                            <input type="text" class="form-control fc" name="vaccineBrand" id="vaccineBrand">
                        </div>
                        <div class="mb-3 w-50">
                            <label for="vaccineBatch" class="form-label small">{{ trans('dash.label.element.lot') }}</label>
                            <input type="text" class="form-control fc" name="vaccineBatch" id="vaccineBatch">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="vaccineDateExpire" class="form-label small">{{ trans('dash.label.element.date.expire') }}</label>
                        <input type="text" class="form-control fc dDropper" name="vaccineDateExpire" id="vaccineDateExpire">
                    </div>

                    <div class="">
                        <label for="vaccinePhoto" class="form-label small">{{ trans('dash.label.element.image') }}</label>
                        <input class="form-control" type="file" name="vaccinePhoto" id="vaccinePhoto" style="padding: .375rem .75rem;">
                    </div>
                </form>
            </div>
            <div class="modal-footer px-3 px-md-4 pb-3 pb-md-4 pt-0">
                <button type="button" class="btn btn-primary btn-sm px-4" data-appoint-action="vaccine-save">{{ trans('dash.text.btn.save') }}</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailVaccine" tabindex="-1" aria-labelledby="detailVaccineLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="fw-normal mb-0 text-secondary">{{ trans('dash.label.element.detail.vaccine') }}</h6>
                <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 p-md-4">
                <table class="table mb-0 small align-middle rTable">
                    <thead>
                        <tr>
                            <th class="text-primary-emphasis text-uppercase fw-medium" style="width: 130px;"><small>{{ trans('dash.label.element.apply') }}</small></th>
                            <th class="text-primary-emphasis text-uppercase fw-medium"><small>{{ trans('dash.label.element.drug') }}</small></th>
                            <th class="text-primary-emphasis text-uppercase fw-medium text-center"><small>{{ trans('dash.label.element.brand') }}</small></th>
                            <th class="text-primary-emphasis text-uppercase fw-medium text-center"><small>{{ trans('dash.label.element.lot') }}</small></th>
                            <th class="text-primary-emphasis text-uppercase fw-medium text-center"><small>{{ trans('dash.label.element.expire') }}</small></th>
                            <th class="text-primary-emphasis text-uppercase fw-medium text-center"><small>{{ trans('dash.label.element.photo') }}</small></th>
                            <th class="text-primary-emphasis text-uppercase fw-medium text-center"><small>{{ trans('dash.label.element.professional') }}</small></th>
                        </tr>
                    </thead>
                    <tbody id="containerVaccine">
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scriptBottom')
    <script>
        window.APPOINT_MODAL_CONFIG = window.APPOINT_MODAL_CONFIG || {};
        window.APPOINT_MODAL_CONFIG.addVaccine = {
            ids: {
                modal: 'addVaccine',
                form: 'frmVaccineModaladd',
                petField: 'vaccineIdPet',
                ownerField: 'vaccineIdOwner',
                nameSelect: 'vaccineName',
                intervalInput: 'interval',
                detailContainer: 'containerVaccine'
            },
            routes: {
                createVaccine: '{{ route('appoinment.createVaccine') }}',
                getVaccineData: '{{ route('appoinment.getVaccineData') }}'
            },
            labels: {
                errorCreate: '{{ trans('dash.msg.error.create.vaccine') }}',
                applyLabel: '{{ trans('dash.label.element.apply') }}',
                drugLabel: '{{ trans('dash.label.element.drug') }}',
                brandLabel: '{{ trans('dash.label.element.brand') }}',
                batchLabel: '{{ trans('dash.label.element.lot') }}',
                expireLabel: '{{ trans('dash.label.element.expire') }}',
                photoLabel: '{{ trans('dash.label.element.photo') }}',
                professionalLabel: '{{ trans('dash.label.element.professional') }}'
            },
            assetsBase: '{{ asset('/') }}'
        };
    </script>
@endpush
