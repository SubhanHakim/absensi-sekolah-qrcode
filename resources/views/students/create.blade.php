<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Tambah Siswa</h2>
    </x-slot>
    <form action="{{ route('students.store') }}" method="POST" class="max-w-md bg-white p-6 rounded shadow">
        @csrf
        <div class="mb-4">
            <label class="block mb-1">User</label>
            <select name="user_id" class="w-full border rounded px-3 py-2" required>
                <option value="">Pilih User</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block mb-1">NIS</label>
            <input type="text" name="nis" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Kelas</label>
            <select name="school_class_id" class="w-full border rounded px-3 py-2">
                <option value="">Pilih Kelas</option>
                @foreach($schoolClass as $class)
                    <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block mb-1">QR Code</label>
            <input type="text" name="qr_code" class="w-full border rounded px-3 py-2">
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
        <a href="{{ route('students.index') }}" class="ml-2 text-gray-600">Batal</a>
    </form>
</x-app-layout>