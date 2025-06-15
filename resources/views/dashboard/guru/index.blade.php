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

    <div class="bg-white shadow rounded-lg p-6">
        <p>Selamat datang, {{ auth()->user()->name }} !</p>
        <h3 class="text-lg font-semibold mb-4">Daftar Siswa Kelas {{ $kelas->class_name ?? '-' }}</h3>
        @if ($students->count())
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
                            <td class="py-2 px-4 border-b border-gray-200">{{ $student->nama }}</td>
                            <td class="py-2 px-4 border-b border-gray-200">{{ $student->nis }}</td>
                            <td class="py-2 px-4 border-b border-gray-200">{{ $student->email }}</td>
                            <td class="py-2 px-4 border-b border-gray-200">
                                <div id="qr-container-{{ $student->id }}" class="flex items-center justify-between">
                                    {!! QrCode::size(100)->generate($student->qr_code) !!}
                                    <a href="#"
                                        class="bg-green-600 hover:bg-green-700 text-white px-2 py-1 rounded text-xs mt-2 transition"
                                        onclick="downloadPNG({{ $student->id }}, '{{ $student->nis }}'); return false;">
                                        <i class="ti ti-download"></i> Download PNG
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
                            canvas.width = img.width;
                            canvas.height = img.height;
                            const ctx = canvas.getContext('2d');
                            ctx.drawImage(img, 0, 0);
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
        @else
            <p class="text-gray-500">Belum ada siswa di kelas ini.</p>
        @endif
    </div>
</x-app-layout>
