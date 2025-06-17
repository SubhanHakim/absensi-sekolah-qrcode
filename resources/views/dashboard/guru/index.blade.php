<!-- filepath: resources/views/dashboard/guru/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <nav class="w-full flex items-center justify-between" aria-label="Global">
            <div>
                <h2 class="font-semibold text-xl">Dashboard Guru</h2>
            </div>
            <div class="flex items-center gap-4">
                @include('header-components.dd-profile')
            </div>
        </nav>
    </x-slot>

    <div class="flex flex-col items-center justify-center min-h-[60vh] bg-gradient-to-br from-blue-50 to-blue-100 py-8">
        <!-- Welcome Banner -->
        <div
            class="w-full max-w-6xl bg-gradient-to-r from-blue-600 to-blue-400 text-white rounded-xl shadow-lg p-6 mb-6">
            <div class="flex items-center gap-4">
                <div class="bg-white bg-opacity-20 p-3 rounded-full flex items-center justify-center w-12 h-12">
                    @php
                        $initial = strtoupper(substr(auth()->user()->name ?? 'G', 0, 1));
                    @endphp
                    <span class="text-black text-2xl font-bold">{{ $initial }}</span>
                </div>
                <div>
                    <h3 class="text-xl font-bold">Selamat Datang, {{ auth()->user()->name }}!</h3>
                    <p class="text-blue-50">Wali Kelas {{ $kelas->class_name ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="w-full max-w-6xl">
            <div class="bg-white rounded-xl shadow-xl border border-blue-200 p-6 mb-6">
                <!-- Quick Actions -->
                <div class="flex flex-wrap gap-4 mb-6">
                    <a href="{{ route('guru.scanAbsen') }}"
                        class="flex items-center gap-3 p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors border border-blue-200">
                        <div class="bg-blue-500 text-white p-2 rounded-lg">
                            <i class="ti ti-qrcode text-xl"></i>
                        </div>
                        <span class="font-medium">Scan QR Absensi</span>
                    </a>

                    <a href="{{ route('guru.rekapAbsen') }}"
                        class="flex items-center gap-3 p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors border border-blue-200">
                        <div class="bg-blue-500 text-white p-2 rounded-lg">
                            <i class="ti ti-clipboard-list text-xl"></i>
                        </div>
                        <span class="font-medium">Rekap Absensi</span>
                    </a>

                    <a href="{{ route('guru.downloadQrPdf') }}"
                        class="flex items-center gap-3 p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors border border-blue-200">
                        <div class="bg-blue-500 text-white p-2 rounded-lg">
                            <i class="ti ti-download text-xl"></i>
                        </div>
                        <span class="font-medium">Download Semua QR</span>
                    </a>
                </div>

                <!-- Student Table -->
                <h3 class="text-lg font-semibold mb-4 flex items-center gap-2 text-blue-700">
                    <i class="ti ti-users text-xl"></i>
                    Daftar Siswa Kelas {{ $kelas->class_name ?? '-' }}
                </h3>

                @if ($students->count())
                    <div class="overflow-x-auto rounded-lg">
                        <table class="min-w-full text-sm border border-gray-200 rounded-lg shadow">
                            <thead class="bg-blue-600 text-white">
                                <tr>
                                    <th class="py-3 px-4 text-left rounded-tl-lg">Nama</th>
                                    <th class="py-3 px-4 text-left">NIS</th>
                                    <th class="py-3 px-4 text-left">Email</th>
                                    <th class="py-3 px-4 text-left rounded-tr-lg">QR Code</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $student)
                                    <tr class="hover:bg-blue-50 even:bg-gray-50 transition">
                                        <td class="py-3 px-4 border-b border-gray-200 font-medium">{{ $student->nama }}
                                        </td>
                                        <td class="py-3 px-4 border-b border-gray-200">{{ $student->nis }}</td>
                                        <td class="py-3 px-4 border-b border-gray-200">{{ $student->email }}</td>
                                        <td class="py-3 px-4 border-b border-gray-200">
                                            <div id="qr-container-{{ $student->id }}"
                                                class="flex flex-col items-center">
                                                {!! QrCode::size(100)->generate($student->qr_code) !!}
                                                <a href="#"
                                                    class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs mt-2 transition flex items-center gap-1"
                                                    onclick="downloadPNG({{ $student->id }}, '{{ $student->nis }}'); return false;">
                                                    <i class="ti ti-download"></i> Download
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div
                        class="bg-yellow-50 border border-yellow-200 text-yellow-700 p-4 rounded-lg flex items-center gap-3">
                        <i class="ti ti-alert-circle text-2xl"></i>
                        <p>Belum ada siswa di kelas ini.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function downloadPNG(studentId, nis) {
            const container = document.getElementById('qr-container-' + studentId);
            const svg = container.querySelector('svg');
            if (svg) {
                const svgData = new XMLSerializer().serializeToString(svg);
                const svg64 = btoa(unescape(encodeURIComponent(svgData)));
                const image64 = 'data:image/svg+xml;base64,' + svg64;

                const img = new Image();
                img.onload = function() {
                    const canvas = document.createElement('canvas');
                    // Set canvas size to 300x300 for bigger PNG
                    canvas.width = 300;
                    canvas.height = 300;
                    const ctx = canvas.getContext('2d');
                    // Draw SVG image scaled up to 300x300
                    ctx.drawImage(img, 0, 0, 300, 300);
                    const pngFile = canvas.toDataURL('image/png');
                    const a = document.createElement('a');
                    a.href = pngFile;
                    a.download = 'qr_code_' + nis + '.png';
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                };
                img.src = image64;
            }
        }
    </script>
</x-app-layout>
