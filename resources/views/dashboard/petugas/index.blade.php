<x-app-layout>
    <x-slot name="header">
        <nav class="w-full flex items-center justify-between" aria-label="Global">
            <div>
                <h2 class="font-semibold text-xl">Dashboard Wali Kelas</h2>
            </div>
            <div class="flex items-center gap-4">
                @include('header-components.dd-profile')
            </div>
        </nav>
    </x-slot>

    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-400 text-white rounded-xl shadow-lg p-6 mb-8">
        <div class="flex items-center gap-4">
            <div class="bg-white bg-opacity-20 p-3 rounded-full flex items-center justify-center w-12 h-12">
                @php
                    $initial = strtoupper(substr(auth()->user()->name ?? 'A', 0, 1));
                @endphp
                <span class="text-black text-2xl font-bold">{{ $initial }}</span>
            </div>
            <div>
                <h3 class="text-xl font-bold">Selamat Datang, {{ auth()->user()->name }}!</h3>
                <p class="text-blue-50">Dashboard Sistem Absensi Sekolah</p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-blue-500 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-gray-500 text-sm font-medium mb-1">Total Kelas</div>
                    <div class="text-3xl font-bold text-gray-800">{{ $kelas }}</div>
                </div>
                <div class="bg-blue-100 p-3 rounded-lg">
                    <i class="ti ti-school text-2xl text-blue-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-green-500 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-gray-500 text-sm font-medium mb-1">Total Guru</div>
                    <div class="text-3xl font-bold text-gray-800">{{ $guru }}</div>
                </div>
                <div class="bg-green-100 p-3 rounded-lg">
                    <i class="ti ti-user-star text-2xl text-green-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-purple-500 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-gray-500 text-sm font-medium mb-1">Total Siswa</div>
                    <div class="text-3xl font-bold text-gray-800">{{ $siswa }}</div>
                </div>
                <div class="bg-purple-100 p-3 rounded-lg">
                    <i class="ti ti-users text-2xl text-purple-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-amber-500 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-gray-500 text-sm font-medium mb-1">Total Orang Tua</div>
                    <div class="text-3xl font-bold text-gray-800">{{ $orangtua }}</div>
                </div>
                <div class="bg-amber-100 p-3 rounded-lg">
                    <i class="ti ti-user-circle text-2xl text-amber-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-8">
        <h3 class="text-lg font-semibold mb-4 text-gray-700 flex items-center gap-2">
            <i class="ti ti-bolt text-blue-600"></i> Aksi Cepat
        </h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ url('dashboard/school_classes') }}" class="flex flex-col items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                <i class="ti ti-school text-3xl text-blue-600 mb-2"></i>
                <span class="text-sm font-medium text-center">Kelola Kelas</span>
            </a>
            
            <a href="{{ url('dashboard/gurus') }}" class="flex flex-col items-center p-4 bg-green-50 hover:bg-green-100 rounded-lg transition-colors">
                <i class="ti ti-user-star text-3xl text-green-600 mb-2"></i>
                <span class="text-sm font-medium text-center">Kelola Guru</span>
            </a>
            
            <a href="{{ url('dashboard/students') }}" class="flex flex-col items-center p-4 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors">
                <i class="ti ti-users text-3xl text-purple-600 mb-2"></i>
                <span class="text-sm font-medium text-center">Kelola Siswa</span>
            </a>
            
            <a href="{{ url('dashboard/orangtuas') }}" class="flex flex-col items-center p-4 bg-amber-50 hover:bg-amber-100 rounded-lg transition-colors">
                <i class="ti ti-user-circle text-3xl text-amber-600 mb-2"></i>
                <span class="text-sm font-medium text-center">Kelola Orang Tua</span>
            </a>
        </div>
    </div>

    <!-- Recent Activity (Optional) -->
    <div class="bg-white rounded-xl shadow-md p-6">
    <h3 class="text-lg font-semibold mb-4 text-gray-700 flex items-center gap-2">
        <i class="ti ti-activity text-blue-600"></i> Aktivitas Terbaru
    </h3>
    <div class="border rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aktivitas</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($recentActivities as $activity)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $activity->description }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $activity->user_name }} ({{ ucfirst($activity->user_role) }})</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $activity->created_at->format('H:i - d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">Belum ada aktivitas terbaru</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</x-app-layout>