@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@include('elements.docmenu')

<section class="container-fluid pb-0 pb-lg-4">

    <div class="row px-2 px-lg-3 mt-2 mt-lg-4">
        <h1 class="h4 text-uppercase text-center text-md-start fw-normal mb-3"><a href="{{ route('schedule.extra.index') }}" class="btn btn-sm smIcon"><i class="fa-solid fa-arrow-left-long"></i></a>Configurar <span class="text-info fw-bold"> Disponibilidad Extra</span></h1>
        <form name="frmAddAppointment" id="frmAddAppointment" action="{{ route('schedule.extra.update') }}" method="post" enctype="multipart/form-data" class="col-lg-10 col-xl-8 col-xxl-6 mx-auto mt-4 mt-lg-0 mb-lg-5">
            @csrf
            <input type="hidden" name="hideId" id="hideId" value="{{ App\Models\User::encryptor('encrypt', $slot->id) }}">

            <div class="container mt-4 mx-auto" style="max-width: 600px;">

                <div class="container mt-4 mx-auto" style="max-width: 600px;">
                    <div class="border p-3 rounded-2 bg-light">

                        <div class="mb-4">
                            <h5 class="fw-bold text-primary mb-2">Disponibilidad extra</h5>
                            <p class="text-muted small mb-3">
                                Crea un horario extra para ajustarlo a tu disponibilidad.
                            </p>

                        </div>
                        <div class="d-flex flex-column flex-md-row align-items-md-center gap-3 mb-3 py-3">
                            <div class="flex-grow-1">
                                <label for="dateMode" class="form-label small fw-semibold">Describa la actividad que desea programar</label>
                                <input type="text" id="activityDescription" name="activityDescription" class="form-control text-center" placeholder="Descripción de la actividad" value="{{ old('activityDescription', $slot->description) }}" required>
                                <div id="activityDescriptionFeedback" class="invalid-feedback">Por favor, ingrese una descripción de la actividad.</div>
                            </div>
                        </div>
                        <div style="display:none;">
                            <div class="flex-grow-1">
                                <label for="dateMode" class="form-label small fw-semibold">Modo de selección de fecha</label>
                                <select id="dateMode" name="dateMode" class="form-select text-center" onchange='changeOptionDescription()'>
                                    <option value="single" selected>Seleccionar una fecha</option>
                                    <option value="multiple">Seleccionar múltiples fechas</option>
                                    <option value="range">Seleccionar un rango de fechas</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex flex-column justify-content-center align-items-center py-4 mb-3">
                            <p id="dateInstruction" class="text-center small mt-2 text-primary">Elige un solo día en el que quieras agregar tu disponibilidad.</p>
                            <input type="text" id="datePicker" name="datePicker" class="form-control text-center" placeholder="Selecciona una fecha" data-date="{{ old('datePicker', $slot->date) }}">
                        </div>


                        <div class="d-flex align-items-start flex-column">
                            <div class="border rounded-3 p-2 px-3 mb-2">
                                <div class="d-flex align-items-start gap-3 flex-wrap w-100 mb-2" id="header">
                                    <label for="first-segment" class="form-label small fw-semibold py-2"> Indique el período de tiempo destinado a la actividad</label>
                                    <div id="first-segment" class="flex-grow-1 d-flex flex-column gap-1">

                                        <div style="padding-right: 1rem; margin-top: 0 !important; padding-top: 0 !important;" class="d-flex align-items-center gap-2 flex-wrap border p-2 rounded-2 bg-light"
                                            data-component="interval" size="6">


                                            <div class="flex-grow-1">
                                                <select class="form-select select2 form-select-m bg-white text-center"
                                                    name="schedule[0][from]">
                                                    @for ($h = 0; $h < 24; $h++)
                                                        @for ($m=0; $m < 60; $m +=15)
                                                        @php
                                                        $time=sprintf('%02d:%02d', $h, $m);
                                                        $timeCompare=$time.':00';
                                                        @endphp
                                                        <option value="{{ $time }}" {{ $timeCompare == $slot->start_time ? 'selected' : '' }}>{{ $time }}</option>
                                                        @endfor
                                                        @endfor
                                                </select>
                                            </div>
                                            <span class="text-muted">-</span>
                                            <div class="flex-grow-1">
                                                <select class="form-select select2 form-select-m bg-white text-center"
                                                    name="schedule[0][to]">
                                                    @for ($h = 0; $h < 24; $h++)
                                                        @for ($m=0; $m < 60; $m +=15)
                                                        @php
                                                        $time=sprintf('%02d:%02d', $h, $m);
                                                        $timeCompare=$time.':00';
                                                        @endphp
                                                        <option value="{{ $time }}" {{ $timeCompare == $slot->end_time ? 'selected' : '' }}>{{ $time }}</option>
                                                        @endfor
                                                        @endfor
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div id="segments" class="flex-grow-1 d-flex flex-column gap-1"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end me-3">
                    <div class="d-flex flex-column flex-md-row gap-2 gap-md-4">
                        <div class="d-none d-md-block">
                            <i class="fa-solid fa-angle-right fa-fw fs-5 mt-1 text-white"></i>
                        </div>
                        <div class="d-flex flex-column flex-sm-row gap-2">
                            <button type="submit" class="btn btn-primary px-4" id="btnSave">
                                Guardar <i class="fa-solid fa-angle-right fa-fw fs-5 mt-1 text-white"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>


