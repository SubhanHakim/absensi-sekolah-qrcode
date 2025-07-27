<x-guest-layout>
    <style>
        .login-bg-logo {
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
        main, header, footer, .app-content, #main-wrapper, .page-wrapper {
            position: relative;
            z-index: 1;
        }
    </style>

    <div class="login-bg-logo"></div>

    <div id="main-wrapper" class="overflow-hidden bg-white">
        <div class="w-full max-w-lg overflow-hidden">
            <!-- Top Section - Logo and Welcome Message -->
            <div
                class="bg-gradient-to-br from-blue-600 to-blue-700 py-4 px-8 flex flex-col items-center justify-center text-center">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('images/logo.png') }}" alt="SD Negeri Bingkeng 03" class="h-16">
                    <div>
                        <h1 class="text-xl font-bold text-white mb-1">Selamat Datang</h1>
                        <h2 class="text-lg font-semibold text-white">SD Negeri Bingkeng 03</h2>
                        <p class="text-blue-100 text-xs mt-1">Sistem Informasi Absensi Siswa</p>
                    </div>
                </div>
            </div>

            <!-- Bottom Section - Login Form -->
            <div class="p-5">
                <h3 class="text-lg font-semibold text-gray-800 mb-3 text-center">Login Akun</h3>

                <!-- Session Status -->
                <x-auth-session-status class="mb-3" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-3">
                        <x-input-label for="email" :value="__('Email')" class="text-gray-700 mb-1" />
                        <x-text-input id="email"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 py-1.5"
                            type="email" name="email" :value="old('email')" required autofocus
                            autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <x-input-label for="password" :value="__('Password')" class="text-gray-700 mb-1" />
                        <x-text-input id="password"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 py-1.5"
                            type="password" name="password" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    <!-- Remember Me and Forgot Password on same row -->
                    <div class="flex items-center justify-between mb-3">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox"
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 focus:ring-opacity-50"
                                name="remember">
                            <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm text-blue-600 hover:text-blue-800 hover:underline"
                                href="{{ route('password.request') }}">
                                {{ __('Forgot password?') }}
                            </a>
                        @endif
                    </div>

                    <button type="submit"
                        class="w-full px-6 py-2 bg-blue-600 text-white font-medium text-sm rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        {{ __('Log in') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
