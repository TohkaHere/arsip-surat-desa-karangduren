@extends('layouts.app')

@section('title', 'Arsip Surat - Unggah')

@section('content')
<div class="page-title">Arsip Surat >> Unggah</div>
<div class="page-subtitle">
    Unggah surat yang telah terbit pada form ini untuk diarsipkan.<br>
    Catatan:
    <ul class="mb-0 mt-2">
        <li>Gunakan file berformat PDF</li>
    </ul>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="bg-white p-4 rounded shadow-sm">
            <form method="POST" action="{{ route('surat.store') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-3 row">
                    <label for="nomor_surat" class="col-sm-3 col-form-label">Nomor Surat</label>
                    <div class="col-sm-9">
                        <input type="text" 
                               class="form-control @error('nomor_surat') is-invalid @enderror" 
                               id="nomor_surat" 
                               name="nomor_surat" 
                               value="{{ old('nomor_surat') }}" 
                               required>
                        @error('nomor_surat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-3 row">
                    <label for="kategori_id" class="col-sm-3 col-form-label">Kategori</label>
                    <div class="col-sm-9">
                        <select class="form-select @error('kategori_id') is-invalid @enderror" 
                                id="kategori_id" 
                                name="kategori_id" 
                                required>
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-3 row">
                    <label for="judul" class="col-sm-3 col-form-label">Judul</label>
                    <div class="col-sm-9">
                        <input type="text" 
                               class="form-control @error('judul') is-invalid @enderror" 
                               id="judul" 
                               name="judul" 
                               value="{{ old('judul') }}" 
                               required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-4 row">
                    <label for="file" class="col-sm-3 col-form-label">File Surat (PDF)</label>
                    <div class="col-sm-6">
                        <input type="file" 
                               class="form-control @error('file') is-invalid @enderror" 
                               id="file" 
                               name="file" 
                               accept=".pdf"
                               required>
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-sm-3">
                        <button type="button" class="btn btn-outline-secondary" onclick="document.getElementById('file').click()">
                            Browse File...
                        </button>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-9 offset-sm-3">
                        <div class="d-flex gap-2">
                            <a href="{{ route('surat.index') }}" class="btn btn-secondary">
                                << Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection