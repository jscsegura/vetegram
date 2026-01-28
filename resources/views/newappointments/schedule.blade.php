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
   $('.select2').select2({
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
    });

    $('.select3').select2({
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        dropdownParent: $('#recipeModal')
    });

    function setCalendar(value) {
        $('.selTimeCalendar').html('');

        if(value == 1) {
            var txt = '<select id="selTime" name="selTime" class="form-select form-select-sm" aria-label="Seleccionar rango" onchange="setCalendar(this.value);">'+
                        '<option value="1" selected>{{ trans('dash.label.cal.montly') }}</option>'+
                        '<option value="2">{{ trans('dash.label.cal.week') }}</option>'+
                        '<option value="3">{{ trans('dash.label.cal.daily') }}</option>'+
                    '</select>';

            $('#selTimeCalendarMensual').html(txt);

            $('#mensual').show();
            $('#semanal').hide();
            $('#diario').hide();
        }else if(value == 2) {
            var txt = '<select id="selTime" name="selTime" class="form-select form-select-sm" aria-label="Seleccionar rango" onchange="setCalendar(this.value);">'+
                        '<option value="1">{{ trans('dash.label.cal.montly') }}</option>'+
                        '<option value="2" selected>{{ trans('dash.label.cal.week') }}</option>'+
                        '<option value="3">{{ trans('dash.label.cal.daily') }}</option>'+
                    '</select>';

            $('#selTimeCalendarSemanal').html(txt);

            $('#mensual').hide();
            $('#semanal').show();
            $('#diario').hide();
        }else if(value == 3) {
            var txt = '<select id="selTime" name="selTime" class="form-select form-select-sm" aria-label="Seleccionar rango" onchange="setCalendar(this.value);">'+
                        '<option value="1">{{ trans('dash.label.cal.montly') }}</option>'+
                        '<option value="2">{{ trans('dash.label.cal.week') }}</option>'+
                        '<option value="3" selected>{{ trans('dash.label.cal.daily') }}</option>'+
                    '</select>';

            $('#selTimeCalendarDiario').html(txt);

            $('#mensual').hide();
            $('#semanal').hide();
            $('#diario').show();
        }
    }
    setCalendar('{{ $type }}');
</script>
@endpush