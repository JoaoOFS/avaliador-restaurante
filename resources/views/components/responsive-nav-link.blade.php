@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full pl-3 pr-4 py-2 border-l-4 border-[#D4AF37] text-left text-base font-medium text-[#D4AF37] bg-black/5 focus:outline-none focus:text-[#D4AF37] focus:bg-black/10 focus:border-[#D4AF37] transition duration-150 ease-in-out'
            : 'block w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-left text-base font-medium text-white hover:text-[#D4AF37] hover:bg-black/5 hover:border-[#D4AF37] focus:outline-none focus:text-[#D4AF37] focus:bg-black/10 focus:border-[#D4AF37] transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
