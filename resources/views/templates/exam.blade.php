@include('templates.head')

<style>
    .sidebar-enable .leftside-menu ul {
        padding-right: 0.88rem;
        padding-left: 1rem;
    }

    .sidebar-enable .leftside-menu ul li {
        width: 100%;
    }

    .leftside-menu ul {
        flex-wrap: wrap;
        padding-right: 2rem;
        display: flex;
        justify-content: space-between;
        list-style-type: none;
    }

    .leftside-menu ul li {
        padding: 10px;
        margin-bottom: 20px;
        margin-right: 5px;
        width: 25%;
        border: 1px solid white;
        color: white;
        text-align: center;
        /* cursor: pointer; */
    }

    .leftside-menu ul li.active {
        /* border: 1px solid #0acf97;
    background-color: #0acf97; */
        border: 1px solid #727cf5;
        background-color: #727cf5;
    }

    .card-rounded {
        border-radius: 15px;
    }

    .card-body ul {
        list-style-type: none;
        padding: 0;
    }

    .card-body ul li {
        margin-bottom: 1rem;
        padding: 10px;
        padding-inline: 20px;
        border: 1px solid #fafbfe;
        border-radius: 20px;
    }

    .card-body ul li:hover {
        background-color: #fafbfe;
    }

    .card-body ul li input {
        cursor: pointer;
        height: 20px;
        width: 20px;
    }
</style>
{{-- @dd(url()) --}}

