@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

    @include('elements.alonetop')

    <section class="container-fluid pb-0 pb-lg-4">
        <div class="row px-2 px-lg-3 mt-2 mt-lg-4 mb-3 mb-lg-5">

            <div class="smallCol mx-auto mt-2">

                <h2 class="h4 text-uppercase text-center text-md-start fw-normal mb-3">{{ trans('dash.label.download') }} <span class="text-info fw-bold">{{ trans('dash.label.doc') }}</span></h2>
                
                @if(isset($attach->id))
                    <div class="d-flex align-items-center border border-2 border-secondary rounded">
                        @php
                            $ext = pathinfo($attach->attach, PATHINFO_EXTENSION);
                        @endphp
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
                    </div>
                @else
                    <p>{{ trans('dash.label.doc.not.exist') }}</p>
                @endif
            </div>

        </div>
    </section>

    @include('elements.footer')

@endsection

@push('scriptBottom')
    <link rel="stylesheet" href="{{ asset('css/wpanel/library/jquery.toast.css') }}">
    <script src="{{ asset('js/wpanel/library/jquery.toast.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
