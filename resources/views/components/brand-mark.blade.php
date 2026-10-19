@props(['class' => 'h-10 w-10'])

<span {{ $attributes->merge(['class' => $class]) }} aria-hidden="true">
    <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-full w-full">
        <path
            d="M24 3.5 40.5 9.2v11.6c0 10.6-6.2 17.8-16.5 23.2C13.7 38.6 7.5 31.4 7.5 20.8V9.2L24 3.5Z"
            stroke="currentColor"
            stroke-width="1.8"
            stroke-linejoin="round"
        />
        <path d="M24 13.5v13" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
        <path d="M18 19h12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
        <path d="M17.5 33.5c2-3.2 4.2-4.8 6.5-4.8s4.5 1.6 6.5 4.8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
    </svg>
</span>
