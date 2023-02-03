<textarea
    x-data="{
        resize() {
            $el.style.height = 'auto'
            $el.style.height = `${$el.scrollHeight}px`
        }
    }"
    x-init="$nextTick(() => { resize() })"
    x-on:input="resize"
    {{ $attributes->merge(['class' => 'overflow-y-hidden box-border shadow-sm block w-full sm:text-sm border border-gray-300 rounded-md']) }}>{{ $slot }}</textarea>

