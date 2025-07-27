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
                    <h1 class="text-xl font-bold text-gray-800">Edit Siswa</h1>
                    <div class="text-sm text-gray-500 flex items-center">
                        <a href="/dashboard" class="hover:text-blue-600 transition-colors">Home</a>
                        <span class="mx-2">/</span>
                        <span class="text-gray-700">Edit Siswa</span>
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
    <div class="min-h-[80vh] flex items-center justify-center bg-gray-100 py-8">
        <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-lg border border-gray-200">
            <h3 class="text-2xl font-bold mb-2 text-blue-700 text-center">Edit Siswa</h3>
            <p class="text-gray-500 mb-6 text-center">Perbarui data siswa di bawah ini.</p>

            @if ($errors->any())
                <div class="mb-6 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('students.update', $student) }}" method="POST">
                @csrf
                @method('PUT')
                <!-- Data Siswa -->
                <div class="mb-4">
                    <label class="block mb-1 font-medium text-gray-700">Nama Siswa</label>
                    <input type="text" name="nama_siswa" value="{{ old('nama_siswa', $student->nama) }}"
                        class="w-full border rounded px-3 py-2 focus:ring focus:border-blue-400" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1 font-medium text-gray-700">Email Siswa</label>
                    <input type="email" name="email" value="{{ old('email', $student->email) }}"
                        class="w-full border rounded px-3 py-2 focus:ring focus:border-blue-400" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1 font-medium text-gray-700">NIS</label>
                    <input type="text" name="nis" value="{{ old('nis', $student->nis) }}"
                        class="w-full border rounded px-3 py-2 focus:ring focus:border-blue-400" required>
                </div>
                <div class="mb-6">
                    <label class="block mb-1 font-medium text-gray-700">Kelas</label>
                    <select name="school_class_id"
                        class="w-full border rounded px-3 py-2 focus:ring focus:border-blue-400" required>
                        <option value="">Pilih Kelas</option>
                        @foreach ($schoolClass as $class)
                            <option value="{{ $class->id }}" @if (old('school_class_id', $student->school_class_id) == $class->id) selected @endif>
                                {{ $class->class_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Data Orang Tua -->
                <h3 class="text-lg font-semibold mb-2 mt-6">Data Orang Tua</h3>
                <div class="mb-4">
                    <label class="block mb-1 font-medium text-gray-700">Nama Orang Tua</label>
                    <input type="text" name="nama_orangtua" value="{{ old('nama_orangtua', $parent->nama ?? '') }}"
                        class="w-full border rounded px-3 py-2 focus:ring focus:border-blue-400" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1 font-medium text-gray-700">Email Orang Tua</label>
                    <input type="email" name="email_orangtua"
                        value="{{ old('email_orangtua', $parent->email ?? '') }}"
                        class="w-full border rounded px-3 py-2 focus:ring focus:border-blue-400" required>
                </div>
                 <div class="mb-6">
                    <label for="alamat" class="block mb-1 font-medium text-gray-700" for="no_hp_orangtua">Alamat</label>
                    <textarea name="alamat" id="alamat" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                </div>
                <div class="mb-6">
                    <label class="block mb-1 font-medium text-gray-700">No HP Orang Tua</label>
                    <input type="text" name="no_hp_orangtua"
                        value="{{ old('no_hp_orangtua', $parent->no_hp ?? '') }}"
                        class="w-full border rounded px-3 py-2 focus:ring focus:border-blue-400" required>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Update</button>
                <a href="{{ route('students.index') }}"
                    class="block text-center mt-3 text-gray-600 hover:underline">Batal</a>
            </form>
        </div>
    </div>
</x-app-layout>
