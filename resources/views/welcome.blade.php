<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SD Negeri Bingkeng 03 - Sistem Absensi</title>
    <meta name="description" content="Sistem informasi absensi sekolah SD Negeri Bingkeng 03">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.22.0/tabler-icons.min.css">
    <style>
        .bg-logo {
            background-image: url("{{ asset('images/logo.png') }}");
            background-repeat: no-repeat;
            background-position: center;
            background-size: contain;
            opacity: 0.1;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <!-- Header/Navbar -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-auto">
                    <div class="ml-4">
                        <h1 class="text-xl font-semibold text-gray-800">SD Negeri Bingkeng 03</h1>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="ti ti-login mr-2"></i> Login
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section - Full Screen Height with Background Logo -->
    <section class="h-screen bg-gradient-to-br from-blue-50 to-blue-100 flex items-center relative">
        <!-- Background Logo -->
        <div class="absolute inset-0 bg-logo"></div>
        
        <!-- Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <div class="max-w-3xl mx-auto">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Sistem Informasi <span class="text-blue-600">Absensi Siswa</span></h2>
                <p class="text-lg text-gray-700 mb-8">Pantau kehadiran siswa dengan mudah dan efisien. Akses informasi absensi kapan saja dan di mana saja.</p>
                <div class="flex justify-center">
                    <a href="{{ route('login') }}" class="inline-flex justify-center items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Login Sistem
                    </a>
                </div>
            </div>
        </div>
    </section>
</body>
</html>