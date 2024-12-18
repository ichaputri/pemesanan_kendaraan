<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('dashboard') }}" class="app-brand-link">
            <span class="app-brand-text demo menu-text fw-bold ms-2">BookingCar</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm d-flex align-items-center justify-content-center"></i>
        </a>
    </div>
    <hr>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-smile"></i>
                <div class="text-truncate" data-i18n="Dashboards">Dashboards</div>
            </a>
        </li>

        <!-- Admin: All Menus -->
        @can('isAdmin')
            <li class="menu-item {{ request()->routeIs('users.index') ? 'active' : '' }}">
                <a href="{{ route('users.index') }}" class="menu-link">
                    <i class='menu-icon bx bxs-user-account'></i>
                    <div class="text-truncate" data-i18n="daftarUser">Daftar User</div>
                </a>
            </li>
        @endcan

        <!-- Kendaraan -->
        @canany(['isAdmin', 'isPengelola', 'isManager', 'isDriver', 'isDirektur'])
            <li class="menu-item {{ request()->routeIs('kendaraan.index') ? 'active' : '' }}">
                <a href="{{ route('kendaraan.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-car"></i>
                    <div class="text-truncate" data-i18n="Dashboards">Kendaraan</div>
                </a>
            </li>
        @endcanany

        <!-- Penyewaan -->
        @canany(['isAdmin', 'isPengelola', 'isDirektur', 'isManager'])
            <li class="menu-item {{ request()->routeIs('pemesanan.index') ? 'active' : '' }}">
                <a href="{{ route('pemesanan.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-notepad"></i>
                    <div class="text-truncate" data-i18n="Dashboards">Penyewaan</div>
                </a>
            </li>
        @endcanany

        <!-- Perawatan -->
        @canany(['isAdmin', 'isManager', 'isDirektur', 'isPengelola'])
            <li class="menu-item {{ request()->routeIs('perawatan.index') ? 'active' : '' }}">
                <a href="{{ route('perawatan.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-car-mechanic"></i>
                    <div class="text-truncate" data-i18n="Dashboards">Perawatan</div>
                </a>
            </li>
        @endcanany

        <!-- Approval -->
        @canany(['isAdmin', 'isManager', 'isDirektur'])
            <li class="menu-item {{ request()->routeIs('approval.index') ? 'active' : '' }}">
                <a href="{{ route('approval.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-calendar"></i>
                    <div class="text-truncate" data-i18n="Dashboards">Approval</div>
                </a>
            </li>
        @endcanany
    </ul>
</aside>
