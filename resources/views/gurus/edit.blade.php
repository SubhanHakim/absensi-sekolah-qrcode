<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Edit Guru</h2>
    </x-slot>
    <form action="{{ route('gurus.update', $guru) }}" method="POST" class="max-w-md bg-white p-6 rounded shadow">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block mb-1">Nama</label>
            <input type="text" name="nama" value="{{ $guru->nama }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1">NIP</label>
            <input type="text" name="nip" value="{{ $guru->nip }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Email</label>
            <input type="email" name="email" value="{{ $guru->email }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Mapel</label>
            <input type="text" name="mapel" value="{{ $guru->mapel }}" class="w-full border rounded px-3 py-2">
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
        <a href="{{ route('gurus.index') }}" class="ml-2 text-gray-600">Batal</a>
    </form>
</x-app-layout>