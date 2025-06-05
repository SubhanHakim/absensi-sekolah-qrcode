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
        <!-- Detail Penyewa (Full Width) -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="flex justify-between items-center mb-5">
                <h4 class="text-[#1e1e1e] dark:text-[#1e1e1e] text-lg font-semibold">
                    INI ADALAHA SISWA
                </h4>
            </div>
            <ul class="space-y-3 text-[#1e1e1e] dark:text-[#1e1e1e]">
                <li class="flex items-center gap-2">
                    <i class="ti ti-home text-xl text-[#DC8330]"></i>
                    <span><strong>No Kamar:</strong></span>
                </li>
                <li class="flex items-center gap-2">
                    <i class="ti ti-bed text-xl text-[#DC8330]"></i>
                    <span><strong>Tipe Kamar:</strong></span>
                </li>
                <li class="flex items-center gap-2">
                    <i class="ti ti-cash text-xl text-[#DC8330]"></i>
                    <span><strong>Tarif Kamar:</strong></span>
                </li>
                <li class="flex items-center gap-2">
                    <i class="ti ti-calendar text-xl text-[#DC8330]"></i>
                    <span><strong>Tanggal Penyewa:</strong>
                    </span>
                </li>
                <li class="flex items-center gap-2">
                    <i class="ti ti-calendar-check text-xl text-[#DC8330]"></i>
                    <span><strong>Tanggal Akhir Sewa:</strong>
                    </span>
                </li>
            </ul>
        </div>

        <!-- Informasi Terkini & Lama Sewa (Dibawahnya) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Informasi Terkini -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4 text-[#1e1e1e] dark:text-[#1e1e1e]">Informasi Terkini</h3>
                <ul class="space-y-2">
                    <li class="text-[#1e1e1e] dark:text-gray-400">
                        <strong>Tagihan Bulanan:</strong> Pastikan untuk membayar tagihan bulanan Anda tepat waktu.
                    </li>
                    {{-- Tambahkan info lain di sini --}}
                </ul>
            </div>
            <!-- Lama Sewa -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h4 class="text-[#1e1e1e] dark:text-[#1e1e1e] text-lg font-semibold mb-4">
                    Lama Sewa
                </h4>
                <div class="flex items-center justify-between gap-8">
                    <div>
                        <h3 class="text-[22px] font-semibold text-[#1e1e1e] dark:text-gray-100 mb-4">
                            $36,358
                        </h3>
                        <div class="flex items-center gap-1 mb-3">
                            <span class="flex items-center justify-center w-5 h-5 rounded-full bg-teal-400">
                                <i class="ti ti-arrow-up-left text-teal-500"></i>
                            </span>
                            <p class="text-gray-500 text-sm font-normal">+9%</p>
                            <p class="text-gray-400 text-sm font-normal text-nowrap">
                                last year
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div id="grade"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
