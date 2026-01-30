<section id="mensual" class="container-fluid pb-0 pb-lg-4" @if($type != 1) style="display: none;" @endif>
    <div class="row px-2 px-lg-3 mt-2 mt-lg-4 mb-3 mb-lg-5">
        
        <div class="col px-xl-5">

            <input type="hidden" name="from1" id="from1" value="{{ $params['from1'] }}">
            <input type="hidden" name="to1" id="to1" value="{{ $params['to1'] }}">

            <div class="d-grid d-md-flex gap-2 gap-md-3 mb-2 mb-md-3 align-items-center">
                <h1 class="h4 text-uppercase text-center text-md-start mb-0">{{ trans('dash.label.calendar') }}</h1>
                <div class="col-12 col-md-auto d-flex gap-2 ms-auto">
                    <a href="{{ route('appointment.add') }}" class="btn btn-primary btn-sm text-uppercase flex-grow-1 px-4 me-1">{{ trans('dash.add.appointment') }}</a>
                    <a href="{{ route('appointment.index') }}" class="btn btn-info btn-sm d-flex"><i class="fa-solid fa-table-list m-auto"></i></a>
                    <a href="{{ route('appointment.schedule') }}" class="btn btn-info btn-sm d-flex active"><i class="fa-solid fa-calendar-days m-auto"></i></a>
                </div>
            </div>

            <div class="row justify-content-end mb-3 mt-3 mt-lg-0">
                <div class="col-md-3 col-xl-2 order-1 order-md-0 mt-3 mt-md-0 selTimeCalendar" id="selTimeCalendarMensual">
                    <select id="selTime" name="selTime" class="form-select form-select-sm" aria-label="Seleccionar rango">
                        <option value="1" selected>{{ trans('dash.label.cal.montly') }}</option>
                        <option value="2">{{ trans('dash.label.cal.week') }}</option>
                        <option value="3">{{ trans('dash.label.cal.daily') }}</option>
                    </select>
                </div>
                <div class="col-md-6 col-xl-8 order-0 order-md-1 d-flex gap-2 justify-content-center">
                    <a href="#" class="circleArrow" data-schedule-nav="month" data-direction="prev"><i class="fa-solid fa-angle-left"></i></a>
                    <h2 class="h4 fw-normal px-2 mb-0">{{ trans('dash.month.num' . (int)date('m', strtotime($params['from1']))) . ' ' . date('Y', strtotime($params['from1'])) }}</h2>
                    <a href="#" class="circleArrow" data-schedule-nav="month" data-direction="next"><i class="fa-solid fa-angle-right"></i></a>
                </div>
                <div class="col-md-3 col-xl-2 order-2 mt-3 mt-md-0">
                    <select name="useridselectM" id="useridselectM" class="form-select form-select-sm" aria-label="{{ trans('dash.label.select.doctor') }}" data-schedule-user="month">
                        @foreach ($vets as $vet)
                            <option value="{{ $vet->id }}" @if($vet->id == $params['userid1']) selected='selected' @endif>{{ ($vet->id == $user->id) ? $vet->name . ' ('. trans('dash.its.me') . ')' : $vet->name }}</option>    
                        @endforeach
                    </select>
                </div>
            </div>

            <div id="schedule" class="small monthly">
                <div class="d-flex border border-top-0 wrapDay">
                    <div class="p-1 p-sm-2 border-end flex-1 position-relative text-center"><span class="opacity-75 small text-uppercase lh-sm d-block">{{ trans('dash.day.short.num1') }}</span></div>
                    <div class="p-1 p-sm-2 border-end flex-1 position-relative text-center"><span class="opacity-75 small text-uppercase lh-sm d-block">{{ trans('dash.day.short.num2') }}</span></div>
                    <div class="p-1 p-sm-2 border-end flex-1 position-relative text-center"><span class="opacity-75 small text-uppercase lh-sm d-block">{{ trans('dash.day.short.num3') }}</span></div>
                    <div class="p-1 p-sm-2 border-end flex-1 position-relative text-center"><span class="opacity-75 small text-uppercase lh-sm d-block">{{ trans('dash.day.short.num4') }}</span></div>
                    <div class="p-1 p-sm-2 border-end flex-1 position-relative text-center"><span class="opacity-75 small text-uppercase lh-sm d-block">{{ trans('dash.day.short.num5') }}</span></div>
                    <div class="p-1 p-sm-2 border-end flex-1 position-relative text-center"><span class="opacity-75 small text-uppercase lh-sm d-block">{{ trans('dash.day.short.num6') }}</span></div>
                    <div class="p-1 p-sm-2 flex-1 position-relative text-center"><span class="opacity-75 small text-uppercase lh-sm d-block">{{ trans('dash.day.short.num0') }}</span></div>
                </div>
                
                @php
                $thisFrom1 = Carbon\Carbon::parse($params['from1']);
                
                $lastMonth = 0;
                $timestamp = strtotime($params['from1']);
                $firstDay = date('w', $timestamp);

                $timestamp = strtotime($params['to1']);
                $lastDay = date('w', $timestamp);

                $subtractDays = 0;
                $addDays = 0;
                switch ($firstDay) {
                    case '2':$subtractDays = 1;
                        break;
                    case '3':$subtractDays = 2;
                        break;
                    case '4':$subtractDays = 3;
                        break;
                    case '5':$subtractDays = 4;
                        break;
                    case '6':$subtractDays = 5;
                        break;
                    case '0':$subtractDays = 6;
                        break;
                    default:
                        $subtractDays = 0;
                        break;
                }

                switch ($lastDay) {
                    case '1':$addDays = 6;
                        break;
                    case '2':$addDays = 5;
                        break;
                    case '3':$addDays = 4;
                        break;
                    case '4':$addDays = 3;
                        break;
                    case '5':$addDays = 2;
                        break;
                    case '6':$addDays = 1;
                        break;
                    default:
                        $addDays = 0;
                        break;
                }

                if($subtractDays > 0) {
                    $params['from1'] = strtotime('-'.$subtractDays.' day', strtotime($params['from1']));
                    $params['from1'] = date('Y-m-d', $params['from1']);
                }

                if($addDays > 0) {
                    $params['to1'] = strtotime('+'.$addDays.' day', strtotime($params['to1']));
                    $params['to1'] = date('Y-m-d', $params['to1']);
                }
                @endphp

                @while (strtotime($params['from1']) <= strtotime($params['to1']))
                    @php
                    $day = date('d', strtotime($params['from1']));
                    $dayWeek = date('w', strtotime($params['from1']));
                    if($day == '01') {
                        $lastMonth++;
                    }
                    @endphp

                    @if($dayWeek == 1)
                    <div class="d-flex align-items-stretch border border-top-0">
                    @endif

                    @if(($lastMonth == 0)||($lastMonth == 2))
                    <div class="p-1 p-sm-2 @if($dayWeek != 0) border-end @endif flex-1 position-relative">
                        <span class="d-block fw-normal text-center opacity-25">{{ (int)$day }}</span>
                    </div>
                    @else
                    <div class="p-1 p-sm-2 @if($dayWeek != 0) border-end @endif flex-1 position-relative">
                        <span class="d-block fw-medium text-center opacity-75">{{ (int)$day }}</span>
                        @if(isset($params['appointments1'][$params['from1']]))
                            @foreach ($params['appointments1'][$params['from1']] as $appointment)
                            <a href="{{ route('appointment.view', App\Models\User::encryptor('encrypt', $appointment->id)) }}" class="btn btn-sm d-block link-secondary p-0 lh-1 text-start mt-1">
                                <span class="d-block d-md-none text-primary text-center"><i class="fa-solid fa-paw"></i></span>
                                <p class="d-none d-md-block">
                                    <span class="text-primary me-1">{{ (isset($appointment['getPet']['name'])) ? $appointment['getPet']['name'] : '' }}</span>
                                    <small>{{ date('h:i A', strtotime($appointment->hour)) }}</small>
                                </p>
                            </a>
                            @endforeach
                        @endif
                    </div>
                    @endif

                    @if($dayWeek == 0)
                    </div>
                    @endif

                    @php
                    $params['from1'] = strtotime('+1 day', strtotime($params['from1']));
                    $params['from1'] = date('Y-m-d', $params['from1']);
                    @endphp
                @endwhile
            </div>

        </div>

    </div>
</section>

@php
$startLastMonth = $thisFrom1->copy()->subMonth()->startOfMonth();
$endLastMonth = $thisFrom1->copy()->subMonth()->endOfMonth();
$startLastMonth = $startLastMonth->toDateString();
$endLastMonth = $endLastMonth->toDateString();

$startNextMonth = $thisFrom1->copy()->addMonth()->startOfMonth();
$endNextMonth = $thisFrom1->copy()->addMonth()->endOfMonth();
$startNextMonth = $startNextMonth->toDateString();
$endNextMonth = $endNextMonth->toDateString();
@endphp

<input type="hidden" id="monthPrevFrom" value="{{ $startLastMonth }}">
<input type="hidden" id="monthPrevTo" value="{{ $endLastMonth }}">
<input type="hidden" id="monthNextFrom" value="{{ $startNextMonth }}">
<input type="hidden" id="monthNextTo" value="{{ $endNextMonth }}">
