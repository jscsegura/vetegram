<!DOCTYPE html>
<html>

<head>
    <title>Historial Clínico</title>
    <style>
        @font-face {
            font-family: 'Roboto';
            src: url({{ storage_path('fonts/Roboto-Black.ttf') }}) format('truetype');
            font-weight: 700;
            font-style: normal;
        }
        @font-face {
            font-family: 'Roboto';
            src: url({{ storage_path('fonts/Roboto-Regular.ttf') }}) format('truetype');
            font-weight: 300;
            font-style: normal;
        }
        body {
            font-family: "Roboto", sans-serif;
            font-size: 13px;
            font-weight: 300;
            color: #6d6d6d;
        }


        h1 {
            color: #152630;
            font-weight: 700;
            font-size: 18px;
        }
        h2 {
            color: #152630;
            font-size: 15px;
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
            font-size: 11px;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }
        td p {
            margin: 0 0 14px 0;
        }
        td p:last-of-type {
            margin: 0 0 0 0;
        }
        .titleH {
            font-size: 10px;
            text-transform: uppercase;
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

        .date {
            display: block;
            font-size: 11px;
        }
        .dName {
            display: block;
            position: absolute;
            right: 10px;
        }
        .physic {
            border: 1px dashed #d4d4d4;
            display: inline-block;
            margin: 8px 6px 0 0;
            padding: 6px 10px
        }
    </style>
</head>

<body>

    @php $weblang = \App::getLocale(); @endphp

    <div class="center"><img src="{{ asset('img/logo.png') }}" alt="Vetegram"></div>

    <table class="white">
        <tr>
            <td style="vertical-align: middle">
                <h1>Historial clínico @if(isset($pet->name)) de <span class="cyan">{{ $pet->name }}</span> @endif </h1>
            </td>
            @if(isset($pet['getUser']['name']))
            <td class="text-end" style="vertical-align: middle"><strong>Dueño: {{ $pet['getUser']['name'] }}</strong></td>
            @endif
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th class="cyan" colspan="3">Datos del paciente</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong class="titleH">Especie:</strong> {{ $pet['getType']['title_' . $weblang] }}</td>
                <td><strong class="titleH">Raza:</strong> {{ $pet['getBreed']['title_' . $weblang] }}</td>
                <td><strong class="titleH">Edad:</strong> {{ ($pet->age != '') ? App\Models\Pet::getAgeValue($pet->age) : trans('dash.labe.no.info') }}</td>
            </tr>
            <tr>
                <td><strong class="titleH">Sexo:</strong> {{ ($pet->gender != '') ? trans('dash.label.sex.' . $pet->gender) : trans('dash.labe.no.info') }}</td>
                <td><strong class="titleH">Castrado:</strong> {{ ($pet->castrate == 1) ? 'Si' : 'No' }}</td>
                <td><strong class="titleH">Color:</strong> {{ ($pet->color != '') ? $pet->color : trans('dash.labe.no.info') }}</td>
            </tr>
            <tr>
                <td><strong class="titleH">Alimentación:</strong> {{ ($pet->alimentation != '') ? $pet->alimentation : trans('dash.labe.no.info') }}</td>
                <td><strong class="titleH">Tipo de sangre:</strong> {{ ($pet->blood != '') ? $pet->blood : trans('dash.labe.no.info') }}</td>
                <td><strong class="titleH">Enfermedad:</strong> {{ ($pet->disease != '') ? $pet->disease : trans('dash.labe.no.info') }}</td>
            </tr>
        </tbody>
    </table>

    <table>
        <thead>
            <tr>
                <th class="cyan" colspan="2">Datos del propietario</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong class="titleH">Nombre:</strong> {{ $pet['getUser']['name'] }}</td>
                <td><strong class="titleH">Identificación:</strong> {{ $pet['getUser']['dni'] }}</td>
            </tr>
            <tr>
                <td><strong class="titleH">Teléfono:</strong> {{ $pet['getUser']['phone'] }}</td>
                <td><strong class="titleH">Email:</strong> {{ $pet['getUser']['email'] }}</td>
            </tr>
            <tr>
                <td colspan="2"><strong class="titleH">Dirección:</strong> {{ App\Models\Countries::getResumeLocation($pet['getUser']['country'], $pet['getUser']['province'], $pet['getUser']['canton'], $pet['getUser']['district']) }}</td>
            </tr>
        </tbody>
    </table>

    <h2>CITAS</h2>
    @foreach ($appointments as $appointment)
    <table>
        <thead>
            <tr>
                <th class="cyan" colspan="2">
                    Fecha: {{ date("d/m/Y",strtotime($appointment->date)) }} &nbsp;|&nbsp; Hora: {{ date("h:i a",strtotime($appointment->hour)) }}
                    @if(isset($appointment['getDoctor']['name']))
                    <span class="dName">Doctor: {{ $appointment['getDoctor']['name'] }}</strong></span>
                    @endif
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="width: 24%"><strong class="titleH">Razón de la cita</strong></td>
                <td>{{ $appointment->reason }}</td>
            </tr>
            <tr>
                <td><strong class="titleH">Síntomas</strong></td>
                <td>{{ $appointment->diagnosis }}</td>
            </tr>
            <tr>
                <td><strong class="titleH">Notas</strong></td>
                <td>
                    @foreach ($appointment['getAllNotes'] as $note)
                        @if($credentials['access'] == false)
                            @if($note->id_vet_created == $credentials['id_vet'])
                                <p><span class="date">{{ date("d/m/Y",strtotime($note->created_at)) }}</span>{{ $note->note }}</p>
                            @endif
                        @else
                            <p><span class="date">{{ date("d/m/Y",strtotime($note->created_at)) }}</span>{{ $note->note }}</p>
                        @endif
                    @endforeach
                </td>
            </tr>
            <tr>
                <td><strong class="titleH">Historial de la cita actual</strong></td>
                <td>{{ $appointment->history }}</td>
            </tr>
            <tr>
                <td><strong class="titleH">Examen físico</strong></td>
                <td>
                    @if($appointment->physical != '')
                        @php $physical = json_decode($appointment->physical, true); @endphp
                        @if(count($physical) > 0)
                            @foreach ($physical as $item)
                                @php
                                    $text = $item['cat'] . ' > ';
                                    if($item['subopt'] != '') {
                                        if($item['value'] != '') {
                                            $text .= $item['opt'] . ' > ' . $item['subopt'] . ': <strong>' . $item['value'] . '</strong>';
                                        }else{
                                            $text .= $item['opt'] . ': <strong>' . $item['subopt'] . '</strong>';
                                        }
                                    }else{
                                        if($item['value'] != '') {
                                            $text .= $item['opt'] . ': <strong>' . $item['value'] . '</strong>';
                                        }else{
                                            $text .= '<strong>' . $item['opt'] . '</strong>';
                                        }
                                    }
                                @endphp
                                <span class="physic">{!! $text !!}</span>
                            @endforeach
                        @endif
                    @endif
                </td>
            </tr>
            <tr>
                <td><strong class="titleH">Diagnósticos diferenciales</strong></td>
                <td>{{ ($appointment->differential == 'Otro') ? $appointment->differential_other : $appointment->differential }} </td>
            </tr>
            <tr>
                <td><strong class="titleH">Diagnóstico definitivo</strong></td>
                <td>{{ ($appointment->definitive == 'Otro') ? $appointment->definitive_other : $appointment->definitive }}</td>
            </tr>
            <tr>
                <td><strong class="titleH">Tratamiento</strong></td>
                <td>{{ $appointment->treatment }}</td>
            </tr>
            <tr>
                <td><strong class="titleH">Receta</strong></td>
                <td>
                    @foreach ($appointment['getRecipesId'] as $recipe)
                        @if($credentials['access'] == false)
                            @if($recipe->id_vet_created == $credentials['id_vet'])
                                <p>Ver receta del día <u>{{ date("d/m/Y",strtotime($recipe->created_at)) }}</u></p>
                            @endif
                        @else
                            <p>Ver receta del día <u>{{ date("d/m/Y",strtotime($recipe->created_at)) }}</u></p>
                        @endif
                    @endforeach
                </td>
            </tr>
        </tbody>
    </table>
    @endforeach


    <h2>RECETAS</h2>
    @if(count($recipes) > 0)
        @foreach ($recipes as $recipe)
        <table>
            <thead>
                <tr>
                    <th class="center cyan" colspan="5">Fecha: {{ date("d/m/Y",strtotime($recipe->created_at)) }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong class="titleH">Nombre</strong></td>
                    <td><strong class="titleH">Duración</strong></td>
                    <td><strong class="titleH">Tomar</strong></td>
                    <td class="center"><strong class="titleH">Cantidad</strong></td>
                    <td><strong class="titleH">Notas</strong></td>
                </tr>
                @foreach ($recipe['detail'] as $detail)
                <tr>
                    <td>{{ $detail['title'] }}</td>
                    <td>{{ $detail['duration'] }}</td>
                    <td>{{ $detail['take'] }}</td>
                    <td class="center">{{ $detail['quantity'] }}</td>
                    <td>{{ $detail['instruction'] }}</td>
                </tr>
                @endforeach
                @if(isset($recipe['getDoctor']['name']))
                <tr>
                    <td class="center" colspan="5"><small>Receta por <strong>{{ $recipe['getDoctor']['name'] }}</strong></small></td>
                </tr>
                @endif
            </tbody>
        </table>
        @endforeach
    @else
        <p>No hay recetas</p>
    @endif

    <h2>VACUNAS</h2>
    @if(count($vaccines) > 0)
        <table>
            <tbody>
                <tr>
                    <td><strong class="titleH">Aplicación</strong></td>
                    <td><strong class="titleH">Fármaco</strong></td>
                    <td class="center"><strong class="titleH">Marca</strong></td>
                    <td class="center"><strong class="titleH">Lote</strong></td>
                    <td class="center"><strong class="titleH">Caducidad</strong></td>
                    <td class="center"><strong class="titleH">Fotografía</strong></td>
                    <td class="center"><strong class="titleH">Profesional</strong></td>
                </tr>
                @foreach ($vaccines as $vaccine)
                <tr>
                    <td>{{ ($vaccine->date != '') ? date('d/m/Y', strtotime($vaccine->date)) : date('d/m/Y', strtotime($vaccine->created_at)) }}</td>
                    <td>{{ $vaccine->name }}</td>
                    <td class="center">{{ ($vaccine->brand != '') ? $vaccine->brand : 'NA' }}</td>
                    <td class="center">{{ ($vaccine->batch != '') ? $vaccine->batch : 'NA' }}</td>
                    <td class="center">{{ ($vaccine->expire != '') ? date('d/m/Y', strtotime($vaccine->expire)) : 'NA' }}</td>
                    <td class="center">
                        @if($vaccine->photo != '')
                            <img src="{{ asset($vaccine->photo) }}" alt="Vacuna" class="vaccineImg">
                        @else
                            <p>No Disponible</p>
                        @endif
                    </td>
                    <td class="center">
                        <p>{{ (isset($vaccine['getDoctor']['name'])) ? $vaccine['getDoctor']['name'] : $vaccine->doctor_name }}</p>
                        @if((isset($vaccine['getDoctor']['signature'])) && ($vaccine['getDoctor']['signature'] != ''))
                        <img width="80px" src="{{ $vaccine['getDoctor']['signature'] }}" alt="Firma">
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay vacunas</p>
    @endif

    <h2>DESPARACITANTES</h2>
    @if(count($desparat) > 0)
        <table>
            <tbody>
                <tr>
                    <td><strong class="titleH">Aplicación</strong></td>
                    <td><strong class="titleH">Fármaco</strong></td>
                    <td class="center"><strong class="titleH">Marca</strong></td>
                    <td class="center"><strong class="titleH">Lote</strong></td>
                    <td class="center"><strong class="titleH">Caducidad</strong></td>
                    <td class="center"><strong class="titleH">Fotografía</strong></td>
                    <td class="center"><strong class="titleH">Profesional</strong></td>
                </tr>
                @foreach ($desparat as $desp)
                <tr>
                    <td>{{ ($desp->date != '') ? date('d/m/Y', strtotime($desp->date)) : date('d/m/Y', strtotime($desp->created_at)) }}</td>
                    <td>{{ $desp->name }}</td>
                    <td class="center">{{ ($desp->brand != '') ? $desp->brand : 'NA' }}</td>
                    <td class="center">{{ ($desp->batch != '') ? $desp->batch : 'NA' }}</td>
                    <td class="center">{{ ($desp->expire != '') ? date('d/m/Y', strtotime($desp->expire)) : 'NA' }}</td>
                    <td class="center">
                        @if($desp->photo != '')
                            <img src="{{ asset($desp->photo) }}" alt="Vacuna" class="vaccineImg">
                        @else
                            <p>No Disponible</p>
                        @endif
                    </td>
                    <td class="center">
                        <p>{{ (isset($desp['getDoctor']['name'])) ? $desp['getDoctor']['name'] : $desp->doctor_name }}</p>
                        @if((isset($desp['getDoctor']['signature'])) && ($desp['getDoctor']['signature'] != ''))
                        <img width="80px" src="{{ $desp['getDoctor']['signature'] }}" alt="Firma">
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay vacunas</p>
    @endif

</body>

</html>