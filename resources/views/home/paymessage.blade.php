@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@php
    $userInSession = ((isset(Auth::guard('web')->user()->id))) ? Auth::guard('web')->user() : null;
@endphp

@if(isset($userInSession->id))
    @include('elements.docmenu')
@else
    @include('elements.alonetop')
@endif

<section class="container-fluid pb-0 pb-lg-4">
    <div class="row px-2 px-lg-3 mt-2 mt-lg-4 mb-3 mb-lg-5">

        <div class="col-lg-11 col-xl-9 col-xxl-8 mx-auto mt-2">
            
            <div class="row g-4 g-xl-5 justify-content-center">
                <div class="col-12 col-lg-7">
                    <div class="card border-2 border-secondary h-100">
                        <div class="card-body p-2">
                            @if($code == '1')
                            <div class="alert alert-success mb-0 p-4 p-lg-5" role="alert">
                                <div class="text-center fs-1">
                                    <i class="fa-regular fa-circle-check"></i>
                                </div>
                                <h1 class="h2 text-white text-center">{{ trans('dash.label.payment.success') }}</h1>
                                <p class="mb-0 fs-5">{{ trans('dash.label.payment.thanks') }}</p>
                            </div>
                            @else
                            <div class="alert alert-danger mb-0 p-4 p-lg-5" role="alert">
                                <div class="text-center fs-1">
                                    <i class="fa-regular fa-circle-xmark"></i>
                                </div>
                                <h1 class="h2 text-white text-center">{{ trans('dash.label.payment.error') }}</h1>
                                <p class="mb-0 fs-5">{{ trans('dash.label.payment.error.message') }}</p>
                                <p class="mb-0 fs-5"><br />{{ trans('dash.label.payment.response') }}: {{$text}}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
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

@endpush