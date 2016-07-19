@if(Session::has('alert-class'))
{{--*/ $msgvar = Session::get('alert-class') /*--}}
@else
{{--*/ $msgvar = 'alert-success' /*--}}
@endif

@if(Session::has('flash_message'))
<div class="alert {{$msgvar}}">
    {{ Session::get('flash_message') }}
</div>
@endif