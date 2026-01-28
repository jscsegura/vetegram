<section id="diario" class="container-fluid pb-0 pb-lg-4" @if($type != 3) style="display: none;" @endif>
    <div class="row px-2 px-lg-3 mt-2 mt-lg-4 mb-3 mb-lg-5">
        
        <div class="col px-xl-5">

            <input type="hidden" name="from3" id="from3" value="{{ $params['from3'] }}">
            <input type="hidden" name="to3" id="to3" value="{{ $params['to3'] }}">

            <div class="d-grid d-md-flex gap-2 gap-md-3 mb-2 mb-md-3 align-items-center">
                <h1 class="h4 text-uppercase text-center text-md-start mb-0">{{ trans('dash.label.calendar') }}</h1>
                <div class="col-12 col-md-auto d-flex gap-2 ms-auto">
                    <a href="{{ route('appointment.add') }}" class="btn btn-primary btn-sm text-uppercase flex-grow-1 px-4 me-1">{{ trans('dash.add.appointment') }}</a>
                    <a href="{{ route('appointment.index') }}" class="btn btn-info btn-sm d-flex"><i class="fa-solid fa-table-list m-auto"></i></a>
                    <a href="{{ route('appointment.schedule') }}" class="btn btn-info btn-sm d-flex active"><i class="fa-solid fa-calendar-days m-auto"></i></a>
                </div>
            </div>

            <div class="row justify-content-end mb-3 mt-3 mt-lg-0">
                <div class="col-md-3 col-xl-2 order-1 order-md-0 mt-3 mt-md-0 selTimeCalendar" id="selTimeCalendarDiario"></div>
                <div class="col-md-6 col-xl-8 order-0 order-md-1 d-flex gap-2 justify-content-center">
                    <a onclick="prevDay();" class="circleArrow"><i class="fa-solid fa-angle-left"></i></a>
                    <h2 class="h4 fw-normal px-2 mb-0">{{ date('d', strtotime($params['from3'])) . ' ' . trans('dash.month.num' . (int)date('m', strtotime($params['from3']))) . ', ' . date('Y', strtotime($params['from3'])) }}</h2>
                    <a onclick="nextDay();" class="circleArrow"><i class="fa-solid fa-angle-right"></i></a>
                </div>
                <div class="col-md-3 col-xl-2 order-2 mt-3 mt-md-0">
                    <select name="useridselectD" id="useridselectD" class="form-select form-select-sm" aria-label="{{ trans('dash.label.select.doctor') }}" onchange="getUserAppoinmentDay();">
                        @foreach ($vets as $vet)
                            <option value="{{ $vet->id }}" @if($vet->id == $params['userid3']) selected='selected' @endif>{{ ($vet->id == $user->id) ? $vet->name . ' ('. trans('dash.its.me') . ')' : $vet->name }}</option>    
                        @endforeach
                    </select>
                </div>
            </div>

            @php
                $thisFrom3 = Carbon\Carbon::parse($params['from3']);
                $currentHour3 = 8;
                $lastHour3 = 17;

                if((count($params['appointments3']) > 0)&&((int)key($params['appointments3']) < $currentHour3)) {
                    $currentHour3 = (int)key($params['appointments3']);
                }

                if((count($params['appointments3']) > 0)&&((int)key(array_slice($params['appointments3'], -1, 1, true)) > $lastHour3)) {
                    $lastHour3 = (int)key(array_slice($params['appointments3'], -1, 1, true));
                }
            @endphp

            <div id="schedule" class="small">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-4 border border-top-0 py-2 px-3 wrapDay">
                    <div class="flex-grow-1 text-center dayPad">{{ trans('dash.day.num' . date('w', strtotime($params['from3']))) }}</div>
                </div>

                @while ($currentHour3 <= $lastHour3)
                    <div class="border border-top-0 pb-1">
                        <span class="timeRow lh-sm">{{ date('h:i', strtotime($currentHour3.':00')) }} <small>{{ date('A', strtotime($currentHour3.':00')) }}</small></span>
                        @if(isset($params['appointments3'][$currentHour3]))
                        <span class="event" style="height: 100%"></span>
                            @foreach ($params['appointments3'][$currentHour3] as $hours)
                                <div class="d-flex flex-column flex-lg-row justify-content-lg-between align-items-lg-center gap-3 gap-lg-4 py-2 px-3">
                                    <div class="wrapNames z-1">
                                        <a href="{{ route('pet.detail', App\Models\User::encryptor('encrypt', $hours['id_pet'])) }}" class="btn btn-sm link-secondary p-0 text-uppercase lh-1"><strong>{{ (isset($hours['get_pet']['name'])) ? $hours['get_pet']['name'] : '' }}</strong></a>
                                        <p class="lh-1">{{ (isset($hours['get_client']['name'])) ? $hours['get_client']['name'] : '' }} ({{ trans('dash.label.owner') }})</p>
                                    </div>
                                    <div class="flex-lg-grow-1 z-1 lh-1">
                                        <span class="d-inline-block pt-lg-1">{{ date('h:i', strtotime($hours['hour'])) }} <small>{{ date('A', strtotime($hours['hour'])) }}</small></span>
                                    </div>
                                    @if(isset($hours['get_last_note'][0]['note']))
                                        <div class="z-1">
                                            <div class="note">
                                                <i class="fa-regular fa-file-lines"></i>{{ (strlen($hours['get_last_note'][0]['note']) > 150) ? substr($hours['get_last_note'][0]['note'], 0, 150) . '...' : $hours['get_last_note'][0]['note'] }}
                                            </div>
                                        </div>
                                    @else
                                        <div class="d-none d-lg-block"></div>
                                    @endif

                                    @if(in_array($hours['status'], [1,2]))
                                        <div class="d-none d-lg-block"></div>
                                    @else
                                        <div class="wrapIcons z-1">
                                            <a onclick="setIdAppointmentToAttach('{{ $hours['id'] }}')" class="btn smIcon link-secondary fs-5" data-bs-toggle="modal" data-bs-target="#attachModal"><i class="fa-solid fa-paperclip"></i></a>
                                            <a onclick="setIdAppointmentToMedicine('{{ $hours['id'] }}');" class="btn smIcon link-secondary fs-5" data-bs-toggle="modal" data-bs-target="#recipeModal"><i class="fa-regular fa-pen-to-square"></i></a>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>

                    @php
                        $currentHour3 = (int)$currentHour3 + 1;
                    @endphp
                @endwhile
            </div>

        </div>

    </div>
</section>

@php
$startLastDay = $thisFrom3->copy()->subDay();
$endLastDay   = $thisFrom3->copy()->addDay();
$startLastDay = $startLastDay->toDateString();
$endLastDay   = $endLastDay->toDateString();
@endphp

<script>
    function prevDay() {
        var from = '{{ $startLastDay }}';
        var to   = '{{ $startLastDay }}';
        
        $('#from3').val(from);
        $('#to3').val(to);

        getUserAppoinmentDay();
    }

    function nextDay() {
        var from = '{{ $endLastDay }}';
        var to   = '{{ $endLastDay }}';
        
        $('#from3').val(from);
        $('#to3').val(to);

        getUserAppoinmentDay();
    }

    function getUserAppoinmentDay() {
        var time = $("#selTime").val();
        var from = $("#from3").val();
        var to   = $("#to3").val();

        setCharge();

        var userid = $('#useridselectD').val();

        location.href = '{{ route('appointment.schedule') }}/' + btoa(userid) + '/' + btoa(from) + '/' + btoa(to) + '/3';
    }
</script>