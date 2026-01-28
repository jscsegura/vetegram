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
            @if($subject == 'reminder')
            <h1>{{ trans('dash.reminder.24hours.title.only') }}</h1>
            @else
            <h1>{{ trans('dash.reminder.24hours.title') }}</h1>
            @endif
            <p>{{ $description }}</p>
            
            @if($id_appointment > 0)
            <p>{{ trans('auth.label.text.to.cancel.first') }} <a href="{{ url('appointment-reschedule/' . App\Models\User::encryptor('encrypt', $id_appointment)) }}"><strong>{{ trans('auth.label.text.here') }}</strong></a> {{ trans('auth.label.text.to.cancel.second') }} <a href="{{ url('appointment-cancel/' . App\Models\User::encryptor('encrypt', $id_appointment)) }}"><strong>{{ trans('auth.label.text.here') }}</strong></a>.</p>
            @endif

            <p>{{ trans('dash.atentamente') }}<br>
            {{ trans('dash.team.vet') }}</p>
        </td>
    </tr>

</table>
<br>
<br>
<br>