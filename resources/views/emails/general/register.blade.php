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
            <h1>{{ trans('auth.register.email.verified') }}</h1>
            <p>{{ trans('auth.register.complete.hello') }} <strong>{{ $name }}</strong></p>
            <p>{{ trans('auth.register.complete.intro') }}</p>
            <a href="{{ route('register.confirm', [$token]) }}" class="btn btn-primary">{{ trans('auth.register.btn.complete') }}</a>
            <p>{{ trans('auth.register.complete.description') }}</p>
            @if(isset($newPass))
            <p>{{ trans('auth.register.complete.password') }}{{ $newPass }}</p>
            @endif
            <p>{{ trans('auth.register.complete.link.plain') }} {{ route('register.confirm', [$token]) }}</p>

            <p>{{ trans('dash.atentamente') }}<br>
                {{ trans('dash.team.vet') }}</p>
        </td>
    </tr>

</table>
<br>
<br>
<br>