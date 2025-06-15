<x-app-layout>
     <x-slot name="header">
        <nav class="w-full flex items-center justify-between" aria-label="Global">
            <div>
                <h2 class="font-semibold text-xl">Tambah Siswa dan Orang Tua</h2>
            </div>
            <div class="flex items-center gap-4">
                @include('header-components.dd-profile')
            </div>
        </nav>
    </x-slot>
    <div class="min-h-[80vh] flex items-center justify-center bg-gray-100 py-8">
        <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-lg border border-gray-200">
            <h3 class="text-2xl font-bold mb-2 text-blue-700 text-center">Tambah Siswa</h3>
            <p class="text-gray-500 mb-6 text-center">Silakan isi data siswa dan orang tua dengan benar.</p>

            @if ($errors->any())
                <div class="mb-6 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('students.store') }}" method="POST">
                @csrf

                <h3 class="text-lg font-semibold mb-2">Data Siswa</h3>
                <div class="mb-4">
                    <label class="block mb-1 font-medium text-gray-700" for="nama_siswa">Nama Siswa</label>
                    <input type="text" id="nama_siswa" name="nama_siswa" class="w-full border rounded px-3 py-2 focus:ring focus:border-blue-400" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1 font-medium text-gray-700" for="nis">NIS</label>
                    <input type="text" id="nis" name="nis" class="w-full border rounded px-3 py-2 focus:ring focus:border-blue-400" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1 font-medium text-gray-700" for="email">Email Siswa</label>
                    <input type="email" id="email" name="email" class="w-full border rounded px-3 py-2 focus:ring focus:border-blue-400" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1 font-medium text-gray-700" for="school_class_id">Kelas</label>
                    <select id="school_class_id" name="school_class_id" class="w-full border rounded px-3 py-2 focus:ring focus:border-blue-400" required>
                        <option value="">Pilih Kelas</option>
                        @foreach ($schoolClass as $class)
                            <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                        @endforeach
                    </select>
                </div>

                <h3 class="text-lg font-semibold mb-2 mt-6">Data Orang Tua</h3>
                <div class="mb-4">
                    <label class="block mb-1 font-medium text-gray-700" for="nama_orangtua">Nama Orang Tua</label>
                    <input type="text" id="nama_orangtua" name="nama_orangtua" class="w-full border rounded px-3 py-2 focus:ring focus:border-blue-400" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1 font-medium text-gray-700" for="email_orangtua">Email Orang Tua</label>
                    <input type="email" id="email_orangtua" name="email_orangtua" class="w-full border rounded px-3 py-2 focus:ring focus:border-blue-400" required>
                </div>
                <div class="mb-6">
                    <label class="block mb-1 font-medium text-gray-700" for="no_hp_orangtua">No HP Orang Tua</label>
                    <input type="text" id="no_hp_orangtua" name="no_hp_orangtua" class="w-full border rounded px-3 py-2 focus:ring focus:border-blue-400" required>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Simpan</button>
                <a href="{{ route('students.index') }}" class="block text-center mt-3 text-gray-600 hover:underline">Batal</a>
            </form>
        </div>
    </div>
</x-app-layout>