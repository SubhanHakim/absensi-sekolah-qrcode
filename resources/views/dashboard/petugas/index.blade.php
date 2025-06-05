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

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <div class="bg-white p-4 rounded shadow">
            <div class="text-gray-500">Kelas</div>
            <div class="text-2xl font-bold">{{ $kelas }}</div>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <div class="text-gray-500">Guru</div>
            <div class="text-2xl font-bold">{{ $guru }}</div>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <div class="text-gray-500">Siswa</div>
            <div class="text-2xl font-bold">{{ $siswa }}</div>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <div class="text-gray-500">Orang Tua</div>
            <div class="text-2xl font-bold">{{ $orangtua }}</div>
        </div>
    </div>
</x-app-layout>
