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
    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
        <!-- Table Header -->
        <div class="p-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
            <h3 class="font-semibold text-gray-700">Data Orang Tua</h3>
        </div>

        <!-- Table Content -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-blue-600 to-blue-500">
                    <tr>
                        <th class="py-3 px-4 text-left text-xs font-medium text-white uppercase tracking-wider">
                            <div class="flex items-center gap-1">
                                <span>Nama</span>
                                <i class="ti ti-chevron-down text-xs opacity-70"></i>
                            </div>
                        </th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-white uppercase tracking-wider">Email
                        </th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-white uppercase tracking-wider">No HP
                        </th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-white uppercase tracking-wider">Anak
                        </th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-white uppercase tracking-wider">Alamat
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($orangtuas as $orangtua)
                        <tr class="hover:bg-blue-50 transition-colors duration-150">
                            <td class="py-3 px-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="flex-shrink-0 h-9 w-9 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-semibold">
                                        {{ strtoupper(substr($orangtua->nama, 0, 1)) }}
                                    </div>
                                    <div class="font-medium text-gray-900">{{ $orangtua->nama }}</div>
                                </div>
                            </td>
                            <td class="py-3 px-4 whitespace-nowrap">
                                @if ($orangtua->email)
                                    <div class="flex items-center gap-2">
                                        <i class="ti ti-mail text-gray-900"></i>
                                        <span class="text-gray-900">{{ $orangtua->email }}</span>
                                    </div>
                                @else
                                    <span class="text-gray-900 text-sm">Tidak ada</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 whitespace-nowrap">
                                @if ($orangtua->no_hp)
                                    <div class="flex items-center gap-2">
                                        <i class="ti ti-phone text-gray-900"></i>
                                        <span class="text-gray-900">{{ $orangtua->no_hp }}</span>
                                    </div>
                                @else
                                    <span class="text-gray-900 text-sm">Tidak ada</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 whitespace-nowrap">
                                @if (isset($orangtua->student->nama))
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $orangtua->student->nama }}
                                    </span>
                                @else
                                    <span class="text-gray-900 text-sm">Tidak ada</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 whitespace-nowrap">
                                @if ($orangtua->alamat)
                                    <div class="flex items-center gap-2">
                                        <i class="ti ti-map-pin text-gray-900"></i>
                                        <span
                                            class="text-gray-900 text-sm">{{ Str::limit($orangtua->alamat, 30) }}</span>
                                    </div>
                                @else
                                    <span class="text-gray-900 text-sm">Tidak ada</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 px-4">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="bg-gray-100 rounded-full p-3 mb-2">
                                        <i class="ti ti-users-off text-3xl text-gray-900"></i>
                                    </div>
                                    <p class="text-gray-500 text-center">Belum ada data orang tua.</p>
                                    <p class="text-gray-900 text-sm mt-1">Silahkan tambahkan data orang tua terlebih
                                        dahulu.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Table Footer with Pagination -->
        @if ($orangtuas->count() > 0)
            <div class="px-4 py-3 bg-gray-50 border-t border-gray-200 sm:px-6 flex items-center justify-between">
                <div class="text-sm text-gray-500">
                    Menampilkan {{ $orangtuas->count() }} data
                </div>
                <div class="flex gap-1">
                    <button
                        class="inline-flex items-center px-3 py-1 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                        <i class="ti ti-chevron-left mr-1"></i>
                        Sebelumnya
                    </button>
                    <button
                        class="inline-flex items-center px-3 py-1 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                        Selanjutnya
                        <i class="ti ti-chevron-right ml-1"></i>
                    </button>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
