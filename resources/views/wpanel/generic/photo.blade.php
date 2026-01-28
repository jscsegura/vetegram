@if((isset($name)) && ($name != ''))
<input type="file" name="{{$name}}" id="{{$name}}" @if(isset($obligatory)) class="requerido" accept="image/png, image/jpeg, image/jpg" @endif>
@else
<input type="file" name="photo" id="photo" @if(isset($obligatory)) class="requerido" accept="image/png, image/jpeg, image/jpg" @endif>
@endif