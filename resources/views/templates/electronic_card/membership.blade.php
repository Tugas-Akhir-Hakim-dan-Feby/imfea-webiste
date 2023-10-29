<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Membership Card</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        #background {
            background-image: url('assets/images/membership-card.png');
            background-size: contain;
            background-size: cover;
            width: 300px;
            height: 169px;
        }

        #background #detail {
            position: relative;
            display: flex;
        }

        #background img {
            margin-top: 37px;
            margin-left: 20px;
            width: 49px;
            height: 62px;
            border-radius: 5px;
        }

        #background #detail div {
            margin-top: 55px;
            margin-left: 8px;
        }

        #background #detail p {
            margin: 0;
            padding: 0;
            font-weight: bold;
            font-size: 10px;
            line-height: 15px;
        }

        #background #detail p:nth-child(2) {
            color: #DC3432;
        }

        #background #detail p:last-child {
            letter-spacing: 1px
        }

        #background #address {
            width: 100px;
            margin-top: 15px;
            margin-left: 20px;
        }

        #background #address p {
            font-size: 8px;
        }

        #background #qrcode {
            position: relative;
            display: flex;
        }

        #background #qrcode p {
            position: absolute;
            right: 93px;
            bottom: -19px;
            font-size: 8px;
        }

        #background #qrcode #code {
            position: absolute;
            right: 9.8px;
            bottom: 0;
            bottom: -13px;
        }
    </style>
</head>

<body>
    <div id="background">
        <div id="detail">
            <img src="{{ public_path('assets/images/logo.png') }}">
            <div>
                <p>HAKIM ASRORI</p>
                <p>Member Aplikasi</p>
                <p>2023 10 28 001 0001</p>
            </div>
        </div>
        <div id="address">
            <p>
                Puntang, kecamatan Losarang, Indramayu, Jawa Barat, Indonesia.
            </p>
        </div>
        <div id="qrcode">
            <p>
                OKTOBER 2023
            </p>
            <div id="code">
                {!! QrCode::size(55)->generate(Request::url()) !!}
            </div>
        </div>
    </div>

</body>

</html>
