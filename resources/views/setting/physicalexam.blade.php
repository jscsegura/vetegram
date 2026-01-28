@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@include('elements.docmenu')

@php $weblang = \App::getLocale(); @endphp

<section class="container-fluid pb-0 pb-lg-4 px-xl-5">
    <div class="row px-2 px-lg-3 mt-2 mt-lg-4">

        <form name="frm" id="frm" method="POST" action="{{ route('sett.physicalexamStore') }}">
            @csrf
            <div class="col-lg-10 col-xl-9 col-xxl-8 mx-auto mt-3">

                <h1 class="h4 text-uppercase justify-content-center justify-content-md-start fw-normal mb-3 flex-grow-1 d-flex gap-1 align-items-center">
                    <a href="{{ route('admin') }}" class="btn btn-sm smIcon"><i class="fa-solid fa-arrow-left-long"></i></a>
                    <span>{{ trans('dash.exam.only.exam') }} <span class="text-info fw-bold">{{ trans('dash.exam.only.physical') }}</span></span>
                </h1>
                
                <div class="card rounded-3 border-2 border-secondary px-2 px-lg-3 py-2 py-lg-3 mb-0 mb-lg-5">
                    <div class="card-body p-3">
                        <p class="fs-5 fw-normal mb-0 text-center lh-sm">{{ trans('dash.label.select.categories') }}:</p>
                        
                        @foreach ($categories as $category)
                            <h3 class="h6 fw-medium text-uppercase mt-4">{{ $category['title_' . $weblang] }}</h3>
                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 g-1">
                                @foreach ($category['options'] as $option)
                                    <div class="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="option{{ $option['id'] }}" name="options[]" value="{{ $category->id }}-{{ $option['id'] }}" @if(in_array($option['id'], $rowOptions)) checked @endif>
                                            <label class="form-check-label" for="option{{ $option['id'] }}">{{ $option['title_' . $weblang] }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <hr class="border-2 border-secondary opacity-100 mt-4">
                        @endforeach

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary px-5">{{ trans('dash.text.btn.save') }}</button>
                        </div>
                    </div>
                </div>

            </div>
        </form>

    </div>
</section>

@include('elements.footer')

@endsection

@push('scriptBottom')
<link rel="stylesheet" href="{{ asset('css/wpanel/library/jquery.toast.css') }}">
<script src="{{ asset('js/wpanel/library/jquery.toast.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
</script>
@endpush