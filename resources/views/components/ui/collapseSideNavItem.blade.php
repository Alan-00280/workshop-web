@props([
    'nav_name' => null,
    'icon' => 'mdi mdi-crosshairs-gps',
])

@php
    $key_collapse = 'coll-' . $nav_name
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

 <script>

    const ul_collapsabel =document.querySelectorAll('.slot-ul-collapsable')
    ul_collapsabel.forEach(ul => {

        const li = ul.querySelectorAll('li')
        li.forEach(i => {
            const i_a = i.querySelector('a')

            if(i_a.classList.contains('active')) {

                const navItem = ul.closest('.nav-item');
                if (navItem) {
                    navItem.classList.add('active')

                    const a_collapsable = navItem.querySelector('.a-collapsable');
                    if (a_collapsable) {
                        a_collapsable.setAttribute("aria-expanded", "true");
                        a_collapsable.classList.add('active')
                    }

                    const div_collapsable = navItem.querySelector('.div-collapsable')
                    if (div_collapsable) {
                        div_collapsable.classList.add('show')
                    }
                }


            }

    })

    })
    
</script>