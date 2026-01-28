<section id="semanal" class="container-fluid pb-0 pb-lg-4" @if($type != 2) style="display: none;" @endif>
    <div class="row px-2 px-lg-3 mt-2 mt-lg-4 mb-3 mb-lg-5">
        
        <div class="col px-xl-5">

            <input type="hidden" name="from2" id="from2" value="{{ $params['from2'] }}">
            <input type="hidden" name="to2" id="to2" value="{{ $params['to2'] }}">

            <div class="d-grid d-md-flex gap-2 gap-md-3 mb-2 mb-md-3 align-items-center">
                <h1 class="h4 text-uppercase text-center text-md-start mb-0">{{ trans('dash.label.calendar') }}</h1>
                <div class="col-12 col-md-auto d-flex gap-2 ms-auto">
                    <a href="{{ route('appointment.add') }}" class="btn btn-primary btn-sm text-uppercase flex-grow-1 px-4 me-1">{{ trans('dash.add.appointment') }}</a>
                    <a href="{{ route('appointment.index') }}" class="btn btn-info btn-sm d-flex"><i class="fa-solid fa-table-list m-auto"></i></a>
                    <a href="{{ route('appointment.schedule') }}" class="btn btn-info btn-sm d-flex active"><i class="fa-solid fa-calendar-days m-auto"></i></a>
                </div>
            </div>

            <div class="row justify-content-end mb-3 mt-3 mt-lg-0">
                <div class="col-md-3 col-xl-2 order-1 order-md-0 mt-3 mt-md-0 selTimeCalendar" id="selTimeCalendarSemanal"></div>
                <div class="col-md-6 col-xl-8 order-0 order-md-1 d-flex gap-2 justify-content-center">
                    <a onclick="prevWeek();" class="circleArrow"><i class="fa-solid fa-angle-left"></i></a>
                    <h2 class="h4 fw-normal px-2 mb-0">{{ date('d', strtotime($params['from2'])) . ' - ' . date('d', strtotime($params['to2'])) . ' ' . trans('dash.month.num' . (int)date('m', strtotime($params['to2']))) . ', ' . date('Y', strtotime($params['to2'])) }}</h2>
                    <a onclick="nextWeek();" class="circleArrow"><i class="fa-solid fa-angle-right"></i></a>
                </div>
                <div class="col-md-3 col-xl-2 order-2 mt-3 mt-md-0">
                    <select name="useridselectW" id="useridselectW" class="form-select form-select-sm" aria-label="{{ trans('dash.label.select.doctor') }}" onchange="getUserAppoinmentWeek();">
                        @foreach ($vets as $vet)
                            <option value="{{ $vet->id }}" @if($vet->id == $params['userid2']) selected='selected' @endif>{{ ($vet->id == $user->id) ? $vet->name . ' ('. trans('dash.its.me') . ')' : $vet->name }}</option>    
                        @endforeach
                    </select>
                </div>
            </div>

            @php
                $thisFrom2 = Carbon\Carbon::parse($params['from2']);
                $now = date('Y-m-d');
                $currentHour = 8;
                $lastHour = 17;

                if((count($params['appointments2']) > 0)&&((int)key($params['appointments2']) < $currentHour)) {
                    $currentHour = (int)key($params['appointments2']);
                }

                if((count($params['appointments2']) > 0)&&((int)key(array_slice($params['appointments2'], -1, 1, true)) > $lastHour)) {
                    $lastHour = (int)key(array_slice($params['appointments2'], -1, 1, true));
                }

                $days = [
                    date('d', strtotime($params['from2'])),
                    date('d', strtotime($params['from2'] . '+1 days')),
                    date('d', strtotime($params['from2'] . '+2 days')),
                    date('d', strtotime($params['from2'] . '+3 days')),
                    date('d', strtotime($params['from2'] . '+4 days')),
                    date('d', strtotime($params['from2'] . '+5 days')),
                    date('d', strtotime($params['from2'] . '+6 days')),
                ];
            @endphp

            <div id="schedule" class="small weekly">
                <div class="d-flex border border-top-0 wrapDay">
                    <div class="p-1 p-sm-2 border-end flex-1 position-relative text-center"><span class="opacity-75 small text-uppercase lh-sm d-block">{{ trans('dash.day.short.num1') }}</span><span class="fw-bold @if($now == date('Y-m-d', strtotime($params['from2']))) text-primary @endif">{{ $days[0] }}</span></div>
                    <div class="p-1 p-sm-2 border-end flex-1 position-relative text-center"><span class="opacity-75 small text-uppercase lh-sm d-block">{{ trans('dash.day.short.num2') }}</span><span class="fw-bold @if($now == date('Y-m-d', strtotime($params['from2'] . '+1 days'))) text-primary @endif">{{ $days[1] }}</span></div>
                    <div class="p-1 p-sm-2 border-end flex-1 position-relative text-center"><span class="opacity-75 small text-uppercase lh-sm d-block">{{ trans('dash.day.short.num3') }}</span><span class="fw-bold @if($now == date('Y-m-d', strtotime($params['from2'] . '+2 days'))) text-primary @endif">{{ $days[2] }}</span></div>
                    <div class="p-1 p-sm-2 border-end flex-1 position-relative text-center"><span class="opacity-75 small text-uppercase lh-sm d-block">{{ trans('dash.day.short.num4') }}</span><span class="fw-bold @if($now == date('Y-m-d', strtotime($params['from2'] . '+3 days'))) text-primary @endif">{{ $days[3] }}</span></div>
                    <div class="p-1 p-sm-2 border-end flex-1 position-relative text-center"><span class="opacity-75 small text-uppercase lh-sm d-block">{{ trans('dash.day.short.num5') }}</span><span class="fw-bold @if($now == date('Y-m-d', strtotime($params['from2'] . '+4 days'))) text-primary @endif">{{ $days[4] }}</span></div>
                    <div class="p-1 p-sm-2 border-end flex-1 position-relative text-center"><span class="opacity-75 small text-uppercase lh-sm d-block">{{ trans('dash.day.short.num6') }}</span><span class="fw-bold @if($now == date('Y-m-d', strtotime($params['from2'] . '+5 days'))) text-primary @endif">{{ $days[5] }}</span></div>
                    <div class="p-1 p-sm-2 flex-1 position-relative text-center"><span class="opacity-75 small text-uppercase lh-sm d-block">{{ trans('dash.day.short.num0') }}</span><span class="fw-bold @if($now == date('Y-m-d', strtotime($params['from2'] . '+6 days'))) text-primary @endif">{{ $days[6] }}</span></div>
                </div>

                @while ($currentHour <= $lastHour)
                    <div class="d-flex align-items-stretch border border-top-0">
                        <span class="timeRow lh-sm">{{ date('h:i', strtotime($currentHour.':00')) }} <small>{{ date('A', strtotime($currentHour.':00')) }}</small></span>
                        @for ($i = 0; $i < 7; $i++)
                            <div class="p-1 p-sm-2 @if($i != 6) border-end @endif flex-1 position-relative">
                                @if(isset($params['appointments2'][$currentHour]))
                                    @foreach ($params['appointments2'][$currentHour] as $hours)
                                        @if ((int)date('d', strtotime($hours['date'])) == (int)$days[$i])
                                            <span class="event" style="height: 100%"></span>
                                            <div class="text-center text-md-start">
                                                <a href="{{ route('appointment.view', App\Models\User::encryptor('encrypt', $hours['id'])) }}" class="btn btn-sm link-secondary p-0 text-uppercase lh-1">
                                                    <span class="d-block d-md-none small">{{ (isset($hours['get_pet']['name'])) ? substr($hours['get_pet']['name'], 0, 2) . '.' : '' }}</span>
                                                    <strong class="d-none d-md-block">{{ (isset($hours['get_pet']['name'])) ? $hours['get_pet']['name'] : '' }}</strong>
                                                </a>
                                                <span class="d-none d-md-block">{{ date('h:i', strtotime($hours['hour'])) }} <small>{{ date('A', strtotime($hours['hour'])) }}</small></span>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        @endfor
                    </div>

                    @php
                        $currentHour = (int)$currentHour + 1;
                    @endphp
                @endwhile

            </div>

        </div>

    </div>
