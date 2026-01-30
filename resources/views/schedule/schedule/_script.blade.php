@php
    $scheduleDayNames = [
        trans('dash.day.num0'),
        trans('dash.day.num1'),
        trans('dash.day.num2'),
        trans('dash.day.num3'),
        trans('dash.day.num4'),
        trans('dash.day.num5'),
        trans('dash.day.num6')
    ];
@endphp
<script>
    window.SCHEDULE_CORE_CONFIG = {
        dayNames: @json($scheduleDayNames),
        texts: {
            copy: @json(trans('dash.schedule.schedule.copy')),
            continue: @json(trans('dash.label.btn.continue')),
            overlap: @json(trans('dash.schedule.schedule.alert.overlap')),
            overlaptime: @json(trans('dash.schedule.schedule.alert.overlaptime')),
            badtime: @json(trans('dash.schedule.schedule.alert.badtime')),
            errorTitle: @json('Error')
        }
    };
</script>
<link rel="stylesheet" href="{{ asset('css/schedule/schedule.css') }}">
<script src="{{ asset('js/schedule/schedule.js') }}"></script>
