@extends('layouts.app')

@section('title', 'Detail Surat - ' . $surat->judul)

@section('content')
<div class="page-title">Arsip Surat >> Lihat</div>

<div class="surat-detail-header mb-4">
    <div><strong>Nomor:</strong> {{ $surat->nomor_surat }}</div>
    <div><strong>Kategori:</strong> {{ $surat->kategori->nama_kategori ?? 'N/A' }}</div>
    <div><strong>Judul:</strong> {{ $surat->judul }}</div>
    <div><strong>Waktu Unggah:</strong> {{ $surat->waktu_pengarsipan->format('Y-m-d H:i') }}</div>
</div>

<!-- PDF Preview Container -->
<div class="pdf-preview-container">
    @if($surat->file_path && file_exists(storage_path('app/public/' . $surat->file_path)))
        
        <!-- PDF Preview Area -->
        <div class="pdf-viewer-section mb-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="mb-0">Preview Dokumen</h6>
                <div class="btn-group btn-group-sm">
                    <button onclick="showInObject()" class="btn btn-outline-primary active" id="btn-object">
                        <i class="fas fa-window-maximize me-1"></i> Preview
                    </button>
                    <button onclick="openInNewTab()" class="btn btn-outline-secondary">
                        <i class="fas fa-external-link-alt me-1"></i> Tab Baru
                    </button>
                </div>
            </div>
            
            <!-- Loading indicator -->
            <div id="loading-indicator" class="text-center py-5" style="display: none;">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2 text-muted">Memuat PDF...</p>
            </div>
            
            <!-- PDF Container -->
            <div id="pdf-container" style="min-height: 600px; border: 1px solid #ddd; border-radius: 4px; background: #f8f9fa;">
                <!-- PDF Object Element (akan diinject oleh JavaScript) -->
                <div class="text-center py-5">
                    <i class="fas fa-file-pdf fa-3x text-primary mb-3"></i>
                    <h6>Dokumen PDF Siap Ditampilkan</h6>
                    <p class="text-muted">Klik tombol "Preview" untuk menampilkan dokumen</p>
                    <button onclick="showInObject()" class="btn btn-primary">
                        <i class="fas fa-eye me-1"></i> Tampilkan PDF
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Alternative Links -->
        <div class="pdf-alternatives">
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Tidak bisa melihat PDF?</strong> Aplikasi ini menggunakan teknologi anti-IDM untuk memastikan preview berfungsi. Coba alternatif berikut:
                <div class="mt-2">
                    <button onclick="showInIframe()" class="btn btn-sm btn-outline-info me-2">
                        <i class="fas fa-window-restore me-1"></i> Mode Iframe
                    </button>
                    <a href="{{ route('surat.preview', $surat->id) }}" target="_blank" class="btn btn-sm btn-outline-primary me-2">
                        <i class="fas fa-external-link-alt me-1"></i> Buka di Tab Baru
                    </a>
                    <a href="{{ route('surat.download', $surat->id) }}" class="btn btn-sm btn-outline-warning">
                        <i class="fas fa-download me-1"></i> Download PDF
                    </a>
                </div>
                <small class="text-muted d-block mt-2">
                    <i class="fas fa-shield-alt me-1"></i> 
                    Sistem menggunakan multiple strategies: Data URI → POST Request → GET Request untuk bypass download managers.
                </small>
            </div>
        </div>
        
    @else
        <div class="no-file-preview">
            <div class="alert alert-warning text-center">
                <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                <h5>File PDF Tidak Ditemukan</h5>
                <p>File PDF untuk surat ini tidak dapat ditemukan atau telah dihapus.</p>
            </div>
        </div>
    @endif
</div>

<!-- Action Buttons -->
<div class="action-buttons mt-4">
    <a href="{{ route('surat.index') }}" class="btn btn-secondary">
        << Kembali
    </a>
    
    <a href="{{ route('surat.download', $surat->id) }}" class="btn btn-warning">
        Unduh
    </a>
    
    <button class="btn btn-info" onclick="printPDF()">
        <i class="fas fa-print me-1"></i> Print
    </button>
    
    <button class="btn btn-success" onclick="openFullscreen()">
        <i class="fas fa-expand me-1"></i> Fullscreen
    </button>
