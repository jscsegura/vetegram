@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@include('elements.docmenu')

<section class="container-fluid pb-0 pb-lg-4">
    <div class="row px-2 px-lg-3 mt-2 mt-lg-4 mb-3 mb-lg-5">
        
        <div class="col px-xl-5">

            <div class="row mb-3 gap-3 align-items-center">
                <div class="col-lg-3 col-xl-4">
                    <h1 class="h4 text-uppercase justify-content-center justify-content-lg-start mb-0 fw-normal d-flex gap-1 align-items-center">
                        <a href="{{ route('admin') }}" class="btn btn-sm smIcon"><i class="fa-solid fa-arrow-left-long"></i></a>
                        <span>{{ trans('dash.label.calendar') }}</span>
                    </h1>
                </div>
                <div class="col-lg-6 col-xl-4 d-flex gap-2 justify-content-center">
                    <a href="{{ route('sett.index') }}" class="btn btn-primary btn-sm text-uppercase px-3 px-lg-4">{{ trans('dash.label.calendar.recurrent') }}</a>
                    <a href="{{ route('sett.edit') }}" class="btn btn-sm text-uppercase px-3 px-lg-4">{{ trans('dash.label.calendar.specific') }}</a>
                </div>
            </div>

            <div class="col-lg-10 col-xl-9 col-xxl-8 mx-auto alert alert-primary text-center mb-3 mb-md-4 small" role="alert">
                <i class="fa-solid fa-triangle-exclamation opacity-50 me-2"></i>{{ trans('dash.label.calendar.custom.days') }}
            </div>

            @if((count($template1) + count($template2) + count($template3) + count($template4) + count($template5) + count($template6) + count($template7)) == 0)
                <form class="col-lg-10 col-xl-9 col-xxl-8 mx-auto mt-3 mt-md-4 p-4 p-lg-5 rounded-3 border border-2 border-secondary" id="initialFrm" action="{{ route('sett.generateTemplate') }}" method="post" data-action="Settings.validategenerate" data-action-event="submit">
                    
                    @csrf

                    <h2 class="h4 fw-bold text-center text-uppercase mb-2 mb-lg-3 text-primary">{{ trans('dash.label.initial.config') }}</h2>
                    <div>
                        <div class="mb-3 mb-md-4">
                            <label for="loadDays" class="form-label small">{{ trans('dash.label.available.days') }}</label>
                            <select class="form-select select2 loadfield" id="loadDays" name="loadDays[]" data-placeholder="label.selected" multiple>
                                <option value="1">{{ trans('dash.day.num1') }}</option>
                                <option value="2">{{ trans('dash.day.num2') }}</option>
                                <option value="3">{{ trans('dash.day.num3') }}</option>
                                <option value="4">{{ trans('dash.day.num4') }}</option>
                                <option value="5">{{ trans('dash.day.num5') }}</option>
                                <option value="6">{{ trans('dash.day.num6') }}</option>
                                <option value="0">{{ trans('dash.day.num0') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex flex-column flex-md-row gap-3 gap-md-4 mb-3 mb-md-4">
                        <div>
                            <label for="loadTime" class="form-label small">{{ trans('dash.label.cita.duration') }}</label>
                            <select class="form-select fc loadfield" id="loadTime" name="loadTime">
                                <option value="">{{ trans('dash.label.selected') }}</option>
                                @for($i = 5; $i <= 240; $i++)
                                @php $minute = ''; @endphp
                                @if ($i < 60)
                                    @php $minute = $i . ' ' . trans('dash.label.minutes.date'); @endphp
                                @elseif ($i < 120)
                                    @php $minute = '1 ' . trans('dash.label.hour.date') . ' ' . ($i - 60) . ' ' . trans('dash.label.minutes.date'); @endphp
                                @elseif ($i < 180)
                                    @php $minute = '2 ' . trans('dash.label.hours.date') . ' ' . ($i - 120) . ' ' . trans('dash.label.minutes.date'); @endphp
                                @elseif ($i < 240)
                                    @php $minute = '3 ' . trans('dash.label.hours.date') . ' ' . ($i - 180) . ' ' . trans('dash.label.minutes.date'); @endphp
                                @else
                                    @php $minute = '4 ' . trans('dash.label.hours.date'); @endphp
                                @endif
                                <option value="{{ $i }}">{{ str_replace(" 0 " . trans('dash.label.minutes.date'),"", $minute) }}</option>
                                @php $i = $i + 4; @endphp
                                @endfor
                            </select>
                        </div>
                        <div class="flex-grow-1">
                            <label for="loadStart" class="form-label small">{{ trans('dash.label.date.time.start') }}</label>
                            <select class="form-select fc loadfield" id="loadStart" name="loadStart">
                                <option value="">{{ trans('dash.label.selected') }}</option>
                                @for($i = 1; $i < 12; $i++)
                                <option value="{{ str_pad($i, 2, "0", STR_PAD_LEFT) }}:00:00">{{ str_pad($i, 2, "0", STR_PAD_LEFT) }}:00 am</option>
                                @endfor
                                <option value="12:00:00">12:00 md</option>
                                @for($i = 1; $i < 12; $i++)
                                <option value="{{ str_pad($i + 12, 2, "0", STR_PAD_LEFT) }}:00:00">{{ str_pad($i, 2, "0", STR_PAD_LEFT) }}:00 pm</option>
                                @endfor
                            </select>
                        </div>
                        <div class="flex-grow-1">
                            <label for="loadEnd" class="form-label small">{{ trans('dash.label.date.time.end') }}</label>
                            <select class="form-select fc loadfield" id="loadEnd" name="loadEnd">
                                <option value="">{{ trans('dash.label.selected') }}</option>
                                @for($i = 1; $i < 12; $i++)
                                <option value="{{ str_pad($i, 2, "0", STR_PAD_LEFT) }}:00:00">{{ str_pad($i, 2, "0", STR_PAD_LEFT) }}:00 am</option>
                                @endfor
                                <option value="12:00:00">12:00 md</option>
                                @for($i = 1; $i < 12; $i++)
                                <option value="{{ str_pad($i + 12, 2, "0", STR_PAD_LEFT) }}:00:00">{{ str_pad($i, 2, "0", STR_PAD_LEFT) }}:00 pm</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary px-4 mt-4">{{ trans('dash.label.generate.cups') }}</button>
                </form>
            @endif

            <form>
                <div class="col-lg-10 col-xl-9 col-xxl-8 mx-auto mt-3 mt-md-4 p-4 p-lg-5 rounded-3 border border-2 border-secondary">
                    <h2 class="h4 fw-bold text-center text-uppercase mb-2 mb-lg-3 text-primary">{{ trans('dash.label.general.options') }}</h2>
                    <h2 class="h5 text-uppercase opacity-75 fw-medium">{{ trans('dash.label.accept.clinic.citas') }}</h2>
                    <div class="form-check mb-1">
                        <input class="form-check-input" type="checkbox" value="1" id="onlineBooking" name="onlineBooking" @if($online_booking == 1) checked @endif>
                        <label class="form-check-label fw-medium" for="onlineBooking">
                            {{ trans('dash.label.accept.clinic.accept') }}
                        </label>
                        <small class="d-block small opacity-75">
                            {{ trans('dash.label.not.accept.clinic') }}
                        </small>
                    </div>

                    <h2 class="h5 text-uppercase opacity-75 fw-medium mt-4">{{ trans('dash.label.select.cups') }}</h2>
                    <div class="d-flex flex-column gap-3">
                        <div class="flex-grow-1">
                            <ul class="list-group">
                                <li class="list-group-item d-flex gap-2">
                                    <div><input class="form-check-input" type="radio" name="mode" id="automatic" value="1" @if($mode == 1) checked @endif></div>
                                    <div>
                                        <label class="form-check-label stretched-link fw-medium" for="automatic">{{ trans('dash.label.cups.auto') }}</label>
                                        <small class="d-block small opacity-75">{{ trans('dash.label.cups.auto.text') }}</small>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex gap-2">
                                    <div><input class="form-check-input" type="radio" name="mode" id="manual" value="0" @if($mode == 0) checked @endif></div>
                                    <div>
                                        <label class="form-check-label stretched-link fw-medium" for="manual">{{ trans('dash.label.cups.manual') }}</label>
                                        <small class="d-block small opacity-75">{{ trans('dash.label.cups.manual.text') }}</small>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="text-end">
                            <a data-action="Settings.updateMode" data-action-event="click" class="btn btn-outline-primary btn-sm text-uppercase px-3 text-nowrap" id="btn-mode"><i class="fa-regular fa-floppy-disk me-2"></i>{{ trans('dash.text.btn.save') }}</a>
                        </div>
                    </div>

                </div>
            </form>

            <form>
                <div class="col-lg-10 col-xl-9 col-xxl-8 mx-auto mt-4 mt-md-5">
                    <h2 class="h4 fw-bold text-center text-uppercase mb-2 mb-lg-3 text-primary">{{ trans('dash.label.available.cups') }}</h2>
                    <div class="bg-light p-4 rounded-3 mb-4">
                        <div class="d-flex flex-column flex-md-row gap-3 gap-md-4 align-items-md-end mt-2">
                            <div class="flex-grow-1">
                                <label for="templateDay" class="form-label small">{{ trans('dash.label.element.day') }}</label>
                                <select class="form-select fc requeridoadd bg-transparent" id="templateDay" name="templateDay">
                                    <option value="">{{ trans('dash.label.selected') }}</option>
                                    <option value="1">{{ trans('dash.day.num1') }}</option>
                                    <option value="2">{{ trans('dash.day.num2') }}</option>
                                    <option value="3">{{ trans('dash.day.num3') }}</option>
                                    <option value="4">{{ trans('dash.day.num4') }}</option>
                                    <option value="5">{{ trans('dash.day.num5') }}</option>
                                    <option value="6">{{ trans('dash.day.num6') }}</option>
                                    <option value="0">{{ trans('dash.day.num0') }}</option>
                                </select>
                            </div>
                            <div class="flex-grow-1">
                                <label for="templateHour" class="form-label small">{{ trans('dash.label.hour') }}</label>
                                <select class="form-select fc requeridoadd bg-transparent" id="templateHour" name="templateHour">
                                    <option value="">{{ trans('dash.label.selected') }}</option>
                                    @for($i = 0; $i < 24; $i++)
                                        <option value="{{ str_pad($i, 2, "0", STR_PAD_LEFT) }}">{{ date("h A",strtotime(str_pad($i, 2, "0", STR_PAD_LEFT).':00:00')) }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="">
                                <label for="templateMinute" class="form-label small">{{ trans('dash.label.minutes.date') }}</label>
                                <select class="form-select fc requeridoadd bg-transparent" id="templateMinute" name="templateMinute">
                                    <option value="">{{ trans('dash.label.selected') }}</option>
                                    @for($i = 0; $i < 60; $i++)
                                        <option value="{{ str_pad($i, 2, "0", STR_PAD_LEFT) }}">{{ str_pad($i, 2, "0", STR_PAD_LEFT) }}</option>
                                        @php $i = $i + 4; @endphp
                                    @endfor
                                </select>
                            </div>
                            <div>
                                <a data-action="Settings.addHours" data-action-event="click" id="btn-addhour" class="btn btn-primary btn-sm text-uppercase px-3"><i class="fa-solid fa-plus me-2"></i>{{ trans('dash.label.calendar.add.cup') }}</a>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-3">
                            <div class="card h-100 border-dark-subtle">
                                <div class="card-header text-center text-black"><i class="fa-solid fa-arrow-right text-primary me-2"></i>{{ trans('dash.day.num1') }}</div>
                                <div class="card-body">
                                    <div id="setDay1" class="settingsDays @if(count($template1) > 0) d-flex flex-row flex-wrap align-items-start justify-content-center gap-2 @endif" data-counter="{{count($template1)}}">
                                        @if(count($template1) > 0)
                                            @foreach ($template1 as $template)
                                                <p data-hour="{{ date("Hi", strtotime($template->hour)) }}" class="d-flex align-items-center m-0 datelist1">{{ date("h:i A", strtotime($template->hour)) }} <span class="deleteH" data-day="1" data-id="{{ $template->id }}" data-action="Settings.deleteHour" data-action-event="click" data-action-args="$el"><i class="fa-solid fa-xmark"></i></span></p>    
                                            @endforeach
                                        @else
                                            <p class="text-secondary fw-normal text-center opacity-75 m-0">{{ trans('dash.label.not.calendar') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card h-100 border-dark-subtle">
                                <div class="card-header text-center text-black"><i class="fa-solid fa-arrow-right text-primary me-2"></i>{{ trans('dash.day.num2') }}</div>
                                <div class="card-body">
                                    <div id="setDay2" class="settingsDays @if(count($template2) > 0) d-flex flex-row flex-wrap align-items-start justify-content-center gap-2 @endif" data-counter="{{count($template2)}}">
                                        @if(count($template2) > 0)
                                            @foreach ($template2 as $template)
                                                <p data-hour="{{ date("Hi", strtotime($template->hour)) }}" class="d-flex align-items-center m-0 datelist2">{{ date("h:i A", strtotime($template->hour)) }} <span class="deleteH" data-day="2" data-id="{{ $template->id }}" data-action="Settings.deleteHour" data-action-event="click" data-action-args="$el"><i class="fa-solid fa-xmark"></i></span></p>    
                                            @endforeach
                                        @else
                                            <p class="text-secondary fw-normal text-center opacity-75 m-0">{{ trans('dash.label.not.calendar') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card h-100 border-dark-subtle">
                                <div class="card-header text-center text-black"><i class="fa-solid fa-arrow-right text-primary me-2"></i>{{ trans('dash.day.num3') }}</div>
                                <div class="card-body">
                                    <div id="setDay3" class="settingsDays @if(count($template3) > 0) d-flex flex-row flex-wrap align-items-start justify-content-center gap-2 @endif" data-counter="{{count($template3)}}">
                                        @if(count($template3) > 0)
                                            @foreach ($template3 as $template)
                                                <p data-hour="{{ date("Hi", strtotime($template->hour)) }}" class="d-flex align-items-center m-0 datelist3">{{ date("h:i A", strtotime($template->hour)) }} <span class="deleteH" data-day="3" data-id="{{ $template->id }}" data-action="Settings.deleteHour" data-action-event="click" data-action-args="$el"><i class="fa-solid fa-xmark"></i></span></p>    
                                            @endforeach
                                        @else
                                            <p class="text-secondary fw-normal text-center opacity-75 m-0">{{ trans('dash.label.not.calendar') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card h-100 border-dark-subtle">
                                <div class="card-header text-center text-black"><i class="fa-solid fa-arrow-right text-primary me-2"></i>{{ trans('dash.day.num4') }}</div>
                                <div class="card-body">
                                    <div id="setDay4" class="settingsDays @if(count($template4) > 0) d-flex flex-row flex-wrap align-items-start justify-content-center gap-2 @endif" data-counter="{{count($template4)}}">
                                        @if(count($template4) > 0)
                                            @foreach ($template4 as $template)
                                                <p data-hour="{{ date("Hi", strtotime($template->hour)) }}" class="d-flex align-items-center m-0 datelist4">{{ date("h:i A", strtotime($template->hour)) }} <span class="deleteH" data-day="4" data-id="{{ $template->id }}" data-action="Settings.deleteHour" data-action-event="click" data-action-args="$el"><i class="fa-solid fa-xmark"></i></span></p>    
                                            @endforeach
                                        @else
                                            <p class="text-secondary fw-normal text-center opacity-75 m-0">{{ trans('dash.label.not.calendar') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card h-100 border-dark-subtle">
                                <div class="card-header text-center text-black"><i class="fa-solid fa-arrow-right text-primary me-2"></i>{{ trans('dash.day.num5') }}</div>
                                <div class="card-body">
                                    <div id="setDay5" class="settingsDays @if(count($template5) > 0) d-flex flex-row flex-wrap align-items-start justify-content-center gap-2 @endif" data-counter="{{count($template5)}}">
                                        @if(count($template5) > 0)
                                            @foreach ($template5 as $template)
                                                <p data-hour="{{ date("Hi", strtotime($template->hour)) }}" class="d-flex align-items-center m-0 datelist5">{{ date("h:i A", strtotime($template->hour)) }} <span class="deleteH" data-day="5" data-id="{{ $template->id }}" data-action="Settings.deleteHour" data-action-event="click" data-action-args="$el"><i class="fa-solid fa-xmark"></i></span></p>    
                                            @endforeach
                                        @else
                                            <p class="text-secondary fw-normal text-center opacity-75 m-0">{{ trans('dash.label.not.calendar') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card h-100 border-dark-subtle">
                                <div class="card-header text-center text-black"><i class="fa-solid fa-arrow-right text-primary me-2"></i>{{ trans('dash.day.num6') }}</div>
                                <div class="card-body">
                                    <div id="setDay6" class="settingsDays @if(count($template6) > 0) d-flex flex-row flex-wrap align-items-start justify-content-center gap-2 @endif" data-counter="{{count($template6)}}">
                                        @if(count($template6) > 0)
                                            @foreach ($template6 as $template)
                                                <p data-hour="{{ date("Hi", strtotime($template->hour)) }}" class="d-flex align-items-center m-0 datelist6">{{ date("h:i A", strtotime($template->hour)) }} <span class="deleteH" data-day="6" data-id="{{ $template->id }}" data-action="Settings.deleteHour" data-action-event="click" data-action-args="$el"><i class="fa-solid fa-xmark"></i></span></p>    
                                            @endforeach
                                        @else
                                            <p class="text-secondary fw-normal text-center opacity-75 m-0">{{ trans('dash.label.not.calendar') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card h-100 border-dark-subtle">
                                <div class="card-header text-center text-black"><i class="fa-solid fa-arrow-right text-primary me-2"></i>{{ trans('dash.day.num0') }}</div>
                                <div class="card-body">
                                    <div id="setDay0" class="settingsDays @if(count($template7) > 0) d-flex flex-row flex-wrap align-items-start justify-content-center gap-2 @endif" data-counter="{{count($template7)}}">
                                        @if(count($template7) > 0)
                                            @foreach ($template7 as $template)
                                                <p data-hour="{{ date("Hi", strtotime($template->hour)) }}" class="d-flex align-items-center m-0 datelist0">{{ date("h:i A", strtotime($template->hour)) }} <span class="deleteH" data-day="0" data-id="{{ $template->id }}" data-action="Settings.deleteHour" data-action-event="click" data-action-args="$el"><i class="fa-solid fa-xmark"></i></span></p>    
                                            @endforeach
                                        @else
                                            <p class="text-secondary fw-normal text-center opacity-75 m-0">{{ trans('dash.label.not.calendar') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-column flex-md-row gap-2 gap-md-3 justify-content-center mt-4">
                    <button data-action="Settings.deleteAllHour" data-action-event="click" type="button" class="btn btn-outline-danger px-5">{{ trans('dash.label.erase.template') }}</button>
                </div>

            </form>

        </div>

    </div>
</section>

@include('elements.footer')

@endsection

@push('scriptBottom')
<script src="{{ asset('js/front/datedropper.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    window.SETTING_INDEX_CONFIG = {
        addHourUrl: "{{ route('sett.addHour') }}",
        deleteHourUrl: "{{ route('sett.delHour') }}",
        deleteAllUrl: "{{ route('sett.delAllHour') }}",
        updateModeUrl: "{{ route('sett.updateMode') }}",
        saveProcessLabel: "{{ trans('dash.text.btn.save.process') }}",
        saveLabelHtml: "<i class=\"fa-regular fa-floppy-disk me-2\"></i>{{ trans('dash.text.btn.save') }}",
        hourExistsTitle: "{{ trans('dash.label.error.hour.exist') }}",
        deleteHourTitle: "{{ trans('dash.swal.title.delete.hour') }}",
        deleteHourText: "{{ trans('dash.swal.text.delete.hour') }}",
        deleteHourErrorTitle: "{{ trans('dash.swal.error.remove.hour.generic') }}",
        deleteAllTitle: "{{ trans('dash.swal.title.remove.all.hour') }}",
        deleteAllText: "{{ trans('dash.swal.text.remove.all.hour') }}",
        deleteYesLabel: "{{ trans('dash.label.yes.delete') }}",
        deleteNoLabel: "{{ trans('dash.label.no.cancel') }}",
        noHoursLabel: "No hay horario"
    };
</script>
<script src="{{ asset('js/setting/index.js') }}"></script>
@endpush
