<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Edit Orang Tua</h2>
    </x-slot>
    <form action="{{ route('parents.update', $parent) }}" method="POST" class="max-w-md bg-white p-6 rounded shadow">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block mb-1">User</label>
            <select name="user_id" class="w-full border rounded px-3 py-2" required>
                <option value="">Pilih User</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" @if($parent->user_id == $user->id) selected @endif>
                        {{ $user->name }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Nama</label>
            <input type="text" name="nama" value="{{ $parent->nama }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1">No HP</label>
            <input type="text" name="no_hp" value="{{ $parent->no_hp }}" class="w-full border rounded px-3 py-2">
        </div>
        <div class="mb-4">
            <label class="block mb-1">Anak (Siswa)</label>
            <select name="student_id" class="w-full border rounded px-3 py-2" required>
                <option value="">Pilih Siswa</option>
                @foreach($students as $student)
                    <option value="{{ $student->id }}" @if($parent->student_id == $student->id) selected @endif>
                        {{ $student->user->name ?? '-' }} (NIS: {{ $student->nis }})
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
        <a href="{{ route('parents.index') }}" class="ml-2 text-gray-600">Batal</a>
    </form>
</x-app-layout>