{{-- filepath: resources/views/dashboard/orangtua/riwayat-absensi.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <nav class="w-full flex items-center justify-between py-2" aria-label="Global">
            <!-- Left Side -->
            <div class="flex items-center gap-4">
                <!-- Mobile Toggle Menu -->
                <div class="relative xl:hidden">
                    <button id="mobile-toggle"
                        class="text-xl cursor-pointer text-gray-700 p-2 rounded-md hover:bg-gray-100 transition-colors"
                        aria-label="Toggle navigation">
                        <i class="ti ti-menu-2 text-2xl"></i>
                    </button>
                </div>

                <!-- Page Title and Breadcrumb -->
                <div>
                    <h2 class="font-semibold text-xl flex items-center gap-2">
                        <i class="ti ti-calendar-stats text-2xl text-blue-600"></i>
                        Rekapitulasi Absensi Anak
                    </h2>
                    <div class="text-sm text-gray-500 flex items-center">
                        <a href="/dashboard" class="hover:text-blue-600 transition-colors">Home</a>
                        <span class="mx-2">/</span>
                        <span class="text-gray-700">Rekap Absen</span>
                    </div>
                </div>
            </div>

            <!-- Right Side -->
            <div class="flex items-center gap-4">
                <!-- Profile Dropdown -->
                @include('header-components.dd-profile')
            </div>
        </nav>
    </x-slot>

    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between mb-4">
            <div>
                <p class="font-semibold text-blue-700">Nama: {{ $student->nama }}</p>
                <p class="text-gray-600">NIS: {{ $student->nis }}</p>
            </div>
            <div>
                <a href="{{ route('dashboard.orangtua.riwayat-absensi.pdf') }}"
                    class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-xs">Download PDF</a>
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
                            <td class="py-2 px-4 border-b">{{ \Carbon\Carbon::parse($absen->tanggal)->format('d-m-Y') }}
                            </td>
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
