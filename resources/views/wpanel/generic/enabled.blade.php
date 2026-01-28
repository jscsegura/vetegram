@if($enabled == 1)
    <a data="{{ $id }}" onclick="enabledRow(this);">
        <img src="{{ asset('img/wpanel/enabled.png') }}">
    </a>
@else
    <a data="{{ $id }}" onclick="enabledRow(this);">
        <img src="{{ asset('img/wpanel/disabled.png') }}">
    </a>
@endif