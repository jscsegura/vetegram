@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@include('elements.docmenu')

<section class="invoiceWidth pb-0 pb-lg-4">
    <div class="row px-2 px-lg-3 mt-2 mt-lg-4 mb-lg-5">
        <div class="col">
            <h1 class="h3 text-center fw-bold text-uppercase mb-2 mb-md-3">Factura</h1>
            <div class="card rounded-3 border-2 border-secondary px-2 px-lg-3 py-2 py-lg-3 mb-3">
                <div class="row row-cols-1 row-cols-md-2 g-3 g-md-4 mb-4 mb-md-5 px-2">
                    <div>
                        <label for="clientName" class="form-label small">Cliente</label>
                        <input type="text" class="form-control fc" id="clientName" value="Nombre de cliente" disabled>
                    </div>
                    <div>
                        <label for="metodoPago" class="form-label small">Medio de pago</label>
                        <select class="form-select fc" id="metodoPago" name="metodoPago">
                            <option value="efectivo">Efectivo</option>
                            <option value="tarjeta">Tarjeta</option>
                            <option value="cheque">Cheque</option>
                            <option value="transferencia">Transferencia</option>
                          </select>
                    </div>
                    <div>
                        <label for="formaPago" class="form-label small">Forma de pago</label>
                        <select class="form-select fc" id="formaPago" name="formaPago">
                            <option value="efectivo">Contado</option>
                          </select>
                    </div>
                    <div>
                        <label for="moneda" class="form-label small">Moneda</label>
                        <input type="text" class="form-control fc" id="moneda" value="Colones" disabled>
                    </div>
                </div>

                <h2 class="h4 fw-normal text-primary text-center">Detalle</h2>
                <table>
                    <table class="table table-striped table-borderless mb-0 small align-middle rTable v2">
                        <thead>
                            <tr>
                                <th class="px-2 px-lg-3" style="width: 70px;"></th>
                                <th class="px-2 px-lg-3" style="width: 90px;">Cantidad</th>
                                <th class="px-2 px-lg-3">Producto/Servicio</th>
                                <th class="px-2 px-lg-3">Detalles</th>
                                <th class="px-2 px-lg-3">Gravado</th>
                                <th class="px-2 px-lg-3">%IVA</th>
                                <th class="px-2 px-lg-3 text-end">Precio</th>
                                <th class="px-2 px-lg-3 text-end">Total línea</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-2 px-lg-3 py-2 py-lg-4" data-label="Eliminar:">
                                    <button type="button" class="btn btn-outline-danger btn-sm">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </td>
                                <td class="px-2 px-lg-3 py-2 py-lg-4" data-label="Cantidad:">
                                    <div class="d-table">
                                        <div class="input-group w-auto align-items-center">
                                            <input type="text" class="form-control form-control-sm fw-semibold text-center" value="1" size="1">
                                        </div>
                                    </div>
                                </td>
                                <td class="px-2 px-lg-3 py-2 py-lg-4" data-label="Pro/Ser:">
                                    <select class="form-select form-select-sm select2">
                                        <option value="">{{ trans('auth.register.complete.select') }}</option>
                                        <option value="1">Producto 1</option>
                                        <option value="2" selected>Producto 2</option>
                                        <option value="3">Producto 3</option>
                                        <option value="4">Producto 4</option>
                                    </select>
                                </td>
                                <td class="px-2 px-lg-3 py-2 py-lg-4" data-label="Detalles:">
                                    {{-- <input type="text" class="form-control form-control-sm"> --}}
                                    Producto 2
                                </td>
                                <td class="px-2 px-lg-3 py-2 py-lg-4" data-label="Gravado:">Gravado</td>
                                <td class="px-2 px-lg-3 py-2 py-lg-4" data-label="IVA:">13%</td>
                                <td class="px-2 px-lg-3 py-2 py-lg-4 text-end" data-label="Precio:">¢10.000</td>
                                <td class="px-2 px-lg-3 py-2 py-lg-4 text-end" data-label="Tot. lin.:">¢10.000</td>
                            </tr>
                            <tr>
                                <td class="px-2 px-lg-3 py-2 py-lg-4" data-label="Eliminar:">
                                    <button type="button" class="btn btn-outline-danger btn-sm">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </td>
                                <td class="px-2 px-lg-3 py-2 py-lg-4" data-label="Cantidad:">
                                    <div class="d-table">
                                        <div class="input-group w-auto align-items-center">
                                            <input type="text" class="form-control form-control-sm fw-semibold text-center" value="2" size="1">
                                        </div>
                                    </div>
                                </td>
                                <td class="px-2 px-lg-3 py-2 py-lg-4" data-label="Pro/Ser:">
                                    <select class="form-select form-select-sm select2">
                                        <option value="">{{ trans('auth.register.complete.select') }}</option>
                                        <option value="1">Producto 1</option>
                                        <option value="2">Producto 2</option>
                                        <option value="3" selected>Producto 3</option>
                                        <option value="4">Producto 4</option>
                                    </select>
                                </td>
                                <td class="px-2 px-lg-3 py-2 py-lg-4" data-label="Detalles:">
                                    {{-- <input type="text" class="form-control form-control-sm"> --}}
                                    Producto 3
                                </td>
                                <td class="px-2 px-lg-3 py-2 py-lg-4" data-label="Gravado:">Gravado</td>
                                <td class="px-2 px-lg-3 py-2 py-lg-4" data-label="IVA:">13%</td>
                                <td class="px-2 px-lg-3 py-2 py-lg-4 text-end" data-label="Precio:">¢10.000</td>
                                <td class="px-2 px-lg-3 py-2 py-lg-4 text-end" data-label="Tot. lin.:">¢20.000</td>
                            </tr>

                            <tr>
                                <td class="px-2 px-lg-3 py-0 py-md-2 py-lg-4 text-end shadow-none" colspan="8">
                                    <button type="button" class="btn btn-outline-primary btn-sm px-4"><i class="fa-solid fa-plus me-1"></i>Agregar línea</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </table>
                <table>
                    <table class="table table-borderless mb-0 small align-middle rTable v2">
                        <tbody>
                            <tr>
                                <td class="px-2 px-lg-3 py-2 py-lg-4 text-end border-top" data-label="Total:">
                                    <span class="me-2 fw-medium d-none d-md-inline-block">Total:</span><span class="fw-bold">¢30.000</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </table>
            </div>
            <button type="button" class="btn btn-primary px-4">Guardar</button>
        </div>
    </div>
</section>

@include('elements.footer')

@endsection

@push('scriptBottom')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('js/front/datedropper.js') }}"></script>

<link rel="stylesheet" href="{{ asset('css/wpanel/library/jquery.toast.css') }}">
<script src="{{ asset('js/wpanel/library/jquery.toast.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="{{ asset('js/appointments/endinvoice.js') }}"></script>
@endpush
