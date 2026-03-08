@props([
    'nav_name' => null,
    'icon' => 'mdi mdi-crosshairs-gps',
])

@php
    $key_collapse = 'coll-' . strtolower(str_replace(' ', '-', $nav_name))
@endphp

<li class="nav-item">
    <a class="nav-link a-collapsable" data-bs-toggle="collapse" href="#{{ $key_collapse }}" aria-expanded="false"
        aria-controls="{{ $key_collapse }}" >
        <span class="menu-title">{{ $nav_name ?? '[null]' }}</span>
        <i class="menu-arrow"></i>
        <i class="{{ $icon }}"></i>
    </a>
    <div class="collapse div-collapsable" id="{{ $key_collapse }}">
        <ul class="nav flex-column sub-menu slot-ul-collapsable">
            {{ $slot }}
        </ul>
    </div>
</li>