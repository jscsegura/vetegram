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
            <h1>{{ $subject }}</h1>
            <p>{{ $description }}</p>

            <p>{{ trans('dash.label.view.attach') }} <a href="{{ route('pet.viewattach', $id) }}"><strong>{{ trans('auth.label.text.here') }}</strong></a></p>
            
            <p>{{ trans('dash.attach.complete.link.plain') }} {{ route('pet.viewattach', $id) }}</p>

            <p>{{ trans('dash.atentamente') }}<br>
                {{ trans('dash.team.vet') }}</p>
        </td>
    </tr>

</table>
<br>
<br>
<br>