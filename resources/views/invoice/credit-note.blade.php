<div class="modal fade" id="creditNoteModal" tabindex="-1" aria-labelledby="creditNoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="fw-normal mb-0 text-secondary">{{ trans('dash.label.invoice.credit') }}</h6>
          <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-3 p-md-4">
          <div class="mb-3">
            <label for="invoiceid" class="form-label small"># {{ trans('dash.label.invoice') }}</label>
            <input type="text" id="invoiceidnc" name="invoiceidnc" class="form-control fc requeridoNC" value="" disabled>
          </div>
          
          <div class="mb-3">
            <label for="action" class="form-label small">{{ trans('dash.label.nc.action') }}</label>
            <select id="actionnc" name="actionnc" class="form-select fc requeridoNC">
                <option value="">{{ trans('dash.label.selected') }}</option>
                <option value="01">{{ trans('dash.label.nc.anula.doc') }}</option>
                <option value="02">{{ trans('dash.label.nc.correction') }}</option>
                <option value="04">{{ trans('dash.label.nc.reference') }}</option>
                <option value="05">{{ trans('dash.label.nc.sustitute') }}</option>
                <option value="99">{{ trans('dash.label.nc.others') }}</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="reason" class="form-label small">{{ trans('dash.label.nc.reason') }}</label>
            <input type="text" id="reasonnc" name="reasonnc" class="form-control fc requeridoNC">
          </div>

        </div>
        <div class="modal-footer px-3 px-md-4 pb-3 pb-md-4 pt-0">
          <button type="button" onclick="saveCreditNoteModal();" class="btn btn-primary btn-sm px-4">{{ trans('dash.label.nc.proceed') }}</button>
        </div>
      </div>
    </div>
</div>

@push('scriptBottom')
    <script>
        function setIdInvoiceNc(clave) {
            $('#invoiceidnc').val(clave);
        }

        function saveCreditNoteModal() {
            var valida = true;

            $('.requeridoNC').each(function(i, elem){
                var value = $(elem).val();
                var value = value.trim();
                if(value == ''){
                    $(elem).addClass('is-invalid');
                    valida = false;
                }else{
                    $(elem).removeClass('is-invalid');
                }
            });

            if(valida == true) {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-primary btn-sm text-uppercase px-4 marginleft20',
                        cancelButton: 'btn btn-danger btn-sm text-uppercase px-4'
                    },
                    buttonsStyling: false
                });

                swalWithBootstrapButtons.fire({
                    title: '{{ trans('dash.nc.swal.title') }}',
                    text: '{{ trans('dash.nc.swal.text') }}',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: '{{ trans('dash.nc.swal.btn.confirm') }}',
                    cancelButtonText: '{{ trans('dash.nc.swal.btn.cancel') }}',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        var clave = $('#invoiceidnc').val();
                        var razon = $('#reasonnc').val();
                        var action = $('#actionnc').val();

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
                            }
                        });

                        setCharge();
                        
                        $.post('{{ route('invoice.nc') }}', {clave:clave, razon:razon, action:action},
                            function (data){
                                if(data.type == '200') {
                                    swal.close();
                                    swal.fire("{{ trans('dash.swal.msg.success') }}", "{{ trans('dash.swal.msg.success.nc') }}" + data.clave, "success");
                                }else{
                                    $.toast({
                                        text: '{{ trans('dash.msg.nc.error.create') }}',
                                        position: 'bottom-right',
                                        textAlign: 'center',
                                        loader: false,
                                        hideAfter: 4000,
                                        icon: 'error'
                                    });
                                }

                                hideCharge();
                            }
                        );
                    }
                });
            }
        }
    </script>
@endpush
