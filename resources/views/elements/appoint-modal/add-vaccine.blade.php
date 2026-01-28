<div class="modal fade" id="addVaccine" tabindex="-1" aria-labelledby="addVaccineLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="fw-normal mb-0 text-secondary">{{ trans('dash.label.add.vaccine') }}</h6>
                <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 p-md-4">
                <form id="frmVaccineModaladd" name="frmVaccineModaladd" action="" enctype="multipart/form-data" method="post" onsubmit="return false;">
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
                        <select id="vaccineName" name="vaccineName" class="form-select fc select5 requeridoAddVaccine" data-placeholder="Seleccionar" onchange="setInterval(this);">
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
                <button type="button" onclick="saveToCreateVaccine();" class="btn btn-primary btn-sm px-4">{{ trans('dash.text.btn.save') }}</button>
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
        function setIdAppointmentToVaccine(id_pet = 0, id_owner = 0) {
            $('#vaccineIdPet').val(id_pet);
            $('#vaccineIdOwner').val(id_owner);
        }

        function setInterval(obj) {
            var selectedOption = $('#vaccineName').find(':selected');
            var interval = selectedOption.attr('data-interval');

            $('#interval').val(interval);
        }

        function saveToCreateVaccine() {
            var validate = true;

            $('.requeridoAddVaccine').each(function(i, elem){
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
                    data: new FormData(document.getElementById('frmVaccineModaladd')),
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

        function showAppointmentVaccine(id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
                }
            });

            setCharge();

            $('#containerVaccine').html('');
            
            $.post('{{ route('appoinment.getVaccineData') }}', {id:id},
                function (data) {
                    var photo = '';
                    if(data.result.photo != '') {
                        var img = '{{ asset('/') }}';
                        photo = '<img src="'+ img + data.result.photo +'" alt="Vacuna" class="vaccineImg">';
                    }

                    var signature = '';
                    if(data.result.signature != '') {
                        signature = '<img src="'+ data.result.signature +'" alt="Firma" class="vaccineImg">';
                    }

                    var html = '<tr>' +
                                    '<td data-label="Aplicación:" class="fw-medium py-1 py-md-3">'+ data.result.date +'</td>' +
                                    '<td data-label="Fármaco:" class="py-1 py-md-3">'+ data.result.name +'</td>' +
                                    '<td data-label="Marca:" class="py-1 py-md-3 text-center">'+ data.result.brand +'</td>' +
                                    '<td data-label="Lote:" class="py-1 py-md-3 text-center">'+ data.result.batch +'</td>' +
                                    '<td data-label="Caducidad:" class="py-1 py-md-3 text-center">'+ data.result.expire +'</td>' +
                                    '<td data-label="Fotografía:" class="py-1 py-md-3 text-center">' +
                                        photo +
                                    '</td>' +
                                    '<td data-label="Profesional:" class="py-1 py-md-3 text-center">' +
                                        '<p class="d-inline-block">'+ data.result.nameDoctor +'</p><br>' +
                                        signature +
                                    '</td>' +
                                '</tr>';
                    
                    $('#containerVaccine').html(html);

                    hideCharge();
                }
            );
        }
    </script>
@endpush