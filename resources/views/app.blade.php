<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-body" data-theme="light" class="scrollbar-hide">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UISI Information System</title>
    <link rel="icon" href="{{ asset('Assets/favicon.ico') }}" type="image/x-icon">
    <meta name="description" content="UISI Information System">
    @vite('resources/css/app.css')
    @vite(['resources/js/app.js'])
    @livewireStyles
</head>

<body class="flex flex-col scrollbar-hide font-Inter">

    @guest
        {{ $slot }}
    @endguest
    @auth
        @include('navbar')
        <div class="drawer lg:drawer-open">
            <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
            <div class="drawer-content flex flex-col">
                <main class="p-3 lg:p-2 mt-[4.5rem]">
                    <div class="lg:p-6">
                        {{ $slot }}
                    </div>
                </main>
            </div>
            @livewire('sidebar')
            @include('livewire.components.alert')

        </div>
    @endauth


    @stack('scripts')
    @livewireScripts
</body>

</html>
