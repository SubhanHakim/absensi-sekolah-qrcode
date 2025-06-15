{{-- filepath: resources/views/school_classes/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <nav class="w-full flex items-center justify-between" aria-label="Global">
            <div>
                <h2 class="font-semibold text-xl">Manajemen Data Kelas</h2>
            </div>
            <div class="flex items-center gap-4">
                @include('header-components.dd-profile')
            </div>
        </nav>
    </x-slot>

    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif

    <div>
        <a href="{{ route('school_classes.create') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block shadow hover:bg-blue-700 transition">Tambah
            Kelas</a>
    </div>

    <div class="overflow-x-auto rounded shadow">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
            <thead class="bg-blue-600 text-white sticky top-0 z-10">
                <tr>
                    <th class="py-3 px-4 text-left font-semibold">Nama Kelas</th>
                    <th class="py-3 px-4 text-left font-semibold">Wali Kelas</th>
                    <th class="py-3 px-4 text-center font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kelases as $class)
                    <tr class="hover:bg-blue-50 even:bg-gray-50 transition">
                        <td class="py-2 px-4 border-b border-gray-200">{{ $class->class_name }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">{{ $class->waliKelas?->nama ?? '-' }}</td>
                        <td class="py-2 px-4 border-b border-gray-200 text-center">
                            <a href="{{ route('school_classes.edit', $class) }}"
                                class="inline-block text-blue-600 hover:underline"><iconify-icon icon="mdi:pencil" width="24" height="24"></iconify-icon></a>
                            <form action="{{ route('school_classes.destroy', $class) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 ml-2 hover:underline"
                                    onclick="return confirm('Yakin hapus?')"><iconify-icon icon="mdi:trash" width="24" height="24"></iconify-icon></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="py-4 px-4 text-center text-gray-500">Belum ada data kelas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
