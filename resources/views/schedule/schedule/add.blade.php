@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@include('elements.docmenu')

<section class="container-fluid pb-0 pb-lg-4">

    <div class="row px-2 px-lg-3 mt-2 mt-lg-4">

        <h1 class="h4 text-uppercase text-center text-md-start fw-normal mb-3"> <a href="{{ route('schedule.menu') }}" class="btn btn-sm smIcon"><i class="fa-solid fa-arrow-left-long"></i></a>{{ trans('dash.schedule.schedule.title1') }} <span class="text-info fw-bold">{{ trans('dash.schedule.schedule.title2') }}</span></h1>
        <form name="frmAddAppointment" id="frmAddAppointment" action="{{ route('schedule.storeSchedule') }}" method="post" onsubmit="return validate();" enctype="multipart/form-data" class="col-lg-10 col-xl-8 col-xxl-6 mx-auto mt-4 mt-lg-0 mb-lg-5">
            @csrf

            <div class="container mt-4 mx-auto" style="max-width: 600px;">
                @php
                $days = [
                0 => trans('dash.day.num0'),
                1 => trans('dash.day.num1'),
                2 => trans('dash.day.num2'),
                3 => trans('dash.day.num3'),
                4 => trans('dash.day.num4'),
                5 => trans('dash.day.num5'),
                6 => trans('dash.day.num6'),
                ];
                @endphp

                @foreach ($days as $dayNumber => $dayName)
                <div class="border rounded-3 p-2 px-3 mb-2">

                    {{-- Fila principal con label + botón + (primer segmento si existe) --}}
                    <div class="d-flex align-items-start flex-column">
                        <div class="d-flex align-items-start gap-3 flex-wrap w-100 mb-2" id="header-{{ $dayNumber }}">
                            <label class="fw-semibold text-primary mb-0" style="width: 90px;">{{ $dayName }}</label>

                            <div id="first-segment-{{ $dayNumber }}" class="flex-grow-1 d-flex flex-column gap-1">
                                @if(!in_array($dayNumber, [0, 6]))
                                <div style="padding-right: 1rem; margin-top: 0 !important; padding-top: 0 !important;" class="d-flex align-items-center gap-2 flex-wrap border p-2 rounded-2 bg-light"
                                    data-component="interval" size="6" id="segment-{{ $dayNumber }}-0">
                                    <div class="flex-grow-1">
                                        <select class="form-select select2 form-select-m bg-white text-center"
                                            name="schedule[{{ $dayNumber }}][0][from]">
                                            @for ($h = 0; $h < 24; $h++)
                                                @for ($m=0; $m < 60; $m +=15)
                                                @php
                                                $time=sprintf('%02d:%02d', $h, $m);
                                                @endphp
                                                <option value="{{ $time }}" {{ $time == '09:00' ? 'selected' : '' }}>{{ $time }}</option>
                                                @endfor
                                                @endfor
                                        </select>
                                    </div>
                                    <span class="text-muted">-</span>
                                    <div class="flex-grow-1">
                                        <select class="form-select select2 form-select-m bg-white text-center"
                                            name="schedule[{{ $dayNumber }}][0][to]">
                                            @for ($h = 0; $h < 24; $h++)
                                                @for ($m=0; $m < 60; $m +=15)
                                                @php
                                                $time=sprintf('%02d:%02d', $h, $m);
                                                @endphp
                                                <option value="{{ $time }}" {{ $time == '17:00' ? 'selected' : '' }}>{{ $time }}</option>
                                                @endfor
                                                @endfor
                                        </select>

                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-danger flex-shrink-0"
                                        onclick="removeSegment(this, {{ $dayNumber }})">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </div>
                                @endif
                            </div>

                            <button type="button" class="btn btn-sm btn-outline-primary"
                                onclick="addSegment({{ $dayNumber }})">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                onclick="showCopyDaysPopup({{ $dayNumber }})">
                                <i class="fa-solid fa-copy"></i>
                            </button>

                        </div>

                        {{-- Segmentos adicionales debajo --}}
                        <div id="segments-{{ $dayNumber }}" class="flex-grow-1 d-flex flex-column gap-1"></div>
                    </div>
                </div>
                @endforeach

                <div class="d-flex justify-content-end">
                    <div class="d-flex flex-column flex-md-row gap-2 gap-md-4">
                        <div class="d-none d-md-block">
                            <i class="fa-solid fa-angle-right fa-fw fs-5 mt-1 text-white"></i>
                        </div>
                        <div class="d-flex flex-column flex-sm-row gap-2">
                            <button type="submit" class="btn btn-primary px-4" id="btnSave">
                                {{ trans('dash.text.btn.save') }} <i class="fa-solid fa-angle-right fa-fw fs-5 mt-1 text-white"></i>
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

