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

    $detailsByDay = [];
    if (isset($schedule) && $schedule) {
        foreach ($schedule->scheduleDetails as $detail) {
            $detailsByDay[$detail->day_of_week][] = $detail;
        }
    }
    $hasDetails = !empty($detailsByDay);
@endphp

@foreach ($days as $dayNumber => $dayName)
    <div class="border rounded-3 p-2 px-3 mb-2">
        <div class="d-flex align-items-start flex-column">
            <div class="d-flex align-items-start gap-3 flex-wrap w-100 mb-2" id="header-{{ $dayNumber }}">
                <label class="fw-semibold text-primary mb-0" style="width: 90px;">{{ $dayName }}</label>

                <div id="first-segment-{{ $dayNumber }}" class="flex-grow-1 d-flex flex-column gap-1">
                    @php
                        $dayDetails = $detailsByDay[$dayNumber] ?? [];
                    @endphp
                    @if ($hasDetails && count($dayDetails))
                        @foreach ($dayDetails as $index => $detail)
                            <div style="padding-right: 1rem; margin-top: 0 !important; padding-top: 0 !important;" class="d-flex align-items-center gap-2 flex-wrap border p-2 rounded-2 bg-light"
                                 data-component="interval" size="6" id="segment-{{ $dayNumber }}-{{ $index }}">
                                <div class="flex-grow-1">
                                    <select class="form-select schedule-select form-select-m bg-white text-center"
                                            name="schedule[{{ $dayNumber }}][{{ $index }}][from]">
                                        @for ($h = 0; $h < 24; $h++)
                                            @for ($m=0; $m < 60; $m +=15)
                                                @php
                                                    $time = sprintf('%02d:%02d', $h, $m);
                                                    $timeCompare = $time . ':00';
                                                @endphp
                                                <option value="{{ $time }}" {{ ($detail && $timeCompare === $detail->start_time) ? 'selected' : '' }}>{{ $time }}</option>
                                            @endfor
                                        @endfor
                                    </select>
                                </div>
                                <span class="text-muted">-</span>
                                <div class="flex-grow-1">
                                    <select class="form-select schedule-select form-select-m bg-white text-center"
                                            name="schedule[{{ $dayNumber }}][{{ $index }}][to]">
                                        @for ($h = 0; $h < 24; $h++)
                                            @for ($m=0; $m < 60; $m +=15)
                                                @php
                                                    $time = sprintf('%02d:%02d', $h, $m);
                                                    $timeCompare = $time . ':00';
                                                @endphp
                                                <option value="{{ $time }}" {{ ($detail && $timeCompare === $detail->end_time) ? 'selected' : '' }}>{{ $time }}</option>
                                            @endfor
                                        @endfor
                                    </select>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-danger flex-shrink-0"
                                        onclick="removeSegment(this, {{ $dayNumber }})">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                        @endforeach
                    @elseif (!$hasDetails && !in_array($dayNumber, [0, 6]))
                        <div style="padding-right: 1rem; margin-top: 0 !important; padding-top: 0 !important;" class="d-flex align-items-center gap-2 flex-wrap border p-2 rounded-2 bg-light"
                             data-component="interval" size="6" id="segment-{{ $dayNumber }}-0">
                            <div class="flex-grow-1">
                                <select class="form-select schedule-select form-select-m bg-white text-center"
                                        name="schedule[{{ $dayNumber }}][0][from]">
                                    @for ($h = 0; $h < 24; $h++)
                                        @for ($m=0; $m < 60; $m +=15)
                                            @php
                                                $time = sprintf('%02d:%02d', $h, $m);
                                            @endphp
                                            <option value="{{ $time }}" {{ $time == '09:00' ? 'selected' : '' }}>{{ $time }}</option>
                                        @endfor
                                    @endfor
                                </select>
                            </div>
                            <span class="text-muted">-</span>
                            <div class="flex-grow-1">
                                <select class="form-select schedule-select form-select-m bg-white text-center"
                                        name="schedule[{{ $dayNumber }}][0][to]">
                                    @for ($h = 0; $h < 24; $h++)
                                        @for ($m=0; $m < 60; $m +=15)
                                            @php
                                                $time = sprintf('%02d:%02d', $h, $m);
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
                        onclick="showCopyDaysPopup({{ $dayNumber }}, event)">
                    <i class="fa-solid fa-copy"></i>
                </button>
            </div>

            <div id="segments-{{ $dayNumber }}" class="flex-grow-1 d-flex flex-column gap-1"></div>
        </div>
    </div>
@endforeach
