@props([
    'href' => null
])

<li class="nav-item active">
    @php
        $path = parse_url($href, PHP_URL_PATH);
        $path = ltrim($path, '/');
    @endphp

    <a 
    class="nav-link {{ request()->is($path.'*') ? 'active' : '' }} " 
    href={{ $href }}
    >
    {{ $slot }}
    </a>
    
</li>