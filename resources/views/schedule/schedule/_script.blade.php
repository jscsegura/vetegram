<script>
    (function() {
        let scheduleSegmentIndex = 1;
        const dayNames = ['{{ trans("dash.day.num0") }}', '{{ trans("dash.day.num1") }}', '{{ trans("dash.day.num2") }}', '{{ trans("dash.day.num3") }}', '{{ trans("dash.day.num4") }}', '{{ trans("dash.day.num5") }}', '{{ trans("dash.day.num6") }}'];

        function buildTimeOptions(defaultValue) {
            let options = '';
            for (let h = 0; h < 24; h++) {
                for (let m = 0; m < 60; m += 15) {
                    const time = `${String(h).padStart(2, '0')}:${String(m).padStart(2, '0')}`;
                    options += `<option value="${time}" ${time === defaultValue ? 'selected' : ''}>${time}</option>`;
                }
            }
            return options;
        }

        function initScheduleSelects(context) {
            const $ctx = context ? $(context) : $(document);
            const dropdownParent = $('.schedule-modal-content').length ? $('.schedule-modal-content') : ($(document.body));
            $ctx.find('.schedule-select').select2({
                theme: "bootstrap-5",
                width: '100%',
                minimumResultsForSearch: Infinity,
                dropdownAutoWidth: true,
                dropdownCssClass: 'select2-no-scroll',
                dropdownParent: dropdownParent
            });
        }

        function addSegment(day) {
            const firstSegmentContainer = document.getElementById(`first-segment-${day}`);
            if (!firstSegmentContainer) return;

            const segment = document.createElement('div');
            segment.className = 'd-flex align-items-center gap-2 flex-wrap border p-2 rounded-2 bg-light';
            segment.setAttribute('data-component', 'interval');
            segment.setAttribute('style', 'padding-right: 1rem; margin-top: 0 !important; padding-top: 0 !important;');

            segment.innerHTML = `
                <div class="flex-grow-1">
                    <select class="form-select schedule-select form-select-m bg-white text-center"
                        name="schedule[${day}][${scheduleSegmentIndex}][from]">
                        ${buildTimeOptions('09:00')}
                    </select>
                </div>
                <span class="text-muted">-</span>
                <div class="flex-grow-1">
                    <select class="form-select schedule-select form-select-m bg-white text-center"
                        name="schedule[${day}][${scheduleSegmentIndex}][to]">
                        ${buildTimeOptions('17:00')}
                    </select>
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger flex-shrink-0">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            `;
            scheduleSegmentIndex++;

            segment.querySelector('button').onclick = () => removeSegment(segment, day);
            firstSegmentContainer.appendChild(segment);
            initScheduleSelects(segment);
            checkOverlaps(day);
        }

        function removeSegment(buttonOrSegment, day) {
            const segment = buttonOrSegment.closest('[data-component=interval]');
            if (!segment) return;
            segment.remove();

            const firstSegmentContainer = document.getElementById(`first-segment-${day}`);
            const additionalContainer = document.getElementById(`segments-${day}`);

            if (firstSegmentContainer && additionalContainer && firstSegmentContainer.children.length === 0 && additionalContainer.children.length > 0) {
                const firstExtra = additionalContainer.children[0];
                firstSegmentContainer.appendChild(firstExtra);
            }
            checkOverlaps(day);
        }

        function showCopyDaysPopup(baseDay, ev) {
            document.querySelectorAll('.copy-days-popup').forEach(p => p.remove());
            const popup = document.createElement('div');
            popup.className = 'copy-days-popup border bg-white p-3 rounded shadow position-absolute';
            popup.style.zIndex = '1000';
            popup.style.minWidth = '180px';

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

            const evt = ev || window.event;
            const button = evt ? evt.target.closest('button') : null;
            if (!button) return;
            const rect = button.getBoundingClientRect();
            popup.style.top = `${rect.bottom + window.scrollY + 5}px`;
            popup.style.left = `${rect.left + window.scrollX}px`;
        }

        function applyCopy(baseDay) {
            const selectedDays = Array.from(document.querySelectorAll('.copy-days-popup input:checked'))
                .map(i => parseInt(i.value, 10));

            const baseContainer = document.getElementById(`first-segment-${baseDay}`);
            if (!baseContainer) return;
            const baseSegments = baseContainer.querySelectorAll('[data-component="interval"]');

            selectedDays.forEach(day => {
                const firstContainer = document.getElementById(`first-segment-${day}`);
                const extraContainer = document.getElementById(`segments-${day}`);
                if (!firstContainer || !extraContainer) return;

                firstContainer.innerHTML = '';
                extraContainer.innerHTML = '';

                baseSegments.forEach(seg => {
                    const clone = document.createElement('div');
                    clone.className = seg.className;
                    clone.setAttribute('data-component', 'interval');

                    const fromOriginal = seg.querySelector('select[name*="[from]"]');
                    const toOriginal = seg.querySelector('select[name*="[to]"]');
                    if (!fromOriginal || !toOriginal) return;

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
                    initScheduleSelects(clone);
                });
                checkOverlaps(day);
            });

            document.querySelectorAll('.copy-days-popup').forEach(p => p.remove());
        }

        function timeToMinutes(str) {
            const parts = str.split(':').map(Number);
            return (parts[0] * 60) + parts[1];
        }

        function checkOverlaps(day) {
            const dayDiv = document.getElementById(`first-segment-${day}`)?.closest('.border.rounded-3');
            const firstContainer = document.getElementById(`first-segment-${day}`);
            const extraContainer = document.getElementById(`segments-${day}`);
            if (!firstContainer || !extraContainer || !dayDiv) return false;

            const allSegments = [
                ...firstContainer.querySelectorAll('[data-component="interval"]'),
                ...extraContainer.querySelectorAll('[data-component="interval"]')
            ];

            const times = [];
            allSegments.forEach(seg => {
                const fromSelect = seg.querySelector('select[name*="[from]"]');
                const toSelect = seg.querySelector('select[name*="[to]"]');
                if (!fromSelect || !toSelect) return;
                if (fromSelect.value && toSelect.value) {
                    times.push({
                        from: timeToMinutes(fromSelect.value),
                        to: timeToMinutes(toSelect.value),
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
                    msg.textContent = '⚠ ' + '{{ trans("dash.schedule.schedule.alert.overlaptime") }}';
                } else if (hasInvalid) {
                    msg.textContent = '⚠ ' + '{{ trans("dash.schedule.schedule.alert.badtime") }}';
                } else {
                    msg.textContent = '⚠ ' + '{{ trans("dash.schedule.schedule.alert.overlap") }}';
                }
                dayDiv.appendChild(msg);
            }
            return hasOverlap || hasInvalid;
        }

        function validateSchedule() {
            let hasAnyOverlap = false;
            for (let day = 0; day <= 6; day++) {
                if (checkOverlaps(day)) {
                    hasAnyOverlap = true;
                }
            }
            if (hasAnyOverlap) {
                if (window.Swal) {
                    Swal.fire({
                        title: 'Error',
                        text: '{{ trans("dash.schedule.schedule.alert.overlaptime") }}',
                        icon: 'error',
                        confirmButtonText: '{{ trans("dash.label.btn.continue") }}',
                        confirmButtonColor: '#4bc6f9',
                        buttonsStyling: true
                    });
                }
                return false;
            }
            return true;
        }

        document.addEventListener('change', function(e) {
            if (e.target.matches('select[name*="[from]"], select[name*="[to]"]')) {
                const match = e.target.name.match(/schedule\\[(\\d+)\\]/);
                if (match) {
                    checkOverlaps(match[1]);
                }
            }
        });

        $(document).on('change.select2', 'select[name*="[from]"], select[name*="[to]"]', function() {
            const match = this.name.match(/schedule\\[(\\d+)\\]/);
            if (match) {
                checkOverlaps(match[1]);
            }
        });

        document.addEventListener('click', (e) => {
            if (!e.target.closest('.copy-days-popup') && !e.target.closest('.btn-outline-secondary')) {
                document.querySelectorAll('.copy-days-popup').forEach(p => p.remove());
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            initScheduleSelects();
            scheduleSegmentIndex = document.querySelectorAll('[data-component=\"interval\"]').length + 1;
        });

        window.addSegment = addSegment;
        window.removeSegment = removeSegment;
        window.showCopyDaysPopup = showCopyDaysPopup;
        window.applyCopy = applyCopy;
        window.checkOverlaps = checkOverlaps;
        window.validateSchedule = validateSchedule;
    })();
</script>
<style>
    .select2-container--bootstrap-5 .select2-selection__rendered {
        text-align: center !important;
    }
    .select2-results__option {
        text-align: left !important;
    }
    .select2-no-scroll {
        max-height: none;
        overflow-y: visible;
    }
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
