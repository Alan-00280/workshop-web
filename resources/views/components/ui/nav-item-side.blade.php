@props([
    'href' => null,
    'icon' => 'mdi mdi-home'
])

<li class="nav-item">
    <a class="nav-link" href="{{ $href }}">
        <span class="menu-title">{{ $slot }}</span>
        <i class="{{ $icon }} menu-icon"></i>
    </a>
</li>