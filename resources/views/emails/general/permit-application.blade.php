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
            <h1>{{ trans('dash.label.permit.application') }}</h1>
            <p>{{ trans('auth.register.complete.hello') }} <strong>{{ $name }}</strong></p>
            <p>{{ trans('dash.label.permit.intro', ['nameVet' => $vetName]) }}</p>

            <p>{{ trans('dash.label.permit.link') }}:</p>
            <p><a href="{{ url('pet/permit-access/' . $code) }}" class="btn" style="color: #fff !important;">{{ trans('auth.label.text.here') }}</a></p>

            <p>{{ trans('dash.label.permit.conclusion') }} <a href="mailto:hola@vetegram.com">hola@vetegram.com</a></p>

            <p>{{ trans('dash.atentamente') }}<br>
            {{ trans('dash.team.vet') }}</p>
        </td>
    </tr>

</table>
<br>
<br>
<br>