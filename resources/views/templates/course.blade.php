@include('templates.head')

<style>
    .card-rounded {
        border-radius: 15px;
    }
</style>

<body class="loading"
    data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
    <div class="wrapper">
        <div class="leftside-menu">

            <a href="index.html" class="logo text-center logo-light">
                <span class="logo-lg">
                    <img src="{{ asset('assets/logo/logo-imfea.png') }}" alt="" height="35">
                </span>
                <span class="logo-sm">
                    <img src="{{ asset('assets/logo/logo-imfea.png') }}" alt="" height="35">
                </span>
            </a>

            <a href="index.html" class="logo text-center logo-dark">
                <span class="logo-lg">
                    <img src="{{ asset('assets/logo/logo-imfea.png') }}" alt="" height="35">
                </span>
                <span class="logo-sm">
                    <img src="{{ asset('assets/logo/logo-imfea.png') }}" alt="" height="35">
                </span>
            </a>

            <div class="h-100" id="leftside-menu-container" data-simplebar="">

                <ul class="side-nav">

                    @foreach ($training->topics as $topic)
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebar{{ $topic->slug }}" aria-expanded="false"
                                aria-controls="sidebar{{ $topic->slug }}" class="side-nav-link">
                                <span> {{ $topic->title }} </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebar{{ $topic->slug }}">
                                <ul class="side-nav-second-level">
                                    @foreach ($topic->courses as $course)
                                        <li>
                                            <x-link route="web.training.course.slug" :parameter="[
                                                'trainingSlug' => $training->slug,
                                                'courseSlug' => $course->slug,
                                            ]"
                                                :label="$course->title" />
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    @endforeach

                </ul>

                <div class="clearfix"></div>

            </div>
        </div>

        <div class="content-page">
            <div class="content">
                <div class="navbar-custom">
                    <ul class="list-unstyled topbar-menu float-end mb-0">
                        <li class="dropdown notification-list">
                            <a class="nav-link nav-user arrow-none me-0" href="#" role="button">
                                {{-- <span class="account-user-avatar">
                                    <img src="assets/images/users/avatar-1.jpg" alt="user-image" class="rounded-circle">
                                </span>
                                <span>
                                    <span class="account-user-name">Soeng Souy</span>
                                    <span class="account-position">Founder</span>
                                </span> --}}
                            </a>
                        </li>

                    </ul>
                    <button class="button-menu-mobile open-left">
                        <i class="mdi mdi-menu"></i>
                    </button>
                </div>

                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <h4 class="page-title">{{ $course->title }}</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card card-rounded">
                                <div class="card-img-top">
                                    <div class="ratio ratio-16x9">
                                        <iframe class="card-rounded" src="{{ $course->link_video }}"
                                            title="{{ $course->title }}" allowfullscreen
                                            style="border-bottom-left-radius: 0px;
                                            border-bottom-right-radius: 0px;"></iframe>
                                    </div>
                                </div>
                                <div class="card-body">
                                    {!! $course->content !!}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="text-center">
                        <script>
                            document.write(new Date().getFullYear())
                        </script> © Hyper - Coderthemes.com
                    </div>
                </div>
            </footer>

        </div>
    </div>

    @stack('modal')

    @include('templates.foot')

</body>

</html>
