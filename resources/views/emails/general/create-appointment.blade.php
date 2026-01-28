<br>
<br>
<br>
<table class="email-container" cellspacing="0" cellpadding="0">
    <tr>
        <td class="header">
            <img src="{{ config('app.url') }}/img/logo.png" alt="Vetegram" class="logo">
        </td>
    </tr>
    <tr>
        <td class="tdPad">
            <h1>{{ trans('auth.label.create.appointment.title') }}</h1>
            <p>{{ trans('auth.register.complete.hello') }} <strong>{{ $name }}</strong><br>
                {{ trans('auth.label.create.appointment.intro') }}</p>
            <p>{{ trans('auth.label.create.appointment.date') }}<strong>{{ $date }}</strong></p>
            <p>{{ trans('auth.label.create.appointment.doctor') }}<u>{{ $doctor }}</u></p>

            <p>{{ trans('auth.label.create.appointment.conclusion') }}{{ trans('auth.label.text.to.cancel.first') }} <a href="{{ url('appointment-reschedule/' . App\Models\User::encryptor('encrypt', $appointmentId)) }}"><strong>{{ trans('auth.label.text.here') }}</strong></a> {{ trans('auth.label.text.to.cancel.second') }} <a href="{{ url('appointment-cancel/' . App\Models\User::encryptor('encrypt', $appointmentId)) }}"><strong>{{ trans('auth.label.text.here') }}</strong></a>.</p>

            @php
                $dateAux = new DateTime($created);
                $formattedDate = $dateAux->format('Ymd\THis\Z');
                $interval = new DateInterval('PT30M');
                $dateAux->add($interval);
                $formattedDateEnd = $dateAux->format('Ymd\THis\Z');

                $urlGoogle = 'https://calendar.google.com/calendar/render';
                $paramGoogle = [
                    "action" => "TEMPLATE", 
                    "dates" => $formattedDate . "/" . $formattedDateEnd, 
                    "details" => trans('auth.label.create.appointment.doctor') . $doctor, 
                    "location" => trans('auth.label.clinic'),
                    "text" => trans('auth.label.create.appointment.title')
                ];
                $urlGoogle = $urlGoogle . "?" . http_build_query($paramGoogle);

                $dateAux = new DateTime($created);
                $formattedDate = $dateAux->format('Y-m-d\TH:i:s');
                $interval = new DateInterval('PT30M');
                $dateAux->add($interval);
                $formattedDateEnd = $dateAux->format('Y-m-d\TH:i:s');

                $urlOutlook = 'https://outlook.live.com/calendar/0/action/compose';
                $paramOutlook = [
                    "allday" => "false", 
                    "body" => trans('auth.label.create.appointment.doctor') . $doctor,
                    "enddt" => $formattedDateEnd, 
                    "location" => trans('auth.label.clinic'), 
                    "path" => "%2Fcalendar%2Faction%2Fcompose",
                    "rru" => "addevent",
                    "startdt" => $formattedDate,
                    "subject" => trans('auth.label.create.appointment.title')
                ];
                $urlOutlook = $urlOutlook . "?" . http_build_query($paramOutlook);
            @endphp

            <p>{{ trans('auth.label.add.appointment.calendar') }} <a href="<?php echo $urlGoogle; ?>"><strong>Google</strong></a> {{ trans('auth.label.add.appointment.calendar.or') }} <a href="<?php echo $urlOutlook; ?>"><strong>Outlook</strong></a></p>

            <p>{{ trans('dash.atentamente') }}<br>
                {{ trans('dash.team.vet') }}</p>
        </td>
    </tr>

</table>
<br>
<br>
<br>