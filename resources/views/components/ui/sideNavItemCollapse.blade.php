@props([
    'route' => null
])

<li class="nav-item">
    <a class="nav-link" href={{ $route }}>{{ $slot }}</a>
</li>