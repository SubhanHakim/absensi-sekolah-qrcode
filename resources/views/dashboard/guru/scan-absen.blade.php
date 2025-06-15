<x-app-layout>
    <x-slot name="header">
        <nav class="w-full flex items-center justify-between" aria-label="Global">
            <div>
                <h2 class="font-semibold text-xl flex items-center gap-2">
                    <i class="ti ti-qrcode text-2xl text-blue-600"></i>
                    Scan QR Code Absensi
                </h2>
            </div>
            <div class="flex items-center gap-4">
                @include('header-components.dd-profile')
            </div>
        </nav>
    </x-slot>

    <div class="flex flex-col items-center justify-center min-h-[70vh] bg-gradient-to-br from-blue-50 to-blue-100 py-8">
        @if (session('success'))
            <div
                class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded mb-4 shadow animate-bounce-in">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded mb-4 shadow animate-bounce-in">
                {{ session('error') }}
            </div>
        @endif

        <div class="rounded-xl shadow-lg bg-white p-6 flex flex-col items-center border border-blue-200">
            <div class="mb-4 text-center">
                <h3 class="text-lg font-semibold text-blue-700">Arahkan kamera ke QR Code Siswa</h3>
                <p class="text-gray-500 text-sm">Pastikan QR code terlihat jelas di dalam kotak scanner.</p>
            </div>
            <div id="reader" class="rounded-lg border-4 border-blue-400 shadow-inner" style="width:320px"></div>
        </div>
    </div>

    <form id="absenForm" action="{{ route('guru.prosesAbsen') }}" method="POST" style="display:none;">
        @csrf
        <input type="hidden" name="qr_code" id="qr_code">
    </form>

    <style>
        .animate-bounce-in {
            animation: bounce-in 0.7s;
        }

        @keyframes bounce-in {
            0% {
                transform: scale(0.7);
                opacity: 0;
            }

            60% {
                transform: scale(1.1);
                opacity: 1;
            }

            100% {
                transform: scale(1);
            }
        }

        #reader video {
            border-radius: 0.5rem;
        }
    </style>

    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        function onScanSuccess(decodedText, decodedResult) {
            // Optional: tampilkan feedback visual
            let box = document.getElementById('reader');
            box.style.boxShadow = "0 0 0 4px #22c55e";
            setTimeout(() => {
                box.style.boxShadow = "";
            }, 800);

            document.getElementById('qr_code').value = decodedText;
            document.getElementById('absenForm').submit();
        }
        new Html5QrcodeScanner("reader", {
            fps: 10,
            qrbox: 250
        }).render(onScanSuccess);
    </script>
</x-app-layout>