</div>

<style>
.surat-detail-header {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

.surat-detail-header div {
    margin-bottom: 8px;
    font-size: 14px;
}

.pdf-preview-container {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    overflow: hidden;
    margin-bottom: 20px;
}

.pdf-viewer {
    width: 100%;
    min-height: 700px;
}

.pdf-viewer iframe {
    display: block;
    width: 100%;
    height: 700px;
    border: none;
    border-radius: 8px;
}

.no-file-preview {
    padding: 60px 20px;
    text-align: center;
}

.action-buttons {
    display: flex;
    gap: 10px;
    justify-content: flex-start;
    flex-wrap: wrap;
}

.action-buttons .btn {
    padding: 10px 20px;
    font-weight: 500;
}

/* Fullscreen modal styles */
.fullscreen-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background-color: rgba(0,0,0,0.9);
    z-index: 9999;
    display: none;
}

.fullscreen-content {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.fullscreen-header {
    background-color: #333;
    color: white;
    padding: 10px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.fullscreen-pdf {
    flex: 1;
    width: 100%;
    height: calc(100vh - 60px);
    border: none;
}

.close-fullscreen {
    background: none;
    border: none;
    color: white;
    font-size: 24px;
    cursor: pointer;
}

@media (max-width: 768px) {
    .action-buttons {
        flex-direction: column;
    }
    
    .action-buttons .btn {
        width: 100%;
        text-align: center;
    }
    
    .pdf-viewer iframe {
        height: 500px;
    }
}
</style>

<!-- Fullscreen Modal -->
<div id="fullscreenModal" class="fullscreen-modal">
    <div class="fullscreen-content">
        <div class="fullscreen-header">
            <h5 class="mb-0">{{ $surat->judul }} - {{ $surat->nomor_surat }}</h5>
            <button class="close-fullscreen" onclick="closeFullscreen()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <iframe id="fullscreenPDF" 
                src=""
                class="fullscreen-pdf">
        </iframe>
    </div>
</div>
@endsection

@section('scripts')
<script>
// URLs untuk PDF
const pdfPreviewUrl = "{{ route('surat.preview', $surat->id) }}";
const pdfPreviewSecureUrl = "{{ route('surat.preview.secure', $surat->id) }}";
const pdfPreviewDataUrl = "{{ route('surat.preview.data', $surat->id) }}";
const pdfDownloadUrl = "{{ route('surat.download', $surat->id) }}";
const csrfToken = "{{ csrf_token() }}";

// Fungsi untuk menampilkan PDF menggunakan multiple strategies untuk bypass IDM
function showInObject() {
    const container = document.getElementById('pdf-container');
    const loadingIndicator = document.getElementById('loading-indicator');
    
    // Show loading
    loadingIndicator.style.display = 'block';
    container.innerHTML = '';
    
    console.log('Starting PDF preview with anti-IDM strategies...');
    
    // Strategy 1: Try Data URI (paling susah di-intercept IDM)
    console.log('Trying Data URI strategy...');
    tryDataUriRequest()
        .then(success => {
            if (success) {
                loadingIndicator.style.display = 'none';
                console.log('✅ Data URI strategy successful!');
                return;
            }
            throw new Error('Data URI strategy failed');
        })
        .catch(() => {
            console.log('❌ Data URI failed, trying GET with headers...');
            // Strategy 2: Try GET request with special headers (anti-IDM)
            tryGetRequestWithHeaders()
                .then(blob => {
                    if (blob) {
                        createObjectFromBlob(blob, container);
                        loadingIndicator.style.display = 'none';
                        console.log('✅ GET with headers strategy successful!');
                        return;
                    }
                    throw new Error('GET with headers failed');
                })
                .catch(() => {
                    console.log('❌ GET with headers failed, trying simple GET...');
                    // Strategy 3: Fallback to simple GET request
                    trySimpleGetRequest()
                        .then(blob => {
                            if (blob) {
                                createObjectFromBlob(blob, container);
                                loadingIndicator.style.display = 'none';
                                console.log('✅ Simple GET strategy successful!');
                                return;
                            }
                            throw new Error('Simple GET failed');
                        })
                        .catch(() => {
                            console.log('❌ All strategies failed, showing error...');
                            showError();
                        });
                });
        });
}

// Strategy 1: Data URI (paling anti-IDM)
function tryDataUriRequest() {
    return fetch(pdfPreviewDataUrl, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.dataUri) {
            createObjectFromDataUri(data.dataUri, document.getElementById('pdf-container'));
            return true;
        }
        return false;
    })
    .catch(error => {
        console.error('Data URI request error:', error);
        return false;
    });
}

