{{-- filepath: resources/views/dashboard/orangtua/rekap-absensi.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl flex items-center gap-2">
            <i class="ti ti-calendar-stats text-2xl text-blue-600"></i>
            Rekapitulasi Absensi Anak
        </h2>
    </x-slot>

    <div class="flex flex-col items-center justify-center min-h-[60vh] bg-gradient-to-br from-blue-50 to-blue-100 py-8">
        <div class="w-full max-w-2xl bg-white rounded-xl shadow-lg border border-blue-200 p-8">
            <form method="GET" class="mb-6 flex flex-wrap gap-2 items-center">
                <label for="bulan" class="font-semibold">Bulan:</label>
                <input type="month" id="bulan" name="bulan" value="{{ request('bulan', now()->format('Y-m')) }}" class="border rounded px-2 py-1">
                <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">Lihat</button>
            </form>

            <h3 class="text-lg font-semibold text-blue-700 mb-4">
                Rekap Absensi {{ $student->nama }}<br>
                Bulan: {{ \Carbon\Carbon::parse($bulan.'-01')->translatedFormat('F Y') }}
            </h3>
            <div class="overflow-x-auto rounded-lg">
                <table class="min-w-full text-sm border border-gray-200 rounded-lg shadow">
                    <thead class="bg-blue-600 text-white">
                        <tr>
                            <th class="py-3 px-4 text-left rounded-tl-lg">Tanggal</th>
                            <th class="py-3 px-4 text-left">Status</th>
                            <th class="py-3 px-4 text-left rounded-tr-lg">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($absensi as $absen)
                            <tr class="hover:bg-blue-50 even:bg-gray-50 transition">
                                <td class="py-2 px-4 border-b border-gray-200">
                                    {{ \Carbon\Carbon::parse($absen->tanggal)->format('d-m-Y') }}
                                </td>
                                <td class="py-2 px-4 border-b border-gray-200">
                                    @if($absen->status == 'hadir')
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded bg-green-100 text-green-700 font-semibold text-xs">
                                            <i class="ti ti-check text-base"></i> Hadir
                                        </span>
                                    @elseif($absen->status == 'izin')
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded bg-yellow-100 text-yellow-700 font-semibold text-xs">
                                            <i class="ti ti-alert-circle text-base"></i> Izin
                                        </span>
                                    @elseif($absen->status == 'sakit')
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded bg-orange-100 text-orange-700 font-semibold text-xs">
                                            <i class="ti ti-medical-cross text-base"></i> Sakit
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded bg-red-100 text-red-700 font-semibold text-xs">
                                            <i class="ti ti-x text-base"></i> Alfa
                                        </span>
                                    @endif
                                </td>
                                <td class="py-2 px-4 border-b border-gray-200">
                                    {{ $absen->keterangan ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-gray-500">Belum ada data absensi bulan ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>