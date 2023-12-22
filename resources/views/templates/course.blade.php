@php
    use Carbon\Carbon;
@endphp
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
                    @if (session('dangerMessage'))
                        <x-alert class="mb-3  mt-3" color="danger" dismissible>
                            {{ session('dangerMessage') }}
                        </x-alert>
                    @endif
                    @if (session('successMessage'))
                        <x-alert class="mb-3  mt-3" color="success" dismissible>
                            {{ session('successMessage') }}
                        </x-alert>
                    @endif

                    @if (!$isExam)
                        <div class="row mt-3">
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
                                    <div class="card-header">
                                        <h3>{{ $course->title }}</h3>
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
                                                    <form
                                                        action="{{ route('web.training.course.slug.finished', [
                                                            'trainingSlug' => $training->slug,
                                                        ]) }}"
                                                        method="post">
                                                        @csrf
                                                        <input type="hidden" name="course_id"
                                                            value="{{ $course->id }}" />
                                                        <x-button label="Selesai" color="primary" size="sm"
                                                            type="submit" />
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="card mt-3">
                            <div class="card-header">
                                <h3>Aturan</h3>
                            </div>
                            <div class="card-body">
                                <p>
                                    Ujian Akhir bertujuan untuk menguji pengetahuan Anda tentang semua materi yang telah
                                    dipelajari di kelas ini.
                                </p>

                                <p>
                                    Terdapat 20 pertanyaan yang harus dikerjakan dalam kuis ini. Beberapa ketentuannya
                                    sebagai berikut:
                                </p>

                                <ul>
                                    <li>Syarat nilai kelulusan : 70%</li>
                                    <li>Durasi ujian : 60 menit</li>
                                </ul>

                                <p>Apabila tidak memenuhi syarat kelulusan, maka Anda harus menunggu selama 60 menit
                                    untuk
                                    mengulang pengerjaan kuis kembali. Manfaatkan waktu tunggu tersebut untuk
                                    mempelajari
                                    kembali materi sebelumnya, ya.</p>

                                @if (!$training->trainingParticipant->check_out_exam)
                                    <p>Selamat Mengerjakan!</p>
                                    <x-button size="sm" color="primary" route="web.training.course.slug.exam"
                                        :parameter="$training->slug">Mulai Quiz</x-button>
                                @else
                                    @if (!$training->trainingParticipant->grade)
                                        <x-alert color="info" class="mb-3">Harap tunggu penilaian dari
                                            pemateri!</x-alert>
                                    @endif
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Tanggal</th>
                                                    <th>Persentase</th>
                                                    <th>Hasil</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th>{{ Carbon::createFromFormat('Y-m-d H:i:s', $training->trainingParticipant->check_out_exam)->isoFormat('DD MMM YYYY H:mm') }}
                                                    </th>
                                                    <th>
                                                        @if ($training->trainingParticipant->grade)
                                                        @else
                                                            -
                                                        @endif
                                                    </th>
                                                    <th>
                                                        @if ($training->trainingParticipant->grade)
                                                        @else
                                                            -
                                                        @endif
                                                    </th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="text-center">
                        <script>
                            document.write(new Date().getFullYear())
                        </script> © Hakim Asrori - imfea.net
                    </div>
                </div>
            </footer>

        </div>
    </div>

    @stack('modal')

    @include('templates.foot')

</body>

</html>
