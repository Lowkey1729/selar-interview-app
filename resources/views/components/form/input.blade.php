@props([
    'disabled' => false,
    'content' => null
])
<input x-data
       @if($content === "numbers") x-on:keyup="$event.target.value = $event.target.value.replace(/[^0-9]/g, '')" @endif
       @if($content === "decimal") x-on:keyup="$event.target.value = $event.target.value.replace(/[^0-9\.]/g, '')" @endif
    {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge(['class' => 'block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md']) !!}>