// Strategy 2: GET request dengan headers anti-IDM
function tryGetRequestWithHeaders() {
    return fetch(pdfPreviewUrl, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Cache-Control': 'no-cache, no-store, must-revalidate',
            'Pragma': 'no-cache',
            'Expires': '0',
            'Accept': 'application/pdf',
            'User-Agent': 'Mozilla/5.0 (Internal PDF Viewer)',
        },
        credentials: 'same-origin'
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.blob();
    })
    .catch(error => {
        console.error('GET with headers request error:', error);
        return null;
    });
}

// Strategy 3: Simple GET request fallback
function trySimpleGetRequest() {
    return fetch(pdfPreviewUrl)
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.blob();
    })
    .catch(error => {
        console.error('Simple GET request error:', error);
        return null;
    });
}

// Create object element from data URI
function createObjectFromDataUri(dataUri, container) {
    // Create object element
    const objectElement = document.createElement('object');
    objectElement.setAttribute('data', dataUri);
    objectElement.setAttribute('type', 'application/pdf');
    objectElement.setAttribute('width', '100%');
    objectElement.setAttribute('height', '600px');
    objectElement.style.borderRadius = '4px';
    
    // Fallback content
    objectElement.innerHTML = `
        <div class="text-center py-5">
            <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
            <h6>Browser Tidak Mendukung Preview PDF</h6>
            <p class="text-muted">Silakan gunakan alternatif di bawah:</p>
            <div class="mt-3">
                <a href="${pdfPreviewUrl}" target="_blank" class="btn btn-primary me-2">
                    <i class="fas fa-external-link-alt me-1"></i> Buka di Tab Baru
                </a>
                <a href="${pdfDownloadUrl}" class="btn btn-warning">
                    <i class="fas fa-download me-1"></i> Download PDF
                </a>
            </div>
        </div>
    `;
    
    objectElement.onload = function() {
        console.log('PDF loaded successfully via Data URI');
    };
    
    container.innerHTML = '';
    container.appendChild(objectElement);
}

// Create object element from blob
function createObjectFromBlob(blob, container) {
    // Create object URL dari blob
    const objectUrl = URL.createObjectURL(blob);
    
    // Create object element
    const objectElement = document.createElement('object');
    objectElement.setAttribute('data', objectUrl);
    objectElement.setAttribute('type', 'application/pdf');
    objectElement.setAttribute('width', '100%');
    objectElement.setAttribute('height', '600px');
    objectElement.style.borderRadius = '4px';
    
    // Fallback content untuk browser yang tidak support
    objectElement.innerHTML = `
        <div class="text-center py-5">
            <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
            <h6>Browser Tidak Mendukung Preview PDF</h6>
            <p class="text-muted">Silakan gunakan alternatif di bawah:</p>
            <div class="mt-3">
                <a href="${pdfPreviewUrl}" target="_blank" class="btn btn-primary me-2">
                    <i class="fas fa-external-link-alt me-1"></i> Buka di Tab Baru
                </a>
                <a href="${pdfDownloadUrl}" class="btn btn-warning">
                    <i class="fas fa-download me-1"></i> Download PDF
                </a>
            </div>
        </div>
    `;
    
    // Event listener untuk cleanup object URL setelah load
    objectElement.onload = function() {
        console.log('PDF loaded successfully via blob URL');
        // Cleanup object URL setelah beberapa detik untuk menghemat memory
        setTimeout(() => {
            URL.revokeObjectURL(objectUrl);
        }, 5000);
    };
    
    // Replace container content dengan object element
    container.innerHTML = '';
    container.appendChild(objectElement);
}

