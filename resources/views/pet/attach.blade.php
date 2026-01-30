@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@include('elements.docmenu')

<section class="container-fluid pb-0 pb-lg-4 px-xxl-5">
    <div class="row px-2 px-lg-3 mt-2 mt-lg-4">

        <div class="col-md-7 col-xl-3 mx-auto">
            @include('elements.petDetail')
        </div>
                
        <div class="col-12 col-xl-9 ps-xl-4 mt-3 mt-lg-0">
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
            
            @if($pet->dead_flag == 0)
            <div class="d-flex flex-column flex-sm-row justify-content-end mb-3">
                <a href="javascript:void(0);" data-action="Appointments.setIdAppointmentToAttach" data-action-event="click" data-action-args="0|{{ $pet->id }}" class="btn btn-secondary btn-sm px-4 text-uppercase" data-bs-toggle="modal" data-bs-target="#attachModal"><i class="fa-solid fa-paperclip me-2"></i>Agregar adjunto</a>
            </div>
            @endif

            <div class="row g-3">
                @if(count($attachs) > 0)
                    @php
                        $thisUser = Auth::guard('web')->user()->id;
                    @endphp
                    @foreach ($attachs as $attach)
                        @php
                            $ext = pathinfo($attach->attach, PATHINFO_EXTENSION);
                        @endphp
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="d-flex align-items-center border border-2 border-secondary rounded h-100 pe-2">
                                <a target="_blank" href="{{ asset('files/' . $attach->folder . '/' . $attach->attach) }}" class="flex-1 d-flex gap-2 gap-sm-3 link-secondary p-3 text-decoration-none">
                                    @if(in_array($ext, ['jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG', 'gif', 'GIF']))
                                        <i class="fa-regular fa-file-image fs-2"></i>
                                    @elseif (in_array($ext, ['pdf', 'PDF']))
                                        <i class="fa-regular fa-file-pdf fs-2"></i>
                                    @else
                                        <i class="fa-regular fa-file fs-2"></i>
                                    @endif
                                    <div>
                                        <p class="fs-6 lh-sm mb-0 fw-medium"><small class="text-break">{{ $attach->title }}</small></p>
                                        <p class="small lh-sm"><small>{{ date('d', strtotime($attach->created_at)) . ' de ' . strtolower(trans('dash.month.num' . (int)date('m', strtotime($attach->created_at)))) . ', ' . date('Y', strtotime($attach->created_at)) }}</small></p>
                                    </div>
                                </a>
                                <button type="button" class="btn btn-link p-2 opacity-75" title="Enviar" data-action="Appointments.setIdAppointmentToSendAttach" data-action-event="click" data-action-args="{{ $attach->id }}|{{ $owner->email }}" data-bs-toggle="modal" data-bs-target="#sendAttachModal"><i class="fa-regular fa-envelope"></i></button>
                                @if($attach->created_by == $thisUser)
                                <button type="button" data-id="{{ $attach->id }}" data-action="Pet.removeFile" data-action-event="click" data-action-args="$el" class="btn btn-link p-2 opacity-75" title="Borrar"><i class="fa-regular fa-trash-can"></i></button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="mb-0 text-center"><i class="fa-regular fa-circle-xmark me-2 opacity-75"></i>{{ trans('dash.label.not.attachments') }}</p>
                @endif
            </div>
        </div>
    </div>
</section>

@include('elements.footer')
@include('elements.appointmodals', ['Modalattach' => true, 'Modalreminder' => true, 'ModalsendAttach' => true])

@endsection

@push('scriptBottom')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/wpanel/library/jquery.toast.css') }}">
<script src="{{ asset('js/wpanel/library/jquery.toast.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    window.PET_COMMON_CONFIG = {
        routes: {
            deleteAttach: @json(route('appoinment.deleteAttach'))
        },
        texts: {
            deleteAttachTitle: @json(trans('dash.msg.delete.attach')),
            deleteAttachConfirm: @json(trans('dash.msg.confir.delete.attach')),
            deleteYes: @json(trans('dash.label.yes.delete')),
            deleteNo: @json(trans('dash.label.no.cancel')),
            deleteAttachPermError: @json(trans('dash.msg.error.perm.attach')),
            deleteAttachError: @json(trans('dash.msg.error.delete.attach'))
        },
        selectors: {
            petEditModal: '#petEditModal'
        }
    };
</script> 
<script src="{{ asset('js/pet/common.js') }}"></script>
<script src="{{ asset('js/pet/attach.js') }}"></script>
@endpush
