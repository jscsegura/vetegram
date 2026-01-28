@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

    @include('elements.docmenu')

    <section class="container-fluid pb-0 pb-lg-4">
        <div class="row px-2 px-lg-3 mt-2 mt-lg-4 mb-3 mb-lg-5">

            <div class="smallCol mx-auto mt-2">
                <h2 class="h4 text-uppercase text-center text-md-start fw-normal mb-3">{{ trans('dash.label.btn.cancel') }} <span class="text-info fw-bold">{{ trans('dash.label.apointment') }}</span></h2>
                <div class="card rounded-3 border-2 border-secondary p-3 p-md-4 mb-3 mb-lg-5">
                    @if($appointment->status == 2)
                    <div class="col-12">
                        <div class="alert alert-warning text-center mb-2" role="alert">
                            <i class="fa-solid fa-triangle-exclamation opacity-50 me-2"></i>{{ trans('dash.label.not.cancel') }}
                        </div>
                    </div>
                    @elseif($appointment->status == 3)
                    <div class="col-12">
                        <div class="alert alert-warning text-center mb-2" role="alert">
                            <i class="fa-solid fa-triangle-exclamation opacity-50 me-2"></i>{{ trans('dash.label.canceled') }}
                        </div>
                    </div>
                    @else
                    <p class="fs-5 text-center mb-3">¿{{ trans('dash.msg.appoinment.title.cancel.nosimbol') }} @if(isset($appointment['getPet']['name'])) {{ trans('dash.label.of') }} <span class="text-uppercase fw-medium">{{ $appointment['getPet']['name'] }} </span>@endif {{ trans('dash.label.of.the') }} <span class="fw-medium">{{ date('d', strtotime($appointment->date)) . ' de ' . strtolower(trans('dash.month.num' . (int)date('m', strtotime($appointment->date)))) }}</span> {{ trans('dash.label.confirm.appointment.at') }} <span class="fw-medium">{{ date('h:i a', strtotime($appointment->hour)) }}</span>?</p>
                    <div class="mx-auto">
                        <button type="submit" class="btn btn-primary px-5" onclick="setToCancel('{{ $appointment->id }}', '{{ $appointment->id_user }}')">{{ trans('dash.msg.yes.cancel') }}</button>
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </section>

    @include('elements.footer')

@endsection

@push('scriptBottom')
<link rel="stylesheet" href="{{ asset('css/wpanel/library/jquery.toast.css') }}">
<script src="{{ asset('js/wpanel/library/jquery.toast.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function setToCancel(id, user_id) {
        var option = 'cancelar';

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary btn-sm text-uppercase px-4 marginleft20',
                cancelButton: 'btn btn-danger btn-sm text-uppercase px-4'
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: '{{ trans('dash.msg.cancel.appoinment') }}',
            text: '{{ trans('dash.msg.confir.cancel.appoinment') }}',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: '{{ trans('dash.msg.yes.cancel') }}',
            cancelButtonText: 'No',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
                    }
                });

                setCharge();
                
                $.post('{{ route('appoinment.cancelOrReschedule') }}', {id:id, user_id:user_id, date:'', time:'', option:option},
                    function (data){
                        if(data.process == '1') {
                            location.reload();
                        }else if(data.process == '500') {
                            $.toast({
                                text: '{{ trans('dash.msg.error.cancel.appoinment') }}',
                                position: 'bottom-right',
                                textAlign: 'center',
                                loader: false,
                                hideAfter: 4000,
                                icon: 'error'
                            });
                        }

                        hideCharge();
                    }
                );
            }
        });
    }
</script>
@endpush
