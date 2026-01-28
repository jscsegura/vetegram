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
            <h1>{{ trans('dash.label.active.pro.title') }}</h1>
            <p>{{ trans('dash.active.pro.hello') }} <strong>{{ $name }}</strong></p>
            <p>{{ trans('dash.active.pro.intro') }}</p>
            <p>{{ trans('dash.active.pro.intro2') }}</p>
            <p>{{ trans('dash.active.pro.intro3') }}</p>

            @php $weblang = \App::getLocale(); @endphp

            <ul class="mt-3 px-0 mb-0">
                @foreach ($pros as $pro)
                <li>{{ $pro['title_' . $weblang] }}</li>    
                @endforeach
            </ul>
            
            <p>{{ trans('dash.active.pro.conclusion') }}<a href="mailto:hola@vetegram.com"><strong>hola@vetegram.com</strong></a></p>
            
            <p>{{ trans('dash.atentamente') }}<br>
            {{ trans('dash.team.vet') }}</p>
        </td>
    </tr>

</table>
<br>
<br>
<br>