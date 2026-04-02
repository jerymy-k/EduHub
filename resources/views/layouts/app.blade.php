<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'EDUHUB') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Custom Scrollbar pour le look Premium */
        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #059669;
            border-radius: 10px;
        }

        .bg-eduhub-sidebar {
            background-color: #022c22;
        }

        .bg-eduhub-main {
            background-color: #f8fafc;
        }
    </style>
</head>

<body class="font-sans antialiased text-gray-900 bg-eduhub-main">

    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-emerald-50 to-slate-100">
        <aside class="hidden lg:block fixed left-0 top-0 h-full z-40 w-72">
            @include('components.sidebare')
        </aside>
        <div class="lg:ml-72">
            @if (isset($header))
                <header
                    class="sticky top-0 z-30 bg-white/95 backdrop-blur-md border-b border-emerald-100 shadow-sm h-20 flex items-center px-6 lg:px-8">
                    <div class="w-full max-w-7xl mx-auto flex justify-between items-center">
                        {{ $header }}
                        <div class="flex items-center space-x-4 text-gray-500">
                            <i
                                class="fas fa-search text-xl hover:text-emerald-600 cursor-pointer transition p-1 rounded-lg hover:bg-gray-100"></i>
                            <i
                                class="fas fa-bell text-xl hover:text-emerald-600 cursor-pointer transition p-1 rounded-lg hover:bg-gray-100"></i>
                        </div>
                    </div>
                </header>
            @endif

            <main class="flex-1 p-6 lg:p-8">
                <div class="max-w-7xl mx-auto">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</body>

</html>
