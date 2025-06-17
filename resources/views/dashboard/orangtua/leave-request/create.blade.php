{{-- resources/views/dashboard/orangtua/leave-requests/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Ajukan Izin/Sakit</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('dashboard.orangtua.leave-requests.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Siswa:</label>
                            <div class="bg-gray-100 p-2 rounded">{{ $student->nama }} ({{ $student->nis }})</div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="type">Jenis Ketidakhadiran:</label>
                            <select name="type" id="type" class="w-full border-gray-300 focus:border-indigo-500 rounded-md shadow-sm">
                                <option value="sakit">Sakit</option>
                                <option value="izin">Izin</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-700 font-bold mb-2" for="from_date">Tanggal Mulai:</label>
                                <input type="date" name="from_date" id="from_date" class="w-full border-gray-300 focus:border-indigo-500 rounded-md shadow-sm" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-bold mb-2" for="to_date">Tanggal Selesai:</label>
                                <input type="date" name="to_date" id="to_date" class="w-full border-gray-300 focus:border-indigo-500 rounded-md shadow-sm" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="reason">Alasan:</label>
                            <textarea name="reason" id="reason" rows="3" class="w-full border-gray-300 focus:border-indigo-500 rounded-md shadow-sm" required></textarea>
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 font-bold mb-2" for="attachment">Lampiran (Opsional):</label>
                            <input type="file" name="attachment" id="attachment" class="w-full border-gray-300 focus:border-indigo-500 rounded-md shadow-sm">
                            <p class="text-gray-500 text-sm mt-1">Format: JPG, PNG, PDF (Max: 2MB)</p>
                        </div>

                        <div class="flex items-center justify-end">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Kirim Pengajuan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>