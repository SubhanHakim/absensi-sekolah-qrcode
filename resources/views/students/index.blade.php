<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Manajemen Data Siswa</h2>
    </x-slot>
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif
    <a href="{{ route('students.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">Tambah Siswa</a>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded shadow">
            <thead>
                <tr>
                    <th>User</th>
                    <th>NIS</th>
                    <th>Kelas</th>
                    <th>QR Code</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                <tr>
                    <td>{{ $student->user->name ?? '-' }}</td>
                    <td>{{ $student->nis }}</td>
                    <td>{{ $student->schoolClass->class_name ?? $student->kelas }}</td>
                    <td>{{ $student->qr_code }}</td>
                    <td>
                        <a href="{{ route('students.edit', $student) }}" class="text-blue-600">Edit</a>
                        <form action="{{ route('students.destroy', $student) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 ml-2" onclick="return confirm('Yakin hapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>