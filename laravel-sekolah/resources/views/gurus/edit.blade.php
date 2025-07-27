<x-app-layout>
    <x-slot name="header">
        <nav class="w-full flex items-center justify-between" aria-label="Global">
            <div>
                <h2 class="font-semibold text-xl">Edit Guru</h2>
            </div>
            <div class="flex items-center gap-4">
                @include('header-components.dd-profile')
            </div>
        </nav>
    </x-slot>
    <div class="min-h-[80vh] flex items-center justify-center bg-gray-100 py-8">
        <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-lg border border-gray-200">
            <h3 class="text-2xl font-bold mb-2 text-blue-700 text-center">Edit Guru</h3>
            <p class="text-gray-500 mb-6 text-center">Perbarui data guru di bawah ini.</p>

            @if ($errors->any())
                <div class="mb-6 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('gurus.update', $guru) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block mb-1 font-medium text-gray-700">Nama</label>
                    <input type="text" name="nama" value="{{ $guru->nama }}" class="w-full border rounded px-3 py-2 focus:ring focus:border-blue-400" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1 font-medium text-gray-700">NIP</label>
                    <input type="text" name="nip" value="{{ $guru->nip }}" class="w-full border rounded px-3 py-2 focus:ring focus:border-blue-400" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1 font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ $guru->email }}" class="w-full border rounded px-3 py-2 focus:ring focus:border-blue-400" required>
                </div>
                <div class="mb-6">
                    <label class="block mb-1 font-medium text-gray-700">Mapel</label>
                    <input type="text" name="mapel" value="{{ $guru->mapel }}" class="w-full border rounded px-3 py-2 focus:ring focus:border-blue-400">
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Update</button>
                <a href="{{ route('gurus.index') }}" class="block text-center mt-3 text-gray-600 hover:underline">Batal</a>
            </form>
        </div>
    </div>
</x-app-layout>