</section>
@endsection

@push('scriptBottom')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('js/front/datedropper.js') }}"></script>

<link rel="stylesheet" href="{{ asset('css/wpanel/library/jquery.toast.css') }}">
<script src="{{ asset('js/wpanel/library/jquery.toast.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let datePickerInstance;

        function initFlatpickr(mode, existingDate = null) {
            // Destruye cualquier instancia anterior
            if (datePickerInstance) {
                datePickerInstance.destroy();
            }

            // Crea una nueva instancia inline (calendario visible)
            datePickerInstance = flatpickr("#datePicker", {
                inline: true,
                mode: mode, // 'single', 'range' o 'multiple'
                dateFormat: "Y-m-d",
                minDate: "today",
                locale: "{{ app()->getLocale() }}",
                defaultDate: existingDate ? existingDate : null
            });
        }

        // Inicializa por defecto en modo "single"
        const existingDate = document.getElementById('datePicker').dataset.date;
        initFlatpickr('single', existingDate);

        // Cambia el modo dinámicamente
        document.getElementById('dateMode').addEventListener('change', function() {
            initFlatpickr(this.value);
        });
    });

    function removeSegment(buttonOrSegment) {
        const segment = buttonOrSegment.closest('[data-component=interval]');
        segment.remove();

        const firstSegmentContainer = document.getElementById(`first-segment`);
        const additionalContainer = document.getElementById(`segments`);

        // Si no hay segmentos en el principal y hay adicionales, mover uno arriba
        if (firstSegmentContainer.children.length === 0 && additionalContainer.children.length > 0) {
            const firstExtra = additionalContainer.children[0];
            firstSegmentContainer.appendChild(firstExtra);
        }
        checkOverlaps();
    }
    let $segmentIndex = 1;

    function addSegment() {
        const firstSegmentContainer = document.getElementById(`first-segment`);
        const additionalContainer = document.getElementById(`segments`);

        // Crear nuevo bloque
        const segment = document.createElement('div');
        segment.className = 'd-flex align-items-center gap-2 flex-wrap border p-2 rounded-2 bg-light';
        segment.setAttribute('data-component', 'interval');
        segment.setAttribute('style', 'padding-right: 1rem; margin-top: 0 !important; padding-top: 0 !important;');

        segment.innerHTML = `
                <div class="flex-grow-1">
                    <select class="form-select select2 form-select-m bg-white text-center"
                        name="schedule[${$segmentIndex}][from]">
                        ${[...Array(24).keys()].map(h => 
                            [...Array(4).keys()].map(m => {
                                const time = `${String(h).padStart(2, '0')}:${String(m * 15).padStart(2, '0')}`;
                                return `<option value="${time}" ${time === '09:00' ? 'selected' : ''}>${time}</option>`;
                            }).join('')
                        ).join('')}
                    </select>
                
                </div>
                <span class="text-muted">-</span>
                <div class="flex-grow-1">
                    <select class="form-select select2 form-select-m bg-white text-center" 
                        name="schedule[${$segmentIndex}][to]">
                        ${[...Array(24).keys()].map(h => 
                            [...Array(4).keys()].map(m => {
                                const time = `${String(h).padStart(2, '0')}:${String(m * 15).padStart(2, '0')}`;
                                return `<option value="${time}" ${time === '17:00' ? 'selected' : ''}>${time}</option>`;
                            }).join('')
                        ).join('')}
                    </select>
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger flex-shrink-0">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            `;
        $segmentIndex++;
        segment.querySelector('button').onclick = () => removeSegment(segment);

        // Si no hay ningún segmento en el principal, lo agregamos ahí 

        firstSegmentContainer.appendChild(segment);

        $(segment).find('.select2').select2({
            theme: "bootstrap-5",
            width: '100%',
            minimumResultsForSearch: Infinity,
            dropdownAutoWidth: true,
            dropdownCssClass: 'select2-no-scroll'
        });
        checkOverlaps();
    }

    function changeOptionDescription() {
        const mode = document.getElementById('dateMode').value;
        const instruction = document.getElementById('dateInstruction');
        const datePicker = document.getElementById('datePicker');

        switch (mode) {
            case 'single':
                instruction.textContent = 'Elige un solo día en el que quieras agregar tu disponibilidad.';
                datePicker.placeholder = 'Selecciona una fecha';
                break;

            case 'range':
                instruction.textContent = 'Elige la fecha de inicio y la fecha de fin para indicar el periodo disponible.';
                datePicker.placeholder = 'Selecciona un rango de fechas';
                break;

            case 'multiple':
                instruction.textContent = 'Elige varios días en los que estarás disponible.';
                datePicker.placeholder = 'Selecciona varias fechas';
                break;

        }
    }

    function validate() {
        var valid = true;
    }
