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
                <a href="" class="btn btn-primary btn-sm d-block text-uppercase px-4">Agregar producto</a>
            </div>

            contenido
        </div>

    </div>
</section>

@include('elements.footer')
@endsection

@push('scriptBottom')
<script>

    //accordion
    var accordion = document.getElementById('marketNav');

    function toggleAcordeonEnAncho(ancho) {
        var collapseOne = accordion.querySelector('#collapseOne');
        var collapseBtn = accordion.querySelector('#catBtn');
        if (window.innerWidth <= ancho) {
            if (collapseOne.classList.contains('show')) {
                collapseOne.classList.remove('show');
            }
            collapseBtn.classList.add('collapsed');
        } else {
            if (!collapseOne.classList.contains('show')) {
                collapseOne.classList.add('show');
            }
            collapseBtn.classList.remove('collapsed');
        }
    }

    toggleAcordeonEnAncho(1200);

    const query = matchMedia('(max-width: 1200px)');
    console.log(query.matches);

    query.addEventListener('change', (event) => {
        console.log(event.matches);
        toggleAcordeonEnAncho(1200);
    });
</script>
@endpush