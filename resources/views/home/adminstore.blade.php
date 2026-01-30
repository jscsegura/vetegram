@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@include('elements.docmenu')

<section class="container-fluid pb-0 pb-lg-4 px-xl-5">
    <div class="row px-2 px-lg-3 mt-2 mt-lg-4">

        <div class="col-xl-3 col-xxl-2">
            <div class="accordion accordion-flush mb-3 mb-xl-0" id="marketNav">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingOne">
                    <button
                      id="catBtn"
                      class="accordion-button rounded-top-3 fs-6 fw-medium fcAccordion"
                      type="button"
                      data-bs-toggle="collapse"
                      data-bs-target="#collapseOne"
                      aria-expanded="false"
                      aria-controls="collapseOne"
                    >
                      <small>Menú de tienda</small>
                    </button>
                  </h2>
                  <div id="collapseOne" class="accordion-collapse collapse show bg-dark rounded-bottom-3" data-bs-theme="dark" aria-labelledby="headingOne" data-bs-parent="#marketNav">
                    <div class="accordion-body p-2">
                      <nav class="nav flex-column">
                        <a class="nav-link active navFc fw-medium text-body fs-6" href="">
                            Productos
                        </a>
                        <a class="nav-link navFc fw-medium text-body fs-6" href="">
                            Categorías
                        </a>
                        <a class="nav-link navFc fw-medium text-body fs-6" href="">
                            Órdenes
                        </a>
                      </nav>
                    </div>
                  </div>
                </div>
              </div>              
        </div>

        <div class="col ps-xl-4">
            <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mb-3">
                <h1 class="h4 text-uppercase text-center text-md-start fw-normal mb-0 flex-grow-1">Lista de <span class="text-info fw-bold">productos</span></h1>
                <div class="d-flex gap-2 align-items-center">
                    <input class="form-control fc" type="text" name="searchOwner" id="searchOwner" placeholder="Buscar" aria-label="default input example" value="">
                    <button type="button" class="btn btn-light btn-sm"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
                <a href="{{ route('addproduct') }}" class="btn btn-primary btn-sm d-block text-uppercase px-4">Agregar producto</a>
            </div>
            <div class="card rounded-3 border-2 border-secondary px-2 px-lg-3 py-2 py-lg-3 mb-0 mb-lg-5">
                <div class="card-body p-0">
                    <table class="table table-striped table-borderless mb-0 small align-middle cTable">
                        <thead>
                            <tr>
                                <th class="px-2 px-lg-3 py-1 py-lg-3 text-uppercase small" style="width: 80px;">Id</th>
                                <th class="px-2 px-lg-3 py-1 py-lg-3 text-uppercase small" scope="col">Título</th>
                                <th class="px-2 px-lg-3 py-1 py-lg-3 text-uppercase small" scope="col">Marca</th>
                                <th class="px-2 px-lg-3 py-1 py-lg-3 text-uppercase small" scope="col">Categoría</th>
                                <th class="px-2 px-lg-3 py-1 py-lg-3 text-uppercase text-center small" scope="col" style="width: 160px;">Receta</th>
                                <th class="px-2 px-lg-3 py-1 py-lg-3 text-uppercase text-center small" scope="col" style="width: 160px;">Tienda</th>
                                <th class="px-2 px-lg-3 py-1 py-lg-3 text-uppercase small" style="width: 280px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-2 px-lg-3 py-1 py-lg-3" data-label="Id:">1</td>
                                <td class="px-2 px-lg-3 py-1 py-lg-3" data-label="Título:">Alimento de perro</td>
                                <td class="px-2 px-lg-3 py-1 py-lg-3" data-label="Marca:">Super Perro</td>
                                <td class="px-2 px-lg-3 py-1 py-lg-3" data-label="Categoría:">Alimentos</td>
                                <td class="px-2 px-lg-3 py-1 py-lg-3 text-center" data-label="Receta:">
                                    <div class="form-check fs-6 form-switch d-inline-block align-middle">
                                        <input class="form-check-input" type="checkbox" role="switch" id="enabled1" checked>
                                    </div>
                                </td>
                                <td class="px-2 px-lg-3 py-1 py-lg-3 text-center" data-label="Tienda:">
                                    <div class="form-check fs-6 form-switch d-inline-block align-middle">
                                        <input class="form-check-input" type="checkbox" role="switch" id="enabled2" checked>
                                    </div>
                                </td>
                                <td class="px-2 px-lg-3 py-1 py-lg-3 text-end" data-label="Opciones:">
                                    <div class="d-inline-block align-top">
                                        <a class="apIcon d-md-inline-block" href="">
                                            <i class="fa-solid fa-pencil"></i>
                                            <span class="d-none d-lg-inline-block">Editar</span>
                                        </a>
                                        <a class="apIcon d-md-inline-block" href="">
                                            <i class="fa-regular fa-trash-can"></i>
                                            <span class="d-none d-lg-inline-block">Eliminar</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
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
<script src="{{ asset('js/home/store-accordion.js') }}"></script>
@endpush
