class QRScanner {
    constructor() {
        this.isScanning = false;
        this.scanCooldown = 3000;
        this.lastScanTime = 0;
        this.lastScannedCode = '';
        this.video = null;
        this.canvas = null;
        this.context = null;
        this.stream = null;
        this.availableCameras = [];
        this.currentCameraIndex = 0;
    }

    async initialize() {
        this.video = document.getElementById('qr-video');
        if (!this.video) {
            console.error('QR video element not found');
            return false;
        }

        this.canvas = document.createElement('canvas');
        this.context = this.canvas.getContext('2d');

        // Get available cameras
        await this.getCameras();
        
        // Start with default camera
        return await this.startCamera();
    }

    async getCameras() {
        try {
            // Request permission first
            await navigator.mediaDevices.getUserMedia({ video: true });
            
            const devices = await navigator.mediaDevices.enumerateDevices();
            this.availableCameras = devices.filter(device => device.kind === 'videoinput');
            
            console.log('Available cameras:', this.availableCameras);
            
            // Create camera selector if multiple cameras
            if (this.availableCameras.length > 1) {
                this.createCameraSelector();
            }
            
        } catch (error) {
            console.error('Error getting cameras:', error);
            this.showError('Tidak dapat mengakses kamera. Pastikan izin kamera sudah diberikan.');
        }
    }

    createCameraSelector() {
        const container = document.getElementById('camera-controls');
        if (!container) return;

        const selector = document.createElement('select');
        selector.id = 'camera-selector';
        selector.className = 'mt-4 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500';
        
        this.availableCameras.forEach((camera, index) => {
            const option = document.createElement('option');
            option.value = index;
            option.textContent = camera.label || `Camera ${index + 1}`;
            selector.appendChild(option);
        });

        selector.addEventListener('change', (e) => {
            this.switchCamera(parseInt(e.target.value));
        });

        const label = document.createElement('label');
        label.textContent = 'Pilih Kamera: ';
        label.className = 'block text-sm font-medium text-gray-700 mb-2';

        container.appendChild(label);
        container.appendChild(selector);
    }

    async startCamera(cameraIndex = 0) {
        try {
            // Stop existing stream
            if (this.stream) {
                this.stream.getTracks().forEach(track => track.stop());
            }

            let constraints = {
                video: {
                    width: { ideal: 1280 },
                    height: { ideal: 720 },
                    facingMode: 'environment'
                }
            };

            if (this.availableCameras.length > 0 && cameraIndex < this.availableCameras.length) {
                constraints.video.deviceId = { exact: this.availableCameras[cameraIndex].deviceId };
                delete constraints.video.facingMode;
            }

            this.stream = await navigator.mediaDevices.getUserMedia(constraints);
            this.video.srcObject = this.stream;
            
            this.updateCameraStatus('Kamera aktif - siap scan');
            
            return new Promise((resolve) => {
                this.video.addEventListener('loadedmetadata', () => {
                    this.canvas.width = this.video.videoWidth;
                    this.canvas.height = this.video.videoHeight;
                    this.startScanning();
                    this.hideError();
                    resolve(true);
                });
                
                this.video.play();
            });

        } catch (error) {
            console.error('Error starting camera:', error);
            let errorMessage = 'Tidak dapat mengakses kamera.';
            
            if (error.name === 'NotAllowedError') {
                errorMessage = 'Akses kamera ditolak. Silakan berikan izin kamera dan refresh halaman.';
            } else if (error.name === 'NotFoundError') {
                errorMessage = 'Kamera tidak ditemukan.';
            } else if (error.name === 'NotReadableError') {
                errorMessage = 'Kamera sedang digunakan aplikasi lain.';
            }
            
            this.showError(errorMessage);
            this.updateCameraStatus('Kamera error');
            return false;
        }
    }

    async switchCamera(cameraIndex) {
        this.currentCameraIndex = cameraIndex;
        this.pauseScanning();
        this.updateCameraStatus('Mengganti kamera...');
        await this.startCamera(cameraIndex);
    }

    startScanning() {
        if (this.isScanning) return;
        
        this.isScanning = true;
        this.updateCameraStatus('Scanning QR Code...');
        this.scanLoop();
    }

    scanLoop() {
        if (!this.isScanning || !this.video.videoWidth || !this.video.videoHeight) {
            requestAnimationFrame(() => this.scanLoop());
            return;
        }

        this.context.drawImage(this.video, 0, 0, this.canvas.width, this.canvas.height);
        const imageData = this.context.getImageData(0, 0, this.canvas.width, this.canvas.height);
        
        try {
            if (typeof jsQR !== 'undefined') {
                const code = jsQR(imageData.data, imageData.width, imageData.height, {
                    inversionAttempts: "dontInvert"
                });
                
                if (code && code.data) {
                    this.handleQRCode(code.data);
                }
            }
        } catch (error) {
            // Ignore QR decode errors
        }

        requestAnimationFrame(() => this.scanLoop());
    }

    handleQRCode(qrCode) {
        const now = Date.now();
        
        if (
            now - this.lastScanTime < this.scanCooldown ||
            qrCode === this.lastScannedCode
        ) {
            return;
        }

        this.lastScanTime = now;
        this.lastScannedCode = qrCode;

        this.pauseScanning();
        this.updateCameraStatus('QR Code terdeteksi!');
        this.showScanningIndicator();
        this.processAttendance(qrCode);
    }

