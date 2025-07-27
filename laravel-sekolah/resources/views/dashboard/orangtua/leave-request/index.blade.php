{{-- resources/views/dashboard/orangtua/leave-requests/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <nav class="w-full flex items-center justify-between py-2 gap-4" aria-label="Global">
            <!-- Left Side -->
            <div class="flex items-center gap-2 sm:gap-4 flex-1 min-w-0">
                <!-- Mobile Toggle -->
                <div class="xl:hidden">
                    <button id="mobile-toggle" class="text-gray-700 p-2 rounded-md hover:bg-gray-100 transition-colors">
                        <i class="ti ti-menu-2 text-xl"></i>
                    </button>
                </div>

                <!-- Title & Breadcrumb -->
                <div class="min-w-0 flex-1">
                    <h2 class="font-semibold text-gray-800 truncate">
                        <span class="text-lg sm:text-xl hidden sm:block">Riwayat Pengajuan Izin/Sakit</span>
                        <span class="text-base sm:hidden">Riwayat Izin</span>
                    </h2>

                    <div class="text-xs sm:text-sm text-gray-500 flex items-center mt-0.5">
                        <a href="/dashboard" class="hover:text-blue-600 transition-colors">
                            <i class="ti ti-home sm:hidden"></i>
                            <span class="hidden sm:inline">Home</span>
                        </a>
                        <span class="mx-1 sm:mx-2">/</span>
                        <span class="text-gray-700 truncate">Riwayat</span>
                    </div>
                </div>
            </div>

            <!-- Right Side -->
            <div class="flex items-center gap-2 sm:gap-4 flex-shrink-0">
                <!-- Action Button -->
                <a href="{{ route('dashboard.orangtua.leave-request.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-3 sm:px-4 rounded text-sm transition-colors flex items-center gap-1 sm:gap-2">
                    <i class="ti ti-plus"></i>
                    <span class="hidden xs:inline">Ajukan</span>
                    <span class="hidden sm:inline">Baru</span>
                </a>

                @include('header-components.dd-profile')
            </div>
        </nav>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if ($leaveRequests->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr>
                                        <th class="py-3 px-4 bg-gray-100 font-semibold text-left">Tanggal Pengajuan</th>
                                        <th class="py-3 px-4 bg-gray-100 font-semibold text-left">Periode</th>
                                        <th class="py-3 px-4 bg-gray-100 font-semibold text-left">Jenis</th>
                                        <th class="py-3 px-4 bg-gray-100 font-semibold text-left">Alasan</th>
                                        <th class="py-3 px-4 bg-gray-100 font-semibold text-left">Status</th>
                                        <th class="py-3 px-4 bg-gray-100 font-semibold text-left">Catatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($leaveRequests as $leave)
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="py-3 px-4">{{ $leave->created_at->format('d M Y') }}</td>
                                            <td class="py-3 px-4">
                                                {{ $leave->from_date->format('d M Y') }}
                                                @if ($leave->to_date->ne($leave->from_date))
                                                    - {{ $leave->to_date->format('d M Y') }}
                                                @endif
                                            </td>
                                            <td class="py-3 px-4">
                                                <span
                                                    class="px-2 py-1 rounded text-xs font-semibold 
                                                    {{ $leave->type == 'sakit' ? 'bg-orange-100 text-orange-700' : 'bg-blue-100 text-blue-700' }}">
                                                    {{ ucfirst($leave->type) }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-4">{{ Str::limit($leave->reason, 50) }}</td>
                                            <td class="py-3 px-4">
                                                @if ($leave->status == 'pending')
                                                    <span
                                                        class="px-2 py-1 rounded text-xs font-semibold bg-yellow-100 text-yellow-700">Menunggu</span>
                                                @elseif($leave->status == 'approved')
                                                    <span
                                                        class="px-2 py-1 rounded text-xs font-semibold bg-green-100 text-green-700">Disetujui</span>
                                                @else
                                                    <span
                                                        class="px-2 py-1 rounded text-xs font-semibold bg-red-100 text-red-700">Ditolak</span>
                                                @endif
                                            </td>
                                            <td class="py-3 px-4">{{ $leave->notes ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="bg-gray-50 p-4 rounded text-center text-gray-500">
                            Belum ada pengajuan izin/sakit.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
