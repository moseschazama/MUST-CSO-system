@props(['name' => 'star', 'class' => 'h-5 w-5', 'title' => null])

<svg
    xmlns="http://www.w3.org/2000/svg"
    viewBox="0 0 24 24"
    fill="none"
    stroke="currentColor"
    stroke-width="1.75"
    stroke-linecap="round"
    stroke-linejoin="round"
    @if ($title) role="img" aria-label="{{ $title }}" @else aria-hidden="true" @endif
    {{ $attributes->merge(['class' => $class]) }}
>
    {!! \App\Support\Icons::get($name) !!}
</svg>
