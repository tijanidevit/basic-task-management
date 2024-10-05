@props(['type' => 'success', 'key' => 'success'])

@if(session($key))
<div class="alert alert-{{$type}}">
    {{ session($key) }}
</div>

@endif
