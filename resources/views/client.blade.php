<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-base-200" data-theme="light" class="scrollbar-hide">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Universitas Internasional Semen Indonesias</title>
    @vite('resources/css/app.css')
    @livewireStyles
</head>

<body class="flex justify-center items-center" style="height: 100vh !important; margin:0px ;">
    {{ $slot }}
</body>


@livewireScripts
@vite(['resources/js/app.js'])
@stack('scripts')

</html>
