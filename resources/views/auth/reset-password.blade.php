@include('templates.head')

<body class="authentication-bg loading" style="background-color: #fafbfe"
    data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-4 col-lg-5">
                    <div class="card">

                        <div class="card-header pt-4 pb-4 text-center bg-primary">
                            <a href="{{ route('web.home.index') }}">
                                <span><img src="{{ asset('assets/images/logo-light.png') }}" alt=""
                                        height="50"></span>
                            </a>
                        </div>

                        <div class="card-body p-4">

                            <div class="text-center w-75 m-auto">
                                <h4 class="text-dark-50 text-center pb-0 fw-bold">Reset Password</h4>
                                <p class="text-muted mb-4">
                                    Masukkan alamat email Anda dan kami akan mengirimkan email berisi instruksi untuk
                                    mengatur ulang kata sandi Anda.
                                </p>
                            </div>

                            @if (session('successMessage'))
                                <x-alert class="mb-3" color="success">
                                    {{ session('successMessage') }}
                                </x-alert>
                            @endif
                            @if (session('warningMessage'))
                                <x-alert class="mb-3" color="warning">
                                    {{ session('warningMessage') }}
                                </x-alert>
                            @endif
                            @if (session('dangerMessage'))
                                <x-alert class="mb-3" color="danger" dismissible>
                                    {{ session('dangerMessage') }}
                                </x-alert>
                            @endif

                            <form action="{{ route('web.auth.reset-password.process') }}" method="POST"
                                class="needs-validation" novalidate>
                                @csrf
                                <x-input label="Email" id="email" type="email" required autofocus
                                    value="{{ old('email') }}" />

                                <div class="mb-3 mb-0 text-center">
                                    <x-button label="Reset Password" size="sm" type="submit" class="w-100" />
                                </div>

                            </form>
                            <x-row class="mt-3">
                                <x-col class="text-center">
                                    <p class="text-muted">
                                        Kembali ke <x-link route="web.auth.login.index"
                                            class="text-muted ms-1 fw-bold">Login</x-link>
                                    </p>
                                </x-col>
                            </x-row>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('templates.foot')
