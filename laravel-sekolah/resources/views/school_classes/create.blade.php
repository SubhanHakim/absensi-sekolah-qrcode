{{-- filepath: resources/views/school_classes/create.blade.php --}}
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
                    <h1 class="text-xl font-bold text-gray-800">Tambah Kelas</h1>
                    <div class="text-sm text-gray-500 flex items-center">
                        <a href="/dashboard" class="hover:text-blue-600 transition-colors">Home</a>
                        <span class="mx-2">/</span>
                        <span class="text-gray-700">Tambah Kelas</span>
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
            <h3 class="text-2xl font-bold mb-2 text-blue-700 text-center">Tambah Kelas</h3>
            <p class="text-gray-500 mb-6 text-center">Silakan isi data kelas dengan benar.</p>

            @if ($errors->any())
                <div class="mb-6 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('school_classes.store') }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block mb-1 font-medium text-gray-700">Nama Kelas</label>
                    <input type="text" name="class_name"
                        class="w-full border rounded px-3 py-2 focus:ring focus:border-blue-400" required>
                </div>
                <button type="submit"
                    class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Simpan</button>
                <a href="{{ route('school_classes.index') }}"
                    class="block text-center mt-3 text-gray-600 hover:underline">Batal</a>
            </form>
        </div>
    </div>
</x-app-layout>