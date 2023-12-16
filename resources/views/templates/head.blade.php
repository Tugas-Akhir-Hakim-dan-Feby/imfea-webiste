<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>
        {{ $title ?? 'Indonesia Mechanical Engineering And Fabrication Education Association' }}
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Indonesia Mechanical Engineering And Fabrication Education Association" name="description">
    <meta content="Indonesia Mechanical Engineering And Fabrication Education Association" name="author">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('assets/logo/logo.png') }}">

    <link href="{{ asset('assets/css/vendor/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="light-style">
    <link href="{{ asset('assets/css/app-dark.min.css') }}" rel="stylesheet" type="text/css" id="dark-style">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}">
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
