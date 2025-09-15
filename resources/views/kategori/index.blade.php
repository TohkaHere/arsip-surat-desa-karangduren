@extends('layouts.app')

@section('title', 'Kategori Surat')

@section('content')
<div class="page-title">Kategori Surat</div>

<div class="content-header">
    <p class="mb-4">Berikut ini adalah kategori yang bisa digunakan untuk melabeli surat.</p>
    <p class="mb-4">Klik "Tambah" pada kolom aksi untuk menambahkan kategori baru.</p>
</div>

<!-- Search Section -->
<div class="search-section">
    <form method="GET" action="{{ route('kategori.index') }}" class="d-flex gap-2">
        <div class="search-wrapper flex-grow-1">
            <label for="search">Cari kategori:</label>
            <input type="text" 
                   name="search" 
                   id="search"
                   class="form-control" 
                   placeholder="search" 
                   value="{{ request('search') }}">
        </div>
        <div class="search-button">
            <button type="submit" class="btn btn-primary">Cari!</button>
        </div>
    </form>
</div>

<!-- Results Info -->
@if(request('search'))
<div class="results-info">
    <small class="text-muted">
        Menampilkan hasil pencarian untuk: <strong>"{{ request('search') }}"</strong>
        @if($kategoris->total() > 0)
            - {{ $kategoris->total() }} kategori ditemukan
        @else
            - Tidak ada kategori ditemukan
        @endif
        <a href="{{ route('kategori.index') }}" class="ms-2">Hapus pencarian</a>
    </small>
</div>
@endif

<!-- Success/Error Messages -->
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- Kategori Table -->
<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th style="width: 80px;">ID Kategori</th>
                <th>Nama Kategori</th>
                <th>Keterangan</th>
                <th style="width: 200px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kategoris as $kategori)
            <tr>
                <td>{{ $kategori->id }}</td>
                <td>
                    <strong>{{ $kategori->nama_kategori }}</strong>
                    @if($kategori->surats_count > 0)
                        <br><small class="text-muted">{{ $kategori->surats_count }} surat</small>
                    @endif
                </td>
                <td>
                    {{ $kategori->deskripsi ?: '-' }}
                </td>
                <td>
                    <div class="action-buttons">
                        <!-- Edit Button -->
                        <a href="{{ route('kategori.edit', $kategori->id) }}" 
                           class="btn btn-primary btn-sm">
                            Edit
                        </a>
                        
                        <!-- Delete Button -->
                        <form action="{{ route('kategori.destroy', $kategori->id) }}" 
                              method="POST" 
                              class="d-inline"
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori \'{{ $kategori->nama_kategori }}\'?{{ $kategori->surats_count > 0 ? ' Kategori ini memiliki ' . $kategori->surats_count . ' surat terkait.' : '' }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="btn btn-danger btn-sm"
                                    {{ $kategori->surats_count > 0 ? 'title="Tidak dapat dihapus karena masih memiliki surat terkait"' : '' }}>
                                Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center py-4">
                    @if(request('search'))
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h5>Tidak Ada Kategori Ditemukan</h5>
                        <p class="text-muted">Tidak ada kategori yang sesuai dengan pencarian "{{ request('search') }}"</p>
                        <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Lihat Semua Kategori</a>
                    @else
                        <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                        <h5>Belum Ada Kategori</h5>
                        <p class="text-muted">Mulai dengan menambahkan kategori pertama Anda</p>
                        <a href="{{ route('kategori.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i> Tambah Kategori Pertama
                        </a>
                    @endif
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Add Button -->
@if($kategoris->count() > 0)
<div class="add-button-container">
    <a href="{{ route('kategori.create') }}" class="btn btn-success">
        <i class="fas fa-plus me-1"></i> Tambah Kategori Baru...
    </a>
</div>
@endif

<!-- Pagination -->
@if($kategoris->hasPages())
<div class="pagination-container">
    {{ $kategoris->appends(request()->query())->links() }}
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
    margin-bottom: 8px;
}

.search-section {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

.search-wrapper label {
    font-size: 14px;
    font-weight: 500;
    margin-bottom: 8px;
    display: block;
}

.search-wrapper input {
    border: 2px solid #ddd;
    border-radius: 6px;
    padding: 10px 12px;
}

.search-wrapper input:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}

.search-button {
    display: flex;
    align-items: end;
}

.search-button .btn {
    padding: 10px 20px;
}

.results-info {
    margin-bottom: 20px;
    padding: 10px 15px;
    background-color: #f8f9fa;
    border-radius: 6px;
}

.table-container {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    overflow: hidden;
    margin-bottom: 20px;
}

.table {
    margin-bottom: 0;
}

.table thead th {
    background-color: #f8f9fa;
    font-weight: 600;
    border-bottom: 2px solid #dee2e6;
    padding: 15px;
}

.table tbody td {
    padding: 15px;
    vertical-align: middle;
}

.table tbody tr:hover {
    background-color: #f8f9fa;
}

.action-buttons {
    display: flex;
    gap: 8px;
}

.action-buttons .btn {
    padding: 6px 12px;
    font-size: 12px;
}

.add-button-container {
    text-align: left;
    margin-bottom: 20px;
}

.add-button-container .btn {
    padding: 12px 24px;
    font-weight: 500;
}

.pagination-container {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

@media (max-width: 768px) {
    .search-section .d-flex {
        flex-direction: column;
    }
    
    .search-button {
        margin-top: 10px;
        align-items: start;
    }
    
    .search-button .btn {
        width: 100%;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .action-buttons .btn {
        width: 100%;
        text-align: center;
    }
}
</style>
@endsection