<body class="loading"
    data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
    <div class="wrapper">

        <div class="leftside-menu">

            <a href="#" class="logo text-center logo-light">
                <span class="logo-lg">
                    <img src="{{ asset('assets/logo/logo-imfea.png') }}" alt="" height="35">
                </span>
                <span class="logo-sm">
                    <img src="{{ asset('assets/logo/logo.png') }}" alt="" height="35">
                </span>
            </a>

            <a href="#" class="logo text-center logo-dark">
                <span class="logo-lg">
                    <img src="{{ asset('assets/logo/logo-imfea.png') }}" alt="" height="35">
                </span>
                <span class="logo-sm">
                    <img src="{{ asset('assets/logo/logo.png') }}" alt="" height="35">
                </span>
            </a>

            <div class="h-100" id="leftside-menu-container" data-simplebar="">

                <ul>
                    @for ($i = 1; $i <= $exams->total(); $i++)
                        <li>
                            {{ $i }}
                        </li>
                    @endfor
                </ul>
                <div class="clearfix"></div>

            </div>
        </div>

        <form
            action="{{ route('web.training.course.slug.exam.answer', ['trainingSlug' => $training->slug, 'page' => $exams->currentPage() + 1]) }}"
            method="post" id="mainform" class="needs-validation" novalidate>
            @csrf
            <div class="content-page">
                <div class="content">
                    <div class="navbar-custom d-flex align-items-center justify-content-between">
                        <button class="button-menu-mobile open-left">
                            <i class="mdi mdi-menu"></i>
                        </button>

                        <ul class="list-unstyled topbar-menu mb-0 me-3">
                            <li class="notification-list">Durasi : <span id="timer"></span></li>
                        </ul>
                    </div>
                    @foreach ($exams as $key => $exam)
                        <input type="hidden" name="exam_id" value="{{ $exam->id }}">
                        <input type="hidden" name="type" value="{{ $exam->type }}">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12">
                                    <div class="page-title-box">
                                        <div class="page-title-right">
                                        </div>
                                        <h4 class="page-title">&nbsp;</h4>
                                    </div>
                                </div>
                            </div>

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

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{ 'Pertanyaan ' . $exams->currentPage() }}</h4>
                                </div>
                                <div class="card-body">
                                    {!! $exam->question !!}
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Jawaban</h4>
                                </div>
                                <div class="card-body">
                                    @if ($exam->type == 1)
                                        <textarea name="answer" class="form-control" rows="7" required>{{ $exam->memberAnswerByAuth ? $exam->memberAnswerByAuth->answer : '' }}</textarea>
                                    @else
                                        <ul>
                                            @foreach ($exam->answers as $answer)
                                                <li class="d-flex justify-content-between align-items-center border"
                                                    style="cursor: pointer" id="answer">
                                                    <p class="m-0">{{ $answer->answer }}</p>
                                                    <input type="radio" value="{{ $answer->id }}"
                                                        @checked($exam->memberAnswerByAuth && $exam->memberAnswerByAuth->answer == $answer->id) name="answer" required />
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <footer class="footer">
                    <div class="container-fluid">
                        <div class="d-flex justify-content-between text-dark">
                            <h5>
                                @if ($exams->currentPage() > 1)
                                    <a href="?page={{ $exams->currentPage() - 1 }}">Kembali</a>
                                @endif
                            </h5>
                            <h5></h5>
                            <h5>
                                @if ($exams->currentPage() != $exams->lastPage())
                                    <a href="#" id="nextButton">Selanjutnya</a>
                                @else
                                    <span class="text-primary" style="cursor: pointer" data-bs-target="#confirmModal"
                                        data-bs-toggle="modal">Selesai</span>
                                @endif
                            </h5>
                        </div>
                    </div>
                </footer>

            </div>
        </form>
    </div>

    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">
                        konfirmasi
                    </h5>
                </div>
                <div class="modal-body">
                    harap periksa kembali jawaban anda, jika sudah yakin bisa klik tombol Simpan?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-sm btn-primary btn-submit">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

    @include('templates.foot')

    <script>
        $(function() {
            setTimeout(() => {
                startTimer();
            }, 1000);

            $('span[data-bs-target="#confirmModal"]').click(function() {
                let action =
                    "{{ route('web.training.course.slug.exam.answer', ['trainingSlug' => $training->slug, 'page' => $exams->currentPage()]) }}&is_finish=1"
                $("#mainform").attr("action", action)
            })

            $(".modal .btn-submit").on("click", function() {
                $("#mainform").submit()
            })

            $("body").on("click", "#answer", function() {
                $("ul li input[type='radio']").prop("checked", false)
                $(this).find("input[type='radio']").prop("checked", true)
            })

            $("body").on("click", "#nextButton", function(e) {
                e.preventDefault();

                if ($("input[name='answer']:checked").val() == undefined) {
                    Swal.fire({
                        title: 'Ooops!',
                        text: "Harap masukan jawaban terlebih dahulu!",
                        icon: 'warning'
                    })
                    return;
                }

                if ($("textarea").val() == "") {
                    Swal.fire({
                        title: 'Ooops!',
                        text: "Harap masukan jawaban terlebih dahulu!",
                        icon: 'warning'
                    })
                    return;
                }

                $(this).parents("form#mainform").submit()
            })

            function startTimer() {
                $.ajax({
                    url: "{{ route('web.exam.check.time', ['id' => auth()->user()->id, 'training' => $training->id]) }}",
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        let time = response.data.check_in_exam
                        const [checkInDate, checkInTime] = time.split(" ");
                        const [endHours, endMinutes, endSeconds] = checkInTime.split(":")

                        const endTime = new Date();
                        endTime.setHours(endHours);
                        endTime.setMinutes(endMinutes);

                        let interval = setInterval(function() {
                            const currentTime = new Date();

                            const remainingTime = endTime - currentTime;
                            const hours = Math.floor(remainingTime / (1000 * 60 * 60));
                            const minutes = Math.floor(
                                (remainingTime % (1000 * 60 * 60)) / (1000 * 60)
                            );
                            const seconds = Math.floor(
                                (remainingTime % (1000 * 60)) / 1000
                            );

                            $("#timer").text(`${formatTime(
                                hours
                                )}:${formatTime(minutes)}:${formatTime(seconds)}`)

                            if (currentTime >= endTime) {
                                clearInterval(interval);

                                // window.location.href =
                                //     "{{ route('web.training.course.slug.exam.expired', $training->slug) }}"
                            }
                        }, 1000);
                    },
                    error: function(error) {
                        console.error(error);
                    }
                })
            }

            function formatTime(time) {
                return time < 10 ? `0${time}` : time;
            }
        })
    </script>
</body>

</html>