</section>

@php
$startLastWeek = $thisFrom2->copy()->subWeek()->startOfWeek();
$endLastWeek   = $thisFrom2->copy()->subWeek()->endOfWeek();
$startLastWeek = $startLastWeek->toDateString();
$endLastWeek   = $endLastWeek->toDateString();

$startNextWeek = $thisFrom2->copy()->addWeek()->startOfWeek();
$endNextWeek   = $thisFrom2->copy()->addWeek()->endOfWeek();
$startNextWeek = $startNextWeek->toDateString();
$endNextWeek   = $endNextWeek->toDateString();
@endphp

<script>
    function prevWeek() {
        var from = '{{ $startLastWeek }}';
        var to   = '{{ $endLastWeek }}';
        
        $('#from2').val(from);
        $('#to2').val(to);

        getUserAppoinmentWeek();
    }

    function nextWeek() {
        var from = '{{ $startNextWeek }}';
        var to   = '{{ $endNextWeek }}';
        
        $('#from2').val(from);
        $('#to2').val(to);

        getUserAppoinmentWeek();
    }

    function getUserAppoinmentWeek() {
        var time = $("#selTime").val();
        var from = $("#from2").val();
        var to   = $("#to2").val();

        setCharge();

        var userid = $('#useridselectW').val();

        location.href = '{{ route('appointment.schedule') }}/' + btoa(userid) + '/' + btoa(from) + '/' + btoa(to) + '/2';
    }
</script>