<!-- filepath: resources/views/dashboard/guru/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Dashboard Guru</h2>
    </x-slot>

    <div class="bg-white shadow rounded-lg p-6">
        <p>Selamat datang, {{ auth()->user()->name }} !</p>
        <h3 class="text-lg font-semibold mb-4">Daftar Siswa Kelas {{ $kelas->class_name ?? '-' }}</h3>
        @if ($students->count())
            <table class="min-w-full border border-gray-200 rounded-lg">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="py-2 px-4">Nama</th>
                        <th class="py-2 px-4">NIS</th>
                        <th class="py-2 px-4">Email</th>
                        <th class="py-2 px-4">QR Code</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr class="hover:bg-blue-50 even:bg-gray-50 transition">
                            <td class="py-2 px-4 border-b">{{ $student->nama }}</td>
                            <td class="py-2 px-4 border-b">{{ $student->nis }}</td>
                            <td class="py-2 px-4 border-b">{{ $student->email }}</td>
                            <td class="py-2 px-4 border-b">
                                <div id="qr-container-{{ $student->id }}">
                                    {!! QrCode::size(60)->generate($student->qr_code) !!}
                                </div>
                                <a href="#"
                                    class="bg-green-600 text-white px-2 py-1 rounded text-xs mt-1 inline-block"
                                    onclick="downloadPNG({{ $student->id }}, '{{ $student->nis }}'); return false;">
                                    Download PNG
                                </a>
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
