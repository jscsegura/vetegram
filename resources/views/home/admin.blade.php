@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@include('elements.docmenu')

<section class="container-fluid pb-0 pb-lg-4">
    <div class="row px-2 px-lg-3 mt-2 mt-lg-4 mb-3 mb-lg-5">
        
        <div class="col-lg-10 col-xl-9 col-xxl-8 mx-auto mt-2">
            <h1 class="h4 text-uppercase text-center text-md-start fw-normal mb-2 mb-md-3">{{ trans('dash.menu.setting') }}</h1>
            <div class="row g-3">
                <div class="col-md-4">
                    <a href="{{ route('adminuser.index') }}" class="btn btn-primary p-4 d-block">
                        <span class="adminIcon"><i class="fa-solid fa-user-group"></i></span>
                        <span class="text-uppercase fw-semibold">{{ trans('dashadmin.label.title.user') }}</span>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('adminpatient.index') }}" class="btn btn-primary p-4 d-block">
                        <span class="adminIcon"><i class="fa-solid fa-paw"></i></span>
                        <span class="text-uppercase fw-semibold">{{ trans('dashadmin.label.title.patients') }}</span>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('inventory.index') }}" class="btn btn-primary p-4 d-block">
                        <span class="adminIcon"><i class="fa-solid fa-basket-shopping"></i></span>
                        <span class="text-uppercase fw-semibold">{{ trans('dashadmin.label.product.services') }}</span>
                    </a>
                </div>
                {{-- <div class="col-md-4">
                    <a href="{{ route('adminstore') }}" class="btn btn-primary p-4 d-block">
                        <span class="adminIcon"><i class="fa-solid fa-store"></i></span>
                        <span class="text-uppercase fw-semibold">{{ trans('dashadmin.label.title.store') }}</span>
                    </a>
                </div> --}}
                <div class="col-md-4">
                    <a href="{{ route('schedule.menu') }}" class="btn btn-primary p-4 d-block">
                        <span class="adminIcon"><i class="fa-solid fa-calendar-days"></i></span>
                        <span class="text-uppercase fw-semibold">{{ trans('dashadmin.label.menu.agenda') }}</span>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('sett.physicalexam') }}" class="btn btn-primary p-4 d-block">
                        <span class="adminIcon"><i class="fa-solid fa-weight-scale"></i></span>
                        <span class="text-uppercase fw-semibold">{{ trans('dashadmin.label.menu.exams') }}</span>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('sett.grooming') }}" class="btn btn-primary p-4 d-block">
                        <span class="adminIcon"><i class="fa-solid fa-scissors"></i></span>
                        <span class="text-uppercase fw-semibold">Grooming</span>
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>

@include('elements.footer')

@endsection

@push('scriptBottom')
@endpush