<div class="navbar-custom topnav-navbar">
    <div class="container-fluid">

        <a href="{{ route('web.home.index') }}" class="topnav-logo">
            <span class="topnav-logo-lg">
                <img src="{{ asset('assets/images/logo-header.png') }}" alt="" height="40">
            </span>
            <span class="topnav-logo-sm">
                <img src="{{ asset('assets/images/logo-header.png') }}" alt="" height="40">
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
            @if (!auth()->user()->membership)
                <li class="notification-list pt-1">
                    <x-button label="Daftar Member" size="sm" route="web.member.register.index" class="mt-2" />
                </li>
            @endif
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
                        <h6 class="text-overflow m-0">Welcome !</h6>
                    </div>

                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="mdi mdi-account-circle me-1"></i>
                        <span>My Account</span>
                    </a>

                    <x-link class="dropdown-item notify-item" route="web.auth.logout">
                        <x-icon name="mdi mdi-logout me-1" />
                        <span>Logout</span>
                    </x-link>
                </div>
            </li>
        </ul>
    </div>
</div>
