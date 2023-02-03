<select {{ $attributes->merge(['class' => 'block w-full bg-white border border-gray-300 rounded-md shadow-sm px-3 focus:outline-none focus:ring-blue-600 focus:border-blue-600 sm:text-sm']) }}>
    {{ $slot }}
</select>
