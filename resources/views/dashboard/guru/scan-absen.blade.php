<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Scan QR Code Absensi</h2>
    </x-slot>
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-2 rounded mb-4">{{ session('error') }}</div>
    @endif

    <div id="reader" style="width:300px"></div>
    <form id="absenForm" action="{{ route('guru.prosesAbsen') }}" method="POST" style="display:none;">
        @csrf
        <input type="hidden" name="qr_code" id="qr_code">
    </form>

    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
    function onScanSuccess(decodedText, decodedResult) {
        document.getElementById('qr_code').value = decodedText;
        document.getElementById('absenForm').submit();
    }
    new Html5QrcodeScanner("reader", { fps: 10, qrbox: 250 }).render(onScanSuccess);
    </script>
</x-app-layout>