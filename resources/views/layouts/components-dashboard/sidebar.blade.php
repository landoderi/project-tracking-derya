<style>
    /* ==============================
       1. Sidebar Base Style
       ============================== */
    .layout-menu {
        background-color: #110093 !important; /* Hijau Tua Keuangan */
        transition: all 0.3s ease;
    }

    /* ==============================
       2. Brand & Typography
       ============================== */
    .app-brand-text {
        color: #ffffff !important;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .layout-menu .menu-header-text {
        color: rgba(255, 255, 255, 0.6) !important; /* Semi transparan untuk header */
    }

    /* ==============================
       3. Link & Icons
       ============================== */
    .layout-menu .menu-link {
        color: #ffffff !important;
        transition: all 0.2s ease-in-out;
    }

    .layout-menu .menu-icon {
        color: #ffffff !important;
    }

    /* ==============================
       4. State: Active & Hover
       ============================== */
    .layout-menu .menu-item.active > .menu-link {
        background-color: rgba(255, 255, 255, 0.2) !important;
        color: #7053ff !important; /* Warna hijau muda terang saat aktif */
        font-weight: 600;
    }

    .layout-menu .menu-item:not(.active) .menu-link:hover {
        background-color: rgba(255, 255, 255, 0.1) !important;
        color: #ffffff !important;
    }

    /* ==============================
       5. Brand Icon SVG
       ============================== */
    .app-brand-logo svg {
        fill: #ffffff;
        filter: drop-shadow(0px 2px 4px rgba(0, 0, 0, 0.2));
    }
</style>

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <!-- Brand Section -->
    <div class="app-brand demo">
        <a href="{{ route('dashboard.index') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                    <path
                        d="M12 2C6.49 2 2 6.49 2 12s4.49 10 10 10 
                           10-4.49 10-10S17.51 2 12 2m1 14.91V18h-2v-1.08
                           c-2.34-.37-3-2-3-2.92h2c.01.14.16 1 2 1 
                           1.38 0 2-.58 2-1 0-.32 0-1-2-1 
                           -3.48 0-4-1.88-4-3 0-1.29 1.03-2.58 3-2.91V6h2v1.12
                           c1.73.41 2.4 1.85 2.4 2.88h-1l-1 .02
                           C13.39 9.64 13.18 9 12 9c-1.3 0-2 .52-2 1 
                           0 .37 0 1 2 1 3.48 0 4 1.88 4 3 
                           0 1.29-1.03 2.58-3 2.91" />
                </svg>
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2">Tracking</span>
        </a>

        <a href="javascript:void(0);" 
           class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <!-- Menu Items -->
    <ul class="menu-inner py-1">
        <!-- Utama -->

        <li class="menu-item {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
            <a href="{{ route('dashboard.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>Dashboard</div>
            </a>
        </li>


       @if(auth()->user()->role === 'admin')
        <li class="menu-item {{ request()->routeIs('dashboard.users.*') ? 'active' : '' }}">
            <a href="{{ route('dashboard.users.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div>Pengguna</div>
            </a>
        </li>
        @endif
        <li class="menu-item {{ request()->routeIs('dashboard.kategori*') ? 'active' : '' }}">
            <a href="{{ route('dashboard.kategori.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-spreadsheet"></i>
                <div>Kategori Keuangan</div>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('dashboard.akun*') ? 'active' : '' }}">
            <a href="{{ route('dashboard.akun.index') }}" class="menu-link">
                <i><svg  xmlns="http://www.w3.org/2000/svg" width="24" height="24"  
fill="currentColor" viewBox="0 0 24 24" >
<!--Boxicons v3.0.8 https://boxicons.com | License  https://docs.boxicons.com/free-->
<path d="M12 12c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5m0-8c1.65 0 3 1.35 3 3s-1.35 3-3 3-3-1.35-3-3 1.35-3 3-3M4 22h16c.55 0 1-.45 1-1v-1c0-3.86-3.14-7-7-7h-4c-3.86 0-7 3.14-7 7v1c0 .55.45 1 1 1m6-7h4c2.76 0 5 2.24 5 5H5c0-2.76 2.24-5 5-5"></path>
</svg></i>
                <div>Akun Keuangan</div>
            </a>
        </li>
                <li class="menu-item {{ request()->routeIs('dashboard.transaksi*') ? 'active' : '' }}">
            <a href="{{ route('dashboard.transaksi.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-spreadsheet"></i>
                <div>Transaksi</div>
            </a>
        </li>
    </ul>
</aside>
