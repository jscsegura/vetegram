<div class="modal fade" id="addDesparation" tabindex="-1" aria-labelledby="addDesparatLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="fw-normal mb-0 text-secondary">{{ trans('dash.label.add.desparation') }}</h6>
                <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 p-md-4">
                <form id="frmVaccineModaladdDesp" name="frmVaccineModaladdDesp" action="" enctype="multipart/form-data" method="post" onsubmit="return false;">
                    @csrf
                    <input type="hidden" id="sectionVaccineAdd" name="sectionVaccineAdd" value="1">
                    <input type="hidden" id="vaccineIdPetDesp" name="vaccineIdPet" value="0">
                    <input type="hidden" id="vaccineIdOwnerDesp" name="vaccineIdOwner" value="0">

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
                        <select id="vaccineNameDesp" name="vaccineName" class="form-select fc select6 requeridoAddVaccineDesp" data-placeholder="Seleccionar" onchange="setIntervalDesp(this);">
                            <option></option>
                            @foreach ($desparacitanteItems as $item)
                            <option value="{{ $item['title_' . $weblang] }}" data-interval="{{ $item->interval }}">{{ $item['title_' . $weblang] }}</option>    
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="intervalDesp" class="form-label small">{{ trans('dash.label.element.interval') }}</label>
                        <div class="input-group">
                            <input type="text" id="intervalDesp" name="interval" class="form-control fc" maxlength="255">
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
                <button type="button" onclick="saveToCreateVaccineDesp();" class="btn btn-primary btn-sm px-4">{{ trans('dash.text.btn.save') }}</button>
            </div>
        </div>
    </div>
</div>

@push('scriptBottom')
    <script>
        function setIdAppointmentToDesparat(id_pet = 0, id_owner = 0) {
            $('#vaccineIdPetDesp').val(id_pet);
            $('#vaccineIdOwnerDesp').val(id_owner);
        }

        function setIntervalDesp(obj) {
            var selectedOption = $('#vaccineNameDesp').find(':selected');
            var interval = selectedOption.attr('data-interval');

            $('#intervalDesp').val(interval);
        }

        function saveToCreateVaccineDesp() {
            var validate = true;

            $('.requeridoAddVaccineDesp').each(function(i, elem){
                var value = $(elem).val();
                var value = value.trim();
                if(value == ''){
                    $(elem).addClass('is-invalid');
                    validate = false;
                }else{
                    $(elem).removeClass('is-invalid');
                }
            });
            
            if(validate == true) {
                setCharge();

                $.ajax({
                    url: '{{ route('appoinment.createVaccine') }}',
                    type: 'POST',
                    data: new FormData(document.getElementById('frmVaccineModaladdDesp')),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data, status, xhr) {  
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        $.toast({
                            text: '{{ trans('dash.msg.error.create.vaccine') }}',
                            position: 'bottom-right',
                            textAlign: 'center',
                            loader: false,
                            hideAfter: 4000,
                            icon: 'error'
                        });

                        hideCharge();
                    }
                });
            }
        }
    </script>
@endpush