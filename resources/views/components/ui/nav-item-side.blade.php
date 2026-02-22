@props([
    'href' => null,
    'icon' => 'mdi mdi-home'
])

@php
    $path = parse_url($href, PHP_URL_PATH);
    $path = ltrim($path, '/');
@endphp

<li class="nav-item {{ request()->is($path.'*') ? 'active' : '' }}">
    <a class="nav-link {{ request()->is($path.'*') ? 'active' : '' }}" href="{{ $href }}">
        <span class="menu-title">{{ $slot }}</span>
        <i class="{{ $icon }} menu-icon"></i>
    </a>
</li>