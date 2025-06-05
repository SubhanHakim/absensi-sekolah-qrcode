{{-- filepath: resources/views/orangtuas/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Manajemen Data Orang Tua</h2>
    </x-slot>
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif

<form action="{{ route('orangtuas.import') }}" method="POST" enctype="multipart/form-data" class="mb-4">
        @csrf
        <input type="file" name="csv_file" accept=".csv" required>
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Import CSV</button>
    </form>


    <a href="{{ route('orangtuas.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">Tambah Orang Tua</a>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded shadow">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Nama</th>
                    <th>No HP</th>
                    <th>Anak</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orangtuas as $orangtua)
                <tr>
                    <td>{{ $orangtua->user->name ?? '-' }}</td>
                    <td>{{ $orangtua->nama }}</td>
                    <td>{{ $orangtua->no_hp ?? '-' }}</td>
                    <td>{{ $orangtua->student->user->name ?? '-' }}</td>
                    <td>
                        <a href="{{ route('orangtuas.edit', $orangtua) }}" class="text-blue-600">Edit</a>
                        <form action="{{ route('orangtuas.destroy', $orangtua) }}" method="POST" class="inline">
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