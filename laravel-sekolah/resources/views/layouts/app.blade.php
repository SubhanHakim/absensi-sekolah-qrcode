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
    @vite(['resources/css/app.css', 'resources/css/theme.css', 'resources/js/app.js'])

    <style>
        .bg-logo {
            background-image: url("{{ asset('images/logo.png') }}");
            background-repeat: no-repeat;
            background-position: center;
            background-size: contain;
            opacity: 0.05;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
        }

        /* Mobile Sidebar Styles */
        #mobile-sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
        }

        #mobile-sidebar.show {
            transform: translateX(0);
        }

        #mobile-backdrop {
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        #mobile-backdrop.show {
            opacity: 1;
            visibility: visible;
        }

        /* Desktop Sidebar */
        @media (min-width: 1280px) {
            #desktop-sidebar {
                display: block;
            }
            #mobile-sidebar, #mobile-backdrop {
                display: none;
            }
        }

        /* Mobile Sidebar */
        @media (max-width: 1279px) {
            #desktop-sidebar {
                display: none;
            }
        }
    </style>
</head>

<body class="bg-surface font-sans antialiased">
    <!-- Background Logo -->
    <div class="bg-logo"></div>

    <!-- Mobile Backdrop -->
    <div id="mobile-backdrop" class="fixed inset-0 bg-black bg-opacity-50 z-40 xl:hidden"></div>

    <!-- Mobile Sidebar -->
    <aside id="mobile-sidebar" class="fixed top-0 left-0 h-full w-[270px] bg-white shadow-lg z-50 xl:hidden">
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

    <main class="relative z-10">
        <div class="flex">
            <!-- Desktop Sidebar -->
            <aside id="desktop-sidebar" class="hidden xl:block w-[270px] bg-white shadow-md rounded-md h-screen sticky top-5 ml-5">
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

            <!-- Main Content -->
            <div class="flex-1 p-5 xl:pr-0">
                <div class="max-w-full">
                    <!-- Header -->
                    @isset($header)
                        <header class="bg-white shadow-md rounded-md w-full text-sm py-4 px-6 mb-6">
                            {{ $header }}
                        </header>
                    @endisset

                    <!-- Content -->
                    {{ $slot }}
                </div>
            </div>
        </div>
    </main>

    @stack('scripts')

    <!-- Mobile Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileToggle = document.getElementById('mobile-toggle');
            const mobileSidebar = document.getElementById('mobile-sidebar');
            const mobileBackdrop = document.getElementById('mobile-backdrop');

            function openSidebar() {
                mobileSidebar.classList.add('show');
                mobileBackdrop.classList.add('show');
                document.body.style.overflow = 'hidden';
            }

            function closeSidebar() {
                mobileSidebar.classList.remove('show');
                mobileBackdrop.classList.remove('show');
                document.body.style.overflow = '';
            }

            // Toggle button click
            if (mobileToggle) {
                mobileToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    if (mobileSidebar.classList.contains('show')) {
                        closeSidebar();
                    } else {
                        openSidebar();
                    }
                });
            }

            // Backdrop click
            if (mobileBackdrop) {
                mobileBackdrop.addEventListener('click', closeSidebar);
            }

            // Close on link click (mobile)
            const sidebarLinks = document.querySelectorAll('#mobile-sidebar a[href]');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function() {
                    setTimeout(closeSidebar, 150);
                });
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 1280) {
                    closeSidebar();
                }
            });
        });
    </script>
</body>

</html>