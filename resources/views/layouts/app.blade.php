<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logos/favicon.png') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.44.0/tabler-icons.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/css/theme.css', 'resources/js/app.js', 'resources/js/sidebarmenu.js', 'resources/css/sidebar.css', 'resources/css/reboot.css', 'resources/js/app.js'])

    <style>
        .bg-logo {
            background-image: url("{{ asset('images/logo.png') }}");
            background-repeat: no-repeat;
            background-position: center;
            background-size: contain;
            opacity: 0.05; /* Reduced opacity so content is still visible */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
        }
        
        main, header, footer, .app-content, #main-wrapper, .page-wrapper {
            position: relative;
            z-index: 1;
        }
    </style>
</head>

<body class="bg-surface font-sans antialiased">
    <!-- Background Logo Element -->
    <div class="bg-logo"></div>
    
    <main>
        <div id="main-wrapper" class="flex p-5 xl:pr-0">
            {{-- Sidebar --}}
            <aside id="application-sidebar-brand"
                class="hs-overlay hs-overlay-open:translate-x-0 -translate-x-full transform hidden xl:block xl:translate-x-0 xl:end-auto xl:bottom-0 fixed xl:top-[90px] xl:left-auto top-0 left-0 with-vertical h-screen z-[999] shrink-0 w-[270px] shadow-md xl:rounded-md rounded-none bg-white left-sidebar transition-all duration-300">

                @php
                    $role = Auth::user()->role ?? null;
                @endphp

                @if ($role === 'guru')
                    @include('layouts.sidebar_guru')
                @elseif ($role === 'siswa')
                    @include('layouts.sidebar_siswa')
                @elseif ($role === 'orang_tua')
                    @include('layouts.sidebar_orangtua')
                @else
                    @include('layouts.sidebar')
                @endif
            </aside>
            {{-- Konten Utama --}}
            <div class="w-full page-wrapper xl:px-6 px-0">
                <main class="h-full max-w-full">
                    <div class="container full-container p-0 flex flex-col gap-6">
                        {{-- Header Konten --}}
                        @isset($header)
                            <header class="bg-white shadow-md rounded-md w-full text-sm py-4 px-6">
                                {{ $header }}
                            </header>
                        @endisset
                        {{-- Slot Konten --}}
                        {{ $slot }}
                        {{-- Footer (opsional) --}}
                        {{-- @includeIf('partials.footer') --}}
                    </div>
                </main>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
</body>

</html>