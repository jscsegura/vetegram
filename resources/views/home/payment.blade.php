@extends('layouts.default')
@section('title', 'Vetegram')

@section('content')

@include('elements.docmenu')

@php $weblang = \App::getLocale(); @endphp

<section class="container-fluid pb-0 pb-lg-4">
    <div class="row px-2 px-lg-3 mt-2 mt-lg-4 mb-3 mb-lg-5">

        <div class="col-lg-11 col-xl-9 col-xxl-8 mx-auto mt-2">
            
            <h1 class="h4 text-uppercase text-center text-md-start fw-normal mb-3 mb-md-4">{{ trans('dash.label.payment.info') }} <span class="text-info fw-bold">{{ trans('dash.label.payment.of.paid') }}</span></h1>

            <div id="msgTest" class="alert alert-danger text-center small mt-3" role="alert" style="display: none;">
                <i class="fa-solid fa-triangle-exclamation opacity-50 me-2"></i>{{ trans('dash.label.payment.test') }}
            </div>

            <div class="row g-4 g-xl-5 justify-content-center">
                <div class="col-12 col-lg-7">
                    <div class="card border-2 border-secondary h-100">
                        <div class="card-body p-4 p-md-5 payFormTilopay">
                            <div class="mb-4">
                                <label for="tlpy_payment_method" class="form-label small">{{ trans('dash.label.payment.method') }}</label>
                                <select class="form-select fc" name="tlpy_payment_method" id="tlpy_payment_method"></select>
                            </div>
                            <div class="mb-4" id="selectToken" style="display: none;">
                                <label for="tlpy_saved_cards" class="form-label small">{{ trans('dash.label.payment.select.card') }}</label>
                                <select class="form-select fc" name="tlpy_saved_cards" id="tlpy_saved_cards" data-action="Home.selectCard" data-action-event="change" data-action-args="$value">
                                    <option value="">{{ trans('dash.label.payment.new.card') }}</option>
                                </select>
                            </div>
                            <div class="mb-4 withToken">
                                <label for="tlpy_cc_number" class="form-label small">{{ trans('dash.label.payment.number') }}</label>
                                <input type="tel" class="form-control fc" id="tlpy_cc_number" name="tlpy_cc_number">
                            </div>
                            <div class="row row-cols-1 row-cols-md-2">
                                <div class="col mb-4 mb-md-0 withToken">
                                    <label for="tlpy_cc_expiration_date" class="form-label small">{{ trans('dash.label.payment.date') }}</label>
                                    <input type="tel" class="form-control fc" id="tlpy_cc_expiration_date" name="tlpy_cc_expiration_date" placeholder="MM/AA">
                                </div>
                                <div class="col">
                                    <label for="tlpy_cvv" class="form-label small">{{ trans('dash.label.payment.cvv') }}</label>
                                    <input type="tel" class="form-control fc" id="tlpy_cvv" name="tlpy_cvv" placeholder="CVV">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-12">
                                    <br />
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" id="terms" name="terms">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            {{ trans('dash.label.payment.terms') }} <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#exampleModal">{{ trans('dash.label.payment.terms.link') }}</a>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="responseTilopay"></div>
                    </div>
                </div>
                <div class="col-12 col-lg-5">
                    <div class="card border-2 border-secondary">
                        <div class="card-body p-4 p-md-5 planlist2">
                            <h2 class="h5 text-uppercase opacity-75 fw-medium mb-2">{{ trans('dash.label.payment.purchase') }}</h2>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <p class="mb-0 fw-medium">Vetegram Pro</p>
                                <p class="mb-0 fw-medium">
                                    <sup class="me-1 fw-normal">Total</sup>
                                    ${{ $setting->price_pro }}/{{ trans('dash.label.payment.month') }}
                                </p>
                            </div>
                            <hr>
                            <div class="alert alert-warning text-center small mt-3" role="alert">
                                <i class="fa-solid fa-triangle-exclamation opacity-50 me-2"></i>{{ trans('dash.label.payment.apply.months') }}
                            </div>
                            <div class="mt-3">
                                <button type="button" class="btn btn-primary px-4" id="Paybtn" data-action="Home.pay" data-action-event="click">{{ trans('dash.label.payment.pay.subscription') }}</button>
                            </div>
                        </div>
                    </div>

                    <div id="msgError" class="alert alert-danger text-center small mt-3" role="alert" style="display: none;">
                        
                    </div>
                </div>
            </div>

        </div>

    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">{{ ucfirst(trans('dash.label.payment.terms.link')) }}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {!! $setting['term_' . $weblang] !!}
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

<script src="https://app.tilopay.com/sdk/v2/sdk_tpay.min.js"></script>

@php
    $orderNumber = rand(111,999) . date('YmdHis');
@endphp

<script>
    window.HOME_PAYMENT_CONFIG = {
        tilopay: {
            token: @json($token),
            currency: @json('USD'),
            language: @json($weblang),
            amount: @json($setting->price_pro),
            billToFirstName: @json($firstName),
            billToLastName: @json($lastName),
            billToAddress: @json($province),
            billToAddress2: @json('line 2 ' . $province),
            billToCity: @json($district),
            billToState: @json($canton),
            billToZipPostCode: @json('10101'),
            billToCountry: @json($country),
            billToTelephone: @json($user->phone),
            billToEmail: @json($user->email),
            orderNumber: @json($orderNumber),
            capture: @json('1'),
            redirect: @json(env('APP_URL') . '/response-tilopay'),
            subscription: @json('1'),
            hashVersion: @json('V2'),
            returnData: @json($user->id),
            shipToAddress: @json($province),
            shipToAddress2: @json('line 2 ' . $province),
            shipToCity: @json($district),
            shipToCountry: @json($country),
            shipToFirstName: @json($firstName),
            shipToLastName: @json($lastName),
            shipToState: @json($canton),
            shipToTelephone: @json($user->phone),
            shipToZipPostCode: @json('10101')
        },
        texts: {
            termAccept: @json(trans('dash.label.payment.pay.term.accept'))
        }
    };
</script>
<script src="{{ asset('js/home/payment.js') }}"></script>
@endpush
