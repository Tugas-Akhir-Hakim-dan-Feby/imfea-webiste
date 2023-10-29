<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>
        {{ $title ?? 'Asosiasi Ahli dalam bidang pemikiran dan advokasi kebijakan keuangan mikro di Indonesia Dashboard - IMFEA IMFEA - Indonesian Micro Finance Expert Associations IMFEA - Indonesian Micro Finance Expert Associations - Indonesian Micro Finance Expert Associations' }}
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description">
    <meta content="Coderthemes" name="author">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo.png') }}">

    <link href="{{ asset('assets/css/vendor/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="light-style">
    <link href="{{ asset('assets/css/app-dark.min.css') }}" rel="stylesheet" type="text/css" id="dark-style">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <style>
        body {
            font-family: "Noir Pro", sans-serif;
        }

        .error {
            color: red;
            font-weight: normal
        }
    </style>
    @stack('css')
</head>
