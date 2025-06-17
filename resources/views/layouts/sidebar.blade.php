<div class="p-4 text-center">
    <div class="flex justify-center mb-3">
        <img src="{{ asset('images/logo.png') }}" alt="Logo Sekolah" class="h-14 w-auto">
    </div>
    <h1 class="text-3xl uppercase font-semibold">Petugas</h1>
</div>
<div class="scroll-sidebar" data-simplebar="">
    <nav class=" w-full flex flex-col sidebar-nav px-4 mt-5">
        <ul id="sidebarnav" class="text-gray-600 text-sm">
            <li class="text-xs font-bold pb-[5px]">
                <i class="ti ti-dots nav-small-cap-icon text-lg hidden text-center"></i>
                <span class="text-xs text-gray-400 font-semibold">HOME</span>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link gap-3 py-2.5 my-1 text-base flex items-center relative rounded-md w-full
        {{ request()->is('dashboard/petugas') ? 'bg-blue-100 text-blue-700' : 'text-gray-500' }}"
                    href="{{ url('dashboard/petugas') }}">
                    <i class="ti ti-layout-dashboard ps-2 text-2xl"></i> <span>Dashboard</span>
                </a>
            </li>

            <li class="text-xs font-bold mb-4 mt-6">
                <i class="ti ti-dots nav-small-cap-icon text-lg hidden text-center"></i>
                <span class="text-xs text-gray-400 font-semibold">MANAJEMEN</span>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link gap-3 py-2.5 my-1 text-base flex items-center relative rounded-md w-full
        {{ request()->is('dashboard/school_classes*') ? 'bg-blue-100 text-blue-700' : 'text-gray-500' }}"
                    href="{{ url('dashboard/school_classes') }}">
                    <iconify-icon icon="mdi:school" class="ps-2 text-2xl"></iconify-icon> <span>Data Kelas</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link gap-3 py-2.5 my-1 text-base flex items-center relative rounded-md w-full
        {{ request()->is('dashboard/gurus*') ? 'bg-blue-100 text-blue-700' : 'text-gray-500' }}"
                    href="{{ url('dashboard/gurus') }}">
                    <iconify-icon icon="mdi:account-tie" class="ps-2 text-2xl"></iconify-icon> <span>Data Guru</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link gap-3 py-2.5 my-1 text-base flex items-center relative rounded-md w-full
        {{ request()->is('dashboard/students*') ? 'bg-blue-100 text-blue-700' : 'text-gray-500' }}"
                    href="{{ url('dashboard/students') }}">
                    <iconify-icon icon="mdi:account-school" class="ps-2 text-2xl"></iconify-icon> <span>Data Siswa</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link gap-3 py-2.5 my-1 text-base flex items-center relative rounded-md w-full
        {{ request()->is('dashboard/orangtuas*') ? 'bg-blue-100 text-blue-700' : 'text-gray-500' }}"
                    href="{{ url('dashboard/orangtuas') }}">
                    <iconify-icon icon="mdi:account-supervisor" class="ps-2 text-2xl"></iconify-icon> <span>Data Orang Tua</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link gap-3 py-2.5 my-1 text-base flex items-center relative rounded-md w-full
        {{ request()->is('dashboard/accounts*') ? 'bg-blue-100 text-blue-700' : 'text-gray-500' }}"
                    href="{{ url('dashboard/accounts') }}">
                    <i class="ti ti-user-cog ps-2 text-2xl"></i> <span>Manajemen Akun</span>
                </a>
            </li>

            <li class="text-xs font-bold mb-4 mt-6">
                <i class="ti ti-dots nav-small-cap-icon text-lg hidden text-center"></i>
                <span class="text-xs text-gray-400 font-semibold">Rekap & Laporan</span>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link gap-3 py-2.5 my-1 text-base flex items-center relative rounded-md w-full
        {{ request()->is('dashboard/testimoni*') ? 'bg-blue-100 text-blue-700' : 'text-gray-500' }}"
                    href="{{ url('dashboard/testimoni') }}">
                    <i class="ti ti-message ps-2 text-2xl"></i> <span>Absensi</span>
                </a>
            </li>
        </ul>
    </nav>
</div>