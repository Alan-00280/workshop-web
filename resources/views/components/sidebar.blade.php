<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        {{-- Profile --}}
        <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
                <div class="nav-profile-image">
                    <img src="assets/images/faces/face5.jpg" alt="profile" />
                    <span class="login-status online"></span>
                    <!--change to offline or busy as needed-->
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2">Lwufy Alan</span>
                    <span class="text-secondary text-small">Bangga HIMTI</span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
        </li>
        {{-- End Profile --}}

        {{-- Navigations --}}
        <x-ui.nav-item-side href="{{ route('dashboard') }}">Dashboard</x-ui.nav-item-side>

        <x-ui.collapseSideNavItem
            icon="fa-classic fa-solid fa-book"
            nav_name="Buku"
        >
            <x-ui.sideNavItemCollapse route="{{ route('book') }}" >Koleksi Buku</x-ui.sideNavItemCollapse>
            <x-ui.sideNavItemCollapse route="{{ route('book-categories') }}" >Kategori Buku</x-ui.sideNavItemCollapse>
        </x-ui.collapseSideNavItem>

        {{-- End Navigations --}}

        {{-- <x-ui.collapseSideNavItem icon="" nav_name="Coba" >
            <x-ui.sideNavItemCollapse route="{{ '/' }}" >Dashboard</x-ui.sideNavItemCollapse>
        </x-ui.collapseSideNavItem> --}}

    </ul>
</nav>