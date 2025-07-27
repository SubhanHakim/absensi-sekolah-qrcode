<!-- filepath: d:\project\client\qrcode-sekolah\resources\views\dashboard\petugas\rekap-absen.blade.php -->
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
                        <i class="ti ti-clipboard-list text-2xl text-blue-600"></i>
                        Rekap Absensi
                    </h2>
                    <div class="text-sm text-gray-500 flex items-center">
                        <a href="/dashboard" class="hover:text-blue-600 transition-colors">Home</a>
                        <span class="mx-2">/</span>
                        <span class="text-gray-700">Rekap Absensi Siswa</span>
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

    <div class="flex flex-col items-center justify-center min-h-[70vh] bg-gradient-to-br from-blue-50 to-blue-100 py-8">
        <div class="w-full max-w-5xl bg-white rounded-xl shadow-lg border border-blue-200 p-8">
            <!-- Form dengan range tanggal -->
            <form method="GET" class="mb-6 flex flex-wrap gap-4 items-center">
                <div class="flex items-center gap-2">
                    <label for="kelas_id" class="font-semibold">Kelas:</label>
                    <select name="kelas_id" id="kelas_id" class="border rounded px-2 py-1">
                        <option value="">Semua Kelas</option>
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}"
                                {{ request('kelas_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->class_name ?? 'Kelas ' . $class->id }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center gap-2">
                    <label for="tanggal_dari" class="font-semibold">Dari Tanggal:</label>
                    <input type="date" id="tanggal_dari" name="tanggal_dari"
                        value="{{ request('tanggal_dari', $tanggalDari ?? now()->toDateString()) }}"
                        class="border rounded px-2 py-1">
                </div>

                <div class="flex items-center gap-2">
                    <label for="tanggal_sampai" class="font-semibold">Sampai Tanggal:</label>
                    <input type="date" id="tanggal_sampai" name="tanggal_sampai"
                        value="{{ request('tanggal_sampai', $tanggalSampai ?? now()->toDateString()) }}"
                        class="border rounded px-2 py-1">
                </div>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Lihat
                </button>
            </form>

            <h3 class="text-lg font-semibold text-blue-700 mb-2">
                Daftar Siswa Kelas {{ $kelas->class_name ?? 'Semua Kelas' }}
            </h3>
            <!-- Info periode menampilkan range tanggal -->
            <p class="text-gray-500 mb-6">
                Periode: <span class="font-semibold">
                    {{ \Carbon\Carbon::parse($tanggalDari ?? now()->toDateString())->format('d-m-Y') }}
                    sampai
                    {{ \Carbon\Carbon::parse($tanggalSampai ?? now()->toDateString())->format('d-m-Y') }}
                </span>
            </p>

            <!-- Tabel dengan logika range tanggal -->
            <div class="overflow-x-auto rounded-lg">
                <table class="min-w-full text-sm border border-gray-200 rounded-lg shadow">
                    <thead class="bg-blue-600 text-white">
                        <tr>
                            <th class="py-3 px-4 text-left rounded-tl-lg">Nama</th>
                            <th class="py-3 px-4 text-left">NIS</th>
                            @if (!$kelas)
                                <th class="py-3 px-4 text-left">Kelas</th>
                            @endif
                            <th class="py-3 px-4 text-left rounded-tr-lg">Status Absen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr class="hover:bg-blue-50 even:bg-gray-50 transition">
                                <td class="py-2 px-4 border-b border-gray-200">{{ $student->nama }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $student->nis }}</td>
                                @if (!$kelas)
                                    <td class="py-2 px-4 border-b border-gray-200">{{ $student->kelas }}</td>
                                @endif
                                <td class="py-2 px-4 border-b border-gray-200">
                                    @php
                                        $studentAbsensi = isset($absensi[$student->id])
                                            ? $absensi[$student->id]
                                            : collect();

                                        // Hitung berdasarkan status
                                        $hadirCount = $studentAbsensi->where('status', 'hadir')->count();
                                        $telatCount = $studentAbsensi->where('status', 'telat')->count();
                                        $izinCount = $studentAbsensi->where('status', 'izin')->count();
                                        $sakitCount = $studentAbsensi->where('status', 'sakit')->count();
                                        $alphaCount = $studentAbsensi->where('status', 'alpha')->count();
                                        $totalAbsen = $studentAbsensi->count();

                                        $hadirDates = $studentAbsensi
                                            ->pluck('tanggal')
                                            ->map(fn($tgl) => \Carbon\Carbon::parse($tgl)->format('d-m-Y'))
                                            ->implode(', ');
                                    @endphp

                                    @if ($totalAbsen > 0)
                                        <div class="space-y-1">
                                            @if ($hadirCount > 0)
                                                <span
                                                    class="inline-flex items-center gap-1 px-2 py-1 rounded bg-green-100 text-green-700 font-semibold text-xs mr-1 mb-1">
                                                    <i class="ti ti-check text-base"></i>
                                                    Hadir: {{ $hadirCount }}x
                                                </span>
                                            @endif

                                            @if ($telatCount > 0)
                                                <span
                                                    class="inline-flex items-center gap-1 px-2 py-1 rounded bg-yellow-100 text-yellow-700 font-semibold text-xs mr-1 mb-1">
                                                    <i class="ti ti-clock text-base"></i>
                                                    Telat: {{ $telatCount }}x
                                                </span>
                                            @endif

                                            @if ($izinCount > 0)
                                                <span
                                                    class="inline-flex items-center gap-1 px-2 py-1 rounded bg-blue-100 text-blue-700 font-semibold text-xs mr-1 mb-1">
                                                    <i class="ti ti-clipboard-check text-base"></i>
                                                    Izin: {{ $izinCount }}x
                                                </span>
                                            @endif

                                            @if ($sakitCount > 0)
                                                <span
                                                    class="inline-flex items-center gap-1 px-2 py-1 rounded bg-orange-100 text-orange-700 font-semibold text-xs mr-1 mb-1">
                                                    <i class="ti ti-medical-cross text-base"></i>
                                                    Sakit: {{ $sakitCount }}x
                                                </span>
                                            @endif

                                            @if ($alphaCount > 0)
                                                <span
                                                    class="inline-flex items-center gap-1 px-2 py-1 rounded bg-red-100 text-red-700 font-semibold text-xs mr-1 mb-1">
                                                    <i class="ti ti-user-x text-base"></i>
                                                    Alpha: {{ $alphaCount }}x
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Total dan tooltip -->
                                        <div class="text-xs text-gray-500 mt-2" title="Tanggal: {{ $hadirDates }}">
                                            Total: {{ $totalAbsen }} hari
                                        </div>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-1 rounded bg-red-100 text-red-700 font-semibold text-xs">
                                            <i class="ti ti-x text-base"></i>
                                            Tidak Ada Absen
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
