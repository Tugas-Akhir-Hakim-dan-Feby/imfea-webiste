@include('templates.head')

<body class="authentication-bg loading" style="background-color: #fafbfe"
    data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-4 col-lg-5">
                    <div class="card">

                        <div class="card-header pt-3 pb-3 text-center bg-light">
                            <a href="{{ route('web.home.index') }}">
                                <span>
                                    <img src="{{ asset('assets/logo/logo-full.png') }}" alt="" width="200">
                                </span>
                            </a>
                        </div>

                        <div class="card-body p-4">

                            <div class="text-center w-75 m-auto">
                                <h4 class="text-dark-50 text-center pb-0 fw-bold">Daftar</h4>
                                <p class="text-muted mb-4">
                                    Dengan Mendaftar, Anda dapat memanfaatkan fitur lengkap layanan kami.
                                    <br>
                                    <br>
                                    Daftar Sekarang !!!
                                </p>
                            </div>

                            @if (session('dangerMessage'))
                                <x-alert color="danger" dismissible>
                                    {{ session('dangerMessage') }}
                                </x-alert>
                            @endif

                            <form action="{{ route('web.auth.register.process') }}" method="POST" id="formRegister"
                                class="needs-validation" novalidate>
                                @csrf
                                <x-input label="Nama Lengkap" id="name" autofocus required
                                    value="{{ old('name') }}" />
                                <x-input label="Email" id="email" type="email" required
                                    value="{{ old('email') }}" />
                                <x-input-addon label="Password" type="password" id="password" required>
                                    <div class="input-group-text" data-password="false">
                                        <span class="password-eye"></span>
                                    </div>
                                </x-input-addon>
                                <x-input-addon label="Konfirmasi Password" type="password" id="confirm_password"
                                    required>
                                    <div class="input-group-text" data-password="false">
                                        <span class="password-eye"></span>
                                    </div>
                                </x-input-addon>
                                <div class="mb-3 mb-0 text-center">
                                    <x-button label="Daftar" size="sm" type="submit" class="w-100" />
                                </div>
                            </form>
                            <x-row class="mt-3">
                                <x-col class="text-center">
                                    <p class="text-muted">
                                        Sudah punya akun? <x-link route="web.auth.login.index"
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
