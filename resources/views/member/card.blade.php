@php
    use Carbon\Carbon;

    $memberCreatedAt = Carbon::createFromFormat('Y-m-d H:i:s', $user->membership->created_at);
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Membercard {{ $user->name }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link href="{{ asset('assets/css/app-dark.min.css') }}" rel="stylesheet" type="text/css" id="dark-style">
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="light-style">
    <style>
        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            margin: auto;
            height: 100vh;
            width: 100vw;
            display: flex;
            font-family: Inter;
            justify-content: center;
            align-items: center;
        }

        .card-header {
            border-bottom-right-radius: 20px !important;
            border-bottom-left-radius: 20px !important;
        }

        .text-danger {
            color: #DC3432 !important;
        }

        .bg-tertiary {
            background-color: #EEF2F7;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card" style="width: 600px;">
            <div class="card-header d-flex justify-content-between align-items-center bg-tertiary py-3 px-4">
                <h4 class="text-danger me-4">KARTU TANDA ANGGOTA</h4>
                <img src="{{ asset('assets/logo/logo-membercard.png') }}" height="50">
            </div>
            <div class="card-body py-3 px-4">
                <div class="d-flex">
                    <img src="{{ asset('assets/images/pas_photo/31102023/1698755580_frame-8png') }}"
                        style="height: 4cm; width: 3cm; margin-top: -3rem; border-radius: 15px">
                    <div class="ms-3">
                        <h5 class="mt-0 mb-2 text-uppercase">{{ $user->name }}</h5>
                        <h5 class="mt-0 mb-2 text-danger">Member Aplikasi</h5>
                        <h5 class="mt-0">
                            <span>{{ $memberCreatedAt->isoFormat('YYYY') }}</span>
                            <span>{{ $memberCreatedAt->isoFormat('MM') }}</span>
                            <span>{{ $memberCreatedAt->isoFormat('DD') }}</span>
                            <span>004</span>
                            <span>{{ $memberId }}</span>
                        </h5>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <div style="width: 13.4rem">
                        <p class="mt-3">
                            {{ ucwords($user->membership->address) }},
                            {{ ucfirst(strtolower($user->membership->city['name'])) }},
                            {{ ucfirst(strtolower($user->membership->province['name'])) }}, Indonesia.
                        </p>
                    </div>
                    <div class="d-flex align-items-end position-relative">
                        <div>
                            <p class="m-0">Masa Berlaku KTA:</p>
                            <p class="mb-2 text-uppercase">{{ $memberCreatedAt->addYears(3)->isoFormat('MMMM YYYY') }}
                            </p>
                        </div>
                        <div class="m-0">
                            <img class="m-0" src="{{ asset("assets/images/qrcode/$user->id.png") }}" height="150">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
