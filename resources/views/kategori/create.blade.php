@extends('layouts.app')

@section('title', 'Kategori Surat >> Tambah')

@section('content')
<div class="page-title">Kategori Surat >> Tambah</div>

<div class="content-header">
    <p class="mb-4">Tambahkan atau edit data kategori. Jika sudah selesai, jangan lupa untuk mengklik tombol "Simpan"</p>
</div>

<div class="form-container">
    <form action="{{ route('kategori.store') }}" method="POST">
        @csrf
        
        <!-- ID Auto Increment -->
        <div class="form-group">
            <label for="id_display" class="form-label">ID (Auto Increment)</label>
            <input type="text" 
                   class="form-control" 
                   id="id_display" 
                   value="Auto Generated"
                   readonly
                   style="background-color: #f8f9fa;">
            <small class="form-text">ID akan diisi otomatis oleh sistem</small>
        </div>

        <!-- Nama Kategori -->
        <div class="form-group">
            <label for="nama_kategori" class="form-label required">Nama Kategori</label>
            <input type="text" 
                   class="form-control @error('nama_kategori') is-invalid @enderror" 
                   id="nama_kategori" 
                   name="nama_kategori" 
                   value="{{ old('nama_kategori') }}"
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
                      maxlength="500">{{ old('deskripsi') }}</textarea>
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
    margin-bottom: 20px;
}

.content-header p {
    font-size: 14px;
    color: #666;
    margin-bottom: 20px;
}

.form-container {
    background-color: white;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    max-width: 800px;
}

.form-group {
    margin-bottom: 25px;
    display: flex;
    align-items: flex-start;
    gap: 20px;
}

.form-label {
    font-weight: 600;
    color: #333;
    min-width: 150px;
    padding-top: 8px;
    text-align: left;
}

.form-label.required::after {
    content: ' *';
    color: #dc3545;
}

.form-control {
    border: 2px solid #333;
    border-radius: 4px;
    padding: 8px 12px;
    font-size: 14px;
    flex: 1;
    min-height: 35px;
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: none;
    outline: none;
}

.form-control.is-invalid {
    border-color: #dc3545;
}

.form-control[readonly] {
    background-color: #f8f9fa;
    color: #6c757d;
}

textarea.form-control {
    min-height: 120px;
    resize: vertical;
}

.invalid-feedback {
    font-size: 12px;
    margin-top: 5px;
    color: #dc3545;
}

.form-text {
    font-size: 12px;
    color: #6c757d;
    margin-top: 5px;
}

.form-actions {
    display: flex;
    gap: 15px;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #eee;
}

.form-actions .btn {
    padding: 10px 20px;
    font-weight: 500;
    border-radius: 4px;
    border: 2px solid #333;
    background-color: white;
    color: #333;
    text-decoration: none;
    display: inline-block;
}

.form-actions .btn:hover {
    background-color: #f8f9fa;
}

.form-actions .btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
}

.form-actions .btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
}

@media (max-width: 768px) {
    .form-container {
        padding: 20px;
        margin: 0 10px;
    }
    
    .form-group {
        flex-direction: column;
        gap: 8px;
    }
    
    .form-label {
        min-width: auto;
        padding-top: 0;
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
// Character counter for textarea
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