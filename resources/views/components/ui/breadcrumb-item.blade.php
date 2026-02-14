@props([
    'href' => '#'
])

<li class="breadcrumb-item">
    <a href="{{ $href }}">{{ $slot }}</a>
</li>
