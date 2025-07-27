<x-app-layout>
    <x-slot name="header">
        <nav class="w-full flex items-center justify-between py-2">
            <div class="flex items-center gap-4">
                <div class="relative xl:hidden">
                    <button id="mobile-toggle"
                        class="text-xl cursor-pointer text-gray-700 p-2 rounded-md hover:bg-gray-100 transition-colors">
                        <i class="ti ti-menu-2 text-2xl"></i>
                    </button>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-800">Scan Absensi</h1>
                    <div class="text-sm text-gray-500 flex items-center">
                        <a href="/dashboard" class="hover:text-blue-600 transition-colors">Home</a>
                        <span class="mx-2">/</span>
                        <span class="text-gray-700">Scan Absensi</span>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-4">
                @include('header-components.dd-profile')
            </div>
        </nav>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <!-- Scanner Container -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">QR Code Scanner</h2>
                <p class="text-gray-600">Arahkan kamera ke QR Code siswa untuk melakukan absensi</p>
            </div>

            <!-- Camera Controls -->
            <div id="camera-controls" class="text-center mb-4">
                <!-- Camera selector will be dynamically added here -->
            </div>

            <!-- Camera Error Message -->
            <div id="camera-error" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            </div>

            <!-- Scan Message -->
            <div id="scan-message" class="hidden mb-4">
            </div>

            <!-- Scanning Indicator -->
            <div id="scanning-indicator"
                class="hidden bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4">
            </div>

            <!-- Camera View -->
            <div class="relative mx-auto" style="max-width: 500px;">
                <video id="qr-video" class="w-full h-auto rounded-lg border-2 border-gray-300" playsinline autoplay
                    muted></video>

                <!-- Scanner Overlay -->
                <div class="absolute inset-0 pointer-events-none">
                    <div class="absolute inset-0 bg-black bg-opacity-30 rounded-lg"></div>
                    <div
                        class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 border-4 border-white border-dashed rounded-lg animate-pulse">
                    </div>
                </div>

                <!-- Camera Status -->
                <div class="absolute bottom-4 left-4 bg-black bg-opacity-50 text-white px-2 py-1 rounded text-xs">
                    <span id="camera-status">Menginisialisasi kamera...</span>
                </div>
            </div>

            <!-- Upload QR Code (fallback) -->
            <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                <h4 class="text-sm font-medium text-gray-700 mb-2">Upload QR Code (jika kamera bermasalah)</h4>
                <div class="space-y-3">
                    <!-- File Upload with Drag & Drop -->
                    <div id="upload-area"
                        class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition-colors">
                        <div class="mb-4">
                            <i class="ti ti-cloud-upload text-4xl text-gray-400"></i>
                        </div>
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-2">Drag & drop gambar QR Code di sini, atau</p>
                            <input type="file" id="qr-upload" accept="image/*" class="hidden">
                            <label for="qr-upload"
                                class="cursor-pointer bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors inline-block">
                                <i class="ti ti-photo mr-1"></i> Pilih File
                            </label>
                        </div>
                        <p class="text-xs text-gray-500">Support: JPG, PNG, GIF (Max 5MB)</p>
                    </div>

                    <!-- Process Button -->
                    <div class="text-center">
                        <button onclick="processUploadedQR()"
                            class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                            id="process-btn" disabled>
                            <i class="ti ti-scan mr-1"></i>
                            Proses QR Code
                        </button>
                    </div>

                    <!-- Preview Area -->
                    <div id="upload-preview" class="hidden">
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                            <img id="preview-image" src="" alt="QR Code Preview"
                                class="max-w-full max-h-48 mx-auto rounded">
                            <p class="text-sm text-gray-500 mt-2">Preview QR Code</p>
                        </div>
                    </div>

                    <!-- Upload Result -->
                    <div id="upload-result" class="hidden">
                    </div>
                </div>
            </div>

            <!-- Instructions -->
            <div class="mt-6 text-center">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600">
                    <div class="flex items-center justify-center">
                        <i class="ti ti-camera text-blue-600 mr-2"></i>
                        <span>Pastikan kamera menghadap QR Code</span>
                    </div>
                    <div class="flex items-center justify-center">
                        <i class="ti ti-brightness text-blue-600 mr-2"></i>
                        <span>Pastikan pencahayaan cukup</span>
                    </div>
                    <div class="flex items-center justify-center">
                        <i class="ti ti-focus text-blue-600 mr-2"></i>
                        <span>Tahan stabil hingga terdeteksi</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Scans -->
        <div class="bg-white rounded-lg shadow-md p-6 mt-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Absensi Hari Ini</h3>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kelas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php
                            try {
                                $todayAttendances = \App\Models\Attendance::with(['student.schoolClass'])
                                    ->whereDate('tanggal', today())
                                    ->orderBy('created_at', 'desc')
                                    ->limit(10)
                                    ->get();
                            } catch (\Exception $e) {
                                $todayAttendances = collect();
                            }
                        @endphp

                        @forelse($todayAttendances as $attendance)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $attendance->student->nama ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $attendance->student->schoolClass->class_name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $attendance->status === 'hadir'
                                            ? 'bg-green-100 text-green-800'
                                            : ($attendance->status === 'telat'
                                                ? 'bg-yellow-100 text-yellow-800'
                                                : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($attendance->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $attendance->created_at->format('H:i:s') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                    Belum ada absensi hari ini
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.js"></script>
        @vite(['resources/js/qr-scanner.js'])

        <script>
            // Wait for QRScanner to be available
            document.addEventListener('DOMContentLoaded', function() {
                // Handle file upload change
                const fileInput = document.getElementById('qr-upload');
                const processBtn = document.getElementById('process-btn');

                if (fileInput) {
                    fileInput.addEventListener('change', function(e) {
                        const file = e.target.files[0];

                        if (file) {
                            // Validate file size (5MB max)
                            if (file.size > 5 * 1024 * 1024) {
                                showUploadMessage('File terlalu besar. Maksimal 5MB', 'error');
                                this.value = '';
                                return;
                            }

                            // Show preview
                            const preview = document.getElementById('upload-preview');
                            const previewImage = document.getElementById('preview-image');

                            const reader = new FileReader();
                            reader.onload = function(e) {
                                previewImage.src = e.target.result;
                                preview.classList.remove('hidden');
                                if (processBtn) processBtn.disabled = false;
                            };
                            reader.readAsDataURL(file);
                        } else {
                            if (processBtn) processBtn.disabled = true;
                            const preview = document.getElementById('upload-preview');
                            if (preview) preview.classList.add('hidden');
                        }
                    });
                }

                // Setup drag and drop
                setupDragAndDrop();
            });

            // Process uploaded QR code
            async function processUploadedQR() {
                const fileInput = document.getElementById('qr-upload');

                if (!fileInput || !fileInput.files || !fileInput.files[0]) {
                    showUploadMessage('Silakan pilih file gambar terlebih dahulu', 'error');
                    return;
                }

                const file = fileInput.files[0];

                // Validate file type
                if (!file.type.startsWith('image/')) {
                    showUploadMessage('File harus berupa gambar (JPG, PNG, etc.)', 'error');
                    return;
                }

                // Show processing indicator
                showUploadMessage('Memproses QR Code dari gambar...', 'processing');

                try {
                    // Wait for QRScanner to be available
                    if (typeof QRScanner === 'undefined') {
                        throw new Error('QRScanner belum tersedia');
                    }

                    // Decode QR from image
                    const qrCode = await QRScanner.decodeQRFromImage(file);

                    if (!qrCode) {
                        showUploadMessage('QR Code tidak terdeteksi dalam gambar', 'error');
                        return;
                    }

                    showUploadMessage('QR Code berhasil terdeteksi: ' + qrCode, 'success');

                    // Process attendance
                    const result = await QRScanner.processUploadedAttendance(qrCode);

                    if (result.success) {
                        showUploadMessage(`
                        <div class="text-green-700">
                            <strong>Absensi Berhasil!</strong><br>
                            <span>${result.message}</span><br>
                            <small>Status: ${result.status?.toUpperCase()} pada ${result.time}</small>
                        </div>
                    `, 'success');

                        // Clear form and reload after delay
                        setTimeout(() => {
                            fileInput.value = '';
                            document.getElementById('upload-preview').classList.add('hidden');
                            const processBtn = document.getElementById('process-btn');
                            if (processBtn) processBtn.disabled = true;
                            window.location.reload();
                        }, 3000);

                    } else {
                        showUploadMessage(result.message, 'error');
                    }

                } catch (error) {
                    console.error('Upload processing error:', error);
                    showUploadMessage(error.message || 'Gagal memproses QR Code dari gambar', 'error');
                }
            }

            // Show upload message
            function showUploadMessage(message, type) {
                const resultDiv = document.getElementById('upload-result');
                if (!resultDiv) return;

                let bgColor, borderColor, textColor, icon;

                switch (type) {
                    case 'success':
                        bgColor = 'bg-green-100';
                        borderColor = 'border-green-400';
                        textColor = 'text-green-700';
                        icon = 'ti-check-circle';
                        break;
                    case 'error':
                        bgColor = 'bg-red-100';
                        borderColor = 'border-red-400';
                        textColor = 'text-red-700';
                        icon = 'ti-alert-circle';
                        break;
                    case 'processing':
                        bgColor = 'bg-blue-100';
                        borderColor = 'border-blue-400';
                        textColor = 'text-blue-700';
                        icon = 'ti-loader';
                        break;
                    default:
                        bgColor = 'bg-gray-100';
                        borderColor = 'border-gray-400';
                        textColor = 'text-gray-700';
                        icon = 'ti-info-circle';
                }

                resultDiv.innerHTML = `
                <div class="${bgColor} ${borderColor} ${textColor} border px-4 py-3 rounded">
                    <div class="flex items-center">
                        <i class="ti ${icon} ${type === 'processing' ? 'animate-spin' : ''} mr-2"></i>
                        <div>${message}</div>
                    </div>
                </div>
            `;
                resultDiv.classList.remove('hidden');
            }

            // Setup drag and drop functionality
            function setupDragAndDrop() {
                const uploadArea = document.getElementById('upload-area');
                const fileInput = document.getElementById('qr-upload');

                if (!uploadArea || !fileInput) return;

                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    uploadArea.addEventListener(eventName, preventDefaults, false);
                });

                function preventDefaults(e) {
                    e.preventDefault();
                    e.stopPropagation();
                }

                ['dragenter', 'dragover'].forEach(eventName => {
                    uploadArea.addEventListener(eventName, highlight, false);
                });

                ['dragleave', 'drop'].forEach(eventName => {
                    uploadArea.addEventListener(eventName, unhighlight, false);
                });

                function highlight(e) {
                    uploadArea.classList.add('border-blue-500', 'bg-blue-50');
                }

                function unhighlight(e) {
                    uploadArea.classList.remove('border-blue-500', 'bg-blue-50');
                }

                uploadArea.addEventListener('drop', handleDrop, false);

                function handleDrop(e) {
                    const dt = e.dataTransfer;
                    const files = dt.files;

                    if (files.length > 0) {
                        fileInput.files = files;
                        // Trigger change event
                        const event = new Event('change', {
                            bubbles: true
                        });
                        fileInput.dispatchEvent(event);
                    }
                }
            }
        </script>
    @endpush
</x-app-layout>
