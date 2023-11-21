<div class="navbar-custom topnav-navbar">
    <div class="container-fluid">

        <a href="{{ route('web.home.index') }}" class="topnav-logo">
            <span class="topnav-logo-lg">
                <img src="{{ asset('assets/logo/logo-text.png') }}" alt="" height="35">
            </span>
            <span class="topnav-logo-sm">
                <img src="{{ asset('assets/logo/logo-text.png') }}" alt="" height="35">
            </span>
        </a>

        <a class="button-menu-mobile disable-btn">
            <div class="lines">
                <span style="background-color: black"></span>
                <span style="background-color: black"></span>
                <span style="background-color: black"></span>
            </div>
        </a>

        <ul class="list-unstyled topbar-menu float-end mb-0">
            <li class="notification-list">
                <x-link class="nav-link end-bar-toggle" route="web.invoice.index">
                    <x-icon name="dripicons-cart" class="noti-icon" />
                </x-link>
            </li>
            <li class="notification-list dropdown">
                <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown"
                    id="topbar-userdrop" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <span class="account-user-avatar">
                        <img src="https://ui-avatars.com/api/?background=random&size=25&rounded=true&length=2&name={{ auth()->user()->name }}"
                            alt="user-image" class="rounded-circle">
                    </span>
                    <span>
                        <span class="account-user-name">{{ auth()->user()->name }}</span>
                        <span class="account-position">{{ auth()->user()->roles[0]->name }}</span>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown"
                    aria-labelledby="topbar-userdrop">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Selamat Datang !</h6>
                    </div>

                    <x-link route="web.profile.index" class="dropdown-item notify-item">
                        <x-icon name="mdi mdi-account-circle me-1" />
                        <span>Profil Saya</span>
                    </x-link>

                    <x-link class="dropdown-item notify-item" route="web.auth.logout">
                        <x-icon name="mdi mdi-logout me-1" />
                        <span>Logout</span>
                    </x-link>
                </div>
            </li>
        </ul>
    </div>
</div>