function showInIframe() {
    // Fallback method untuk iframe
    const container = document.getElementById('pdf-container');
    const loadingIndicator = document.getElementById('loading-indicator');
    
    // Show loading
    loadingIndicator.style.display = 'block';
    container.innerHTML = '';
    
    // Create iframe
    setTimeout(() => {
        container.innerHTML = `
            <iframe src="${pdfPreviewUrl}" 
                    width="100%" 
                    height="600px" 
                    style="border: none; border-radius: 4px;"
                    onload="hideLoading()"
                    onerror="showError()">
                <div class="text-center py-5">
                    <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                    <h6>Preview tidak tersedia</h6>
                    <p>Browser tidak mendukung preview PDF.</p>
                    <a href="${pdfPreviewUrl}" target="_blank" class="btn btn-primary">
                        Buka di Tab Baru
                    </a>
                </div>
            </iframe>
        `;
        loadingIndicator.style.display = 'none';
    }, 500);
}

function hideLoading() {
    document.getElementById('loading-indicator').style.display = 'none';
}

function showError() {
    const container = document.getElementById('pdf-container');
    container.innerHTML = `
        <div class="text-center py-5">
            <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
            <h6>Preview Tidak Dapat Dimuat</h6>
            <p class="text-muted">Terjadi masalah saat memuat PDF. Silakan gunakan alternatif di bawah:</p>
            <div class="mt-3">
                <a href="${pdfPreviewUrl}" target="_blank" class="btn btn-primary me-2">
                    <i class="fas fa-external-link-alt me-1"></i> Buka di Tab Baru
                </a>
                <a href="${pdfDownloadUrl}" class="btn btn-warning">
                    <i class="fas fa-download me-1"></i> Download PDF
                </a>
            </div>
        </div>
    `;
    hideLoading();
}

function openInNewTab() {
    window.open(pdfPreviewUrl, '_blank');
}

function printPDF() {
    @if($surat->file_path && file_exists(storage_path('app/public/' . $surat->file_path)))
        window.open(pdfPreviewUrl, '_blank');
    @else
        Swal.fire({
            title: 'File Tidak Ditemukan',
            text: 'File PDF tidak dapat ditemukan untuk dicetak.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    @endif
}

function openFullscreen() {
    @if($surat->file_path && file_exists(storage_path('app/public/' . $surat->file_path)))
        document.getElementById('fullscreenModal').style.display = 'block';
        document.body.style.overflow = 'hidden';
        
        // Load PDF in fullscreen
        const fullscreenPDF = document.getElementById('fullscreenPDF');
        fullscreenPDF.src = pdfPreviewUrl;
    @else
        Swal.fire({
            title: 'File Tidak Ditemukan',
            text: 'File PDF tidak dapat ditampilkan dalam mode fullscreen.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    @endif
}

function closeFullscreen() {
    document.getElementById('fullscreenModal').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Close fullscreen with ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeFullscreen();
    }
});

// Test PDF accessibility on page load
document.addEventListener('DOMContentLoaded', function() {
    console.log('PDF Preview URL:', pdfPreviewUrl);
    
    // Test if preview URL is accessible
    fetch(pdfPreviewUrl, { method: 'HEAD' })
        .then(response => {
            if (response.ok) {
                console.log('PDF preview URL is accessible');
            } else {
                console.log('PDF preview URL returned:', response.status);
            }
        })
        .catch(error => {
            console.log('Error accessing PDF preview:', error);
        });
});
</script>
@endsection