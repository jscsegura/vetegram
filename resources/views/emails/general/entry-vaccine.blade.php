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
            <h1>{{ trans('dash.controller.subject.email.entry.vaccine') }}</h1>
            <p>{{ trans('dash.email.intro.entry.vaccine', ['namepet' => $namepet]) }}</p>

            <p>{{ trans('dash.email.link.entry.vaccine') }} <a href="{{ url('entry-vaccine/' . App\Models\User::encryptor('encrypt', $petId)) }}"><strong>{{ trans('auth.label.text.here') }}</strong></a>.</p>

            <p>{{ trans('dash.atentamente') }}<br>
                {{ trans('dash.team.vet') }}</p>
        </td>
    </tr>

</table>
<br>
<br>
<br>