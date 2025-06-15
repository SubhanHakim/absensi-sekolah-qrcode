{{-- filepath: resources/views/dashboard/orangtua/riwayat-absensi.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Riwayat Absensi Anak</h2>
    </x-slot>
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between mb-4">
            <div>
                <p class="font-semibold text-blue-700">Nama: {{ $student->nama }}</p>
                <p class="text-gray-600">NIS: {{ $student->nis }}</p>
            </div>
            <div>
                <a href="{{ route('dashboard.orangtua.riwayat-absensi.pdf') }}" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-xs">Download PDF</a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 rounded-lg">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="py-2 px-4">Tanggal</th>
                        <th class="py-2 px-4">Status</th>
                        <th class="py-2 px-4">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($absensi as $absen)
                        <tr class="hover:bg-blue-50 even:bg-gray-50 transition">
                            <td class="py-2 px-4 border-b">{{ \Carbon\Carbon::parse($absen->tanggal)->format('d-m-Y') }}</td>
                            <td class="py-2 px-4 border-b">{{ ucfirst($absen->status) }}</td>
                            <td class="py-2 px-4 border-b">{{ $absen->keterangan ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-gray-500">Belum ada data absensi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>