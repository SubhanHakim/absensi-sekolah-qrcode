<!-- filepath: resources/views/dashboard/petugas/rekap-absen.blade.php -->
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
                <div class="w-full flex flex-wrap gap-2 items-center mb-3">
                    <label for="kelas_id" class="font-semibold">Kelas:</label>
                    <select name="kelas_id" id="kelas_id" class="border rounded px-2 py-1">
                        <option value="">Semua Kelas</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ request('kelas_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->class_name ?? 'Kelas '.$class->id }}
                            </option>
                        @endforeach
                    </select>
                    
                    <label for="tanggal" class="ml-4 font-semibold">Tanggal:</label>
                    <input type="date" id="tanggal" name="tanggal" value="{{ request('tanggal', $tanggal) }}" class="border rounded px-2 py-1">
                    
                    <button type="submit" class="ml-4 bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">Tampilkan</button>
                </div>
            </form>

            <h3 class="text-lg font-semibold text-blue-700 mb-2">
                Daftar Siswa {{ $kelas->class_name ?? 'Semua Kelas' }}
            </h3>
            <p class="text-gray-500 mb-6">
                Tanggal: <span class="font-semibold">{{ \Carbon\Carbon::parse($tanggal)->format('d-m-Y') }}</span>
            </p>
            
            <div class="overflow-x-auto rounded-lg">
                <table class="min-w-full text-sm border border-gray-200 rounded-lg shadow">
                    <thead class="bg-blue-600 text-white">
                        <tr>
                            <th class="py-3 px-4 text-left rounded-tl-lg">Nama</th>
                            <th class="py-3 px-4 text-left">NIS</th>
                            @if(!$kelas)
                                <th class="py-3 px-4 text-left">Kelas</th>
                            @endif
                            <th class="py-3 px-4 text-left rounded-tr-lg">Status Absen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            <tr class="hover:bg-blue-50 even:bg-gray-50 transition">
                                <td class="py-2 px-4 border-b border-gray-200">{{ $student->nama }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $student->nis }}</td>
                                @if(!$kelas)
                                    <td class="py-2 px-4 border-b border-gray-200">{{ $student->kelas }}</td>
                                @endif
                                <td class="py-2 px-4 border-b border-gray-200">
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
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>