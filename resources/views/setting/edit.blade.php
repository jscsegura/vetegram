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
                    <a href="{{ route('sett.index') }}" class="btn btn-sm text-uppercase px-3 px-lg-4">{{ trans('dash.label.calendar.recurrent') }}</a>
                    <a href="{{ route('sett.edit') }}" class="btn btn-primary btn-sm text-uppercase px-3 px-lg-4">{{ trans('dash.label.calendar.specific') }}</a>
                </div>
            </div>

            <div class="col-md-8 col-lg-6 mx-auto alert alert-primary text-center mb-3 mb-md-4 small" role="alert">
                <i class="fa-solid fa-triangle-exclamation opacity-50 me-2"></i>{{ trans('dash.label.calendar.custom') }}
            </div>

            <form>

                <div class="col-md-8 col-lg-6 mx-auto mt-4">
                    <div class="d-flex flex-column flex-md-row gap-3 gap-md-4 align-items-md-end">
                        <div class="flex-grow-1">
                            <label for="daySearch" class="form-label small">{{ trans('dash.label.element.day') }}</label>
                            <input type="text" id="daySearch" name="daySearch" class="form-control text-primary fc dDropper" value="{{ date('d/m/Y', strtotime($date)) }}" data-dd-opt-default-date="{{ date('Y/m/d', strtotime($date)) }}">
                        </div>
                        <div>
                            <a onclick="getDate();" class="btn btn-secondary btn-sm text-uppercase px-3"><i class="fa-solid fa-magnifying-glass me-2"></i>{{ trans('dash.menu.search') }}</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-8 col-lg-6 mx-auto mt-4 mt-md-5">
                    <div class="d-flex gap-3 mb-2 mb-md-3 justify-content-end">
                        <span class="small d-flex align-items-center gap-2"><span class="stateH"></span><small>{{ trans('dash.label.calendar.available') }}</small></span>
                        <span class="small d-flex align-items-center gap-2"><span class="stateH c2"></span><small>{{ trans('dash.label.calendar.reserved') }}</small></span>
                        <span class="small d-flex align-items-center gap-2"><span class="stateH c3"></span><small>{{ trans('dash.label.calendar.confirmed') }}</small></span>
                    </div>
                    <div class="card border-2 border-secondary">
                        <div class="h5 pt-3 pb-0 mb-0 fw-medium text-center text-black">
                            <i class="fa-solid fa-arrow-right me-2 text-primary"></i>{{ trans('dash.label.calendar.cups') }}: {{trans('dash.day.num' . $day) .' ' . date('d', strtotime($date)) .' ' . trans('dash.label.of') . ' ' . strtolower(trans('dash.month.num' . (int)date('m', strtotime($date)))) . ' ' . trans('dash.label.of.the') . ' ' . date('Y', strtotime($date)) }}
                        </div>
                        <div class="card-body">
                            <div class="text-center" id="container-template" @if(count($hours) > 0) style="display: none;" @endif>
                                <a data-date="{{ $date }}" data-day="{{ $day }}" onclick="chargeTemplate(this);" class="btn btn-outline-primary btn-sm text-uppercase px-4" id="btn-template"><i class="fa-solid fa-calendar-days me-2"></i>{{ trans('dash.label.calendar.template') }}</a>
                            </div>
                            <div class="settingsDays d-flex flex-row flex-wrap align-items-start justify-content-center gap-2">
                                @php $now = date('Y-m-d H:i:s'); @endphp
                                @foreach ($hours as $hour)
                                @php 
                                $status = '';
                                if($hour->status == 1) {
                                    $status = 'confirmed';
                                }else{
                                    if(($hour->user_reserve > 0)&&($hour->expire != '')) {
                                        $thisnow = strtotime($now);
                                        $expire = strtotime($hour->expire);

                                        if($thisnow < $expire) {
                                            $status = 'reserved';
                                        }
                                    }
                                }
                                @endphp
                                <p data-hour="{{ date("Hi", strtotime($hour->hour)) }}" class="datelist d-flex align-items-center m-0 {{ $status }}">{{ date("h:i A", strtotime($hour->hour)) }} <span class="deleteH" data-id="{{ $hour->id }}" @if($status != '') onclick="deleteNotAvailable();" @else onclick="deleteHour(this);" @endif><i class="fa-solid fa-xmark"></i></span></p>    
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="bg-light p-4 rounded-3 mb-4 mt-4">
                        <div class="d-flex flex-column flex-md-row gap-3 gap-md-4 align-items-md-end">
                            <div class="flex-grow-1">
                                <label for="templateHour" class="form-label small">Hora</label>
                                <select class="form-select fc requeridoadd bg-transparent" id="templateHour" name="templateHour">
                                    <option value="">{{ trans('dash.label.selected') }}</option>
                                    @for($i = 0; $i < 24; $i++)
                                        <option value="{{ str_pad($i, 2, "0", STR_PAD_LEFT) }}">{{ date("h A",strtotime(str_pad($i, 2, "0", STR_PAD_LEFT).':00:00')) }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="">
                                <label for="templateMinute" class="form-label small">Minutos</label>
                                <select class="form-select fc requeridoadd bg-transparent" id="templateMinute" name="templateMinute">
                                    <option value="">{{ trans('dash.label.selected') }}</option>
                                    @for($i = 0; $i < 60; $i++)
                                        <option value="{{ str_pad($i, 2, "0", STR_PAD_LEFT) }}">{{ str_pad($i, 2, "0", STR_PAD_LEFT) }}</option>
                                        @php $i = $i + 4; @endphp
                                    @endfor
                                </select>
                            </div>
                            <div>
                                <a data-date="{{ $date }}" onclick="addHours(this);" class="btn btn-primary btn-sm text-uppercase px-3" id="btn-addhour"><i class="fa-solid fa-plus me-2"></i>{{ trans('dash.label.calendar.add.cup') }}</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-column flex-md-row gap-2 gap-md-3 justify-content-center mt-4">
                    <button onclick="deleteAllHour();" type="button" class="btn btn-outline-danger px-5">{{ trans('dash.label.calendar.clear') }}</button>
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

<script>
    new dateDropper({
        selector: '.dDropper',
        format: 'd/m/y',
        expandable: true,
        showArrowsOnHover: true,
    });

    function getDate () {
        var date = $('#daySearch').val();

        if(date != '') {
            location.href = '{{ route('sett.edit') }}/' + btoa(date);
        }
    }

    function chargeTemplate(obj) {
        var date = $(obj).attr('data-date');
        var day = $(obj).attr('data-day');
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
            }
        });
        
        setLoad('btn-template', 'Cargando plantilla');
        $.post('{{ route('sett.setTemplate') }}', {date:date, day:day},
            function (data){
                location.reload();
            }
        );
    }

    function addHours(obj) {
        var valid = true;

        $('.requeridoadd').each(function(i, elem){
            var value = $(elem).val();
            var value = value.trim();
            if(value == ''){
                $(elem).addClass('is-invalid');
                valid = false;
            }else{
                $(elem).removeClass('is-invalid');
            }
        });

        if(valid == true) {
            var date = $(obj).attr('data-date');
            var hour = $('#templateHour').val();
            var minute = $('#templateMinute').val();
        
            setLoad('btn-addhour', '{{ trans('dash.text.btn.save.process') }}');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
                }
            });
            
            $.post('{{ route('sett.addAvailableHour') }}', {date:date, hour:hour, minute:minute},
                function (data){
                    if(data.type == '200') {
                        var html = '<p data-hour="'+data.text+'" class="datelist d-flex align-items-center m-0">'+data.hour+' <span class="deleteH" data-id="'+data.id+'" onclick="deleteHour(this);"><i class="fa-solid fa-xmark"></i></span></p>';

                        var count = document.getElementsByClassName('datelist').length;
                        if(count == 0) {
                            $('.settingsDays').append(html);
                            $('#container-template').hide();
                        }else{
                            var lastElement = $('.card-body');
                            var insert = false;
                            $('.datelist').each(function(){
                                var aux = $(this).attr('data-hour');

                                if(parseInt(aux) > parseInt(data.text)) {
                                    $(this).before(html);
                                    insert = true;
                                    return false;
                                }else{
                                    lastElement = $(this);
                                }
                            });

                            if(insert == false) {
                                $(lastElement).after(html);
                            }
                        }
                    }

                    if(data.type == '401') {
                        Swal.fire({
                            title: 'Ya existe el horario que intenta ingresar',
                            showClass: {
                                popup: 'animate__animated animate__fadeInDown'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOutUp'
                            }
                        });
                    }
                        
                    stopLoad('btn-addhour', '<i class="fa-solid fa-plus me-2"></i>Agregar');
                }
            );
        }
    }

    function deleteNotAvailable() {
        Swal.fire(
            'No se puede eliminar',
            'Para poder eliminar este horario debe eliminar o reagendar la cita que esta ocupando su lugar',
            'error'
        );
    }

    function deleteHour(obj) {
        var id = $(obj).attr('data-id');

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary btn-sm text-uppercase px-4 marginleft20',
                cancelButton: 'btn btn-danger btn-sm text-uppercase px-4'
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: '¿Eliminar horario?',
            text: "Seguro que desea eliminar este horario de su agenda",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Si, eliminar!',
            cancelButtonText: 'No, cancelar!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
                    }
                });
                
                setCharge();

                $.post('{{ route('sett.delAvailableHour') }}', {id:id},
                    function (data){
                        if(data.isdelete == '1') {
                            var p = $(obj).parent('p');
                            var element = $(obj).parent('p').parent('div');

                            $(p).remove();

                            var quantity = $(element).find('p').toArray().length; 

                            if(quantity == 0) {
                                $('#container-template').show();
                            }
                        }else{
                            Swal.fire({
                                title: 'Ocurrio un error al eliminar el horario',
                                showClass: {
                                    popup: 'animate__animated animate__fadeInDown'
                                },
                                hideClass: {
                                    popup: 'animate__animated animate__fadeOutUp'
                                }
                            });
                        }

                        hideCharge();
                    }
                );
            }
        });
    }

    function deleteAllHour() {
        var date = '{{ $date }}';

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary btn-sm text-uppercase px-4 marginleft20',
                cancelButton: 'btn btn-danger btn-sm text-uppercase px-4'
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: '¿Eliminar todos los horarios?',
            text: "Seguro que desea eliminar todos los horarios del dia seleccionado, no será posible eliminar los que esten reservados o confirmados.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Si, eliminar!',
            cancelButtonText: 'No, cancelar!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
                    }
                });

                setCharge();
                
                $.post('{{ route('sett.delAllHour') }}', {date:date},
                    function (data){
                        location.reload();
                    }
                );
            }
        });
    }
</script>
@endpush