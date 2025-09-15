@extends('layouts.app')

@section('title', 'Arsip Surat - Desa Karangduren')

@section('content')
<div class="page-title">Arsip Surat</div>
<div class="page-subtitle">
    Berikut ini adalah surat-surat yang telah terbit dan diarsipkan.<br>
    Klik "Lihat" pada kolom aksi untuk menampilkan surat.
</div>

<!-- Search Form -->
<form method="GET" action="{{ route('surat.index') }}" class="search-container">
    <label for="search" class="me-2">Cari surat:</label>
    <input type="text" 
           name="search" 
           id="search"
           class="search-input" 
           placeholder="search" 
           value="{{ request('search') }}">
    <button type="submit" class="btn-search">Cari</button>
</form>

<!-- Arsipkan Surat Button -->
<a href="{{ route('surat.create') }}" class="btn-arsipkan">
    Arsipkan Surat..
</a>

<!-- Table -->
<div class="table-container">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nomor Surat</th>
                <th>Kategori</th>
                <th>Judul</th>
                <th>Waktu Pengarsipan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($surats as $surat)
            <tr>
                <td>{{ $surat->nomor_surat }}</td>
                <td>{{ $surat->kategori->nama_kategori ?? 'N/A' }}</td>
                <td>{{ $surat->judul }}</td>
                <td>{{ $surat->waktu_pengarsipan->format('Y-m-d H:i') }}</td>
                <td>
                    <button onclick="confirmDelete('{{ route('surat.destroy', $surat->id) }}')" 
                            class="btn-action btn-hapus">
                        Hapus
                    </button>
                    <a href="{{ route('surat.download', $surat->id) }}" 
                       class="btn-action btn-unduh">
                        Unduh
                    </a>
                    <a href="{{ route('surat.show', $surat->id) }}" 
                       class="btn-action btn-lihat">
                        Lihat >>
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center py-4">
                    @if(request('search'))
                        <em>Tidak ada surat yang ditemukan dengan kata kunci "{{ request('search') }}"</em>
                    @else
                        <em>Belum ada surat yang diarsipkan</em>
                    @endif
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script>
function confirmDelete(deleteUrl) {
    Swal.fire({
        title: 'Konfirmasi Hapus',
        text: 'Apakah Anda yakin ingin menghapus surat ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Create form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = deleteUrl;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            
            form.appendChild(csrfToken);
            form.appendChild(methodField);
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>
@endsection