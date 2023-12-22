<div class="leftside-menu leftside-menu-detached">

    <div class="leftbar-user">
    </div>

    <ul class="side-nav">

        <li class="side-nav-title side-nav-item">Navigation</li>

        <li class="side-nav-item">
            <x-link route="web.home.index" class="side-nav-link">
                <x-icon name="uil-home-alt" />
                <span> Dashboard </span>
            </x-link>
        </li>

        <li class="side-nav-item">
            <x-link route="web.webinar.index" class="side-nav-link">
                <x-icon name="mdi mdi-calendar-month" />
                <span> Webinar </span>
            </x-link>
        </li>

        <li class="side-nav-item">
            <x-link route="web.news.index" class="side-nav-link">
                <x-icon name="dripicons-article" />
                <span> Berita </span>
            </x-link>
        </li>

        <li class="side-nav-item">
            <x-link route="web.training.index" class="side-nav-link">
                <x-icon name="uil-clipboard-alt" />
                <span> Pelatihan </span>
            </x-link>
        </li>

        @if (auth()->user()->hasRole(App\Models\Role::ADMIN_APP))
            <li class="side-nav-item">
                <x-link route="web.user.admin-app.index" class="side-nav-link">
                    <x-icon name="dripicons-user" />
                    <span> Pengguna </span>
                </x-link>
            </li>
        @endif

    </ul>

    <div class="clearfix"></div>

</div>
