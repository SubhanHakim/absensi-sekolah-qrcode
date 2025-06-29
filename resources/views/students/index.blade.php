<x-app-layout>
    <x-slot name="header">
        <nav class="w-full flex items-center justify-between" aria-label="Global">
            <div>
                <h2 class="font-semibold text-xl">Manajemen Data Siswa</h2>
            </div>
            <div class="flex items-center gap-4">
                @include('header-components.dd-profile')
            </div>
        </nav>
    </x-slot>
    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif
    <div class="flex justify-between items-center mb-4">

        <a href="{{ route('students.create') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition flex items-center gap-2">
            <iconify-icon icon="mdi:account-plus" width="22" height="22"></iconify-icon>
            Tambah Siswa
        </a>

        <form action="{{ route('siswa.import') }}" method="POST" enctype="multipart/form-data"
            class="flex items-center gap-2">
            @csrf
            <label
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow cursor-pointer transition flex items-center gap-2 mb-0">
                <iconify-icon icon="mdi:upload" width="22" height="22"></iconify-icon>
                <span>Upload Siswa</span>
                <input type="file" name="file" accept=".csv,.xlsx" class="hidden" onchange="this.form.submit()"
                    required>
            </label>
        </form>
    </div>
    <div class="overflow-x-auto rounded shadow">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
            <thead class="bg-blue-600 text-white sticky top-0 z-10">
                <tr>
                    <th class="py-3 px-4 text-left font-semibold">Nama</th>
                    <th class="py-3 px-4 text-left font-semibold">NIS</th>
                    <th class="py-3 px-4 text-left font-semibold">Kelas</th>
                    <th class="py-3 px-4 text-left font-semibold">QR Code</th>
                    <th class="py-3 px-4 text-center font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                    <tr class="hover:bg-blue-50 even:bg-gray-50 transition">
                        <td class="py-2 px-4 border-b border-gray-200">{{ $student->nama ?? '-' }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">{{ $student->nis }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">
                            {{ $student->schoolClass->class_name ?? $student->kelas }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">
                            <div id="qr-container-{{ $student->id }}" class="flex flex-col items-center">
                                @if ($student->qr_code)
                                    {!! QrCode::size(100)->generate($student->qr_code) !!}
                                @else
                                    <span class="text-red-500 text-xs">QR Code belum tersedia</span>
                                @endif
                                <a href="#"
                                    class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs mt-2 transition flex items-center gap-1"
                                    onclick="downloadPNG({{ $student->id }}, '{{ $student->nis }}'); return false;">
                                    <i class="ti ti-download"></i> Download
                                </a>
                            </div>
                        </td>
                        <td class="py-2 px-4 border-b border-gray-200 text-center">
                            <a href="{{ route('students.edit', $student) }}"
                                class="inline-block text-blue-600 hover:underline"><iconify-icon icon="mdi:pencil"
                                    width="24" height="24"></iconify-icon></a>
                            <form action="{{ route('students.destroy', $student) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 ml-2 hover:underline"
                                    onclick="return confirm('Yakin hapus?')"><iconify-icon icon="mdi:trash"
                                        width="24" height="24"></iconify-icon></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-4 px-4 text-center text-gray-500">Belum ada data siswa.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
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
