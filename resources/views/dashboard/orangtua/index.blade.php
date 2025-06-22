{{-- filepath: resources/views/dashboard/orangtua/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <nav class="w-full flex items-center justify-between" aria-label="Global">
            <div>
                <h2 class="font-semibold text-xl">Dashboard Orangtua</h2>
            </div>
            <div class="flex items-center gap-4">
                @include('header-components.dd-profile')
            </div>
        </nav>
    </x-slot>

    <div class="flex flex-col items-center justify-center min-h-[60vh] bg-gradient-to-br from-blue-100 to-blue-200 py-8">
        <!-- Welcome Banner -->
        <div
            class="w-full max-w-4xl bg-gradient-to-r from-blue-600 to-blue-400 text-white rounded-xl shadow-lg p-6 mb-6">
            <div class="flex items-center gap-4">
                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                    <i class="ti ti-hand-wave text-3xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold">Selamat Datang, {{ auth()->user()->name }}!</h3>
                    <p class="text-blue-50">Pantau perkembangan dan kehadiran anak Anda dengan mudah</p>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="w-full max-w-4xl flex flex-col md:flex-row gap-6">
            <!-- Profile Card -->
            <div class="md:w-2/3 bg-white rounded-2xl shadow-xl border border-blue-200 p-6">
                <h3 class="text-lg font-bold text-blue-700 mb-4 flex items-center gap-2">
                    <i class="ti ti-user-circle text-xl text-blue-500"></i>
                    Profil Siswa
                </h3>
                <div class="flex flex-col sm:flex-row items-center gap-6 mb-6">
                    @if (!empty($student->foto_url))
                        <img src="{{ $student->foto_url }}" alt="Foto Anak"
                            class="w-28 h-28 rounded-full border-4 border-blue-300 object-cover shadow">
                    @else
                        {{-- Avatar Initial --}}
                        @php
                            $initial = strtoupper(substr($student->nama ?? 'A', 0, 1));
                        @endphp
                        <div
                            class="w-28 h-28 rounded-full flex items-center justify-center bg-gradient-to-br from-blue-200 to-blue-400 border-4 border-blue-300 text-blue-700 text-4xl font-bold shadow select-none">
                            {{ $initial }}
                        </div>
                    @endif
                    <div class="grid grid-cols-[100px_1fr] gap-y-2 gap-x-4">
                        <div class="text-blue-600 font-semibold text-right">Nama :</div>
                        <div class="text-gray-700 font-medium">{{ $student->nama }}</div>

                        <div class="text-blue-600 font-semibold text-right">NIS :</div>
                        <div class="text-gray-700 font-medium">{{ $student->nis }}</div>

                        <div class="text-blue-600 font-semibold text-right">Kelas :</div>
                        <div class="text-gray-700 font-medium">{{ $student->kelas->class_name ?? '-' }}</div>
                    </div>
                    <!-- Statistik Kehadiran -->
                    <div class="mt-6 bg-gray-50 rounded-lg p-4 w-full">
                        <h5 class="text-sm font-semibold text-gray-600 mb-3 flex items-center gap-2">
                            <i class="ti ti-chart-bar text-blue-500"></i> Statistik Kehadiran Bulan Ini
                        </h5>

                        @php
                            $currentMonth = now()->month;
                            $hadir = \App\Models\Attendance::where('student_id', $student->id)
                                ->whereMonth('tanggal', $currentMonth)
                                ->where('status', 'hadir')
                                ->count();

                            $izin = \App\Models\Attendance::where('student_id', $student->id)
                                ->whereMonth('tanggal', $currentMonth)
                                ->where('status', 'izin')
                                ->count();

                            $sakit = \App\Models\Attendance::where('student_id', $student->id)
                                ->whereMonth('tanggal', $currentMonth)
                                ->where('status', 'sakit')
                                ->count();

                            $alpha = \App\Models\Attendance::where('student_id', $student->id)
                                ->whereMonth('tanggal', $currentMonth)
                                ->where('status', 'alpha')
                                ->count();
                        @endphp

                        <div class="grid grid-cols-4 gap-2 text-center">
                            <div class="bg-green-100 p-2 rounded">
                                <div class="text-lg font-bold text-green-700">{{ $hadir }}</div>
                                <div class="text-xs text-green-600">Hadir</div>
                            </div>
                            <div class="bg-blue-100 p-2 rounded">
                                <div class="text-lg font-bold text-blue-700">{{ $izin }}</div>
                                <div class="text-xs text-blue-600">Izin</div>
                            </div>
                            <div class="bg-yellow-100 p-2 rounded">
                                <div class="text-lg font-bold text-yellow-700">{{ $sakit }}</div>
                                <div class="text-xs text-yellow-600">Sakit</div>
                            </div>
                            <div class="bg-red-100 p-2 rounded">
                                <div class="text-lg font-bold text-red-700">{{ $alpha }}</div>
                                <div class="text-xs text-red-600">Alpha</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="md:w-1/3 flex flex-col gap-4">
                <div class="bg-white rounded-2xl shadow-xl border border-blue-200 p-6">
                    <h3 class="text-lg font-bold text-blue-700 mb-4">Menu Cepat</h3>
                    <div class="flex flex-col gap-3">
                        <a href="{{ url('dashboard/orangtua/rekap-absensi') }}"
                            class="flex items-center gap-3 p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                            <div class="bg-blue-500 text-white p-2 rounded-lg">
                                <i class="ti ti-calendar-stats text-xl"></i>
                            </div>
                            <span class="font-medium">Rekap Absensi</span>
                        </a>

                        <a href="{{ url('dashboard/orangtua/riwayat-absensi') }}"
                            class="flex items-center gap-3 p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                            <div class="bg-blue-500 text-white p-2 rounded-lg">
                                <i class="ti ti-clipboard-list text-xl"></i>
                            </div>
                            <span class="font-medium">Riwayat Absensi</span>
                        </a>
                    </div>
                </div>

                <!-- Status Hari Ini -->
                @php
                    $today = now()->toDateString();
                    $statusHariIni = isset($student)
                        ? \App\Models\Attendance::where('student_id', $student->id)->where('tanggal', $today)->first()
                        : null;
                @endphp

                <div class="bg-white rounded-2xl shadow-xl border border-blue-200 p-6">
                    <h3 class="text-lg font-bold text-blue-700 mb-4">Status Hari Ini</h3>
                    @if ($statusHariIni)
                        <div class="bg-green-100 text-green-700 p-4 rounded-lg flex items-center gap-3">
                            <i class="ti ti-check-circle text-3xl"></i>
                            <div>
                                <p class="font-bold">Sudah Absen</p>
                                <p class="text-sm">Status: {{ ucfirst($statusHariIni->status) }}</p>
                            </div>
                        </div>
                    @else
                        <div class="bg-yellow-100 text-yellow-700 p-4 rounded-lg flex items-center gap-3">
                            <i class="ti ti-alert-circle text-3xl"></i>
                            <div>
                                <p class="font-bold">Belum Absen</p>
                                <p class="text-sm">Atau data belum diperbarui</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
