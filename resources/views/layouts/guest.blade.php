<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'EduHub') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased overflow-hidden">

    <div class="min-h-screen grid grid-cols-1 md:grid-cols-2 bg-[#f8fafc]">

        <div class="relative hidden md:flex items-center justify-center overflow-hidden">

            <img src="{{ asset('images/EduHubCampus.jpeg') }}" alt="EduHub Campus Life"
                class="absolute inset-0 w-full h-full object-cover select-none">

            <div
                class="absolute inset-0 z-10 bg-gradient-to-tr from-[#064e3b] via-[#064e3b]/90 to-transparent mix-blend-multiply opacity-30">
            </div>

            <div class="relative z-20 text-center text-white px-12 group">
                <div class="inline-flex flex-col items-center">
                    <div class="bg-white/10 backdrop-blur-md p-2 rounded-3xl border border-white/20 mb-8 shadow-inner">
                        <x-application-logo class="w-20 h-20 fill-current text-white rounded-lg" />
                    </div>
                    <h1 class="text-4xl font-extrabold italic tracking-tight text-white mb-2">
                        Edu<span class="text-emerald-300">Hub</span>
                    </h1>
                    <p class="text-emerald-100 font-medium tracking-wide opacity-90 max-w-sm">
                        Le système de gestion scolaire unifié, moderne et performant.
                    </p>
                </div>
            </div>
        </div>

        <div
            class="flex items-center justify-center p-6 sm:p-12 relative overflow-hidden bg-white md:rounded-l-[40px] shadow-2xl md:-ml-12 md:z-20">

            <div class="absolute top-0 right-0 w-full h-1 bg-gradient-to-r from-emerald-500 to-blue-500"></div>

            <div class="absolute top-1/4 right-0 w-64 h-64 bg-emerald-50 rounded-full blur-3xl opacity-40"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-blue-50 rounded-full blur-3xl opacity-40"></div>

            <div class="relative z-30 w-screen max-w-md">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>

</html>
