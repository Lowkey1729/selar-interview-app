@props([
'label' => null,
'labelClass' => "",
'disabled' => false,
'name' => ""
])
<div x-data>
    @if($label)
        <x-form.label for="{{$label}}"
                      class="{{ $labelClass }}">{{ \Illuminate\Support\Str::ucfirst($label) }}</x-form.label>
    @endif
    <div class="mt-1 relative rounded-md shadow-sm">
        <div class="absolute inset-y-0 left-0 pl-1 flex items-center pointer-events-none">
            <span class="text-gray-500 sm:text-sm"> ₦ </span>
        </div>
        <input type="date" name="{{$name ?? ''}}"
               {{ $attributes->merge(['class' => 'focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md']) }}
               @if ($disabled === true) disabled="true" @endif
        >
    </div>
</div>
