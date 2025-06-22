{{-- resources/views/dashboard/guru/leave-requests/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Permintaan Izin/Sakit Siswa</h2>
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
                                        <th class="py-3 px-4 bg-gray-100 font-semibold text-left">Siswa</th>
                                        <th class="py-3 px-4 bg-gray-100 font-semibold text-left">Tanggal Pengajuan</th>
                                        <th class="py-3 px-4 bg-gray-100 font-semibold text-left">Periode</th>
                                        <th class="py-3 px-4 bg-gray-100 font-semibold text-left">Jenis</th>
                                        <th class="py-3 px-4 bg-gray-100 font-semibold text-left">Alasan</th>
                                        <th class="py-3 px-4 bg-gray-100 font-semibold text-left">Lampiran</th>
                                        <th class="py-3 px-4 bg-gray-100 font-semibold text-left">Status</th>
                                        <th class="py-3 px-4 bg-gray-100 font-semibold text-left">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($leaveRequests as $leave)
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="py-3 px-4">{{ $leave->student->nama }}</td>
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
                                                @if ($leave->attachment_path)
                                                    <a href="{{ Storage::url($leave->attachment_path) }}"
                                                        target="_blank" class="text-blue-600 hover:underline">
                                                        Lihat
                                                    </a>
                                                @else
                                                    -
                                                @endif
                                            </td>
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
                                            <td class="py-3 px-4">
                                                @if ($leave->status == 'pending')
                                                    <button onclick="openModal('{{ $leave->id }}')"
                                                        class="bg-blue-600 hover:bg-blue-700 text-white py-1 px-3 rounded text-xs">
                                                        Proses
                                                    </button>
                                                @else
                                                    <span class="text-gray-500">-</span>
                                                @endif
                                            </td>
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

    <!-- Modal untuk approval -->
    <div id="approvalModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg w-full max-w-md p-6">
            <h3 class="text-lg font-bold mb-4">Proses Permintaan Izin/Sakit</h3>
            <form id="approvalForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2" for="status">Status:</label>
                    <select name="status" id="status"
                        class="w-full border-gray-300 focus:border-indigo-500 rounded-md shadow-sm">
                        <option value="approved">Setujui</option>
                        <option value="rejected">Tolak</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2" for="notes">Catatan (Opsional):</label>
                    <textarea name="notes" id="notes" rows="3"
                        class="w-full border-gray-300 focus:border-indigo-500 rounded-md shadow-sm"></textarea>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal()"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        Batal
                    </button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(id) {
            document.getElementById('approvalForm').action = "{{ url('dashboard/petugas/leave-requests') }}/" + id +
                "/process";
            document.getElementById('approvalModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('approvalModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
