@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@include('elements.docmenu')

<section class="container-fluid pb-0 pb-lg-4">

    <div class="row px-2 px-lg-3 mt-2 mt-lg-4">

        <h1 class="h4 text-uppercase text-center text-md-start fw-normal mb-3"> <a href="{{ route('schedule.menu') }}" class="btn btn-sm smIcon"><i class="fa-solid fa-arrow-left-long"></i></a>{{ trans('dash.schedule.schedule.title1') }} <span class="text-info fw-bold">{{ trans('dash.schedule.schedule.title2') }}</span></h1>
        <form name="frmAddAppointment" id="frmAddAppointment" action="{{ route('schedule.storeSchedule') }}" method="post" data-action="Schedule.validateSchedule" data-action-event="submit" enctype="multipart/form-data" class="col-lg-10 col-xl-8 col-xxl-6 mx-auto mt-4 mt-lg-0 mb-lg-5">
            @csrf

            <div class="container mt-4 mx-auto" style="max-width: 600px;">
                @include('schedule.schedule._fields')

                <div class="d-flex justify-content-end">
                    <div class="d-flex flex-column flex-md-row gap-2 gap-md-4">
                        <div class="d-none d-md-block">
                            <i class="fa-solid fa-angle-right fa-fw fs-5 mt-1 text-white"></i>
                        </div>
                        <div class="d-flex flex-column flex-sm-row gap-2">
                            <button type="submit" class="btn btn-primary px-4" id="btnSave">
                                {{ trans('dash.text.btn.save') }} <i class="fa-solid fa-angle-right fa-fw fs-5 mt-1 text-white"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>


</section>
@endsection

@push('scriptBottom')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('js/front/datedropper.js') }}"></script>

<link rel="stylesheet" href="{{ asset('css/wpanel/library/jquery.toast.css') }}">
<script src="{{ asset('js/wpanel/library/jquery.toast.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@include('schedule.schedule._script')
@endpush
