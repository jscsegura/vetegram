<div class="col-12">
    <div class="card rounded-3 border-2 border-secondary px-2 px-lg-3 py-2 py-lg-3 mb-0 mb-lg-5">
        <div class="card-body p-0" id="preload">
            <table class="table table-striped table-borderless mb-0 small align-middle cTable">
                <thead>
                    <tr>
                        <th class="px-2 px-lg-3" style="width: 120px;">{{ trans('dash.label.date') }}</th>
                        <th class="px-2 px-lg-3" style="width: 430px;"># {{ trans('dash.label.doc') }}</th>
                        <th class="px-2 px-lg-3">{{ trans('dash.label.currency') }}</th>
                        <th class="px-2 px-lg-3">{{ trans('dash.label.payment') }}</th>
                        <th class="px-2 px-lg-3">{{ trans('dash.label.period') }}</th>
                        <th class="px-2 px-lg-3 text-center">{{ trans('dash.label.status') }}</th>
                        <th class="px-2 px-lg-3" style="width: 35px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($invoices) > 0)
                        @foreach ($invoices as $invoice)
                        <tr class="position-relative">
                            <td class="px-2 px-lg-3 py-1 py-lg-3" data-label="{{ trans('dash.label.date') }}:">
                                {{ date('d/m/Y', strtotime($invoice['FECHAEMISION'])) }} <i class="ms-2">{{ date('h:ia', strtotime($invoice['FECHAEMISION'])) }}</i>
                            </td>
                            <td class="px-2 px-lg-3 py-1 py-lg-3" data-label="# Doc.:">
                                <a href="{{ route('invoice.detail', ['id' => $invoice['CLAVE'], 'doctype' => 1]) }}" class="cellMax text-break link-secondary">{{ $invoice['CLAVE'] }}</a>
                            </td>
                            <td class="px-2 px-lg-3 py-1 py-lg-3" data-label="{{ trans('dash.label.currency') }}:">
                                {{ $invoice['CURRENCY'] }}
                            </td>
                            <td class="px-2 px-lg-3 py-1 py-lg-3" data-label="{{ trans('dash.label.payment') }}:">
                                {{ $invoice['PAYMENTMODE'] }}
                            </td>
                            <td class="px-2 px-lg-3 py-1 py-lg-3" data-label="{{ trans('dash.label.period') }}:">
                                {{ $invoice['PERIOD'] }}
                            </td>
                            <td class="px-2 px-lg-3 py-1 py-lg-3 text-center" data-label="{{ trans('dash.label.status') }}:">
                                @switch ($invoice['APPROVED'])
                                    @case ('1') <span class="text-success fw-semibold">{{ trans('dash.label.status.invoice.approved') }}</span> @break
                                    @case ('E1') <span class="text-danger fw-semibold">{{ trans('dash.label.status.invoice.rejected.xml') }}</span> @break
                                    @case ('E2') <span class="text-danger fw-semibold">{{ trans('dash.label.status.invoice.no.connection') }}</span> @break
                                    @case ('E3') <span class="text-danger fw-semibold">{{ trans('dash.label.status.invoice.error') }}</span> @break
                                    @case ('0') <span class="text-danger fw-semibold">{{ trans('dash.label.status.invoice.not.approved') }}</span> @break
                                    @case ('W') <span class="text-danger fw-semibold">{{ trans('dash.label.status.invoice.waiting') }}</span> @break
                                    @default <span class="text-danger fw-semibold">{{ trans('dash.label.status.invoice.rejected') }}</span> @break
                                @endswitch
                            </td>
                            <td class="px-2 px-lg-3 py-1 py-lg-3 h-0 text-center">
                                <a class="btn btn-link btn-sm smIcon optIcons v2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </a>
                                <div class="dropdown d-inline-block">
                                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow rounded-3">
                                        <li><a class="dropdown-item small" href="{{ route('invoice.detail', ['id' => $invoice['CLAVE'], 'doctype' => 1]) }}">{{ trans('dash.label.detail') }}</a></li>
                                        
                                        @if($invoice['APPROVED'] != 1)
                                            <li><a class="dropdown-item small" data-invoice-action="resend" data-type="1" data-clave="{{ $invoice['CLAVE'] }}">{{ trans('dash.invoice.index.btn.resend') }}</a></li>
                                        @endif
                                                                                
                                        @if($invoice['CLAVE'] != '')
                                            <li><a class="dropdown-item small" href="https://vetegram.sistelix.com/documents/pdf.php?token={{ $invoice['CLAVE'] }}" target="_blank">{{ trans('dash.label.btn.see') }} PDF</a></li>
                                            <li><a href="https://documentos.factulix.com/pmlix/Tiquetes/Tiquetes/Tiquete-{{ $invoice['CLAVE'] }}.xml" target="_blank" class="dropdown-item small">{{ trans('dash.label.btn.see') }} XML</a></li>
                                            <li><a href="https://documentos.factulix.com/pmlix/Tiquetes/Respuestas/Tiquete-{{ $invoice['CLAVE'] }}-respuesta.xml" target="_blank" class="dropdown-item small">{{ trans('dash.label.btn.see') }} XML {{ trans('dash.label.payment.response') }}</a></li>
                                            {{--<li><button type="button" class="dropdown-item small" data-bs-toggle="modal" data-bs-target="#sendMailModal">Enviar por email</button></li>--}}
                                        @endif

                                        <li><a class="dropdown-item small" href="{{ route('invoice.detail', ['id' => $invoice['CLAVE'], 'doctype' => 1, 'printer' => 'printer']) }}" target="_blank">{{ trans('dash.btn.label.printer') }}</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @else
                    <tr class="position-relative">
                        <td class="px-12 px-lg-12 py-12 py-lg-12" style="width: 100%; text-align: center;" colspan="8"><strong>{{ trans('dash.label.no.registers') }}</strong></td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
