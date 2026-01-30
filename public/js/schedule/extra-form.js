(function() {
    const helpers = window.vetegramHelpers || {};
    const config = window.SCHEDULE_EXTRA_FORM_CONFIG || {};
    const texts = config.texts || {};
    const locale = config.locale || 'es';

    let datePickerInstance = null;
    let segmentIndex = 1;

    function initFlatpickr(mode) {
        if (typeof flatpickr === 'undefined') {
            return;
        }
        if (datePickerInstance) {
            datePickerInstance.destroy();
        }
        const datePicker = document.getElementById('datePicker');
        const existingDate = datePicker && datePicker.dataset ? datePicker.dataset.date : null;
        datePickerInstance = flatpickr('#datePicker', {
            inline: true,
            mode: mode,
            dateFormat: 'Y-m-d',
            minDate: 'today',
            locale: locale,
            defaultDate: existingDate || null
        });
    }

    function initSelect2(context) {
        if (!helpers.initSelect2) {
            return;
        }
        helpers.initSelect2('.select2', {
            width: '100%',
            minimumResultsForSearch: Infinity,
            dropdownAutoWidth: true,
            dropdownCssClass: 'select2-no-scroll'
        }, context);
        if (typeof $ !== 'undefined') {
            $('.select2-no-scroll').css({
                'max-height': 'none',
                'overflow-y': 'visible'
            });
        }
    }

    function buildTimeOptions(selected) {
        let html = '';
        for (let h = 0; h < 24; h++) {
            for (let m = 0; m < 60; m += 15) {
                const time = `${String(h).padStart(2, '0')}:${String(m).padStart(2, '0')}`;
                html += `<option value="${time}" ${time === selected ? 'selected' : ''}>${time}</option>`;
            }
        }
        return html;
    }

    function removeSegment(buttonOrSegment) {
        const segment = buttonOrSegment.closest('[data-component=interval]');
        if (!segment) return;
        segment.remove();

        const firstSegmentContainer = document.getElementById('first-segment');
        const additionalContainer = document.getElementById('segments');

        if (firstSegmentContainer && additionalContainer && firstSegmentContainer.children.length === 0 && additionalContainer.children.length > 0) {
            const firstExtra = additionalContainer.children[0];
            firstSegmentContainer.appendChild(firstExtra);
        }
        checkOverlaps();
    }

    function addSegment() {
        const firstSegmentContainer = document.getElementById('first-segment');
        if (!firstSegmentContainer) return;

        const segment = document.createElement('div');
        segment.className = 'd-flex align-items-center gap-2 flex-wrap border p-2 rounded-2 bg-light';
        segment.setAttribute('data-component', 'interval');
        segment.setAttribute('style', 'padding-right: 1rem; margin-top: 0 !important; padding-top: 0 !important;');

        segment.innerHTML = `
            <div class="flex-grow-1">
                <select class="form-select select2 form-select-m bg-white text-center"
                    name="schedule[${segmentIndex}][from]">
                    ${buildTimeOptions('09:00')}
                </select>
            </div>
            <span class="text-muted">-</span>
            <div class="flex-grow-1">
                <select class="form-select select2 form-select-m bg-white text-center"
                    name="schedule[${segmentIndex}][to]">
                    ${buildTimeOptions('17:00')}
                </select>
            </div>
            <button type="button" class="btn btn-sm btn-outline-danger flex-shrink-0">
                <i class="fa-solid fa-xmark"></i>
            </button>
        `;
        segmentIndex++;

        firstSegmentContainer.appendChild(segment);
        initSelect2(segment);
        checkOverlaps();
    }

    function changeOptionDescription() {
        const mode = document.getElementById('dateMode')?.value || 'single';
        const instruction = document.getElementById('dateInstruction');
        const datePicker = document.getElementById('datePicker');

        if (!instruction || !datePicker) return;

        if (mode === 'single') {
            instruction.textContent = texts.instructionSingle || '';
            datePicker.placeholder = texts.placeholderSingle || '';
        } else if (mode === 'range') {
            instruction.textContent = texts.instructionRange || '';
            datePicker.placeholder = texts.placeholderRange || '';
        } else {
            instruction.textContent = texts.instructionMultiple || '';
            datePicker.placeholder = texts.placeholderMultiple || '';
        }
    }

    function timeToMinutes(str) {
        const parts = str.split(':').map(Number);
        return (parts[0] * 60) + parts[1];
    }

    function checkOverlaps() {
        const firstSegment = document.getElementById('first-segment');
        if (!firstSegment) return false;
        const dayDiv = firstSegment.closest('.border.rounded-3');
        const extraContainer = document.getElementById('segments');

        if (!dayDiv || !extraContainer) return false;

        const allSegments = [
            ...firstSegment.querySelectorAll('[data-component="interval"]'),
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

        dayDiv.classList.remove('overlap');
        allSegments.forEach(seg => seg.classList.remove('overlap'));

        const prevMsg = dayDiv.querySelector('.overlap-message');
        if (prevMsg) prevMsg.remove();

        times.sort((a, b) => a.from - b.from);

        let hasOverlap = false;
        let hasInvalid = false;

        times.forEach(t => {
            if (t.from > t.to) {
                hasInvalid = true;
                t.element.classList.add('overlap');
            }
        });

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
                msg.textContent = '⚠ ' + (texts.overlapBoth || '');
            } else if (hasInvalid) {
                msg.textContent = '⚠ ' + (texts.overlapInvalid || '');
            } else {
                msg.textContent = '⚠ ' + (texts.overlapOnly || '');
            }
            dayDiv.appendChild(msg);
        }
        return hasOverlap || hasInvalid;
    }

    function validate() {
        const hasAnyOverlap = checkOverlaps();
        if (hasAnyOverlap && window.Swal) {
            Swal.fire({
                title: texts.overlapTitle || 'Error',
                text: texts.overlapAlert || '',
                icon: 'error',
                confirmButtonText: texts.overlapConfirm || '',
                confirmButtonColor: '#4bc6f9',
                buttonsStyling: true
            });
            return false;
        }
        return true;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const dateModeEl = document.getElementById('dateMode');
        initFlatpickr(dateModeEl ? dateModeEl.value : 'single');
        if (dateModeEl) {
            dateModeEl.addEventListener('change', function() {
                initFlatpickr(this.value);
                changeOptionDescription();
            });
        }
        initSelect2();
        changeOptionDescription();
    });

    document.addEventListener('change', function(e) {
        if (e.target.matches('select[name*="[from]"], select[name*="[to]"]')) {
            checkOverlaps();
        }
    });

    if (typeof $ !== 'undefined') {
        $(document).on('change.select2', 'select[name*="[from]"], select[name*="[to]"]', function() {
            checkOverlaps();
        });
    }

    document.addEventListener('click', function(e) {
        const addBtn = e.target.closest('[data-schedule-action=\"segment-add\"]');
        if (addBtn) {
            addSegment();
            return;
        }
        const removeBtn = e.target.closest('[data-schedule-action=\"segment-remove\"]');
        if (removeBtn) {
            removeSegment(removeBtn);
        }
    });
})();
