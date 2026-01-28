@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@include('elements.docmenu')

<section class="container-fluid pb-0 pb-lg-4 px-xxl-5">
    <div class="row px-2 px-lg-3 mt-2 mt-lg-4">
        
        <div class="col-md-7 col-xl-3 mx-auto">
            @include('elements.petDetail')
        </div>
        
        <div class="col-12 col-xl-9 ps-xl-4 mt-2 mt-lg-0">

            @include('elements.topPet')

            @if(session('success'))
            <div class="alert alert-success small mt-3 mb-0" role="alert">
                {{ session('success') }}
            </div><br />
            @endif
            
            <div class="card border-0 mb-0 mb-lg-5">
                <div class="card-body p-0">
                    @if((Auth::guard('web')->user()->rol_id != 8) && ($credentials['access'] == false))
                    <div class="alert alert-warning text-center mb-3 mb-md-4 small" role="alert">
                        <i class="fa-solid fa-triangle-exclamation opacity-50 me-2"></i>{{ trans('dash.msg.page.limit.owners') }}
                    </div>
                    @endif

                    @if((Auth::guard('web')->user()->rol_id == 8)&&($pet->dead_flag == 0))
                    <div class="d-flex flex-column flex-sm-row justify-content-end mb-3">
                        <a href="{{ route('search.index') }}" class="btn btn-primary btn-sm text-uppercase px-4"><i class="fa-solid fa-magnifying-glass me-2"></i>{{ trans('dash.label.create.cita') }}</a>
                    </div>
                    @endif

                    <table class="table table-striped table-borderless mb-0 small align-middle cTable">
                        <tbody>
                            @if(count($appointments) > 0)
                                @foreach ($appointments as $appointment)
                                    <tr class="position-relative">
                                        <td class="px-2 px-lg-3 py-1 py-lg-4" data-label="{{ trans('dash.label.date') }}:" style="width: 164px;">{{ date('d', strtotime($appointment->date)) . ' ' . strtolower(trans('dash.month.num' . (int)date('m', strtotime($appointment->date)))) . ' ' . date('Y', strtotime($appointment->date)) }}</td>
                                        <td class="px-2 px-lg-3 py-1 py-lg-4" data-label="{{ trans('dash.label.hour') }}:" style="width: 100px;"><strong>{{ date('h:i a', strtotime($appointment->hour)) }}</strong></td>
                                        <td class="px-2 px-lg-3 py-1 py-lg-4" data-label="{{ trans('dash.label.element.type') }}:" style="width: 320px;">{{ $appointment->reason }}</td>
                                        <td class="px-2 px-lg-3 py-1 py-lg-4" data-label="{{ trans('dash.label.status') }}:" style="width: 140px;"
                                            @if($appointment->status == 1)
                                                ><span class="badge statusW rounded-pill text-bg-danger">{{ trans('dash.label.cancel') }}</span>
                                            @elseif($appointment->status == 2)
                                                ><span class="badge statusW rounded-pill text-bg-success">{{ trans('dash.label.finish') }}</span>
                                            @else
                                                ><span class="badge statusW rounded-pill text-bg-warning">{{ trans('dash.label.pending') }}</span>
                                            @endif
                                        </td>
                                        <td class="px-2 px-lg-3 py-1 py-lg-4 text-end" data-label="{{ trans('dash.label.options') }}:">
                                            <div class="d-inline-block align-top">
                                                <a href="{{ route('appointment.view', App\Models\User::encryptor('encrypt', $appointment->id)) }}" class="apIcon d-md-inline-block mb-2 mb-md-0">
                                                    <i class="fa-regular fa-eye"></i>
                                                    <span class="d-none d-lg-inline-block">{{ trans('dash.label.btn.see') }}</span>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <div>
                                    <p class="mb-0 text-center"><i class="fa-regular fa-circle-xmark me-2 opacity-75"></i>{{ trans('dash.label.dash.not.appoinment') }}</p>
                                </div>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

@include('elements.footer')
@include('elements.appointmodals', ['Modalreminder' => true])

@endsection

@push('scriptBottom')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('js/front/datedropper.js') }}"></script>

<link rel="stylesheet" href="{{ asset('css/wpanel/library/jquery.toast.css') }}">
<script src="{{ asset('js/wpanel/library/jquery.toast.js') }}"></script>

<script>
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

    new dateDropper({
        selector: '.dDropper',
        format: 'd/m/y',
        expandable: true,
        showArrowsOnHover: true,
   })

   $('.select4').select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        dropdownParent: $('#petEditModal')
    });
</script>
@endpush