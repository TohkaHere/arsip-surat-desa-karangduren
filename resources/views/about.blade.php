@extends('layouts.app')

@section('title', 'About')

@section('content')
<div class="page-title">About</div>

<div class="about-container">
    <div class="about-content">
        <!-- Profile Photo -->
        <div class="profile-photo">
            <img src="{{ asset('images/pasfoto.jpg') }}" 
                 alt="Profile Photo" 
                 class="profile-image"
                 onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgdmlld0JveD0iMCAwIDIwMCAyMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIyMDAiIGhlaWdodD0iMjAwIiBmaWxsPSIjRjhGOUZBIiBzdHJva2U9IiNEMUQ1REIiIHN0cm9rZS13aWR0aD0iMiIvPgo8Y2lyY2xlIGN4PSIxMDAiIGN5PSI4NSIgcj0iMzUiIGZpbGw9IiM2QjczODAiLz4KPHBhdGggZD0iTTUwIDEzMEM1MCAxMTAgNzMuMzMzMyA5NSAxMDAgOTVDMTI2LjY2NyA5NSAxNTAgMTEwIDE1MCAxMzBWMTcwSDUwVjEzMFoiIGZpbGw9IiM2QjczODAiLz4KPC9zdmc+'">
        </div>

        <!-- Application Info -->
        <div class="app-info">
            <h5 class="mb-3">Aplikasi ini dibuat oleh:</h5>
            
            <div class="info-item">
                <strong>Nama</strong>
                <span class="separator">:</span>
                <span class="info-value">Raihan Zacky Surya Dewanta</span>
            </div>
            
            <div class="info-item">
                <strong>Prodi</strong>
                <span class="separator">:</span>
                <span class="info-value">D3-MI PSDKU Kediri</span>
            </div>
            
            <div class="info-item">
                <strong>NIM</strong>
                <span class="separator">:</span>
                <span class="info-value">2331730147</span>
            </div>
            
            <div class="info-item">
                <strong>Tanggal</strong>
                <span class="separator">:</span>
                <span class="info-value">15 September 2025</span>
            </div>
        </div>
    </div>
</div>

<style>
.about-container {
    background-color: white;
    border-radius: 8px;
    padding: 30px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
}

.about-content {
    display: flex;
    align-items: flex-start;
    gap: 30px;
    max-width: 600px;
}

.profile-photo {
    flex-shrink: 0;
}

.profile-image {
    width: 150px;
    height: 150px;
    border: 3px solid #000;
    border-radius: 8px;
    object-fit: cover;
    background-color: #f8f9fa;
}

.app-info {
    flex: 1;
}

.app-info h5 {
    color: #333;
    font-weight: 600;
    margin-bottom: 20px;
}

.info-item {
    display: flex;
    margin-bottom: 8px;
    font-size: 14px;
    line-height: 1.5;
}

.info-item strong {
    min-width: 70px;
    color: #333;
    font-weight: 600;
}

.separator {
    margin: 0 10px;
    color: #666;
}

.info-value {
    color: #555;
    flex: 1;
}

/* Responsive */
@media (max-width: 768px) {
    .about-content {
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 20px;
    }
    
    .profile-image {
        width: 120px;
        height: 120px;
    }
    
    .info-item {
        justify-content: center;
    }
    
    .info-item strong {
        min-width: 60px;
    }
}
</style>
@endsection