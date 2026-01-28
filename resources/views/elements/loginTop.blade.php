<div id="logLogo" class="d-flex mb-auto align-items-center">
    <object data="{{asset('img/logo.svg')}}" style="height: 64px; color: blue"></object>
    @if (Config::get('app.locale') == 'en')
    <a href="{{ route('change.language', ['es'])}}" class="btn btn-outline-secondary btn-sm text-uppercase ms-auto">Es</a>
    @endif
    @if (Config::get('app.locale') == 'es')
    <a href="{{ route('change.language', ['en'])}}" class="btn btn-outline-secondary btn-sm text-uppercase ms-auto">En</a>
    @endif
</div>