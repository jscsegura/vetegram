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
            <h1>{{ trans('auth.label.cancel.appointment.title') }}</h1>
            <p>{{ trans('auth.register.complete.hello') }} <strong>{{ $name }}</strong></p>
            <p>{{ trans('auth.label.cancel.appointment.intro', ['date' => $date, 'doctor' => $doctor]) }}</p>
            <p>{{ trans('auth.label.cancel.link') }} <a href="{{ url('book/hours/' . App\Models\User::encryptor('encrypt', $iddoctor)) }}"><strong>{{ trans('auth.label.text.here') }}</strong></a></p>
            <p>{{ trans('auth.label.cancel.appointment.conclusion') }}</p>
            
            <p>{{ trans('dash.atentamente') }}<br>
            {{ trans('dash.team.vet') }}</p>
        </td>
    </tr>

</table>
<br>
<br>
<br>