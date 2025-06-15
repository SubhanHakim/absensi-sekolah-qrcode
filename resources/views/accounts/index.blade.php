<x-app-layout>
       <x-slot name="header">
        <nav class="w-full flex items-center justify-between" aria-label="Global">
            <div>
                <h2 class="font-semibold text-xl">Manajemen Akun</h2>
            </div>
            <div class="flex items-center gap-4">
                @include('header-components.dd-profile')
            </div>
        </nav>
    </x-slot>
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Guru --}}
        <div class="bg-white rounded-lg shadow p-4">
            <h3 class="font-semibold text-lg mb-4 text-blue-700 flex items-center gap-2">
                <i class="ti ti-user"></i> Guru
            </h3>
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 rounded-lg">
                    <thead class="bg-blue-600 text-white sticky top-0 z-10">
                        <tr>
                            <th class="py-2 px-4 text-left font-semibold">Nama</th>
                            <th class="py-2 px-4 text-left font-semibold">Email</th>
                            <th class="py-2 px-4 text-center font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($gurus as $guru)
                        <tr class="hover:bg-blue-50 even:bg-gray-50 transition">
                            <td class="py-2 px-4 border-b border-gray-200">{{ $guru->nama }}</td>
                            <td class="py-2 px-4 border-b border-gray-200">{{ $guru->email }}</td>
                            <td class="py-2 px-4 border-b border-gray-200 text-center">
                                <form action="{{ route('accounts.createGuru', $guru) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded shadow hover:bg-blue-700 transition">Buat Akun</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="py-3 px-4 text-center text-gray-500">Semua guru sudah punya akun.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Siswa --}}
        {{-- <div class="bg-white rounded-lg shadow p-4">
            <h3 class="font-semibold text-lg mb-4 text-blue-700 flex items-center gap-2">
                <i class="ti ti-users"></i> Siswa
            </h3>
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 rounded-lg">
                    <thead class="bg-blue-600 text-white sticky top-0 z-10">
                        <tr>
                            <th class="py-2 px-4 text-left font-semibold">Nama</th>
                            <th class="py-2 px-4 text-left font-semibold">Email</th>
                            <th class="py-2 px-4 text-center font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)
                        <tr class="hover:bg-blue-50 even:bg-gray-50 transition">
                            <td class="py-2 px-4 border-b border-gray-200">{{ $student->nama }}</td>
                            <td class="py-2 px-4 border-b border-gray-200">{{ $student->email }}</td>
                            <td class="py-2 px-4 border-b border-gray-200 text-center">
                                <form action="{{ route('accounts.createSiswa', $student) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded shadow hover:bg-blue-700 transition">Buat Akun</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="py-3 px-4 text-center text-gray-500">Semua siswa sudah punya akun.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div> --}}

        {{-- Orang Tua --}}
        <div class="bg-white rounded-lg shadow p-4 md:col-span-2">
            <h3 class="font-semibold text-lg mb-4 text-blue-700 flex items-center gap-2">
                <i class="ti ti-user-shield"></i> Orang Tua
            </h3>
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 rounded-lg">
                    <thead class="bg-blue-600 text-white sticky top-0 z-10">
                        <tr>
                            <th class="py-2 px-4 text-left font-semibold">Nama</th>
                            <th class="py-2 px-4 text-left font-semibold">Email</th>
                            <th class="py-2 px-4 text-center font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($parents as $parent)
                        <tr class="hover:bg-blue-50 even:bg-gray-50 transition">
                            <td class="py-2 px-4 border-b border-gray-200">{{ $parent->nama }}</td>
                            <td class="py-2 px-4 border-b border-gray-200">{{ $parent->email }}</td>
                            <td class="py-2 px-4 border-b border-gray-200 text-center">
                                <form action="{{ route('accounts.createParent', $parent) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded shadow hover:bg-blue-700 transition">Buat Akun</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="py-3 px-4 text-center text-gray-500">Semua orang tua sudah punya akun.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>