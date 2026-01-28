@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@include('elements.docmenu')

<section class="container-fluid pb-0 pb-lg-4 px-xl-5">
    <div class="row px-2 px-lg-3 mt-2 mt-lg-4">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-3">
            <h1 class="h4 text-uppercase justify-content-center justify-content-md-start fw-normal mb-0 flex-grow-1 d-flex gap-1 align-items-center">
                <a href="{{ route('inventory.upload') }}" class="btn btn-sm smIcon"><i class="fa-solid fa-arrow-left-long"></i></a>
                <span>{{ trans('dashadmin.label.inventory.list.of') }} <span class="text-info fw-bold">{{ trans('dashadmin.label.title.products') }}</span></span>
            </h1>

        </div>

        <div class="col">
            <div class="card rounded-3 border-2 border-secondary px-2 px-lg-3 py-2 py-lg-3 mb-0 mb-lg-5">
                <div class="card-body p-0">
                    <form id="frmProfile" name="frmProfile" method="post" action="{{ route('inventory.storeXmlProducts') }}">
                        @csrf

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-borderless small align-middle">
                                    <thead>
                                        <tr>
                                            <th class="px-2 px-lg-3 py-1 py-lg-3 text-uppercase small" scope="col">
                                                {{ trans('dashadmin.label.inventory.xml.barcode') }}
                                            </th>
                                            <th class="px-2 px-lg-3 py-1 py-lg-3 text-uppercase small" scope="col">
                                                {{ trans('dashadmin.label.inventory.xml.name') }}
                                            </th>
                                            <th class="px-2 px-lg-3 py-1 py-lg-3 text-uppercase small" scope="col"> 
                                                {{ trans('dashadmin.label.inventory.xml.quantity') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <input type="hidden" name="currentInput" id="currentInput" value="null">
                                        @foreach ($rows as $index => $row)
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control form-control-sm" name="data[{{ $index }}][codigo]" value="{{ $row['codigo'] }}">
                                                @if (!$row['exist'])
                                                <span class="text-success">{{ trans('dashadmin.label.inventory.barcode.exist.no') }}</span> 
                                                @endif
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm" name="data[{{ $index }}][detalle]" value="{{ $row['detalle'] }}">
                                            </td>
                                            <td>
                                                <input type="number" step="any" class="form-control form-control-sm" name="data[{{ $index }}][cantidad]" value="{{ $row['cantidad'] }}">
                                            </td>

                                            <input type="hidden" name="data[{{ $index }}][impuestoMonto]" value="{{ $row['impuestoMonto'] }}">
                                            <input type="hidden" name="data[{{ $index }}][subprice]" value="{{ $row['subprice'] }}">
                                            <input type="hidden" name="data[{{ $index }}][price]" value="{{ $row['price'] }}">
                                            <input type="hidden" name="data[{{ $index }}][rate]" value="{{ $row['rate'] }}">
                                            <input type="hidden" name="data[{{ $index }}][tipo]" value="{{ $row['tipo'] }}">
                                            <input type="hidden" name="data[{{ $index }}][cabys]" value="{{ $row['cabys'] }}">
                                            <input type="hidden" name="data[{{ $index }}][documento]" value="{{ $row['documento'] }}">
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="mt-3 text-end">
                                    <button type="submit" class="btn btn-primary px-5">{{ trans('dashadmin.label.inventory.save') }}</button>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@include('elements.footer')
<div class="modal fade" id="cabysCode" tabindex="-1" aria-labelledby="cabysCodeLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="fw-normal mb-0 text-secondary">{{ trans('dashadmin.label.cabys.search') }}</h6>
                <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 p-md-4">
                <form method="post" enctype="multipart/form-data">

                    <div class="row">
                        <div class="col-md-12">
                            <label for="searchCabys" class="form-label small mb-1">{{ trans('dashadmin.label.cabys.criteria') }}</label>
                            <input type="text" name="searchCabys" id="searchCabys" class="form-control" value="" onkeyup="searchCabysMethod(this);">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            &nbsp;
                        </div>
                    </div>

                    <div>
                        <label for="cabysModal" class="form-label small mb-1">{{ trans('dashadmin.label.cabys.codes') }}</label>
                        <select class="form-select select3" name="cabysModal" id="cabysModal"></select>
                    </div>

                </form>
            </div>
            <div class="modal-footer px-3 px-md-4 pb-3 pb-md-4 pt-0">
                <button type="button" class="btn btn-primary btn-sm px-4" onclick="getCode();">{{ trans('dashadmin.label.select') }}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scriptBottom')
<link rel="stylesheet" href="{{ asset('css/wpanel/library/jquery.toast.css') }}">
<script src="{{ asset('js/wpanel/library/jquery.toast.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script>
    $('.select3').select2({
        theme: "bootstrap-5",
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        dropdownParent: $('#cabysCode')
    });
    //let currentInput = null;

    /*document.querySelectorAll('.cabys-btn').forEach(button => {
        button.addEventListener('click', function() {
            +

            console.log(this.getAttribute('data-input'));
            const inputSelector = this.getAttribute('data-input');
            currentInput = document.querySelector(`input[id="${CSS.escape(inputSelector)}"]`);
        });
    });*/

    function changeCurrentInput(input) {
        let cinput = document.getElementById('currentInput');
        cinput.value = input;
    }

    function searchCabysMethod(obj) {
        var text = $(obj).val();

        var options = '';

        if (text != '') {
            if (!isNaN(parseFloat(text)) && isFinite(text)) {
                $.getJSON("https://api.hacienda.go.cr/fe/cabys?codigo=" + text, function(json) {
                    $.each(json, function(key, val) {
                        if (val.codigo) {
                            options += '<option value="' + val.codigo + '">' + val.descripcion + ' (' + val.codigo + ') ' + val.impuesto + '%</option>';
                        } else {
                            options = '<option value="">{{ trans("dashadmin.label.cabys.not.search") }}</option>';
                        }

                        $('#cabysModal').html(options);
                    });
                });
            } else {
                $.getJSON("https://api.hacienda.go.cr/fe/cabys?q=" + text, function(json) {
                    if (json.total > 0) {
                        $.each(json.cabys, function(key, val) {
                            options += '<option value="' + val.codigo + '">' + val.descripcion + ' (' + val.codigo + ') ' + val.impuesto + '%</option>';
                        });
                    } else {
                        options = '<option value="">{{ trans("dashadmin.label.cabys.not.search") }}</option>';
                    }

                    $('#cabysModal').html(options);
                });
            }
        } else {
            options = '<option value="">{{ trans("dashadmin.label.cabys.not.search") }}</option>';
            $('#cabysModal').html(options);
        }
    }

    function getCode() {
        cinput = document.getElementById('currentInput');
        var code = $('#cabysModal').val();
        if (cinput && code != '') {

            let currentInput = document.getElementById(cinput.value);
            currentInput.value = code;

            $('#cabysCode').modal('toggle');
        }
    }

    function removeMedicine(id, obj) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary btn-sm text-uppercase px-4 marginleft20',
                cancelButton: 'btn btn-danger btn-sm text-uppercase px-4'
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: '{{ trans("dashadmin.msg.delete.medicine") }}',
            text: "{{ trans('dashadmin.msg.confir.delete.medicine') }}",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: '{{ trans("dashadmin.label.yes.delete") }}',
            cancelButtonText: '{{ trans("dashadmin.label.not.delete") }}',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $('#row' + id).remove();
            }
        });
    }
</script>
@endpush