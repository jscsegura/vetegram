@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@include('elements.docmenu')

@php $weblang = \App::getLocale(); @endphp

<section class="container-fluid pb-0 pb-lg-4">
    <div class="row px-2 px-lg-3 mt-2 mt-lg-4 mb-3 mb-lg-5">

        <div class="col-lg-10 col-xl-9 col-xxl-8 mx-auto mt-2">
            <h2 class="h4 text-uppercase text-center text-md-start fw-normal mb-3 mb-md-4">{{ trans('dash.label.my') }} <span class="text-info fw-bold">plan</span></h2>

            <div class="row row-cols-1 row-cols-md-2 g-4 g-lg-5">
                <div class="col">
                    <div class="card border-2 border-secondary @if($vet->pro == 0) border-info @endif h-100">
                        <div class="card-body p-0">
                            @if($vet->pro == 0)
                            <span class="planLegend d-block fw-semibold text-center text-uppercase small text-primary px-2">{{ trans('dash.label.payment.current') }}</span>
                            @endif
                            <div class="border-bottom border-2 border-secondary px-4 px-md-5 py-3 py-md-4">
                                <h1 class="h3 my-0 fw-medium">{{ trans('dash.label.payment.free') }}</h1>
                            </div>
                            <div class="p-4 p-md-5 planlist">
                                <h2 class="h1"><sup class="fw-light me-1">$</sup>0</h2>
                                <ul class="mt-3 px-0 mb-0">
                                    @foreach ($pros as $pro)
                                        @if($pro->pro == 0)
                                            <li>{{ $pro['title_' . $weblang] }}</li>    
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card border-2 border-secondary @if($vet->pro == 1) border-info @endif h-100">
                        <div class="card-body p-0">
                            @if($vet->pro == 1)
                            <span class="planLegend d-block fw-semibold text-center text-uppercase small text-primary px-2">{{ trans('dash.label.payment.current') }}</span>
                            @endif
                            <div class="border-bottom border-2 border-secondary px-4 px-md-5 py-3 py-md-4">
                                <h1 class="h3 my-0 fw-medium">Vetegram PRO</h1>
                            </div>
                            <div class="p-4 p-md-5 planlist2">
                                <h2 class="h1"><sup class="fw-light me-1">$</sup>{{ $setting->price_pro }}<span class="fw-light small2">/{{ trans('dash.label.payment.month') }}</span></h2>
                                @if($vet->pro == 0)
                                <button type="button" data-action="Home.callPlan" data-action-event="click" class="w-100 btn btn-primary text-uppercase py-2 mt-1">{{ trans('dash.label.payment.solicitation') }}</button>
                                @endif
                                <ul class="mt-3 px-0 mb-0">
                                    @foreach ($pros as $pro)
                                        @if($pro->pro == 1)
                                            <li>{{ $pro['title_' . $weblang] }}</li>    
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @if($vet->pro == 1)
                        <div class="text-center mb-3">
                            <button type="button" class="btn btn-sm btn-outline-secondary border-secondary" data-bs-toggle="modal" data-bs-target="#planReason">
                                <small>{{ trans('dash.label.payment.cancel.subscription') }}</small>
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="text-center mt-4 mt-lg-5">
                <button type="button" class="btn btn-outline-dark py-2" data-bs-toggle="modal" data-bs-target="#planHistory">
                    {{ trans('dash.label.payment.history') }}
                </button>
            </div>

        </div>

    </div>
</section>

@include('elements.footer')

<div class="modal fade" id="planReason" tabindex="-1" aria-labelledby="planReasonLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="fw-normal mb-0 text-secondary">{{ trans('dash.label.payment.cancel') }}</h6>
                <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 p-md-4">
                <div>
                    <label for="planWhy" class="form-label d-block text-center fw-medium mb-2">{{ trans('dash.label.payment.motive') }}</label>
                    <textarea class="form-control" id="planWhy" name="planWhy" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer px-3 px-md-4 pb-3 pb-md-4 pt-0">
                <button type="button" data-action="Home.cancelPlan" data-action-event="click" class="btn btn-primary btn-sm px-4">{{ trans('dash.label.btn.continue') }}</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="planHistory" tabindex="-1" aria-labelledby="planHistoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="fw-normal mb-0 text-secondary">{{ trans('dash.label.payment.history') }}</h6>
                <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 p-md-4">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col" class="small">{{ trans('dash.label.date') }}</th>
                            <th scope="col" class="small">{{ trans('dash.label.payment.amount') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($payments) > 0)
                            @foreach ($payments as $payment)
                            <tr>
                                <td>{{ date('d/m/Y', strtotime($payment->created_at)) }}</td>
                                <td>${{ $payment->amount }}</td>
                            </tr>
                            @endforeach
                        @else
                        <tr>
                            <td colspan="2">{{ trans('dash.label.not.register') }}</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scriptBottom')
<link rel="stylesheet" href="{{ asset('css/wpanel/library/jquery.toast.css') }}">
<script src="{{ asset('js/wpanel/library/jquery.toast.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    window.HOME_PLAN_CONFIG = {
        routes: {
            payment: @json(route('home.payment')),
            cancel: @json(route('home.cancelPro'))
        },
        texts: {
            title: @json(trans('dash.msg.start.plan')),
            text: @json(trans('dash.msg.confir.start.plan')),
            confirm: @json(trans('dash.label.yes.contact')),
            cancel: @json(trans('dash.label.not'))
        }
    };
</script>
<script src="{{ asset('js/home/plan.js') }}"></script>
@endpush
