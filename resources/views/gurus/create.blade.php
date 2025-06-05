<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Tambah Guru</h2>
    </x-slot>
    <form action="{{ route('gurus.store') }}" method="POST" class="max-w-md bg-white p-6 rounded shadow">
        @csrf
        <div class="mb-4">
            <label class="block mb-1">Nama</label>
            <input type="text" name="nama" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1">NIP</label>
            <input type="text" name="nip" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Email</label>
            <input type="email" name="email" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Mapel</label>
            <input type="text" name="mapel" class="w-full border rounded px-3 py-2">
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
        <a href="{{ route('gurus.index') }}" class="ml-2 text-gray-600">Batal</a>
    </form>
</x-app-layout>