    pauseScanning() {
        this.isScanning = false;
    }

    resumeScanning() {
        setTimeout(() => {
            this.lastScannedCode = '';
            this.isScanning = true;
            this.updateCameraStatus('Scanning QR Code...');
            this.scanLoop();
        }, 2000);
    }

    async processAttendance(qrCode) {
        try {
            const response = await fetch('/dashboard/petugas/process-absen', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    qr_code: qrCode
                })
            });

            const result = await response.json();
            
            this.hideScanningIndicator();
            
            if (result.success) {
                this.showSuccessMessage(result);
                this.updateCameraStatus('Absensi berhasil!');
                
                setTimeout(() => {
                    window.location.reload();
                }, 3000);
                
            } else {
                this.showErrorMessage(result.message);
                this.updateCameraStatus('Scan gagal - coba lagi');
                
                setTimeout(() => {
                    this.resumeScanning();
                }, 2000);
            }

        } catch (error) {
            console.error('Error processing attendance:', error);
            this.hideScanningIndicator();
            this.showErrorMessage('Terjadi kesalahan saat memproses absensi.');
            this.updateCameraStatus('Error - coba lagi');
            
            setTimeout(() => {
                this.resumeScanning();
            }, 2000);
        }
    }

    updateCameraStatus(status) {
        const statusElement = document.getElementById('camera-status');
        if (statusElement) {
            statusElement.textContent = status;
        }
    }

    showScanningIndicator() {
        const indicator = document.getElementById('scanning-indicator');
        if (indicator) {
            indicator.classList.remove('hidden');
            indicator.innerHTML = `
                <div class="flex items-center justify-center">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                    <span class="ml-2">Memproses QR Code...</span>
                </div>
            `;
        }
    }

    hideScanningIndicator() {
        const indicator = document.getElementById('scanning-indicator');
        if (indicator) {
            indicator.classList.add('hidden');
        }
    }

    showSuccessMessage(result) {
        const messageDiv = document.getElementById('scan-message');
        if (messageDiv) {
            messageDiv.innerHTML = `
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <div class="flex items-center">
                        <i class="ti ti-check-circle text-2xl mr-2"></i>
                        <div>
                            <strong>Berhasil!</strong><br>
                            <span>${result.message}</span><br>
                            <small>Status: ${result.status?.toUpperCase()} pada ${result.time}</small>
                        </div>
                    </div>
                </div>
            `;
            messageDiv.classList.remove('hidden');
        }
    }

    showErrorMessage(message) {
        const messageDiv = document.getElementById('scan-message');
        if (messageDiv) {
            messageDiv.innerHTML = `
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <div class="flex items-center">
                        <i class="ti ti-alert-circle text-2xl mr-2"></i>
                        <div>
                            <strong>Error!</strong><br>
                            <span>${message}</span>
                        </div>
                    </div>
                </div>
            `;
            messageDiv.classList.remove('hidden');
        }
    }

    showError(message) {
        const errorDiv = document.getElementById('camera-error');
        if (errorDiv) {
            errorDiv.textContent = message;
            errorDiv.classList.remove('hidden');
        }
    }

    hideError() {
        const errorDiv = document.getElementById('camera-error');
        if (errorDiv) {
            errorDiv.classList.add('hidden');
        }
    }

    stop() {
        this.isScanning = false;
        
        if (this.stream) {
            this.stream.getTracks().forEach(track => track.stop());
        }
    }

    // Static method untuk decode QR dari uploaded image
    static async decodeQRFromImage(imageFile) {
        return new Promise((resolve, reject) => {
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');
            const img = new Image();
            
            img.onload = function() {
                canvas.width = img.width;
                canvas.height = img.height;
                context.drawImage(img, 0, 0);
                
                const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
                
                try {
                    if (typeof jsQR !== 'undefined') {
                        const code = jsQR(imageData.data, imageData.width, imageData.height, {
                            inversionAttempts: "dontInvert"
                        });
                        
                        if (code && code.data) {
                            resolve(code.data);
                        } else {
                            reject(new Error('QR Code tidak terdeteksi dalam gambar'));
                        }
                    } else {
                        reject(new Error('jsQR library tidak tersedia'));
                    }
                } catch (error) {
                    reject(new Error('Gagal memproses gambar: ' + error.message));
                }
            };
            
            img.onerror = function() {
                reject(new Error('Gagal memuat gambar'));
            };
            
            img.src = URL.createObjectURL(imageFile);
        });
    }

    // Static method untuk processing attendance dari upload
    static async processUploadedAttendance(qrCode) {
        try {
            const response = await fetch('/dashboard/petugas/process-absen', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    qr_code: qrCode
                })
            });

            const result = await response.json();
            return result;

        } catch (error) {
            console.error('Error processing attendance:', error);
            throw new Error('Terjadi kesalahan saat memproses absensi.');
        }
    }
}

// Make QRScanner globally available
window.QRScanner = QRScanner;

// Initialize scanner when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Check if we're on the scan page
    if (document.getElementById('qr-video')) {
        const scanner = new QRScanner();
        scanner.initialize();

        // Store scanner instance globally for access from other scripts
        window.scannerInstance = scanner;

        // Cleanup on page unload
        window.addEventListener('beforeunload', () => {
            scanner.stop();
        });
    }
});