{{-- filepath: resources/views/dashboard/orangtua/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl flex items-center gap-2">
            <i class="ti ti-users text-2xl text-blue-600"></i>
            Dashboard Orang Tua
        </h2>
    </x-slot>

    <div
        class="flex flex-col items-center justify-center min-h-[60vh] bg-gradient-to-br from-blue-100 to-blue-200 py-10">
        <div class="w-full max-w-xl bg-white rounded-2xl shadow-2xl border border-blue-200 p-8">
            <h3 class="text-lg font-bold text-blue-700 mb-6 flex items-center gap-2">
                <i class="ti ti-user-circle text-xl text-blue-500"></i>
                Ringkasan Profil Anak
            </h3>
            <div class="flex items-center gap-6 mb-8">
                @if (!empty($student->foto_url))
                    <img src="{{ $student->foto_url }}" alt="Foto Anak"
                        class="w-24 h-24 rounded-full border-4 border-blue-300 object-cover shadow">
                @else
                    {{-- Avatar Initial --}}
                    @php
                        $initial = strtoupper(substr($student->nama ?? 'A', 0, 1));
                    @endphp
                    <div
                        class="w-24 h-24 rounded-full flex items-center justify-center bg-gradient-to-br from-blue-200 to-blue-400 border-4 border-blue-300 text-blue-700 text-4xl font-bold shadow select-none">
                        {{ $initial }}
                    </div>
                @endif
                <div class="grid grid-cols-3 gap-y-2 gap-x-4">
                    <div class="text-blue-600 font-semibold text-right">Nama :</div>
                    <div class="col-span-2 text-gray-700">{{ $student->nama }}</div>

                    <div class="text-blue-600 font-semibold text-right">NIS :</div>
                    <div class="col-span-2 text-gray-700">{{ $student->nis }}</div>

                    <div class="text-blue-600 font-semibold text-right">Kelas :</div>
                    <div class="col-span-2 text-gray-700">{{ $student->kelas->class_name ?? '-' }}</div>
                </div>
            </div>
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-5 shadow-inner">
                <h4 class="font-semibold text-blue-600 mb-3 flex items-center gap-2">
                    <i class="ti ti-user-star text-lg text-blue-500"></i>
                    Info Wali Kelas
                </h4>
                <div class="flex flex-col gap-1">
                    <p class="text-gray-700"><span class="font-semibold text-blue-600">Nama:</span>
                        {{ $student->kelas->walikelas->nama ?? '-' }}</p>
                    <p class="text-gray-700"><span class="font-semibold text-blue-600">Kontak:</span>
                        {{ $student->kelas->walikelas->email ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
