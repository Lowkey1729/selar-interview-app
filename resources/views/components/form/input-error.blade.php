@props(['for'])
@error($for)
<p {{ $attributes->merge(['class' => 'text-sm mt-2 text-red-600']) }}>{{ $message }}</p>
@enderror
