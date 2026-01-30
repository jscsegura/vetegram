@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@include('elements.docmenu')

@include('appointments.schedules.monthly')
@include('appointments.schedules.weekly')
@include('appointments.schedules.diary')

@include('elements.footer')
@include('elements.appointmodals', ['Modalrecipe' => true, 'Modalattach' => true])

@endsection

@push('scriptBottom')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('js/front/datedropper.js') }}"></script>
<script>
    window.APPOINTMENTS_SCHEDULE_CONFIG = {
        texts: {
            monthly: @json(trans('dash.label.cal.montly')),
            weekly: @json(trans('dash.label.cal.week')),
            daily: @json(trans('dash.label.cal.daily'))
        },
        selectors: {
            recipeModal: '#recipeModal',
            monthlyContainer: '#mensual',
            weeklyContainer: '#semanal',
            dailyContainer: '#diario',
            monthlySelectorContainer: '#selTimeCalendarMensual',
            weeklySelectorContainer: '#selTimeCalendarSemanal',
            dailySelectorContainer: '#selTimeCalendarDiario'
        },
        initialType: @json($type)
    };
    window.APPOINTMENTS_SCHEDULE_VIEW_CONFIG = {
        routes: {
            scheduleBase: @json(route('appointment.schedule'))
        },
        rangeTypes: {
            month: 1,
            week: 2,
            day: 3
        },
        ranges: {
            month: {
                fromInput: '#from1',
                toInput: '#to1',
                userSelect: '#useridselectM',
                prevFrom: '#monthPrevFrom',
                prevTo: '#monthPrevTo',
                nextFrom: '#monthNextFrom',
                nextTo: '#monthNextTo'
            },
            week: {
                fromInput: '#from2',
                toInput: '#to2',
                userSelect: '#useridselectW',
                prevFrom: '#weekPrevFrom',
                prevTo: '#weekPrevTo',
                nextFrom: '#weekNextFrom',
                nextTo: '#weekNextTo'
            },
            day: {
                fromInput: '#from3',
                toInput: '#to3',
                userSelect: '#useridselectD',
                prevFrom: '#dayPrevFrom',
                prevTo: '#dayPrevTo',
                nextFrom: '#dayNextFrom',
                nextTo: '#dayNextTo'
            }
        }
    };
</script>
<script src="{{ asset('js/appointments/schedule.js') }}"></script>
<script src="{{ asset('js/appointments/schedules-common.js') }}"></script>
@endpush
