@if($enabled == 0)
    <a data="{{ $id }}" onclick="activeRow(this);">
        <img width="25px" src="{{ asset('img/wpanel/deactivated.png') }}">
    </a>
@else
    <a data="{{ $id }}">
        <img width="25px" src="{{ asset('img/wpanel/active.png') }}">
    </a>
@endif