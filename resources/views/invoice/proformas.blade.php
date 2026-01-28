@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

    @include('elements.docmenu')

    <section class="container-fluid pb-0 pb-lg-4 px-xl-5">
        <div class="row px-2 px-lg-3 mt-2 mt-lg-4">

            <div class="d-grid d-md-flex gap-2 gap-md-3 mb-2 mb-md-3 align-items-center">
                <h1 class="h4 text-uppercase text-center text-md-start fw-bold mb-0">{{ trans('dash.menu.proformas') }}</h1>
                <div class="col-12 col-md-auto d-flex gap-2 ms-md-auto">
                    <a href="{{ route('invoice.create') }}" class="btn btn-primary btn-sm text-uppercase flex-grow-1 px-4">{{ trans('dash.label.new.proforma') }}</a>
                </div>
            </div>

            <div class="col-12">
                <div class="card rounded-3 border-2 border-secondary px-2 px-lg-3 py-2 py-lg-3 mb-0 mb-lg-5">
                    <div class="card-body p-0" id="preload">
                        <table class="table table-striped table-borderless mb-0 small align-middle cTable">
                            <thead>
                                <tr>
                                    <th class="px-2 px-lg-3" style="width: 120px;">{{ trans('dash.label.date') }}</th>
                                    <th class="px-2 px-lg-3">{{ trans('dash.label.currency') }}</th>
                                    <th class="px-2 px-lg-3">{{ trans('dash.label.payment.amount') }}</th>
                                    <th class="px-2 px-lg-3">{{ trans('dash.label.element.client') }}</th>
                                    <th class="px-2 px-lg-3">{{ trans('dash.label.element.email') }}</th>
                                    <th class="px-2 px-lg-3" style="width: 35px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($invoices) > 0)
                                    @foreach ($invoices as $invoice)
                                    <tr class="position-relative">
                                        <td class="px-2 px-lg-3 py-1 py-lg-3" data-label="{{ trans('dash.label.date') }}:">
                                            {{ date('d/m/Y', strtotime($invoice->created_at)) }} <i class="ms-2">{{ date('h:ia', strtotime($invoice->created_at)) }}</i>
                                        </td>
                                        <td class="px-2 px-lg-3 py-1 py-lg-3" data-label="{{ trans('dash.label.currency') }}:">
                                            {{ $invoice->currency }}
                                        </td>
                                        <td class="px-2 px-lg-3 py-1 py-lg-3" data-label="Total:">
                                            &cent;{{ number_format($invoice->total, 2, ".", ",") }}
                                        </td>
                                        <td class="px-2 px-lg-3 py-1 py-lg-3" data-label="{{ trans('dash.label.element.client') }}:">
                                            {{ $invoice->name }}
                                        </td>
                                        <td class="px-2 px-lg-3 py-1 py-lg-3" data-label="{{ trans('dash.label.element.email') }}:">
                                            {{ $invoice->email }}
                                        </td>
                                        <td class="px-2 px-lg-3 py-1 py-lg-3 h-0 text-center">
                                            <a class="btn btn-link btn-sm smIcon optIcons v2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </a>
                                            <div class="dropdown d-inline-block">
                                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow rounded-3">
                                                    <li><a class="dropdown-item small" href="{{ route('proform.detail', App\Models\User::encryptor('encrypt', $invoice->id)) }}">{{ trans('dash.label.detail') }}</a></li>
                                                    <li><a class="dropdown-item small" href="{{ route('proform.edit', App\Models\User::encryptor('encrypt', $invoice->id)) }}">{{ trans('dash.label.btn.edit') }}</a></li>
                                                    <li><a class="dropdown-item small" href="javascript:void(0);" onclick="deleteProforma('{{ App\Models\User::encryptor('encrypt', $invoice->id) }}')">{{ trans('dash.label.btn.delete') }}</a></li>
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
            
        </div>
    </section>

    @include('elements.footer')

@endsection

@push('scriptBottom')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('css/wpanel/library/jquery.toast.css') }}">
    <script src="{{ asset('js/wpanel/library/jquery.toast.js') }}"></script>
    <script>
        function deleteProforma(id) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-primary btn-sm text-uppercase px-4 marginleft20',
                    cancelButton: 'btn btn-danger btn-sm text-uppercase px-4'
                },
                buttonsStyling: false
            });
            
            swalWithBootstrapButtons.fire({
                title: '{{ trans('dash.proform.msg.delete') }}',
                text: '{{ trans('dash.proform.msg.delete.text') }}',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: '{{ trans('dash.proform.delete.yes') }}',
                cancelButtonText: '{{ trans('dash.proform.delete.no') }}',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
                        }
                    });

                    setCharge();
                    
                    $.post('{{ route('invoice.delete') }}', {id:id},
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