<script>
    let $segmentIndex = 1;

    function addSegment(day) {
        const firstSegmentContainer = document.getElementById(`first-segment-${day}`);
        const additionalContainer = document.getElementById(`segments-${day}`);

        // Crear nuevo bloque
        const segment = document.createElement('div');
        segment.className = 'd-flex align-items-center gap-2 flex-wrap border p-2 rounded-2 bg-light';
        segment.setAttribute('data-component', 'interval');
        segment.setAttribute('style', 'padding-right: 1rem; margin-top: 0 !important; padding-top: 0 !important;');

        segment.innerHTML = `
                <div class="flex-grow-1">
                    <select class="form-select select2 form-select-m bg-white text-center"
                        name="schedule[${day}][${$segmentIndex}][from]">
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
                        name="schedule[${day}][${$segmentIndex}][to]">
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

        segment.querySelector('button').onclick = () => removeSegment(segment, day);

        // Si no hay ningún segmento en el principal, lo agregamos ahí

        firstSegmentContainer.appendChild(segment);

        $(segment).find('.select2').select2({
            theme: "bootstrap-5",
            width: '100%',
            minimumResultsForSearch: Infinity,
            dropdownAutoWidth: true,
            dropdownCssClass: 'select2-no-scroll'
        });
        checkOverlaps(day);
    }

    function validate() {
        var valid = true;
    }

    function removeSegment(buttonOrSegment, day) {
        const segment = buttonOrSegment.closest('[data-component=interval]');
        segment.remove();

        const firstSegmentContainer = document.getElementById(`first-segment-${day}`);
        const additionalContainer = document.getElementById(`segments-${day}`);

        // Si no hay segmentos en el principal y hay adicionales, mover uno arriba
        if (firstSegmentContainer.children.length === 0 && additionalContainer.children.length > 0) {
            const firstExtra = additionalContainer.children[0];
            firstSegmentContainer.appendChild(firstExtra);
        }
        checkOverlaps(day);
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
<script>
    const dayNames = ['{{ trans("dash.day.num0") }}', '{{ trans("dash.day.num1") }}', '{{ trans("dash.day.num2") }}', '{{ trans("dash.day.num3") }}', '{{ trans("dash.day.num4") }}', '{{ trans("dash.day.num5") }}', '{{ trans("dash.day.num6") }}'];

    function showCopyDaysPopup(baseDay) {
        // Cerrar cualquier popup anterior
        document.querySelectorAll('.copy-days-popup').forEach(p => p.remove());

        // Crear el contenedor flotante
        const popup = document.createElement('div');
        popup.className = 'copy-days-popup border bg-white p-3 rounded shadow position-absolute';
        popup.style.zIndex = '1000';
        popup.style.minWidth = '180px';

        // Generar los checkboxes de días
        let html = '<strong class="d-block mb-2 text-center">{{ trans("dash.schedule.schedule.copy") }}</strong>';
        dayNames.forEach((name, i) => {
            if (i !== baseDay) {
                html += `
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="${i}" id="copy-day-${i}">
                        <label class="form-check-label small" for="copy-day-${i}">${name}</label>
                    </div>
                `;
            }
        });

        html += `
            <div class="text-center mt-2">
                <button type="button" class="btn btn-sm btn-primary" onclick="applyCopy(${baseDay})">{{ trans("dash.label.btn.continue") }}</button>
            </div>
        `;

        popup.innerHTML = html;
        document.body.appendChild(popup);

        // Posicionar el popup junto al botón presionado
        const button = event.target.closest('button');
        const rect = button.getBoundingClientRect();
        popup.style.top = `${rect.bottom + window.scrollY + 5}px`;
        popup.style.left = `${rect.left + window.scrollX}px`;
    }

    function applyCopy(baseDay) {
        const selectedDays = Array.from(document.querySelectorAll('.copy-days-popup input:checked'))
            .map(i => parseInt(i.value));

        const baseContainer = document.getElementById(`first-segment-${baseDay}`);
        const baseSegments = baseContainer.querySelectorAll('[data-component="interval"]');

        selectedDays.forEach(day => {
            const firstContainer = document.getElementById(`first-segment-${day}`);
            const extraContainer = document.getElementById(`segments-${day}`);

            // ✅ Paso 1: eliminar cualquier segmento existente del día seleccionado
            firstContainer.innerHTML = '';
            extraContainer.innerHTML = '';

            // ✅ Paso 2: clonar los segmentos del día base
            baseSegments.forEach(seg => {
                const clone = document.createElement('div');
                clone.className = seg.className;
                clone.setAttribute('data-component', 'interval');

                const fromOriginal = seg.querySelector('select[name*="[from]"]');
                const toOriginal = seg.querySelector('select[name*="[to]"]');

                // Crear nuevos selects limpios y asignar valor actual
                const fromClone = document.createElement('select');
                fromClone.className = fromOriginal.className;
                fromClone.name = fromOriginal.name.replace(`[${baseDay}]`, `[${day}]`);
                fromClone.innerHTML = fromOriginal.innerHTML;
                fromClone.value = fromOriginal.value;

                const toClone = document.createElement('select');
                toClone.className = toOriginal.className;
                toClone.name = toOriginal.name.replace(`[${baseDay}]`, `[${day}]`);
                toClone.innerHTML = toOriginal.innerHTML;
                toClone.value = toOriginal.value;

                clone.innerHTML = `<div class="flex-grow-1"></div><span class="text-muted">-</span><div class="flex-grow-1"></div>`;
                clone.querySelectorAll('div.flex-grow-1')[0].appendChild(fromClone);
                clone.querySelectorAll('div.flex-grow-1')[1].appendChild(toClone);

                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'btn btn-sm btn-outline-danger flex-shrink-0';
                removeBtn.innerHTML = '<i class="fa-solid fa-xmark"></i>';
                removeBtn.onclick = () => removeSegment(clone, day);
                clone.appendChild(removeBtn);

                firstContainer.appendChild(clone);

                $(fromClone).select2({
                    theme: "bootstrap-5",
                    width: '100%',
                    minimumResultsForSearch: Infinity,
                    dropdownAutoWidth: true,
                    dropdownCssClass: 'select2-no-scroll'
                });
                $(toClone).select2({
                    theme: "bootstrap-5",
                    width: '100%',
                    minimumResultsForSearch: Infinity,
                    dropdownAutoWidth: true,
                    dropdownCssClass: 'select2-no-scroll'
                });
            });
            checkOverlaps(day);
        });

        // Cerrar el popup
        document.querySelectorAll('.copy-days-popup').forEach(p => p.remove());
    }

    // Cierra el popup si se hace clic fuera
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.copy-days-popup') && !e.target.closest('.btn-outline-secondary')) {
            document.querySelectorAll('.copy-days-popup').forEach(p => p.remove());
        }
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
<script>
    // Convierte "HH:MM" en minutos totales
    function timeToMinutes(str) {
        const [h, m] = str.split(':').map(Number);
        return h * 60 + m;
    }

    // Revisa si hay cruces entre los intervalos de un día
    function checkOverlaps(day) {
        const dayDiv = document.getElementById(`first-segment-${day}`).closest('.border.rounded-3');

        const firstContainer = document.getElementById(`first-segment-${day}`);
        const extraContainer = document.getElementById(`segments-${day}`);

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
                msg.textContent = '⚠ ' + '{{ trans("dash.schedule.schedule.alert.overlaptime") }}';
            } else if (hasInvalid) {
                msg.textContent = '⚠ ' + '{{ trans("dash.schedule.schedule.alert.badtime") }}';
            } else {
                msg.textContent = '⚠ ' + '{{ trans("dash.schedule.schedule.alert.overlap") }}';
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

        for (let day = 0; day <= 6; day++) {
            const overlap = checkOverlaps(day);
            if (overlap) hasAnyOverlap = true;
        }

        if (hasAnyOverlap) {
            Swal.fire({
                title: 'Error',
                text: '{{ trans("dash.schedule.schedule.alert.overlaptime") }}',
                icon: 'error',
                confirmButtonText: '{{ trans("dash.label.btn.continue") }}',
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