<x-app-layout>
    <x-slot name="header">
       <nav class="w-full flex items-center justify-between py-2" aria-label="Global">
            <!-- Left Side -->
            <div class="flex items-center gap-4">
                <!-- Mobile Toggle Menu -->
                <div class="relative xl:hidden">
                    <button 
                        id="mobile-toggle"
                        class="text-xl cursor-pointer text-gray-700 p-2 rounded-md hover:bg-gray-100 transition-colors"
                        aria-label="Toggle navigation">
                        <i class="ti ti-menu-2 text-2xl"></i>
                    </button>
                </div>

                <!-- Page Title and Breadcrumb -->
                <div>
                    <h1 class="text-xl font-bold text-gray-800">Tambah Orang Tua</h1>
                    <div class="text-sm text-gray-500 flex items-center">
                        <a href="/dashboard" class="hover:text-blue-600 transition-colors">Home</a>
                        <span class="mx-2">/</span>
                        <span class="text-gray-700">Tambah Orang Tua</span>
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
    <form action="{{ route('orangtuas.store') }}" method="POST" class="max-w-md bg-white p-6 rounded shadow">
        @csrf
        <div class="mb-4">
            <label class="block mb-1">User</label>
            <select name="user_id" class="w-full border rounded px-3 py-2" required>
                <option value="">Pilih User</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Nama</label>
            <input type="text" name="nama" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Email</label>
            <input type="email" name="email" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1">No HP</label>
            <input type="text" name="no_hp" class="w-full border rounded px-3 py-2">
        </div>
        <div class="mb-4">
            <label class="block mb-1">Anak (Siswa)</label>
            <select name="student_id" class="w-full border rounded px-3 py-2" required>
                <option value="">Pilih Siswa</option>
                @foreach($students as $student)
                    <option value="{{ $student->id }}">{{ $student->user->name ?? '-' }} (NIS: {{ $student->nis }})</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
        <a href="{{ route('orangtuas.index') }}" class="ml-2 text-gray-600">Batal</a>
    </form>

    @if ($errors->any())
    <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</x-app-layout>