</script>
<script>
    $('.select2').select2({
        theme: "bootstrap-5",
        width: '100%', // fuerza el ancho del select al contenedor
        minimumResultsForSearch: Infinity, // quita la barra de búsqueda
        dropdownAutoWidth: true, // ajusta el ancho del dropdown automáticamente
        dropdownCssClass: 'select2-no-scroll' // clase para eliminar scrollbar
    });

    // Quitar la scrollbar del dropdown
    $('.select2-no-scroll').css({
        'max-height': 'none',
        'overflow-y': 'visible'
    });
</script>
<style>
    /* Centrar solo el valor mostrado en el select */
    .select2-container--bootstrap-5 .select2-selection__rendered {
        text-align: center !important;
    }

    /* Mantener las opciones del dropdown alineadas a la izquierda */
    .select2-results__option {
        text-align: left !important;
    }
</style>
<style>
    /* Oculta completamente el input */
    #datePicker {
        display: none !important;
    }

    /* Opcional: elimina margen si quieres que el calendario quede pegado */
    .mb-3 {
        margin-bottom: 0 !important;
    }
</style>
<script>
    // Convierte "HH:MM" en minutos totales
    function timeToMinutes(str) {
        const [h, m] = str.split(':').map(Number);
        return h * 60 + m;
    }

    // Revisa si hay cruces entre los intervalos de un día
    function checkOverlaps() {
        const dayDiv = document.getElementById(`first-segment`).closest('.border.rounded-3');

        const firstContainer = document.getElementById(`first-segment`);
        const extraContainer = document.getElementById(`segments`);

        if (!firstContainer && !extraContainer) return false;

        // Buscar todos los segmentos del día
        const allSegments = [
            ...firstContainer.querySelectorAll('[data-component="interval"]'),
            ...extraContainer.querySelectorAll('[data-component="interval"]')
        ];

        const times = [];

        allSegments.forEach(seg => {
            const fromSelect = seg.querySelector('select[name*="[from]"]');
            const toSelect = seg.querySelector('select[name*="[to]"]');
            const from = fromSelect ? fromSelect.value : null;
            const to = toSelect ? toSelect.value : null;

            if (from && to) {
                times.push({
                    from: timeToMinutes(from),
                    to: timeToMinutes(to),
                    element: seg
                });
            }
        });

        // Limpiar estilos previos
        dayDiv.classList.remove('overlap');
        allSegments.forEach(seg => seg.classList.remove('overlap'));

        // Eliminar mensaje previo si existe
        const prevMsg = dayDiv.querySelector('.overlap-message');
        if (prevMsg) prevMsg.remove();

        // Ordenar por hora de inicio
        times.sort((a, b) => a.from - b.from);

        let hasOverlap = false;
        let hasInvalid = false;

        // Validación de from > to
        times.forEach(t => {
            if (t.from > t.to) {
                hasInvalid = true;
                t.element.classList.add('overlap');
            }
        });

        // Detectar solapamientos
        for (let i = 0; i < times.length - 1; i++) {
            if (times[i].to > times[i + 1].from) {
                hasOverlap = true;
            }
        }
        if (hasOverlap || hasInvalid) {
            dayDiv.classList.add('overlap');
            const msg = document.createElement('div');
            msg.className = 'overlap-message';
            if (hasInvalid && hasOverlap) {
                msg.textContent = '⚠ Revisa los horarios: algunos se solapan y otros tienen inicio mayor que el fin.';
            } else if (hasInvalid) {
                msg.textContent = '⚠ Este segmento tiene un horario de inicio mayor que el de fin.';
            } else {
                msg.textContent = '⚠ Algunos horarios se están solapando, revisa los segmentos.';
            }
            dayDiv.appendChild(msg);
        }
        return hasOverlap;
    }

    // Listener para cambios en selects (también funciona con elementos nuevos)
    // Detectar cambios en selects (incluye los manejados por Select2)
    document.addEventListener('change', function(e) {
        if (e.target.matches('select[name*="[from]"], select[name*="[to]"]')) {
            const match = e.target.name.match(/schedule\[(\d+)\]/);
            if (match) {
                const day = match[1];
                checkOverlaps(day);
            }
        }
    });


    // También detectar cambios cuando Select2 dispara su propio evento
    $(document).on('change.select2', 'select[name*="[from]"], select[name*="[to]"]', function() {
        const match = this.name.match(/schedule\[(\d+)\]/);
        if (match) {
            const day = match[1];
            checkOverlaps(day);
        }
    });


    // Verifica todos los días antes de enviar el formulario
    function validate() {
        let hasAnyOverlap = false;


        const overlap = checkOverlaps();
        if (overlap) hasAnyOverlap = true;


        if (hasAnyOverlap) {
            Swal.fire({
                title: 'Error',
                text: 'Hay horarios que se cruzan. Por favor corrígelos antes de continuar.',
                icon: 'error',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#4bc6f9',
                buttonsStyling: true
            });

            return false;
        }

        return true;
    }
</script>
<style>
    /* Estilo para segmentos con solapamientos */
    .overlap {
        border-color: #dc3545 !important;
        position: relative;
        margin-top: 25px !important;
    }

    .overlap-message {
        position: absolute;
        bottom: 100%;
        left: 0;
        margin-top: 0.25rem;
        background-color: #f8d7da;
        color: #842029;
        padding: 0.3rem 0.6rem;
        font-size: 0.875rem;
        border: 1px solid #f5c2c7;
        border-radius: 0.25rem;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        white-space: nowrap;
        z-index: 10;
    }
</style>
@endpush