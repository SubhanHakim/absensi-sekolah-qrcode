<!-- filepath: resources/views/dashboard/guru/rekap-absen.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <nav class="w-full flex items-center justify-between" aria-label="Global">
            <div>
                <h2 class="font-semibold text-xl flex items-center gap-2">
                    <i class="ti ti-clipboard-list text-2xl text-blue-600"></i>
                    Rekap Absensi
                </h2>
            </div>
            <div class="flex items-center gap-4">
                @include('header-components.dd-profile')
            </div>
        </nav>
    </x-slot>

    <div class="flex flex-col items-center justify-center min-h-[70vh] bg-gradient-to-br from-blue-50 to-blue-100 py-8">
        <div class="w-full max-w-3xl bg-white rounded-xl shadow-lg border border-blue-200 p-8">
            <form method="GET" class="mb-6 flex flex-wrap gap-2 items-center">
                <label for="tanggal" class="font-semibold">Tanggal:</label>
                <input type="date" id="tanggal" name="tanggal" value="{{ request('tanggal', $tanggal) }}" class="border rounded px-2 py-1">
                <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">Lihat</button>

                <label for="periode" class="ml-4 font-semibold">Periode:</label>
                <select name="periode" id="periode" class="border rounded px-2 py-1">
                    <option value="harian" {{ request('periode', $periode) == 'harian' ? 'selected' : '' }}>Harian</option>
                    <option value="mingguan" {{ request('periode', $periode) == 'mingguan' ? 'selected' : '' }}>Mingguan</option>
                    <option value="bulanan" {{ request('periode', $periode) == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                </select>
            </form>

            <h3 class="text-lg font-semibold text-blue-700 mb-2">
                Daftar Siswa Kelas {{ $kelas->class_name ?? '-' }}
            </h3>
            <p class="text-gray-500 mb-6">
                @if($periode == 'harian')
                    Tanggal: <span class="font-semibold">{{ \Carbon\Carbon::parse($tanggal)->format('d-m-Y') }}</span>
                @elseif($periode == 'mingguan')
                    Minggu: <span class="font-semibold">
                        {{ \Carbon\Carbon::parse($tanggal)->startOfWeek()->format('d-m-Y') }} s/d {{ \Carbon\Carbon::parse($tanggal)->endOfWeek()->format('d-m-Y') }}
                    </span>
                @elseif($periode == 'bulanan')
                    Bulan: <span class="font-semibold">
                        {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('F Y') }}
                    </span>
                @endif
            </p>
            <div class="overflow-x-auto rounded-lg">
                <table class="min-w-full text-sm border border-gray-200 rounded-lg shadow">
                    <thead class="bg-blue-600 text-white">
                        <tr>
                            <th class="py-3 px-4 text-left rounded-tl-lg">Nama</th>
                            <th class="py-3 px-4 text-left">NIS</th>
                            <th class="py-3 px-4 text-left rounded-tr-lg">Status Absen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            <tr class="hover:bg-blue-50 even:bg-gray-50 transition">
                                <td class="py-2 px-4 border-b border-gray-200">{{ $student->nama }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $student->nis }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">
                                    @if($periode == 'harian')
                                        @if(isset($absensi[$student->id]) && $absensi[$student->id]->where('tanggal', $tanggal)->count())
                                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded bg-green-100 text-green-700 font-semibold text-xs">
                                                <i class="ti ti-check text-base"></i>
                                                Sudah Absen ({{ ucfirst($absensi[$student->id]->where('tanggal', $tanggal)->first()->status) }})
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded bg-red-100 text-red-700 font-semibold text-xs">
                                                <i class="ti ti-x text-base"></i>
                                                Belum Absen
                                            </span>
                                        @endif
                                    @else
                                        @php
                                            $count = isset($absensi[$student->id]) ? $absensi[$student->id]->count() : 0;
                                            $hadirDates = isset($absensi[$student->id]) ? $absensi[$student->id]->pluck('tanggal')->map(fn($tgl) => \Carbon\Carbon::parse($tgl)->format('d-m-Y'))->implode(', ') : '';
                                        @endphp
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded bg-blue-100 text-blue-700 font-semibold text-xs" title="Tanggal hadir: {{ $hadirDates }}">
                                            <i class="ti ti-calendar-stats text-base"></i>
                                            {{ $count }} x Hadir
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