<x-app-layout>
    <x-slot name="header">
        <nav class="w-full flex items-center justify-between" aria-label="Global">
            <div>
                <h2 class="font-semibold text-xl">Manajemen Data Guru</h2>
            </div>
            <div class="flex items-center gap-4">
                @include('header-components.dd-profile')
            </div>
        </nav>
    </x-slot>
    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif
    <div class="flex justify-between items-center mb-4">
        <a href="{{ route('gurus.create') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition flex items-center gap-2">
            <iconify-icon icon="mdi:account-plus" width="22" height="22"></iconify-icon>
            Tambah Guru
        </a>
    </div>
    <div class="overflow-x-auto rounded shadow">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
            <thead class="bg-blue-600 text-white sticky top-0 z-10">
                <tr>
                    <th class="py-3 px-4 text-left font-semibold">Nama</th>
                    <th class="py-3 px-4 text-left font-semibold">NIP</th>
                    <th class="py-3 px-4 text-left font-semibold">Email</th>
                    <th class="py-3 px-4 text-left font-semibold">Mapel</th>
                    <th class="py-3 px-4 text-center font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($gurus as $guru)
                    <tr class="hover:bg-blue-50 even:bg-gray-50 transition">
                        <td class="py-2 px-4 border-b border-gray-200">{{ $guru->nama }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">{{ $guru->nip }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">{{ $guru->email }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">{{ $guru->mapel }}</td>
                        <td class="py-2 px-4 border-b border-gray-200 text-center">
                            <a href="{{ route('gurus.edit', $guru) }}"
                                class="inline-block text-blue-600 hover:underline"><iconify-icon icon="mdi:pencil"
                                    width="24" height="24"></iconify-icon></a>
                            <form action="{{ route('gurus.destroy', $guru) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 ml-2 hover:underline"
                                    onclick="return confirm('Yakin hapus?')"><iconify-icon icon="mdi:trash"
                                        width="24" height="24"></iconify-icon></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-4 px-4 text-center text-gray-500">Belum ada data guru.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
