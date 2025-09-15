@extends('layouts.app')

@section('title', 'Kategori Surat >> Edit')

@section('content')
<div class="page-title">Kategori Surat >> Edit</div>

<div class="content-header">
    <p class="mb-4">Tambahkan atau edit data kategori. Jika sudah selesai, jangan lupa untuk mengklik tombol "Simpan"</p>
</div>

<div class="form-container">
    <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <!-- ID Auto Increment -->
        <div class="form-group">
            <label for="id_display" class="form-label">ID (Auto Increment)</label>
            <input type="text" 
                   class="form-control" 
                   id="id_display" 
                   value="{{ $kategori->id }}"
                   readonly
                   style="background-color: #f8f9fa;">
        </div>

        <!-- Nama Kategori -->
        <div class="form-group">
            <label for="nama_kategori" class="form-label required">Nama Kategori</label>
            <input type="text" 
                   class="form-control @error('nama_kategori') is-invalid @enderror" 
                   id="nama_kategori" 
                   name="nama_kategori" 
                   value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                   placeholder="Masukkan nama kategori"
                   maxlength="100"
                   required>
            @error('nama_kategori')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Judul (Deskripsi) -->
        <div class="form-group">
            <label for="deskripsi" class="form-label">Judul</label>
            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                      id="deskripsi" 
                      name="deskripsi" 
                      rows="5"
                      placeholder="Kategori ini digunakan untuk surat yang sifatnya berupa pengumuman atau menginformasikan suatu perihal."
                      maxlength="500">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
            @error('deskripsi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Action Buttons -->
        <div class="form-actions">
            <a href="{{ route('kategori.index') }}" class="btn btn-secondary">
                << Kembali
            </a>
            <button type="submit" class="btn btn-primary">
                Simpan
            </button>
        </div>
    </form>
</div>

<!-- Delete Section -->
<div class="danger-zone">
    <h6 class="text-danger mb-3">
        <i class="fas fa-exclamation-triangle me-2"></i>Zona Berbahaya
    </h6>
    
    @if($kategori->surats()->count() > 0)
        <div class="alert alert-warning">
            <i class="fas fa-info-circle me-2"></i>
            <strong>Kategori tidak dapat dihapus</strong><br>
            Kategori ini masih memiliki {{ $kategori->surats()->count() }} surat terkait. 
            Hapus atau pindahkan surat tersebut terlebih dahulu sebelum menghapus kategori.
        </div>
    @else
        <p class="text-muted mb-3">
            Menghapus kategori akan menghilangkannya secara permanen. Tindakan ini tidak dapat dibatalkan.
        </p>
        
        <form action="{{ route('kategori.destroy', $kategori->id) }}" 
              method="POST" 
              onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori \'{{ $kategori->nama_kategori }}\'? Tindakan ini tidak dapat dibatalkan.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-trash me-1"></i> Hapus Kategori
            </button>
        </form>
    @endif
</div>

<!-- Error Messages -->
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<style>
.page-title {
    font-size: 28px;
    font-weight: bold;
    margin-bottom: 30px;
}

.form-container {
    background-color: white;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    max-width: 600px;
    margin-bottom: 30px;
}

.current-info {
    background-color: #f8f9fa;
    padding: 15px;
    border-radius: 6px;
    margin-bottom: 25px;
    border-left: 4px solid #007bff;
}

.current-info h6 {
    margin-bottom: 5px;
    color: #007bff;
}

.form-group {
    margin-bottom: 25px;
}

.form-label {
    font-weight: 600;
    margin-bottom: 8px;
    color: #333;
    display: block;
}

.form-label.required::after {
    content: ' *';
    color: #dc3545;
}

.form-control {
    border: 2px solid #ddd;
    border-radius: 6px;
    padding: 12px 15px;
    font-size: 14px;
    transition: border-color 0.3s ease;
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}

.form-control.is-invalid {
    border-color: #dc3545;
}

.invalid-feedback {
    font-size: 12px;
    margin-top: 5px;
}

.form-text {
    font-size: 12px;
    color: #6c757d;
    margin-top: 5px;
    display: block;
}

.form-actions {
    display: flex;
    gap: 15px;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #eee;
}

.form-actions .btn {
    padding: 12px 24px;
    font-weight: 500;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.form-actions .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.danger-zone {
    background-color: white;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    border-left: 4px solid #dc3545;
    max-width: 600px;
}

.danger-zone h6 {
    font-size: 16px;
    font-weight: 600;
}

.danger-zone .btn-danger {
    padding: 10px 20px;
    font-weight: 500;
}

@media (max-width: 768px) {
    .form-container, .danger-zone {
        padding: 20px;
        margin: 0 10px 20px 10px;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .form-actions .btn {
        width: 100%;
        text-align: center;
    }
}
</style>

<script>
// Character counter for textarea and input
document.addEventListener('DOMContentLoaded', function() {
    const deskripsiField = document.getElementById('deskripsi');
    const namaKategoriField = document.getElementById('nama_kategori');
    
    // Add character counter for deskripsi
    if (deskripsiField) {
        const maxLength = 500;
        const counter = document.createElement('small');
        counter.className = 'form-text text-end d-block';
        counter.style.marginTop = '5px';
        
        function updateCounter() {
            const remaining = maxLength - deskripsiField.value.length;
            counter.textContent = `${deskripsiField.value.length}/${maxLength} karakter`;
            counter.style.color = remaining < 50 ? '#dc3545' : '#6c757d';
        }
        
        deskripsiField.addEventListener('input', updateCounter);
        deskripsiField.parentNode.appendChild(counter);
        updateCounter();
    }
    
    // Add character counter for nama kategori
    if (namaKategoriField) {
        const maxLength = 100;
        const counter = document.createElement('small');
        counter.className = 'form-text text-end d-block';
        counter.style.marginTop = '5px';
        
        function updateCounter() {
            const remaining = maxLength - namaKategoriField.value.length;
            counter.textContent = `${namaKategoriField.value.length}/${maxLength} karakter`;
            counter.style.color = remaining < 20 ? '#dc3545' : '#6c757d';
        }
        
        namaKategoriField.addEventListener('input', updateCounter);
        namaKategoriField.parentNode.appendChild(counter);
        updateCounter();
    }
});
</script>
@endsection