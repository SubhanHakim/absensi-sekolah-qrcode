<div class="p-4 text-center">
    <div class="flex justify-center mb-3">
        <img src="{{ asset('images/logo.png') }}" alt="Logo Sekolah" class="h-14 w-auto">
    </div>
    <h1 class="text-3xl uppercase font-semibold">Guru</h1>
</div>
<div class="scroll-sidebar" data-simplebar="">
    <nav class="w-full flex flex-col sidebar-nav px-4 mt-5">
        <ul id="sidebarnav" class="text-gray-600 text-sm">
            <li class="text-xs font-bold pb-[5px]">
                <i class="ti ti-dots nav-small-cap-icon text-lg hidden text-center"></i>
                <span class="text-xs text-gray-400 font-semibold">HOME</span>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link gap-3 py-2.5 my-1 text-base flex items-center relative rounded-md w-full
                    {{ request()->is('dashboard/guru') ? 'bg-blue-100 text-blue-700' : 'text-gray-500' }}"
                    href="{{ url('dashboard/guru') }}">
                    <i class="ti ti-layout-dashboard ps-2 text-2xl"></i> <span>Dashboard</span>
                </a>
            </li>

            <li class="text-xs font-bold mb-4 mt-6">
                <i class="ti ti-dots nav-small-cap-icon text-lg hidden text-center"></i>
                <span class="text-xs text-gray-400 font-semibold">MANAJEMEN</span>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link gap-3 py-2.5 my-1 text-base flex items-center relative rounded-md w-full
                    {{ request()->is('dashboard/guru/scan-absen*') ? 'bg-blue-100 text-blue-700' : 'text-gray-500' }}"
                    href="{{ url('dashboard/guru/scan-absen') }}">
                    <i class="ti ti-qrcode ps-2 text-2xl"></i> <span>Absensi Siswa (Scan)</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link gap-3 py-2.5 my-1 text-base flex items-center relative rounded-md w-full
                    {{ request()->is('dashboard/guru/rekap-absen*') ? 'bg-blue-100 text-blue-700' : 'text-gray-500' }}"
                    href="{{ url('dashboard/guru/rekap-absen') }}">
                    <i class="ti ti-clipboard-list ps-2 text-2xl"></i> <span>Rekap Absen</span>
                </a>
            </li>

            <li class="text-xs font-bold mb-4 mt-6">
                <i class="ti ti-dots nav-small-cap-icon text-lg hidden text-center"></i>
                <span class="text-xs text-gray-400 font-semibold">Rekap & Laporan</span>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link gap-3 py-2.5 my-1 text-base flex items-center relative rounded-md w-full
        {{ request()->is('dashboard/guru/leave-requests*') ? 'bg-blue-100 text-blue-700' : 'text-gray-500' }}"
                    href="{{ url('dashboard/guru/leave-requests') }}">
                    <i class="ti ti-medical-cross ps-2 text-2xl"></i> <span>Permintaan Izin</span>
                    @php
                        $pendingCount = \App\Models\LeaveRequest::whereHas('student', function ($q) {
                            $q->where('school_class_id', auth()->user()->guru->kelas->id ?? 0);
                        })
                            ->where('status', 'pending')
                            ->count();
                    @endphp
                    @if ($pendingCount > 0)
                        <span
                            class="bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center ml-1">
                            {{ $pendingCount }}
                        </span>
                    @endif
                </a>
            </li>
        </ul>
    </nav>
</div>