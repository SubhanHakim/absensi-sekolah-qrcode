{{-- filepath: resources/views/orangtuas/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <nav class="w-full flex items-center justify-between" aria-label="Global">
            <div>
                <h2 class="font-semibold text-xl">Manajemen Orang Tua</h2>
            </div>
            <div class="flex items-center gap-4">
                @include('header-components.dd-profile')
            </div>
        </nav>
    </x-slot>
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif
    <div class="overflow-x-auto rounded shadow">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
            <thead class="bg-blue-600 text-white sticky top-0 z-10">
                <tr>
                    <th class="py-3 px-4 text-left font-semibold">Nama</th>
                    <th class="py-3 px-4 text-left font-semibold">Email</th>
                    <th class="py-3 px-4 text-left font-semibold">No HP</th>
                    <th class="py-3 px-4 text-left font-semibold">Anak</th>
                    {{-- <th class="py-3 px-4 text-center font-semibold">Aksi</th> --}}
                </tr>
            </thead>
            <tbody>
                @forelse($orangtuas as $orangtua)
                <tr class="hover:bg-blue-50 even:bg-gray-50 transition">
                    <td class="py-2 px-4 border-b border-gray-200">{{ $orangtua->nama }}</td>
                    <td class="py-2 px-4 border-b border-gray-200">{{ $orangtua->no_hp ?? '-' }}</td>
                    <td class="py-2 px-4 border-b border-gray-200">{{ $orangtua->email ?? '-' }}</td>
                    <td class="py-2 px-4 border-b border-gray-200">{{ $orangtua->student->nama ?? '-' }}</td>
                    {{-- <td class="py-2 px-4 border-b border-gray-200 text-center">
                        <a href="{{ route('orangtuas.edit', $orangtua) }}" class="inline-block text-blue-600 hover:underline">Edit</a>
                        <form action="{{ route('orangtuas.destroy', $orangtua) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 ml-2 hover:underline" onclick="return confirm('Yakin hapus?')">Hapus</button>
                        </form>
                    </td> --}}
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-4 px-4 text-center text-gray-500">Belum ada data orang tua.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>