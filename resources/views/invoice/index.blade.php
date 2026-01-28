@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

    @include('elements.docmenu')

    <section class="container-fluid pb-0 pb-lg-4 px-xl-5">
        <div class="row px-2 px-lg-3 mt-2 mt-lg-4">

            <div class="d-grid d-md-flex gap-2 gap-md-3 mb-2 mb-md-3 align-items-center">
                <h1 class="h4 text-uppercase text-center text-md-start fw-bold mb-0">{{ trans('dash.menu.bills') }}</h1>
                <div class="col-12 col-md-auto d-flex gap-2 ms-md-auto">
                    <a href="{{ route('invoice.create') }}" class="btn btn-primary btn-sm text-uppercase flex-grow-1 px-4">{{ trans('dash.label.new.invoice') }}</a>
                </div>
            </div>

            <div class="row align-items-center justify-content-end mb-3 mt-3 mt-lg-0 mx-0 px-0">
                <div class="col-md-6 col-xl-8 d-flex gap-2 justify-content-center">
                    <div class="d-flex gap-2 justify-content-center">
                        <a onclick="prevMonth();" class="circleArrow me-1"><i class="fa-solid fa-angle-left"></i></a>
                        <div>
                            <select name="monthselect" id="monthselect" class="form-select fs-5 fc" aria-label="{{ trans('dash.label.select.month') }}" onchange="getInvoices();">
                                <option value="1" @if((int)$month == 1) selected="selected" @endif>{{ trans('dash.month.num1') }}</option>
                                <option value="2" @if((int)$month == 2) selected="selected" @endif>{{ trans('dash.month.num2') }}</option>
                                <option value="3" @if((int)$month == 3) selected="selected" @endif>{{ trans('dash.month.num3') }}</option>
                                <option value="4" @if((int)$month == 4) selected="selected" @endif>{{ trans('dash.month.num4') }}</option>
                                <option value="5" @if((int)$month == 5) selected="selected" @endif>{{ trans('dash.month.num5') }}</option>
                                <option value="6" @if((int)$month == 6) selected="selected" @endif>{{ trans('dash.month.num6') }}</option>
                                <option value="7" @if((int)$month == 7) selected="selected" @endif>{{ trans('dash.month.num7') }}</option>
                                <option value="8" @if((int)$month == 8) selected="selected" @endif>{{ trans('dash.month.num8') }}</option>
                                <option value="9" @if((int)$month == 9) selected="selected" @endif>{{ trans('dash.month.num9') }}</option>
                                <option value="10" @if((int)$month == 10) selected="selected" @endif>{{ trans('dash.month.num10') }}</option>
                                <option value="11" @if((int)$month == 11) selected="selected" @endif>{{ trans('dash.month.num11') }}</option>
                                <option value="12" @if((int)$month == 12) selected="selected" @endif>{{ trans('dash.month.num12') }}</option>
                            </select>
                        </div>
                        <div>
                            <select name="yearselect" id="yearselect" class="form-select fs-5 fc" aria-label="{{ trans('dash.label.select.year') }}" onchange="getInvoices();">
                                @for ($i = date('Y') + 1; $i >= date('Y') - 2; $i--)
                                    <option value="{{ $i }}" @if($i == $year) selected="selected" @endif>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <a onclick="nextMonth();" class="circleArrow ms-1"><i class="fa-solid fa-angle-right"></i></a>
                    </div>
                </div>
                <div class="col-md-3 col-xl-2 mt-3 mt-md-0">
                    <select name="billingFilter" id="billingFilter" class="form-select form-select-sm" aria-label="Filtro" onchange="getInvoices();">
                        <option value="0" @if($billtype == 0) selected="selected" @endif>{{ trans('dash.menu.bills') }}</option>
                        <option value="1" @if($billtype == 1) selected="selected" @endif>{{ trans('dash.menu.tickets') }}</option>
                        <option value="2" @if($billtype == 2) selected="selected" @endif>{{ trans('dash.menu.credits') }}</option>
                    </select>
                </div>
            </div>

            @switch($billtype)
                @case(0)
                    @include('invoice/documents/invoices')
                    @break
                @case(1)
                    @include('invoice/documents/tickets')
                @break
                @case(2)
                    @include('invoice/documents/credits')
                @break
                @default
                @break
            @endswitch
            
        </div>
    </section>

    @include('elements.footer')

    @include('invoice/credit-note')

    <div class="modal fade" id="sendMailModal" tabindex="-1" aria-labelledby="sendMailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="fw-normal mb-0 text-secondary">Enviar por email</h6>
                    <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3 p-md-4">
                    <div>
                        <input type="text" name="emailToSendInvoice" id="emailToSendInvoice" class="form-control fc" placeholder="Email">
                    </div>
                </div>
                <div class="modal-footer px-3 px-md-4 pb-3 pb-md-4 pt-0">
                    <button type="button" class="btn btn-primary btn-sm px-4">Enviar</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scriptBottom')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('css/wpanel/library/jquery.toast.css') }}">
    <script src="{{ asset('js/wpanel/library/jquery.toast.js') }}"></script>
    <script>
        //select2
        $('.select2').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
        });

        function prevMonth() {
            var month  = $('#monthselect').val();
            var year   = $('#yearselect').val();
            var type   = $('#billingFilter').val();

            if(month == 1) {
                month = 12;
                year = parseInt(year) - 1;
            }else{
                month = parseInt(month) - 1;
            }

            setCharge();

            location.href = '{{ route('invoice.index') }}/' + btoa(month) + '/' + btoa(year) + '/' + type;
        }

        function nextMonth() {
            var month  = $('#monthselect').val();
            var year   = $('#yearselect').val();
            var type   = $('#billingFilter').val();

            if(month == 12) {
                month = 1;
                year = parseInt(year) + 1;
            }else{
                month = parseInt(month) + 1;
            }

            setCharge();

            location.href = '{{ route('invoice.index') }}/' + btoa(month) + '/' + btoa(year) + '/' + type;
        }

        function getInvoices() {
            var month  = $('#monthselect').val();
            var year   = $('#yearselect').val();
            var type   = $('#billingFilter').val();

            setCharge();

            location.href = '{{ route('invoice.index') }}/' + btoa(month) + '/' + btoa(year) + '/' + type;
        }

        function resendDocument(type, clave) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-primary btn-sm text-uppercase px-4 marginleft20',
                    cancelButton: 'btn btn-danger btn-sm text-uppercase px-4'
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: '{{ trans('dash.invoice.index.msg.resend') }}',
                text: '{{ trans('dash.invoice.index.msg.resend.text') }}',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: '{{ trans('dash.invoice.index.yes') }}',
                cancelButtonText: '{{ trans('dash.invoice.index.no') }}',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
                        }
                    });

                    setCharge();
                    
                    $.post('{{ route('invoice.resend') }}', {type:type, clave:clave},
                        function (data){
                            location.reload();

                            hideCharge();
                        }
                    );
                }
            });
        }
    </script>
@endpush
