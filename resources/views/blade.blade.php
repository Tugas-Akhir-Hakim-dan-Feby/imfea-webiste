<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <style>
        body {
            background-color: white;
        }

        header {
            height: 200px;
            flex-shrink: 0;
            border-radius: 0px 0px 50px 50px;
            background: rgba(220, 52, 50, 0.83);
        }

        header h5 {
            color: #F6FA9C;
            font-size: 40px;
        }
    </style>
</head>

<body>
    <header>
        <div class="container d-flex justify-content-between">
            <h5 class="fw-bold pt-4">KARTU TANDA ANGGOTA</h5>
            <img src="{{ asset('assets/images/logo-header.png') }}" width="400">
        </div>
    </header>
</body>

</html>
