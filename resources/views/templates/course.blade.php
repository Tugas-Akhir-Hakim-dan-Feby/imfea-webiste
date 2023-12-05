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
                                    @foreach ($topic->courses as $listCourse)
                                        <li>
                                            <x-link route="web.training.course.slug" :parameter="[
                                                'trainingSlug' => $training->slug,
                                                'courseSlug' => $listCourse->slug,
                                            ]"
                                                color="{{ $listCourse->courseVisitor ? 'success' : '' }}"
                                                class="d-flex justify-content-between {{ !$listCourse->courseVisitor ? 'disable-link' : '' }}">
                                                {{ $listCourse->title }}
                                                @if ($listCourse->courseVisitor)
                                                    <span class="badge bg-success text-sm">Selesai</span>
                                                @endif
                                            </x-link>
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
                    <button class="button-menu-mobile open-left">
                        <i class="mdi mdi-menu"></i>
                    </button>
                </div>

                <div class="container-fluid">
                    <x-header-page :title="$course->title" :options="[
                        ['link' => route('web.home.index'), 'text' => 'Dashboard'],
                        ['link' => route('web.training.show', $training), 'text' => $training->title],
                    ]" />

                    @if (session('dangerMessage'))
                        <x-alert class="mb-3" color="danger" dismissible>
                            {{ session('dangerMessage') }}
                        </x-alert>
                    @endif
                    @if (session('successMessage'))
                        <x-alert class="mb-3" color="success" dismissible>
                            {{ session('successMessage') }}
                        </x-alert>
                    @endif

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
                            <div class="card card-rounded">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h4>Apakah sudah paham?</h4>
                                        <div>
                                            @if ($nextCourse)
                                                <form
                                                    action="{{ route('web.training.course.slug.process', [
                                                        'trainingSlug' => $training->slug,
                                                        'courseSlug' => $nextCourse->slug,
                                                    ]) }}"
                                                    method="post">
                                                    @csrf
                                                    <input type="hidden" name="course_id"
                                                        value="{{ $course->id }}" />
                                                    <x-button label="Ya, Saya Sudah Paham" color="primary"
                                                        size="sm" type="submit" />
                                                </form>
                                            @else
                                                <x-button label="Selesai" class="text-white me-2" color="primary"
                                                    size="sm" />
                                            @endif
                                        </div>
                                    </div>
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
