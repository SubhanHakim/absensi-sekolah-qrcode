<div class="p-4 text-center">
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
                    href="/dashboard/petugas">
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
                    href="/dashboard/school_classes">
                    <i class="ti ti-credit-card ps-2 text-2xl"></i> <span>Data Kelas</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link gap-3 py-2.5 my-1 text-base flex items-center relative rounded-md w-full
        {{ request()->is('dashboard/gurus*') ? 'bg-blue-100 text-blue-700' : 'text-gray-500' }}"
                    href="/dashboard/gurus">
                    <i class="ti ti-credit-card ps-2 text-2xl"></i> <span>Data Guru</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link gap-3 py-2.5 my-1 text-base flex items-center relative rounded-md w-full
        {{ request()->is('dashboard/students*') ? 'bg-blue-100 text-blue-700' : 'text-gray-500' }}"
                    href="/dashboard/students">
                    <i class="ti ti-credit-card ps-2 text-2xl"></i> <span>Data Siswa</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link gap-3 py-2.5 my-1 text-base flex items-center relative rounded-md w-full
        {{ request()->is('dashboard/orangtuas*') ? 'bg-blue-100 text-blue-700' : 'text-gray-500' }}"
                    href="/dashboard/orangtuas">
                    <i class="ti ti-credit-card ps-2 text-2xl"></i> <span>Data Orang Tua</span>
                </a>
            </li>

            <li class="text-xs font-bold mb-4 mt-6">
                <i class="ti ti-dots nav-small-cap-icon text-lg hidden text-center"></i>
                <span class="text-xs text-gray-400 font-semibold">Rekap & Laporan</span>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link gap-3 py-2.5 my-1 text-base flex items-center relative rounded-md w-full
        {{ request()->is('dashboard/testimoni*') ? 'bg-blue-100 text-blue-700' : 'text-gray-500' }}"
                    href="/dashboard/testimoni">
                    <i class="ti ti-message ps-2 text-2xl"></i> <span>Absensi</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
