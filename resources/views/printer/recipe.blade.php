@extends('layouts.empty')

@section('content')
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Imprimir receta</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <style>
            @media print{
                .btn-dark { display: none !important }
            }
        </style>
    </head>

    <body @if($printerNow == '') data-auto-print="1" @endif>

        <div class="p-4">
            <div class="d-flex align-items-center justify-content-center gap-4 mb-3">
                <img src="{{ asset('img/logo.png') }}" alt="Vetegram" style="width: 200px">
                <button type="button" class="btn btn-dark" data-action="print" data-action-event="click">{{ trans('dash.btn.label.printer') }}</button>
            </div>

            <div class="d-flex align-items-center mb-1">
                <h1 class="h3 fw-semibold">{{ trans('dash.label.recipes') }} @if(isset($pet->name)) {{ trans('dash.label.of') }} <span class="fw-bold" style="color: #4bc6f9">{{ $pet->name }}</span> @endif</h1>
                <div class="ms-auto">{{ date("d/m/Y",strtotime($recipe->created_at)) }}</div>
            </div>

            @if(isset($vet->id))
            <table class="table table-bordered mb-4 small align-middle">
                <tr>
                    <td class="fw-medium"><strong class="fw-semibold">{{ trans('dash.label.vet.title') }}:</strong> {{ ($vet->company != '') ? $vet->company : $vet->social_name }}</td>
                    <td class="fw-medium"><strong class="fw-semibold">{{ trans('dash.label.phone') }}:</strong> {{ $vet->phone }}</td>
                </tr>
                <tr>
                    <td class="fw-medium" colspan="2"><strong class="fw-semibold">{{ trans('dash.label.address') }}:</strong> {{ $vet->address }}</td>
                </tr>
            </table>
            @endif

            <table class="table table-bordered mb-0 small align-middle">
                <thead>
                    <tr>
                        <th class="bg-light fw-semibold">{{ trans('dash.label.name') }}</th>
                        <th class="bg-light fw-semibold">{{ trans('dash.label.duration') }}</th>
                        <th class="bg-light fw-semibold text-center">{{ trans('dash.label.take') }}</th>
                        <th class="bg-light fw-semibold text-center">{{ trans('dash.label.quantity') }}</th>
                        <th class="bg-light fw-semibold">{{ trans('dash.label.notes') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($details as $detail)
                        <tr>
                            <td class="fw-medium">{{ $detail->title }}</td>
                            <td>{{ $detail->duration }}</td>
                            <td class="text-center">{{ $detail->take }}</td>
                            <td class="text-center">{{ $detail->quantity }}</td>
                            <td>{{ $detail->instruction }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            @if(isset($doctor->name))
            <p class="small mt-3">{{ trans('dash.label.recipe.by') }} <strong>{{ $doctor->name }}</strong></p>
            @endif

            @if((isset($doctor->code))&&($doctor->code != ''))
            <p class="small mt-3">{{ trans('dash.label.doctor.vet') }} N. <strong>{{ $doctor->code }}</strong></p>
            @endif

            @if((isset($doctor->signature))&&($doctor->signature != ''))
            <img width="200px" src="{{ $doctor->signature }}" alt="Firma">
            @endif
            
        </div>
        <script src="{{ asset('js/common/action-router.js') }}"></script>
        <script src="{{ asset('js/common/auto-print.js') }}"></script>

    </body>

    </html>
@endsection
