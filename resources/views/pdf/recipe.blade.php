<!DOCTYPE html>
<html>

<head>
    <title>Receta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            color: #6d6d6d;
        }

        h1 {
            color: #152630;
            font-size: 18px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 22px;
        }
        table.white {
            margin-bottom: 0;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .white th,
        .white td {
            border: 1px solid #fff;
            padding: 0;
        }

        th {
            background-color: #f2fbff;
            font-size: 11px;
            text-transform: uppercase
        }

        img {
            max-width: 150px;
            height: auto;
        }

        .cyan {
            color: #4bc6f9;
        }
        .center {
            text-align: center;
        }
        .text-end {
            text-align: right;
        }
    </style>
</head>

<body>

    <div class="center"><img src="{{ asset('img/logo.png') }}" alt="Vetegram"></div>

    <table class="white">
        <tr>
            <td>
                <h1>Receta @if(isset($pet->name)) de <span class="cyan">{{ $pet->name }}</span> @endif </h1>
            </td>
            <td class="text-end">{{ date("d/m/Y",strtotime($recipe->created_at)) }}</td>
        </tr>
    </table>

    @if(isset($vet->id))
    <table class="table mb-0 small align-middle">
        <tr>
            <td class="fw-medium"><strong>Veterinaria:</strong> {{ ($vet->company != '') ? $vet->company : $vet->social_name }}</td>
            <td class="fw-medium"><strong>Teléfono:</strong> {{ $vet->phone }}</td>
        </tr>
        <tr>
            <td class="fw-medium" colspan="2"><strong>Dirección:</strong> {{ $vet->address }}</td>
        </tr>
    </table>
    @endif

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Duración</th>
                <th>Tomar</th>
                <th class="center">Cantidad</th>
                <th>Notas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($details as $detail)
                <tr>
                    <td>{{ $detail->title }}</td>
                    <td>{{ $detail->duration }}</td>
                    <td>{{ $detail->take }}</td>
                    <td class="center">{{ $detail->quantity }}</td>
                    <td>{{ $detail->instruction }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if(isset($doctor->name))
    <p>Receta por <strong>{{ $doctor->name }}</strong></p>
    @endif

    @if((isset($doctor->code))&&($doctor->code != ''))
    <p>Médico veterinario N. <strong>{{ $doctor->code }}</strong></p>
    @endif

    @if((isset($doctor->signature))&&($doctor->signature != ''))
    <img width="200px" src="{{ $doctor->signature }}" alt="Firma">
    @endif

</body>

</html>
