@if($enabled == 1)
    <a data="{{ $id }}" data-action="toggle-pro">
        <img src="{{ asset('img/wpanel/enabled.png') }}">
    </a>
@else
    <a data="{{ $id }}" data-action="toggle-pro">
        <img src="{{ asset('img/wpanel/disabled.png') }}">
    </a>
@endif