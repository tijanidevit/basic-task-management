@props(['type' => 'danger', 'record'])

@error($record)
<small class="text-{{$type}}">
    {{ $message }}
</small>

@enderror
