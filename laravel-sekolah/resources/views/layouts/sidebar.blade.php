<div class="p-4 text-center border-b">
    <div class="flex justify-center mb-3">
        <img src="{{ asset('images/logo.png') }}" alt="Logo Sekolah" class="h-14 w-auto">
    </div>
    <h1 class="text-lg font-semibold text-gray-800">Wali Kelas</h1>
</div>

<div class="flex-1 overflow-y-auto p-4">
    <nav class="space-y-2">
        <!-- HOME Section -->
        <div class="text-xs font-bold text-gray-400 uppercase mb-3">Home</div>

        <a href="{{ url('dashboard/petugas') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->is('dashboard/petugas') ? 'bg-blue-100 text-blue-700' : '' }}">
            <i class="ti ti-layout-dashboard text-xl"></i>
            <span>Dashboard</span>
        </a>

        <!-- Master Data Dropdown -->
        <div class="sidebar-item has-dropdown">
            <a class="sidebar-link gap-3 py-2.5 my-1 text-base flex items-center relative rounded-md w-full cursor-pointer
                {{ request()->is('dashboard/students*') || request()->is('dashboard/school_classes*') || request()->is('dashboard/orangtuas*') || request()->is('dashboard/accounts*') ? 'bg-blue-100 text-blue-700' : 'text-gray-500' }}"
                onclick="toggleDropdown(this)">
                <i class="ti ti-database ps-2 text-2xl"></i>
                <span class="flex-1">Master Data</span>
                <i class="ti ti-chevron-down dropdown-arrow transition-transform duration-200"></i>
            </a>
            <ul class="dropdown-menu ml-8 mt-1 space-y-1 max-h-0 overflow-hidden transition-all duration-300">
                <li>
                    <a class="sidebar-link gap-3 py-2 my-1 text-sm flex items-center relative rounded-md w-full
                        {{ request()->is('dashboard/students*') ? 'bg-blue-100 text-blue-700' : 'text-gray-500' }}"
                        href="{{ url('dashboard/students') }}">
                        <iconify-icon icon="mdi:account-school" class="ps-2 text-xl"></iconify-icon> <span>Data
                            Siswa</span>
                    </a>
                </li>
                <li>
                    <a class="sidebar-link gap-3 py-2 my-1 text-sm flex items-center relative rounded-md w-full
                        {{ request()->is('dashboard/school_classes*') ? 'bg-blue-100 text-blue-700' : 'text-gray-500' }}"
                        href="{{ url('dashboard/school_classes') }}">
                        <iconify-icon icon="mdi:school" class="ps-2 text-xl"></iconify-icon> <span>Data Kelas</span>
                    </a>
                </li>
                <li>
                    <a class="sidebar-link gap-3 py-2 my-1 text-sm flex items-center relative rounded-md w-full
                        {{ request()->is('dashboard/orangtuas*') ? 'bg-blue-100 text-blue-700' : 'text-gray-500' }}"
                        href="{{ url('dashboard/orangtuas') }}">
                        <iconify-icon icon="mdi:account-supervisor" class="ps-2 text-xl"></iconify-icon> <span>Data
                            Orang Tua</span>
                    </a>
                </li>
                <li>
                    <a class="sidebar-link gap-3 py-2 my-1 text-sm flex items-center relative rounded-md w-full
                        {{ request()->is('dashboard/accounts*') ? 'bg-blue-100 text-blue-700' : 'text-gray-500' }}"
                        href="{{ url('dashboard/accounts') }}">
                        <i class="ti ti-user-cog ps-2 text-xl"></i> <span>Manajemen Akun</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- ABSENSI Section -->
        <div class="text-xs font-bold text-gray-400 uppercase mb-3 mt-6">Absensi</div>

        <a href="{{ url('dashboard/petugas/scan-absen') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->is('dashboard/petugas/scan-absen*') ? 'bg-blue-100 text-blue-700' : '' }}">
            <i class="ti ti-qrcode text-xl"></i>
            <span>Absensi Siswa (Scan)</span>
        </a>

        <a href="{{ url('dashboard/petugas/rekap-absen') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->is('dashboard/petugas/rekap-absen*') ? 'bg-blue-100 text-blue-700' : '' }}">
            <i class="ti ti-clipboard-list text-xl"></i>
            <span>Rekap Absen</span>
        </a>

        <a href="{{ route('dashboard.petugas.leave-requests.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->is('dashboard/petugas/leave-requests*') ? 'bg-blue-100 text-blue-700' : '' }}">
            <i class="ti ti-clipboard-check text-xl"></i>
            <span>Persetujuan Izin Siswa</span>
        </a>
    </nav>
</div>

<script>
    function toggleDropdown(element) {
        const dropdownMenu = element.nextElementSibling;
        const arrow = element.querySelector('.ti-chevron-down');

        if (dropdownMenu.style.maxHeight === '0px' || dropdownMenu.style.maxHeight === '') {
            dropdownMenu.style.maxHeight = dropdownMenu.scrollHeight + 'px';
            arrow.style.transform = 'rotate(180deg)';
        } else {
            dropdownMenu.style.maxHeight = '0px';
            arrow.style.transform = 'rotate(0deg)';
        }
    }

    // Auto expand dropdown if active
    document.addEventListener('DOMContentLoaded', function() {
        const activeLink = document.querySelector('.dropdown-menu a.bg-blue-100');
        if (activeLink) {
            const dropdown = activeLink.closest('.dropdown-menu').previousElementSibling;
            toggleDropdown(dropdown);
        }
    });
</script>
