@props(['name', 'class' => 'h-5 w-5'])

@switch($name)
    @case('facebook')
        <svg viewBox="0 0 24 24" aria-hidden="true" class="{{ $class }}" fill="#1877F2">
            <path d="M24 12.073C24 5.405 18.627 0 12 0S0 5.405 0 12.073C0 18.1 4.388 23.094 10.125 24v-8.437H7.078v-3.49h3.047V9.41c0-3.025 1.792-4.697 4.533-4.697 1.312 0 2.686.236 2.686.236v2.97h-1.513c-1.491 0-1.956.93-1.956 1.886v2.267h3.328l-.532 3.49h-2.796V24C19.612 23.094 24 18.1 24 12.073z"/>
        </svg>
        @break

    @case('x')
        <svg viewBox="0 0 24 24" aria-hidden="true" class="{{ $class }}" fill="#FFFFFF">
            <path d="M18.244 2H21.5l-7.116 8.134L22.75 22h-6.555l-5.134-6.716L5.186 22H1.928l7.612-8.7L1.25 2h6.722l4.64 6.136L18.244 2Zm-1.141 17.966h1.804L6.99 3.927H5.055l12.048 16.04Z"/>
        </svg>
        @break

    @case('instagram')
        <svg viewBox="0 0 24 24" aria-hidden="true" class="{{ $class }}">
            <defs>
                <linearGradient id="ig-gradient" x1="0%" y1="100%" x2="100%" y2="0%">
                    <stop offset="0%" stop-color="#F58529"/>
                    <stop offset="30%" stop-color="#FEDA77"/>
                    <stop offset="50%" stop-color="#DD2A7B"/>
                    <stop offset="70%" stop-color="#8134AF"/>
                    <stop offset="100%" stop-color="#515BD4"/>
                </linearGradient>
            </defs>
            <rect x="2" y="2" width="20" height="20" rx="5.5" ry="5.5" fill="url(#ig-gradient)"/>
            <rect x="6.2" y="6.2" width="11.6" height="11.6" rx="3.2" ry="3.2" fill="none" stroke="#FFFFFF" stroke-width="1.8"/>
            <circle cx="12" cy="12" r="2.8" fill="none" stroke="#FFFFFF" stroke-width="1.8"/>
            <circle cx="16.35" cy="7.65" r="1.15" fill="#FFFFFF"/>
        </svg>
        @break

    @case('tiktok')
        <svg viewBox="0 0 24 24" aria-hidden="true" class="{{ $class }}">
            <path fill="#25F4EE" d="M10.2 8.7v6.2a3 3 0 1 1-2.2-2.9V9.3a5.7 5.7 0 1 0 4.9 5.6V8.2c1 .8 2.3 1.3 3.6 1.4V6.9a3.8 3.8 0 0 1-2.2-1.1 3.9 3.9 0 0 1-1.1-2.1H10.2v5z" transform="translate(-.7 .6)"/>
            <path fill="#FE2C5D" d="M10.2 8.7v6.2a3 3 0 1 1-2.2-2.9V9.3a5.7 5.7 0 1 0 4.9 5.6V8.2c1 .8 2.3 1.3 3.6 1.4V6.9a3.8 3.8 0 0 1-2.2-1.1 3.9 3.9 0 0 1-1.1-2.1H10.2v5z" transform="translate(.7 -.6)"/>
            <path fill="#FFFFFF" d="M10.2 8.7v6.2a3 3 0 1 1-2.2-2.9V9.3a5.7 5.7 0 1 0 4.9 5.6V8.2c1 .8 2.3 1.3 3.6 1.4V6.9a3.8 3.8 0 0 1-2.2-1.1 3.9 3.9 0 0 1-1.1-2.1H10.2v5z"/>
        </svg>
        @break
@endswitch
