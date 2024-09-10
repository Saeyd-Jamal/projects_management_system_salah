<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('img/icon.png')}}">
    <link rel="icon" type="image/png" href="{{asset('img/icon.png')}}">
    <title>
        {{ $title }}
    </title>
        <link href="{{asset('assets/css/bootstrap.rtl.css')}}" rel="stylesheet" />

    <!--  Fonts and icons -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <link href="{{asset('assets/css/all.min.css')}}" rel="stylesheet"></link>
    <!-- Nucleo Icons -->
    <link href="{{asset('assets/css/nucleo-icons.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/nucleo-svg.css')}}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <link href="{{asset('assets/css/nucleo-svg.css')}}" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{asset('assets/css/soft-ui-dashboard.css?v=1.0.3')}}" rel="stylesheet" />

    <link href="{{asset('assets/css/coustem.css')}}" rel="stylesheet" />

    <livewire:styles />
    @stack('styles')
</head>

<body class="g-sidenav-show rtl bg-gray-100">
