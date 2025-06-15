<x-app-layout>

    <x-slot name="header">
        <nav class="w-full flex items-center justify-between" aria-label="Global">
            <ul class="icon-nav flex items-center gap-4">
                <li class="relative xl:hidden">
                    <a class="text-xl icon-hover cursor-pointer text-heading" id="headerCollapse"
                        data-hs-overlay="#application-sidebar-brand" aria-controls="application-sidebar-brand"
                        aria-label="Toggle navigation" href="javascript:void(0)">
                        <i class="ti ti-menu-2 relative z-1"></i>
                    </a>
                </li>
                <li class="relative">
                    @include('header-components.dd-notification')
                </li>
            </ul>
            <div class="flex items-center gap-4">
                @include('header-components.dd-profile')
            </div>
        </nav>
    </x-slot>

    <div class="flex flex-col gap-6">
        <!-- Profil Siswa -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="flex justify-between items-center mb-5">
                <h4 class="text-[#1e1e1e] dark:text-[#1e1e1e] text-lg font-semibold">
                    Profil Siswa
                </h4>
            </div>
            <ul class="space-y-3 text-[#1e1e1e] dark:text-[#1e1e1e]">
                <li><strong>Nama:</strong> {{ $siswa->nama ?? '-' }}</li>
                <li><strong>NIS:</strong> {{ $siswa->nis ?? '-' }}</li>
                <li><strong>Email:</strong> {{ $siswa->email ?? '-' }}</li>
                <li><strong>Kelas:</strong> {{ $kelas->class_name ?? '-' }}</li>
                <li><strong>QR Code:</strong> {{ $siswa->qr_code ?? '-' }}</li>
            </ul>
        </div>

        <!-- Informasi Kelas -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h4 class="text-[#1e1e1e] dark:text-[#1e1e1e] text-lg font-semibold mb-4">
                Informasi Kelas
            </h4>
            <ul class="space-y-2">
                <li><strong>Nama Kelas:</strong> {{ $kelas->class_name ?? '-' }}</li>
                <li><strong>Wali Kelas:</strong> {{ $kelas->wali_kelas ?? '-' }}</li>
                {{-- Tambahkan info kelas lain jika ada --}}
            </ul>
        </div>

        <!-- ...bagian lain dashboard siswa... -->
    </div>
</x-app-layout>
