<!-- filepath: resources/views/dashboard/guru/rekap-absen.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Rekap Absensi Hari Ini</h2>
    </x-slot>

    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-semibold mb-4">
            Daftar Siswa Kelas {{ $kelas->class_name ?? '-' }}<br>
            Tanggal: {{ \Carbon\Carbon::parse($tanggal)->format('d-m-Y') }}
        </h3>
        <table class="min-w-full border border-gray-200 rounded-lg">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="py-2 px-4">Nama</th>
                    <th class="py-2 px-4">NIS</th>
                    <th class="py-2 px-4">Status Absen</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                    <tr class="hover:bg-blue-50 even:bg-gray-50 transition">
                        <td class="py-2 px-4 border-b">{{ $student->nama }}</td>
                        <td class="py-2 px-4 border-b">{{ $student->nis }}</td>
                        <td class="py-2 px-4 border-b">
                            @if(isset($absenHariIni[$student->id]))
                                <span class="text-green-600 font-semibold">
                                    Sudah Absen ({{ $absenHariIni[$student->id]->status }})
                                </span>
                            @else
                                <span class="text-red-600 font-semibold">Belum Absen</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>