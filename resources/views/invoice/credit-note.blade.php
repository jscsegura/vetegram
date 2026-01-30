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
          <button type="button" class="btn btn-primary btn-sm px-4" data-invoice-action="credit-note-save">{{ trans('dash.label.nc.proceed') }}</button>
        </div>
      </div>
    </div>
</div>

@push('scriptBottom')
    <script>
        window.INVOICE_CREDIT_NOTE_CONFIG = {
            routes: {
                save: "{{ route('invoice.nc') }}"
            },
            ids: {
                invoiceId: "invoiceidnc",
                reason: "reasonnc",
                action: "actionnc"
            },
            labels: {
                confirmTitle: "{{ trans('dash.nc.swal.title') }}",
                confirmText: "{{ trans('dash.nc.swal.text') }}",
                confirmYes: "{{ trans('dash.nc.swal.btn.confirm') }}",
                confirmNo: "{{ trans('dash.nc.swal.btn.cancel') }}",
                successTitle: "{{ trans('dash.swal.msg.success') }}",
                successText: "{{ trans('dash.swal.msg.success.nc') }}",
                errorText: "{{ trans('dash.msg.nc.error.create') }}"
            }
        };
    </script>
    <script src="{{ asset('js/invoice/credit-note.js') }}"></script>
@endpush
