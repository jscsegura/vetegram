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
            <h1>{{ trans('auth.reset.password.subject') }}</h1>
            <p>{{ trans('auth.reset.password.hello') }}</p>
            <p>{{ trans('auth.reset.password.intro') }}</p>
            <a href="{{ route('reset.passsword', [$token, $email]) }}" class="btn btn-primary">{{ trans('auth.reset.password.btn.reset') }}</a>
            <p>{{ trans('auth.reset.password.expire', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]) }}</p>
            <p>{{ trans('auth.reset.password.description') }}</p>
            <p>{{ trans('auth.reset.password.link.plain') }} {{ route('reset.passsword', [$token, $email]) }}</p>

            <p>{{ trans('dash.atentamente') }}<br>
                {{ trans('dash.team.vet') }}</p>
        </td>
    </tr>

</table>
<br>
<br>
<br>