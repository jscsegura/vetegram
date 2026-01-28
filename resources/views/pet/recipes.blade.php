@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

    @include('elements.docmenu')

    <section class="container-fluid pb-0 pb-lg-4 px-xxl-5">
        <div class="row px-2 px-lg-3 mt-2 mt-lg-4">

            <div class="col-md-7 col-xl-3 mx-auto">
                @include('elements.petDetail')
            </div>

            <div class="col-12 col-xl-9 ps-xl-4 mt-4 mt-lg-0">
                @include('elements.topPet')

                @if(session('success'))
                <div class="alert alert-success small mt-3 mb-0" role="alert">
                    {{ session('success') }}
                </div><br />
                @endif

                @if((Auth::guard('web')->user()->rol_id != 8) && ($credentials['access'] == false))
                <div class="alert alert-warning text-center mb-3 mb-md-4 small" role="alert">
                    <i class="fa-solid fa-triangle-exclamation opacity-50 me-2"></i>{{ trans('dash.msg.page.limit.owners') }}
                </div>
                @endif

                <div class="d-flex flex-column flex-md-row justify-content-end align-items-center mb-3 gap-3 gap-md-4">
                    <p class="small text-center text-md-end lh-sm">
                        <i class="fa-solid fa-triangle-exclamation me-1 text-warning"></i>
                        <span class="opacity-75">{{ trans('dash.label.only.authorized') }}</span>
                    </p>
                    @if((Auth::guard('web')->user()->rol_id != 8)&&($pet->dead_flag == 0))
                        <a href="javascript:void(0);" onclick="setIdAppointmentToMedicine('0', '{{ $pet->id }}');" class="btn btn-secondary btn-sm px-4 text-uppercase" data-bs-toggle="modal" data-bs-target="#recipeModal"><i class="fa-regular fa-pen-to-square me-2"></i>{{ trans('dash.label.add.recipes') }}</a>
                    @endif
                </div>
                  
                <div class="accordion" id="recipeAccordion">
                    @if(count($recipes) > 0)
                        @foreach ($recipes as $recipe)
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$recipe->id}}" aria-expanded="false" aria-controls="collapseOne">
                                        {{ date('d/m/Y', strtotime($recipe->created_at)) }}
                                    </button>
                                </h2>
                                <div id="collapse{{$recipe->id}}" class="accordion-collapse collapse" data-bs-parent="#recipeAccordion">
                                    <div class="accordion-body">
        
                                        <div class="card border-0">
                                            <div class="card-body p-2 p-md-3">
                                                <table class="table mb-0 small align-middle rTable">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-primary-emphasis text-uppercase fw-medium"><small>{{ trans('dash.label.name') }}</small></th>
                                                            <th class="text-primary-emphasis text-uppercase fw-medium"><small>{{ trans('dash.label.duration') }}</small></th>
                                                            <th class="text-primary-emphasis text-uppercase fw-medium text-center"><small>{{ trans('dash.label.take') }}</small></th>
                                                            <th class="text-primary-emphasis text-uppercase fw-medium text-center"><small>{{ trans('dash.label.quantity') }}</small></th>
                                                            <th class="text-primary-emphasis text-uppercase fw-medium"><small>{{ trans('dash.label.notes') }}</small></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($recipe->detail as $detail)
                                                            <tr>
                                                                <td data-label="{{ trans('dash.label.name') }}:" class="fw-medium py-1 py-md-3">{{ $detail->title }}</td>
                                                                <td data-label="{{ trans('dash.label.duration') }}:" class="py-1 py-md-3">{{ $detail->duration }}</td>
                                                                <td data-label="{{ trans('dash.label.take') }}:" class="py-1 py-md-3 text-center">{{ $detail->take }}</td>
                                                                <td data-label="{{ trans('dash.label.quantity') }}:" class="py-1 py-md-3 text-center">{{ $detail->quantity }}</td>
                                                                <td data-label="{{ trans('dash.label.notes') }}:" class="py-1 py-md-3 d-flex"><span class="flex-1">{{ $detail->instruction }}</span></td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                <div class="d-flex gap-2 justify-content-end">
                                                    <a href="javascript:void(0);" onclick="setIdAppointmentToSendRecipe('{{ $recipe->id }}');" class="btn btn-outline-primary btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#sendModal"><i class="fa-regular fa-envelope me-2"></i>{{ trans('dash.btn.label.send') }}</a>
                                                    <a href="{{ route('appoinment.printrecipe', App\Models\User::encryptor('encrypt', $recipe->id)) }}" target="_blank" class="btn btn-outline-primary btn-sm mt-3"><i class="fa-solid fa-print me-2"></i>{{ trans('dash.btn.label.printer') }}</a>
                                                </div>
                                            </div>
                                        </div>
        
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div>
                            <p class="mb-0 text-center"><i class="fa-regular fa-circle-xmark me-2 opacity-75"></i>{{ trans('dash.label.not.recipes') }}</p>
                        </div>
                    @endif

                </div>

            </div>
        </div>
    </section>

    @include('elements.footer')
    @include('elements.appointmodals', ['Modalrecipe' => true, 'ModalsendRecipe' => true, 'Modalreminder' => true])

@endsection


@push('scriptBottom')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/wpanel/library/jquery.toast.css') }}">
<script src="{{ asset('js/wpanel/library/jquery.toast.js') }}"></script>

<script>
    var reloadToComplete = true;

   $( '.select2' ).select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
    } );

    $( '.select3' ).select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        dropdownParent: $('#recipeModal')
    } );

    $('.select4').select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        dropdownParent: $('#petEditModal')
    });
</script>
@endpush